<?php

namespace App\Http\Controllers\Bedah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Bedah;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\PaketBedah;
use App\Models\ListPaketBedah;
use App\Models\LaporanPembedahan;
use App\Models\ChecklistKesiapanBedah;
use App\Models\PerawatanPeriOperative;
use App\Models\CatatanOperasiKatarak;
use App\Models\PersetujuanTindakanKedokteran;
use App\Models\KeselamatanBedah;

class DataFormBedahCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Bedah::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								// ->where('is_approve', '=', 'ya')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = Bedah::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								// ->where('is_approve', '=', 'ya')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Bedah::where('delete_soft', '=', 1)
									// ->where('is_approve', '=', 'ya')
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Bedah::where('delete_soft', '=', 1)
									// ->where('is_approve', '=', 'ya')
									->orderBy('id', 'desc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function formall(Request $request) {
		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);
	}

	public function laporanpembedahan(Request $request) {

		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'ruang_operasi' => $request->ruang_operasi,
				'akut_terencana' => $request->akut_terencana,
				'kamar' => $request->kamar,
				'tanggal' => $request->tanggal,
				'pembedahan' => $request->pembedahan,
				'ahli_anastesi' => $request->ahli_anastesi,
				'asisten_1' => $request->asisten_1,
				'asisten_2' => $request->asisten_2,
				'perawat_instrument' => $request->perawat_instrument,
				
				'ja_umum' => $request->ja_umum,
				'ja_bsp' => $request->ja_bsp,
				'ja_csp' => $request->ja_csp,
				'ja_epidural' => $request->ja_epidural,
				'ja_spiral' => $request->ja_spiral,
				'ja_lokal' => $request->ja_lokal,

				'diagnosa_pra_bedah' => $request->diagnosa_pra_bedah,
				'diagnosa_pasca_bedah' => $request->diagnosa_pasca_bedah,
				'indikasi_operasi' => $request->indikasi_operasi,
				'jenis_operasi' => $request->jenis_operasi,
				'desinfeksi_kulit_dengan' => $request->desinfeksi_kulit_dengan,
				'posisi_penderita_desinfeksi' => $request->posisi_penderita_desinfeksi,
				'jam_operasi_dimulai' => $request->jam_operasi_dimulai,
				'jam_operasi_selesai' => $request->jam_operasi_selesai,
				'lama_operasi_berlansung' => $request->lama_operasi_berlansung,
				'jenis_bahan_yang_dikirim_ke_laboratorium' => $request->jenis_bahan_yang_dikirim_ke_laboratorium,
				'macam_sayatan' => $request->macam_sayatan,
				'posisi_sayatan' => $request->posisi_sayatan,
				'teknik_operasi_dan_temuan_intra' => $request->teknik_operasi_dan_temuan_intra,
				'penggunaan_amhp_khusus' => $request->penggunaan_amhp_khusus,
				'jenis_dan_jumlah_amhp_khusus' => $request->jenis_dan_jumlah_amhp_khusus,
				'komplikasi_intra_operasi' => $request->komplikasi_intra_operasi,
				'penjabaran_komplikasi_intra_operasi' => $request->penjabaran_komplikasi_intra_operasi,
				'perdarahan' => $request->perdarahan,
				'instruksi_anastesi' => $request->instruksi_anastesi,
				'ipb_kontrol' => $request->ipb_kontrol,
				'ipb_puasa' => $request->ipb_puasa,
				'ipb_drain' => $request->ipb_drain,
				'ipb_inpus' => $request->ipb_inpus,
				'ipb_obat_obatan' => $request->ipb_obat_obatan,
				'ipb_ganti_balut' => $request->ipb_ganti_balut,
				'ipb_lainnya' => $request->ipb_lainnya,
				'operator_bedah' => $request->operator_bedah,
			);

			$update = LaporanPembedahan::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new LaporanPembedahan();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->ruang_operasi = $request->ruang_operasi;
			$item->akut_terencana = $request->akut_terencana;
			$item->kamar = $request->kamar;
			$item->tanggal = $request->tanggal;
			$item->pembedahan = $request->pembedahan;
			$item->ahli_anastesi = $request->ahli_anastesi;
			$item->asisten_1 = $request->asisten_1;
			$item->asisten_2 = $request->asisten_2;
			$item->perawat_instrument = $request->perawat_instrument;
			
			$item->ja_umum = $request->ja_umum;
			$item->ja_bsp = $request->ja_bsp;
			$item->ja_csp = $request->ja_csp;
			$item->ja_epidural = $request->ja_epidural;
			$item->ja_spiral = $request->ja_spiral;
			$item->ja_lokal = $request->ja_lokal;


			$item->diagnosa_pra_bedah = $request->diagnosa_pra_bedah;
			$item->diagnosa_pasca_bedah = $request->diagnosa_pasca_bedah;
			$item->indikasi_operasi = $request->indikasi_operasi;
			$item->jenis_operasi = $request->jenis_operasi;
			$item->desinfeksi_kulit_dengan = $request->desinfeksi_kulit_dengan;
			$item->posisi_penderita_desinfeksi = $request->posisi_penderita_desinfeksi;
			$item->jam_operasi_dimulai = $request->jam_operasi_dimulai;
			$item->jam_operasi_selesai = $request->jam_operasi_selesai;
			$item->lama_operasi_berlansung = $request->lama_operasi_berlansung;
			$item->jenis_bahan_yang_dikirim_ke_laboratorium = $request->jenis_bahan_yang_dikirim_ke_laboratorium;
			$item->macam_sayatan = $request->macam_sayatan;
			$item->posisi_sayatan = $request->posisi_sayatan;
			$item->teknik_operasi_dan_temuan_intra = $request->teknik_operasi_dan_temuan_intra;
			$item->penggunaan_amhp_khusus = $request->penggunaan_amhp_khusus;
			$item->jenis_dan_jumlah_amhp_khusus = $request->jenis_dan_jumlah_amhp_khusus;
			$item->komplikasi_intra_operasi = $request->komplikasi_intra_operasi;
			$item->penjabaran_komplikasi_intra_operasi = $request->penjabaran_komplikasi_intra_operasi;
			$item->perdarahan = $request->perdarahan;
			$item->instruksi_anastesi = $request->instruksi_anastesi;
			$item->ipb_kontrol = $request->ipb_kontrol;
			$item->ipb_puasa = $request->ipb_puasa;
			$item->ipb_drain = $request->ipb_drain;
			$item->ipb_inpus = $request->ipb_inpus;
			$item->ipb_obat_obatan = $request->ipb_obat_obatan;
			$item->ipb_ganti_balut = $request->ipb_ganti_balut;
			$item->ipb_lainnya = $request->ipb_lainnya;
			$item->operator_bedah = $request->operator_bedah;

			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);
	}

	public function checklistkesiapanbedah(Request $request) {
		
		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'ruangan' => $request->ruangan,
				'kamar' => $request->kamar,
				'diagnosa' => $request->diagnosa,
				'tindakan' => $request->tindakan,
				'teknik_anastesi' => $request->teknik_anastesi,
				'tanggal_tindakan' => $request->tanggal_tindakan,
				'listrik' => $request->listrik,
				'alat' => $request->alat,
				'linen_steril' => $request->linen_steril,
				'akhp' => $request->akhp,
				'perawat_kamar_bedah' => $request->perawat_kamar_bedah,
				'kepala_ruangan' => $request->kepala_ruangan,
			);
			$update = ChecklistKesiapanBedah::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new ChecklistKesiapanBedah();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->ruangan = $request->ruang;
			$item->kamar = $request->kamar;
			$item->diagnosa = $request->diagnosa;
			$item->tindakan = $request->tindakan;
			$item->teknik_anastesi = $request->teknik_anastesi;
			$item->tanggal_tindakan = $request->tanggal_tindakan;
			$item->listrik = $request->listrik;
			$item->alat = $request->alat;
			$item->linen_steril = $request->linen_steril;
			$item->akhp = $request->akhp;
			$item->perawat_kamar_bedah = $request->perawat_kamar_bedah;
			$item->kepala_ruangan = $request->kepala_ruangan;

			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);

	}

	public function perawatanperioperative(Request $request) {
		
		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'tanggal' => $request->tanggal,
				'jam' => $request->jam,
				'ruangan' => $request->ruangan,
				'dokter_operator' => $request->dokter_operator,
				'dokter_anastesi' => $request->dokter_anastesi,
				'diagnosis' => $request->diagnosis,
				'tindakan_operasi' => $request->tindakan_operasi,
				'vs_temp' => $request->vs_temp,
				'vs_nadi' => $request->vs_nadi,
				'vs_pernapasan' => $request->vs_pernapasan,
				'vs_tekanan_darah' => $request->vs_tekanan_darah,
				'vs_tinggi' => $request->vs_tinggi,
				'vs_berat' => $request->vs_berat,
				'riwayat_penyakit' => $request->riwayat_penyakit,
				'alergi_obatan' => $request->alergi_obatan,
				'alergi_makanan' => $request->alergi_makanan,
				'hasil_kgd' => $request->hasil_kgd,
				'waktu_pengambilan_kgd' => $request->waktu_pengambilan_kgd,
				'r_pemeriksaan_identitas_pasien' => $request->r_pemeriksaan_identitas_pasien,
				'r_pemeriksaan_gelang_nama' => $request->r_pemeriksaan_gelang_nama,
				'r_formulir_persetujuan_operasi' => $request->r_formulir_persetujuan_operasi,
				'r_pemberian_premedikasi' => $request->r_pemberian_premedikasi,
				'r_pemberian_makan_minum_last' => $request->r_pemberian_makan_minum_last,
				'r_alat_protesa_luar' => $request->r_alat_protesa_luar,
				'r_alat_perhiasan' => $request->r_alat_perhiasan,
				'r_status_pasien_terlampir' => $request->r_status_pasien_terlampir,
				'r_xray_scan' => $request->r_xray_scan,
				'r_pencukuran_bulu_mata' => $request->r_pencukuran_bulu_mata,
				'r_pemeriksaan_darah' => $request->r_pemeriksaan_darah,
				'r_site_marker' => $request->r_site_marker,
				'ok1_pemeriksaan_identitas_pasien' => $request->ok1_pemeriksaan_identitas_pasien,
				'ok1_pemeriksaan_gelang_nama' => $request->ok1_pemeriksaan_gelang_nama,
				'ok1_formulir_persetujuan_operasi' => $request->ok1_formulir_persetujuan_operasi,
				'ok1_pemberian_premedikasi' => $request->ok1_pemberian_premedikasi,
				'ok1_pemberian_makan_minum_last' => $request->ok1_pemberian_makan_minum_last,
				'ok1_alat_protesa_luar' => $request->ok1_alat_protesa_luar,
				'ok1_alat_perhiasan' => $request->ok1_alat_perhiasan,
				'ok1_status_pasien_terlampir' => $request->ok1_status_pasien_terlampir,
				'ok1_xray_scan' => $request->ok1_xray_scan,
				'ok1_pencukuran_bulu_mata' => $request->ok1_pencukuran_bulu_mata,
				'ok1_pemeriksaan_darah' => $request->ok1_pemeriksaan_darah,
				'ok1_site_marker' => $request->ok1_site_marker,
				'ok2_pemeriksaan_identitas_pasien' => $request->ok2_pemeriksaan_identitas_pasien,
				'ok2_pemeriksaan_gelang_nama' => $request->ok2_pemeriksaan_gelang_nama,
				'ok2_formulir_persetujuan_operasi' => $request->ok2_formulir_persetujuan_operasi,
				'ok2_pemberian_premedikasi' => $request->ok2_pemberian_premedikasi,
				'ok2_pemberian_makan_minum_last' => $request->ok2_pemberian_makan_minum_last,
				'ok2_alat_protesa_luar' => $request->ok2_alat_protesa_luar,
				'ok2_alat_perhiasan' => $request->ok2_alat_perhiasan,
				'ok2_status_pasien_terlampir' => $request->ok2_status_pasien_terlampir,
				'ok2_xray_scan' => $request->ok2_xray_scan,
				'ok2_pencukuran_bulu_mata' => $request->ok2_pencukuran_bulu_mata,
				'ok2_pemeriksaan_darah' => $request->ok2_pemeriksaan_darah,
				'ok2_site_marker' => $request->ok2_site_marker,
				'pemeriksaan_identitas_pasien_ket' => $request->pemeriksaan_identitas_pasien_ket,
				'pemeriksaan_gelang_nama_ket' => $request->pemeriksaan_gelang_nama_ket,
				'formulir_persetujuan_operasi_ket' => $request->formulir_persetujuan_operasi_ket,
				'pemberian_premedikasi_ket' => $request->pemberian_premedikasi_ket,
				'pemberian_makan_minum_last_ket' => $request->pemberian_makan_minum_last_ket,
				'alat_protesa_luar_ket' => $request->alat_protesa_luar_ket,
				'alat_perhiasan_ket' => $request->alat_perhiasan_ket,
				'status_pasien_terlampir_ket' => $request->status_pasien_terlampir_ket,
				'xray_scan_ket' => $request->xray_scan_ket,
				'pencukuran_bulu_mata_ket' => $request->pencukuran_bulu_mata_ket,
				'pemeriksaan_darah_ket' => $request->pemeriksaan_darah_ket,
				'site_marker_ket' => $request->site_marker_ket,
				'perawat_ruangan' => $request->perawat_ruangan,
				'perawat_kamar_bedah' => $request->perawat_kamar_bedah,
			);
			$update = PerawatanPeriOperative::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new PerawatanPeriOperative();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->tanggal = $request->tanggal;
			$item->jam = $request->jam;
			$item->ruangan = $request->ruangan;
			$item->dokter_operator = $request->dokter_operator;
			$item->dokter_anastesi = $request->dokter_anastesi;
			$item->diagnosis = $request->diagnosis;
			$item->tindakan_operasi = $request->tindakan_operasi;

			$item->vs_temp = $request->vs_temp;
			$item->vs_nadi = $request->vs_nadi;
			$item->vs_pernapasan = $request->vs_pernapasan;
			$item->vs_tekanan_darah = $request->vs_tekanan_darah;
			$item->vs_tinggi = $request->vs_tinggi;
			$item->vs_berat = $request->vs_berat;
			$item->riwayat_penyakit = $request->riwayat_penyakit;
			$item->alergi_obatan = $request->alergi_obatan;
			$item->alergi_makanan = $request->alergi_makanan;
			$item->hasil_kgd = $request->hasil_kgd;
			$item->waktu_pengambilan_kgd = $request->waktu_pengambilan_kgd;
			$item->r_pemeriksaan_identitas_pasien = $request->r_pemeriksaan_identitas_pasien;
			$item->r_pemeriksaan_gelang_nama = $request->r_pemeriksaan_gelang_nama;
			$item->r_formulir_persetujuan_operasi = $request->r_formulir_persetujuan_operasi;
			$item->r_pemberian_premedikasi = $request->r_pemberian_premedikasi;
			$item->r_pemberian_makan_minum_last = $request->r_pemberian_makan_minum_last;
			$item->r_alat_protesa_luar = $request->r_alat_protesa_luar;
			$item->r_alat_perhiasan = $request->r_alat_perhiasan;
			$item->r_status_pasien_terlampir = $request->r_status_pasien_terlampir;
			$item->r_xray_scan = $request->r_xray_scan;
			$item->r_pencukuran_bulu_mata = $request->r_pencukuran_bulu_mata;
			$item->r_pemeriksaan_darah = $request->r_pemeriksaan_darah;
			$item->r_site_marker = $request->r_site_marker;
			$item->ok1_pemeriksaan_identitas_pasien = $request->ok1_pemeriksaan_identitas_pasien;
			$item->ok1_pemeriksaan_gelang_nama = $request->ok1_pemeriksaan_gelang_nama;
			$item->ok1_formulir_persetujuan_operasi = $request->ok1_formulir_persetujuan_operasi;
			$item->ok1_pemberian_premedikasi = $request->ok1_pemberian_premedikasi;
			$item->ok1_pemberian_makan_minum_last = $request->ok1_pemberian_makan_minum_last;
			$item->ok1_alat_protesa_luar = $request->ok1_alat_protesa_luar;
			$item->ok1_alat_perhiasan = $request->ok1_alat_perhiasan;
			$item->ok1_status_pasien_terlampir = $request->ok1_status_pasien_terlampir;
			$item->ok1_xray_scan = $request->ok1_xray_scan;
			$item->ok1_pencukuran_bulu_mata = $request->ok1_pencukuran_bulu_mata;
			$item->ok1_pemeriksaan_darah = $request->ok1_pemeriksaan_darah;
			$item->ok1_site_marker = $request->ok1_site_marker;
			$item->ok2_pemeriksaan_identitas_pasien = $request->ok2_pemeriksaan_identitas_pasien;
			$item->ok2_pemeriksaan_gelang_nama = $request->ok2_pemeriksaan_gelang_nama;
			$item->ok2_formulir_persetujuan_operasi = $request->ok2_formulir_persetujuan_operasi;
			$item->ok2_pemberian_premedikasi = $request->ok2_pemberian_premedikasi;
			$item->ok2_pemberian_makan_minum_last = $request->ok2_pemberian_makan_minum_last;
			$item->ok2_alat_protesa_luar = $request->ok2_alat_protesa_luar;
			$item->ok2_alat_perhiasan = $request->ok2_alat_perhiasan;
			$item->ok2_status_pasien_terlampir = $request->ok2_status_pasien_terlampir;
			$item->ok2_xray_scan = $request->ok2_xray_scan;
			$item->ok2_pencukuran_bulu_mata = $request->ok2_pencukuran_bulu_mata;
			$item->ok2_pemeriksaan_darah = $request->ok2_pemeriksaan_darah;
			$item->ok2_site_marker = $request->ok2_site_marker;
			$item->pemeriksaan_identitas_pasien_ket = $request->pemeriksaan_identitas_pasien_ket;
			$item->pemeriksaan_gelang_nama_ket = $request->pemeriksaan_gelang_nama_ket;
			$item->formulir_persetujuan_operasi_ket = $request->formulir_persetujuan_operasi_ket;
			$item->pemberian_premedikasi_ket = $request->pemberian_premedikasi_ket;
			$item->pemberian_makan_minum_last_ket = $request->pemberian_makan_minum_last_ket;
			$item->alat_protesa_luar_ket = $request->alat_protesa_luar_ket;
			$item->alat_perhiasan_ket = $request->alat_perhiasan_ket;
			$item->status_pasien_terlampir_ket = $request->status_pasien_terlampir_ket;
			$item->xray_scan_ket = $request->xray_scan_ket;
			$item->pencukuran_bulu_mata_ket = $request->pencukuran_bulu_mata_ket;
			$item->pemeriksaan_darah_ket = $request->pemeriksaan_darah_ket;
			$item->site_marker_ket = $request->site_marker_ket;
			$item->perawat_ruangan = $request->perawat_ruangan;
			$item->perawat_kamar_bedah = $request->perawat_kamar_bedah;

			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);

	}

	public function catatanoperasikatarak(Request $request) {
		
		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'dokter_bedah' => $request->dokter_bedah,
				'dokter_anastesi' => $request->dokter_anastesi,
				'tindakan_operasi' => $request->tindakan_operasi,
				'perawat_scrub' => $request->perawat_scrub,
				'diagnosis_pra_bedah' => $request->diagnosis_pra_bedah,
				'diagnosis_pasca_bedah' => $request->diagnosis_pasca_bedah,
				'tanggal' => $request->tanggal,
				'operasi_mulai' => $request->operasi_mulai,
				'operasi_selesai' => $request->operasi_selesai,
				'an_topical' => $request->an_topical,
				'an_intracamelar' => $request->an_intracamelar,
				'an_retrobulbar_peribulbar' => $request->an_retrobulbar_peribulbar,
				'an_nu_bius_umum' => $request->an_nu_bius_umum,
				'an_sub_conjunctival' => $request->an_sub_conjunctival,
				'an_xylocain' => $request->an_xylocain,
				'an_lidocain' => $request->an_lidocain,
				'in_kornea' => $request->in_kornea,
				'in_limbus' => $request->in_limbus,
				'catatan_tambahan' => $request->catatan_tambahan,
				'in_sclera' => $request->in_sclera,
				'wt_main_port' => $request->wt_main_port,
				'wt_keratome_2_koma_75_mm' => $request->wt_keratome_2_koma_75_mm,
				'wt_two_side_port' => $request->wt_two_side_port,
				'wt_crescen_knife' => $request->wt_crescen_knife,
				'wt_one_side_port' => $request->wt_one_side_port,
				'cs_ccc' => $request->cs_ccc,
				'cs_can_opener' => $request->cs_can_opener,
				'cs_x_mas_tree' => $request->cs_x_mas_tree,
				'cs_tryphan_blue' => $request->cs_tryphan_blue,
				'cs_linear' => $request->cs_linear,
				'tb_ctr' => $request->tb_ctr,
				'tb_kapsulotomi_posterior' => $request->tb_kapsulotomi_posterior,
				'tb_vitrektomi_anterior' => $request->tb_vitrektomi_anterior,
				'ci_rl' => $request->ci_rl,
				'ci_bss' => $request->ci_bss,
				'lio_dalam_kantung_kapsul' => $request->lio_dalam_kantung_kapsul,
				'lio_diluar_kantong_kapsul' => $request->lio_diluar_kantong_kapsul,
				'lio_bilik_mata_depan' => $request->lio_bilik_mata_depan,
				'lio_afakia' => $request->lio_afakia,
				'lio_sulcus_siliaris' => $request->lio_sulcus_siliaris,
				'lio_fiksasi_scleral' => $request->lio_fiksasi_scleral,
				'cv_hpmc' => $request->cv_hpmc,
				'cv_viscoat' => $request->cv_viscoat,
				'cv_hyaluronic_acid' => $request->cv_hyaluronic_acid,
				'benang_tanpa_jahitan' => $request->benang_tanpa_jahitan,
				'benang_ethylon_10_0' => $request->benang_ethylon_10_0,
				'benang_vicryl_8_0' => $request->benang_vicryl_8_0,
				'kompikasi_tidak_ada' => $request->kompikasi_tidak_ada,
				'kompikasi_drop_nucleus' => $request->kompikasi_drop_nucleus,
				'kompikasi_convert_to_ecce' => $request->kompikasi_convert_to_ecce,
				'kompikasi_pcr' => $request->kompikasi_pcr,
				'kompikasi_perdarahan' => $request->kompikasi_perdarahan,
				'kompikasi_convert_to_icce' => $request->kompikasi_convert_to_icce,
				'kompikasi_prolaps_vitreous' => $request->kompikasi_prolaps_vitreous,
				'kompikasi_corneal_burn' => $request->kompikasi_corneal_burn,
				'ppo_pulang_berobat_jalan' => $request->ppo_pulang_berobat_jalan,
				'ppo_opname' => $request->ppo_opname,
				'ipo_pdb2jpo' => $request->ipo_pdb2jpo,
				'ipo_omdpspdb' => $request->ipo_omdpspdb,
				'ipo_pdbddtksdto' => $request->ipo_pdbddtksdto,
				'ipo_psdipo' => $request->ipo_psdipo,
				'operator' => $request->operator,
			);
			$update = CatatanOperasiKatarak::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new CatatanOperasiKatarak();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->dokter_bedah = $request->dokter_bedah;
			$item->dokter_anastesi = $request->dokter_anastesi;
			$item->tindakan_operasi = $request->tindakan_operasi;
			$item->perawat_scrub = $request->perawat_scrub;
			$item->diagnosis_pra_bedah = $request->diagnosis_pra_bedah;
			$item->diagnosis_pasca_bedah = $request->diagnosis_pasca_bedah;
			$item->tanggal = $request->tanggal;
			$item->operasi_mulai = $request->operasi_mulai;
			$item->operasi_selesai = $request->operasi_selesai;
			$item->an_topical = $request->an_topical;
			$item->an_intracamelar = $request->an_intracamelar;
			$item->an_retrobulbar_peribulbar = $request->an_retrobulbar_peribulbar;
			$item->an_nu_bius_umum = $request->an_nu_bius_umum;
			$item->an_sub_conjunctival = $request->an_sub_conjunctival;
			$item->an_xylocain = $request->an_xylocain;
			$item->an_lidocain = $request->an_lidocain;
			$item->in_kornea = $request->in_kornea;
			$item->in_limbus = $request->in_limbus;
			$item->in_sclera = $request->in_sclera;
			$item->wt_main_port = $request->wt_main_port;
			$item->wt_keratome_2_koma_75_mm = $request->wt_keratome_2_koma_75_mm;
			$item->wt_two_side_port = $request->wt_two_side_port;
			$item->wt_crescen_knife = $request->wt_crescen_knife;
			$item->wt_one_side_port = $request->wt_one_side_port;
			$item->cs_ccc = $request->cs_ccc;
			$item->cs_can_opener = $request->cs_can_opener;
			$item->cs_x_mas_tree = $request->cs_x_mas_tree;
			$item->cs_tryphan_blue = $request->cs_tryphan_blue;
			$item->cs_linear = $request->cs_linear;
			$item->tb_ctr = $request->tb_ctr;
			$item->tb_kapsulotomi_posterior = $request->tb_kapsulotomi_posterior;
			$item->tb_vitrektomi_anterior = $request->tb_vitrektomi_anterior;
			$item->ci_rl = $request->ci_rl;
			$item->ci_bss = $request->ci_bss;
			$item->lio_dalam_kantung_kapsul = $request->lio_dalam_kantung_kapsul;
			$item->lio_diluar_kantong_kapsul = $request->lio_diluar_kantong_kapsul;
			$item->lio_bilik_mata_depan = $request->lio_bilik_mata_depan;
			$item->lio_afakia = $request->lio_afakia;
			$item->lio_sulcus_siliaris = $request->lio_sulcus_siliaris;
			$item->lio_fiksasi_scleral = $request->lio_fiksasi_scleral;
			$item->cv_hpmc = $request->cv_hpmc;
			$item->cv_viscoat = $request->cv_viscoat;
			$item->cv_hyaluronic_acid = $request->cv_hyaluronic_acid;
			$item->benang_tanpa_jahitan = $request->benang_tanpa_jahitan;
			$item->benang_ethylon_10_0 = $request->benang_ethylon_10_0;
			$item->benang_vicryl_8_0 = $request->benang_vicryl_8_0;
			$item->kompikasi_tidak_ada = $request->kompikasi_tidak_ada;
			$item->kompikasi_drop_nucleus = $request->kompikasi_drop_nucleus;
			$item->kompikasi_convert_to_ecce = $request->kompikasi_convert_to_ecce;
			$item->kompikasi_pcr = $request->kompikasi_pcr;
			$item->kompikasi_perdarahan = $request->kompikasi_perdarahan;
			$item->kompikasi_convert_to_icce = $request->kompikasi_convert_to_icce;
			$item->kompikasi_prolaps_vitreous = $request->kompikasi_prolaps_vitreous;
			$item->kompikasi_corneal_burn = $request->kompikasi_corneal_burn;
			$item->ppo_pulang_berobat_jalan = $request->ppo_pulang_berobat_jalan;
			$item->ppo_opname = $request->ppo_opname;
			$item->ipo_pdb2jpo = $request->ipo_pdb2jpo;
			$item->ipo_omdpspdb = $request->ipo_omdpspdb;
			$item->ipo_pdbddtksdto = $request->ipo_pdbddtksdto;
			$item->ipo_psdipo = $request->ipo_psdipo;
			$item->operator = $request->operator;
			$item->catatan_tambahan = $request->catatan_tambahan;


			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);

	}

	public function persetujuantindakankedokteran(Request $request) {
		
		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'dokter_pelaksana_tindakan' => $request->dokter_pelaksana_tindakan,
				'pemberi_informasi' => $request->pemberi_informasi,
				'penerima_penolak_informasi' => $request->penerima_penolak_informasi,
				'ji_diagnosis_wd_dd' => $request->ji_diagnosis_wd_dd,
				'ji_dasar_diagnosis' => $request->ji_dasar_diagnosis,
				'ji_tindakan_kedokteran' => $request->ji_tindakan_kedokteran,
				'ji_indikasi_tindakan' => $request->ji_indikasi_tindakan,
				'ji_tata_cara' => $request->ji_tata_cara,
				'ji_tujuan' => $request->ji_tujuan,
				'ji_resiko' => $request->ji_resiko,
				'ji_komplikasi' => $request->ji_komplikasi,
				'ji_prognosis' => $request->ji_prognosis,
				'ji_alternatif_dan_resiko' => $request->ji_alternatif_dan_resiko,
				'ji_lain_lain' => $request->ji_lain_lain,
				'ptk_nama_penerima' => $request->ptk_nama_penerima,
				'ptk_tanggal_lahir_penerima' => $request->ptk_tanggal_lahir_penerima,
				'ptk_jenis_kelamin_penerima' => $request->ptk_jenis_kelamin_penerima,
				'ptk_alamat_penerima' => $request->ptk_alamat_penerima,
				'ptk_hubungan_penerima' => $request->ptk_hubungan_penerima,
				'ptk_tindakan' => $request->ptk_tindakan,
				'ptk_terhadap' => $request->ptk_terhadap,
				'ptk_nama_target' => $request->ptk_nama_target,
				'ptk_tanggal_lahir_target' => $request->ptk_tanggal_lahir_target,
				'ptk_jenis_kelamin_target' => $request->ptk_jenis_kelamin_target,
				'ptk_alamat_target' => $request->ptk_alamat_target,
				'tanggal' => $request->tanggal,
				'pukul' => $request->pukul,
				'nama_target' => $request->nama_target,
				'nama_saksi' => $request->nama_saksi,
				'perawat' => $request->perawat,
			);
			$update = PersetujuanTindakanKedokteran::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new PersetujuanTindakanKedokteran();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->dokter_pelaksana_tindakan = $request->dokter_pelaksana_tindakan;
			$item->pemberi_informasi = $request->pemberi_informasi;
			$item->penerima_penolak_informasi = $request->penerima_penolak_informasi;
			$item->ji_diagnosis_wd_dd = $request->ji_diagnosis_wd_dd;
			$item->ji_dasar_diagnosis = $request->ji_dasar_diagnosis;
			$item->ji_tindakan_kedokteran = $request->ji_tindakan_kedokteran;
			$item->ji_indikasi_tindakan = $request->ji_indikasi_tindakan;
			$item->ji_tata_cara = $request->ji_tata_cara;
			$item->ji_tujuan = $request->ji_tujuan;
			$item->ji_resiko = $request->ji_resiko;
			$item->ji_komplikasi = $request->ji_komplikasi;
			$item->ji_prognosis = $request->ji_prognosis;
			$item->ji_alternatif_dan_resiko = $request->ji_alternatif_dan_resiko;
			$item->ji_lain_lain = $request->ji_lain_lain;
			$item->ptk_nama_penerima = $request->ptk_nama_penerima;
			$item->ptk_tanggal_lahir_penerima = $request->ptk_tanggal_lahir_penerima;
			$item->ptk_jenis_kelamin_penerima = $request->ptk_jenis_kelamin_penerima;
			$item->ptk_alamat_penerima = $request->ptk_alamat_penerima;
			$item->ptk_hubungan_penerima = $request->ptk_hubungan_penerima;
			$item->ptk_tindakan = $request->ptk_tindakan;
			$item->ptk_terhadap = $request->ptk_terhadap;
			$item->ptk_nama_target = $request->ptk_nama_target;
			$item->ptk_tanggal_lahir_target = $request->ptk_tanggal_lahir_target;
			$item->ptk_jenis_kelamin_target = $request->ptk_jenis_kelamin_target;
			$item->ptk_alamat_target = $request->ptk_alamat_target;
			$item->tanggal = $request->tanggal;
			$item->pukul = $request->pukul;
			$item->nama_target = $request->nama_target;
			$item->nama_saksi = $request->nama_saksi;
			$item->perawat = $request->perawat;

			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);

	}

	public function checklistkeselamatanbedah(Request $request) {
	
		$bedah = Bedah::where('uuid', '=', $request->bedah_uuid)->first();
		if ($request->uuid != '') {
			$arr = array(
				'nama_operator' => $request->nama_operator,
				'nama_ahli_anastesi' => $request->nama_ahli_anastesi,
				'diagnosis_medis' => $request->diagnosis_medis,
				'tindakan_operasi' => $request->tindakan_operasi,
				'asisten_operasi' => $request->asisten_operasi,
				'scrub_nurses' => $request->scrub_nurses,
				'si_bagian_1' => $request->si_bagian_1,
				'si_bagian_2' => $request->si_bagian_2,
				'si_bagian_3' => $request->si_bagian_3,
				'si_bagian_4' => $request->si_bagian_4,
				'si_bagian_5' => $request->si_bagian_5,
				'si_bagian_6' => $request->si_bagian_6,
				'si_bagian_7' => $request->si_bagian_7,
				'si_nama' => $request->si_nama,
				'si_jam' => $request->si_jam,
				'so_jam' => $request->so_jam,
				'to_bagian_1' => $request->to_bagian_1,
				'to_bagian_2_1' => $request->to_bagian_2_1,
				'to_bagian_2_2' => $request->to_bagian_2_2,
				'to_bagian_2_3' => $request->to_bagian_2_3,
				'to_bagian_3' => $request->to_bagian_3,
				'to_bagian_4_1' => $request->to_bagian_4_1,
				'to_bagian_4_2' => $request->to_bagian_4_2,
				'to_bagian_5' => $request->to_bagian_5,
				'to_bagian_6' => $request->to_bagian_6,
				'to_nama' => $request->to_nama,
				'to_jam' => $request->to_jam,
				'so_bagian_1' => $request->so_bagian_1,
				'so_bagian_2' => $request->so_bagian_2,
				'so_bagian_3' => $request->so_bagian_3,
				'so_bagian_4' => $request->so_bagian_4,
				'so_bagian_4_1' => $request->so_bagian_4_1,
				'so_bagian_5' => $request->so_bagian_5,
				'so_bagian_5_1' => $request->so_bagian_5_1,
				'so_dokter_operator' => $request->so_dokter_operator,
				'so_dokter_anastesi' => $request->so_dokter_anastesi,
				'so_asisten_1' => $request->so_asisten_1,
				'so_asisten_instrumen' => $request->so_asisten_instrumen,
				'so_penata' => $request->so_penata,
				'so_sirkuler' => $request->so_sirkuler,
				'so_dokter_operator_jam' => $request->so_dokter_operator_jam,
				'so_dokter_anastesi_jam' => $request->so_dokter_anastesi_jam,
				'so_asisten_1_jam' => $request->so_asisten_1_jam,
				'so_asisten_instrumen_jam' => $request->so_asisten_instrumen_jam,
				'so_penata_jam' => $request->so_penata_jam,
				'so_sirkuler_jam' => $request->so_sirkuler_jam,
			);
			$update = KeselamatanBedah::where('uuid', '=', $request->uuid)->update($arr);
		}
		else {
			$item = new KeselamatanBedah();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $bedah->registrasi_uuid;
			$item->no_pendaftaran = $bedah->no_pendaftaran;
			$item->registrasi_kode = $bedah->registrasi_kode;
			$item->registrasi_nomor = $bedah->registrasi_nomor;
			$item->registrasi_jenis = $bedah->registrasi_jenis;
			$item->penginput = '';
			$item->bedah_uuid = $bedah->uuid;
			$item->pasien_uuid = $bedah->pasien_uuid;
			$item->rekam_medis = $bedah->rekam_medis;
			$item->nama_pasien = $bedah->nama_pasien;
			$item->tanggal_lahir = '1000-01-10';
			$item->pengguna_uuid = $bedah->pengguna_uuid;
			$item->nama_dokter = $bedah->nama_dokter;

			$item->nama_operator = $request->nama_operator;
			$item->nama_ahli_anastesi = $request->nama_ahli_anastesi;
			$item->diagnosis_medis = $request->diagnosis_medis;
			$item->tindakan_operasi = $request->tindakan_operasi;
			$item->asisten_operasi = $request->asisten_operasi;
			$item->scrub_nurses = $request->scrub_nurses;
			$item->si_bagian_1 = $request->si_bagian_1;
			$item->si_bagian_2 = $request->si_bagian_2;
			$item->si_bagian_3 = $request->si_bagian_3;
			$item->si_bagian_4 = $request->si_bagian_4;
			$item->si_bagian_5 = $request->si_bagian_5;
			$item->si_bagian_6 = $request->si_bagian_6;
			$item->si_bagian_7 = $request->si_bagian_7;
			$item->si_nama = $request->si_nama;
			$item->si_jam = $request->si_jam;
			$item->to_bagian_1 = $request->to_bagian_1;
			$item->to_bagian_2_1 = $request->to_bagian_2_1;
			$item->to_bagian_2_2 = $request->to_bagian_2_2;
			$item->to_bagian_2_3 = $request->to_bagian_2_3;
			$item->to_bagian_3 = $request->to_bagian_3;
			$item->to_bagian_4_1 = $request->to_bagian_4_1;
			$item->to_bagian_4_2 = $request->to_bagian_4_2;
			$item->to_bagian_5 = $request->to_bagian_5;
			$item->to_bagian_6 = $request->to_bagian_6;
			$item->to_nama = $request->to_nama;
			$item->to_jam = $request->to_jam;
			$item->so_jam = $request->so_jam;
			$item->so_bagian_1 = $request->so_bagian_1;
			$item->so_bagian_2 = $request->so_bagian_2;
			$item->so_bagian_3 = $request->so_bagian_3;
			$item->so_bagian_4 = $request->so_bagian_4;
			$item->so_bagian_4_1 = $request->so_bagian_4_1;
			$item->so_bagian_5 = $request->so_bagian_5;
			$item->so_bagian_5_1 = $request->so_bagian_5_1;
			$item->so_dokter_operator = $request->so_dokter_operator;
			$item->so_dokter_anastesi = $request->so_dokter_anastesi;
			$item->so_asisten_1 = $request->so_asisten_1;
			$item->so_asisten_instrumen = $request->so_asisten_instrumen;
			$item->so_penata = $request->so_penata;
			$item->so_sirkuler = $request->so_sirkuler;
			$item->so_dokter_operator_jam = $request->so_dokter_operator_jam;
			$item->so_dokter_anastesi_jam = $request->so_dokter_anastesi_jam;
			$item->so_asisten_1_jam = $request->so_asisten_1_jam;
			$item->so_asisten_instrumen_jam = $request->so_asisten_instrumen_jam;
			$item->so_penata_jam = $request->so_penata_jam;
			$item->so_sirkuler_jam = $request->so_sirkuler_jam;

			$item->save();
		}

		$laporanpembedahan = LaporanPembedahan::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$checklistkesiapanbedah = ChecklistKesiapanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$perawatanperioperative = PerawatanPeriOperative::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$catatanOperasikatarak = CatatanOperasiKatarak::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$persetujuantindakankedokteran = PersetujuanTindakanKedokteran::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();
		$keselamatanbedah = KeselamatanBedah::where('registrasi_uuid', '=', $bedah->registrasi_uuid)->first();

		return response()->json([
			'laporanpembedahan' => $laporanpembedahan, 
			'checklistkesiapanbedah' => $checklistkesiapanbedah,
			'perawatanperioperative' => $perawatanperioperative,
			'catatanOperasikatarak' => $catatanOperasikatarak,
			'persetujuantindakankedokteran' => $persetujuantindakankedokteran,
			'keselamatanbedah' => $keselamatanbedah,
		]);
		
	}
	
}