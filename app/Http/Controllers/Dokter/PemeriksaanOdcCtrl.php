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
use App\Models\RegistrasiOperasi;
use App\Models\AntrianPoli;
use App\Models\Pasien;
use App\Models\CaraBayarKamar;
use App\Models\ListPaketBedahBaru;
use App\Jobs\SendPoliJob;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class PemeriksaanOdcCtrl extends Controller
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
								->where('apakah_paket', '=', 'Ya')
								->where('jenis', '=', 'Rawat Jalan')
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
								->whereDate('tanggal', '=', date('Y-m-d'));
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data= $data->orderBy('status_dokter', 'asc')
								->orderBy('posisi_antrian_dokter', 'asc')
								->where(function($q) {
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('apakah_paket', '=', 'Ya')
								->where('jenis', '=', 'Rawat Jalan')
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
								->where(function($q) {
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								});

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
								
			$total = $total->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('posisi_antrian_dokter', 'asc')
								->orderBy('status_dokter', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('status_dokter', 'asc')
									->orderBy('posisi_antrian_dokter', 'asc')
									->where('apakah_paket', '=', 'Ya')
									->where('jenis', '=', 'Rawat Jalan')
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
									->where(function($q) {
										$q->where('status', 'Kunjungan')
											->orWhere('status', 'Selesai');
									});

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}

			$data = $data->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('apakah_paket', '=', 'Ya')
								->where('jenis', '=', 'Rawat Jalan');

			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
								
			$total = $total->where(function($q) {
									$q->where('status', 'Kunjungan')
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

				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
				$tindakan = json_decode($request->tindakan);

				if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
					$listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid)->get();

					foreach ($listpaket as $row) {
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
						$item->layanan_uuid = $row->uuid;
						
						if ($row->nama == 'Honor Operator Bedah') {
							$item->nama_layanan = $row->sub_label;
						}
						else {
							$item->nama_layanan = $row->nama;
						}
						$item->tarif = $row->harga;
						$item->total = $row->harga;
						$item->jenis = $row->label;
						$item->default = '-';
						$item->others = 1;
						$item->save();
					}

				}

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
					// $item->nama_dokter = $request->nama_dokter;
					
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					if ($row->default == 'Ya' || $row->default == 'YA') {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
								$item->nama_dokter = $request->nama_dokter;
							}
							else {
								$item->jenis = 'Administrasi';
								$item->nama_dokter = $request->nama_dokter;
							}
						}
						else {
							$item->jenis = 'Administrasi';
							$item->nama_dokter = $request->nama_dokter;
						}
					}
					else {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
								if ($row->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
									$item->nama_dokter = 'dr. Eric Jansen';
								}
								else {
									$item->nama_dokter = $request->nama_dokter;
								}
							}
							else if ($cek[0] == 'Administrasi') {
								$item->jenis = 'Administrasi';
								$item->nama_dokter = $request->nama_dokter;
							}
							else if ($cek[0] == 'Operation' || $cek[0] == 'Room') {
								$item->jenis = 'Room';
								$item->nama_dokter = $request->nama_dokter;
							}
							else {
								$item->jenis = 'Rawat Jalan';
								$item->nama_dokter = $request->nama_dokter;
							}
						}
						else {
							$item->jenis = 'Rawat Jalan';
							$item->nama_dokter = $request->nama_dokter;
						}
					}
					$item->default = $row->default;
					$item->save();
				}

				$tindakanjalan = json_decode($request->tindakanjalan);

				foreach ($tindakanjalan as $row) {
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
					if ($row->default == 'Ya' || $row->default == 'YA') {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
							}
							else {
								$item->jenis = 'Administrasi';
							}
						}
						else {
							$item->jenis = 'Administrasi';
						}
					}
					else {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
							}
							else if ($cek[0] == 'Administrasi') {
								$item->jenis = 'Administrasi';
							}
							else if ($cek[0] == 'Operation' || $cek[0] == 'Room') {
								$item->jenis = 'Room';
							}
							else {
								$item->jenis = 'Rawat Jalan';
							}
						}
						else {
							$item->jenis = 'Rawat Jalan';
						}
					}
					$item->default = $row->default;
					$item->save();
				}

				$apakah_paket = 'Tidak';
				if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
					$apakah_paket = 'Ya';
				}

				$arr = array(
					'status_dokter' => 'Sudah Diperiksa', 
					'dokter_jam_update' => date('H:i'),
					'catatan' => $request->catatan,
					'paket_bedah_uuid' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->paket_uuid : '-',
					'nama_paket_bedah' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->nama_paket : '-',
					'apakah_paket' => $apakah_paket
				);	
			
				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

				$remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
				$obat = json_decode($request->obat);

				if (count($obat) > 0) {

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

				

				if (count($obat) > 0) {
					$cek = Registrasi::where('uuid', '=', $request->registrasi_uuid)->select('rke')->orderBy('rke', 'desc')->first();
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

				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

				$tindakan = json_decode($request->tindakan);

				if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
					$listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid)->get();

					foreach ($listpaket as $row) {
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
						$item->layanan_uuid = $row->uuid;
						if ($row->nama == 'Honor Operator Bedah') {
							$item->nama_layanan = $row->sub_label.' '.$row->nama;
						}
						else {
							$item->nama_layanan = $row->nama;
						}
						$item->tarif = $row->harga;
						$item->total = $row->harga;
						$item->jenis = $row->label;
						$item->default = '-';
						$item->others = 1;
						$item->save();
					}

				}

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
					// $item->nama_dokter = $request->nama_dokter;
					
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');
				
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					if ($row->default == 'Ya' || $row->default == 'YA') {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
								$item->nama_dokter = $request->nama_dokter;
							}
							else {
								$item->jenis = 'Administrasi';
								$item->nama_dokter = $request->nama_dokter;
							}
						}
						else {
							$item->jenis = 'Administrasi';
							$item->nama_dokter = $request->nama_dokter;
						}
					}
					else {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
								if ($row->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
									$item->nama_dokter = 'dr. Eric Jansen';
								}
								else {
									$item->nama_dokter = $request->nama_dokter;
								}
							}
							else if ($cek[0] == 'Administrasi') {
								$item->jenis = 'Administrasi';
								$item->nama_dokter = $request->nama_dokter;
							}
							else if ($cek[0] == 'Operation' || $cek[0] == 'Room') {
								$item->jenis = 'Room';
								$item->nama_dokter = $request->nama_dokter;
							}
							else {
								$item->jenis = 'Rawat Jalan';
								$item->nama_dokter = $request->nama_dokter;
							}
						}
						else {
							$item->jenis = 'Rawat Jalan';
							$item->nama_dokter = $request->nama_dokter;
						}
					}
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

				$no_kwitansi = '';
				$kwitansi = '';
				$kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
								->where('no_kwitansi', '!=', '-')
								->where('jenis', '=', 'Rawat Jalan')
								->orderBy('no_kwitansi', 'desc')->first();
				$no_kwitansi = 'RJ/RSKMPV/8875/'.date('Ymd').'00001';
				
				$nomor_i = 1;
				if ($kwitansi) {
					$potong_kalimat = substr($kwitansi->no_kwitansi,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_i += $potong_kalimat;
				}
				if ($nomor_i < 10) { $nomor_i = '0000'.$nomor_i; }
				else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
				else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
				else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }

				$no_kwitansi = 'RJ/RSKMPV/8875/'.date('Ymd').$nomor_i;

				//if ($request->inap_jalan != '') {
				//	$no_kwitansi = 'RI/RSKMPV/8875/'.date('Ymd').'00001';
				//}
				//else {
				//	$no_kwitansi = 'RJ/RSKMPV/8875/'.date('Ymd').'00001';
				//}

				$invoice = '';
				$no_invoice = '';

				$invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
								->where('no_invoice', '!=', '-')
								->where('jenis', '=', 'Rawat Jalan')
								->orderBy('no_invoice', 'desc')->first();
				$no_invoice = date('Ymd').'00001';

				$nomor_i = 1;
				if ($invoice) {
					$potong_kalimat = substr($invoice->no_invoice,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_i += $potong_kalimat;
				}
				if ($nomor_i < 10) { $nomor_i = '0000'.$nomor_i; }
				else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
				else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
				else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
				$no_invoice = date('Ymd').$nomor_i;

				$resep = '';
				$no_resep = '';

				$resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
								->where('no_resep', '!=', '-')
								->where('jenis', '=', 'Rawat Jalan')
								->orderBy('no_resep', 'desc')->first();
				$no_resep = date('Ymd').'00001';
				

				$nomor_r = 1;
				if ($resep) {
					$potong_kalimat = substr($resep->no_resep,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor_r += $potong_kalimat;
				}
				if ($nomor_r < 10) { $nomor_r = '0000'.$nomor_r; }
				else if ($nomor_r > 9 && $nomor_r < 100) { $nomor_r = '000'.$nomor_r; }
				else if ($nomor_r > 99 && $nomor_r < 1000) { $nomor_r = '00'.$nomor_r; }
				else if ($nomor_r > 999 && $nomor_r < 10000) { $nomor_r = '0'.$nomor_r; }
				$no_resep = date('Ymd').$nomor_r;

				$apakah_paket = 'Tidak';
				if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
					$apakah_paket = 'Ya';
				}
				$arr = array(
					'ruang_poliklinik' => $request->ruang_poliklinik,
					'status_dokter' => 'Sudah Diperiksa',
					'dokter_jam_selesai' => date('H:i'),
					'catatan' => $request->catatan,
					'no_invoice' => $no_invoice,
					'no_kwitansi' => $no_kwitansi,
					'no_resep' => $no_resep,
					'last_position' => 'Pemberian Tindakan Dokter (Selesai)',
					'paket_bedah_uuid' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->paket_uuid : '-',
					'nama_paket_bedah' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->nama_paket : '-',
					'apakah_paket' => $apakah_paket
				);
				
				
				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

				if (count($obat) > 0) {
					$cek = Registrasi::where('uuid', '=', $request->registrasi_uuid)->select('rke')->orderBy('rke', 'desc')->first();
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
			$arr = array('dokter_jam_periksa' => date('H:i'), 'last_position' => 'Pemeriksaan Dokter');
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}

		$arr = array('status_antrian_dokter' => '-');
		$cek = Registrasi::where('pengguna_uuid', '=', $data->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		
		if ($data) {
			if ($data->dokter_jam_selesai == '-') {
				$arr = array('status_antrian_dokter' => 'active', );
				$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
			}
		}
		

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();
		
		$pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $request->uuid)
									->orderBy('id', 'desc')->first();

		$kunjungan = PemeriksaanDokter::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->first();

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
							->where('nama_layanan', '!=', 'Obat-obatan')
							->where('nama_layanan', '!=', 'Obat Racikan')
							->where('others', '=', 0)
						->orderBy('id', 'desc')->get();

		$layananjalan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
							->where(function($q){
								$q->where('jenis', '=', 'Room Inap Jalan')
										->orWhere('jenis', '=', 'Rawat Inap Jalan');
							})
						->orderBy('id', 'desc')->get();

		$onedaycare = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)
						->where('jenis', '=', 'One Day Care')
						->orderBy('id', 'desc')->first();

		$bedah = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)
						->where('jenis', '=', 'Inap dan Bedah')
						->orderBy('id', 'desc')->first();

		$obat = Resep::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$apotek = $this->apotek();
		$apotekracikan = $this->apotek();
		$paketbedah = $this->paketbedah();
		$carabayartindakanrawatjalan = $this->carabayartindakanrawatjalan();
		$tindakanrawatjalan = $this->tindakanrawatjalan();
		$carabayar = $this->carabayar();
		$asuransi = $this->asuransi();
		
		return response()->json([
			'data' => $data, 
			'histori' => $histori, 
			'pemeriksaanro' => $pemeriksaanro, 
			'kunjungan' => $kunjungan, 
			'layanan' => $layanan, 
			'bedah' => $bedah, 
			'onedaycare' => $onedaycare, 
			'obat' => $obat,
			'obatracikan' => $obatracikan,
			'apotek' => $apotek,
			'apotekracikan' => $apotekracikan,
			'paketbedah' => $paketbedah,
			'carabayartindakanrawatjalan' => $carabayartindakanrawatjalan,
			'tindakanrawatjalan' => $tindakanrawatjalan,
			'carabayar' => $carabayar,
			'asuransi' => $asuransi,
			'layananjalan' => $layananjalan
		]);
	}

	public function histori(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(15)->get();
		
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

		$arr = array('status_antrian_dokter' => '-', 'last_position' => 'Pemeriksaan Dokter');
		$update = Registrasi::where('pengguna_uuid', '=', $request->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
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

	private function apotek() {
		return DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->where('stock_opname.nama_unit', '=', 'Apotek')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.jenis as jenis',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_resep_besar as hja_resep_besar',
										'harga_obat.hja_non_resep as hja_non_resep',
										'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar',
										'stock_opname.nama_unit as nama_unit'
									])
									->where('stock_opname.jumlah_kecil', '>', 0)
									->get();
	}

	private function paketbedah() {
		return DB::table('paket_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayartindakanrawatjalan() {
		return DB::table('carabayar_tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function tindakanrawatjalan() {
		return DB::table('tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayar() {
		return DB::table('carabayar')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function asuransi() {
		return DB::table('asuransi')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

}