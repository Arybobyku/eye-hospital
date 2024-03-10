<?php

namespace App\Http\Controllers\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\ResepBebas;
use App\Models\LayananPasienBebas;
use App\Models\PasienBebas;
use App\Models\JadwalKontrol;
use App\Models\PasienKontrol;
use App\Models\ListReminder;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class PasienKontrolCtrl extends Controller
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
			$data = JadwalKontrol::where('delete_soft', '=', 1)
								->whereDate('tanggal', '>', date('Y-m-d'))
								->where('sudah_mendaftar', '=', 'Sudah')
								->orderBy('tanggal', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = JadwalKontrol::where('delete_soft', '=', 1)
								->whereDate('tanggal', '>', date('Y-m-d'))
								->where('sudah_mendaftar', '=', 'Sudah')
								->orderBy('tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::where('delete_soft', '=', 1)
								->whereDate('tanggal', '>', date('Y-m-d'))
								->where('sudah_mendaftar', '=', 'Sudah')
								->orderBy('tanggal', 'asc')
								->skip($skip)->take($this->take)
								->get();

			$total = JadwalKontrol::where('delete_soft', '=', 1)
								->whereDate('tanggal', '>', date('Y-m-d'))
								->where('sudah_mendaftar', '=', 'Sudah')
								->orderBy('tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$jadwal = JadwalKontrol::where('uuid', '=', $request->uuid)->first();
		$item = PasienKontrol::where('jadwal_kontrol_uuid', '=', $jadwal->uuid)->first();
		$keterangan = '';
		if ($item) {
			$keterangan = $item->keterangan;
		}
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		// }
		
		return response()->json(['jadwal' => $jadwal, 'keterangan' => $keterangan]);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			$jadwal = JadwalKontrol::where('uuid', '=', $request->uuid)->first();

			$arr = array('sudah_diperiksa' => 'Sudah');
			$update = JadwalKontrol::where('uuid', '=', $request->uuid)->update($arr);
			$cek = PasienKontrol::where('jadwal_kontrol_uuid', '=', $jadwal->uuid)->first();
			if ($cek) {
				$arr = array('keterangan' => $request->keterangan);
				$update = PasienKontrol::where('jadwal_kontrol_uuid', '=', $jadwal->uuid)->update($arr);
			}
			else {
				$item = new PasienKontrol();
				$item->uuid = Uuid::uuid4();
				$item->jadwal_kontrol_uuid = $jadwal->uuid;
				$item->registrasi_uuid = $jadwal->registrasi_uuid;
				$item->no_pendaftaran = $jadwal->no_pendaftaran;
				$item->registrasi_kode = $jadwal->registrasi_kode;
				$item->registrasi_nomor = $jadwal->registrasi_nomor;
				$item->registrasi_jenis = $jadwal->registrasi_jenis;
				$item->pasien_uuid = $jadwal->pasien_uuid;
				$item->rekam_medis = $jadwal->rekam_medis;
				$item->nama_pasien = $jadwal->nama_pasien;
				$item->pengguna_uuid = $jadwal->pengguna_uuid;
				$item->nama_dokter = $jadwal->nama_dokter;
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
				$item->keterangan = $request->keterangan;
				$item->save();
			}
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}