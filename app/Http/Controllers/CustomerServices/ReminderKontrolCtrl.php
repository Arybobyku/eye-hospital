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

class ReminderKontrolCtrl extends Controller
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

	public function seven(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+7 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function six(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+6 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function five(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+5 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function four(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+4 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function three(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+3 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function two(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+2 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function one(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$date = strtotime("+1 day");
		$tgl = date('Y-m-d', $date);
		

		if ($request->search != "") {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->wher('jadwal_kontrol.'.$column, '=', $search)
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();
			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->count();
		}
		else {
			$data = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
								->orderBy('jadwal_kontrol.tanggal', 'asc')
								->skip($skip)->take($this->take)
								->select(['jadwal_kontrol.*', 'pasien.no_handphone as no_handphone'])
								->get();

			$total = JadwalKontrol::join('pasien', 'jadwal_kontrol.pasien_uuid', '=', 'pasien.uuid')
								->where('jadwal_kontrol.delete_soft', '=', 1)
								->whereDate('jadwal_kontrol.tanggal', '=', $tgl)
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

			$item = new ListReminder();
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
			$item->tanggal = $request->tanggal;
			$item->waktu = $request->waktu;
			$item->melalui = $request->melalui;
			$item->keterangan = 'Pasien dengan nama '.$jadwal->nama_pasien.' telah dihubungi melalui '.$request->melalui.'.';
			$item->save();

			$arr = array('sudah_dihubungi' => 'Sudah');
			$update = JadwalKontrol::where('uuid', '=', $request->uuid)->update($arr);

			$list = ListReminder::where('jadwal_kontrol_uuid', '=', $jadwal->uuid)->get();
		
			DB::commit();

			return response()->json(['list' => $list, 'jadwal' => $jadwal]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();
		// if ($data) {
		// 	PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		// }
		
		try{
			DB::beginTransaction();

			$remove = LayananPasienBebas::where('uuid', '=', $request->uuid)->delete();

			$detail = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();
			$data = LayananPasienBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->get();

			if (count($data) < 1) {
				$arr = array('ada_tindakan' => 'Tidak');
				$update = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->update($arr);
			}
			
			DB::commit();

			return response()->json(['data' => $data, 'detail' => $detail, 'dfd' => $request->pasienbebas_uuid]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Unit::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}