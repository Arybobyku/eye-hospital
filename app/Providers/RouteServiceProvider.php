<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * The path to your application's "home" route.
   *
   * Typically, users are redirected here after authentication.
   *
   * @var string
   */
  public const HOME = '/home';

  /**
   * Define your route model bindings, pattern filters, and other route configuration.
   */
  public function boot(): void
  {
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    $this->routes(function () {
      Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

      Route::middleware('web')
        ->group(base_path('routes/web.php'));

      Route::middleware('web')
        ->prefix('administration')
        ->group(base_path('routes/administration.php'));

      Route::middleware('web')
        ->prefix('laporan')
        ->group(base_path('routes/laporan.php'));

      Route::middleware('web')
        ->prefix('gudang')
        ->group(base_path('routes/gudang.php'));

      Route::middleware('web')
        ->prefix('print')
        ->group(base_path('routes/print.php'));

      Route::middleware('web')
        ->prefix('bedah')
        ->group(base_path('routes/bedah.php'));

      Route::middleware('web')
        ->prefix('asuransi')
        ->group(base_path('routes/asuransi.php'));

      Route::middleware('web')
        ->prefix('rawatjalan')
        ->group(base_path('routes/rawatjalan.php'));

      Route::middleware('web')
        ->prefix('rawatinap')
        ->group(base_path('routes/rawatinap.php'));

      Route::middleware('web')
        ->prefix('customerservices')
        ->group(base_path('routes/customerservices.php'));

      Route::middleware('web')
        ->prefix('igd')
        ->group(base_path('routes/igd.php'));

      Route::middleware('web')
        ->prefix('finance')
        ->group(base_path('routes/finance.php'));

      Route::middleware('web')
        ->prefix('apotek')
        ->group(base_path('routes/apotek.php'));

      Route::middleware('web')
        ->prefix('dokter')
        ->group(base_path('routes/dokter.php'));

      Route::middleware('web')
        ->prefix('preview')
        ->group(base_path('routes/preview.php'));

      Route::middleware('web')
        ->prefix('master')
        ->group(base_path('routes/master.php'));

      Route::middleware('web')
        ->prefix('bpjs')
        ->group(base_path('routes/bpjs.php'));
    });
  }
}
