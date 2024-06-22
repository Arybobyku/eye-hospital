<?php

use App\Http\Controllers\Bedah\PrintBedahCtrl;
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

use App\Http\Controllers\Finance\PrintKasirCtrl;
use App\Http\Controllers\Finance\PrintKasirInapCtrl;
use App\Http\Controllers\RawatJalan\PrintRekamMedisCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::get('kasir/{uuid}', [PrintKasirCtrl::class, 'print']);
	Route::get('kasirinap/{uuid}', [PrintKasirInapCtrl::class, 'print']);
	Route::get('claim/{uuid}', [PrintKasirCtrl::class, 'claim']);
	Route::get('pengantar/{uuid}', [PrintKasirCtrl::class, 'pengantar']);
	// Route::get('kasirinap/{uuid}', [PrintKasirCtrl::class, 'printinap']);
	Route::get('kasirrincian/{uuid}', [PrintKasirCtrl::class, 'printrincian']);
	Route::get('kasirrincianinap/{uuid}', [PrintKasirInapCtrl::class, 'printrincian']);
	Route::get('bedahkasir/{uuid}', [PrintKasirCtrl::class, 'printinap']);
	Route::get('bedahkasirrincian/{uuid}', [PrintKasirCtrl::class, 'printrincian']);
	Route::get('kasirbeli/{uuid}', [PrintKasirCtrl::class, 'printbeli']);
	Route::get('panjar/{uuid}', [PrintKasirCtrl::class, 'panjar']);
	Route::get('rekammedis/{uuid}', [PrintRekamMedisCtrl::class, 'print']);
	Route::get('persetujuan/{uuid}', [PrintBedahCtrl::class, 'print']);

});