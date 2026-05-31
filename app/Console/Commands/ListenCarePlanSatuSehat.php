<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncCarePlanToSatuSehat;

/**
 * ListenCarePlanSatuSehat — Daemon yang mendengarkan notifikasi PostgreSQL
 * dan otomatis men-dispatch sync job setiap dokter selesai memeriksa pasien
 * (status_dokter berubah menjadi 'Sudah Diperiksa').
 *
 * Cara menjalankan (development):
 *   php artisan satusehat:listen-careplan
 *   php artisan satusehat:listen-careplan --heartbeat=10
 *
 * Production: lihat config/supervisor/satusehat-group.conf
 *
 * Mekanisme:
 *   - PostgreSQL trigger fn_notify_careplan_ready() memanggil pg_notify()
 *     saat UPDATE registrasi dengan status_dokter = 'Sudah Diperiksa'
 *   - Command ini LISTEN pada channel 'satusehat_careplan_notify'
 *   - Notifikasi diterima → dispatch SyncCarePlanToSatuSehat job
 */
class ListenCarePlanSatuSehat extends Command
{
    protected $signature = 'satusehat:listen-careplan
                            {--timeout=5000  : Timeout polling pg_notify dalam milidetik}
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}
                            {--heartbeat=30  : Interval heartbeat log dalam detik (0 = nonaktif)}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync CarePlan saat dokter selesai periksa';

    private const CHANNEL = 'satusehat_careplan_notify';

    private bool  $shouldStop   = false;
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
        $this->info('│ [CAREPLAN] Daemon SatuSehat CarePlan Listener');
        $this->info('│ PID       : ' . getmypid());
        $this->info('│ Channel   : ' . self::CHANNEL);
        $this->info('│ Timeout   : ' . $timeoutMs . ' ms per poll');
        $this->info('│ Max-jobs  : ' . $maxJobs);
        $this->info('│ Heartbeat : ' . ($heartbeatSec > 0 ? "{$heartbeatSec} detik" : 'nonaktif'));
        $this->info('└─────────────────────────────────────────────────────────');

        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, fn() => $this->shouldStop = true);
            pcntl_signal(SIGINT,  fn() => $this->shouldStop = true);
        }

        while (!$this->shouldStop) {
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            if ($jobCount >= $maxJobs) {
                $this->info("[CAREPLAN] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS;
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[CAREPLAN] ✗ Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[CAREPLAN] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();
                $this->listeningPdo = null;
                continue;
            }

            // ── Polling pg_notify ────────────────────────────────────────────
            try {
                $notification = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                $this->warn('[CAREPLAN] ✗ Koneksi terputus: ' . $e->getMessage());
                DB::reconnect();
                $this->listeningPdo = null;
                sleep(2);
                continue;
            }

            $pollCount++;

            // ── Heartbeat ─────────────────────────────────────────────────────
            if ($heartbeatSec > 0 && (time() - $lastHeartbeat) >= $heartbeatSec) {
                $this->line(
                    '<fg=gray>[CAREPLAN] ♥ Heartbeat — mendengarkan | channel: '
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

            // ── NOTIFIKASI DITERIMA ───────────────────────────────────────────
            // pgsqlGetNotify() mengembalikan key 'message' (bukan 'name') untuk channel
            $channel = $notification['message'] ?? '';
            $payload = $notification['payload'] ?? '';

            $this->newLine();
            $this->line('<fg=yellow;options=bold>╔══ [CAREPLAN] NOTIFIKASI pg_notify DITERIMA ════════════════╗</>');
            $this->line('<fg=yellow>║  Channel : ' . $channel . '</>');
            $this->line('<fg=yellow>║  Waktu   : ' . now()->format('Y-m-d H:i:s') . '</>');
            $this->line('<fg=yellow>║  Payload : ' . $payload . '</>');
            $this->line('<fg=yellow;options=bold>╚════════════════════════════════════════════════════════════╝</>');

            if ($channel !== self::CHANNEL) {
                $this->warn("[CAREPLAN] ⚠ Channel tidak dikenal '{$channel}' — diabaikan.");
                $this->newLine();
                continue;
            }

            $data = json_decode($payload, true);
            if (empty($data['uuid'])) {
                $this->error('[CAREPLAN] ✗ Payload tidak valid atau uuid kosong: ' . $payload);
                $this->newLine();
                continue;
            }

            $uuid        = $data['uuid'];
            $nomor       = $data['nomor']                  ?? '-';
            $careplanId  = $data['satusehat_careplan_id']  ?? null;
            $encounterId = $data['satusehat_encounter_id'] ?? null;

            $this->line('<fg=yellow>  UUID        : ' . $uuid . '</>');
            $this->line('<fg=yellow>  Nomor       : ' . $nomor . '</>');
            $this->line('<fg=yellow>  Enc.ID      : ' . ($encounterId ?? 'null (belum ada encounter)') . '</>');
            $this->line('<fg=yellow>  CarePlan ID : ' . ($careplanId ?? 'null (belum synced)') . '</>');

            // Guard: sudah synced
            if ($careplanId) {
                $this->line('<fg=gray>  → SKIP: CarePlan sudah ada (' . $careplanId . ')</>');
                $this->newLine();
                continue;
            }

            // Info jika encounter belum ada
            if (empty($encounterId)) {
                $this->line('<fg=yellow>  ⚠ Encounter ID belum ada — job akan menangani (waiting_encounter)</>');
            }

            // ── Dispatch job ──────────────────────────────────────────────────
            try {
                SyncCarePlanToSatuSehat::dispatch($uuid);
                $jobCount++;
                $this->line('<fg=green;options=bold>  → ✓ Job SyncCarePlanToSatuSehat dispatched!</>');
                $this->line('<fg=green>    UUID  : ' . $uuid . '</>');
                $this->line('<fg=green>    Nomor : ' . $nomor . '</>');
                $this->line('<fg=green>    Total dispatched: ' . $jobCount . '</>');
            } catch (\Throwable $e) {
                $this->error('  → ✗ Gagal dispatch job: ' . $e->getMessage());
            }

            $this->newLine();
        }

        $this->info('[CAREPLAN] Daemon dihentikan (graceful shutdown).');
        return self::SUCCESS;
    }

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

        $this->info('[CAREPLAN] ✓ LISTEN aktif pada channel: ' . self::CHANNEL);
        return $this->listeningPdo;
    }
}
