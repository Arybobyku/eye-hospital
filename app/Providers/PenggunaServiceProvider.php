<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PenggunaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      require_once app_path() . '/Helpers/Pengguna.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
