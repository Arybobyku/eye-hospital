<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Observers\PasienObserver;
use App\Observers\RegistrasiObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * ──────────────────────────────────────────────────────────────────────────
     * STRATEGI AUTO-SYNC → SATUSEHAT (dual-layer, idempoten)
     * ──────────────────────────────────────────────────────────────────────────
     *
     * PRIMARY  : PostgreSQL LISTEN/NOTIFY (menangkap SEMUA INSERT/UPDATE dari
     *            sumber manapun — Eloquent, DB::table(), raw SQL)
     *            → Pasien    : php artisan satusehat:listen-pasien
     *            → Registrasi: php artisan satusehat:listen-registrasi
     *            → di production, gunakan Supervisor (lihat config/supervisor/)
     *
     * FALLBACK : Eloquent Observer (hanya menangkap operasi via Eloquent model)
     *            → aktif otomatis sebagai safety net jika daemon tidak berjalan
     *            → tidak double-dispatch karena setiap job idempoten:
     *                SyncPasienToSatuSehat    : cek id_satu_sehat di awal
     *                SyncEncounterToSatuSehat : cek satusehat_encounter_id di awal
     *
     * Kedua mekanisme aman dipakai bersamaan:
     *   - Daemon NOTIFY + Observer keduanya dispatch job untuk UUID yang sama
     *   - Job pertama berhasil → job kedua skip via guard di handle()
     *   - Jika daemon tidak berjalan → Observer tetap handle via Eloquent
     *   - Jika insert/update via raw DB::table() → hanya daemon yang handle
     */
    public function boot(): void
    {
        // Fallback layer: Eloquent Observers
        // Aman dipakai bersamaan dengan LISTEN daemon (semua job idempoten)
        Pasien::observe(PasienObserver::class);
        Registrasi::observe(RegistrasiObserver::class);
    }
}
