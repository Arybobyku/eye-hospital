<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        /**
         * Sync ID SatuSehat (IHS Number) untuk pasien berdasarkan NIK.
         * Berjalan setiap jam — hanya memproses pasien yang belum di-sync.
         * Pasien dengan status 'synced' atau 'not_found' dilewati secara permanen.
         */
        $schedule->command('satusehat:sync-patient --batch=50 --delay=300')
                 ->hourly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/satusehat-sync-patient.log'));

        /**
         * Sync Encounter (kunjungan) ke SatuSehat.
         * Berjalan setiap 30 menit — mendorong registrasi pending ke API SatuSehat.
         * Hanya memproses yang status NULL atau 'failed'.
         * Registrasi yang pasiennya belum sync dilewati dan dicoba kembali berikutnya.
         */
        $schedule->command('satusehat:sync-encounter --batch=30 --delay=300')
                 ->everyThirtyMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/satusehat-sync-encounter.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
