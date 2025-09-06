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

use App\Http\Controllers\Administration\HistoriCtrl;
use App\Http\Controllers\Administration\TrackCtrl;
use App\Http\Controllers\Administration\LabelCtrl;
use App\Http\Controllers\Administration\UnitCtrl;
use App\Http\Controllers\Administration\Icd9Ctrl;	
use App\Http\Controllers\Administration\Icd10Ctrl;
use App\Http\Controllers\Administration\RuanganCtrl;
use App\Http\Controllers\Administration\ProvinsiCtrl;
use App\Http\Controllers\Administration\KabKotaCtrl;
use App\Http\Controllers\Administration\KecamatanCtrl;
use App\Http\Controllers\Administration\KelurahanCtrl;
use App\Http\Controllers\Administration\PenggunaCtrl;
use App\Http\Controllers\Administration\JenisKamarCtrl;
use App\Http\Controllers\Administration\KamarInapCtrl;
use App\Http\Controllers\Administration\TindakanRawatJalanCtrl;
use App\Http\Controllers\Administration\TindakanNonBedahCtrl;
use App\Http\Controllers\Administration\TindakanBedahCtrl;
use App\Http\Controllers\Administration\RunningTextCtrl;
use App\Http\Controllers\Administration\RunningImageCtrl;
use App\Http\Controllers\Administration\PemeriksaanOdcCtrl;


Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('histori')->group(function () {
		Route::post('list', [HistoriCtrl::class, 'list'])->name('histori-list');
	});

	Route::prefix('track')->group(function () {
		Route::post('list', [TrackCtrl::class, 'list'])->name('track-list');
	});

	Route::prefix('tindakanrawatjalan')->group(function () {
		Route::post('list', [TindakanRawatJalanCtrl::class, 'list'])->name('tindakanrawatjalan-list');
		Route::post('add', [TindakanRawatJalanCtrl::class, 'add'])->name('tindakanrawatjalan-add');
		Route::post('edit', [TindakanRawatJalanCtrl::class, 'edit'])->name('tindakanrawatjalan-edit');
		Route::post('update', [TindakanRawatJalanCtrl::class, 'update'])->name('tindakanrawatjalan-update');
		Route::post('remove', [TindakanRawatJalanCtrl::class, 'remove'])->name('tindakanrawatjalan-remove');
		Route::post('api', [TindakanRawatJalanCtrl::class, 'api'])->name('tindakanrawatjalan-api');
	});

	Route::prefix('tindakannonbedah')->group(function () {
		Route::post('list', [TindakanNonBedahCtrl::class, 'list'])->name('tindakannonbedah-list');
		Route::post('add', [TindakanNonBedahCtrl::class, 'add'])->name('tindakannonbedah-add');
		Route::post('edit', [TindakanNonBedahCtrl::class, 'edit'])->name('tindakannonbedah-edit');
		Route::post('update', [TindakanNonBedahCtrl::class, 'update'])->name('tindakannonbedah-update');
		Route::post('remove', [TindakanNonBedahCtrl::class, 'remove'])->name('tindakannonbedah-remove');
		Route::post('api', [TindakanNonBedahCtrl::class, 'api'])->name('tindakannonbedah-api');
	});

	Route::prefix('tindakanbedah')->group(function () {
		Route::post('list', [TindakanBedahCtrl::class, 'list'])->name('tindakanbedah-list');
		Route::post('add', [TindakanBedahCtrl::class, 'add'])->name('tindakanbedah-add');
		Route::post('edit', [TindakanBedahCtrl::class, 'edit'])->name('tindakanbedah-edit');
		Route::post('update', [TindakanBedahCtrl::class, 'update'])->name('tindakanbedah-update');
		Route::post('remove', [TindakanBedahCtrl::class, 'remove'])->name('tindakanbedah-remove');
		Route::post('api', [TindakanBedahCtrl::class, 'api'])->name('tindakanbedah-api');
	});

	Route::prefix('jeniskamar')->group(function () {
		Route::post('list', [JenisKamarCtrl::class, 'list'])->name('jeniskamar-list');
		Route::post('add', [JenisKamarCtrl::class, 'add'])->name('jeniskamar-add');
		Route::post('edit', [JenisKamarCtrl::class, 'edit'])->name('jeniskamar-edit');
		Route::post('update', [JenisKamarCtrl::class, 'update'])->name('jeniskamar-update');
		Route::post('remove', [JenisKamarCtrl::class, 'remove'])->name('jeniskamar-remove');
		Route::post('api', [JenisKamarCtrl::class, 'api'])->name('jeniskamar-api');
	});

	Route::prefix('kamarinap')->group(function () {
		Route::post('list', [kamarInapCtrl::class, 'list'])->name('kamarinap-list');
		Route::post('add', [kamarInapCtrl::class, 'add'])->name('kamarinap-add');
		Route::post('edit', [kamarInapCtrl::class, 'edit'])->name('kamarinap-edit');
		Route::post('update', [kamarInapCtrl::class, 'update'])->name('kamarinap-update');
		Route::post('remove', [kamarInapCtrl::class, 'remove'])->name('kamarinap-remove');
		Route::post('api', [kamarInapCtrl::class, 'api'])->name('kamarinap-api');
	});

	Route::prefix('pemeriksaanodc')->group(function () {
		Route::post('list', [PemeriksaanOdcCtrl::class, 'list'])->name('pemeriksaan-list');
		Route::post('detail', [PemeriksaanOdcCtrl::class, 'detail'])->name('pemeriksaan-detail');
		Route::post('add', [PemeriksaanOdcCtrl::class, 'add'])->name('pemeriksaan-add');
	});

	Route::prefix('label')->group(function () {
		Route::post('list', [LabelCtrl::class, 'list'])->name('label-list');
		Route::post('add', [LabelCtrl::class, 'add'])->name('label-add');
		Route::post('edit', [LabelCtrl::class, 'edit'])->name('label-edit');
		Route::post('update', [LabelCtrl::class, 'update'])->name('label-update');
		Route::post('remove', [LabelCtrl::class, 'remove'])->name('label-remove');
		Route::post('api', [LabelCtrl::class, 'api'])->name('label-api');
	});

	Route::prefix('unit')->group(function () {
		Route::post('list', [UnitCtrl::class, 'list'])->name('unit-list');
		Route::post('add', [UnitCtrl::class, 'add'])->name('unit-add');
		Route::post('edit', [UnitCtrl::class, 'edit'])->name('unit-edit');
		Route::post('update', [UnitCtrl::class, 'update'])->name('unit-update');
		Route::post('remove', [UnitCtrl::class, 'remove'])->name('unit-remove');
		Route::post('api', [UnitCtrl::class, 'api'])->name('unit-api');
	});

	Route::prefix('runningtext')->group(function () {
		Route::post('list', [RunningTextCtrl::class, 'list'])->name('runningtext-list');
		Route::post('add', [RunningTextCtrl::class, 'add'])->name('runningtext-add');
		Route::post('edit', [RunningTextCtrl::class, 'edit'])->name('runningtext-edit');
		Route::post('update', [RunningTextCtrl::class, 'update'])->name('runningtext-update');
		Route::post('block', [RunningTextCtrl::class, 'block'])->name('runningtext-block');
		Route::post('active', [RunningTextCtrl::class, 'active'])->name('runningtext-active');
		Route::post('api', [RunningTextCtrl::class, 'api'])->name('runningtext-api');
	});

	Route::prefix('runningimage')->group(function () {
		Route::post('list', [RunningImageCtrl::class, 'list'])->name('runningimage-list');
		Route::post('add', [RunningImageCtrl::class, 'add'])->name('runningimage-add');
		Route::post('block', [RunningImageCtrl::class, 'block'])->name('runningimage-block');
	});

	Route::prefix('icd9')->group(function () {
		Route::post('list', [Icd9Ctrl::class, 'list'])->name('icd9-list');
		Route::post('add', [Icd9Ctrl::class, 'add'])->name('icd9-add');
		Route::post('edit', [Icd9Ctrl::class, 'edit'])->name('icd9-edit');
		Route::post('update', [Icd9Ctrl::class, 'update'])->name('icd9-update');
		Route::post('remove', [Icd9Ctrl::class, 'remove'])->name('icd9-remove');
		Route::post('api', [Icd9Ctrl::class, 'api'])->name('icd9-api');
	});

	Route::prefix('icd10')->group(function () {
		Route::post('list', [Icd10Ctrl::class, 'list'])->name('icd10-list');
		Route::post('add', [Icd10Ctrl::class, 'add'])->name('icd10-add');
		Route::post('edit', [Icd10Ctrl::class, 'edit'])->name('icd10-edit');
		Route::post('update', [Icd10Ctrl::class, 'update'])->name('icd10-update');
		Route::post('remove', [Icd10Ctrl::class, 'remove'])->name('icd10-remove');
		Route::post('api', [Icd10Ctrl::class, 'api'])->name('icd10-api');
	});

	Route::prefix('ruangan')->group(function () {
		Route::post('list', [RuanganCtrl::class, 'list'])->name('ruangan-list');
		Route::post('add', [RuanganCtrl::class, 'add'])->name('ruangan-add');
		Route::post('edit', [RuanganCtrl::class, 'edit'])->name('ruangan-edit');
		Route::post('update', [RuanganCtrl::class, 'update'])->name('ruangan-update');
		Route::post('remove', [RuanganCtrl::class, 'remove'])->name('ruangan-remove');
		Route::post('api', [RuanganCtrl::class, 'api'])->name('ruangan-api');
	});

	Route::prefix('provinsi')->group(function () {
		Route::post('list', [ProvinsiCtrl::class, 'list'])->name('provinsi-list');
		Route::post('add', [ProvinsiCtrl::class, 'add'])->name('provinsi-add');
		Route::post('edit', [ProvinsiCtrl::class, 'edit'])->name('provinsi-edit');
		Route::post('update', [ProvinsiCtrl::class, 'update'])->name('provinsi-update');
		Route::post('remove', [ProvinsiCtrl::class, 'remove'])->name('provinsi-remove');
		Route::post('api', [ProvinsiCtrl::class, 'api'])->name('provinsi-api');
	});

	Route::prefix('kabkota')->group(function () {
		Route::post('list', [KabKotaCtrl::class, 'list'])->name('kabkota-list');
		Route::post('add', [KabKotaCtrl::class, 'add'])->name('kabkota-add');
		Route::post('edit', [KabKotaCtrl::class, 'edit'])->name('kabkota-edit');
		Route::post('update', [KabKotaCtrl::class, 'update'])->name('kabkota-update');
		Route::post('remove', [KabKotaCtrl::class, 'remove'])->name('kabkota-remove');
		Route::post('api', [KabKotaCtrl::class, 'api'])->name('kabkota-api');
	});

	Route::prefix('kecamatan')->group(function () {
		Route::post('list', [KecamatanCtrl::class, 'list'])->name('kecamatan-list');
		Route::post('add', [KecamatanCtrl::class, 'add'])->name('kecamatan-add');
		Route::post('edit', [KecamatanCtrl::class, 'edit'])->name('kecamatan-edit');
		Route::post('update', [KecamatanCtrl::class, 'update'])->name('kecamatan-update');
		Route::post('remove', [KecamatanCtrl::class, 'remove'])->name('kecamatan-remove');
		Route::post('api', [KecamatanCtrl::class, 'api'])->name('kecamatan-api');
	});

	Route::prefix('kelurahan')->group(function () {
		Route::post('list', [KelurahanCtrl::class, 'list'])->name('kelurahan-list');
		Route::post('add', [KelurahanCtrl::class, 'add'])->name('kelurahan-add');
		Route::post('edit', [KelurahanCtrl::class, 'edit'])->name('kelurahan-edit');
		Route::post('update', [KelurahanCtrl::class, 'update'])->name('kelurahan-update');
		Route::post('remove', [KelurahanCtrl::class, 'remove'])->name('kelurahan-remove');
		Route::post('api', [KelurahanCtrl::class, 'api'])->name('kelurahan-api');
	});

	Route::prefix('pengguna')->group(function () {
		Route::post('list', [PenggunaCtrl::class, 'list'])->name('pengguna-list');
		Route::post('add', [PenggunaCtrl::class, 'add'])->name('pengguna-add');
		Route::post('edit', [PenggunaCtrl::class, 'edit'])->name('pengguna-edit');
		Route::post('update', [PenggunaCtrl::class, 'update'])->name('pengguna-update');
		Route::post('reset', [PenggunaCtrl::class, 'reset'])->name('pengguna-reset');
		Route::post('block', [PenggunaCtrl::class, 'block'])->name('pengguna-block');
		Route::post('active', [PenggunaCtrl::class, 'active'])->name('pengguna-active');
		Route::post('detail', [PenggunaCtrl::class, 'detail'])->name('pengguna-detail');
		Route::post('api', [PenggunaCtrl::class, 'api'])->name('pengguna-api');
		Route::post('dokter', [PenggunaCtrl::class, 'dokter'])->name('pengguna-dokter');

		Route::prefix('hakakses')->group(function () {
			Route::post('look', [PenggunaCtrl::class, 'look'])->name('akses-look');
			Route::post('update', [PenggunaCtrl::class, 'updatehakakses'])->name('akses-update');
		});
	});
	
});
