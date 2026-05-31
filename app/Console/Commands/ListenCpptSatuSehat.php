<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncObservationToSatuSehat;

/**
 * ListenCpptSatuSehat — Daemon yang mendengarkan notifikasi PostgreSQL
 * dan otomatis men-dispatch SyncObservationToSatuSehat job setiap ada
 * INSERT atau UPDATE ke tabel `cppt`.
 *
 * Cara menjalankan (development):
 *   php artisan satusehat:listen-cppt
 *   php artisan satusehat:listen-cppt --verbose           ← log tiap poll
 *   php artisan satusehat:listen-cppt --check-trigger     ← verifikasi trigger ada
 *
 * Production: gunakan Supervisor (config/supervisor/satusehat-group.conf)
 */
class ListenCpptSatuSehat extends Command
{
    protected $signature = 'satusehat:listen-cppt
                            {--timeout=5000     : Timeout polling pg_notify dalam milidetik}
                            {--max-jobs=1000    : Restart daemon setelah N job agar tidak memory leak}
                            {--heartbeat=30     : Interval heartbeat log dalam detik (0 = nonaktif)}
                            {--debug            : Log tiap poll cycle (berguna saat debug)}
                            {--check-trigger    : Verifikasi trigger ada di DB lalu keluar}';

    protected $description = 'Daemon LISTEN PostgreSQL — auto-sync CPPT sebagai Observation ke SatuSehat via pg_notify';

    private const CHANNEL = 'satusehat_cppt_upsert';

    private bool  $shouldStop   = false;
    private ?\PDO $listeningPdo = null;

