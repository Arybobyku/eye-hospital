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
use App\Http\Controllers\Igd\PasienCtrl;
use App\Http\Controllers\Igd\RegistrasiCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){

	Route::prefix('pasien')->group(function () {
		Route::post('list', [PasienCtrl::class, 'list'])->name('cs-pasien-list');
		Route::post('add', [PasienCtrl::class, 'add'])->name('cs-pasien-add');
		Route::post('edit', [PasienCtrl::class, 'edit'])->name('cs-pasien-edit');
		Route::post('update', [PasienCtrl::class, 'update'])->name('cs-pasien-update');
		Route::post('detail', [PasienCtrl::class, 'detail'])->name('cs-pasien-detail');

		Route::prefix('registrasi')->group(function () {
			Route::post('page', [RegistrasiCtrl::class, 'page'])->name('cs-registrasi-page');
			Route::post('igd', [RegistrasiCtrl::class, 'igd'])->name('cs-registrasi-igd');
			Route::post('editigd', [RegistrasiCtrl::class, 'editigd'])->name('cs-registrasi-editigd');
			Route::post('canceligd', [RegistrasiCtrl::class, 'canceligd'])->name('cs-registrasi-canceligd');
		});
	});

});