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

Route::group(['middleware' => 'throttle: 250, 1'], function () {
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
		Route::post('get-dokumen-persetujuan-penolkan', [PasienCtrl::class, 'getDokumenPersetujuanPenolakan'])->name('master-pasien-get-persetujuan-penolkan');
		Route::post('update-dokumen-persetujuan-penolkan', [PasienCtrl::class, 'updateDokumenPersetujuanPenolakan'])->name('master-pasien-update-persetujuan-penolkan');
		Route::post('delete-dokumen-persetujuan-penolkan', [PasienCtrl::class, 'deleteDokumenPersetujuanPenolakan'])->name('master-pasien-delete-persetujuan-penolkan');

		Route::post('dokumen-persetujuan-umum', [PasienCtrl::class, 'dokumenPersetujuanUmum'])->name('dokumen-persetujuan-umum');
		Route::post('list-dokumen-persetujuan-umum', [PasienCtrl::class, 'listDokumenPersetujuanUmum'])->name('list-dokumen-pertujuan-umum');
		Route::post('get-dokumen-persetujuan-umum', [PasienCtrl::class, 'getDokumenPersetujuanUmum'])->name('get-dokumen-persetujuan-umum');
		Route::post('update-dokumen-persetujuan-umum', [PasienCtrl::class, 'updateDokumenPersetujuanUmum'])->name('update-dokumen-persetujuan-umum');
		Route::post('delete-dokumen-persetujuan-umum', [PasienCtrl::class, 'deleteDokumenPersetujuanUmum'])->name('delete-dokumen-persetujuan-umum');

		Route::post('dokumen-list', [PasienCtrl::class, 'dokumenList'])->name('master-pasien-dokumen-list');
		Route::post('dokumen-store', [PasienCtrl::class, 'dokumenStore'])->name('master-pasien-dokumen-store');
		Route::post('dokumen-update', [PasienCtrl::class, 'dokumenUpdate'])->name('master-pasien-dokumen-update');
		Route::post('dokumen-delete', [PasienCtrl::class, 'dokumenDelete'])->name('master-pasien-dokumen-delete');
		Route::post('dokumen-verify', [PasienCtrl::class, 'dokumenVerify'])->name('master-pasien-dokumen-verify');
		Route::post('dokumen-download', [PasienCtrl::class, 'dokumenDownload'])->name('master-pasien-dokumen-download');

		// Lampiran
		Route::post('dokumen-laser-barrage', [PasienCtrl::class, 'storeFormLaserBarrage'])->name('master-pasien-storeFormLaserBarrage');
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
		Route::post('dokumen-ceklist-kesiapan-bedah', [PasienCtrl::class, 'storeDokumenCeklistKesiapanBedah']);
		Route::post('form-edukasi-pasien-dan-keluarga-rawat-jalan', [PasienCtrl::class, 'storeFormEdukasiPasienDanKeluargaRawatJalan']);
		Route::post('form-persetujuan-umum-pasien-keluarga', [PasienCtrl::class, 'storeFormPersetujuanUmumPasienKeluarga']);
		Route::post('form-proses-perawatan-peri-operative', [PasienCtrl::class, 'storeFormProsesPerawatanPeriOperative']);
		Route::post('form-pendidikan-edukasi-pasien-keluarga-terintegrasi-rawat-inap', [PasienCtrl::class, 'storeFormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap']);
		Route::post('penolakan-tindakan-anestesi', [PasienCtrl::class, 'storePenolakanTindakanAnestesi']);
		Route::post('form-pengkajian-keperawatan-mata-rawat-jalan', [PasienCtrl::class, 'storeFormPengkajianKeperawatanMataRawatJalan']);
		Route::post('form-laporan-injeksi', [PasienCtrl::class, 'storeFormLaporanInjeksi']);
		Route::post('form-permintaan-pulang', [PasienCtrl::class, 'storeFormPermintaanPulang']);
		Route::post('voucher-rawat-inap', [PasienCtrl::class, 'storeVoucherRawatInap']);
		Route::post('form-reaksi-transfusi-darah', [PasienCtrl::class, 'storeFormReaksiTransfusiDarah']);
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
		Route::post('dokumen-laser-fokal', [PasienCtrl::class, 'storeFormLaserFokal'])->name('master-pasien-storeFormLaserFokal');
		Route::post('dokumen-status-anestesi', [PasienCtrl::class, 'storeStatusAnestesi'])->name('master-pasien-storeStatusAnestesi');
		Route::post('dokumen-laporan-operasi-vitreo-retina', [PasienCtrl::class, 'storeLaporanOperasiVitreoRetina'])->name('master-pasien-storeLaporanOperasiVitreoRetina');
		
		//master
		Route::get('master-dokter-all', [PasienCtrl::class, 'masterDokter'])->name('master-dokter-all');

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
		Route::post('lampiran/{uuid}/detail', [RekamMedisCtrl::class, 'getDetailLampiran']);  // ✅ UBAH JADI POST DAN TAMBAH /detail
		Route::delete('lampiran/{uuid}', [RekamMedisCtrl::class, 'deleteLampiran']);


		// Assign dokter untuk tanda tangan lampiran
		Route::post('lampiran/assign-dokter', [RekamMedisCtrl::class, 'assignDokter']);

		// Update status assign (direview -> ditandatangan)
		Route::post('lampiran/assign-dokter/update-status', [RekamMedisCtrl::class, 'updateStatusAssign']);

		// Get list dokter (untuk dropdown pilih dokter di modal)
		Route::post('lampiran/list-dokter', [RekamMedisCtrl::class, 'listDokterForAssign']);
		Route::post('tanda-tangan-dokter/list', [RekamMedisCtrl::class, 'listTandaTanganDokter']);
	});
});
