<?php

use App\Http\Controllers\SatuSehat\SatuSehatPatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('', function (Request $request) {
    return "ok";
});


Route::prefix('satusehat')->group(function () {
    Route::post('pasien/{uuid}', [SatuSehatPatientController::class, 'registerPatient']);
    Route::get('pasien/{uuid}', [SatuSehatPatientController::class, 'getPatient']);
});

