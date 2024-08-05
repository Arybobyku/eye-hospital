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
use App\Http\Controllers\CustomerServices\AntrianPasienCtrl;
use App\Http\Controllers\CustomerServices\PasienCtrl;
use App\Http\Controllers\CustomerServices\PasienActiveCtrl;
use App\Http\Controllers\CustomerServices\RegistrasiCtrl;
use App\Http\Controllers\CustomerServices\RegistrasiInapCtrl;
use App\Http\Controllers\CustomerServices\RegistrasiOdcCtrl;
use App\Http\Controllers\CustomerServices\AntrianCtrl;
use App\Http\Controllers\CustomerServices\PemeriksaanDokterCtrl;
use App\Http\Controllers\CustomerServices\RawatInapCtrl;
use App\Http\Controllers\CustomerServices\BebasCtrl;
use App\Http\Controllers\CustomerServices\ReminderKontrolCtrl;
use App\Http\Controllers\CustomerServices\PasienKontrolCtrl;
use App\Http\Controllers\CustomerServices\PasienOneDayCareCtrl;
use App\Http\Controllers\CustomerServices\PasienInapBedahCtrl;
use App\Http\Controllers\CustomerServices\HistoriRawatJalanCtrl;
use App\Http\Controllers\CustomerServices\HistoriRawatInapCtrl;
use App\Http\Controllers\CustomerServices\HistoriOneDayCareCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('antrianpasien')->group(function () {
    Route::post('list', [AntrianPasienCtrl::class, 'list'])->name('cs-antrianpasien-list');
	});
	Route::prefix('pasien')->group(function () {
		Route::post('list', [PasienCtrl::class, 'list'])->name('cs-pasien-list');
		Route::post('listkunjungan', [PasienCtrl::class, 'listkunjungan'])->name('cs-pasien-listkunjungan');
		
		Route::post('add', [PasienCtrl::class, 'add'])->name('cs-pasien-add');
		Route::post('edit', [PasienCtrl::class, 'edit'])->name('cs-pasien-edit');
		Route::get('cetakkartu/{uuid}', [PasienCtrl::class, 'pdf'])->name('cs-pasien-pdf');
		Route::get('cetaklabel/{uuid}', [PasienCtrl::class, 'label'])->name('cs-pasien-pdf');
		Route::get('cetakidentitas/{uuid}', [PasienCtrl::class, 'identitaspasien'])->name('cs-identitaspasien-pdf');

		Route::post('listpemeriksaan/{uuid}', [PasienCtrl::class, 'listpemeriksaan'])->name('cs-listpemeriksaan');

		Route::get('cetaksuratsakit/{uuid}', [PasienCtrl::class, 'cetaksuratsakit'])->name('cs-cetaksuratsakit-docx');
		Route::get('cetaksuratsehat/{uuid}', [PasienCtrl::class, 'cetaksuratsehat'])->name('cs-cetaksuratsehat-docx');
		Route::get('cetaksuratro/{uuid}', [PasienCtrl::class, 'cetaksuratro'])->name('cs-cetaksuratro-docx');

		Route::post('update', [PasienCtrl::class, 'update'])->name('cs-pasien-update');
		Route::post('detail', [PasienCtrl::class, 'detail'])->name('cs-pasien-detail');
		Route::post('uploadfile', [PasienCtrl::class, 'uploadfile'])->name('cs-pasien-uploadfile');
		Route::post('rawatjalan', [PemeriksaanDokterCtrl::class, 'rawatjalan'])->name('cs-pasien-rawatjalan');
		Route::post('suratpersetujuan', [PasienCtrl::class, 'suratpersetujuan'])->name('cs-pasien-suratpersetujuan');
		Route::get('printsuratpersetujuan/{uuid}', [PasienCtrl::class, 'printsuratpersetujuan'])->name('cs-pasien-printsuratpersetujuan');

		Route::prefix('registrasi')->group(function () {
			Route::post('page', [RegistrasiCtrl::class, 'page'])->name('cs-registrasi-page');
			Route::post('rawatjalan', [RegistrasiCtrl::class, 'rawatjalan'])->name('cs-registrasi-rawatjalan');
			Route::post('editrawatjalan', [RegistrasiCtrl::class, 'editrawatjalan'])->name('cs-registrasi-editrawatjalan');
			Route::post('cancelrawatjalan', [RegistrasiCtrl::class, 'cancelrawatjalan'])->name('cs-registrasi-cancelrawatjalan');

			Route::post('pageinap', [RegistrasiInapCtrl::class, 'pageinap'])->name('cs-registrasi-pageinap');
			Route::post('rawatinap', [RegistrasiInapCtrl::class, 'rawatinap'])->name('cs-registrasi-rawatinap');
			Route::post('editrawatinap', [RegistrasiInapCtrl::class, 'editrawatinap'])->name('cs-registrasi-editrawatinap');
			Route::post('cancelrawatinap', [RegistrasiInapCtrl::class, 'cancelrawatinap'])->name('cs-registrasi-cancelrawatinap');

			Route::post('pageodc', [RegistrasiOdcCtrl::class, 'pageodc'])->name('cs-registrasi-pageodc');
			Route::post('rawatodc', [RegistrasiOdcCtrl::class, 'rawatodc'])->name('cs-registrasi-rawatodc');
			Route::post('editrawatodc', [RegistrasiOdcCtrl::class, 'editrawatodc'])->name('cs-registrasi-editrawatodc');
			Route::post('cancelrawatodc', [RegistrasiOdcCtrl::class, 'cancelrawatodc'])->name('cs-registrasi-cancelrawatodc');
		});
	});

	Route::prefix('pasienactive')->group(function () {
		Route::post('list', [PasienActiveCtrl::class, 'list'])->name('cs-pasienactive-list');
		Route::post('listbelum', [PasienActiveCtrl::class, 'listbelum'])->name('cs-pasienactive-listbelum');
		Route::post('listsudah', [PasienActiveCtrl::class, 'listsudah'])->name('cs-pasienactive-listsudah');
		Route::post('detail', [PasienActiveCtrl::class, 'detail'])->name('cs-pasienactive-detail');
	});

	Route::prefix('historirawatjalan')->group(function () {
		Route::post('list', [HistoriRawatJalanCtrl::class, 'list'])->name('cs-historirawatjalan-list');
		Route::post('detail', [HistoriRawatJalanCtrl::class, 'detail'])->name('cs-historirawatjalan-detail');
	});

	Route::prefix('historirawatinap')->group(function () {
		Route::post('list', [HistoriRawatInapCtrl::class, 'list'])->name('cs-historirawatinap-list');
		Route::post('detail', [HistoriRawatInapCtrl::class, 'detail'])->name('cs-historirawatinap-detail');
	});

	Route::prefix('historionedaycare')->group(function () {
		Route::post('list', [HistoriOneDayCareCtrl::class, 'list'])->name('cs-historionedaycare-list');
		Route::post('detail', [HistoriOneDayCareCtrl::class, 'detail'])->name('cs-historionedaycare-detail');
	});

	Route::prefix('antrian')->group(function () {
		Route::post('list', [AntrianCtrl::class, 'list'])->name('antrian-list');
		Route::post('call', [AntrianCtrl::class, 'call'])->name('antrian-call');
		Route::post('finish', [AntrianCtrl::class, 'finish'])->name('antrian-finish');
		Route::post('lihat', [AntrianCtrl::class, 'lihat'])->name('antrian-lihat');
	});

	Route::prefix('rawatinap')->group(function () {
    Route::post('list', [RawatInapCtrl::class, 'list'])->name('cs-rawatinap-list');
    Route::post('registrasi', [RawatInapCtrl::class, 'registrasi'])->name('cs-rawatinap-registrasi');
    Route::post('pindahkamar', [RawatInapCtrl::class, 'pindahkamar'])->name('cs-rawatinap-pindahkamar');
	});

	Route::prefix('registrasirawatinap')->group(function () {
    Route::post('list', [RegistrasiRawatInapCtrl::class, 'list'])->name('cs-registrasirawatinap-list');
    Route::post('registrasi', [RegistrasiRawatInapCtrl::class, 'registrasi'])->name('cs-registrasirawatinap-registrasi');
    Route::post('pindahkamar', [RegistrasiRawatInapCtrl::class, 'pindahkamar'])->name('cs-registrasirawatinap-pindahkamar');
	});

	Route::prefix('bebas')->group(function () {
		Route::post('list', [BebasCtrl::class, 'list'])->name('cs-bebas-list');
		Route::post('add', [BebasCtrl::class, 'add'])->name('cs-bebas-add');
		Route::post('detail', [BebasCtrl::class, 'detail'])->name('cs-bebas-detail');
		Route::post('remove', [BebasCtrl::class, 'remove'])->name('cs-bebas-remove');
	});

	Route::prefix('reminderkontrol')->group(function () {
		Route::post('list', [ReminderKontrolCtrl::class, 'list'])->name('cs-reminderkontrol-list');
		Route::post('seven', [ReminderKontrolCtrl::class, 'seven'])->name('cs-reminderkontrol-seven');
		Route::post('six', [ReminderKontrolCtrl::class, 'six'])->name('cs-reminderkontrol-six');
		Route::post('five', [ReminderKontrolCtrl::class, 'five'])->name('cs-reminderkontrol-five');
		Route::post('four', [ReminderKontrolCtrl::class, 'four'])->name('cs-reminderkontrol-four');
		Route::post('three', [ReminderKontrolCtrl::class, 'three'])->name('cs-reminderkontrol-three');
		Route::post('two', [ReminderKontrolCtrl::class, 'two'])->name('cs-reminderkontrol-two');
		Route::post('one', [ReminderKontrolCtrl::class, 'one'])->name('cs-reminderkontrol-one');
		Route::post('add', [ReminderKontrolCtrl::class, 'add'])->name('cs-reminderkontrol-add');
		Route::post('detail', [ReminderKontrolCtrl::class, 'detail'])->name('cs-reminderkontrol-detail'); 
	});

	Route::prefix('pasienkontrol')->group(function () {
		Route::post('list', [PasienKontrolCtrl::class, 'list'])->name('cs-pasienkontrol-list');
		Route::post('add', [PasienKontrolCtrl::class, 'add'])->name('cs-pasienkontrol-add');
		Route::post('detail', [PasienKontrolCtrl::class, 'detail'])->name('cs-pasienkontrol-detail'); 
	});

	Route::prefix('onedaycare')->group(function () {
		Route::post('list', [PasienOneDayCareCtrl::class, 'list'])->name('onedaycare-reqopname-list');
		Route::post('approve', [PasienOneDayCareCtrl::class, 'approve'])->name('onedaycare-reqopname-approve');
		Route::post('diterima', [PasienOneDayCareCtrl::class, 'diterima'])->name('onedaycare-reqopname-diterima');
		Route::post('dikirim', [PasienOneDayCareCtrl::class, 'dikirim'])->name('onedaycare-reqopname-dikirim');
		Route::post('detail', [PasienOneDayCareCtrl::class, 'detail'])->name('onedaycare-reqopname-detail');
	});

	Route::prefix('inapbedah')->group(function () {
		Route::post('list', [PasienInapBedahCtrl::class, 'list'])->name('bedah-reqopname-list');
		Route::post('approve', [PasienInapBedahCtrl::class, 'approve'])->name('bedah-reqopname-approve');
		Route::post('diterima', [PasienInapBedahCtrl::class, 'diterima'])->name('bedah-reqopname-diterima');
		Route::post('dikirim', [PasienInapBedahCtrl::class, 'dikirim'])->name('bedah-reqopname-dikirim');
		Route::post('detail', [PasienInapBedahCtrl::class, 'detail'])->name('bedah-reqopname-detail');
	});

});