<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncEncounterToSatuSehat;

/**
 * ListenRegistrasiSatuSehat — Daemon yang mendengarkan notifikasi PostgreSQL
 * dan otomatis men-dispatch sync job setiap ada registrasi baru dibuat
 * atau diperbarui (INSERT / UPDATE).
 *
 * Cara menjalankan (development):
 *   php artisan satusehat:listen-registrasi
 *
 * Cara menjalankan di production (dengan Supervisor):
 *   Lihat config/supervisor/satusehat-registrasi-listener.conf
 *
 * Mekanisme:
 *   - PostgreSQL trigger fn_notify_registrasi_upsert() memanggil pg_notify()
 *     setiap ada INSERT atau UPDATE ke tabel `registrasi`
 *   - Command ini memanggil LISTEN satusehat_registrasi_upsert pada koneksi dedicated
 *   - pgsqlGetNotify() polling dengan timeout 5 detik (non-blocking)
 *   - Saat notifikasi diterima → dispatch SyncEncounterToSatuSehat job
 *
 * Kondisi yang memicu notifikasi (di trigger):
 *   INSERT : delete_soft = 1 (registrasi aktif)
 *   UPDATE : delete_soft = 1 DAN (encounter_id NULL ATAU status = 'failed')
 *
 * Signal handling:
 *   SIGTERM / SIGINT → graceful shutdown (tunggu iterasi selesai lalu keluar)
 *
 * Memory & stability:
 *   - Daemon restart otomatis oleh Supervisor setelah --max-jobs tercapai
 *   - Reconnect otomatis jika koneksi PostgreSQL putus
 */
class ListenRegistrasiSatuSehat extends Command
{
    protected $signature = 'satusehat:listen-registrasi
                            {--timeout=5000  : Timeout polling pg_notify dalam milidetik}
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync encounter baru/update ke SatuSehat via pg_notify';

    /** Channel PostgreSQL yang di-listen — harus sama dengan yang ada di trigger */
    private const CHANNEL = 'satusehat_registrasi_upsert';

    /** Flag shutdown — set ke true saat SIGTERM/SIGINT diterima */
    private bool $shouldStop = false;

    /** Referensi PDO yang sudah dalam state LISTEN (null = belum/reconnect) */
    private ?\PDO $listeningPdo = null;

    public function handle(): int
    {
        $timeoutMs = (int)$this->option('timeout');
        $maxJobs   = (int)$this->option('max-jobs');
        $jobCount  = 0;

        $this->info('[SatuSehat Registrasi Listener] Memulai daemon — channel: ' . self::CHANNEL);
        $this->info('[SatuSehat Registrasi Listener] PID: ' . getmypid());

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
                $this->info("[SatuSehat Registrasi Listener] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS; // Supervisor akan restart otomatis
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[SatuSehat Registrasi Listener] Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[SatuSehat Registrasi Listener] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();
                $this->listeningPdo = null;
                continue;
            }

            // ── Polling pg_notify ─────────────────────────────────────────
            try {
                $notification = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                $this->warn('[SatuSehat Registrasi Listener] Koneksi terputus: ' . $e->getMessage());
                DB::reconnect();
                $this->listeningPdo = null;
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
                continue;
            }

            $data = json_decode($payload, true);
            if (empty($data['uuid'])) {
                $this->warn('[SatuSehat Registrasi Listener] Payload tidak valid: ' . $payload);
                continue;
            }

            $uuid        = $data['uuid'];
            $nomor       = $data['nomor']                    ?? '';
            $encounterId = $data['satusehat_encounter_id']   ?? null;
            $status      = $data['satusehat_encounter_status'] ?? null;
            $event       = $data['event']                    ?? 'insert';

            // Guard awal — hemat round-trip ke job jika jelas tidak perlu sync
            if ($encounterId && $status === 'synced') {
                $this->line("[SatuSehat Registrasi Listener] Skip {$uuid} — sudah synced (Encounter ID: {$encounterId})");
                continue;
            }

            // ── Dispatch job ──────────────────────────────────────────────
            try {
                SyncEncounterToSatuSehat::dispatch($uuid);
                $jobCount++;
                $this->line("[SatuSehat Registrasi Listener] ✓ Dispatched job [{$event}] untuk registrasi {$uuid} (No: {$nomor}) — total: {$jobCount}");
            } catch (\Throwable $e) {
                $this->error("[SatuSehat Registrasi Listener] Gagal dispatch job untuk {$uuid}: " . $e->getMessage());
            }
        }

        $this->info('[SatuSehat Registrasi Listener] Daemon dihentikan (graceful shutdown).');
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
        if ($this->listeningPdo !== null) {
            return $this->listeningPdo;
        }

        $pdo = DB::connection()->getPdo();

        if ($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) !== 'pgsql') {
            throw new \RuntimeException('Koneksi bukan PostgreSQL. LISTEN/NOTIFY hanya didukung PostgreSQL.');
        }

        $pdo->exec('LISTEN ' . self::CHANNEL);
        $this->listeningPdo = $pdo;

        $this->info('[SatuSehat Registrasi Listener] LISTEN aktif pada channel: ' . self::CHANNEL);
        return $this->listeningPdo;
    }
}
