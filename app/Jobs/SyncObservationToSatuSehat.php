<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\ObservationBuilder;

/**
 * SyncObservationToSatuSehat
 *
 * Job ini dipanggil oleh:
 *   1. ListenCpptSatuSehat daemon (pg_notify) — saat INSERT/UPDATE ke tabel cppt
 *   2. ObservationSyncCtrl::syncOne()         — sync manual dari UI
 *
 * Guard (idempoten):
 *   - asesmen IS NULL                        → tandai 'waiting_assessment', skip
 *   - Pasien belum punya id_satu_sehat       → tandai 'waiting_patient', skip
 *   - pengguna belum punya satusehat_ihs_id  → tetap lanjut (performer opsional)
 *   - Registrasi belum punya encounter_id    → tandai 'waiting_encounter', skip
 *   - Sudah punya observation_id & 'synced'  → skip (idempoten)
 *
 * Flow:
 *   1. Fetch cppt + join registrasi & pasien & pengguna
 *   2. Guard checks
 *   3. Build payload via ObservationBuilder::build()
 *   4. POST ke SatuSehat /Observation
 *   5. Berhasil → simpan observation_id, status='synced'
 *   6. Gagal    → status='failed', throw untuk retry
 */
class SyncObservationToSatuSehat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int   $tries   = 3;
    public array $backoff = [30, 120, 300];
    public int   $timeout = 60;

    public function __construct(public string $cpptUuid) {}

    public function handle(): void
    {
        // ── 1. Fetch cppt + join registrasi, pasien, pengguna ───────────────
        $cppt = DB::table('cppt')
            ->select([
                'cppt.id',
                'cppt.uuid',
                'cppt.registrasi_uuid',
                'cppt.pasien_uuid',
                'cppt.pengguna_uuid',
                'cppt.nama_pengguna',
                'cppt.nama_pasien',
                'cppt.nama_dokter',
                'cppt.subjek',
                'cppt.objek',
                'cppt.asesmen',
                'cppt.plan',
                'cppt.sebagai',
                'cppt.satusehat_observation_id',
                'cppt.satusehat_observation_status',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
                DB::raw("COALESCE(pengguna.nama, cppt.nama_pengguna) as nama_pengguna"),
            ])
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'cppt.pengguna_uuid')
            ->where('cppt.uuid', $this->cpptUuid)
            ->first();

        if (!$cppt) {
            return; // CPPT tidak ada (mungkin sudah dihapus)
        }

        // ── 2. Guard: sudah ter-sync ─────────────────────────────────────────
        if (!empty($cppt->satusehat_observation_id) && $cppt->satusehat_observation_status === 'synced') {
            return;
        }

        // ── 3. Guard: asesmen kosong ─────────────────────────────────────────
        if (empty(trim($cppt->asesmen ?? ''))) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'waiting_assessment',
            ]);
            return;
        }

        // ── 4. Fetch registrasi + pasien ─────────────────────────────────────
        $reg = DB::table('registrasi')
            ->select([
                'registrasi.uuid',
                'registrasi.tanggal',
                'registrasi.waktu',
                'registrasi.satusehat_encounter_id',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pasien.nama as nama_pasien_reg',
            ])
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.uuid', $cppt->registrasi_uuid)
            ->where('registrasi.delete_soft', 1)
            ->first();

        if (!$reg) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'failed',
            ]);
            return;
        }

        // ── 5. Guard: pasien belum punya IHS Number ──────────────────────────
        if (empty($reg->patient_ihs_id)) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'waiting_patient',
            ]);
            return;
        }

        // ── 6. Guard: encounter belum di-sync ────────────────────────────────
        if (empty($reg->satusehat_encounter_id)) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'waiting_encounter',
            ]);
            return;
        }

        // ── 7. Inisialisasi bridge SatuSehat ─────────────────────────────────
        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'observation_sync';
        } catch (\Throwable $e) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'failed',
            ]);
            throw $e;
        }

        // ── 8. POST Observation ke SatuSehat ─────────────────────────────────
        try {
            $payload       = ObservationBuilder::build($cppt, $reg);
            $result        = $bridge->postJson('Observation', $payload);
            $observationId = $result['id'] ?? null;

            if ($observationId) {
                DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                    'satusehat_observation_id'         => $observationId,
                    'satusehat_observation_status'     => 'synced',
                    'satusehat_observation_synced_at'  => now(),
                ]);
                return;
            }

            // ── 9. Error response dari SatuSehat ─────────────────────────────
            $issue  = $result['issue'][0] ?? [];
            $errMsg = $issue['diagnostics'] ?? json_encode($result);

            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'failed',
            ]);
            throw new \RuntimeException('[SyncObservationToSatuSehat] Gagal: ' . $errMsg);

        } catch (\Throwable $e) {
            DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
                'satusehat_observation_status' => 'failed',
            ]);
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        DB::table('cppt')->where('uuid', $this->cpptUuid)->update([
            'satusehat_observation_status' => 'failed',
        ]);
    }
}
