<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\MasukCtrl;
use App\Http\Controllers\KeluarCtrl;
use App\Http\Controllers\AllApiCtrl;
use App\Http\Controllers\ProfileCtrl;
use App\Http\Controllers\DashboardCtrl;
use App\Http\Controllers\AntrianCtrl;
use App\Http\Controllers\RoomCtrl;
use App\Http\Controllers\MigrasiCtrl;
use App\Http\Controllers\SearchingCtrl;

Route::group(['middleware' => 'throttle: 250, 1', 'middleware' => 'acl'], function(){
	Route::get('dashboard/{any}', function () {
    return view('welcome');
  })->where('any', '[\/\w\.-]*');
});

Route::prefix('information')->group(function () {
	Route::post('page', [DashboardCtrl::class, 'page'])->name('information-page');
});

Route::get('/', [MasukCtrl::class, 'view'])->name('masuk-view');
Route::get('masuk', [MasukCtrl::class, 'view'])->name('masuk-view-masuk');
Route::post('periksa/masuk', [MasukCtrl::class, 'periksa'])->name('periksa-masuk');
Route::get('keluar', [KeluarCtrl::class, 'keluar'])->name('keluar');

Route::prefix('allapi')->group(function () {
	Route::post('patch', [AllApiCtrl::class, 'patch'])->name('allapi-patch');
	Route::post('menu', [AllApiCtrl::class, 'menu'])->name('allapi-menu');
});

Route::prefix('profile')->group(function () {
	Route::post('data', [ProfileCtrl::class, 'data'])->name('profile-data');
	Route::post('edit', [ProfileCtrl::class, 'edit'])->name('profile-edit');
	Route::post('update', [ProfileCtrl::class, 'update'])->name('profile-update');
	Route::post('password', [ProfileCtrl::class, 'password'])->name('profile-password');
});

Route::prefix('antrian')->group(function () {
	Route::prefix('tiketing')->group(function () {
		Route::post('load', [AntrianCtrl::class, 'load'])->name('antrian-load');
		Route::post('add', [AntrianCtrl::class, 'add'])->name('antrian-add');
	});
	Route::get('ambil', [AntrianCtrl::class, 'ambil'])->name('antrian-ambil');
	Route::post('slider', [AntrianCtrl::class, 'slider'])->name('antrian-slider');
	Route::get('cs', [AntrianCtrl::class, 'cs'])->name('antrian-cs');
	Route::get('poli', [AntrianCtrl::class, 'poli'])->name('antrian-poli');
	Route::get('all', [AntrianCtrl::class, 'all'])->name('antrian-all');
	Route::prefix('display')->group(function () {
    Route::post('cs', [AntrianCtrl::class, 'displaycs'])->name('antrian-displaycs');
		Route::post('poliklinik', [AntrianCtrl::class, 'displaypoli'])->name('antrian-displaypoli');
		Route::post('all', [AntrianCtrl::class, 'displayall'])->name('antrian-all');
	});
});

Route::prefix('rooms')->group(function () {
	Route::get('status', [RoomCtrl::class, 'status'])->name('rooms-status');
	Route::post('load', [RoomCtrl::class, 'load'])->name('rooms-load');
});

Route::get('ambildatas', [AllApiCtrl::class, 'testing'])->name('testing-ambil');
Route::get('ngetest', function () {
	event(new App\Events\NewTrade("John"));
	return "Event has been sent!";
});

Route::prefix('migration')->group(function () {
	Route::get('pasien', [MigrasiCtrl::class, 'pasien'])->name('migrasi-pasien');
	Route::get('masterdanhargaobatalkes', [MigrasiCtrl::class, 'masterDanHargaObatAlkes'])->name('migrasi-masterDanHargaObatAlkes');
	Route::get('stockopname', [MigrasiCtrl::class, 'stockopname'])->name('migrasi-stockopname');
	Route::get('setupuuidstockopname', [MigrasiCtrl::class, 'setupuuidstockopname'])->name('migrasi-setupuuidstockopname');
	Route::get('logresepold', [MigrasiCtrl::class, 'logresepold'])->name('migrasi-logresepold');
	Route::get('pendaftaranold', [MigrasiCtrl::class, 'pendaftaranold'])->name('migrasi-pendaftaranold');
	Route::get('converttosmalltext', [MigrasiCtrl::class, 'converttosmalltext'])->name('migrasi-converttosmalltext');
});

Route::prefix('searchion')->group(function () {
	Route::post('searching', [SearchingCtrl::class, 'search'])->name('searchion-search');
});
