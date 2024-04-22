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
use App\Http\Controllers\Bpjs\DiagnosaCtrl;
use App\Http\Controllers\Bpjs\DokterCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function () {

    Route::prefix('diagnosa')->group(function () {
        Route::post('list', [DiagnosaCtrl::class, 'list'])->name('bpjs-diagnosa-list');
    });

    Route::prefix('dokter')->group(function () {
        Route::post('list', [DokterCtrl::class, 'list'])->name('bpjs-dokter-list');
    });
});