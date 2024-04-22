<?php

namespace App\Http\Controllers\RawatJalan;

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
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\LayananPasien;
use App\Models\CaraBayarKamar;
use App\Models\KamarInap;
use App\Models\JadwalKontrol;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;

class PasienCtrl extends Controller
{

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function addjadwalkontrol(Request $request) {
		try{
			$reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

			$cek = JadwalKontrol::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
			
			if ($cek) {
				$arr = array('tanggal' => $request->tanggal, 'waktu' => $request->waktu);
				$update = JadwalKontrol::where('uuid', '=', $cek->uuid)->update($arr);	
			}
			else {
				$item = new JadwalKontrol();
				$item->uuid = Uuid::uuid4();
				$item->registrasi_uuid = $reg->uuid;
				$item->no_pendaftaran = $reg->no_pendaftaran;
				$item->registrasi_kode = $reg->kode;
				$item->registrasi_nomor = $reg->nomor;
				$item->registrasi_jenis = $reg->jenis;
				$item->pasien_uuid = $reg->pasien_uuid;
				$item->rekam_medis = $reg->rekam_medis;
				$item->nama_pasien = $reg->nama_pasien;
				$item->pengguna_uuid = $reg->pengguna_uuid;
				$item->nama_dokter = $reg->nama_dokter;
								
				$item->tanggal = $request->tanggal;
				$item->waktu = $request->waktu;
				$item->jenis = 'Rawat Jalan';
				$item->save();
			}

			return response()->json(['hasil' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function getjadwalkontrol(Request $request) {
		$data = JadwalKontrol::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
		$tanggal = ''; $waktu = ''; $uuid = '';
		if ($data) { $uuid = $data->uuid; $tanggal = $data->tanggal; $waktu = $data->waktu; }
		return response()->json(['uuid' => $uuid, 'tanggal' => $tanggal, 'waktu' => $waktu]);
	}

}