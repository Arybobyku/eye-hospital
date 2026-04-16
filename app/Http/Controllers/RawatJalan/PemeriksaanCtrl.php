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
use App\Models\EdukasiPasien;
use App\Models\Cppt;
use Carbon\Carbon;

class PemeriksaanCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function list(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%' . $search . '%')
				->orderBy('id', 'asc')
				->orderBy('status_ro', 'asc')
				->where(function ($q) {
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
				->where(function ($q) {
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
				->where($column, 'ilike', '%' . $search . '%')
				->whereDate('tanggal', '=', date('Y-m-d'))
				->orderBy('status_ro', 'asc')
				->orderBy('id', 'asc')->count();
		} else {
			$data = Registrasi::where('delete_soft', '=', 1)
				->orderBy('status_ro', 'asc')
				->orderBy('id', 'asc')
				->where(function ($q) {
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
				->where(function ($q) {
					$q->where('status', 'Kunjungan')
						->orWhere('status', 'Rawat Inap')
						->orWhere('status', 'Selesai');
				})
				->orderBy('status_ro', 'asc')
				->orderBy('id', 'asc')->count();
		}

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function add(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "' . $request->nama_pasien . '".');

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = PemeriksaanRo::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);
		$ocular_dextra_autoref = 's ' . $request->ocular_dextra_autoref_s;
		if ($request->ocular_dextra_autoref_c) {
			$ocular_dextra_autoref .= ' c ' . $request->ocular_dextra_autoref_c;
		}
		$ocular_dextra_autoref .= ' x ' . $request->ocular_dextra_autoref_x;

		$ocular_sinistra_autoref = 's ' . $request->ocular_sinistra_autoref_s;
		if ($request->ocular_sinistra_autoref_c) {
			$ocular_sinistra_autoref .= ' c ' . $request->ocular_sinistra_autoref_c;
		}
		$ocular_sinistra_autoref .= ' x ' . $request->ocular_sinistra_autoref_x;

		$ocular_dextra_bcva = 's ' . $request->ocular_dextra_bcva1_s;
		if ($request->ocular_dextra_bcva1_c) {
			$ocular_dextra_bcva .= ' c ' . $request->ocular_dextra_bcva1_c;
		}
		$ocular_dextra_bcva .= ' x ' . $request->ocular_dextra_bcva1_x;

		$ocular_sinistra_bcva = 's ' . $request->ocular_sinistra_bcva1_s;
		if ($request->ocular_sinistra_bcva1_c) {
			$ocular_sinistra_bcva .= ' c ' . $request->ocular_sinistra_bcva1_c;
		}
		$ocular_sinistra_bcva .= ' x ' . $request->ocular_sinistra_bcva1_x;


		try {
			DB::beginTransaction();

			//return response()->json(['data' => $request]);

			if ($request->uuid != '') {
				$arr = array(

					'ocular_dextra_pd' => $request->ocular_dextra_pd,
					// 'ocular_dextra_autoref' => $request->ocular_dextra_autoref,
					'ocular_dextra_autoref' => $ocular_dextra_autoref,
					'ocular_dextra_keratometri_k1' => $request->ocular_dextra_keratometri_k1,
					'ocular_dextra_keratometri_k2' => $request->ocular_dextra_keratometri_k2,
					'ocular_dextra_tonometri' => $request->ocular_dextra_tonometri,
					'ocular_dextra_visus' => $request->ocular_dextra_visus,
					// 'ocular_dextra_bcva1' => $request->ocular_dextra_bcva1,
					'ocular_dextra_bcva1' => $ocular_dextra_bcva,
					'ocular_dextra_bcva2' => $request->ocular_dextra_bcva2,
					'ocular_dextra_add' => $request->ocular_dextra_add,
					'ocular_dextra_kacamata_lama_sph' => $request->ocular_dextra_kacamata_lama_sph,
					'ocular_dextra_kacamata_lama_cyl' => $request->ocular_dextra_kacamata_lama_cyl,
					'ocular_dextra_kacamata_lama_addisi' => $request->ocular_dextra_kacamata_lama_addisi,
					'ocular_sinistra_ro' => $request->ocular_sinistra_ro,
					// 'ocular_sinistra_autoref' => $request->ocular_sinistra_autoref,
					'ocular_sinistra_autoref' => $ocular_sinistra_autoref,
					'ocular_sinistra_keratometri_k1' => $request->ocular_sinistra_keratometri_k1,
					'ocular_sinistra_keratometri_k2' => $request->ocular_sinistra_keratometri_k2,
					'ocular_sinistra_tonometri' => $request->ocular_sinistra_tonometri,
					'ocular_sinistra_visus' => $request->ocular_sinistra_visus,
					// 'ocular_sinistra_bcva1' => $request->ocular_sinistra_bcva1,
					'ocular_sinistra_bcva1' => $ocular_sinistra_bcva,
					'ocular_sinistra_bcva2' => $request->ocular_sinistra_bcva2,
					'ocular_sinistra_add' => $request->ocular_sinistra_add,
					'ocular_sinistra_kacamata_lama_sph' => $request->ocular_sinistra_kacamata_lama_sph,
					'ocular_sinistra_kacamata_lama_cyl' => $request->ocular_sinistra_kacamata_lama_cyl,
					'ocular_sinistra_kacamata_lama_addisi' => $request->ocular_sinistra_kacamata_lama_addisi,
				);


				$update = PemeriksaanRo::where("uuid", '=', $request->uuid)->update($arr);
				$arr = array(
					'ruang_poliklinik' => $request->ruang_poliklinik,
					'status_ro' => 'Sudah Diperiksa RO',
				);

				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);




				$registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();


			} else {
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
				$item->ocular_dextra_autoref = $ocular_dextra_autoref;
				$item->ocular_dextra_keratometri_k1 = $request->ocular_dextra_keratometri_k1;
				$item->ocular_dextra_keratometri_k2 = $request->ocular_dextra_keratometri_k2;
				$item->ocular_dextra_tonometri = $request->ocular_dextra_tonometri;
				$item->ocular_dextra_visus = $request->ocular_dextra_visus;
				$item->ocular_dextra_bcva1 = $ocular_dextra_bcva;
				$item->ocular_dextra_bcva2 = $request->ocular_dextra_bcva2;
				$item->ocular_dextra_add = $request->ocular_dextra_add;
				$item->ocular_dextra_kacamata_lama_sph = $request->ocular_dextra_kacamata_lama_sph;
				$item->ocular_dextra_kacamata_lama_cyl = $request->ocular_dextra_kacamata_lama_cyl;
				$item->ocular_dextra_kacamata_lama_addisi = $request->ocular_dextra_kacamata_lama_addisi;
				$item->ocular_sinistra_ro = $request->ocular_sinistra_ro;
				$item->ocular_sinistra_autoref = $ocular_sinistra_autoref;
				$item->ocular_sinistra_keratometri_k1 = $request->ocular_sinistra_keratometri_k1;
				$item->ocular_sinistra_keratometri_k2 = $request->ocular_sinistra_keratometri_k2;
				$item->ocular_sinistra_tonometri = $request->ocular_sinistra_tonometri;
				$item->ocular_sinistra_visus = $request->ocular_sinistra_visus;
				$item->ocular_sinistra_bcva1 = $ocular_sinistra_bcva;
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
					'status_ro' => 'Sudah Diperiksa RO',
					'posisi_antrian_dokter' => $posisi_antrian_dokter,
					'ro_jam_selesai' => date('H:i'),
					'last_position' => 'Pemeriksaan RO (Selesai)'
				);

				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);


			}
            if($request->subject != null || $request->object != null || $request->assessment != null || $request->plan != null){
                	$cppt = Cppt::where('registrasi_uuid', '=', $request->registrasi_uuid)
						->where('sebagai','=', $request->cppt_sebagai)
						->first();
                    $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
                    if ($cppt != null) {
                        $arr = array(
                            'subjek' => $request->subject,
                            'objek' => $request->object,
                            'asesmen' => $request->assessment,
                            'plan' => $request->plan,
                            'ttd' => $request->ttd,
                            'sebagai' => $request->cppt_sebagai,
                            'pengguna_uuid' => $pengguna_uuid,
                        );
                            $update = Cppt::where('uuid', '=', $request->uuid)
                                        ->where('sebagai', '=', $request->cppt_sebagai)
                                        ->update($arr);
                    }
                    else{
                    $item = new Cppt();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->pengguna_uuid = $pengguna_uuid;
                        $item->nama_pengguna = $request->nama_penggunna;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->nama_dokter = $request->nama_dokter;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->subjek = $request->subject;
                        $item->objek = $request->object;
                        $item->asesmen = $request->assessment;
                        $item->plan = $request->plan;
                        $item->sebagai = $request->cppt_sebagai;
                        $item->ttd = $request->ttd;
                        $item->save();
                    }
            }


			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}
	public function addperawat(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan data pemeriksaan perawat dengan nama pasien "' . $request->nama_pasien . '".');

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = PemeriksaanRo::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		try {
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
					'kgd' => $request->kgd,
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
						'posisi_antrian_dokter' => $posisi_antrian_dokter,

					);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				} else {
					$arr = array('ro_jam_update' => date('H:i'));
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				$arr = array(
					'ruang_poliklinik' => $request->ruang_poliklinik,
					'ro_jam_selesai' => date('H:i'),
					'status_ro' => 'Sudah Diperiksa',
					'last_position' => 'Pemeriksaan RO (Selesai)'
				);

				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

			} else {
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
				$item->kgd = $request->kgd;
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
			}



			$edukasi_pasien = EdukasiPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

			if ($edukasi_pasien != null) {
				$arr = array(
					'ph_bahasa' => $request->ph_bahasa,
					'ph_pendengaran' => $request->ph_pendengaran,
					'ph_masalah_penglihatan' => $request->ph_masalah_penglihatan,
					'ph_bicara_buruk' => $request->ph_bicara_buruk,
					'ph_hilang_memori' => $request->ph_hilang_memori,
					'ph_tidak_ada_partisipasi' => $request->ph_tidak_ada_partisipasi,
					'ph_tidak_mampu_belajar' => $request->ph_tidak_mampu_belajar,
					'ph_tidak_ada_hambatan_belajar' => $request->ph_tidak_ada_hambatan_belajar,
					'ph_cemas' => $request->ph_cemas,
					'ph_emosi' => $request->ph_emosi,
					'ph_kognitif' => $request->ph_kognitif,
					'ph_motivasi' => $request->ph_motivasi,
					'edukasi_tata_tertib' => $request->edukasi_tata_tertib,
					'edukasi_hak_dan_kewajiban' => $request->edukasi_hak_dan_kewajiban,
					'metode_audio' => $request->metode_audio,
					'metode_demonstrasi' => $request->metode_demonstrasi,
					'metode_lisan' => $request->metode_lisan,
					'metode_tulisan' => $request->metode_tulisan,
					'metode_visual' => $request->metode_visual,
					'pb_normal' => $request->pb_normal,
					'pb_gangguan' => $request->pb_gangguan,
					'bs_indonesia' => $request->bs_indonesia,
					'bs_daerah' => $request->bs_daerah,
					'bs_inggris' => $request->bs_inggris,
					'bi_tidak' => $request->bi_tidak,
					'bi_iya' => $request->bi_iya,
					'tp_tk' => $request->tp_tk,
					'tp_sd' => $request->tp_sd,
					'tp_smp' => $request->tp_smp,
					'tp_sma' => $request->tp_sma,
					'tp_diploma' => $request->tp_diploma,
					'tp_sarjana' => $request->tp_sarjana,
					'tp_lainnya' => $request->tp_lainnya,
					'ag_islam' => $request->ag_islam,
					'ag_protestan' => $request->ag_protestan,
					'ag_katolik' => $request->ag_katolik,
					'ag_hindu' => $request->ag_hindu,
					'ag_budha' => $request->ag_budha,
					'ag_lainnya' => $request->ag_lainnya,
					'tp_paham' => $request->tp_paham,
					'tp_kurang_paham' => $request->tp_kurang_paham,
					'tp_tidak' => $request->tp_tidak,
					'np_modern' => $request->np_modern,
					'np_moderat' => $request->np_moderat,
					'np_konvensional' => $request->np_konvensional,
					'rokok_ya' => $request->rokok_ya,
					'rokok_tidak' => $request->rokok_tidak,
					'alkohol_ya' => $request->alkohol_ya,
					'alkohol_tidak' => $request->alkohol_tidak,
					'kmi_ya' => $request->kmi_ya,
					'kmi_tidak' => $request->kmi_tidak,
					'rpk_proses_penyakit' => $request->rpk_proses_penyakit,
					'rpk_pengobatan' => $request->rpk_pengobatan,
					'rpk_nutrisi' => $request->rpk_nutrisi,
					'rpk_edukasi' => $request->rpk_edukasi,
					'rpk_lain_lain' => $request->rpk_lain_lain,
					'kp_ya' => $request->kp_ya,
					'kp_tidak' => $request->kp_tidak,
					'bs_lainnya' => $request->bs_lainnya,
					'kmi_alasan' => $request->kmi_alasan,
					'rpk_jelaskan' => $request->rpk_jelaskan,

				);

				$update = EdukasiPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->update($arr);
			} else {
				$item = new EdukasiPasien();
				$item->uuid = Uuid::uuid4();
				$item->registrasi_uuid = $request->registrasi_uuid;
				$item->no_pendaftaran = $request->no_pendaftaran;
				$item->registrasi_kode = $request->registrasi_kode;
				$item->registrasi_nomor = $request->registrasi_nomor;
				// $item->registrasi_jenis = $request->registrasi_jenis;
				$item->pasien_uuid = $request->pasien_uuid;
				$item->nama_pasien = $request->nama_pasien;
				$item->pengguna_uuid = $request->pengguna_uuid;
				$item->nama_dokter = $request->nama_dokter;

				$item->ph_bahasa = $request->ph_bahasa;
				$item->ph_pendengaran = $request->ph_pendengaran;
				$item->ph_masalah_penglihatan = $request->ph_masalah_penglihatan;
				$item->ph_bicara_buruk = $request->ph_bicara_buruk;
				$item->ph_hilang_memori = $request->ph_hilang_memori;
				$item->ph_tidak_ada_partisipasi = $request->ph_tidak_ada_partisipasi;
				$item->ph_tidak_mampu_belajar = $request->ph_tidak_mampu_belajar;
				$item->ph_tidak_ada_hambatan_belajar = $request->ph_tidak_ada_hambatan_belajar;
				$item->ph_cemas = $request->ph_cemas;
				$item->ph_emosi = $request->ph_emosi;
				$item->ph_kognitif = $request->ph_kognitif;
				$item->ph_motivasi = $request->ph_motivasi;
				$item->edukasi_tata_tertib = $request->edukasi_tata_tertib;
				$item->edukasi_hak_dan_kewajiban = $request->edukasi_hak_dan_kewajiban;
				$item->metode_audio = $request->metode_audio;
				$item->metode_demonstrasi = $request->metode_demonstrasi;
				$item->metode_lisan = $request->metode_lisan;
				$item->metode_tulisan = $request->metode_tulisan;
				$item->metode_visual = $request->metode_visual;
				$item->pb_normal = $request->pb_normal;
				$item->pb_gangguan = $request->pb_gangguan;
				$item->bs_indonesia = $request->bs_indonesia;
				$item->bs_daerah = $request->bs_daerah;
				$item->bs_inggris = $request->bs_inggris;
				$item->bi_tidak = $request->bi_tidak;
				$item->bi_iya = $request->bi_iya;
				$item->tp_tk = $request->tp_tk;
				$item->tp_sd = $request->tp_sd;
				$item->tp_smp = $request->tp_smp;
				$item->tp_sma = $request->tp_sma;
				$item->tp_diploma = $request->tp_diploma;
				$item->tp_sarjana = $request->tp_sarjana;
				$item->tp_lainnya = $request->tp_lainnya;
				$item->ag_islam = $request->ag_islam;
				$item->ag_protestan = $request->ag_protestan;
				$item->ag_katolik = $request->ag_katolik;
				$item->ag_hindu = $request->ag_hindu;
				$item->ag_budha = $request->ag_budha;
				$item->ag_lainnya = $request->ag_lainnya;
				$item->tp_paham = $request->tp_paham;
				$item->tp_kurang_paham = $request->tp_kurang_paham;
				$item->tp_tidak = $request->tp_tidak;
				$item->np_modern = $request->np_modern;
				$item->np_moderat = $request->np_moderat;
				$item->np_konvensional = $request->np_konvensional;
				$item->rokok_ya = $request->rokok_ya;
				$item->rokok_tidak = $request->rokok_tidak;
				$item->alkohol_ya = $request->alkohol_ya;
				$item->alkohol_tidak = $request->alkohol_tidak;
				$item->kmi_ya = $request->kmi_ya;
				$item->kmi_tidak = $request->kmi_tidak;
				$item->rpk_proses_penyakit = $request->rpk_proses_penyakit;
				$item->rpk_pengobatan = $request->rpk_pengobatan;
				$item->rpk_nutrisi = $request->rpk_nutrisi;
				$item->rpk_edukasi = $request->rpk_edukasi;
				$item->rpk_lain_lain = $request->rpk_lain_lain;
				$item->kp_ya = $request->kp_ya;
				$item->kp_tidak = $request->kp_tidak;
				$item->bs_lainnya = $request->bs_lainnya;
				$item->kmi_alasan = $request->kmi_alasan;
				$item->rpk_jelaskan = $request->rpk_jelaskan;


				$item->save();
			}

            if($request->subject != null || $request->object != null || $request->assessment != null || $request->plan != null){
                    $cppt = Cppt::where('registrasi_uuid', '=', $request->registrasi_uuid)
                    ->where('sebagai','=', $request->cppt_sebagai)
                    ->first();

                    $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
                    if ($cppt != null) {
                        $arr = array(
                            'subjek' => $request->subject,
                            'objek' => $request->object,
                            'asesmen' => $request->assessment,
                            'plan' => $request->plan,
                            'ttd' => $request->ttd,
                            'sebagai' => $request->cppt_sebagai,
                            'pengguna_uuid' => $pengguna_uuid,
                        );
                            $update = Cppt::where('uuid', '=', $request->uuid)
                                        ->where('sebagai', '=', $request->cppt_sebagai)
                                        ->update($arr);
                    }
                    else{
                    $item = new Cppt();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->pengguna_uuid = $pengguna_uuid;
                        $item->nama_pengguna = $request->nama_penggunna;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->nama_dokter = $request->nama_dokter;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->subjek = $request->subject;
                        $item->objek = $request->object;
                        $item->asesmen = $request->assessment;
                        $item->plan = $request->plan;
                        $item->sebagai = $request->cppt_sebagai;
                        $item->ttd = $request->ttd;
                        $item->save();
                    }

            }

		//	$edukasi_pasien = EdukasiPasien::where('registrasi_uuid', '=', $registrasi->registrasi_uuid)->first();


			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}


	}

	public function detail(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
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

		$cppt = Cppt::where('registrasi_uuid', '=', $request->uuid)
			->where('sebagai', '=', 'RO')
			->orderBy('id', 'desc')->first();

		$nama_login = \Illuminate\Support\Facades\Crypt::decrypt(\Illuminate\Support\Facades\Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

		return response()->json(['data' => $data, 'histori' => $histori, 'kunjungan' => $kunjungan, 'cppt'=>$cppt, 'nama_login' => $nama_login]);
	}
	public function detailperawat(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
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

		$edukasi_pasien = EdukasiPasien::where('registrasi_uuid', '=', $request->uuid)
			->orderBy('id', 'desc')->first();

		$cppt = Cppt::where('registrasi_uuid', '=', $request->uuid)
			->where('sebagai','=','PERAWAT')
			->orderBy('id', 'desc')->first();


		if ($edukasi_pasien != null){
		$kunjungan->edukasi_pasien=$edukasi_pasien;
		}


		return response()->json(['data' => $data, 'histori' => $histori, 'kunjungan' => $kunjungan,'cppt'=>$cppt]);
	}


	public function histori(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
		}

		$histori = PemeriksaanRo::where('pasien_uuid', '=', $data->pasien_uuid)
			->orderBy('id', 'desc')->limit(15)->get();

		return response()->json(['data' => $data, 'histori' => $histori]);
	}

	public function call(Request $request)
	{
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
			$str = 'Refraksi Optisi=' . $request->number;
			// after 14 Detik
			$on = Carbon::now()->subSeconds(14);
			dispatch(new SendPoliJob($str))->delay($on);
			return response()->json(['data' => 'berhasil']);
		}

		$get = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
			->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') {
				return response()->json(['data' => 'cannot']);
			}
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

		$str = 'Refraksi Optisi=' . $request->number;
		$on = Carbon::now()->subSeconds(14);
		dispatch(new SendPoliJob($str))->delay($on);

		return response()->json(['data' => 'berhasil']);
	}

	public function update(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "' . $request->nama . '".');

		$arr = array(
			'nama' => $request->nama,
			'kode' => $request->kode
		);

		try {
			DB::beginTransaction();

			$update = Icd9::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Icd9::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data icd 9 dengan nama "' . $data->nama . '" dan id "' . $data->id . '".');
		}

		$arr = array('delete_soft' => 0);

		try {
			DB::beginTransaction();

			$remove = Icd9::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$data = Icd9::where('delete_soft', '=', '1')->where('nama', 'ilike', '%' . $request->keyword . '%')->select(['id', 'uuid', 'nama', 'kode'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}
}
