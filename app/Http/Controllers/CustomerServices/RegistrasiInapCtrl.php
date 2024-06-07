<?php

namespace App\Http\Controllers\CustomerServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\PenanggungJawab;
use App\Models\LayananPasien;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;

class RegistrasiInapCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function pageinap(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman registrasi');
		}

		$registrasi = Registrasi::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->limit(12)->get();
		$kunjungan = Registrasi::where('pasien_uuid', '=', $request->uuid)
										->where('status', '=', 'Rawat Inap')
										->orderBy('id', 'desc')->first();
		$pj = '';
		if ($kunjungan) {
			$pj = PenanggungJawab::where('registrasi_uuid', '=', $kunjungan->uuid)->first();
		}
		
		
		return response()->json(['data' => $data, 'registrasi' => $registrasi, 'kunjungan' => $kunjungan, 'pj' => $pj]);
	}

	public function rawatinap(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			if ($request->uuid != '') {

				$posisi_antrian_dokter = 1;
				$arr = array();
				$registrasi = Registrasi::where('uuid', '=', $request->uuid)->first();

				$registrasi_uuid = $registrasi->uuid;
				$registrasi_kode = $registrasi->kode;
				$registrasi_nomor = $registrasi->nomor;
				$registrasi_jenis = $registrasi->jenis;

				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';
				if ($request->carabayar_nama != 'Umum' && $request->carabayar_nama != 'BPJS Kesehatan') {
					$status_penjamin = 'tunda';
					$is_approve = 'tidak';
					$is_pay = 'tidak';
					$is_asuransi = 'ya';
				}

				if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
					$status_penjamin = 'disetujui';
					$is_approve = 'ya';
					$is_pay = 'tidak';
					$is_asuransi = 'tidak';
				}

				
				$arr = array(
					'pengguna_uuid' => $request->pengguna_uuid,
					'nama_dokter' => $request->nama_dokter,
					'no_pendaftaran' => $request->no_pendaftaran,
					'cara_masuk' => $request->cara_masuk,
					'rujukan' => $request->rujukan,
					'carabayar_uuid' => $request->carabayar_uuid,
					'carabayar_nama' => $request->carabayar_nama,
					'asuransi_uuid' => $request->asuransi_uuid ? $request->asuransi_uuid : '-',
					'nama_asuransi' => $request->nama_asuransi ? $request->nama_asuransi : '-',
					'status_penjamin' => $status_penjamin,
					'is_approve' => $is_approve,
					'is_pay' => $is_pay,
					'is_asuransi' => $is_asuransi,
				);
				
				$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

				$arr = array(
					'nama' => $request->nama,
					'hubungan' => $request->hubungan,
					'alamat' => $request->alamat,
					'jenis_identitas' => $request->jenis_identitas,
					'no_identitas' => $request->no_identitas,
					'no_handphone' => $request->no_handphone,
				);
				$update = PenanggungJawab::where('registrasi_uuid', '=', $request->uuid)->update($arr);

				// $rekammedis = $request->rekam_medis;
				// $result = substr($rekammedis, 0, 1);
				// $remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// if ($result == '0') {
				// 	$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// 	$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// }
				// else {
				// 	$check = Registrasi::where('status', '=', 'Selesai')->where('pasien_uuid', '=', $request->pasien_uuid)->first();
				// 	if ($check) {
				// 		$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// 		$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// 	}
				// 	else {
				// 		$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// 		$this->savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// 	}
				// }
			}
			else {
				$uuid = ''; $loop = false;
				do { $uuid = Uuid::uuid4(); $check = Registrasi::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);
				
				$photos = '';

				$registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Rawat Inap')->first();

				$loop = false;
				$nomor = 1;
				$nomor_ = '';
				do {
					$nomor_ = '';
					$nomor = 1;
					$registrasinomors = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Rawat Inap')->orderBy('nomor', 'desc')->first();
				
					if ($registrasinomors) {
						$potong_kalimat = substr($registrasinomors->nomor,-5);
						$potong_kalimat = (int) $potong_kalimat;
						$nomor += $potong_kalimat;
					}

					if ($nomor < 10) { $nomor = '0000'.$nomor; }
					else if ($nomor > 9 && $nomor < 100) { $nomor = '000'.$nomor; }
					else if ($nomor > 99 && $nomor < 1000) { $nomor = '00'.$nomor; }
					else if ($nomor > 999 && $nomor < 10000) { $nomor = '0'.$nomor; }

					$nomor_ = date('Y').date('m').date('d').$nomor;

					$ceks = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Rawat Inap')
					->where('nomor', '=', $nomor_)->first();

					if (!$ceks) { $loop = true; }

				}while($loop == false);
				
				$registrasi_uuid = $uuid;
				
				$item = new Registrasi();
				$item->uuid = $uuid;
				$item->kode = 'RI';
				$item->nomor = $nomor_;
				$item->jenis = 'Rawat Inap';
				$item->jalur_masuk = 'Rawat Inap';
				$item->photos = '';

				$item->pasien_uuid = $request->pasien_uuid ? $request->pasien_uuid : '-';
				$item->rekam_medis = $request->rekam_medis ? $request->rekam_medis : '-';
				$item->nama_pasien = $request->nama_pasien ? $request->nama_pasien : '-';
				$item->tanggal_lahir = $request->tanggal_lahir ? $request->tanggal_lahir : '-';
				$item->jenis_identitas = $request->jenis_identitas ? $request->jenis_identitas : '-';
				$item->no_identitas = $request->no_identitas ? $request->no_identitas : '-';
				$item->jenis_kelamin = $request->jenis_kelamin ? $request->jenis_kelamin : '-';
				$item->no_handphone = $request->no_handphone ? $request->no_handphone : '-';
				$item->agama = $request->agama ? $request->agama : '-';

				$item->pengguna_uuid = $request->pengguna_uuid ? $request->pengguna_uuid : '-';
				$item->nama_dokter = $request->nama_dokter ? $request->nama_dokter : '-';
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
				$item->no_pendaftaran = $request->no_pendaftaran ? $request->no_pendaftaran : '-';
				$item->cara_masuk = $request->cara_masuk ? $request->cara_masuk : '-';
				$item->rujukan = $request->rujukan ? $request->rujukan : '-';
				$item->carabayar_uuid = $request->carabayar_uuid ? $request->carabayar_uuid : '-';
				$item->carabayar_nama = $request->carabayar_nama ? $request->carabayar_nama : '-';
				$item->asuransi_uuid = $request->asuransi_uuid ? $request->asuransi_uuid : '-';
				$item->nama_asuransi = $request->nama_asuransi ? $request->nama_asuransi : '-';
				$item->posisi_antrian_ro = 0;
				$item->posisi_antrian_dokter = 0;
				$item->ruang_poliklinik = 0;
				$item->berkebutuhan_khusus = '-';
				$item->keterangan_berkebutuhan = '-';
				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';
				if ($request->carabayar_nama != 'Umum' && $request->carabayar_nama != 'BPJS Kesehatan') {
					$status_penjamin = 'tunda';
					$is_approve = 'tidak';
					$is_pay = 'tidak';
					$is_asuransi = 'ya';
				}

				if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
					$status_penjamin = 'disetujui';
					$is_approve = 'ya';
					$is_pay = 'tidak';
					$is_asuransi = 'tidak';
				}
				$item->status_penjamin = $status_penjamin;
				$item->is_approve = $is_approve;
				$item->is_pay = $is_pay;
				$item->is_asuransi = $is_asuransi;
				$item->last_position = 'Pendaftaran';
				$item->status = 'Rawat Inap';
				$item->save();

				$arr = array('status' => 'Rawat Inap');
				$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);

				$registrasi_uuid = $uuid;
				$registrasi_kode = 'RI';
				$registrasi_nomor = $nomor;
				$registrasi_jenis = 'Rawat Inap';

				$data = new PenanggungJawab();
				$data->uuid = Uuid::uuid4();
				$data->registrasi_uuid = $uuid;
				$data->registrasi_no_pendaftaran = $request->no_pendaftaran;
				$data->registrasi_tipe = 'Rawat Inap';
				$data->registrasi_kode = 'RI';
				$data->registrasi_nomor = $nomor;
				$data->registrasi_jenis = 'Rawat Inap';
				$data->pasien_uuid = $request->pasien_uuid;
				$data->rekam_medis = $request->rekam_medis;
				$data->nama_pasien = $request->nama_pasien;
				$data->pengguna_uuid = $request->pengguna_uuid;
				$data->nama_dokter = $request->nama_dokter;

				$data->nama = $request->nama;
				$data->hubungan = $request->hubungan;
				$data->alamat = $request->alamat;
				$data->jenis_identitas = $request->jenis_identitas;
				$data->no_identitas = $request->no_identitas;
				$data->no_handphone = $request->no_handphone;
				$data->save();

				// $rekammedis = $request->rekam_medis;
				// $result = substr($rekammedis, 0, 1);

				// if ($result == '0') {
				// 	$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// }
				// else {
				// 	$check = Registrasi::where('status', '=', 'Selesai')->where('pasien_uuid', '=', $request->pasien_uuid)->first();
				// 	if ($check) {
				// 		$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// 	}
				// 	else {
				// 		$this->savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				// 	}
				// }
				
				$arr = array('status' => 'Rawat Inap');
				$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);

				$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')).'='.'Registrasi';
				event(new NewTradeRo($str));
			}
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function editrawatinap(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		$penanggungjawab = PenanggungJawab::where('registrasi_uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman registrasi');
		}
		
		return response()->json(['data' => $data, 'penanggungjawab' => $penanggungjawab]);
	}

	public function cancelrawatinap(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman registrasi');
		}

		$arr = array('status' => 'Batal');
		$item = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$arr = array('status' => 'Aktif');
		$pasien = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
		
		return response()->json(['data' => $data]);
	}

	private function savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis) {
		$tindakan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $request->carabayar_uuid)->where('default', '=', 'Ya')
					->where('tindakan_rawat_jalan_uuid', '!=', '6808853b-2aad-4ebd-acee-ec9980a2407d')->get();
		foreach ($tindakan as $row) {
    	$item = new LayananPasien();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $registrasi_uuid;
			$item->no_pendaftaran = $request->no_pendaftaran;
			$item->registrasi_kode = $registrasi_kode;
			$item->registrasi_nomor = $registrasi_nomor;
			$item->registrasi_jenis = $registrasi_jenis;
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
			$item->default = 'Ya';
			$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
			if (count($cek) > 0) {
				if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
					$item->jenis = 'Honor';
				}
				else {
					$item->jenis = 'Administrasi';
				}
			}
			$item->jenis = 'Administrasi';
			$item->save();
		}
	}

	private function savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis) {
		$tindakan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $request->carabayar_uuid)->where('default', '=', 'Ya')
					->where('tindakan_rawat_jalan_uuid', '!=', 'c13bf9c8-151f-4718-85de-e4d65cf667a8')->get();
		foreach ($tindakan as $row) {
    	$item = new LayananPasien();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $registrasi_uuid;
			$item->no_pendaftaran = $request->no_pendaftaran;
			$item->registrasi_kode = $registrasi_kode;
			$item->registrasi_nomor = $registrasi_nomor;
			$item->registrasi_jenis = $registrasi_jenis;
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
			$item->default = 'Ya';
			$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
			if (count($cek) > 0) {
				if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
					$item->jenis = 'Honor';
				}
				else {
					$item->jenis = 'Administrasi';
				}
			}
			$item->jenis = 'Administrasi';
			$item->save();
		}
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Pasien::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->limit(15)->get();
		return response()->json(['data' => $data]);
	}

}