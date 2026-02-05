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
use App\Http\Controllers\Laporan\LaporanFarmasiCtrl;
use App\Http\Controllers\Laporan\LaporanKeuanganCtrl;
use App\Http\Controllers\Laporan\LaporanFakturObatCtrl;
use App\Http\Controllers\Laporan\LaporanKontrolCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	
	Route::get('excel/penjualanapotek/{dari}/{ke}/{dokter_uuid}', [LaporanFarmasiCtrl::class, 'penjualanapotek'])->name('laporan-penjualanapotek');
	Route::get('excel/kartustockgudang/{dari}/{ke}/{obatuuid}', [LaporanFarmasiCtrl::class, 'kartustockgudang'])->name('laporan-kartustockgudang');
	Route::get('excel/kartustockbedah/{dari}/{ke}/{dokter_uuid}', [LaporanFarmasiCtrl::class, 'kartustockbedah'])->name('laporan-kartustockbedah');
	Route::get('excel/kartustockapotek/{dari}/{ke}/{dokter_uuid}', [LaporanFarmasiCtrl::class, 'kartustockapotek'])->name('laporan-kartustockapotek');
	Route::get('excel/fakturgudang/{dari}/{ke}/{supplier_uuid}', [LaporanFarmasiCtrl::class, 'fakturgudang'])->name('laporan-fakturgudang');
	Route::get('excel/stockopnameapotek/{dari}', [LaporanFarmasiCtrl::class, 'stockopnameapotek'])->name('laporan-stockopnameapotek');
	Route::get('excel/stockopnamegudang/{dari}', [LaporanFarmasiCtrl::class, 'stockopnamegudang'])->name('laporan-stockopnamegudang');
	Route::get('excel/stockopnamebedah/{dari}', [LaporanFarmasiCtrl::class, 'stockopnamebedah'])->name('laporan-stockopnamebedah');
	Route::get('excel/returgudang/{dari}/{ke}/{supplier_uuid}', [LaporanFarmasiCtrl::class, 'returgudang'])->name('laporan-returgudang');

	Route::get('excel/tindakan/{dari}/{ke}/{carabayar_uuid}/{asuransi_uuid}/{dokter_uuid}/{layanan_uuid}', [LaporanKeuanganCtrl::class, 'tindakan'])->name('laporan-tindakan');
	Route::get('excel/tindakan-v2/{dari}/{ke}/{carabayar_uuid}/{asuransi_uuid}/{dokter_uuid}/{layanan_uuid}', [LaporanKeuanganCtrl::class, 'tindakanv2'])->name('laporan-tindakan');
	Route::get('excel/kontrol/{dari}/{ke}/{carabayar_uuid}/{asuransi_uuid}/{dokter_uuid}/{layanan_uuid}', [LaporanKontrolCtrl::class, 'registrasi'])->name('laporan-kontrol');
	Route::get('excel/registrasi/{dari}/{ke}/{carabayar_uuid}/{asuransi_uuid}/{dokter_uuid}', [LaporanKeuanganCtrl::class, 'registrasi'])->name('laporan-registrasi');

	Route::post('fakturobat', [LaporanFakturObatCtrl::class, 'datapage'])->name('laporan-fakturobat');
	Route::get('excelfakturobat/{dari}', [LaporanFakturObatCtrl::class, 'dataexcel'])->name('laporan-excelfakturobat');
	Route::post('amprahan', [LaporanPenjualanApotekCtrl::class, 'penjualanapotek'])->name('laporan-amprahan');
	Route::post('tindakan', [LaporanPenjualanApotekCtrl::class, 'penjualanapotek'])->name('laporan-tindakan');

});