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
use App\Http\Controllers\Asuransi\PasienOneDayCareCtrl;
use App\Http\Controllers\Asuransi\PasienInapBedahCtrl;
use App\Http\Controllers\Asuransi\PasienRawatJalanCtrl;
use App\Http\Controllers\Asuransi\OneDayCareActiveCtrl;
use App\Http\Controllers\Asuransi\InapBedahActiveCtrl;
use App\Http\Controllers\Asuransi\CetakanCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('onedaycare')->group(function () {
		Route::post('list', [PasienOneDayCareCtrl::class, 'list'])->name('onedaycare-reqopname-list');
		Route::post('approve', [PasienOneDayCareCtrl::class, 'approve'])->name('onedaycare-reqopname-approve');
		Route::post('deny', [PasienOneDayCareCtrl::class, 'deny'])->name('onedaycare-reqopname-deny');
		Route::post('diterima', [PasienOneDayCareCtrl::class, 'diterima'])->name('onedaycare-reqopname-diterima');
		Route::post('dikirim', [PasienOneDayCareCtrl::class, 'dikirim'])->name('onedaycare-reqopname-dikirim');
		Route::post('detail', [PasienOneDayCareCtrl::class, 'detail'])->name('onedaycare-reqopname-detail');
	});

	Route::prefix('inapbedah')->group(function () {
		Route::post('list', [PasienInapBedahCtrl::class, 'list'])->name('bedah-reqopname-list');
		Route::post('approve', [PasienInapBedahCtrl::class, 'approve'])->name('bedah-reqopname-approve');
		Route::post('deny', [PasienInapBedahCtrl::class, 'deny'])->name('bedah-reqopname-deny');
		Route::post('diterima', [PasienInapBedahCtrl::class, 'diterima'])->name('bedah-reqopname-diterima');
		Route::post('dikirim', [PasienInapBedahCtrl::class, 'dikirim'])->name('bedah-reqopname-dikirim');
		Route::post('detail', [PasienInapBedahCtrl::class, 'detail'])->name('bedah-reqopname-detail');
	});

	Route::prefix('rawatjalan')->group(function () {
		Route::post('list', [PasienRawatJalanCtrl::class, 'list'])->name('asuransi-rawatjalan-list');
		Route::post('edit', [PasienRawatJalanCtrl::class, 'edit'])->name('asuransi-rawatjalan-edit');
		Route::post('update', [PasienRawatJalanCtrl::class, 'update'])->name('asuransi-rawatjalan-update');
		Route::post('disetujui', [PasienRawatJalanCtrl::class, 'disetujui'])->name('asuransi-rawatjalan-disetujui');
	});

	Route::prefix('activeonedaycare')->group(function () {
		Route::post('list', [OneDayCareActiveCtrl::class, 'list'])->name('asuransi-rawatjalan-list');
		Route::post('edit', [OneDayCareActiveCtrl::class, 'edit'])->name('asuransi-rawatjalan-edit');
		Route::post('update', [OneDayCareActiveCtrl::class, 'update'])->name('asuransi-rawatjalan-update');
		Route::post('disetujui', [OneDayCareActiveCtrl::class, 'disetujui'])->name('asuransi-rawatjalan-disetujui');
	});

	Route::prefix('activeinapbedah')->group(function () {
		Route::post('list', [InapBedahActiveCtrl::class, 'list'])->name('asuransi-rawatjalan-list');
		Route::post('edit', [InapBedahActiveCtrl::class, 'edit'])->name('asuransi-rawatjalan-edit');
		Route::post('update', [InapBedahActiveCtrl::class, 'update'])->name('asuransi-rawatjalan-update');
		Route::post('disetujui', [InapBedahActiveCtrl::class, 'disetujui'])->name('asuransi-rawatjalan-disetujui');
	});

	Route::prefix('cetakan')->group(function () {
    Route::get('printsuratistirahat/{uuid}', [CetakanCtrl::class, 'printsuratistirahat'])->name('pemeriksaan-printsuratistirahat');
    Route::get('printsuratkonsul/{uuid}', [CetakanCtrl::class, 'printsuratkonsul'])->name('pemeriksaan-printsuratkonsul');
    Route::get('printsuratbalasankonsul/{uuid}', [CetakanCtrl::class, 'printsuratbalasankonsul'])->name('pemeriksaan-printsuratbalasankonsul');
    Route::get('printresepkacamata/{uuid}', [CetakanCtrl::class, 'printresepkacamata'])->name('pemeriksaan-printresepkacamata');
});

});