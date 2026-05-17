<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\PatientBuilder;

/**
 * SyncPasienToSatuSehat
 *
 * Job ini dipanggil secara otomatis oleh PasienObserver::created() setiap kali
 * ada pasien baru dibuat via Eloquent (new Pasien → save()).
 *
 * Dengan Bus::dispatchAfterResponse(), job berjalan SETELAH HTTP response dikirim ke client,
 * sehingga proses pendaftaran pasien di UI tidak terasa lambat.
 *
 * Dengan QUEUE_CONNECTION=sync (default), job langsung dieksekusi di proses yang sama.
 * Dengan QUEUE_CONNECTION=database/redis, job diproses oleh worker secara async.
 *
 * Flow:
 *   1. Ambil data lengkap pasien (dengan relasi wilayah FK)
 *   2. Validasi NIK (harus 16 digit angka)
 *   3. POST ke SatuSehat via PatientBuilder
 *   4. Berhasil   → simpan id_satu_sehat, status='synced'
 *   5. Duplikat   → GET IHS ID yang ada, simpan ke local
 *   6. Gagal      → set status='failed', job bisa di-retry via PatientSyncCtrl
 */
class SyncPasienToSatuSehat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Jumlah maksimal percobaan ulang jika job gagal */
    public int $tries = 2;

    /** Delay antar retry dalam detik */
    public array $backoff = [30, 120];

    /** Timeout per eksekusi (detik) */
    public int $timeout = 60;

    /**
     * @param string $pasienUuid  UUID pasien yang akan di-sync
     */
    public function __construct(public string $pasienUuid) {}

    public function handle(): void
    {
        // ── 1. Ambil data pasien beserta FK wilayah ───────────────────────
        $pasien = DB::table('pasien')
            ->where('uuid', $this->pasienUuid)
            ->where('delete_soft', 1)
            ->select([
                'id', 'uuid', 'nama', 'no_identitas', 'jenis_kelamin', 'tanggal_lahir',
                'alamat', 'nama_kab_kota', 'kodepos', 'no_handphone',
                'status_pernikahan', 'nama_provinsi', 'nama_kecamatan', 'nama_kelurahan',
                'rt_rw', 'id_satu_sehat',
                'provinsi_id', 'kab_kota_id', 'kecamatan_id', 'kelurahan_id',
            ])
            ->first();

        if (!$pasien) {
            // Pasien tidak ditemukan (mungkin sudah dihapus soft-delete) — abaikan
            return;
        }

        // ── 2. Guard: sudah punya IHS ID → tidak perlu sync ulang ─────────
        if (!empty($pasien->id_satu_sehat)) {
            return;
        }

        // ── 3. Validasi NIK ───────────────────────────────────────────────
        $nik = trim($pasien->no_identitas ?? '');
        if (!preg_match('/^\d{16}$/', $nik)) {
            // NIK tidak valid → tidak bisa di-POST ke SatuSehat
            DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                'satusehat_sync_status' => 'not_found',
            ]);
            return;
        }

        // ── 4. Inisialisasi bridge SatuSehat ──────────────────────────────
        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'patient_auto_sync';
        } catch (\Throwable $e) {
            // Token gagal diinisialisasi → tandai failed agar bisa di-retry manual
            DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                'satusehat_sync_status' => 'failed',
            ]);
            // Re-throw agar framework mencatat job failure + menghitung retry
            throw $e;
        }

        // ── 5. POST Patient ke SatuSehat ──────────────────────────────────
        try {
            $payload = PatientBuilder::build($pasien);
            $result  = $bridge->postJson('Patient', $payload);
            $ihsId   = $result['id'] ?? null;

            if ($ihsId) {
                // ✓ Berhasil — simpan IHS ID
                DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                    'id_satu_sehat'         => $ihsId,
                    'satusehat_sync_status' => 'synced',
                    'satusehat_synced_at'   => now(),
                ]);
                return;
            }

            // ── 6. Handle error response ───────────────────────────────────
            $issue   = $result['issue'][0] ?? [];
            $errCode = $issue['details']['coding'][0]['code'] ?? ($issue['code'] ?? '');
            $errMsg  = $issue['diagnostics'] ?? json_encode($result);

            // Duplikat → ambil IHS ID yang sudah ada
            if (stripos($errMsg, 'duplicate') !== false || stripos($errCode, 'duplicate') !== false) {
                $existing   = $bridge->getJson('Patient?identifier=' . urlencode('https://fhir.kemkes.go.id/id/nik|' . $nik));
                $existingId = $existing['entry'][0]['resource']['id'] ?? null;

                if ($existingId) {
                    DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                        'id_satu_sehat'         => $existingId,
                        'satusehat_sync_status' => 'synced',
                        'satusehat_synced_at'   => now(),
                    ]);
                    return;
                }
            }

            // Error lainnya → tandai failed
            DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                'satusehat_sync_status' => 'failed',
            ]);

        } catch (\Throwable $e) {
            DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
                'satusehat_sync_status' => 'failed',
            ]);
            throw $e; // re-throw agar framework menghitung retry
        }
    }

    /**
     * Dipanggil setelah semua retry habis dan job masih gagal.
     */
    public function failed(\Throwable $exception): void
    {
        DB::table('pasien')->where('uuid', $this->pasienUuid)->update([
            'satusehat_sync_status' => 'failed',
        ]);
    }
}
