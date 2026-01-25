<?php

use App\Http\Controllers\Master\RekamMedisCtrl;
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
		Route::post('list', [PasienCtrl::class, 'list'])->name('master-pasien-list');;
		Route::get('listexcel', [PasienCtrl::class, 'listexcel'])->name('master-pasien-listexcel');
		Route::post('obat', [PasienCtrl::class, 'obat'])->name('master-pasien-obat');
		Route::post('tindakan', [PasienCtrl::class, 'tindakan'])->name('master-pasien-tindakan');
		Route::post('kunjungan', [PasienCtrl::class, 'kunjungan'])->name('master-pasien-kunjungan');

		// RME

		//master
		Route::post('tindakan-pasien', [PasienCtrl::class, 'tindakanPasien'])->name('master-pasien-tindakan');
		Route::post('tanda-umum-pasien', [PasienCtrl::class, 'tandaUmumPasien'])->name('master-pasien-tanda-umum-pasien');
		Route::post('history', [PasienCtrl::class, 'history'])->name('master-pasien-history');
		Route::post('search', [PasienCtrl::class, 'search'])->name('master-pasien-search');
		Route::post('soap', [PasienCtrl::class, 'soap'])->name('master-pasien-soap');
		
		//Report
		Route::post('listobat', [PasienCtrl::class, 'listobat'])->name('report-pasien-listobat');
		Route::post('detailobat', [PasienCtrl::class, 'detailobat'])->name('report-pasien-detailobat');
		
		Route::post('listbillpembayaran', [PasienCtrl::class, 'listBillPembayaran'])->name('report-pasien-listbillpembayaran');

	});


});