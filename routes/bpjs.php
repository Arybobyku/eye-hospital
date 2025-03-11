<?php


use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;
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

Route::group([], function () {

    Route::prefix('diagnosa')->group(function () {
        Route::post('list', [DiagnosaCtrl::class, 'list'])->name('bpjs-diagnosa-list');
    });

    Route::prefix('dokter')->group(function () {
        Route::post('list', [DokterCtrl::class, 'list'])->name('bpjs-dokter-list');
    });

    // BPJS Antrol WS
    Route::prefix('antrol-bpjs')->group(function () {
        Route::get('ref/dokter', [AntrolBpjsCtrl::class, 'referensiDokter']);
        Route::get('ref/poli', [AntrolBpjsCtrl::class, 'referensiPoli']);
        Route::get('sync/poli', [AntrolBpjsCtrl::class, 'syncPoli']);
        Route::get('sync/dokter', [AntrolBpjsCtrl::class, 'syncDokter']);
        Route::get('ref/poli/fp', [AntrolBpjsCtrl::class, 'referensiPoliFingerPrint']);
        Route::get('ref/pasien/fp/identitas/{nik}/noidentitas/{noidentitas}', [AntrolBpjsCtrl::class, 'referensiPasienFingerPrint']);
        
        Route::get('jadwaldokter/kodepoli/{params1}/tanggal/{params2}', [AntrolBpjsCtrl::class, 'referensiJadwalDokter']);

        Route::get('antrean/pendaftaran/aktif', [AntrolBpjsCtrl::class, 'antrianBelumDilayani']);
        Route::get('antrean/getlisttask', [AntrolBpjsCtrl::class, 'listTask']);
        Route::get('antrean/pendaftaran/kodebooking/{param1}', [AntrolBpjsCtrl::class, 'getAntrianByKodeBooking']);

        //Yudha
        Route::post('jadwaldokter/updatejadwaldokter', [AntrolBpjsCtrl::class, 'updateJadwalDokter']);
        Route::post('antrean/add', [AntrolBpjsCtrl::class, 'tambahAntrean']);
        Route::post('antrean/farmasi/add', [AntrolBpjsCtrl::class, 'tambahAntreanFarmasi']);
        Route::post('antrean/updatewaktu', [AntrolBpjsCtrl::class, 'updateWaktuAntrean']);
        Route::post('antrean/batal', [AntrolBpjsCtrl::class, 'batalAntrean']);
        Route::post('antrean/getlisttask', [AntrolBpjsCtrl::class, 'listWaktuTaskId']);

        Route::get('dashboard/waktutunggu/tanggal/{params1}/waktu/{params2}', [AntrolBpjsCtrl::class, 'dashboardPerTanggal']);
        Route::get('dashboard/waktutunggu/bulan/{params1}/tahun/{params2}/waktu/{params3}', [AntrolBpjsCtrl::class, 'dashboardPerBulan']);

    });
});
