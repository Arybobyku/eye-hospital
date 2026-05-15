<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuSehat\OrganizationCtrl;
use App\Http\Controllers\SatuSehat\LocationCtrl;
use App\Http\Controllers\SatuSehat\TokenCtrl;
use App\Http\Controllers\SatuSehat\PatientSyncCtrl;
use App\Http\Controllers\SatuSehat\EncounterSyncCtrl;
use App\Http\Controllers\SatuSehat\WilayahCtrl;
use App\Http\Controllers\SatuSehat\ApiLogCtrl;
use App\Http\Controllers\SatuSehat\PractitionerSyncCtrl;

/*
|--------------------------------------------------------------------------
| SatuSehat API Routes (dipanggil oleh Vue SPA di /dashboard)
| Prefix: /satusehat-api — lihat RouteServiceProvider.php
|--------------------------------------------------------------------------
*/

// ── Organization ──────────────────────────────────────────────────────────
Route::prefix('organization')->group(function () {
    Route::post('profile', [OrganizationCtrl::class, 'profile'])->name('satusehat-org-profile');
    Route::post('list',   [OrganizationCtrl::class, 'list'])  ->name('satusehat-org-list');
    Route::post('add',    [OrganizationCtrl::class, 'add'])   ->name('satusehat-org-add');
    Route::post('edit',   [OrganizationCtrl::class, 'edit'])  ->name('satusehat-org-edit');
    Route::post('update', [OrganizationCtrl::class, 'update'])->name('satusehat-org-update');
});

// ── Location ──────────────────────────────────────────────────────────────
Route::prefix('location')->group(function () {
    Route::post('profile', [LocationCtrl::class, 'profile'])->name('satusehat-loc-profile');
    Route::post('list',    [LocationCtrl::class, 'list'])   ->name('satusehat-loc-list');
    Route::post('add',     [LocationCtrl::class, 'add'])    ->name('satusehat-loc-add');
    Route::post('edit',    [LocationCtrl::class, 'edit'])   ->name('satusehat-loc-edit');
    Route::post('update',  [LocationCtrl::class, 'update']) ->name('satusehat-loc-update');
});

// ── Patient Sync ───────────────────────────────────────────────────────────
Route::prefix('patient-sync')->group(function () {
    Route::post('dashboard',    [PatientSyncCtrl::class, 'dashboard'])   ->name('satusehat-patient-dashboard');
    Route::post('list',         [PatientSyncCtrl::class, 'list'])        ->name('satusehat-patient-list');
    Route::post('run-sync',     [PatientSyncCtrl::class, 'runSync'])     ->name('satusehat-patient-run-sync');
    Route::post('retry-failed', [PatientSyncCtrl::class, 'retryFailed'])->name('satusehat-patient-retry');
    Route::post('create-one',   [PatientSyncCtrl::class, 'createOne'])  ->name('satusehat-patient-create-one');
    Route::post('create-bulk',  [PatientSyncCtrl::class, 'createBulk']) ->name('satusehat-patient-create-bulk');
});

// ── Encounter Sync ─────────────────────────────────────────────────────────
Route::prefix('encounter-sync')->group(function () {
    Route::post('dashboard',    [EncounterSyncCtrl::class, 'dashboard'])   ->name('satusehat-encounter-dashboard');
    Route::post('list',         [EncounterSyncCtrl::class, 'list'])        ->name('satusehat-encounter-list');
    Route::post('run-sync',     [EncounterSyncCtrl::class, 'runSync'])     ->name('satusehat-encounter-run-sync');
    Route::post('retry-failed', [EncounterSyncCtrl::class, 'retryFailed'])->name('satusehat-encounter-retry');
    Route::post('set-location', [EncounterSyncCtrl::class, 'setLocation'])->name('satusehat-encounter-set-location');
    Route::post('sync-one',     [EncounterSyncCtrl::class, 'syncOne'])    ->name('satusehat-encounter-sync-one');
});

// ── Access Token ───────────────────────────────────────────────────────────
Route::prefix('token')->group(function () {
    Route::post('status',  [TokenCtrl::class, 'status']) ->name('satusehat-token-status');
    Route::post('refresh', [TokenCtrl::class, 'refresh'])->name('satusehat-token-refresh');
});

// ── Wilayah (Administrative Area Cache) ────────────────────────────────────
Route::prefix('wilayah')->group(function () {
    Route::post('dashboard',      [WilayahCtrl::class, 'dashboard'])    ->name('satusehat-wilayah-dashboard');
    Route::post('list',           [WilayahCtrl::class, 'list'])         ->name('satusehat-wilayah-list');
    Route::post('fetch',          [WilayahCtrl::class, 'fetch'])        ->name('satusehat-wilayah-fetch');
    Route::post('select',         [WilayahCtrl::class, 'select'])       ->name('satusehat-wilayah-select');
    Route::post('sync-to-master',   [WilayahCtrl::class, 'syncToMaster'])   ->name('satusehat-wilayah-sync-master');
    Route::post('master-stats',     [WilayahCtrl::class, 'masterStats'])    ->name('satusehat-wilayah-master-stats');
    Route::post('fetch-all',        [WilayahCtrl::class, 'fetchAll'])       ->name('satusehat-wilayah-fetch-all');
    Route::post('sync-all-to-master', [WilayahCtrl::class, 'syncAllToMaster'])->name('satusehat-wilayah-sync-all');
});

// ── API Logs ───────────────────────────────────────────────────────────────
Route::prefix('api-logs')->group(function () {
    Route::post('dashboard', [ApiLogCtrl::class, 'dashboard'])->name('satusehat-apilog-dashboard');
    Route::post('list',      [ApiLogCtrl::class, 'list'])     ->name('satusehat-apilog-list');
    Route::post('detail',    [ApiLogCtrl::class, 'detail'])   ->name('satusehat-apilog-detail');
    Route::post('clear',     [ApiLogCtrl::class, 'clear'])    ->name('satusehat-apilog-clear');
    Route::post('clear-all', [ApiLogCtrl::class, 'clearAll']) ->name('satusehat-apilog-clear-all');
});

// ── Practitioner Sync ─────────────────────────────────────────────────────
Route::prefix('practitioner-sync')->group(function () {
    Route::post('dashboard',  [PractitionerSyncCtrl::class, 'dashboard']) ->name('satusehat-practitioner-dashboard');
    Route::post('list',       [PractitionerSyncCtrl::class, 'list'])      ->name('satusehat-practitioner-list');
    Route::post('sync-one',   [PractitionerSyncCtrl::class, 'syncOne'])   ->name('satusehat-practitioner-sync-one');
    Route::post('sync-bulk',  [PractitionerSyncCtrl::class, 'syncBulk'])  ->name('satusehat-practitioner-sync-bulk');
});
