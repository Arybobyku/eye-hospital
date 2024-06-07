<?php

namespace App\Http\Controllers\Igd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\PenanggungJawab;
use App\Models\LayananPasien;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;

class RegistrasiCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function page(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman registrasi');
		}

		$registrasi = Registrasi::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->limit(12)->get();
		$kunjungan = Registrasi::where('pasien_uuid', '=', $request->uuid)
										->where(function($q){
											$q->where('status', '=', 'Instalasi Gawat Darurat');
										})->orderBy('id', 'desc')->first();
		$pj = '';
		if ($kunjungan) {
			$pj = PenanggungJawab::where('registrasi_uuid', '=', $kunjungan->uuid)->first();
		}
		
		
		return response()->json(['data' => $data, 'registrasi' => $registrasi, 'kunjungan' => $kunjungan, 'pj' => $pj]);
	}

	public function igd(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			if ($request->uuid != '') {

				$posisi_antrian_dokter = 0;
				$arr = array();
				$registrasi = Registrasi::where('uuid', '=', $request->uuid)->first();

				$registrasi_uuid = $registrasi->uuid;
				$registrasi_kode = $registrasi->kode;
				$registrasi_nomor = $registrasi->nomor;
				$registrasi_jenis = $registrasi->jenis;

				$arr = array(
					'pengguna_umum_uuid' => $request->pengguna_uuid,
					'nama_dokter_umum' => $request->nama_dokter,
					'cara_masuk' => $request->cara_masuk,
					'rujukan' => $request->rujukan,
					'carabayar_uuid' => $request->carabayar_uuid,
					'carabayar_nama' => $request->carabayar_nama,
					'asuransi_uuid' => $request->asuransi_uuid ? $request->asuransi_uuid : '-',
					'nama_asuransi' => $request->nama_asuransi ? $request->nama_asuransi : '-',
					'last_position' => 'Instalasi Gawat Darurat',
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
			}
			else {
				$uuid = ''; $loop = false;
				do { $uuid = Uuid::uuid4(); $check = Registrasi::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);
				
				$posisi_antrian_dokter = 0;
				$posisi_antrian_ro = 0;
				$nomor = 1;

				if ($nomor < 9) { $nomor = '0000'.$nomor; }
				else if ($nomor > 9 && $nomor < 100) { $nomor = '000'.$nomor; }
				else if ($nomor > 99 && $nomor < 1000) { $nomor = '00'.$nomor; }
				else if ($nomor > 999 && $nomor < 10000) { $nomor = '0'.$nomor; }

				$nomor = date('Y').date('m').date('d').$nomor;
				$registrasi_uuid = $uuid;

				$no = 1;
				$nopendaftaran = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('jalur_masuk', '=', 'Instalasi Gawat Darurat')
					->orderBy('no_pendaftaran', 'desc')->first();
				if ($nopendaftaran) { 
					$temp = explode("-", $nopendaftaran->no_pendaftaran);
					$no += (int) $temp[1]; 
				}
				if ($no < 9) { $no = '00'.$no; }
				else if ($no > 9 && $no < 100) { $no = '0'.$no; }
				else if ($no > 99 && $no < 1000) { $no = ''.$no; }
				$no_pendaftaran = 'G-'.$no;
				
				$item = new Registrasi();
				$item->uuid = $uuid;
				$item->kode = 'IGD';
				$item->nomor = $nomor;
				$item->jenis = 'Instalasi Gawat Darurat';
				$item->jalur_masuk = 'Instalasi Gawat Darurat';

				$item->pasien_uuid = $request->pasien_uuid ? $request->pasien_uuid : '-';
				$item->rekam_medis = $request->rekam_medis ? $request->rekam_medis : '-';
				$item->nama_pasien = $request->nama_pasien ? $request->nama_pasien : '-';
				$item->tanggal_lahir = $request->tanggal_lahir ? $request->tanggal_lahir : '-';
				$item->jenis_identitas = $request->jenis_identitas ? $request->jenis_identitas : '-';
				$item->no_identitas = $request->no_identitas ? $request->no_identitas : '-';
				$item->jenis_kelamin = $request->jenis_kelamin ? $request->jenis_kelamin : '-';
				$item->no_handphone = $request->no_handphone ? $request->no_handphone : '-';
				$item->agama = $request->agama ? $request->agama : '-';

				$item->pengguna_umum_uuid = $request->pengguna_uuid ? $request->pengguna_uuid : '-';
				$item->nama_dokter_umum = $request->nama_dokter ? $request->nama_dokter : '-';
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
				$item->no_pendaftaran = $no_pendaftaran;
				$item->cara_masuk = $request->cara_masuk ? $request->cara_masuk : '-';
				$item->rujukan = $request->rujukan ? $request->rujukan : '-';
				$item->carabayar_uuid = $request->carabayar_uuid ? $request->carabayar_uuid : '-';
				$item->carabayar_nama = $request->carabayar_nama ? $request->carabayar_nama : '-';
				$item->asuransi_uuid = $request->asuransi_uuid ? $request->asuransi_uuid : '-';
				$item->nama_asuransi = $request->nama_asuransi ? $request->nama_asuransi : '-';
				$item->posisi_antrian_ro = $posisi_antrian_ro;
				$item->posisi_antrian_dokter = $posisi_antrian_dokter;
				$item->ruang_poliklinik = $request->ruang_poliklinik ? $request->ruang_poliklinik : 0;
				$item->berkebutuhan_khusus = $request->berkebutuhan_khusus ? $request->berkebutuhan_khusus : '-';
				$item->keterangan_berkebutuhan = $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-';
				$item->last_position = 'Instalasi Gawat Darurat';
				$item->status = 'Instalasi Gawat Darurat';
				$item->save();

				$arr = array('status' => 'Instalasi Gawat Darurat');
				$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);

				$registrasi_uuid = $uuid;
				$registrasi_kode = 'IGD';
				$registrasi_nomor = $nomor;
				$registrasi_jenis = 'Instalasi Gawat Darurat';

				$data = new PenanggungJawab();
				$data->uuid = Uuid::uuid4();
				$data->registrasi_uuid = $uuid;
				$data->registrasi_no_pendaftaran = $no_pendaftaran;
				$data->registrasi_tipe = $registrasi_jenis;
				$data->registrasi_kode = $registrasi_kode;
				$data->registrasi_nomor = $nomor;
				$data->registrasi_jenis = $registrasi_jenis;
				$data->pasien_uuid = $request->pasien_uuid;
				$data->rekam_medis = $request->rekam_medis;
				$data->nama_pasien = $request->nama_pasien;
				$data->pengguna_umum_uuid = $request->pengguna_uuid;
				$data->nama_dokter_umum = $request->nama_dokter;

				$data->nama = $request->nama;
				$data->hubungan = $request->hubungan;
				$data->alamat = $request->alamat;
				$data->jenis_identitas = $request->jenis_identitas;
				$data->no_identitas = $request->no_identitas;
				$data->no_handphone = $request->no_handphone;
				$data->save();
				
				$arr = array('status' => 'Instalasi Gawat Darurat');
				$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
			}
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function editigd(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		$penanggungjawab = PenanggungJawab::where('registrasi_uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman registrasi');
		}
		
		return response()->json(['data' => $data, 'penanggungjawab' => $penanggungjawab]);
	}

	public function canceligd(Request $request) {

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

}