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
use App\Http\Controllers\Dokter\StockOpnameCtrl;
use App\Http\Controllers\Dokter\PemeriksaanCtrl;
use App\Http\Controllers\Dokter\PemeriksaanOdcCtrl;
use App\Http\Controllers\Dokter\CetakanCtrl;
use App\Http\Controllers\Dokter\PemeriksaanPendingCtrl;
use App\Http\Controllers\Dokter\PemeriksaanTriaseCtrl;
use App\Http\Controllers\Dokter\PemeriksaanTransferCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('stockopname')->group(function () {
		Route::post('list', [StockOpnameCtrl::class, 'list'])->name('stockopname-list');
	});

	Route::prefix('pemeriksaan')->group(function () {
		Route::post('list', [PemeriksaanCtrl::class, 'list'])->name('pemeriksaan-list');
		Route::post('listhistori', [PemeriksaanCtrl::class, 'listhistori'])->name('pemeriksaan-listhistori');
		Route::post('detail', [PemeriksaanCtrl::class, 'detail'])->name('pemeriksaan-detail');
		Route::post('cetakan', [CetakanCtrl::class, 'cetakan'])->name('pemeriksaan-cetakan');
		
		Route::post('suratistirahat', [CetakanCtrl::class, 'suratistirahat'])->name('pemeriksaan-suratistirahat');
		Route::get('printsuratistirahat/{uuid}', [CetakanCtrl::class, 'printsuratistirahat'])->name('pemeriksaan-printsuratistirahat');

		Route::post('suratkonsul', [CetakanCtrl::class, 'suratkonsul'])->name('pemeriksaan-suratkonsul');
		Route::get('printsuratkonsul/{uuid}', [CetakanCtrl::class, 'printsuratkonsul'])->name('pemeriksaan-printsuratkonsul');

		Route::post('suratbalasankonsul', [CetakanCtrl::class, 'suratbalasankonsul'])->name('pemeriksaan-suratbalasankonsul');
		Route::get('printsuratbalasankonsul/{uuid}', [CetakanCtrl::class, 'printsuratbalasankonsul'])->name('pemeriksaan-printsuratbalasankonsul');
		
		Route::post('resepkacamata', [CetakanCtrl::class, 'resepkacamatas'])->name('pemeriksaan-resepkacamata');
		Route::get('printresepkacamata/{uuid}', [CetakanCtrl::class, 'printresepkacamata'])->name('pemeriksaan-printresepkacamata');

		Route::post('add', [PemeriksaanCtrl::class, 'add'])->name('pemeriksaan-add');
		Route::post('histori', [PemeriksaanCtrl::class, 'histori'])->name('pemeriksaan-histori');
		Route::post('call', [PemeriksaanCtrl::class, 'call'])->name('pemeriksaan-call');
		Route::post('allcppt', [PemeriksaanCtrl::class, 'allcppt'])->name('pemeriksaan-allcppt');

		Route::post('adddatatransfer', [PemeriksaanTransferCtrl::class, 'add'])->name('pemeriksaan-adddatatransfer');

		Route::post('listpending', [PemeriksaanPendingCtrl::class, 'list'])->name('pemeriksaan-listpending');
		Route::post('listtriase', [PemeriksaanTriaseCtrl::class, 'list'])->name('pemeriksaan-listtriase');
		Route::post('listtransfer', [PemeriksaanTransferCtrl::class, 'list'])->name('pemeriksaan-listtransfer');
		Route::post('detailtransfer', [PemeriksaanTransferCtrl::class, 'detail'])->name('pemeriksaan-detailtransfer');

		// Pemeriksaan Penunjang
		Route::post('set-penunjang', [PemeriksaanCtrl::class, 'setPemeriksaanPenunjang'])->name('pemeriksaan-set-penunjang');
		Route::post('list-penunjang', [PemeriksaanCtrl::class, 'listPemeriksaanPenunjang'])->name('pemeriksaan-list-penunjang');
		Route::post('detail-penunjang', [PemeriksaanCtrl::class, 'detailPenunjang'])->name('pemeriksaan-detail-penunjang');
		Route::post('set-sudah-upload-penunjang', [PemeriksaanCtrl::class, 'setSudahUploadPenunjang'])->name('pemeriksaan-set-sudah-upload-penunjang');
		Route::post('batalkan-penunjang', [PemeriksaanCtrl::class, 'batalkanPenunjang'])->name('pemeriksaan-batalkan-penunjang');
	});

	Route::prefix('pemeriksaanodc')->group(function () {
		Route::post('list', [PemeriksaanOdcCtrl::class, 'list'])->name('pemeriksaan-list');
		Route::post('detail', [PemeriksaanOdcCtrl::class, 'detail'])->name('pemeriksaan-detail');
		Route::post('cetakan', [CetakanCtrl::class, 'cetakan'])->name('pemeriksaan-cetakan');
		
		Route::post('suratistirahat', [CetakanCtrl::class, 'suratistirahat'])->name('pemeriksaan-suratistirahat');
		Route::get('printsuratistirahat/{uuid}', [CetakanCtrl::class, 'printsuratistirahat'])->name('pemeriksaan-printsuratistirahat');

		Route::post('suratkonsul', [CetakanCtrl::class, 'suratkonsul'])->name('pemeriksaan-suratkonsul');
		Route::get('printsuratkonsul/{uuid}', [CetakanCtrl::class, 'printsuratkonsul'])->name('pemeriksaan-printsuratkonsul');

		Route::post('suratbalasankonsul', [CetakanCtrl::class, 'suratbalasankonsul'])->name('pemeriksaan-suratbalasankonsul');
		Route::get('printsuratbalasankonsul/{uuid}', [CetakanCtrl::class, 'printsuratbalasankonsul'])->name('pemeriksaan-printsuratbalasankonsul');
		
		Route::post('resepkacamata', [CetakanCtrl::class, 'resepkacamatas'])->name('pemeriksaan-resepkacamata');
		Route::get('printresepkacamata/{uuid}', [CetakanCtrl::class, 'printresepkacamata'])->name('pemeriksaan-printresepkacamata');

		Route::post('add', [PemeriksaanOdcCtrl::class, 'add'])->name('pemeriksaan-add');
		Route::post('histori', [PemeriksaanOdcCtrl::class, 'histori'])->name('pemeriksaan-histori');
		Route::post('call', [PemeriksaanOdcCtrl::class, 'call'])->name('pemeriksaan-call');

		Route::post('listpending', [PemeriksaanPendingCtrl::class, 'list'])->name('pemeriksaan-listpending');
		Route::post('listtriase', [PemeriksaanTriaseCtrl::class, 'list'])->name('pemeriksaan-listtriase');
		Route::post('listtransfer', [PemeriksaanTransferCtrl::class, 'list'])->name('pemeriksaan-listtransfer');
		Route::post('detailtransfer', [PemeriksaanTransferCtrl::class, 'detail'])->name('pemeriksaan-detailtransfer');
	});

});