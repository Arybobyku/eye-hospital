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
use App\Http\Controllers\Bedah\StockOpnameCtrl;
use App\Http\Controllers\Bedah\ReqOpnameCtrl;
use App\Http\Controllers\Bedah\PasienBedahCtrl;
use App\Http\Controllers\Bedah\DataFormBedahCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('stockopname')->group(function () {
		Route::post('list', [StockOpnameCtrl::class, 'list'])->name('bedah-stockopname-list');
		Route::post('ambil', [StockOpnameCtrl::class, 'ambil'])->name('bedah-stockopname-ambil');
		Route::post('kembali', [StockOpnameCtrl::class, 'kembali'])->name('bedah-stockopname-kembali');
	});

	Route::prefix('reqopname')->group(function () {
		Route::post('list', [ReqOpnameCtrl::class, 'list'])->name('bedah-reqopname-list');
		Route::post('detail', [ReqOpnameCtrl::class, 'detail'])->name('bedah-reqopname-detail');
		Route::post('minta', [ReqOpnameCtrl::class, 'minta'])->name('bedah-reqopname-minta');
		Route::post('terima', [ReqOpnameCtrl::class, 'terima'])->name('bedah-reqopname-terima');
		Route::post('batal', [ReqOpnameCtrl::class, 'batal'])->name('bedah-reqopname-batal');
	});

	Route::prefix('pasien')->group(function () {
		Route::post('list', [PasienBedahCtrl::class, 'list'])->name('bedah-reqopname-list');
		Route::post('listselesai', [PasienBedahCtrl::class, 'listselesai'])->name('bedah-reqopname-listselesai');
		Route::post('listhistori', [PasienBedahCtrl::class, 'listhistori'])->name('bedah-reqopname-listhistori');
		
		Route::post('add', [PasienBedahCtrl::class, 'add'])->name('pemeriksaan-add');
		Route::post('remove', [PasienBedahCtrl::class, 'remove'])->name('pemeriksaan-remove');
		Route::post('getlayanan', [PasienBedahCtrl::class, 'getlayanan'])->name('pemeriksaan-getlayanan');
		Route::post('getobat', [PasienBedahCtrl::class, 'getobat'])->name('pemeriksaan-getobat');
		Route::post('getresep', [PasienBedahCtrl::class, 'getresep'])->name('pemeriksaan-getresep');
		Route::post('getjadwalkontrol', [PasienBedahCtrl::class, 'getjadwalkontrol'])->name('pemeriksaan-getjadwalkontrol');
		Route::post('addobat', [PasienBedahCtrl::class, 'addobat'])->name('pemeriksaan-addobat');
		Route::post('addresep', [PasienBedahCtrl::class, 'addresep'])->name('pemeriksaan-addresep');
		Route::post('addjadwalkontrol', [PasienBedahCtrl::class, 'addjadwalkontrol'])->name('pemeriksaan-addjadwalkontrol');
		Route::post('removeobat', [PasienBedahCtrl::class, 'removeobat'])->name('pemeriksaan-removeobat');

		Route::post('proses', [PasienBedahCtrl::class, 'proses'])->name('bedah-reqopname-proses');
		Route::post('selesai', [PasienBedahCtrl::class, 'selesai'])->name('bedah-reqopname-selesai');
		Route::post('detail', [PasienBedahCtrl::class, 'detail'])->name('bedah-reqopname-detail');
	});

	Route::prefix('dataform')->group(function () {
		Route::post('list', [DataFormBedahCtrl::class, 'list'])->name('bedah-form-list');
		Route::post('formall', [DataFormBedahCtrl::class, 'formall'])->name('bedah-reqopname-formall');
		Route::post('laporanpembedahan', [DataFormBedahCtrl::class, 'laporanpembedahan'])->name('bedah-form-laporanpembedahan');
		Route::post('checklistkesiapanbedah', [DataFormBedahCtrl::class, 'checklistkesiapanbedah'])->name('bedah-form-checklistkesiapanbedah');
		Route::post('perawatanperioperative', [DataFormBedahCtrl::class, 'perawatanperioperative'])->name('bedah-form-perawatanperioperative');
		Route::post('catatanoperasikatarak', [DataFormBedahCtrl::class, 'catatanoperasikatarak'])->name('bedah-form-catatanoperasikatarak');
		Route::post('persetujuantindakankedokteran', [DataFormBedahCtrl::class, 'persetujuantindakankedokteran'])->name('bedah-form-persetujuantindakankedokteran');
		Route::post('checklistkeselamatanbedah', [DataFormBedahCtrl::class, 'checklistkeselamatanbedah'])->name('bedah-form-checklistkeselamatanbedah');
		Route::post('laporaninjeksiantivega', [DataFormBedahCtrl::class, 'laporaninjeksiantivega'])->name('bedah-form-laporaninjeksiantivega');

	});

});