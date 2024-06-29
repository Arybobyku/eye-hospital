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

	// REKAM MEDIS RAWAT JALAN
	Route::get('rekammedis/{uuid}', [PrintRekamMedisCtrl::class, 'print']);
	Route::get('rekammedis/rawat-jalan/rm1dot1/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot1']);
	Route::get('rekammedis/rawat-jalan/rm1dot3/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot3']);
	Route::get('rekammedis/rawat-jalan/rm1dot4/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot4']);
	Route::get('rekammedis/rawat-jalan/rm1dot5/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot5']);
	Route::get('rekammedis/rawat-jalan/rm1dot7/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot7']);
	Route::get('rekammedis/rawat-jalan/all/{uuid}', [PrintRekamMedisCtrl::class, 'all']);

});