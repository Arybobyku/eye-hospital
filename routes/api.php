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
    // PASIEN
    Route::post('pasien/{uuid}', [SatuSehatPatientController::class, 'setPatient']);
    Route::get('pasien/{uuid}', [SatuSehatPatientController::class, 'getPatient']);
    // PRAKTISI
    Route::post('praktisi', [SatuSehatPatientController::class, 'setPraktisi']);
    Route::get('praktisi', [SatuSehatPatientController::class, 'getPraktisi']);
    // ORGANISASI
    Route::post('organisasi', [SatuSehatPatientController::class, 'setOrganisasi']);
    Route::get('organisasi', [SatuSehatPatientController::class, 'getOrganisasi']);
    // LOCATION
    Route::post('lokasi', [SatuSehatPatientController::class, 'setLocation']);
    // Route::get('lokasi', [SatuSehatPatientController::class, 'getOrganisasi']);
});

