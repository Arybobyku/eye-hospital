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
use App\Services\SatuSehat\EncounterBuilder;

/**
 * SyncEncounterToSatuSehat
 *
 * Job ini dipanggil otomatis oleh:
 *   1. ListenRegistrasiSatuSehat daemon (via PostgreSQL pg_notify) — menangkap
 *      SEMUA INSERT / UPDATE ke tabel registrasi dari sumber manapun.
 *   2. RegistrasiObserver::created() / updated() — fallback untuk insert/update
 *      via Eloquent (new Registrasi → save()).
 *
 * Job ini bersifat IDEMPOTEN:
 *   - Jika encounter sudah punya satusehat_encounter_id → skip.
 *   - Jika pasien belum punya id_satu_sehat → skip (tandai 'waiting_patient').
 *   - Jika satusehat_location_id tidak terisi → skip (tandai 'no_location').
 *
 * Double-dispatch aman: listener & observer bisa keduanya dispatch untuk UUID
 * yang sama; job pertama berhasil, job kedua akan skip di guard awal.
 *
 * Flow:
 *   1. Fetch registrasi + join pasien & pengguna
 *   2. Guard: sudah punya encounter_id & status 'synced' → skip
 *   3. Guard: pasien belum punya id_satu_sehat → tunggu
 *   4. Guard: satusehat_location_id kosong → tandai 'no_location'
 *   5. POST ke SatuSehat via EncounterBuilder
 *   6. Berhasil → simpan encounter_id, status='synced'
 *   7. Gagal    → status='failed', throw untuk retry
 */
class SyncEncounterToSatuSehat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Maksimal percobaan ulang jika job gagal */
    public int $tries = 3;

    /** Delay antar retry dalam detik */
    public array $backoff = [30, 120, 300];

    /** Timeout per eksekusi (detik) */
    public int $timeout = 60;

    /**
     * @param string $registrasiUuid  UUID registrasi yang akan di-sync
     */
    public function __construct(public string $registrasiUuid) {}

    public function handle(): void
    {
        // ── 1. Ambil data registrasi beserta join pasien & pengguna ──────────
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
                'registrasi.satusehat_location_id',
                'registrasi.satusehat_encounter_id',
                'registrasi.satusehat_encounter_status',
                'registrasi.tanggal',
                'registrasi.waktu',
                'registrasi.jenis',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
            ])
            ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
            ->where('registrasi.uuid', $this->registrasiUuid)
            ->where('registrasi.delete_soft', 1)
            ->first();

        if (!$reg) {
            // Registrasi tidak ditemukan / sudah dihapus soft-delete — abaikan
            return;
        }

        // ── 2. Guard: sudah ter-sync → tidak perlu kirim ulang ───────────────
        if (!empty($reg->satusehat_encounter_id) && $reg->satusehat_encounter_status === 'synced') {
            return;
        }

        // ── 3. Guard: pasien belum punya IHS Number → tunggu sync pasien dulu ─
        if (empty($reg->patient_ihs_id)) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'waiting_patient',
            ]);
            return;
        }

        // ── 4. Guard: satusehat_location_id wajib diisi ──────────────────────
        if (empty($reg->satusehat_location_id)) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'no_location',
            ]);
            return;
        }

        // ── 5. Inisialisasi bridge SatuSehat ─────────────────────────────────
        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'encounter_auto_sync';
            $orgId = (new ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);
            throw $e;
        }

        // ── 6. POST Encounter ke SatuSehat ────────────────────────────────────
        try {
            $payload     = EncounterBuilder::build($reg, $orgId);
            $result      = $bridge->postJson('Encounter', $payload);
            $encounterId = $result['id'] ?? null;

            if ($encounterId) {
                // ✓ Berhasil — simpan Encounter ID
                DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                    'satusehat_encounter_id'        => $encounterId,
                    'satusehat_encounter_status'     => 'synced',
                    'satusehat_encounter_synced_at'  => now(),
                ]);
                return;
            }

            // ── 7. Handle error response dari SatuSehat ──────────────────────
            $issue   = $result['issue'][0] ?? [];
            $errCode = $issue['details']['coding'][0]['code'] ?? ($issue['code'] ?? '');
            $errMsg  = $issue['diagnostics'] ?? json_encode($result);

            // Duplikat → ambil ID yang sudah ada
            if (stripos($errMsg, 'duplicate') !== false || stripos($errCode, 'duplicate') !== false) {
                $nomor    = $reg->nomor ?? $this->registrasiUuid;
                $existing = $bridge->getJson('Encounter?identifier=' . urlencode($nomor));
                $existId  = $existing['entry'][0]['resource']['id'] ?? null;

                if ($existId) {
                    DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                        'satusehat_encounter_id'        => $existId,
                        'satusehat_encounter_status'     => 'synced',
                        'satusehat_encounter_synced_at'  => now(),
                    ]);
                    return;
                }
            }

            // Error lainnya → tandai failed, job akan di-retry
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);
            throw new \RuntimeException('[SyncEncounterToSatuSehat] Gagal: ' . $errMsg);

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);
            throw $e; // re-throw agar framework menghitung retry
        }
    }

    /**
     * Dipanggil setelah semua retry habis dan job masih gagal.
     */
    public function failed(\Throwable $exception): void
    {
        DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
            'satusehat_encounter_status' => 'failed',
        ]);
    }
}
