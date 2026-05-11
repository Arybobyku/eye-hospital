<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\ServiceProvider;

class SatusehatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind ReferensiController ke service container agar bisa di-inject
        $this->app->singleton(ReferensiController::class, function () {
            return new ReferensiController();
        });
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/Config/satusehat.php' => config_path('satusehat.php'),
        ], 'satusehat-config');
    }
}
