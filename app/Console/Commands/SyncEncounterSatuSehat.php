<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\EncounterBuilder;

class SyncEncounterSatuSehat extends Command
{
    /**
     * Signature command — bisa dipanggil manual:
     *   php artisan satusehat:sync-encounter
     *   php artisan satusehat:sync-encounter --batch=20
     */
    protected $signature = 'satusehat:sync-encounter
                            {--batch=30 : Jumlah encounter per batch}
                            {--delay=300 : Delay antar request dalam milidetik}';

    protected $description = 'Kirim data Encounter (kunjungan) ke SatuSehat berdasarkan registrasi pending';

    public function handle(): int
    {
        $batchSize = (int) $this->option('batch');
        $delayMs   = (int) $this->option('delay');

        $this->info('[SatuSehat Encounter Sync] Mulai — batch=' . $batchSize);

        try {
            $bridge = new BridgeBase();
            $orgId  = (new ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            $this->error('Gagal inisialisasi token SatuSehat: ' . $e->getMessage());
            return self::FAILURE;
        }

        $synced      = 0;
        $notEligible = 0;
        $failed      = 0;
        $page        = 0;

        do {
            /**
             * Kandidat sync encounter:
             *   - delete_soft = 1 (aktif)
             *   - satusehat_encounter_status NULL atau 'failed' (pending/retry)
             *   - satusehat_encounter_id masih NULL (belum dapat IHS Encounter ID)
             *
             * NULL tidak tertangkap whereNotIn di PostgreSQL — gunakan where() eksplisit.
             */
            $registrations = DB::table('registrasi')
                ->select([
                    'registrasi.id',
                    'registrasi.uuid',
                    'registrasi.nomor',
                    'registrasi.nama_pasien',
                    'registrasi.pasien_uuid',
                    'registrasi.pengguna_uuid',
                    'registrasi.nama_dokter',
                    'registrasi.ruang_poliklinik',
                    'registrasi.satusehat_location_id',
                    'registrasi.tanggal',
                    'registrasi.waktu',
                    'registrasi.jenis',
                    'pasien.id_satu_sehat as patient_ihs_id',
                    'pengguna.satusehat_ihs_id as practitioner_ihs_id',
                ])
                ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
                ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
                ->where('registrasi.delete_soft', 1)
                ->whereNull('registrasi.satusehat_encounter_id')
                ->where(function ($q) {
                    $q->whereNull('registrasi.satusehat_encounter_status')
                      ->orWhere('registrasi.satusehat_encounter_status', 'failed');
                })
                ->orderBy('registrasi.id')
                ->offset($page * $batchSize)
                ->limit($batchSize)
                ->get();

            if ($registrations->isEmpty()) {
                break;
            }

            $this->line('→ Memproses batch ' . ($page + 1) . ' (' . $registrations->count() . ' encounter)');

            foreach ($registrations as $reg) {
                // Lewati jika pasien belum di-sync ke SatuSehat (akan dicoba lagi nanti)
                if (empty($reg->patient_ihs_id)) {
                    $notEligible++;
                    $this->line("  ⊘ [{$reg->nama_pasien}] No.{$reg->nomor} — pasien belum di-sync, dilewati");
                    continue;
                }

                try {
                    $payload = EncounterBuilder::build($reg, $orgId);
                    $result  = $bridge->postJson('Encounter', $payload);

                    $encounterId = $result['id'] ?? null;

                    if ($encounterId) {
                        DB::table('registrasi')->where('id', $reg->id)->update([
                            'satusehat_encounter_id'      => $encounterId,
                            'satusehat_encounter_status'  => 'synced',
                            'satusehat_encounter_synced_at' => now(),
                        ]);
                        $synced++;
                        $this->line("  ✓ [{$reg->nama_pasien}] No.{$reg->nomor} → {$encounterId}");
                    } else {
                        // API responded tapi tidak ada ID — kemungkinan validation error
                        $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
                        DB::table('registrasi')->where('id', $reg->id)->update([
                            'satusehat_encounter_status' => 'failed',
                        ]);
                        $failed++;
                        $this->warn("  ✗ [{$reg->nama_pasien}] No.{$reg->nomor} — {$errMsg}");
                    }
                } catch (\Throwable $e) {
                    DB::table('registrasi')->where('id', $reg->id)->update([
                        'satusehat_encounter_status' => 'failed',
                    ]);
                    $failed++;
                    $this->warn("  ✗ [{$reg->nama_pasien}] No.{$reg->nomor} Error: " . $e->getMessage());
                }

                if ($delayMs > 0) {
                    usleep($delayMs * 1000);
                }
            }

            $page++;

        } while ($registrations->count() === $batchSize);

        $this->info(
            '[SatuSehat Encounter Sync] Selesai — ' .
            "Berhasil: {$synced} | Dilewati (pasien belum sync): {$notEligible} | Gagal: {$failed}"
        );

        return self::SUCCESS;
    }

}
