<?php

use App\Http\Controllers\Master\RekamMedisCtrl;
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
use App\Http\Controllers\Master\PasienCtrl;

Route::group(['middleware' => 'throttle: 250, 1'], function(){
	Route::prefix('pasien')->group(function () {
		Route::post('list', [PasienCtrl::class, 'list'])->name('master-pasien-list');;
		Route::get('listexcel', [PasienCtrl::class, 'listexcel'])->name('master-pasien-listexcel');
		Route::post('obat', [PasienCtrl::class, 'obat'])->name('master-pasien-obat');
		Route::post('tindakan', [PasienCtrl::class, 'tindakan'])->name('master-pasien-tindakan');
		Route::post('kunjungan', [PasienCtrl::class, 'kunjungan'])->name('master-pasien-kunjungan');

		// RME
		Route::post('tindakan-pasien', [PasienCtrl::class, 'tindakanPasien'])->name('master-pasien-tindakan');
		Route::post('tanda-umum-pasien', [PasienCtrl::class, 'tandaUmumPasien'])->name('master-pasien-tanda-umum-pasien');
		Route::post('history', [PasienCtrl::class, 'history'])->name('master-pasien-history');
		Route::post('search', [PasienCtrl::class, 'search'])->name('master-pasien-search');
		Route::post('soap', [PasienCtrl::class, 'soap'])->name('master-pasien-soap');

		Route::post('dokumen-pertujuan-penolakan-tindakan-dokter', [PasienCtrl::class, 'dokumenPersetujuanPenolakan'])->name('master-pasien-persetujuan-penolkan-tindakan-dokter');
		Route::post('list-dokumen-persetujuan-penolkan', [PasienCtrl::class, 'listDokumenPersetujuanPenolakan'])->name('master-pasien-list-persetujuan-penolkan-tindakan-dokter');
		
		Route::post('dokumen-persetujuan-umum', [PasienCtrl::class, 'dokumenPersetujuanUmum'])->name('dokumen-persetujuan-umum');
		Route::post('list-dokumen-persetujuan-umum', [PasienCtrl::class, 'listDokumenPersetujuanUmum'])->name('list-dokumen-pertujuan-umum');

		// Lampiran
		Route::post('dokumen-form-laser-bargage', [PasienCtrl::class, 'storeFormLaseBarage'])->name('master-pasien-storeFormLaseBarage');
		Route::post('dokumen-laporan-pembedahan', [PasienCtrl::class, 'storeLaporanPembedahan'])->name('master-pasien-storeLaporanPembedahan');
		Route::post('dokumen-balance-cairan-harian', [PasienCtrl::class, 'storeBalanceCairanHarian'])->name('master-pasien-storeBalanceCairanHarian');
		Route::post('dokumen-resume-perawatan-rawat-jalan', [PasienCtrl::class, 'storeResumePerawatanRawatJalan'])->name('master-pasien-storeResumePerawatanRawatJalan');
		Route::post('dokumen-surat-penolakan-rujukan', [PasienCtrl::class, 'storeSuratPenolakanRujukan'])->name('master-pasien-storeSuratPenolakanRujukan');
		Route::post('dokumen-surat-kontrol', [PasienCtrl::class, 'storeSuratKontrol'])->name('master-pasien-storeSuratKontrol');
		Route::post('dokumen-surat-konsul', [PasienCtrl::class, 'storeSuratKonsul'])->name('master-pasien-storeSuratKonsul');
		Route::post('dokumen-surat-balasan-konsul', [PasienCtrl::class, 'storeSuratBalasanKonsul'])->name('master-pasien-storeSuratBalasanKonsul');
		Route::post('dokumen-surat-pernyataan-batal-operasi', [PasienCtrl::class, 'storeSuratPernyataanBatalOperasi'])->name('master-pasien-storeSuratPernyataanBatalOperasi');
		Route::post('dokumen-surat-pernyataan-pasien-umum', [PasienCtrl::class, 'storeSuratPernyataanPasienUmum'])->name('master-pasien-storeSuratPernyataanPasienUmum');
		Route::post('dokumen-dietitian-pasien-baru', [PasienCtrl::class, 'storeDokumenDietitianPasienBaru'])->name('master-pasien-storeDokumenDietitianPasienBaru');
		Route::post('dokumen-asuhan-gizi', [PasienCtrl::class, 'storeDokumenAsuhanGizi'])->name('master-pasien-storeDokumenAsuhanGizi');
		Route::post('dokumen-laser-lpi', [PasienCtrl::class, 'storeDokumenLaserLPI'])->name('master-pasien-storeDokumenLaserLPI');
		Route::post('dokumen-laser-prp', [PasienCtrl::class, 'storeDokumenLaserPRP'])->name('master-pasien-storeDokumenLaserLPI');
	});

	Route::prefix('rekammedis')->group(function () {
		Route::post('list', [RekamMedisCtrl::class, 'list'])->name('master-rekammedis-list');
		Route::get('listexcel', [RekamMedisCtrl::class, 'listexcel'])->name('master-rekammedis-listexcel');
		Route::post('statsjumlahpengunjung', [RekamMedisCtrl::class, 'statsjumlahpengunjung'])->name('master-rekammedis-statsjumlahpengunjung');
		Route::post('statsjumlahkunjungan', [RekamMedisCtrl::class, 'statsjumlahkunjungan'])->name('master-rekammedis-statsjumlahkunjungan');
		Route::post('statspenyakitterbanyak', [RekamMedisCtrl::class, 'statspenyakitterbanyak'])->name('master-rekammedis-statspenyakitterbanyak');


		// Data Lampiran
		Route::post('list-lampiran', [RekamMedisCtrl::class, 'listLampiran']);
		Route::get('lampiran/{uuid}', [RekamMedisCtrl::class, 'getDetailLampiran']);
		Route::delete('lampiran/{uuid}', [RekamMedisCtrl::class, 'deleteLampiran']);

		
	});
});