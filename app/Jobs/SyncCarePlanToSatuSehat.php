<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\CarePlanBuilder;

/**
 * SyncCarePlanToSatuSehat
 *
 * Job ini dipanggil secara otomatis oleh:
 *   1. ListenCarePlanSatuSehat daemon (pg_notify) — saat status_dokter
 *      berubah menjadi 'Sudah Diperiksa' pada tabel registrasi.
 *   2. CarePlanSyncCtrl::syncOne() — sync manual dari UI.
 *
 * Guard (idempoten):
 *   - Sudah punya satusehat_careplan_id & status 'synced' → skip
 *   - Pasien belum punya id_satu_sehat → tandai 'waiting_patient'
 *   - Registrasi belum punya satusehat_encounter_id → tandai 'waiting_encounter'
 *
 * Flow:
 *   1. Fetch registrasi + join pasien & pengguna
 *   2. Guard checks
 *   3. Build payload via CarePlanBuilder::build()
 *   4. POST ke SatuSehat /CarePlan
 *   5. Berhasil → simpan careplan_id, status='synced'
 *   6. Gagal    → status='failed', throw untuk retry
 */
class SyncCarePlanToSatuSehat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int   $tries   = 3;
    public array $backoff = [30, 120, 300];
    public int   $timeout = 60;

    public function __construct(public string $registrasiUuid) {}

    public function handle(): void
    {
        // ── 1. Fetch registrasi + join pasien & pengguna ─────────────────────
        $reg = DB::table('registrasi')
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
                'registrasi.satusehat_careplan_id',
                'registrasi.satusehat_careplan_status',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
                'pengguna.nama as nama_pengguna',
            ])
            ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
            ->where('registrasi.uuid', $this->registrasiUuid)
            ->where('registrasi.delete_soft', 1)
            ->first();

        if (!$reg) {
            return; // registrasi sudah dihapus soft-delete
        }

        // ── 2. Guard: sudah ter-sync ─────────────────────────────────────────
        if (!empty($reg->satusehat_careplan_id) && $reg->satusehat_careplan_status === 'synced') {
            return;
        }

        // ── 3. Guard: pasien belum punya IHS Number ──────────────────────────
        if (empty($reg->patient_ihs_id)) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_careplan_status' => 'waiting_patient',
            ]);
            return;
        }

        // ── 4. Guard: encounter belum di-sync ────────────────────────────────
        if (empty($reg->satusehat_encounter_id)) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_careplan_status' => 'waiting_encounter',
            ]);
            return;
        }

        // ── 5. Inisialisasi bridge SatuSehat ─────────────────────────────────
        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'careplan_auto_sync';
            $orgId  = (new ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_careplan_status' => 'failed',
            ]);
            throw $e;
        }

        // ── 6. POST CarePlan ke SatuSehat ────────────────────────────────────
        try {
            $payload    = CarePlanBuilder::build($reg, $orgId);
            $result     = $bridge->postJson('CarePlan', $payload);
            $careplanId = $result['id'] ?? null;

            if ($careplanId) {
                DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                    'satusehat_careplan_id'        => $careplanId,
                    'satusehat_careplan_status'     => 'synced',
                    'satusehat_careplan_synced_at'  => now(),
                ]);
                return;
            }

            // ── 7. Error response dari SatuSehat ─────────────────────────────
            $issue  = $result['issue'][0] ?? [];
            $errMsg = $issue['diagnostics'] ?? json_encode($result);

            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_careplan_status' => 'failed',
            ]);
            throw new \RuntimeException('[SyncCarePlanToSatuSehat] Gagal: ' . $errMsg);

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_careplan_status' => 'failed',
            ]);
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
            'satusehat_careplan_status' => 'failed',
        ]);
    }
}
