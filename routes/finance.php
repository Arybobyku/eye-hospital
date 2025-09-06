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
use App\Http\Controllers\Finance\CaraBayarCtrl;
use App\Http\Controllers\Finance\ChildCtrl;
use App\Http\Controllers\Finance\TarifCtrl;
use App\Http\Controllers\Finance\TarifRawatJalanCtrl;
use App\Http\Controllers\Finance\TarifNonBedahCtrl;
use App\Http\Controllers\Finance\TarifBedahCtrl;
use App\Http\Controllers\Finance\TarifKamarCtrl;
use App\Http\Controllers\Finance\LayananCtrl;
use App\Http\Controllers\Finance\KasirCtrl;
use App\Http\Controllers\Finance\BedahKasirCtrl;
use App\Http\Controllers\Finance\PaketBedahCtrl;
use App\Http\Controllers\Finance\ListPaketBedahCtrl;
use App\Http\Controllers\Finance\HistoriKasirCtrl;
use App\Http\Controllers\Finance\HistoriKasirRawatInapCtrl;
use App\Http\Controllers\Finance\BebasCtrl;
use App\Http\Controllers\Finance\HistoriBebasCtrl;
use App\Http\Controllers\Finance\ClaimCtrl;
use App\Http\Controllers\Finance\KwitansiClaimCtrl;
use App\Http\Controllers\Finance\PembelianCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('bebas')->group(function () {
		Route::post('list', [BebasCtrl::class, 'list'])->name('apotek-bebas-list');
		Route::post('listbayar', [BebasCtrl::class, 'listbayar'])->name('apotek-bebas-listbayar');
		Route::post('add', [BebasCtrl::class, 'add'])->name('apotek-bebas-add');
		Route::post('detail', [BebasCtrl::class, 'detail'])->name('apotek-bebas-detail');
		Route::post('antrian', [BebasCtrl::class, 'antrian'])->name('apotek-bebas-antrian');
		Route::post('call', [BebasCtrl::class, 'call'])->name('apotek-bebas-call');
		Route::post('selesai', [BebasCtrl::class, 'selesai'])->name('apotek-bebas-selesai');
	});

	Route::prefix('pembelian')->group(function () {
		Route::post('list', [PembelianCtrl::class, 'list'])->name('pembelian-list');
		Route::post('listtagihan', [PembelianCtrl::class, 'listtagihan'])->name('pembelian-listtagihan');
		Route::post('listsudah', [PembelianCtrl::class, 'listsudah'])->name('pembelian-listsudah');
		Route::post('listbelum', [PembelianCtrl::class, 'listbelum'])->name('pembelian-listbelum');
		Route::post('add', [PembelianCtrl::class, 'add'])->name('pembelian-add');
		Route::post('edit', [PembelianCtrl::class, 'edit'])->name('pembelian-edit');
		Route::post('update', [PembelianCtrl::class, 'update'])->name('pembelian-update');
		Route::post('remove', [PembelianCtrl::class, 'remove'])->name('pembelian-remove');
		Route::post('approve', [PembelianCtrl::class, 'approve'])->name('pembelian-approve');
		Route::post('obat', [PembelianCtrl::class, 'obat'])->name('pembelian-obat');
		Route::post('addobat', [PembelianCtrl::class, 'addobat'])->name('pembelian-addobat');
		Route::get('cetak', [PembelianCtrl::class, 'cetak'])->name('pembelian-cetak');
		Route::post('ubahstatus', [PembelianCtrl::class, 'ubahstatus'])->name('pembelian-ubahstatus');
	});

	Route::prefix('historibebas')->group(function () {
    Route::post('list', [HistoriBebasCtrl::class, 'list'])->name('apotek-bebas-list');
	});

	Route::prefix('carabayar')->group(function () {
		Route::post('list', [CaraBayarCtrl::class, 'list'])->name('finance-carabayar-list');
		Route::post('add', [CaraBayarCtrl::class, 'add'])->name('finance-carabayar-add');
		Route::post('edit', [CaraBayarCtrl::class, 'edit'])->name('finance-carabayar-edit');
		Route::post('update', [CaraBayarCtrl::class, 'update'])->name('finance-carabayar-update');
		Route::post('remove', [CaraBayarCtrl::class, 'remove'])->name('finance-carabayar-remove');

		Route::get('downloadtemplate/{metode}', [CaraBayarCtrl::class, 'downloadTemplateUploadPembayaran'])->name('finance-carabayar-downloadtemplate');
		Route::get('download', [CaraBayarCtrl::class, 'exportMetodePembayaran'])->name('finance-carabayar-download');
		Route::post('uploadmetodepembayaran', [CaraBayarCtrl::class, 'uploadMetodePembayaran'])->name('finance-carabayar-upload');

		Route::prefix('child')->group(function () {
			Route::post('data', [ChildCtrl::class, 'data'])->name('finance-child-data');
			Route::post('add', [ChildCtrl::class, 'add'])->name('finance-child-add');
			Route::post('remove', [ChildCtrl::class, 'remove'])->name('finance-child-remove');
		});
	
		Route::prefix('tarif')->group(function () {
			Route::post('data', [TarifCtrl::class, 'data'])->name('finance-child-data');

			Route::prefix('tindakanrawatjalan')->group(function () {
    		Route::post('add', [TarifRawatJalanCtrl::class, 'add'])->name('finance-tarif-tindakanrawatjalan-add');
    		Route::post('remove', [TarifRawatJalanCtrl::class, 'remove'])->name('finance-tarif-tindakanrawatjalan-remove');
			});
			Route::prefix('tindakannonbedah')->group(function () {
    		Route::post('add', [TarifNonBedahCtrl::class, 'add'])->name('finance-tarif-tindakannonbedah-add');
    		Route::post('remove', [TarifNonBedahCtrl::class, 'remove'])->name('finance-tarif-tindakannonbedah-remove');
			});
			Route::prefix('tindakanbedah')->group(function () {
    		Route::post('add', [TarifBedahCtrl::class, 'add'])->name('finance-tarif-tindakanbedah-add');
    		Route::post('remove', [TarifBedahCtrl::class, 'remove'])->name('finance-tarif-tindakanbedah-remove');
			});
			Route::prefix('jeniskamar')->group(function () {
    		Route::post('add', [TarifKamarCtrl::class, 'add'])->name('finance-tarif-kamar-add');
    		Route::post('remove', [TarifKamarCtrl::class, 'remove'])->name('finance-tarif-kamar-remove');
			});
		});

	});

	Route::prefix('layanan')->group(function () {
    Route::post('list', [LayananCtrl::class, 'list'])->name('finance-layanan-list');
    Route::post('edit', [LayananCtrl::class, 'edit'])->name('finance-layanan-edit');
    Route::post('update', [LayananCtrl::class, 'update'])->name('finance-layanan-update');
    Route::post('remove', [LayananCtrl::class, 'remove'])->name('finance-layanan-remove');
	});

	Route::prefix('kasir')->group(function () {
		Route::post('list', [KasirCtrl::class, 'list'])->name('kasir-list');
		Route::post('getpanjar', [KasirCtrl::class, 'getpanjar'])->name('kasir-getpanjar');
		Route::post('addpanjar', [KasirCtrl::class, 'addpanjar'])->name('kasir-addpanjar');
		Route::post('hapusbiaya', [KasirCtrl::class, 'hapusbiaya'])->name('kasir-hapusbiaya');
		Route::post('perbaharuibiaya', [KasirCtrl::class, 'perbaharuibiaya'])->name('kasir-perbaharuibiaya');
		Route::post('listsudahbayar', [KasirCtrl::class, 'listsudahbayar'])->name('kasir-listsudahbayar');
		Route::post('editlistsudahbayar', [KasirCtrl::class, 'editlistsudahbayar'])->name('kasir-editlistsudahbayar');
		Route::post('panjar', [KasirCtrl::class, 'panjar'])->name('panjar-list');
		Route::post('call', [KasirCtrl::class, 'call'])->name('kasir-call');
		Route::post('detail', [KasirCtrl::class, 'detail'])->name('kasir-detail');
		Route::post('bayar', [KasirCtrl::class, 'bayar'])->name('kasir-bayar');
		Route::post('editbayar', [KasirCtrl::class, 'editbayar'])->name('kasir-editbayar');
		Route::post('cancelbayar', [KasirCtrl::class, 'cancelbayar'])->name('kasir-cancelbayar');
		Route::post('terima', [KasirCtrl::class, 'terima'])->name('kasir-terima');
	});

	Route::prefix('historikasir')->group(function () {
		Route::post('list', [HistoriKasirCtrl::class, 'list'])->name('kasir-list');
		Route::post('detail', [HistoriKasirCtrl::class, 'detail'])->name('kasir-detail');
	});

	Route::prefix('historikasirrawatinap')->group(function () {
		Route::post('list', [HistoriKasirRawatInapCtrl::class, 'list'])->name('historikasirrawatinap-list');
		Route::post('detail', [HistoriKasirRawatInapCtrl::class, 'detail'])->name('historikasirrawatinap-detail');
	});

	Route::prefix('claim')->group(function () {
		Route::post('list', [ClaimCtrl::class, 'list'])->name('kasir-list');
		Route::post('detail', [ClaimCtrl::class, 'detail'])->name('kasir-detail');
	});

	Route::prefix('kwitansiclaim')->group(function () {
		Route::post('get', [KwitansiClaimCtrl::class, 'get'])->name('kasir-get');
		Route::post('add', [KwitansiClaimCtrl::class, 'add'])->name('kasir-add');
		Route::post('diterima', [KwitansiClaimCtrl::class, 'diterima'])->name('kasir-diterima');
	});

	Route::prefix('bedahkasir')->group(function () {
		Route::post('list', [BedahKasirCtrl::class, 'list'])->name('kasir-list');
		Route::post('listbayar', [BedahKasirCtrl::class, 'listbayar'])->name('kasir-listbayar');
		Route::post('getpanjar', [BedahKasirCtrl::class, 'getpanjar'])->name('kasir-getpanjar');
		Route::post('addpanjar', [BedahKasirCtrl::class, 'addpanjar'])->name('kasir-addpanjar');
		Route::post('hapusbiaya', [BedahKasirCtrl::class, 'hapusbiaya'])->name('kasir-hapusbiaya');
		Route::post('perbaharuibiaya', [BedahKasirCtrl::class, 'perbaharuibiaya'])->name('kasir-perbaharuibiaya');
		Route::post('listsudahbayar', [BedahKasirCtrl::class, 'listsudahbayar'])->name('kasir-listsudahbayar');
		Route::post('panjar', [BedahKasirCtrl::class, 'panjar'])->name('panjar-list');
		Route::post('call', [BedahKasirCtrl::class, 'call'])->name('kasir-call');
		Route::post('detail', [BedahKasirCtrl::class, 'detail'])->name('kasir-detail');
		Route::post('bayar', [BedahKasirCtrl::class, 'bayar'])->name('kasir-bayar');
		Route::post('cancelbayar', [BedahKasirCtrl::class, 'cancelbayar'])->name('kasir-cancelbayar');
		Route::post('terima', [BedahKasirCtrl::class, 'terima'])->name('kasir-terima');
	});

	Route::prefix('paketbedah')->group(function () {
		Route::post('list', [PaketBedahCtrl::class, 'list'])->name('paketbedah-list');
		Route::post('edit', [PaketBedahCtrl::class, 'edit'])->name('paketbedah-edit');
		Route::post('update', [PaketBedahCtrl::class, 'update'])->name('paketbedah-update');
		Route::post('detail', [PaketBedahCtrl::class, 'detail'])->name('paketbedah-detail');
		Route::post('add', [PaketBedahCtrl::class, 'add'])->name('paketbedah-add');
		Route::post('histori', [PaketBedahCtrl::class, 'histori'])->name('paketbedah-histori');
		Route::post('remove', [PaketBedahCtrl::class, 'remove'])->name('paketbedah-remove');
		Route::post('duplicate', [PaketBedahCtrl::class, 'duplicate'])->name('paketbedah-duplicate');

	});

	Route::prefix('listpaketbedah')->group(function () {
		Route::post('list', [ListPaketBedahCtrl::class, 'list'])->name('listpaketbedah-list');
		Route::post('add', [ListPaketBedahCtrl::class, 'add'])->name('listpaketbedah-add');
		Route::post('remove', [ListPaketBedahCtrl::class, 'remove'])->name('listpaketbedah-remove');
		// Route::post('duplicate', [ListPaketBedahCtrl::class, 'duplicate'])->name('listpaketbedah-duplicate');
	});

});