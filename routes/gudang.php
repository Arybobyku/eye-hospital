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
use App\Http\Controllers\Gudang\SupplierCtrl;
use App\Http\Controllers\Gudang\SatuanCtrl;
use App\Http\Controllers\Gudang\ObatCtrl;
use App\Http\Controllers\Gudang\HargaObatCtrl;
use App\Http\Controllers\Gudang\PembelianCtrl;
use App\Http\Controllers\Gudang\StockOpnameCtrl;
use App\Http\Controllers\Gudang\AccOpnameCtrl;
use App\Http\Controllers\Gudang\ReturCtrl;
use App\Http\Controllers\Gudang\LabelStockOpnameCtrl;
use App\Http\Controllers\Gudang\LabelPermohonanCtrl;
use App\Http\Controllers\Gudang\LabelPermintaanCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('supplier')->group(function () {
		Route::post('list', [SupplierCtrl::class, 'list'])->name('supplier-list');
		Route::post('add', [SupplierCtrl::class, 'add'])->name('supplier-add');
		Route::post('edit', [SupplierCtrl::class, 'edit'])->name('supplier-edit');
		Route::post('update', [SupplierCtrl::class, 'update'])->name('supplier-update');
		Route::post('remove', [SupplierCtrl::class, 'remove'])->name('supplier-remove');
		Route::post('api', [SupplierCtrl::class, 'api'])->name('supplier-api');
	});

	Route::prefix('satuan')->group(function () {
		Route::post('list', [SatuanCtrl::class, 'list'])->name('satuan-list');
		Route::post('add', [SatuanCtrl::class, 'add'])->name('satuan-add');
		Route::post('edit', [SatuanCtrl::class, 'edit'])->name('satuan-edit');
		Route::post('update', [SatuanCtrl::class, 'update'])->name('satuan-update');
		Route::post('remove', [SatuanCtrl::class, 'remove'])->name('satuan-remove');
		Route::post('api', [SatuanCtrl::class, 'api'])->name('satuan-api');
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

	Route::prefix('permohonanlabel')->group(function () {
		Route::post('list', [LabelPermohonanCtrl::class, 'list'])->name('permohonanlabel-list');
		Route::post('add', [LabelPermohonanCtrl::class, 'add'])->name('permohonanlabel-add');
		Route::post('edit', [LabelPermohonanCtrl::class, 'edit'])->name('permohonanlabel-edit');
		Route::post('update', [LabelPermohonanCtrl::class, 'update'])->name('permohonanlabel-update');
		Route::post('remove', [LabelPermohonanCtrl::class, 'remove'])->name('permohonanlabel-remove');
		Route::post('api', [LabelPermohonanCtrl::class, 'api'])->name('permohonanlabel-api');

		Route::post('getpermohonan', [LabelPermohonanCtrl::class, 'getpermohonan'])->name('permohonanlabel-getpermohonan');
		Route::post('addpermohonan', [LabelPermohonanCtrl::class, 'addpermohonan'])->name('permohonanlabel-addpermohonan');
		Route::get('cetakpermohonan/{uuid}', [LabelPermohonanCtrl::class, 'cetakpermohonan'])->name('cetakpermohonan-pdf');
	});

	Route::prefix('permintaanlabel')->group(function () {
		Route::post('list', [LabelPermintaanCtrl::class, 'list'])->name('permintaanlabel-list');
		Route::post('add', [LabelPermintaanCtrl::class, 'add'])->name('permintaanlabel-add');
		Route::post('edit', [LabelPermintaanCtrl::class, 'edit'])->name('permintaanlabel-edit');
		Route::post('update', [LabelPermintaanCtrl::class, 'update'])->name('permintaanlabel-update');
		Route::post('remove', [LabelPermintaanCtrl::class, 'remove'])->name('permintaanlabel-remove');
		Route::post('api', [LabelPermintaanCtrl::class, 'api'])->name('permintaanlabel-api');

		Route::post('getpermintaan', [LabelPermintaanCtrl::class, 'getpermintaan'])->name('permintaanlabel-getpermintaan');
		Route::post('addpermintaan', [LabelPermintaanCtrl::class, 'addpermintaan'])->name('permintaanlabel-addpermintaan');
		Route::get('cetakpermintaan/{uuid}', [LabelPermintaanCtrl::class, 'cetakpermintaan'])->name('cetakpermintaan-pdf');
	});

	Route::prefix('obat')->group(function () {
		Route::post('list', [ObatCtrl::class, 'list'])->name('obat-list');
		Route::post('add', [ObatCtrl::class, 'add'])->name('obat-add');
		Route::post('edit', [ObatCtrl::class, 'edit'])->name('obat-edit');
		Route::post('update', [ObatCtrl::class, 'update'])->name('obat-update');
		Route::post('remove', [ObatCtrl::class, 'remove'])->name('obat-remove');
		Route::post('api', [ObatCtrl::class, 'api'])->name('obat-api');
	});

	Route::prefix('harga')->group(function () {
		Route::post('list', [HargaObatCtrl::class, 'list'])->name('harga-list');
		Route::post('add', [HargaObatCtrl::class, 'add'])->name('harga-add');
		Route::post('edit', [HargaObatCtrl::class, 'edit'])->name('harga-edit');
		Route::post('update', [HargaObatCtrl::class, 'update'])->name('harga-update');
		Route::post('remove', [HargaObatCtrl::class, 'remove'])->name('harga-remove');
		Route::post('api', [HargaObatCtrl::class, 'api'])->name('harga-api');
	});

	Route::prefix('pembelian')->group(function () {
		Route::post('list', [PembelianCtrl::class, 'list'])->name('pembelian-list');
		Route::post('add', [PembelianCtrl::class, 'add'])->name('pembelian-add');
		Route::post('edit', [PembelianCtrl::class, 'edit'])->name('pembelian-edit');
		Route::post('update', [PembelianCtrl::class, 'update'])->name('pembelian-update');
		Route::post('remove', [PembelianCtrl::class, 'remove'])->name('pembelian-remove');
		Route::post('approve', [PembelianCtrl::class, 'approve'])->name('pembelian-approve');
		Route::post('obat', [PembelianCtrl::class, 'obat'])->name('pembelian-obat');
		Route::post('addobat', [PembelianCtrl::class, 'addobat'])->name('pembelian-addobat');
	});

	Route::prefix('stockopname')->group(function () {
		Route::post('list', [StockOpnameCtrl::class, 'list'])->name('stockopname-list');
		Route::post('rincian', [StockOpnameCtrl::class, 'rincian'])->name('apotek-stockopname-rincian');
	});

	Route::prefix('accopname')->group(function () {
		Route::post('list', [AccOpnameCtrl::class, 'list'])->name('gudang-accopname-list');
		Route::post('detail', [AccOpnameCtrl::class, 'detail'])->name('gudang-accopname-detail');
		Route::post('proses', [AccOpnameCtrl::class, 'proses'])->name('gudang-accopname-proses');
		Route::post('kirim', [AccOpnameCtrl::class, 'kirim'])->name('gudang-accopname-kirim');
		Route::post('tolak', [AccOpnameCtrl::class, 'tolak'])->name('gudang-accopname-tolak');
	});

	Route::prefix('retur')->group(function () {
		Route::post('list', [ReturCtrl::class, 'list'])->name('gudang-retur-list');
		Route::post('add', [ReturCtrl::class, 'add'])->name('gudang-retur-add');
		Route::post('edit', [ReturCtrl::class, 'edit'])->name('gudang-retur-edit');
		Route::post('update', [ReturCtrl::class, 'update'])->name('gudang-retur-update');
		Route::post('remove', [ReturCtrl::class, 'remove'])->name('gudang-retur-remove');
		Route::post('obat', [ReturCtrl::class, 'obat'])->name('gudang-retur-obat');
		Route::post('addobat', [ReturCtrl::class, 'addobat'])->name('gudang-retur-addobat');
		Route::post('approve', [ReturCtrl::class, 'approve'])->name('gudang-retur-approve');
	});

});