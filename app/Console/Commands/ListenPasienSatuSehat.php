<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncPasienToSatuSehat;

/**
 * ListenPasienSatuSehat — Daemon yang mendengarkan notifikasi PostgreSQL
 * dan otomatis men-dispatch sync job setiap ada pasien baru dibuat.
 *
 * Cara menjalankan (development):
 *   php artisan satusehat:listen-pasien
 *
 * Cara menjalankan di production (dengan Supervisor):
 *   Lihat config/supervisor/satusehat-listener.conf
 *
 * Mekanisme:
 *   - PostgreSQL trigger fn_notify_pasien_inserted() memanggil pg_notify()
 *     setiap ada INSERT ke tabel `pasien`
 *   - Command ini memanggil LISTEN satusehat_pasien_insert pada koneksi dedicated
 *   - pgsqlGetNotify() polling dengan timeout 5 detik (non-blocking)
 *   - Saat notifikasi diterima → dispatch SyncPasienToSatuSehat job
 *
 * Signal handling:
 *   SIGTERM / SIGINT → graceful shutdown (tunggu iterasi selesai lalu keluar)
 *
 * Memory & stability:
 *   - Daemon restart otomatis oleh Supervisor setelah --max-jobs tercapai
 *   - Reconnect otomatis jika koneksi PostgreSQL putus
 */
class ListenPasienSatuSehat extends Command
{
    protected $signature = 'satusehat:listen-pasien
                            {--timeout=5000  : Timeout polling pg_notify dalam milidetik}
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync pasien baru ke SatuSehat via pg_notify';

    /** Channel PostgreSQL yang di-listen — harus sama dengan yang ada di trigger */
    private const CHANNEL = 'satusehat_pasien_insert';

    /** Flag shutdown — set ke true saat SIGTERM/SIGINT diterima */
    private bool $shouldStop = false;

    /** Referensi PDO yang sudah dalam state LISTEN (null = belum/reconnect) */
    private ?\PDO $listeningPdo = null;

    public function handle(): int
    {
        $timeoutMs = (int)$this->option('timeout');
        $maxJobs   = (int)$this->option('max-jobs');
        $jobCount  = 0;

        $this->info('[SatuSehat Listener] Memulai daemon — channel: ' . self::CHANNEL);
        $this->info('[SatuSehat Listener] PID: ' . getmypid());

        // ── Daftarkan signal handler untuk graceful shutdown ─────────────
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, fn() => $this->shouldStop = true);
            pcntl_signal(SIGINT,  fn() => $this->shouldStop = true);
        }

        while (!$this->shouldStop) {
            // Dispatch pending signals (SIGTERM/SIGINT)
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            // Cek batas max-jobs → restart daemon agar tidak memory leak
            if ($jobCount >= $maxJobs) {
                $this->info("[SatuSehat Listener] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS; // Supervisor akan restart otomatis
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[SatuSehat Listener] Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[SatuSehat Listener] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();          // reset pool Laravel
                $this->listeningPdo = null; // paksa re-LISTEN setelah reconnect
                continue;
            }

            // ── Polling pg_notify ─────────────────────────────────────────
            try {
                $notification = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                // Koneksi putus — reconnect di iterasi berikutnya
                $this->warn('[SatuSehat Listener] Koneksi terputus: ' . $e->getMessage());
                DB::reconnect();
                $this->listeningPdo = null; // paksa re-LISTEN
                sleep(2);
                continue;
            }

            // Tidak ada notifikasi dalam timeout window → lanjut polling
            if (!$notification) {
                continue;
            }

            // ── Proses notifikasi ─────────────────────────────────────────
            $channel = $notification['name']    ?? '';
            $payload = $notification['payload'] ?? '';

            if ($channel !== self::CHANNEL) {
                continue; // bukan channel kita — abaikan
            }

            $data = json_decode($payload, true);
            if (empty($data['uuid'])) {
                $this->warn('[SatuSehat Listener] Payload tidak valid: ' . $payload);
                continue;
            }

            $uuid         = $data['uuid'];
            $nik          = $data['no_identitas'] ?? '';
            $ihsId        = $data['id_satu_sehat'] ?? null;

            // Guard awal di sini (hemat 1 DB query di job kalau jelas tidak perlu sync)
            if ($ihsId) {
                $this->line("[SatuSehat Listener] Skip {$uuid} — sudah punya IHS ID");
                continue;
            }
            if (!preg_match('/^\d{16}$/', trim($nik))) {
                $this->line("[SatuSehat Listener] Skip {$uuid} — NIK tidak valid ({$nik})");
                continue;
            }

            // ── Dispatch job ──────────────────────────────────────────────
            try {
                SyncPasienToSatuSehat::dispatch($uuid);
                $jobCount++;
                $this->line("[SatuSehat Listener] ✓ Dispatched job untuk pasien {$uuid} (NIK: {$nik}) — total: {$jobCount}");
            } catch (\Throwable $e) {
                $this->error("[SatuSehat Listener] Gagal dispatch job untuk {$uuid}: " . $e->getMessage());
            }
        }

        $this->info('[SatuSehat Listener] Daemon dihentikan (graceful shutdown).');
        return self::SUCCESS;
    }

    /**
     * Ambil koneksi PDO yang sudah dalam state LISTEN.
     *
     * Menggunakan $this->listeningPdo sebagai referensi — jika null
     * (pertama kali atau setelah reconnect), buat koneksi baru dan jalankan LISTEN.
     *
     * pgsqlGetNotify() HARUS dipanggil pada PDO object yang sama
     * dengan yang menjalankan LISTEN — jadi kita simpan referensinya.
     */
    private function getListeningPdo(): \PDO
    {
        // Gunakan PDO yang sudah di-LISTEN jika masih valid
        if ($this->listeningPdo !== null) {
            return $this->listeningPdo;
        }

        $pdo = DB::connection()->getPdo();

        if ($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) !== 'pgsql') {
            throw new \RuntimeException('Koneksi bukan PostgreSQL. LISTEN/NOTIFY hanya didukung PostgreSQL.');
        }

        // Jalankan LISTEN pada koneksi ini — LISTEN bersifat per-session
        $pdo->exec('LISTEN ' . self::CHANNEL);
        $this->listeningPdo = $pdo;

        $this->info('[SatuSehat Listener] LISTEN aktif pada channel: ' . self::CHANNEL);
        return $this->listeningPdo;
    }
}
