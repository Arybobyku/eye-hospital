<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;
use DateTime;

use App\Models\Pasien;
use App\Models\Resep;
use App\Models\LayananPasien;
use App\Models\UploadSuratPersetujuan;
use App\Models\Registrasi;
use App\Models\SuratPersetujuan;
use App\Models\PenanggungJawab;
use PDF;


class PasienCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;
				$data = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
			else if ($column == 'tanggal_lahir') {
				$data = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
			else {
				$data = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
		}
		else {
			$data = Pasien::where('delete_soft', '=', 1)
									->where('rekam_medis', '!=', 'AP020739')
									->orderBy('status', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Pasien::where('delete_soft', '=', 1)->where('rekam_medis', '!=', 'AP020739')->orderBy('status', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function search(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
				$data = Pasien::where('delete_soft', '=', 1)
								->where(function ($q) use ($search) {
									$q->where('nama', 'ilike', '%' . $search . '%')
									->orWhere('no_identitas', 'ilike', '%' . $search . '%')
									->orWhere('rekam_medis', 'ilike', '%' . $search . '%');
								})
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->where(function ($q) use ($search) {
									$q->where('nama', 'ilike', '%' . $search . '%')
									->orWhere('no_identitas', 'ilike', '%' . $search . '%')
									->orWhere('rekam_medis', 'ilike', '%' . $search . '%');
								})
								->orderBy('status', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function history(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; 

		if ($request->search != "") {
				$data = Registrasi::where('delete_soft', '=', 1)
								->where('pasien_uuid', '=', $search)
								->orderBy('tanggal', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Registrasi::where('delete_soft', '=', 1)
								->where('pasien_uuid', '=', $search)
								->orderBy('tanggal', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}


	public function obat(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Resep::join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
						->where('registrasi.status', '=', 'Selesai')
						->select('resep.*')
						->where('resep.pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}

	public function tindakan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = LayananPasien::join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('layanan_pasien.*')
							->where('layanan_pasien.pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}

	public function kunjungan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('status', '=', 'Selesai')
							->where('pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}

}