    public function handle(): int
    {
        // ── Mode: hanya cek trigger lalu keluar ──────────────────────────────
        if ($this->option('check-trigger')) {
            return $this->runTriggerCheck();
        }

        $timeoutMs    = (int)$this->option('timeout');
        $maxJobs      = (int)$this->option('max-jobs');
        $heartbeatSec = (int)$this->option('heartbeat');
        $verbose      = (bool)$this->option('debug');
        $jobCount     = 0;
        $pollCount    = 0;
        $lastHeartbeat = time();

        $this->info('┌─────────────────────────────────────────────────────────');
        $this->info('│ [CPPT] Daemon SatuSehat CPPT Observation Listener');
        $this->info('│ PID       : ' . getmypid());
        $this->info('│ Channel   : ' . self::CHANNEL);
        $this->info('│ Timeout   : ' . $timeoutMs . ' ms per poll');
        $this->info('│ Max-jobs  : ' . $maxJobs);
        $this->info('│ Heartbeat : ' . ($heartbeatSec > 0 ? "{$heartbeatSec} detik" : 'nonaktif'));
        $this->info('│ Debug     : ' . ($verbose ? 'YA' : 'tidak'));
        $this->info('└─────────────────────────────────────────────────────────');

        // ── Cek trigger saat startup ─────────────────────────────────────────
        $this->checkTriggerOnStartup();

        if (function_exists('pcntl_async_signals')) {
            pcntl_async_signals(true);
        }
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, fn() => $this->shouldStop = true);
            pcntl_signal(SIGINT,  fn() => $this->shouldStop = true);
        }

        while (!$this->shouldStop) {
            if (function_exists('pcntl_signal_dispatch')) {
                pcntl_signal_dispatch();
            }

            if ($jobCount >= $maxJobs) {
                $this->info("[CPPT] Batas {$maxJobs} job tercapai — restart daemon.");
                return self::SUCCESS;
            }

            // ── Dapatkan / reconnect koneksi PostgreSQL ──────────────────────
            try {
                $pdo = $this->getListeningPdo();
            } catch (\Throwable $e) {
                $this->error('[CPPT] ✗ Koneksi DB gagal: ' . $e->getMessage());
                $this->info('[CPPT] Mencoba reconnect dalam 5 detik...');
                sleep(5);
                DB::reconnect();
                $this->listeningPdo = null;
                continue;
            }

            // ── Poll notifikasi ──────────────────────────────────────────────
            $pollCount++;
            if ($verbose) {
                $this->line(sprintf(
                    '<fg=gray>[CPPT] poll #%d @ %s — menunggu notifikasi (timeout=%dms)…</>',
                    $pollCount, now()->format('H:i:s'), $timeoutMs
                ));
            }

            try {
                $notify = $pdo->pgsqlGetNotify(\PDO::FETCH_ASSOC, $timeoutMs);
            } catch (\Throwable $e) {
                $this->error('[CPPT] ✗ Poll gagal: ' . $e->getMessage());
                $this->listeningPdo = null;
                sleep(2);
                continue;
            }

            // ── Heartbeat ────────────────────────────────────────────────────
            if ($heartbeatSec > 0 && (time() - $lastHeartbeat) >= $heartbeatSec) {
                $this->info(sprintf(
                    '[CPPT] ♥ Heartbeat | polls=%d jobs=%d | %s',
                    $pollCount, $jobCount, now()->format('Y-m-d H:i:s')
                ));
                $lastHeartbeat = time();
            }

            if (!$notify) {
                // Tidak ada notifikasi dalam window ini — normal
                continue;
            }

            // ── Notifikasi diterima — log raw ────────────────────────────────
            $this->info(sprintf(
                '[CPPT] 📨 Notifikasi diterima @ %s',
                now()->format('Y-m-d H:i:s')
            ));
            $this->line('[CPPT]    channel : ' . ($notify['name']    ?? '—'));
            $this->line('[CPPT]    pid     : ' . ($notify['pid']     ?? '—'));
            $this->line('[CPPT]    payload : ' . ($notify['payload'] ?? '—'));

            // ── Parse payload ────────────────────────────────────────────────
            $payload = json_decode($notify['payload'] ?? '', true);
            if (!$payload) {
                $this->warn('[CPPT] ⚠ Payload bukan JSON valid: ' . ($notify['payload'] ?? '(kosong)'));
                continue;
            }

            $cpptUuid = $payload['uuid']     ?? null;
            $asesmen  = $payload['asesmen']  ?? null;
            $regUuid  = $payload['registrasi_uuid'] ?? null;

            $this->line('[CPPT]    uuid    : ' . ($cpptUuid ?? '—'));
            $this->line('[CPPT]    reg_uuid: ' . ($regUuid  ?? '—'));
            $this->line('[CPPT]    asesmen : ' . (strlen($asesmen ?? '') > 80
                ? substr($asesmen, 0, 80) . '…'
                : ($asesmen ?? '(NULL/kosong)')));

            if (!$cpptUuid) {
                $this->warn('[CPPT] ⚠ uuid tidak ada di payload — skip.');
                continue;
            }

            // Guard: asesmen kosong di payload — job tetap di-dispatch,
            // job sendiri akan cek ulang nilai aktual dari DB
            if (empty(trim($asesmen ?? ''))) {
                $this->warn('[CPPT] ⚠ asesmen kosong di payload — trigger mungkin tidak sesuai guard, skip.');
                continue;
            }

            // ── Dispatch job ─────────────────────────────────────────────────
            try {
                SyncObservationToSatuSehat::dispatch($cpptUuid);
                $jobCount++;
                $this->info(sprintf(
                    '[CPPT] ✓ Job dispatched | cppt=%s | jobs=%d',
                    $cpptUuid, $jobCount
                ));
            } catch (\Throwable $e) {
                $this->error('[CPPT] ✗ Gagal dispatch job: ' . $e->getMessage());
            }
        }

        $this->info('[CPPT] Daemon dihentikan.');
        return self::SUCCESS;
    }

    // ── Cek trigger saat daemon baru start ──────────────────────────────────
    private function checkTriggerOnStartup(): void
    {
        try {
            $triggerExists = DB::selectOne("
                SELECT COUNT(*) as cnt
                FROM information_schema.triggers
                WHERE event_object_table = 'cppt'
                  AND trigger_name = 'trg_cppt_ss_upsert'
            ");

            if ($triggerExists && (int)$triggerExists->cnt > 0) {
                $this->info('[CPPT] ✓ Trigger trg_cppt_ss_upsert DITEMUKAN di database.');
            } else {
                $this->error('[CPPT] ✗ Trigger trg_cppt_ss_upsert TIDAK ADA di database!');
                $this->error('[CPPT]   pg_notify tidak akan pernah terpancar sampai trigger diinstall.');
                $this->error('[CPPT]   Jalankan SQL berikut di PostgreSQL:');
                $this->line('');
                $this->line("  CREATE OR REPLACE FUNCTION fn_notify_cppt_upsert()");
                $this->line("  RETURNS TRIGGER AS \$\$ BEGIN");
                $this->line("    IF NEW.asesmen IS NOT NULL AND TRIM(NEW.asesmen) <> '' THEN");
                $this->line("      PERFORM pg_notify('satusehat_cppt_upsert',");
                $this->line("        json_build_object('uuid', NEW.uuid,");
                $this->line("          'registrasi_uuid', NEW.registrasi_uuid,");
                $this->line("          'asesmen', LEFT(NEW.asesmen, 100))::text);");
                $this->line("    END IF;");
                $this->line("    RETURN NEW;");
                $this->line("  END; \$\$ LANGUAGE plpgsql;");
                $this->line("  DROP TRIGGER IF EXISTS trg_cppt_ss_upsert ON cppt;");
                $this->line("  CREATE TRIGGER trg_cppt_ss_upsert");
                $this->line("    AFTER INSERT OR UPDATE ON cppt");
                $this->line("    FOR EACH ROW EXECUTE FUNCTION fn_notify_cppt_upsert();");
                $this->line('');
                $this->warn('[CPPT] Daemon tetap jalan, menunggu jika trigger dipasang nanti.');
            }

            // Cek juga apakah kolom satusehat_observation_id sudah ada
            $colExists = DB::selectOne("
                SELECT COUNT(*) as cnt
                FROM information_schema.columns
                WHERE table_name = 'cppt'
                  AND column_name = 'satusehat_observation_id'
            ");

            if ($colExists && (int)$colExists->cnt > 0) {
                $this->info('[CPPT] ✓ Kolom satusehat_observation_id ada di tabel cppt.');
            } else {
                $this->error('[CPPT] ✗ Kolom satusehat_observation_id TIDAK ADA — jalankan: php artisan migrate');
            }

        } catch (\Throwable $e) {
            $this->warn('[CPPT] ⚠ Gagal cek trigger: ' . $e->getMessage());
        }
    }

    // ── Mode --check-trigger: hanya verifikasi lalu keluar ──────────────────
    private function runTriggerCheck(): int
    {
        $this->info('=== [CPPT] Verifikasi trigger & kolom ===');

        // Trigger
        $triggers = DB::select("
            SELECT trigger_name, event_manipulation, action_timing
            FROM information_schema.triggers
            WHERE event_object_table = 'cppt'
            ORDER BY trigger_name, event_manipulation
        ");

        if (empty($triggers)) {
            $this->error('Tidak ada trigger pada tabel cppt.');
        } else {
            $this->info('Trigger pada tabel cppt:');
            foreach ($triggers as $t) {
                $this->line("  {$t->action_timing} {$t->event_manipulation} → {$t->trigger_name}");
            }
        }

        // Fungsi
        $func = DB::selectOne("SELECT proname FROM pg_proc WHERE proname = 'fn_notify_cppt_upsert'");
        if ($func) {
            $this->info('✓ Fungsi fn_notify_cppt_upsert ADA.');
        } else {
            $this->error('✗ Fungsi fn_notify_cppt_upsert TIDAK ADA.');
        }

        // Kolom migration
        $col = DB::selectOne("
            SELECT column_name FROM information_schema.columns
            WHERE table_name = 'cppt' AND column_name = 'satusehat_observation_id'
        ");
        if ($col) {
            $this->info('✓ Kolom satusehat_observation_id ADA di tabel cppt.');
        } else {
            $this->error('✗ Kolom satusehat_observation_id TIDAK ADA — php artisan migrate belum dijalankan.');
        }

        // Sample CPPT dengan asesmen IS NOT NULL
        $sample = DB::selectOne("
            SELECT id, uuid, LEFT(asesmen, 60) as asesmen_preview,
                   satusehat_observation_status
            FROM cppt
            WHERE asesmen IS NOT NULL AND TRIM(asesmen) <> ''
            ORDER BY id DESC LIMIT 1
        ");
        if ($sample) {
            $this->info('✓ Sample CPPT dengan asesmen:');
            $this->line("  id={$sample->id} | uuid={$sample->uuid}");
            $this->line("  asesmen: {$sample->asesmen_preview}...");
            $this->line("  obs_status: " . ($sample->satusehat_observation_status ?? 'NULL'));
        } else {
            $this->warn('Tidak ada baris CPPT dengan asesmen IS NOT NULL. Trigger tidak akan pernah fire!');
        }

        return self::SUCCESS;
    }

    /**
     * Dapatkan PDO connection yang sudah dalam state LISTEN.
     */
    private function getListeningPdo(): \PDO
    {
        if ($this->listeningPdo !== null) {
            try {
                $this->listeningPdo->query('SELECT 1');
                return $this->listeningPdo;
            } catch (\Throwable) {
                $this->listeningPdo = null;
                DB::reconnect();
            }
        }

        $pdo = DB::connection()->getPdo();
        $pdo->exec('LISTEN ' . self::CHANNEL);
        $this->listeningPdo = $pdo;
        $this->info('[CPPT] ✓ Terhubung & LISTEN pada channel: ' . self::CHANNEL . ' @ ' . now()->format('H:i:s'));

        return $pdo;
    }
}
