<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Bpjs\DiagnosaCtrl;
use App\Http\Controllers\Bpjs\DokterCtrl;
use App\Http\Controllers\Bpjs\AntrolController;


Route::group(['middleware' => 'throttle: 250, 1'], function () {

    Route::prefix('diagnosa')->group(function () {
        Route::post('list', [DiagnosaCtrl::class, 'list'])->name('bpjs-diagnosa-list');
    });

    Route::prefix('dokter')->group(function () {
        Route::post('list', [DokterCtrl::class, 'list'])->name('bpjs-dokter-list');
    });

    Route::prefix('antrol')->group(function () {
        Route::get('referensi-poli', [AntrolController::class, 'getReferensiPoli']);
        Route::get('referensi-dokter', [AntrolController::class, 'getReferensiDokter']);
        Route::get('referensi-jadwal-dokter', [AntrolController::class, 'getReferensiJadwalDokter']);
        Route::get('antrean/pendaftaran/aktif', [AntrolController::class, 'getAntreanBelumDilayani']);
        Route::get('antrean/pendaftaran/kodebooking/{kodebooking}', [AntrolController::class, 'getAntreanPerKodeBooking']);
        Route::get('antrian', [AntrolController::class, 'getAntrian']);
    });
});