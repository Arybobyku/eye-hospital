<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;
use App\Services\SatuSehat\Bridge\BridgeBase;

class SyncPatientSatuSehat extends Command
{
    /**
     * Signature command — bisa dipanggil manual:
     *   php artisan satusehat:sync-patient
     *   php artisan satusehat:sync-patient --batch=100
     */
    protected $signature = 'satusehat:sync-patient
                            {--batch=50 : Jumlah pasien per batch}
                            {--delay=300 : Delay antar request dalam milidetik}';

    protected $description = 'Sinkronisasi ID SatuSehat (IHS Number) untuk pasien berdasarkan NIK';

    /** Prefix NIK untuk FHIR identifier */
    private const NIK_SYSTEM = 'https://fhir.kemkes.go.id/id/nik';

    public function handle(): int
    {
        $batchSize = (int) $this->option('batch');
        $delayMs   = (int) $this->option('delay');

        $this->info('[SatuSehat Patient Sync] Mulai — batch=' . $batchSize);

        try {
            $bridge = new BridgeBase();
        } catch (\Throwable $e) {
            $this->error('Gagal inisialisasi token SatuSehat: ' . $e->getMessage());
            return self::FAILURE;
        }

        $synced    = 0;
        $notFound  = 0;
        $failed    = 0;
        $skipped   = 0;
        $page      = 0;

        do {
            /**
             * Kandidat sync:
             *   - no_identitas terisi (NIK)
             *   - id_satu_sehat masih null (belum punya IHS)
             *   - satusehat_sync_status bukan 'not_found' (skip permanen)
             *   - satusehat_sync_status bukan 'synced'   (sudah berhasil)
             */
            $patients = Pasien::where('delete_soft', 1)
                ->whereNotNull('no_identitas')
                ->where('no_identitas', '!=', '')
                ->whereNull('id_satu_sehat')
                ->where(function ($q) {
                    // NULL tidak tertangkap whereNotIn di PostgreSQL — harus eksplisit
                    $q->whereNull('satusehat_sync_status')
                      ->orWhere(function ($q2) {
                          $q2->whereNotNull('satusehat_sync_status')
                             ->whereNotIn('satusehat_sync_status', ['not_found', 'synced']);
                      });
                })
                ->orderBy('id')
                ->offset($page * $batchSize)
                ->limit($batchSize)
                ->get(['id', 'uuid', 'nama', 'no_identitas', 'jenis_identitas']);

            if ($patients->isEmpty()) {
                break;
            }

            $this->line('→ Memproses batch ' . ($page + 1) . ' (' . $patients->count() . ' pasien)');

            foreach ($patients as $pasien) {
                $nik = trim($pasien->no_identitas);

                // Lewati jika bukan NIK (16 digit angka) atau jenis_identitas bukan KTP/NIK
                if (!preg_match('/^\d{16}$/', $nik)) {
                    $skipped++;
                    DB::table('pasien')
                        ->where('id', $pasien->id)
                        ->update(['satusehat_sync_status' => 'not_found']);
                    continue;
                }

                try {
                    $endpoint = 'Patient?identifier=' . urlencode(self::NIK_SYSTEM . '|' . $nik);
                    $result   = $bridge->getJson($endpoint);

                    $total   = (int)($result['total'] ?? 0);
                    $entries = $result['entry'] ?? [];

                    if ($total > 0 && !empty($entries)) {
                        // Ambil IHS Number dari resource.id di entry pertama
                        $ihsId = $entries[0]['resource']['id'] ?? null;

                        if ($ihsId) {
                            DB::table('pasien')
                                ->where('id', $pasien->id)
                                ->update([
                                    'id_satu_sehat'          => $ihsId,
                                    'satusehat_sync_status'  => 'synced',
                                    'satusehat_synced_at'    => now(),
                                ]);
                            $synced++;
                            $this->line("  ✓ [{$pasien->nama}] NIK {$nik} → {$ihsId}");
                        } else {
                            // Entry ada tapi id kosong — tandai not_found
                            DB::table('pasien')
                                ->where('id', $pasien->id)
                                ->update(['satusehat_sync_status' => 'not_found']);
                            $notFound++;
                        }
                    } else {
                        // API mengembalikan 0 hasil → skip permanen
                        DB::table('pasien')
                            ->where('id', $pasien->id)
                            ->update(['satusehat_sync_status' => 'not_found']);
                        $notFound++;
                        $this->line("  ○ [{$pasien->nama}] NIK {$nik} tidak ditemukan di SatuSehat");
                    }
                } catch (\Throwable $e) {
                    // Error sementara — tandai failed agar retry berikutnya
                    DB::table('pasien')
                        ->where('id', $pasien->id)
                        ->update(['satusehat_sync_status' => 'failed']);
                    $failed++;
                    $this->warn("  ✗ [{$pasien->nama}] Error: " . $e->getMessage());
                }

                // Delay antar request agar tidak di-rate-limit
                if ($delayMs > 0) {
                    usleep($delayMs * 1000);
                }
            }

            $page++;

        } while ($patients->count() === $batchSize);

        $this->info(
            "[SatuSehat Patient Sync] Selesai — " .
            "Berhasil: {$synced} | Tidak Ditemukan: {$notFound} | Gagal: {$failed} | Dilewati: {$skipped}"
        );

        return self::SUCCESS;
    }
}
