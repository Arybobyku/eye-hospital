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

use App\Models\ResepBebas;
use App\Models\LayananPasienBebas;
use App\Models\PasienBebas;
use App\Models\JadwalKontrol;
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
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '>', date('Y-m-d'))
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '>', date('Y-m-d'))
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '>', date('Y-m-d'))
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '>', date('Y-m-d'))
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$jadwal = JadwalKontrol::where('uuid', '=', $request->uuid)->first();
		$list = ListReminder::where('jadwal_kontrol_uuid', '=', $jadwal->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		// }
		
		return response()->json(['jadwal' => $jadwal, 'list' => $list, 'dfd' => $request->uuid]);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			$jadwal = JadwalKontrol::where('uuid', '=', $request->uuid)->first();

			$arr = array('sudah_mendaftar' => 'Sudah', 'poli_tujuan' => $request->klinik);
			$update = JadwalKontrol::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}