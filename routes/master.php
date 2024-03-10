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
use App\Http\Controllers\Master\PasienCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){
	Route::prefix('pasien')->group(function () {
		Route::post('list', [PasienCtrl::class, 'list'])->name('master-pasien-list');
		Route::post('obat', [PasienCtrl::class, 'obat'])->name('master-pasien-obat');
		Route::post('tindakan', [PasienCtrl::class, 'tindakan'])->name('master-pasien-tindakan');
		Route::post('kunjungan', [PasienCtrl::class, 'kunjungan'])->name('master-pasien-kunjungan');
	});
});