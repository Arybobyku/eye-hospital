<?php

use App\Models\Cppt;
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
use App\Http\Controllers\RawatJalan\StockOpnameCtrl;
use App\Http\Controllers\RawatJalan\PemeriksaanCtrl;
use App\Http\Controllers\RawatJalan\HistoriPemeriksaanCtrl;
use App\Http\Controllers\RawatJalan\PasienKontrolCtrl;
use App\Http\Controllers\RawatJalan\ReqOpnameCtrl;
use App\Http\Controllers\RawatJalan\PasienCtrl;
use App\Http\Controllers\RawatJalan\TransferCtrl;
use App\Http\Controllers\RawatJalan\PemeriksaanBedahCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('pemeriksaan')->group(function () {
		Route::post('list', [PemeriksaanCtrl::class, 'list'])->name('pemeriksaan-list');
		Route::post('detail', [PemeriksaanCtrl::class, 'detail'])->name('pemeriksaan-detail');
		Route::post('detailperawat', [PemeriksaanCtrl::class, 'detailperawat'])->name('pemeriksaan-detailperawat');
		Route::post('add', [PemeriksaanCtrl::class, 'add'])->name('pemeriksaan-add');
		Route::post('addperawat', [PemeriksaanCtrl::class, 'addperawat'])->name('pemeriksaan-addperawat');
		Route::post('histori', [PemeriksaanCtrl::class, 'histori'])->name('pemeriksaan-histori');
		Route::post('call', [PemeriksaanCtrl::class, 'call'])->name('pemeriksaan-call');
	});

	Route::prefix('historipemeriksaan')->group(function () {
		Route::post('list', [HistoriPemeriksaanCtrl::class, 'list'])->name('historipemeriksaan-list');
		Route::post('detail', [HistoriPemeriksaanCtrl::class, 'detail'])->name('historipemeriksaan-detail');
		Route::post('add', [HistoriPemeriksaanCtrl::class, 'add'])->name('historipemeriksaan-add');
		Route::post('histori', [HistoriPemeriksaanCtrl::class, 'histori'])->name('historipemeriksaan-histori');
	});

	Route::prefix('pemeriksaanbedah')->group(function () {
		Route::post('list', [PemeriksaanBedahCtrl::class, 'list'])->name('pemeriksaanbedah-list');
		Route::post('detail', [PemeriksaanBedahCtrl::class, 'detail'])->name('pemeriksaanbedah-detail');
		Route::post('add', [PemeriksaanBedahCtrl::class, 'add'])->name('pemeriksaanbedah-add');
		Route::post('histori', [PemeriksaanBedahCtrl::class, 'histori'])->name('pemeriksaanbedah-histori');
		Route::post('call', [PemeriksaanBedahCtrl::class, 'call'])->name('pemeriksaanbedah-call');
	});

	Route::prefix('pasienkontrol')->group(function () {
		Route::post('list', [PasienKontrolCtrl::class, 'list'])->name('cs-pasienkontrol-list');
		Route::post('add', [PasienKontrolCtrl::class, 'add'])->name('cs-pasienkontrol-add');
		Route::post('detail', [PasienKontrolCtrl::class, 'detail'])->name('cs-pasienkontrol-detail'); 
	});

	Route::prefix('stockopname')->group(function () {
		Route::post('list', [StockOpnameCtrl::class, 'list'])->name('rj-stockopname-list');
		Route::post('ambil', [StockOpnameCtrl::class, 'ambil'])->name('rj-stockopname-ambil');
		Route::post('kembali', [StockOpnameCtrl::class, 'kembali'])->name('rj-stockopname-kembali');
	});

	Route::prefix('reqopname')->group(function () {
		Route::post('list', [ReqOpnameCtrl::class, 'list'])->name('rj-reqopname-list');
		Route::post('detail', [ReqOpnameCtrl::class, 'detail'])->name('rj-reqopname-detail');
		Route::post('minta', [ReqOpnameCtrl::class, 'minta'])->name('rj-reqopname-minta');
		Route::post('terima', [ReqOpnameCtrl::class, 'terima'])->name('rj-reqopname-terima');
		Route::post('batal', [ReqOpnameCtrl::class, 'batal'])->name('rj-reqopname-batal');
	});

	Route::prefix('pasien')->group(function () {
		Route::post('getjadwalkontrol', [PasienCtrl::class, 'getjadwalkontrol'])->name('pemeriksaan-getjadwalkontrol');
		Route::post('addjadwalkontrol', [PasienCtrl::class, 'addjadwalkontrol'])->name('pemeriksaan-addjadwalkontrol');
	});

	Route::prefix('transfer')->group(function () {
		Route::post('gettransfer', [TransferCtrl::class, 'gettransfer'])->name('pemeriksaan-gettransfer');
		Route::post('addtransfer', [TransferCtrl::class, 'addtransfer'])->name('pemeriksaan-addtransfer');
		Route::post('removetransfer', [TransferCtrl::class, 'removetransfer'])->name('pemeriksaan-removetransfer');
	});

	

});