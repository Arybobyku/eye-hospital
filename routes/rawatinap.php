<?php

use App\Http\Controllers\RawatInap\PasienCtrl;
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
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'throttle: 250, 1'], function () {
    Route::prefix('pasien')->group(function () {
        Route::post('list', [PasienCtrl::class, 'list'])->name('pemeriksaan-list');
        Route::post('add', [PasienCtrl::class, 'add'])->name('pemeriksaan-add');
        Route::post('remove', [PasienCtrl::class, 'remove'])->name('pemeriksaan-remove');
        Route::post('getlayanan', [PasienCtrl::class, 'getlayanan'])->name('pemeriksaan-getlayanan');
        Route::post('getobat', [PasienCtrl::class, 'getobat'])->name('pemeriksaan-getobat');
        Route::post('getresep', [PasienCtrl::class, 'getresep'])->name('pemeriksaan-getresep');
        Route::post('getjadwalkontrol', [PasienCtrl::class, 'getjadwalkontrol'])->name('pemeriksaan-getjadwalkontrol');
        Route::post('getpaket', [PasienCtrl::class, 'getpaket'])->name('pemeriksaan-getpaket');
        Route::post('addobat', [PasienCtrl::class, 'addobat'])->name('pemeriksaan-addobat');
        Route::post('addresep', [PasienCtrl::class, 'addresep'])->name('pemeriksaan-addresep');
        Route::post('addjadwalkontrol', [PasienCtrl::class, 'addjadwalkontrol'])->name('pemeriksaan-addjadwalkontrol');
        Route::post('addpaket', [PasienCtrl::class, 'addpaket'])->name('pemeriksaan-addpaket');
        Route::post('removeobat', [PasienCtrl::class, 'removeobat'])->name('pemeriksaan-removeobat');
        Route::post('pulang', [PasienCtrl::class, 'pulang'])->name('pemeriksaan-pulang');
        Route::post('pulangdata', [PasienCtrl::class, 'pulangdata'])->name('pemeriksaan-pulangdata');
    });
});
