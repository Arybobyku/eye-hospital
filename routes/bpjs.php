<?php


use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;
use App\Http\Controllers\Bpjs\RuangPoliCtrl;
use App\Http\Controllers\Bpjs\AntrolMbjknCtrl;
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
        Route::get('ruangpoli/{params1}', [RuangPoliCtrl::class, 'referensiRuangPoli']);

        Route::get('antrean/getlisttask', [AntrolBpjsCtrl::class, 'listTask']);
        
        Route::get('antrean/pendaftaran/aktif', [AntrolBpjsCtrl::class, 'antrianBelumDilayani']);
        Route::get('antrean/pendaftaran/tanggal/{param1}', [AntrolBpjsCtrl::class, 'getAntrianByTanggal']);
        Route::get('antrean/pendaftaran/kodebooking/{param1}', [AntrolBpjsCtrl::class, 'getAntrianByKodeBooking']);
        Route::get('antrean/pendaftaran/kodepoli/{param1}/kodedokter/{param2}/hari/{param3}/jampraktek/{param4}', [AntrolBpjsCtrl::class, 'getAntrianByAll']);
        
        Route::post('jadwaldokter/updatejadwaldokter', [AntrolBpjsCtrl::class, 'updateJadwalDokter']);
        Route::post('antrean/add', [AntrolBpjsCtrl::class, 'tambahAntrean']);
        Route::post('antrean/farmasi/add', [AntrolBpjsCtrl::class, 'tambahAntreanFarmasi']);
        Route::post('antrean/updatewaktu', [AntrolBpjsCtrl::class, 'updateWaktuAntrean']);
        Route::post('antrean/batal', [AntrolBpjsCtrl::class, 'batalAntrean']);
        Route::post('antrean/getlisttask/{kodebooking}', [AntrolBpjsCtrl::class, 'listWaktuTaskId']);
        
        Route::get('dashboard/waktutunggu/tanggal/{params1}/waktu/{params2}', [AntrolBpjsCtrl::class, 'dashboardPerTanggal']);
        Route::get('dashboard/waktutunggu/bulan/{params1}/tahun/{params2}/waktu/{params3}', [AntrolBpjsCtrl::class, 'dashboardPerBulan']);

    });
    

    // API Endpoint Web Service
    Route::prefix('ws')->group(function () {
        Route::get('token', [AntrolMbjknCtrl::class, 'generateToken']);
        Route::get('payload', [AntrolMbjknCtrl::class, 'getPayload']);

        Route::post('status-antrean', [AntrolMbjknCtrl::class, 'statusAntrean']);
        Route::post('ambil-antrean', [AntrolMbjknCtrl::class, 'ambilAntrean']);
        Route::post('sisa-antrian', [AntrolMbjknCtrl::class, 'sisaAntrean']);
        Route::post('batal-antrean', [AntrolMbjknCtrl::class, 'batalAntrean']);
        Route::post('checkin', [AntrolMbjknCtrl::class, 'checkIn']);
        Route::post('info-pasien-baru', [AntrolMbjknCtrl::class, 'infoPasienBaru']);
        Route::post('jadwal-operasi-rs', [AntrolMbjknCtrl::class, 'jadwalOperasiRs']);
        Route::post('jadwal-operasi-pasien', [AntrolMbjknCtrl::class, 'jadwalOperasiPasien']);
        Route::post('ambil-antrean-farmasi', [AntrolMbjknCtrl::class, 'ambilAntreanFarmasi']);
        Route::post('status-antrean-farmasi', [AntrolMbjknCtrl::class, 'statusAntreanFarmasi']);

    });

});
