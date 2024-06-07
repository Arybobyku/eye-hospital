<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\Bedah;
use App\Models\AntrianPoli;
use App\Models\Pasien;
use App\Jobs\SendPoliJob;
use App\Jobs\SendAllJob;
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
								->where('ruang_poliklinik', '!=', '0')
								->where('berkebutuhan_khusus', '=', 'Tidak')
								->whereDate('tanggal', '=', date('Y-m-d'));
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data= $data->orderBy('status_dokter', 'asc')
								->orderBy('posisi_antrian_dokter', 'asc')
								->where('status', 'Kunjungan')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', 'Kunjungan')
								->where('ruang_poliklinik', '!=', '0');

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
								
			$total = $total->where('berkebutuhan_khusus', '=', 'Tidak')
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('posisi_antrian_dokter', 'asc')
								->orderBy('status_dokter', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('status_dokter', 'asc')
									->orderBy('posisi_antrian_dokter', 'asc')
									->where('status', 'Kunjungan');

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}

			$data = $data->where('ruang_poliklinik', '!=', '0')
									->where('berkebutuhan_khusus', '=', 'Tidak')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ruang_poliklinik', '!=', '0');

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
								
			$total = $total->where('berkebutuhan_khusus', '=', 'Tidak')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', 'Kunjungan')
								->orderBy('posisi_antrian_dokter', 'asc')
								->orderBy('status_dokter', 'asc')
								->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = PemeriksaanDokter::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			//return response()->json(['data' => $request]);

			if ($request->uuid != '') {
				$arr = array(
					'posisi_bola_mata' => $request->posisi_bola_mata,
					'pergerakan_bola_mata' => $request->pergerakan_bola_mata,
					'ocular_dextra_palpebra' => $request->ocular_dextra_palpebra,
					'ocular_dextra_conjunctiva' => $request->ocular_dextra_conjunctiva,
					'ocular_dextra_cornea' => $request->ocular_dextra_cornea,
					'ocular_dextra_bilik_mata_depan' => $request->ocular_dextra_bilik_mata_depan,
					'ocular_dextra_pupil_dan_iris' => $request->ocular_dextra_pupil_dan_iris,
					'ocular_dextra_lensa' => $request->ocular_dextra_lensa,
					'ocular_dextra_vitreous' => $request->ocular_dextra_vitreous,
					'ocular_dextra_funduscopy' => $request->ocular_dextra_funduscopy,
					'ocular_sinistra_palpebra' => $request->ocular_sinistra_palpebra,
					'ocular_sinistra_conjunctiva' => $request->ocular_sinistra_conjunctiva,
					'ocular_sinistra_cornea' => $request->ocular_sinistra_cornea,
					'ocular_sinistra_bilik_mata_depan' => $request->ocular_sinistra_bilik_mata_depan,
					'ocular_sinistra_pupil_dan_iris' => $request->ocular_sinistra_pupil_dan_iris,
					'ocular_sinistra_lensa' => $request->ocular_sinistra_lensa,
					'ocular_sinistra_vitreous' => $request->ocular_sinistra_vitreous,
					'ocular_sinistra_funduscopy' => $request->ocular_sinistra_funduscopy,
					'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
					'pemeriksaan_diagnosa' => $request->pemeriksaan_diagnosa,
					'pemeriksaan_diagnosa_kode' => $request->pemeriksaan_diagnosa_kode,
					'pemeriksaan_tindakan' => $request->pemeriksaan_tindakan,
					'pemeriksaan_tindakan_kode' => $request->pemeriksaan_tindakan_kode,
					'pemeriksaan_tata_laksana' => $request->pemeriksaan_tata_laksana,
					'pemeriksaan_prognosa' => $request->pemeriksaan_prognosa,
				);

				$update = PemeriksaanDokter::where("uuid", '=', $request->uuid)->update($arr);

				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
				$tindakan = json_decode($request->tindakan);

				foreach ($tindakan as $row) {
					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					$item->jenis = 'Rawat Jalan';
					$item->default = $row->default;
					$item->save();
				}

				$arr = array();
				if ($request->ispending == 'yes') {
					$arr = array(
						'ruang_poliklinik' => $request->ruang_poliklinik, 
						'status_dokter' => 'Sudah Diperiksa (Pending)', 
						'panjar' => $request->panjar, 
						'keterangan_panjar' => $request->keterangan_panjar, 
						'status' => 'Pending', 
						'dokter_jam_update' => date('H:i'), 
						'status_antrian_dokter' => '-',
						'catatan' => $request->catatan
					);
					$arrantrian = array('pemanggil' => '-');
					$splits = explode("-", $request->no_pendaftaran);
					$cek = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
										->where('number', '=', (int) $splits[1])
										->where('pemanggil', '=', $request->ruang_poliklinik)
										->update($arrantrian);
				}
				else {

					if ($request->keterangan_inap != '' && $request->keterangan_inap) {
						$reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
						$kode = $reg->kode + ', RI';
						$jenis = $reg->jenis + ', Rawat Inap';
						$arr = array(
							'status' => 'Rawat Inap', 
							'dokter_jam_selesai' => date('H:i'), 
							'status_antrian_dokter' => '-',
							'status_dokter' => 'Sudah Diperiksa (Rawat Inap)', 
							'kode' => $kode,
							'jenis' => $jenis,
							'keterangan_inap' => $request->keterangan_inap
						);
						$pasienarr = array('status' => 'Rawat Inap');
						$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->update($pasienarr);
					}
					else {
						$arr = array(
							'ruang_poliklinik' => $request->ruang_poliklinik, 
							'status_dokter' => 'Sudah Diperiksa', 
							'dokter_jam_update' => date('H:i'),
							'catatan' => $request->catatan
						);
					}
					
				}
				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

				if ($request->paket_uuid != '' && $request->paket_uuid != ' ' && $request->paket_uuid) {
					$cek = Bedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
					if ($cek) {
						$arr = array(
							'paket_uuid' => $request->paket_uuid,
							'nama_paket' => $request->nama_paket,
							'harga_paket' => $request->harga_paket,
							'tanggal' => $request->tanggal,
							'waktu' => $request->waktu,
							'keterangan' => $request->keterangan ? $request->keterangan : ''
						);
	
						$update = Bedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->update($arr);
					}
					else {
						$item = new Bedah();
						$item->uuid = Uuid::uuid4();
						$item->jenis = 'One Day Care';
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
						$item->tanggal = $request->tanggal;
						$item->waktu = $request->waktu;

						$item->paket_uuid = $request->paket_uuid;
						$item->nama_paket = $request->nama_paket;
						$item->harga_paket = $request->harga_paket;
						$item->keterangan = $request->keterangan ? $request->keterangan : '';
						$item->save();
					}
					
				}

				if ($request->paket_uuid_bedah != '' && $request->paket_uuid_bedah != ' ' && $request->paket_uuid_bedah) {
					$cek = Bedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
					if ($cek) {
						$arr = array(
							'paket_uuid' => $request->paket_uuid_bedah,
							'nama_paket' => $request->nama_paket_bedah,
							'harga_paket' => $request->harga_paket_bedah,
							'tanggal' => $request->tanggal_bedah,
							'waktu' => $request->waktu_bedah,
							'keterangan' => $request->keterangan_bedah_bedah ? $request->keterangan_bedah_bedah : ''
						);
	
						$update = Bedah::where('registrasi_uuid', '=', $request->registrasi_uuid)->update($arr);
					}
					else {
						$item = new Bedah();
						$item->uuid = Uuid::uuid4();
						$item->jenis = 'Bedah dan Inap';
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

						$item->tanggal = $request->tanggal_bedah;
						$item->waktu = $request->waktu_bedah;

						$item->paket_uuid = $request->paket_uuid_bedah;
						$item->nama_paket = $request->nama_paket_bedah;
						$item->harga_paket = $request->harga_paket_bedah;
						$item->keterangan = $request->keterangan_bedah_bedah ? $request->keterangan_bedah_bedah : '';
						$item->save();
					}
					
				}

				$obat = json_decode($request->obat);

				if (count($obat) > 0) {

					$nama_layanan = 'Obat-obatan';
					$tarif = 0;

					$remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

					foreach ($obat as $row) {
						$item = new Resep();
						$item->uuid = Uuid::uuid4();
						$item->registrasi_uuid = $request->registrasi_uuid;
						$item->no_pendaftaran = $request->no_pendaftaran;
						$item->registrasi_kode = $request->kode;
						$item->registrasi_nomor = $request->nomor;
						$item->registrasi_jenis = $request->jenis;
						$item->pasien_uuid = $request->pasien_uuid;
						$item->rekam_medis = $request->rekam_medis;
						$item->nama_pasien = $request->nama_pasien;
						$item->dokter_uuid = $request->pengguna_uuid;
						$item->nama_dokter = $request->nama_dokter;
							
						$item->tanggal = date('Y-m-d');
						$item->waktu = date('H:i');

						$item->nama_obat = $row->nama;
						$item->kategori = $row->kategori;
						$item->formularium = $row->formularium;
						$item->golongan = $row->golongan;
						$item->satuan_uuid_besar = $row->satuan_uuid_besar;
						$item->nama_satuan_besar = $row->nama_satuan_besar;
						$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
						$item->nama_satuan_kecil = $row->nama_satuan_kecil;
						$item->hitung_besar = $row->hitung_besar;
						$item->hitung_kecil = $row->hitung_kecil;
						$item->harga_netto = $row->harga_netto;
						$item->harga_netto_discount = $row->harga_netto_discount;
						$item->harga_netto_ppn = $row->harga_netto_ppn;
						$item->hpp = $row->hpp;
						$item->hja_resep = $row->hja_resep;
						$item->hja_non_resep = $row->hja_non_resep;
						$item->hja_resep_besar = $row->hja_resep_besar;
						$item->hja_non_resep_besar = $row->hja_non_resep_besar;
						$item->margin_resep = $row->margin_resep;
						$item->margin_non_resep = $row->margin_non_resep;
						$item->jumlah_kecil = $row->jumlah_kecil;
						$item->jumlah_besar = $row->jumlah_besar;
						$item->signa = $row->signa;
						$item->total = $row->total;
						$item->save();

						$hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
						$tarif = $tarif + $hasil;
					}

					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
					
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;

					$item->layanan_uuid = 'obatan';
					$item->nama_layanan = $nama_layanan;
					$item->tarif = $tarif;
					$item->total = $tarif;
					$item->jenis = 'Obat-Obatan';
					$item->default = 'Tidak';
					$item->save();
				}
				else {
					$cek = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();

					if (count($cek) > 1) {
							$remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
					}
				}


				// Bagian untuk obat obatracikan
				$obatracikan = json_decode($request->obatracikan);

				if (count($obatracikan) > 0) {

					$nama_layanan = 'Obat Racikan';
					$tarif = 0;

					$remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

					foreach ($obatracikan as $row) {
						$item = new ResepRacikan();
						$item->uuid = Uuid::uuid4();
						$item->registrasi_uuid = $request->registrasi_uuid;
						$item->no_pendaftaran = $request->no_pendaftaran;
						$item->registrasi_kode = $request->kode;
						$item->registrasi_nomor = $request->nomor;
						$item->registrasi_jenis = $request->jenis;
						$item->pasien_uuid = $request->pasien_uuid;
						$item->rekam_medis = $request->rekam_medis;
						$item->nama_pasien = $request->nama_pasien;
						$item->dokter_uuid = $request->pengguna_uuid;
						$item->nama_dokter = $request->nama_dokter;
							
						$item->tanggal = date('Y-m-d');
						$item->waktu = date('H:i');

						$item->label = $row->label;
						$item->kemasan = $row->kemasan;
						$item->jumlah = $row->jumlah;
						$item->signa = $row->signa;
						$item->total = $row->total;
						$item->informasi = $row->informasi;
						$item->save();

						$tarif = $tarif + $row->total;
					}

					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
					
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;

					$item->layanan_uuid = 'obatracikan';
					$item->nama_layanan = $nama_layanan;
					$item->tarif = $tarif;
					$item->total = $tarif;
					$item->jenis = 'Obat Racikan';
					$item->default = 'Tidak';
					$item->save();
				}
				else {
					$cek = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();

					if (count($cek) > 1) {
							$remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
					}
				}

				if (count($obat) > 0 || count($obatracikan) > 0) {
					$cek = Registrasi::where('registrasi_uuid', '=', '$request->registrasi_uuid')->select('rke')->orderBy('rke', 'desc')->first();
					$nomor = 1;
					if ($cek) { $nomor = $nomor + $cek->rke; }
					$arr = array('ada_obat' => 'Ya', 'rke' => $nomor);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				else {
					$arr = array('ada_obat' => 'Tidak', 'rke' => 0);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				
			}
			else {
				$item = new PemeriksaanDokter();
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

				$item->posisi_bola_mata = $request->posisi_bola_mata;
				$item->pergerakan_bola_mata = $request->pergerakan_bola_mata;
				$item->ocular_dextra_palpebra = $request->ocular_dextra_palpebra;
				$item->ocular_dextra_conjunctiva = $request->ocular_dextra_conjunctiva;
				$item->ocular_dextra_cornea = $request->ocular_dextra_cornea;
				$item->ocular_dextra_bilik_mata_depan = $request->ocular_dextra_bilik_mata_depan;
				$item->ocular_dextra_pupil_dan_iris = $request->ocular_dextra_pupil_dan_iris;
				$item->ocular_dextra_lensa = $request->ocular_dextra_lensa;
				$item->ocular_dextra_vitreous = $request->ocular_dextra_vitreous;
				$item->ocular_dextra_funduscopy = $request->ocular_dextra_funduscopy;
				$item->ocular_sinistra_palpebra = $request->ocular_sinistra_palpebra;
				$item->ocular_sinistra_conjunctiva = $request->ocular_sinistra_conjunctiva;
				$item->ocular_sinistra_cornea = $request->ocular_sinistra_cornea;
				$item->ocular_sinistra_bilik_mata_depan = $request->ocular_sinistra_bilik_mata_depan;
				$item->ocular_sinistra_pupil_dan_iris = $request->ocular_sinistra_pupil_dan_iris;
				$item->ocular_sinistra_lensa = $request->ocular_sinistra_lensa;
				$item->ocular_sinistra_vitreous = $request->ocular_sinistra_vitreous;
				$item->ocular_sinistra_funduscopy = $request->ocular_sinistra_funduscopy;
				$item->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
				$item->pemeriksaan_diagnosa = $request->pemeriksaan_diagnosa;
				$item->pemeriksaan_diagnosa_kode = $request->pemeriksaan_diagnosa_kode;
				$item->pemeriksaan_tindakan = $request->pemeriksaan_tindakan;
				$item->pemeriksaan_tindakan_kode = $request->pemeriksaan_tindakan_kode;
				$item->pemeriksaan_tata_laksana = $request->pemeriksaan_tata_laksana;
				$item->pemeriksaan_prognosa = $request->pemeriksaan_prognosa;
				
				$item->save();

				$remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

				$obat = json_decode($request->obat);

				$nama_layanan = 'Obat-obatan';
				$tarif = 0;

				foreach ($obat as $row) {
					$item = new Resep();
					$item->uuid = Uuid::uuid4();
					$item->registrasi_uuid = $request->registrasi_uuid;
					$item->no_pendaftaran = $request->no_pendaftaran;
					$item->registrasi_kode = $request->kode;
					$item->registrasi_nomor = $request->nomor;
					$item->registrasi_jenis = $request->jenis;
					$item->pasien_uuid = $request->pasien_uuid;
					$item->rekam_medis = $request->rekam_medis;
					$item->nama_pasien = $request->nama_pasien;
					$item->dokter_uuid = $request->pengguna_uuid;
					$item->nama_dokter = $request->nama_dokter;
					
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');
					
					$item->obat_uuid = $row->obat_uuid;
					$item->nama_obat = $row->nama;
					$item->kategori = $row->kategori;
					$item->formularium = $row->formularium;
					$item->golongan = $row->golongan;
					$item->satuan_uuid_besar = $row->satuan_uuid_besar;
					$item->nama_satuan_besar = $row->nama_satuan_besar;
					$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
					$item->nama_satuan_kecil = $row->nama_satuan_kecil;
					$item->hitung_besar = $row->hitung_besar;
					$item->hitung_kecil = $row->hitung_kecil;
					$item->harga_netto = $row->harga_netto;
					$item->harga_netto_discount = $row->harga_netto_discount;
					$item->harga_netto_ppn = $row->harga_netto_ppn;
					$item->hpp = $row->hpp;
					$item->hja_resep = $row->hja_resep;
					$item->hja_non_resep = $row->hja_non_resep;
					$item->hja_resep_besar = $row->hja_resep_besar;
					$item->hja_non_resep_besar = $row->hja_non_resep_besar;
					$item->margin_resep = $row->margin_resep;
					$item->margin_non_resep = $row->margin_non_resep;
					$item->jumlah_kecil = $row->jumlah_kecil;
					$item->jumlah_besar = $row->jumlah_besar;
					$item->signa = $row->signa;
					$item->total = $row->total;
					$item->save();

					$hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
					$tarif = $tarif + $hasil;
				}

				// Bagian obat racikan

				$remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

				$obatracikan = json_decode($request->obatracikan);

				$nama_layanan_racikan = 'Obat Racikan';
				$tarifracikan = 0;

				foreach ($obatracikan as $row) {
					$item = new ResepRacikan();
					$item->uuid = Uuid::uuid4();
					$item->registrasi_uuid = $request->registrasi_uuid;
					$item->no_pendaftaran = $request->no_pendaftaran;
					$item->registrasi_kode = $request->kode;
					$item->registrasi_nomor = $request->nomor;
					$item->registrasi_jenis = $request->jenis;
					$item->pasien_uuid = $request->pasien_uuid;
					$item->rekam_medis = $request->rekam_medis;
					$item->nama_pasien = $request->nama_pasien;
					$item->dokter_uuid = $request->pengguna_uuid;
					$item->nama_dokter = $request->nama_dokter;
					
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');
					
					$item->label = $row->label;
					$item->kemasan = $row->kemasan;
					$item->jumlah = $row->jumlah;
					$item->signa = $row->signa;
					$item->total = $row->total;
					$item->informasi = $row->informasi;
					$item->save();

					$tarifracikan = $tarifracikan + $row->total;
				}

				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

				$tindakan = json_decode($request->tindakan);

				foreach ($tindakan as $row) {
					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					$item->jenis = 'Rawat Jalan';
					$item->default = $row->default;
					$item->save();
				}

				if (count($obat) > 0) {
					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;

					$item->layanan_uuid = 'obatan';
					$item->nama_layanan = $nama_layanan;
					$item->tarif = $tarif;
					$item->total = $tarif;
					$item->jenis = 'Obat-Obatan';
					$item->default = 'Tidak';
					$item->save();
				}

				if (count($obatracikan) > 0) {
					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
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
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;

					$item->layanan_uuid = 'obatracikan';
					$item->nama_layanan = $nama_layanan_racikan;
					$item->tarif = $tarifracikan;
					$item->total = $tarifracikan;
					$item->jenis = 'Obat Racikan';
					$item->default = 'Tidak';
					$item->save();
				}

				if ($request->paket_uuid != '' && $request->paket_uuid != ' ' && $request->paket_uuid) {
					
					$item = new Bedah();
					$item->uuid = Uuid::uuid4();
					$item->jenis = 'One Day Care';
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
					$item->tanggal = $request->tanggal;
					$item->waktu = $request->waktu;

					$item->paket_uuid = $request->paket_uuid;
					$item->nama_paket = $request->nama_paket;
					$item->harga_paket = $request->harga_paket;
					$item->keterangan = $request->keterangan ? $request->keterangan : '';
					$item->save();
				}

				if ($request->paket_uuid_bedah != '' && $request->paket_uuid_bedah != ' ' && $request->paket_uuid_bedah) {
					$item = new Bedah();
					$item->uuid = Uuid::uuid4();
					$item->jenis = 'Bedah dan Inap';
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

					$item->tanggal = $request->tanggal_bedah;
					$item->waktu = $request->waktu_bedah;

					$item->paket_uuid = $request->paket_uuid_bedah;
					$item->nama_paket = $request->nama_paket_bedah;
					$item->harga_paket = $request->harga_paket_bedah;
					$item->keterangan = $request->keterangan_bedah_bedah ? $request->keterangan_bedah_bedah : '';
					$item->save();
				}

				$kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_kwitansi', '!=', '-')->orderBy('id', 'desc')->first();
				$no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').'00001';
				$nomor_i = 1;
				if ($kwitansi) {
					$potong_kalimat = substr($kwitansi->no_invoice,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_i += $potong_kalimat;
				}
				if ($nomor_i < 9) { $nomor_i = '0000'.$nomor_i; }
				else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
				else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
				else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
				$no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').$nomor_i;

				$invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_invoice', '!=', '-')->orderBy('id', 'desc')->first();
				$no_invoice = date('Ymd').'00001';
				$nomor_i = 1;
				if ($invoice) {
					$potong_kalimat = substr($invoice->no_invoice,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_i += $potong_kalimat;
				}
				if ($nomor_i < 9) { $nomor_i = '0000'.$nomor_i; }
				else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
				else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
				else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
				$no_invoice = date('Ymd').$nomor_i;

				$resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_resep', '!=', '-')->orderBy('id', 'desc')->first();
				$no_resep = date('Ymd').'00001';
				$nomor_r = 1;
				if ($resep) {
					$potong_kalimat = substr($resep->no_resep,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_r += $potong_kalimat;
				}
				if ($nomor_r < 9) { $nomor_r = '0000'.$nomor_r; }
				else if ($nomor_r > 9 && $nomor_r < 100) { $nomor_r = '000'.$nomor_r; }
				else if ($nomor_r > 99 && $nomor_r < 1000) { $nomor_r = '00'.$nomor_r; }
				else if ($nomor_r > 999 && $nomor_r < 10000) { $nomor_r = '0'.$nomor_r; }
				$no_resep = date('Ymd').$nomor_r;
				
				$arr = array();
				if ($request->ispending == 'yes') {
					$arr = array(
						'ruang_poliklinik' => $request->ruang_poliklinik, 
						'status_dokter' => 'Sudah Diperiksa', 
						'panjar' => $request->panjar, 
						'keterangan_panjar' => $request->keterangan_panjar, 
						'status' => 'Pending', 
						'dokter_jam_selesai' => date('H:i'), 
						'status_antrian_dokter' => '-',
						'catatan' => $request->catatan,
						'no_invoice' => $no_invoice,
						'no_kwitansi' => $no_kwitansi,
						'no_resep' => $no_resep,
					);
					$arrantrian = array('pemanggil' => '-');
					$splits = explode("-", $request->no_pendaftaran);
					$cek = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
										->where('number', '=', (int) $splits[1])
										->where('pemanggil', '=', $request->ruang_poliklinik)
										->update($arrantrian);
				}
				else {
					if ($request->keterangan_inap != '' && $request->keterangan_inap) {
						$reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
						$kode = $reg->kode.', RI';
						$jenis = $reg->jenis.', Rawat Inap';
						$arr = array(
							'status' => 'Rawat Inap', 
							'dokter_jam_selesai' => date('H:i'), 
							'status_antrian_dokter' => '-',
							'status_dokter' => 'Sudah Diperiksa (Rawat Inap)', 
							'kode' => $kode,
							'jenis' => $jenis,
							'no_invoice' => $no_invoice,
							'no_kwitansi' => $no_kwitansi,
							'no_resep' => $no_resep,
							'keterangan_inap' => $request->keterangan_inap
						);

						$pasienarr = array('status' => 'Rawat Inap');
						$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->update($pasienarr);
					}
					else {
						
						$arr = array(
								'ruang_poliklinik' => $request->ruang_poliklinik,
								'status_dokter' => 'Sudah Diperiksa',
								'dokter_jam_selesai' => date('H:i'),
								'catatan' => $request->catatan,
								'no_invoice' => $no_invoice,
								'no_kwitansi' => $no_kwitansi,
								'no_resep' => $no_resep,
						);
					}
				}
				
				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

				if (count($obat) > 0 || count($obatracikan) > 0) {
					$cek = Registrasi::where('registrasi_uuid', '=', '$request->registrasi_uuid')->select('rke')->orderBy('rke', 'desc')->first();
					$nomor = 1;
					if ($cek) { $nomor = $nomor + $cek->rke; }
					$arr = array('ada_obat' => 'Ya', 'rke' => $nomor);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
				else {
					$arr = array('ada_obat' => 'Tidak', 'rke' => 0);
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
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

		if ($data->dokter_jam_periksa == '-') {
			$arr = array('dokter_jam_periksa' => date('H:i'));
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}

		$arr = array('status_antrian_dokter' => '-');
		$cek = Registrasi::where('pengguna_uuid', '=', $data->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		$arr = array('status_antrian_dokter' => 'active');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();
		
		$pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $request->uuid)
									->orderBy('id', 'desc')->first();

		$kunjungan = PemeriksaanDokter::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->first();

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
							->where('nama_layanan', '!=', 'Obat-obatan')
							->where('nama_layanan', '!=', 'Obat Racikan')
						->orderBy('id', 'desc')->get();

		$bedah = Bedah::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->first();

		$obat = Resep::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();
		
		return response()->json([
			'data' => $data, 
			'histori' => $histori, 
			'pemeriksaanro' => $pemeriksaanro, 
			'kunjungan' => $kunjungan, 
			'layanan' => $layanan, 
			'bedah' => $bedah, 
			'obat' => $obat,
			'obatracikan' => $obatracikan
		]);
	}

	public function histori(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();
		
		return response()->json(['data' => $data, 'histori' => $histori]);
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

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$cek = Registrasi::where('uuid', '=', $request->uuid)->first();

		$arr = array('status_antrian_dokter' => '-');
		$cek = Registrasi::where('pengguna_uuid', '=', $request->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		if ($cek->status_dokter != 'Sudah Diperiksa') {
			$arr = array('dokter_jam_periksa' => date('H:i'));
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}
		$arr = array('status_antrian_dokter' => 'active');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', $request->ruang_poliklinik)
								->first();

		if ($get) { 
			$str = 'Poliklinik '.$request->ruang_poliklinik.'='.$request->number;
			// after 14 Detik
			$on = Carbon::now()->addSeconds(1);
			if ($request->ruang_poliklinik == '1' || $request->ruang_poliklinik == '2' || $request->ruang_poliklinik == '3') {
				dispatch(new SendPoliJob($str))->delay($on);
			}
			else {
				dispatch(new SendAllJob($str))->delay($on);
			}
			return response()->json(['data' => 'berhasil']);
		}

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']);  }
		}

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', $request->ruang_poliklinik)
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = AntrianPoli::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => $request->ruang_poliklinik);
		$panggil = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);
		
		$str = 'Poliklinik '.$request->ruang_poliklinik.'='.$request->number;
		// after 14 Detik
		$on = Carbon::now()->addSeconds(1);
		if ($request->ruang_poliklinik == '1' || $request->ruang_poliklinik == '2' || $request->ruang_poliklinik == '3') {
			dispatch(new SendPoliJob($str))->delay($on);
		}
		else {
			dispatch(new SendAllJob($str))->delay($on);
		}

		return response()->json(['data' => 'berhasil']);
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Icd9::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama', 'kode'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}