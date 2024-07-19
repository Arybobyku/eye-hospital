<?php

namespace App\Http\Controllers\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanRo;
use App\Models\Registrasi;
use App\Models\AntrianRo;
use App\Jobs\SendPoliJob;
use Carbon\Carbon;

class PemeriksaanCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'asc')
								->orderBy('status_ro', 'asc')
								->where(function($q){
									$q->where('status', 'Kunjungan')
									->orWhere('status', 'Rawat Inap')
										->orWhere('status', 'Selesai');
								})
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('status', 'Kunjungan')
									->orWhere('status', 'Rawat Inap')
										->orWhere('status', 'Selesai');
								})
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('status_ro', 'asc')
								->orderBy('id', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('status_ro', 'asc')
									->orderBy('id', 'asc')
									->where(function($q){
										$q->where('status', 'Kunjungan')
										->orWhere('status', 'Rawat Inap')
											->orWhere('status', 'Selesai');
									})
								// 	->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
						// 		->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
						// 		->where('carabayar_nama', '!=', 'bpjs kesehatan')
						// 		->where('carabayar_nama', '!=', 'bpjs Kesehatan')
						// 		->where('carabayar_nama', '!=', 'bpjs_kesehatan')
						// 		->where('carabayar_nama', '!=', 'bpjs-kesehatan')
						// 		->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
						// 		->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
						// 		->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
						// 		->where('carabayar_nama', '!=', 'BPJS Sehat')
						// 		->where('carabayar_nama', '!=', 'BPJS-Sehat')
						// 		->where('carabayar_nama', '!=', 'BPJS_Sehat')
						// 		->where('carabayar_nama', '!=', 'BPJS SEHAT')
						// 		->where('carabayar_nama', '!=', 'BPJS-SEHAT')
						// 		->where('carabayar_nama', '!=', 'BPJS_SEHAT')
						// 		->where('carabayar_nama', '!=', 'bpjs sehat')
						// 		->where('carabayar_nama', '!=', 'bpjs-sehat')
						// 		->where('carabayar_nama', '!=', 'bpjs_sehat')
						->where(function($q){
							$q->where('status', 'Kunjungan')
							->orWhere('status', 'Rawat Inap')
								->orWhere('status', 'Selesai');
						})
						->orderBy('status_ro', 'asc')
						->orderBy('id', 'asc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = PemeriksaanRo::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			//return response()->json(['data' => $request]);

			if ($request->uuid != '') {
				$arr = array(
					
					'ocular_dextra_pd' => $request->ocular_dextra_pd,
					'ocular_dextra_autoref' => $request->ocular_dextra_autoref,
					'ocular_dextra_keratometri_k1' => $request->ocular_dextra_keratometri_k1,
					'ocular_dextra_keratometri_k2' => $request->ocular_dextra_keratometri_k2,
					'ocular_dextra_tonometri' => $request->ocular_dextra_tonometri,
					'ocular_dextra_visus' => $request->ocular_dextra_visus,
					'ocular_dextra_bcva1' => $request->ocular_dextra_bcva1,
					'ocular_dextra_bcva2' => $request->ocular_dextra_bcva2,
					'ocular_dextra_add' => $request->ocular_dextra_add,
					'ocular_dextra_kacamata_lama_sph' => $request->ocular_dextra_kacamata_lama_sph,
					'ocular_dextra_kacamata_lama_cyl' => $request->ocular_dextra_kacamata_lama_cyl,
					'ocular_dextra_kacamata_lama_addisi' => $request->ocular_dextra_kacamata_lama_addisi,
					'ocular_sinistra_ro' => $request->ocular_sinistra_ro,
					'ocular_sinistra_autoref' => $request->ocular_sinistra_autoref,
					'ocular_sinistra_keratometri_k1' => $request->ocular_sinistra_keratometri_k1,
					'ocular_sinistra_keratometri_k2' => $request->ocular_sinistra_keratometri_k2,
					'ocular_sinistra_tonometri' => $request->ocular_sinistra_tonometri,
					'ocular_sinistra_visus' => $request->ocular_sinistra_visus,
					'ocular_sinistra_bcva1' => $request->ocular_sinistra_bcva1,
					'ocular_sinistra_bcva2' => $request->ocular_sinistra_bcva2,
					'ocular_sinistra_add' => $request->ocular_sinistra_add,
					'ocular_sinistra_kacamata_lama_sph' => $request->ocular_sinistra_kacamata_lama_sph,
					'ocular_sinistra_kacamata_lama_cyl' => $request->ocular_sinistra_kacamata_lama_cyl,
					'ocular_sinistra_kacamata_lama_addisi' => $request->ocular_sinistra_kacamata_lama_addisi,
				);

				$update = PemeriksaanRo::where("uuid", '=', $request->uuid)->update($arr);
				
				$registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
				
				if ($registrasi->ruang_poliklinik != $request->ruang_poliklinik) {
					$posisi_antrian_dokter = 1;
					$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
						->where('status', '=', 'Kunjungan')
						->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
						->orderBy('posisi_antrian_dokter', 'desc')
						->first();

					if ($registrasi_poli) { 
						$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
					}
					$arr = array(
						'ruang_poliklinik' => $request->ruang_poliklinik, 
						'posisi_antrian_dokter' => $posisi_antrian_dokter
					);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				else {
					$arr = array('ro_jam_update' => date('H:i'));
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				
			}
			else {
				$item = new PemeriksaanRo();
				$item->uuid = $uuid;
				$item->registrasi_uuid = $request->registrasi_uuid;
				$item->no_pendaftaran = $request->no_pendaftaran;
				$item->registrasi_kode = $request->kode;
				$item->registrasi_nomor = $request->nomor;
				$item->registrasi_jenis = $request->jenis;

				$item->pasien_uuid = $request->pasien_uuid;
				$item->rekam_medis = $request->rekam_medis;
				$item->nama_pasien = $request->nama_pasien;
				$item->pengguna_uuid = $request->pengguna_uuid;
				$item->nama_dokter = $request->nama_dokter;

				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');

				
				$item->ocular_dextra_pd = $request->ocular_dextra_pd;
				$item->ocular_dextra_autoref = $request->ocular_dextra_autoref;
				$item->ocular_dextra_keratometri_k1 = $request->ocular_dextra_keratometri_k1;
				$item->ocular_dextra_keratometri_k2 = $request->ocular_dextra_keratometri_k2;
				$item->ocular_dextra_tonometri = $request->ocular_dextra_tonometri;
				$item->ocular_dextra_visus = $request->ocular_dextra_visus;
				$item->ocular_dextra_bcva1 = $request->ocular_dextra_bcva1;
				$item->ocular_dextra_bcva2 = $request->ocular_dextra_bcva2;
				$item->ocular_dextra_add = $request->ocular_dextra_add;
				$item->ocular_dextra_kacamata_lama_sph = $request->ocular_dextra_kacamata_lama_sph;
				$item->ocular_dextra_kacamata_lama_cyl = $request->ocular_dextra_kacamata_lama_cyl;
				$item->ocular_dextra_kacamata_lama_addisi = $request->ocular_dextra_kacamata_lama_addisi;
				$item->ocular_sinistra_ro = $request->ocular_sinistra_ro;
				$item->ocular_sinistra_autoref = $request->ocular_sinistra_autoref;
				$item->ocular_sinistra_keratometri_k1 = $request->ocular_sinistra_keratometri_k1;
				$item->ocular_sinistra_keratometri_k2 = $request->ocular_sinistra_keratometri_k2;
				$item->ocular_sinistra_tonometri = $request->ocular_sinistra_tonometri;
				$item->ocular_sinistra_visus = $request->ocular_sinistra_visus;
				$item->ocular_sinistra_bcva1 = $request->ocular_sinistra_bcva1;
				$item->ocular_sinistra_bcva2 = $request->ocular_sinistra_bcva2;
				$item->ocular_sinistra_add = $request->ocular_sinistra_add;
				$item->ocular_sinistra_kacamata_lama_sph = $request->ocular_sinistra_kacamata_lama_sph;
				$item->ocular_sinistra_kacamata_lama_cyl = $request->ocular_sinistra_kacamata_lama_cyl;
				$item->ocular_sinistra_kacamata_lama_addisi = $request->ocular_sinistra_kacamata_lama_addisi;
				$item->save();

				$posisi_antrian_dokter = 1;
				$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Kunjungan')
					->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
					->orderBy('posisi_antrian_dokter', 'desc')
					->first();

				if ($registrasi_poli) { 
					$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
				}

				$arr = array(
					'ruang_poliklinik' => $request->ruang_poliklinik, 
					'status_ro' => 'Sudah Diperiksa', 
					'posisi_antrian_dokter' => $posisi_antrian_dokter,
					'ro_jam_selesai' => date('H:i'),
					'last_position' => 'Pemeriksaan RO (Selesai)'
				);

				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
			}
			

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}
	public function addperawat(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = PemeriksaanRo::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			//return response()->json(['data' => $request]);

			if ($request->uuid != '') {
				$arr = array(
					'penetesan_obat' => $request->penetesan_obat,
					'nama_pemeriksa' => $request->nama_pemeriksa,

					'status_fungsional' => $request->status_fungsional,
					'keluhan_utama' => $request->keluhan_utama,

					'kasus_urgent' => $request->kasus_urgent,
					'kasus_urgent_lainnya' => $request->kasus_urgent_lainnya,

					'riwayat_penyakit' => $request->riwayat_penyakit,
					'status_psikologi' => $request->status_psikologis,
					'tekanan_darah' => $request->tekanan_darah,
					'nadi' => $request->nadi,
					'respiratory_rate' => $request->respiratory_rate,
					'suhu' => $request->suhu,
					'berat_badan' => $request->berat_badan,
					'tinggi_badan' => $request->tinggi_badan,
					'nyeri' => $request->nyeri,

					'nyeri_hilang_bila' => $request->nyeri_hilang_bila,
					'nyeri_hilang_bila_lainnya' => $request->nyeri_hilang_bila_lainnya,
						
					'skala_nyeri' => $request->skala_nyeri,
					'lokasi_nyeri' => $request->lokasi_nyeri,
					'karakteristik_nyeri' => $request->karakteristik_nyeri,
					'durasi_nyeri' => $request->durasi_nyeri,
					'keterangan_nyeri' => $request->keterangan_nyeri,

					'penyakit_pernah_diderita' => $request->penyakit_pernah_diderita,
					'penyakit_pernah_diderita_lainnya' => $request->penyakit_pernah_diderita_lainnya,

					'pernah_dioperasi' => $request->pernah_dioperasi,
					'pernah_dioperasi_lainnya' => $request->pernah_dioperasi_lainnya,

					'riwayat_alergi_makanan' => $request->riwayat_alergi_makanan,
					'riwayat_alergi_makanan_lainnya' => $request->riwayat_alergi_makanan_lainnya,

					'riwayat_alergi_obatan' => $request->riwayat_alergi_obatan,
					'riwayat_alergi_obatan_lainnya' => $request->riwayat_alergi_obatan_lainnya,

					'obat_digunakan_saat_ini' => $request->obat_digunakan_saat_ini,
					'obat_digunakan_saat_ini_lainnya' => $request->obat_digunakan_saat_ini_lainnya,

					'penilaian_resiko_jatuh' => $request->penilaian_resiko_jatuh,
					
				);

				$update = PemeriksaanRo::where("uuid", '=', $request->uuid)->update($arr);
				
				$registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
				
			}
			else {
				$item = new PemeriksaanRo();
				$item->uuid = $uuid;
				$item->registrasi_uuid = $request->registrasi_uuid;
				$item->no_pendaftaran = $request->no_pendaftaran;
				$item->registrasi_kode = $request->kode;
				$item->registrasi_nomor = $request->nomor;
				$item->registrasi_jenis = $request->jenis;

				$item->pasien_uuid = $request->pasien_uuid;
				$item->rekam_medis = $request->rekam_medis;
				$item->nama_pasien = $request->nama_pasien;
				$item->pengguna_uuid = $request->pengguna_uuid;
				$item->nama_dokter = $request->nama_dokter;

				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');

				$item->penetesan_obat = $request->penetesan_obat;
				
				$item->status_fungsional = $request->status_fungsional;
				$item->keluhan_utama = $request->keluhan_utama;

				$item->kasus_urgent = $request->kasus_urgent;
				$item->kasus_urgent_lainnya = $request->kasus_urgent_lainnya;

				$item->riwayat_penyakit = $request->riwayat_penyakit;
				$item->status_psikologi = $request->status_psikologis;
				$item->tekanan_darah = $request->tekanan_darah;
				$item->nadi = $request->nadi;
				$item->respiratory_rate = $request->respiratory_rate;
				$item->suhu = $request->suhu;
				$item->berat_badan = $request->berat_badan;
				$item->tinggi_badan = $request->tinggi_badan;
				$item->nyeri = $request->nyeri;

				$item->nyeri_hilang_bila = $request->nyeri_hilang_bila;
				$item->nyeri_hilang_bila_lainnya = $request->nyeri_hilang_bila_lainnya;
					
				$item->skala_nyeri = $request->skala_nyeri;
				$item->lokasi_nyeri = $request->lokasi_nyeri;
				$item->karakteristik_nyeri = $request->karakteristik_nyeri;
				$item->durasi_nyeri = $request->durasi_nyeri;
				$item->keterangan_nyeri = $request->keterangan_nyeri;

				$item->penyakit_pernah_diderita = $request->penyakit_pernah_diderita;
				$item->penyakit_pernah_diderita_lainnya = $request->penyakit_pernah_diderita_lainnya;

				$item->pernah_dioperasi = $request->pernah_dioperasi;
				$item->pernah_dioperasi_lainnya = $request->pernah_dioperasi_lainnya;

				$item->riwayat_alergi_makanan = $request->riwayat_alergi_makanan;
				$item->riwayat_alergi_makanan_lainnya = $request->riwayat_alergi_makanan_lainnya;

				$item->riwayat_alergi_obatan = $request->riwayat_alergi_obatan;
				$item->riwayat_alergi_obatan_lainnya = $request->riwayat_alergi_obatan_lainnya;

				$item->obat_digunakan_saat_ini = $request->obat_digunakan_saat_ini;
				$item->obat_digunakan_saat_ini_lainnya = $request->obat_digunakan_saat_ini_lainnya;

				$item->penilaian_resiko_jatuh = $request->penilaian_resiko_jatuh;
				
				$item->save();

				$posisi_antrian_dokter = 1;
				$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Kunjungan')
					->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
					->orderBy('posisi_antrian_dokter', 'desc')
					->first();

				if ($registrasi_poli) { 
					$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
				}

				$arr = array(
					'ruang_poliklinik' => $request->ruang_poliklinik, 
					'status_ro' => 'Sudah Diperiksa', 
					'posisi_antrian_dokter' => $posisi_antrian_dokter,
					'ro_jam_selesai' => date('H:i'),
					'last_position' => 'Pemeriksaan RO (Selesai)'
				);

				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
			}
			

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		if ($data->ro_jam_periksa == '-') {
			$arr = array('ro_jam_periksa' => date('H:i'));
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}

		$arr = array('status_antrian_ro' => '-');
		$cek = Registrasi::where('pengguna_uuid', '=', $data->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		if ($data && $data->last_position != '-') {
			$arr = array('last_position' => 'Pemeriksaan RO');
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}
		
		$arr = array('status_antrian_ro' => 'active');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$histori = PemeriksaanRo::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();

		$kunjungan = PemeriksaanRo::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->first();
		
		return response()->json(['data' => $data, 'histori' => $histori, 'kunjungan' => $kunjungan]);
	}
	

	public function histori(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$histori = PemeriksaanRo::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(15)->get();
		
		return response()->json(['data' => $data, 'histori' => $histori]);
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$cek = Registrasi::where('uuid', '=', $request->uuid)->first();

		$arr = array('status_antrian_ro' => '-', 'last_position' => 'Pemeriksaan RO');
		$update = Registrasi::where('pengguna_uuid', '=', $request->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		if ($cek->status_ro != 'Sudah Diperiksa') {
			$arr = array('ro_jam_periksa' => date('H:i'));
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}
		$arr = array('status_antrian_ro' => 'active');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$get = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', 'Refraksi Optisi')
								->first();

		if ($get) { 
			$str = 'Refraksi Optisi='.$request->number;
			// after 14 Detik
			$on = Carbon::now()->subSeconds(14); 
			dispatch(new SendPoliJob($str))->delay($on);
			return response()->json(['data' => 'berhasil']); 
		}

		$get = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']);  }
		}

		$get = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', 'Refraksi Optisi')
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = AntrianRo::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => 'Refraksi Optisi');
		$panggil = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);
		
		$str = 'Refraksi Optisi='.$request->number;
		$on = Carbon::now()->subSeconds(14); 
		dispatch(new SendPoliJob($str))->delay($on);

		return response()->json(['data' => 'berhasil']);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama,
				'kode' => $request->kode
		);

		try{
			DB::beginTransaction();

			$update = Icd9::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Icd9::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data icd 9 dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Icd9::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Icd9::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama', 'kode'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}