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
 *   php artisan satusehat:listen-registrasi --heartbeat=10   ← heartbeat tiap 10 detik
 *
 * Cara menjalankan di production (dengan Supervisor):
 *   Lihat config/supervisor/satusehat-group.conf
 *
 * Mekanisme:
 *   - PostgreSQL trigger fn_notify_registrasi_upsert() memanggil pg_notify()
 *     setiap ada INSERT atau UPDATE ke tabel `registrasi`
 *   - Command ini memanggil LISTEN satusehat_registrasi_upsert pada koneksi dedicated
 *   - pgsqlGetNotify() polling dengan timeout 5 detik (non-blocking)
 *   - Saat notifikasi diterima → dispatch SyncEncounterToSatuSehat job
 *
 * Event yang dipancarkan trigger (semua UPDATE, INSERT tidak lagi ditangani):
 *   encounter_post   → POST Encounter baru (encounter_id NULL, status_ro = 'Belum Diperiksa')
 *   encounter_ro     → PUT in-progress (status_ro berubah ke 'Sudah Diperiksa RO')
 *   encounter_dokter → PUT finished (status_dokter berubah ke 'Sudah Diperiksa')
 *   careplan_kontrol → POST CarePlan jadwal kontrol (tanggal_kontrol_selanjutnya IS NOT NULL)
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
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}
                            {--heartbeat=30  : Interval heartbeat log dalam detik (0 = nonaktif)}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync encounter baru/update ke SatuSehat via pg_notify';

    /** Channel PostgreSQL yang di-listen — harus sama dengan yang ada di trigger */
    private const CHANNEL = 'satusehat_registrasi_upsert';

    /** Event yang valid dari trigger */
    private const VALID_EVENTS = ['encounter_post', 'encounter_ro', 'encounter_dokter', 'careplan_kontrol'];

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
        $this->info('│ [REGISTRASI] Daemon SatuSehat Registrasi Listener');
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
            // Dispatch pending signals (SIGTERM/SIGINT)
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            // Cek batas max-jobs → restart daemon agar tidak memory leak
            if ($jobCount >= $maxJobs) {
                $this->info("[REGISTRASI] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS; // Supervisor akan restart otomatis
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[REGISTRASI] ✗ Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[REGISTRASI] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();
                $this->listeningPdo = null;
                continue;
            }

            // ── Polling pg_notify ─────────────────────────────────────────
            try {
                $notification = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                $this->warn('[REGISTRASI] ✗ Koneksi terputus: ' . $e->getMessage());
                DB::reconnect();
                $this->listeningPdo = null;
                sleep(2);
                continue;
            }

            $pollCount++;

            // ── Heartbeat — bukti daemon masih hidup & aktif mendengarkan ─
            if ($heartbeatSec > 0 && (time() - $lastHeartbeat) >= $heartbeatSec) {
                $this->line(
                    '<fg=gray>[REGISTRASI] ♥ Heartbeat — mendengarkan | channel: '
                    . self::CHANNEL
                    . ' | poll#' . number_format($pollCount)
                    . ' | dispatched: ' . $jobCount
                    . ' | ' . now()->format('H:i:s') . '</>'
                );
                $lastHeartbeat = time();
            }

            // Tidak ada notifikasi dalam timeout window → lanjut polling
            if (!$notification) {
                continue;
            }

            // ── NOTIFIKASI DITERIMA — log payload mentah ──────────────────
            // pgsqlGetNotify() mengembalikan key 'message' (bukan 'name') untuk channel
            $channel = $notification['message'] ?? '';
            $payload = $notification['payload'] ?? '';

            $this->newLine();
            $this->line('<fg=yellow;options=bold>╔══ [REGISTRASI] NOTIFIKASI pg_notify DITERIMA ══════════════╗</>');
            $this->line('<fg=yellow>║  Channel : ' . $channel . '</>');
            $this->line('<fg=yellow>║  Waktu   : ' . now()->format('Y-m-d H:i:s') . '</>');
            $this->line('<fg=yellow>║  Payload : ' . $payload . '</>');
            $this->line('<fg=yellow;options=bold>╚════════════════════════════════════════════════════════════╝</>');

            if ($channel !== self::CHANNEL) {
                $this->warn("[REGISTRASI] ⚠ Channel tidak dikenal '{$channel}' — diabaikan.");
                $this->newLine();
                continue;
            }

            $data = json_decode($payload, true);
            if (empty($data['uuid'])) {
                $this->error('[REGISTRASI] ✗ Payload tidak valid atau uuid kosong: ' . $payload);
                $this->newLine();
                continue;
            }

            $uuid        = $data['uuid'];
            $nomor       = $data['nomor']                      ?? '-';
            $encounterId = $data['satusehat_encounter_id']     ?? null;
            $status      = $data['satusehat_encounter_status'] ?? null;
            $event       = $data['event']                      ?? 'unknown';

            $this->line('<fg=cyan>  UUID    : ' . $uuid . '</>');
            $this->line('<fg=cyan>  Nomor   : ' . $nomor . '</>');
            $this->line('<fg=cyan>  Event   : ' . $event . '</>');
            $this->line('<fg=cyan>  Enc.ID  : ' . ($encounterId ?? 'null') . '</>');

            // Guard: event tidak dikenal — abaikan
            if (!in_array($event, self::VALID_EVENTS)) {
                $this->warn("  → SKIP: event '{$event}' tidak dikenal — diabaikan.");
                $this->newLine();
                continue;
            }

            // Guard khusus encounter_post: skip jika sudah synced
            if ($event === 'encounter_post' && $encounterId && $status === 'synced') {
                $this->line('<fg=gray>  → SKIP: encounter_post sudah synced (ID: ' . $encounterId . ')</>');
                $this->newLine();
                continue;
            }

            // ── Dispatch job dengan event ─────────────────────────────────
            try {
                SyncEncounterToSatuSehat::dispatch($uuid, $event);
                $jobCount++;
                $eventColor = match ($event) {
                    'encounter_post'   => 'green',
                    'encounter_ro'     => 'yellow',
                    'encounter_dokter' => 'cyan',
                    'careplan_kontrol' => 'magenta',
                    default            => 'white',
                };
                $this->line("<fg={$eventColor};options=bold>  → ✓ Job dispatched [{$event}]!</>");
                $this->line("<fg={$eventColor}>    UUID    : {$uuid}</>");
                $this->line("<fg={$eventColor}>    Nomor   : {$nomor}</>");
                $this->line("<fg={$eventColor}>    Total dispatched: {$jobCount}</>");
            } catch (\Throwable $e) {
                $this->error('  → ✗ Gagal dispatch job: ' . $e->getMessage());
            }

            $this->newLine();
        }

        $this->info('[REGISTRASI] Daemon dihentikan (graceful shutdown).');
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

        $this->info('[REGISTRASI] ✓ LISTEN aktif pada channel: ' . self::CHANNEL);
        return $this->listeningPdo;
    }
}
