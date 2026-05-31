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
 *   php artisan satusehat:listen-pasien --heartbeat=10
 *
 * Cara menjalankan di production (dengan Supervisor):
 *   Lihat config/supervisor/satusehat-group.conf
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
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}
                            {--heartbeat=30  : Interval heartbeat log dalam detik (0 = nonaktif)}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync pasien baru ke SatuSehat via pg_notify';

    /** Channel PostgreSQL yang di-listen — harus sama dengan yang ada di trigger */
    private const CHANNEL = 'satusehat_pasien_insert';

    /** Flag shutdown — set ke true saat SIGTERM/SIGINT diterima */
    private bool $shouldStop = false;

    /** Referensi PDO yang sudah dalam state LISTEN (null = belum/reconnect) */
    private ?\PDO $listeningPdo = null;

    public function handle(): int
    {
        $timeoutMs    = (int)$this->option('timeout');
        $maxJobs      = (int)$this->option('max-jobs');
        $heartbeatSec = (int)$this->option('heartbeat');
        $jobCount     = 0;
        $pollCount    = 0;
        $lastHeartbeat = time();

        $this->info('┌─────────────────────────────────────────────────────────');
        $this->info('│ [PASIEN] Daemon SatuSehat Pasien Listener');
        $this->info('│ PID       : ' . getmypid());
        $this->info('│ Channel   : ' . self::CHANNEL);
        $this->info('│ Timeout   : ' . $timeoutMs . ' ms per poll');
        $this->info('│ Max-jobs  : ' . $maxJobs);
        $this->info('│ Heartbeat : ' . ($heartbeatSec > 0 ? "{$heartbeatSec} detik" : 'nonaktif'));
        $this->info('└─────────────────────────────────────────────────────────');

        // ── Daftarkan signal handler untuk graceful shutdown ─────────────
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, fn() => $this->shouldStop = true);
            pcntl_signal(SIGINT,  fn() => $this->shouldStop = true);
        }

        while (!$this->shouldStop) {
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            if ($jobCount >= $maxJobs) {
                $this->info("[PASIEN] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS;
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[PASIEN] ✗ Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[PASIEN] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();
                $this->listeningPdo = null;
                continue;
            }

            // ── Polling pg_notify ─────────────────────────────────────────
            try {
                $notification = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                $this->warn('[PASIEN] ✗ Koneksi terputus: ' . $e->getMessage());
                DB::reconnect();
                $this->listeningPdo = null;
                sleep(2);
                continue;
            }

            $pollCount++;

            // ── Heartbeat ─────────────────────────────────────────────────
            if ($heartbeatSec > 0 && (time() - $lastHeartbeat) >= $heartbeatSec) {
                $this->line(
                    '<fg=gray>[PASIEN] ♥ Heartbeat — mendengarkan | channel: '
                    . self::CHANNEL
                    . ' | poll#' . number_format($pollCount)
                    . ' | dispatched: ' . $jobCount
                    . ' | ' . now()->format('H:i:s') . '</>'
                );
                $lastHeartbeat = time();
            }

            if (!$notification) {
                continue;
            }

            // ── NOTIFIKASI DITERIMA ───────────────────────────────────────
            // pgsqlGetNotify() mengembalikan key 'message' (bukan 'name') untuk channel
            $channel = $notification['message'] ?? '';
            $payload = $notification['payload'] ?? '';

            $this->newLine();
            $this->line('<fg=cyan;options=bold>╔══ [PASIEN] NOTIFIKASI pg_notify DITERIMA ══════════════════╗</>');
            $this->line('<fg=cyan>║  Channel : ' . $channel . '</>');
            $this->line('<fg=cyan>║  Waktu   : ' . now()->format('Y-m-d H:i:s') . '</>');
            $this->line('<fg=cyan>║  Payload : ' . $payload . '</>');
            $this->line('<fg=cyan;options=bold>╚════════════════════════════════════════════════════════════╝</>');

            if ($channel !== self::CHANNEL) {
                $this->warn("[PASIEN] ⚠ Channel tidak dikenal '{$channel}' — diabaikan.");
                $this->newLine();
                continue;
            }

            $data = json_decode($payload, true);
            if (empty($data['uuid'])) {
                $this->error('[PASIEN] ✗ Payload tidak valid atau uuid kosong: ' . $payload);
                $this->newLine();
                continue;
            }

            $uuid  = $data['uuid'];
            $nik   = $data['no_identitas'] ?? '';
            $ihsId = $data['id_satu_sehat'] ?? null;

            $this->line('<fg=cyan>  UUID   : ' . $uuid . '</>');
            $this->line('<fg=cyan>  NIK    : ' . ($nik ?: '-') . '</>');
            $this->line('<fg=cyan>  IHS ID : ' . ($ihsId ?? 'null (belum sync)') . '</>');

            // Guard: sudah punya IHS ID → skip
            if ($ihsId) {
                $this->line('<fg=gray>  → SKIP: pasien sudah punya IHS ID (' . $ihsId . ')</>');
                $this->newLine();
                continue;
            }

            // Guard: NIK tidak valid
            if (!preg_match('/^\d{16}$/', trim($nik))) {
                $this->line('<fg=yellow>  → SKIP: NIK tidak valid (' . $nik . '), tidak bisa sync ke SatuSehat</>');
                $this->newLine();
                continue;
            }

            // ── Dispatch job ──────────────────────────────────────────────
            try {
                SyncPasienToSatuSehat::dispatch($uuid);
                $jobCount++;
                $this->line('<fg=green;options=bold>  → ✓ Job SyncPasienToSatuSehat dispatched!</>');
                $this->line('<fg=green>    UUID  : ' . $uuid . '</>');
                $this->line('<fg=green>    NIK   : ' . $nik . '</>');
                $this->line('<fg=green>    Total dispatched: ' . $jobCount . '</>');
            } catch (\Throwable $e) {
                $this->error('  → ✗ Gagal dispatch job: ' . $e->getMessage());
            }

            $this->newLine();
        }

        $this->info('[PASIEN] Daemon dihentikan (graceful shutdown).');
        return self::SUCCESS;
    }

    /**
     * Ambil koneksi PDO yang sudah dalam state LISTEN.
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

        $this->info('[PASIEN] ✓ LISTEN aktif pada channel: ' . self::CHANNEL);
        return $this->listeningPdo;
    }
}
