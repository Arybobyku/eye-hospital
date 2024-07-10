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

	// REKAM MEDIS RAWAT JALAN
	Route::get('rekammedis/{uuid}', [PrintRekamMedisCtrl::class, 'print']);
	Route::get('persetujuan/{uuid}', [PrintBedahCtrl::class, 'print']);
	Route::get('rekammedis/rawat-jalan/rm1dot1/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot1']);
	Route::get('rekammedis/rawat-jalan/rm1dot2/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot2']);
	Route::get('rekammedis/rawat-jalan/rm1dot3/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot3']);
	Route::get('rekammedis/rawat-jalan/rm1dot4/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot4']);
	Route::get('rekammedis/rawat-jalan/rm1dot5/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot5']);
	Route::get('rekammedis/rawat-jalan/rm1dot6/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot6']);
	Route::get('rekammedis/rawat-jalan/rm1dot7/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot7']);
    Route::get('rekammedis/bedah/rm1dot10/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot10']);
	Route::get('rekammedis/bedah/rm1dot8/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot8']);
	Route::get('rekammedis/bedah/rm1dot9/{uuid}', [PrintRekamMedisCtrl::class, 'printRm1dot9']);
	Route::get('rekammedis/bedah/rm2dot0/{uuid}', [PrintRekamMedisCtrl::class, 'printRm2dot0']);
	Route::get('rekammedis/bedah/rm2dot2/{uuid}', [PrintRekamMedisCtrl::class, 'printRm2dot2']);
	Route::get('rekammedis/bedah/rm2dot3/{uuid}', [PrintRekamMedisCtrl::class, 'printRm2dot3']);
	Route::get('rekammedis/bedah/rm2dot9/{uuid}', [PrintRekamMedisCtrl::class, 'printRm2dot9']);
	Route::get('rekammedis/bedah/rm4dot9/{uuid}', [PrintRekamMedisCtrl::class, 'printRm4dot9']);
	Route::get('rekammedis/bedah/rm8dot7/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot7']);
	Route::get('rekammedis/bedah/rm8dot8/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot8']);
	Route::get('rekammedis/bedah/rm8dot9/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot9']);
	Route::get('rekammedis/bedah/rm8dot10/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot10']);
	Route::get('rekammedis/bedah/rm9dot0/{uuid}', [PrintRekamMedisCtrl::class, 'printRm9dot0']);
	Route::get('rekammedis/bedah/rm9dot1/{uuid}', [PrintRekamMedisCtrl::class, 'printRm9dot1']);
	Route::get('rekammedis/rawat-jalan/all/{uuid}', [PrintRekamMedisCtrl::class, 'all']);

});