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
use App\Http\Controllers\Preview\ClaimGabunganCtrl;
use App\Http\Controllers\Preview\StockCtrl;
use App\Http\Controllers\Preview\KartuStockCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){
	Route::prefix('claimgabungan')->group(function () {
		Route::post('get', [ClaimGabunganCtrl::class, 'get'])->name('preview-claimgabungan-get');
		Route::post('add', [ClaimGabunganCtrl::class, 'add'])->name('preview-claimgabungan-add');
		Route::post('ubah', [ClaimGabunganCtrl::class, 'ubah'])->name('preview-claimgabungan-ubah');
		Route::get('claim/{posisi}/{dari}/{ke}', [ClaimGabunganCtrl::class, 'claim'])->name('preview-claimgabungan-claim');
		Route::get('pengantar/{posisi}/{dari}/{ke}', [ClaimGabunganCtrl::class, 'pengantar'])->name('preview-claimgabungan-pengantar');
	});

	Route::prefix('datastock')->group(function () {
		Route::get('stock/{posisi}', [StockCtrl::class, 'stock'])->name('preview-datastock-stock');
	});

	Route::prefix('kartustock')->group(function () {
		Route::get('stock/{posisi}/{dari}/{ke}', [KartuStockCtrl::class, 'stock'])->name('preview-kartustock-stock');
	});
});