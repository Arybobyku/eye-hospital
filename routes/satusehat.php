<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuSehat\OrganizationCtrl;
use App\Http\Controllers\SatuSehat\LocationCtrl;
use App\Http\Controllers\SatuSehat\TokenCtrl;
use App\Http\Controllers\SatuSehat\PatientSyncCtrl;
use App\Http\Controllers\SatuSehat\EncounterSyncCtrl;

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
