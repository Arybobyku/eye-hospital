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

		Route::post('/pengkajian-data-umum', [PasienCtrl::class, 'pengkajianDataUmum'])->name('master-pasien-pengkajian-data-umum');
		Route::post('/list-pengkajian-data-umum', [PasienCtrl::class, 'listPengkajianDataUmum'])->name('master-pasien-list-pengkajian-data-umum');

		// ✅ TAMBAHAN: Route untuk update dan delete
		Route::post('/pengkajian-data-umum-update/{id}', [PasienCtrl::class, 'updatePengkajianDataUmum'])->name('master-pasien-update-pengkajian-data-umum');
		Route::delete('/pengkajian-data-umum/{id}', [PasienCtrl::class, 'deletePengkajianDataUmum'])->name('master-pasien-delete-pengkajian-data-umum');
		Route::get('/pengkajian-data-umum/{id}', [PasienCtrl::class, 'getPengkajianDataUmum'])->name('master-pasien-get-pengkajian-data-umum');

		// Route::post('penunjang-medis-list', [PasienCtrl::class, 'penunjangMedisList'])->name('master-pasien-penunjang-medis-list');
		// Route::post('list-penunjang-medis', [PasienCtrl::class, 'listPenunjangMedis'])->name('master-pasien-list-penunjang_medis');

		 // Routes Laboratorium
		Route::prefix('laboratorium')->group(function () {
        Route::get('hasil-pemeriksaan', [PasienCtrl::class, 'hasilPemeriksaan']);
        Route::post('hasil-upload-laboratorium', [PasienCtrl::class, 'hasilUploadLaboratorium']);
        
        // ✅ PERBAIKAN: Tambahkan {uuid} parameter
        Route::post('hasil-update/{uuid}', [PasienCtrl::class, 'hasilUpdateLaboratorium']);
        
        Route::get('user-info', [PasienCtrl::class, 'userInfo']);
        
        // ✅ PERBAIKAN: Ganti method destroy menjadi deleteLab
        Route::delete('hasil/{uuid}', [PasienCtrl::class, 'deleteLab']);
        
        // ✅ TAMBAHAN: Route untuk print/view file
        Route::get('print/{uuid}', [PasienCtrl::class, 'printLab']);
    });

		// Routes Radiologi
 		Route::prefix('radiologi')->group(function () {
        Route::get('hasil-radiologi', [PasienCtrl::class, 'hasilRadiologi']);
        Route::post('hasil-upload-radiologi', [PasienCtrl::class, 'hasilUploadRadiologi']);
        
        // ✅ PERBAIKAN: Tambahkan {uuid} parameter
        Route::post('hasil-update/{uuid}', [PasienCtrl::class, 'hasilUpdateRadiologi']);
        
        // ✅ PERBAIKAN: Ganti method destroy menjadi deleteRadiologi
        Route::delete('hasil/{uuid}', [PasienCtrl::class, 'deleteRadiologi']);
        
        // ✅ PERBAIKAN: Ganti view-file menjadi menggunakan uuid
        Route::get('view-file/{uuid}', [PasienCtrl::class, 'viewFileRadiologi']);
    });
});
	

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
		Route::post('dokumen-operasi-trabekulektomi', [PasienCtrl::class, 'storeLaporanOperasiTrabekulektomi'])->name('master-pasien-storeLaporanOperasiTrabekulektomi');
		Route::post('dokumen-operasi-pterygium', [PasienCtrl::class, 'storeLaporanOperasiPterygium'])->name('master-pasien-storeLaporanOperasiPterygium');
		Route::post('dokumen-eksisi-palpebra', [PasienCtrl::class, 'storeLaporanEksisiPalpebra'])->name('master-pasien-storeLaporanEksisiPalpebra');
		Route::post('dokumen-eksisi-chalazion', [PasienCtrl::class, 'storeLaporanEksisiChalazion'])->name('master-pasien-storeLaporanEksisiChalazion');
		Route::post('asesmen-awal-keperawatan-rawat-inap', [PasienCtrl::class, 'storeAsesmenKeperawatanRawatInap'])->name('master-pasien-storeAsesmenKeperawatanRawatInap');
		Route::post('dokumen-pulang-aps', [PasienCtrl::class, 'storeDokumenPulangAPS'])->name('master-pasien-storeDokumenPulangAPS');
		Route::post('dokumen-laser-capsulotomy', [PasienCtrl::class, 'storeTindakanLaserCapsulotomy'])->name('master-pasien-storeTindakanLaserCapsulotomy');
		Route::post('dokumen-tindakan-epilasi', [PasienCtrl::class, 'storeTindakanEpilasi'])->name('master-pasien-storeTindakanEpilasi');
		Route::post('dokumen-kronologis', [PasienCtrl::class, 'storeKronologisPasien'])->name('master-pasien-storeKronologisPasien');
		Route::post('dokumen-catatan-operasi', [PasienCtrl::class, 'storeCatatanOperasi'])->name('master-pasien-storeCatatanOperasi');
		Route::post('dokumen-resume-medis-rawat-jalan', [PasienCtrl::class, 'storeResumeMedisRawatJalan'])->name('master-pasien-storeResumeMedisRawatJalan');
		Route::post('dokumen-resume-medis-rawat-inap', [PasienCtrl::class, 'storeResumeMedisRawatInap'])->name('master-pasien-storeResumeMedisRawatInap');
		Route::post('dokumen-cppt-rawat-inap', [PasienCtrl::class, 'storeCPPTRawatInap'])->name('master-pasien-storeCPPTRawatInap');
		Route::post('dokumen-monitoring-efek-samping-obat', [PasienCtrl::class, 'storeMonitoringEfekSampingObat'])->name('master-pasien-storeMonitoringEfekSampingObat');
		Route::post('dokumen-catatan-keperawatan', [PasienCtrl::class, 'storeCatatanKeperawatan'])->name('master-pasien-storeCatatanKeperawatan');
		Route::post('dokumen-form-transfer-pasien', [PasienCtrl::class, 'storeDokumenFormTransferPasien'])->name('master-pasien-storeDokumenFormTransferPasien');
		Route::post('dokumen-pelaksanaan-pencegahan-pasien-jatuh', [PasienCtrl::class, 'storeDokumenPelaksanaanPencegahanPasienJatuh'])->name('master-pasien-storeDokumenPelaksanaanPencegahanPasienJatuh');
		Route::post('dokumen-evaluasi-pra-anesthesi', [PasienCtrl::class, 'storeDokumenEvaluasiPraAnesthesi'])->name('master-pasien-storeDokumenEvaluasiPraAnesthesi');
		Route::post('dokumen-penilaian-pra-anestesi-sedasi', [PasienCtrl::class, 'storePenilaianPraAnestesiSedasi'])->name('master-pasien-storePenilaianPraAnestesiSedasi');
		//Route::post('dokumen-laporan-pembedahan', [PasienCtrl::class, 'storeLaporanPembedahan'])->name('master-pasien-storeLaporanPembedahan');
		Route::post('dokumen-surat-pengantar-rawat-inap', [PasienCtrl::class, 'storeSuratPengantarRawatInap'])->name('master-pasien-storeSuratPengantarRawatInap');
		Route::post('dokumen-pelaksanaan-pencegahan-pasien-jatuh', [PasienCtrl::class, 'storeDokumenPelaksanaanPencegahanPasienJatuh'])->name('master-pasien-storeDokumenPelaksanaanPencegahanPasienJatuh');
		Route::post('dokumen-checklist-keselamatan-pasien-operasi', [PasienCtrl::class, 'storeChecklistKeselamatanPasienOperasi'])->name('master-pasien-storeDokumenChecklistKeselamatanPasienOperasi');
		Route::post('dokumen-form-persetujuan-tindakan-anestesi', [PasienCtrl::class, 'storePersetujuanAnestesi'])->name('master-pasien-storePersetujuanAnestesi');
		
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