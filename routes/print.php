<?php

use App\Http\Controllers\Bedah\PrintBedahCtrl;
use App\Http\Controllers\Finance\PrintKasirCtrl;
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

use App\Http\Controllers\Finance\PrintKasirInapCtrl;
use App\Http\Controllers\RawatJalan\PrintRekamMedisCtrl;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'throttle: 250, 1'], function () {
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

    //REKAM MEDIS GENERAL
    Route::get('rekammedis/general/kronologis/{uuid}', [PrintRekamMedisCtrl::class, 'printKronologis']);
    Route::get('rekammedis/general/suratkonsul/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratKonsul']);
    Route::get('rekammedis/general/formlaserbarrage/{uuid}', [PrintRekamMedisCtrl::class, 'printFormLaserBarrage']);
    Route::get('rekammedis/general/formlaserfokal/{uuid}', [PrintRekamMedisCtrl::class, 'printFormLaserFokal']);
    Route::get('rekammedis/general/formtindakanepilasi/{uuid}', [PrintRekamMedisCtrl::class, 'printFormTindakanEpilasi']);
    Route::get('rekammedis/general/laporaninjeksi/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanInjeksi']);
    Route::get('rekammedis/general/tindakanlaserlpi/{uuid}', [PrintRekamMedisCtrl::class, 'printTindakanLaserLPI']);
    Route::get('rekammedis/general/formlaserprp/{uuid}', [PrintRekamMedisCtrl::class, 'printFormLaserPRP']);
    Route::get('rekammedis/general/formlasercapsulotomy/{uuid}', [PrintRekamMedisCtrl::class, 'printFormLaserCapsulotomy']);
    Route::get('rekammedis/general/suratbalasankonsul/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratBalasanKonsul']);    
    Route::get('rekammedis/general/formpermintaanpulang/{uuid}', [PrintRekamMedisCtrl::class, 'printFormPermintaanPulang']);
    Route::get('rekammedis/general/suratpenolakanrujukan/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratPenolakanRujukan']);
    Route::get('rekammedis/general/suratpengantaruntukdirawatinap/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratPengantarUntukDiRawatInap']);    
    Route::get('rekammedis/general/formcpptranap/{uuid}', [PrintRekamMedisCtrl::class, 'printFormCpptRanap']);    
    Route::get('rekammedis/general/pengkajiankeperawatanmata/{uuid}', [PrintRekamMedisCtrl::class, 'printPengkajianKeperawatanMata']);    
    Route::get('rekammedis/general/catatankeperawatan/{uuid}', [PrintRekamMedisCtrl::class, 'printCatatanKeperawatan']);    
    Route::get('rekammedis/general/resumemedis/{uuid}', [PrintRekamMedisCtrl::class, 'printResumeMedis']);
    Route::get('rekammedis/general/laporaneksisichalazion/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanEksisiChalazion']);     
    Route::get('rekammedis/general/laporanoperasitrabekulektomi/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanOperasiTrabekulektomi']);
    Route::get('rekammedis/general/laporanoperasipterygium/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanOperasiPterygium']);
    Route::get('rekammedis/general/laporaneksisipalbera/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanEksisiPalbera']);
    Route::get('rekammedis/general/balancecairanharian/{uuid}', [PrintRekamMedisCtrl::class, 'printBalanceCairanHarian']);
    Route::get('rekammedis/general/kunjunganawaldietitianpadapasienbaru/{uuid}', [PrintRekamMedisCtrl::class, 'printKunjunganAwalDietitianPadaPasienBaru']);
    Route::get('rekammedis/general/asuhangizi/{uuid}', [PrintRekamMedisCtrl::class, 'printAsuhanGizi']);
    Route::get('rekammedis/general/suratpernyataanpasienumum/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratPernyataanPasienUmum']);
    Route::get('rekammedis/general/suratkontrolulang/{uuid}', [PrintRekamMedisCtrl::class, 'printSuratKontrolUlang']);
    Route::get('rekammedis/general/formulirkonsuldanjawabankonsul/{uuid}', [PrintRekamMedisCtrl::class, 'printFormulirKonsulDanJawabanKonsul']);
    Route::get('rekammedis/general/voucherrawatinap/{uuid}', [PrintRekamMedisCtrl::class, 'printVoucherRawatInap']);
    Route::get('rekammedis/general/prosesperawatanperioperatif/{uuid}', [PrintRekamMedisCtrl::class, 'printProsesPerawatanPeriOperatif']);
    Route::get('rekammedis/general/monitoringefeksampingobat/{uuid}', [PrintRekamMedisCtrl::class, 'printMonitoringEfekSampingObat']);
    Route::get('rekammedis/general/forumulirreaksitransfusidarah/{uuid}', [PrintRekamMedisCtrl::class, 'printFormulirReaksiTranfusiDarah']);
    Route::get('rekammedis/general/penolakantindakananestesi/{uuid}', [PrintRekamMedisCtrl::class, 'printPenolakanTindakanAnestesi']);
    Route::get('rekammedis/general/suratpernyataanbataloperasi/{uuid}', [PrintRekamMedisCtrl::class, 'suratpernyataanbataloperasi']);
    
    // REKAM MEDIS RAWAT JALAN
	Route::get('rekammedis/{uuid}', [PrintRekamMedisCtrl::class, 'print']);
	Route::get('persetujuan/{uuid}', [PrintBedahCtrl::class, 'print']);
	Route::get('rekammedis/rawat-jalan/cppt/{uuid}', [PrintRekamMedisCtrl::class, 'cppt']);
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
    // Route::get('rekammedis/bedah/rm8dot8/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot8']);
    // Route::get('rekammedis/bedah/rm8dot9/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot9']);
    // Route::get('rekammedis/bedah/rm8dot10/{uuid}', [PrintRekamMedisCtrl::class, 'printRm8dot10']);
    // Route::get('rekammedis/bedah/rm9dot0/{uuid}', [PrintRekamMedisCtrl::class, 'printRm9dot0']);
    // Route::get('rekammedis/bedah/rm9dot1/{uuid}', [PrintRekamMedisCtrl::class, 'printRm9dot1']);
    Route::get('rekammedis/rawat-jalan/all/{uuid}', [PrintRekamMedisCtrl::class, 'all']);
    Route::get('rekammedis/bedah/all_bedah/{uuid}', [PrintRekamMedisCtrl::class, 'all_bedah']);
    Route::get('rekammedis/obat/print/{uuid}', [PrintRekamMedisCtrl::class, 'printRacikanObat']);
    Route::get('rekammedis/lampiran/rekam-medis-rawat-inap/{uuid}', [PrintRekamMedisCtrl::class, 'printResumeMedisRawatInap']);
    Route::get('rekammedis/lampiran/rekam-medis-rawat-jalan/{uuid}', [PrintRekamMedisCtrl::class, 'printResumeMedisRawatJalan']);
    Route::get('rekammedis/lampiran/rekam-medis-perawatan-rawat-jalan/{uuid}', [PrintRekamMedisCtrl::class, 'printResumeMedisPerawatanRawatJalan']);
    Route::get('rekammedis/lampiran/cppt-rawat-inap/{uuid}', [PrintRekamMedisCtrl::class, 'printCpptRawatInap']);
    Route::get('rekammedis/lampiran/catatan-keperawatan/{uuid}', [PrintRekamMedisCtrl::class, 'printCatatanKeperawatan']);
    Route::get('rekammedis/lampiran/monitoring-efek-samping-obat/{uuid}', [PrintRekamMedisCtrl::class, 'printMonitoringEfekSampingObat']);
    Route::get('rekammedis/lampiran/status-anestesi/{uuid}', [PrintRekamMedisCtrl::class, 'printMonitoringEfekSampingObat']);
    Route::get('rekammedis/lampiran/laporan-operasi-vitreo-retina/{uuid}', [PrintRekamMedisCtrl::class, 'printLaporanOperasiVitreoRetina']);
});
