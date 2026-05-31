<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * ListenAllSatuSehat — Wrapper development yang menjalankan ketiga daemon
 * LISTEN SatuSehat secara paralel dalam satu terminal.
 *
 * Cara menjalankan (development):
 *   php artisan satusehat:listen-all
 *
 * Output masing-masing daemon ditampilkan dengan prefix warna berbeda:
 *   [PASIEN]      → cyan
 *   [REGISTRASI]  → green
 *   [CAREPLAN]    → yellow
 *
 * CATATAN: Command ini hanya untuk development / debugging.
 * Di production gunakan Supervisor (config/supervisor/satusehat-group.conf).
 *
 * Signal handling:
 *   CTRL+C (SIGINT) → kirim SIGTERM ke semua child process, tunggu graceful exit
 */
class ListenAllSatuSehat extends Command
{
    protected $signature = 'satusehat:listen-all
                            {--timeout=5000  : Timeout polling pg_notify dalam milidetik}
                            {--max-jobs=1000 : Restart daemon setelah N job agar tidak memory leak}
                            {--no-queue      : Jangan jalankan queue:work (jika sudah ada worker terpisah)}';

    protected $description = 'Jalankan semua daemon SatuSehat listener (pasien, registrasi, careplan) secara paralel';

    /** @var Process[] */
    private array $processes = [];

    private bool $shouldStop = false;

    public function handle(): int
    {
        $timeout  = (int) $this->option('timeout');
        $maxJobs  = (int) $this->option('max-jobs');
        $php      = PHP_BINARY;
        $artisan  = base_path('artisan');

        // ── Definisi daemon ──────────────────────────────────────────────────
        $daemons = [
            [
                'label'   => 'PASIEN',
                'color'   => 'cyan',
                'command' => "$php $artisan satusehat:listen-pasien --timeout=$timeout --max-jobs=$maxJobs",
            ],
            [
                'label'   => 'REGISTRASI',
                'color'   => 'green',
                'command' => "$php $artisan satusehat:listen-registrasi --timeout=$timeout --max-jobs=$maxJobs",
            ],
            // [
            //     'label'   => 'CAREPLAN',
            //     'color'   => 'yellow',
            //     'command' => "$php $artisan satusehat:listen-careplan --timeout=$timeout --max-jobs=$maxJobs",
            // ],
            [
                'label'   => 'CPPT',
                'color'   => 'blue',
                'command' => "$php $artisan satusehat:listen-cppt --timeout=$timeout --max-jobs=$maxJobs",
            ],
        ];

        // Tambahkan queue:work jika QUEUE_CONNECTION=database dan flag --no-queue tidak aktif
        // Queue worker WAJIB berjalan agar job SyncEncounterToSatuSehat, SyncPasienToSatuSehat,
        // SyncCarePlanToSatuSehat dapat dieksekusi (QUEUE_CONNECTION=database → job disimpan ke tabel jobs)
        if (!$this->option('no-queue')) {
            $daemons[] = [
                'label'   => 'QUEUE',
                'color'   => 'magenta',
                'command' => "$php $artisan queue:work --queue=default --tries=3 --max-jobs=$maxJobs --sleep=3",
            ];
        }

        // ── Banner ────────────────────────────────────────────────────────────
        $this->newLine();
        $this->line('<fg=white;bg=blue;options=bold> SATUSEHAT LISTENER — ALL DAEMONS </> ' . now()->format('Y-m-d H:i:s'));
        $this->newLine();

        foreach ($daemons as $d) {
            $this->line("<fg={$d['color']};options=bold>[{$d['label']}]</> {$d['command']}");
        }

        $this->newLine();
        $this->line('<fg=gray>Tekan CTRL+C untuk menghentikan semua daemon secara graceful.</>');
        $this->line('<fg=gray>─────────────────────────────────────────────────────────────</>');
        $this->newLine();

        // ── Daftarkan signal handler ──────────────────────────────────────────
        if (extension_loaded('pcntl')) {
            pcntl_async_signals(true);

            $stopAll = function () {
                $this->shouldStop = true;
                $this->newLine();
                $this->line('<fg=red;options=bold>Signal diterima — menghentikan semua daemon...</>');
                foreach ($this->processes as $proc) {
                    if ($proc->isRunning()) {
                        $proc->stop(10, SIGTERM);
                    }
                }
            };

            pcntl_signal(SIGTERM, $stopAll);
            pcntl_signal(SIGINT,  $stopAll);
        }

        // ── Start semua proses ────────────────────────────────────────────────
        foreach ($daemons as $d) {
            $process = Process::fromShellCommandline($d['command'], base_path(), null, null, null);
            $process->start();
            $this->processes[] = ['proc' => $process, 'label' => $d['label'], 'color' => $d['color']];
            $this->line("<fg={$d['color']};options=bold>[{$d['label']}]</> <fg=gray>PID {$process->getPid()} — daemon started</>");
        }

        $this->newLine();

        // ── Loop: baca output dan pantau proses ───────────────────────────────
        while (!$this->shouldStop) {
            $anyRunning = false;

            foreach ($this->processes as &$entry) {
                /** @var Process $proc */
                $proc  = $entry['proc'];
                $label = $entry['label'];
                $color = $entry['color'];

                // Baca output baru
                $out = $proc->getIncrementalOutput();
                $err = $proc->getIncrementalErrorOutput();

                if ($out !== '') {
                    foreach (explode("\n", rtrim($out)) as $line) {
                        if ($line !== '') {
                            $this->line("<fg={$color};options=bold>[{$label}]</> $line");
                        }
                    }
                }

                if ($err !== '') {
                    foreach (explode("\n", rtrim($err)) as $line) {
                        if ($line !== '') {
                            $this->line("<fg={$color};options=bold>[{$label}]</> <fg=red>$line</>");
                        }
                    }
                }

                if ($proc->isRunning()) {
                    $anyRunning = true;
                } else {
                    // Proses mati — restart otomatis jika belum diminta stop
                    if (!$this->shouldStop) {
                        $exitCode = $proc->getExitCode();
                        $this->line("<fg={$color};options=bold>[{$label}]</> <fg=yellow>Proses berhenti (exit {$exitCode}), restart dalam 3 detik...</>");
                        sleep(3);

                        $newProc = Process::fromShellCommandline($entry['cmd'] ?? $proc->getCommandLine(), base_path(), null, null, null);
                        $newProc->start();
                        $entry['proc'] = $newProc;
                        $anyRunning    = true;
                        $this->line("<fg={$color};options=bold>[{$label}]</> <fg=gray>PID {$newProc->getPid()} — daemon restarted</>");
                    }
                }
            }
            unset($entry);

            if (!$anyRunning) {
                break;
            }

            usleep(200_000); // polling tiap 200ms
        }

        // ── Pastikan semua berhenti ───────────────────────────────────────────
        foreach ($this->processes as $entry) {
            if ($entry['proc']->isRunning()) {
                $entry['proc']->stop(10, SIGTERM);
            }
        }

        $this->newLine();
        $this->line('<fg=white;options=bold>Semua daemon SatuSehat telah dihentikan.</>');

        return Command::SUCCESS;
    }
}
