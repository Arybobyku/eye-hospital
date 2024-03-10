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
use App\Http\Controllers\Apotek\StockOpnameCtrl;
use App\Http\Controllers\Apotek\ReqOpnameCtrl;
use App\Http\Controllers\Apotek\FarmasiCtrl;
use App\Http\Controllers\Apotek\HistoriFarmasiCtrl;
use App\Http\Controllers\Apotek\HistoriFarmasiRawatInapCtrl;
use App\Http\Controllers\Apotek\FarmasiRawatInapCtrl;
use App\Http\Controllers\Apotek\BebasCtrl;
use App\Http\Controllers\Apotek\HistoriBebasCtrl;
use App\Http\Controllers\Apotek\LabelStockOpnameCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('bebas')->group(function () {
		Route::post('addpembeli', [BebasCtrl::class, 'addpembeli'])->name('apotek-bebas-addpembeli');
		Route::post('list', [BebasCtrl::class, 'list'])->name('apotek-bebas-list');
		Route::post('listbayar', [BebasCtrl::class, 'listbayar'])->name('apotek-bebas-listbayar');
		Route::post('add', [BebasCtrl::class, 'add'])->name('apotek-bebas-add');
		Route::post('detail', [BebasCtrl::class, 'detail'])->name('apotek-bebas-detail');
		Route::post('antrian', [BebasCtrl::class, 'antrian'])->name('apotek-bebas-antrian');
		Route::post('batal', [BebasCtrl::class, 'batal'])->name('apotek-bebas-batal');
		Route::post('selesai', [BebasCtrl::class, 'selesai'])->name('apotek-bebas-selesai');
	});

	Route::prefix('stockopname')->group(function () {
		Route::post('list', [StockOpnameCtrl::class, 'list'])->name('apotek-stockopname-list');
		Route::post('ambil', [StockOpnameCtrl::class, 'ambil'])->name('apotek-stockopname-ambil');
		Route::post('kembali', [StockOpnameCtrl::class, 'kembali'])->name('apotek-stockopname-kembali');
	});

	Route::prefix('farmasi')->group(function () {
		Route::post('list', [FarmasiCtrl::class, 'list'])->name('farmasi-list');
		Route::post('listbayar', [FarmasiCtrl::class, 'listbayar'])->name('farmasi-listbayar');
		Route::post('editobat', [FarmasiCtrl::class, 'editobat'])->name('farmasi-editobat');
		Route::post('panjar', [FarmasiCtrl::class, 'panjar'])->name('panjar-list');
		Route::post('call', [FarmasiCtrl::class, 'call'])->name('farmasi-call');
		Route::post('approvement', [FarmasiCtrl::class, 'approvement'])->name('farmasi-approvement');
		Route::post('detail', [FarmasiCtrl::class, 'detail'])->name('kasir-detail');
		Route::post('bayar', [FarmasiCtrl::class, 'bayar'])->name('kasir-bayar');
		Route::post('terima', [FarmasiCtrl::class, 'terima'])->name('kasir-terima');
	});

	Route::prefix('farmasirawatinap')->group(function () {
		Route::post('list', [FarmasiRawatInapCtrl::class, 'list'])->name('farmasirawatinap-list');
		Route::post('listbayar', [FarmasiRawatInapCtrl::class, 'listbayar'])->name('farmasirawatinap-listbayar');
		Route::post('editobat', [FarmasiRawatInapCtrl::class, 'editobat'])->name('farmasi-editobat');
		Route::post('panjar', [FarmasiRawatInapCtrl::class, 'panjar'])->name('panjar-list');
		Route::post('call', [FarmasiRawatInapCtrl::class, 'call'])->name('farmasirawatinap-call');
		Route::post('approvement', [FarmasiRawatInapCtrl::class, 'approvement'])->name('farmasirawatinap-approvement');
		Route::post('detail', [FarmasiRawatInapCtrl::class, 'detail'])->name('kasir-detail');
		Route::post('bayar', [FarmasiRawatInapCtrl::class, 'bayar'])->name('kasir-bayar');
		Route::post('terima', [FarmasiRawatInapCtrl::class, 'terima'])->name('kasir-terima');
	});

	Route::prefix('stockcatatlabel')->group(function () {
		Route::post('list', [LabelStockOpnameCtrl::class, 'list'])->name('stockcatatlabel-list');
		Route::post('add', [LabelStockOpnameCtrl::class, 'add'])->name('stockcatatlabel-add');
		Route::post('edit', [LabelStockOpnameCtrl::class, 'edit'])->name('stockcatatlabel-edit');
		Route::post('update', [LabelStockOpnameCtrl::class, 'update'])->name('stockcatatlabel-update');
		Route::post('remove', [LabelStockOpnameCtrl::class, 'remove'])->name('stockcatatlabel-remove');
		Route::post('api', [LabelStockOpnameCtrl::class, 'api'])->name('stockcatatlabel-api');

		Route::post('getbalance', [LabelStockOpnameCtrl::class, 'getbalance'])->name('stockcatatlabel-getbalance');
		Route::post('addbalance', [LabelStockOpnameCtrl::class, 'addbalance'])->name('stockcatatlabel-addbalance');
		Route::post('prosesbalance', [LabelStockOpnameCtrl::class, 'prosesbalance'])->name('stockcatatlabel-prosesbalance');
	});

	Route::prefix('historifarmasi')->group(function () {
    Route::post('list', [HistoriFarmasiCtrl::class, 'list'])->name('historifarmasi-list');
	});

	Route::prefix('historifarmasirawatinap')->group(function () {
    Route::post('list', [HistoriFarmasiRawatInapCtrl::class, 'list'])->name('historifarmasirawatinap-list');
	});

	Route::prefix('historibebas')->group(function () {
		Route::post('list', [HistoriBebasCtrl::class, 'list'])->name('apotek-historibebas-list');
	});

	Route::prefix('reqopname')->group(function () {
		Route::post('list', [ReqOpnameCtrl::class, 'list'])->name('apotek-reqopname-list');
		Route::post('detail', [ReqOpnameCtrl::class, 'detail'])->name('apotek-reqopname-detail');
		Route::post('minta', [ReqOpnameCtrl::class, 'minta'])->name('apotek-reqopname-minta');
		Route::post('terima', [ReqOpnameCtrl::class, 'terima'])->name('apotek-reqopname-terima');
		Route::post('batal', [ReqOpnameCtrl::class, 'batal'])->name('apotek-reqopname-batal');
	});

	Route::prefix('accopname')->group(function () {
		Route::post('list', [AccOpnameCtrl::class, 'list'])->name('apotek-accopname-list');
		Route::post('detail', [AccOpnameCtrl::class, 'detail'])->name('apotek-accopname-detail');
		Route::post('proses', [AccOpnameCtrl::class, 'proses'])->name('apotek-accopname-proses');
		Route::post('kirim', [AccOpnameCtrl::class, 'kirim'])->name('apotek-accopname-kirim');
		Route::post('tolak', [AccOpnameCtrl::class, 'tolak'])->name('apotek-accopname-tolak');
	});

});