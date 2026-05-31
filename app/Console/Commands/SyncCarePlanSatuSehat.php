<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\CarePlanBuilder;

/**
 * SyncCarePlanSatuSehat — Bulk sync CarePlan untuk registrasi yang
 * status_dokter = 'Sudah Diperiksa' dan belum ter-sync.
 *
 * Dipakai sebagai:
 *   1. Scheduler safety net (setiap 15 menit via Kernel.php)
 *   2. Manual sync dari UI (via CarePlanSyncCtrl::runSync)
 *
 * Juga menangkap registrasi yang sebelumnya stuck di 'waiting_encounter'
 * atau 'waiting_patient' setelah prasyaratnya terpenuhi.
 */
class SyncCarePlanSatuSehat extends Command
{
    protected $signature = 'satusehat:sync-careplan
                            {--batch=30  : Jumlah CarePlan per batch}
                            {--delay=200 : Delay antar request dalam milidetik}';

    protected $description = 'Bulk sync CarePlan ke SatuSehat untuk registrasi yang sudah diperiksa dokter';

    public function handle(): int
    {
        $batchSize = (int)$this->option('batch');
        $delayMs   = (int)$this->option('delay');

        $this->info('[SatuSehat CarePlan Sync] Mulai — batch=' . $batchSize);

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
                    'registrasi.tanggal',
                    'registrasi.waktu',
                    'registrasi.jenis',
                    'registrasi.status_dokter',
                    'registrasi.satusehat_encounter_id',
                    'pasien.id_satu_sehat as patient_ihs_id',
                    'pengguna.satusehat_ihs_id as practitioner_ihs_id',
                ])
                ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
                ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
                ->where('registrasi.delete_soft', 1)
                ->where('registrasi.status_dokter', 'Sudah Diperiksa')
                ->whereNull('registrasi.satusehat_careplan_id')
                ->where(function ($q) {
                    $q->whereNull('registrasi.satusehat_careplan_status')
                      ->orWhereIn('registrasi.satusehat_careplan_status',
                          ['failed', 'waiting_encounter', 'waiting_patient']);
                })
                ->orderBy('registrasi.id')
                ->offset($page * $batchSize)
                ->limit($batchSize)
                ->get();

            if ($registrations->isEmpty()) break;

            $this->line('→ Memproses batch ' . ($page + 1) . ' (' . $registrations->count() . ' careplan)');

            foreach ($registrations as $reg) {
                if (empty($reg->patient_ihs_id)) {
                    DB::table('registrasi')->where('id', $reg->id)
                        ->update(['satusehat_careplan_status' => 'waiting_patient']);
                    $notEligible++;
                    $this->line("  ⊘ [{$reg->nama_pasien}] No.{$reg->nomor} — pasien belum sync");
                    continue;
                }

                if (empty($reg->satusehat_encounter_id)) {
                    DB::table('registrasi')->where('id', $reg->id)
                        ->update(['satusehat_careplan_status' => 'waiting_encounter']);
                    $notEligible++;
                    $this->line("  ⊘ [{$reg->nama_pasien}] No.{$reg->nomor} — encounter belum sync");
                    continue;
                }

                try {
                    $payload    = CarePlanBuilder::build($reg, $orgId);
                    $result     = $bridge->postJson('CarePlan', $payload);
                    $careplanId = $result['id'] ?? null;

                    if ($careplanId) {
                        DB::table('registrasi')->where('id', $reg->id)->update([
                            'satusehat_careplan_id'       => $careplanId,
                            'satusehat_careplan_status'   => 'synced',
                            'satusehat_careplan_synced_at' => now(),
                        ]);
                        $synced++;
                        $this->line("  ✓ [{$reg->nama_pasien}] No.{$reg->nomor} → {$careplanId}");
                    } else {
                        $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
                        DB::table('registrasi')->where('id', $reg->id)
                            ->update(['satusehat_careplan_status' => 'failed']);
                        $failed++;
                        $this->warn("  ✗ [{$reg->nama_pasien}] No.{$reg->nomor} — {$errMsg}");
                    }
                } catch (\Throwable $e) {
                    DB::table('registrasi')->where('id', $reg->id)
                        ->update(['satusehat_careplan_status' => 'failed']);
                    $failed++;
                    $this->warn("  ✗ [{$reg->nama_pasien}] No.{$reg->nomor} Error: " . $e->getMessage());
                }

                if ($delayMs > 0) usleep($delayMs * 1000);
            }

            $page++;

        } while ($registrations->count() === $batchSize);

        $this->info(
            '[SatuSehat CarePlan Sync] Selesai — ' .
            "Berhasil: {$synced} | Dilewati: {$notEligible} | Gagal: {$failed}"
        );

        return self::SUCCESS;
    }
}
