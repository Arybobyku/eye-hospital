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
use DateTime;

use App\Models\Pasien;
use App\Models\UploadSuratPersetujuan;
use App\Models\Registrasi;
use App\Models\SuratPersetujuan;
use App\Models\PenanggungJawab;
use PDF;


class AntrianPasienCtrl extends Controller
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
			if ($column == 'tanggal_lahir') {
				$data = Registrasi::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('pengguna_uuid', '=', $request->pengguna_uuid)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', '=', 'Kunjungan')
								->where('status_dokter', '=', 'Belum Diperiksa')
								->orderBy('posisi_antrian_dokter', 'asc')
								->skip($skip)->take($this->take)
								->get();
				$total = Registrasi::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', '=', 'Kunjungan')
								->where('status_dokter', '=', 'Belum Diperiksa')
								->where('pengguna_uuid', '=', $request->pengguna_uuid)
								->orderBy('posisi_antrian_dokter', 'asc')->count();
			}
			else {
				$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', '=', 'Kunjungan')
								->where('status_dokter', '=', 'Belum Diperiksa')
								->where('pengguna_uuid', '=', $request->pengguna_uuid)
								->orderBy('posisi_antrian_dokter', 'asc')
								->skip($skip)->take($this->take)
								->get();
				$total = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', '=', 'Kunjungan')
								->where('status_dokter', '=', 'Belum Diperiksa')
								->where('pengguna_uuid', '=', $request->pengguna_uuid)
								->orderBy('posisi_antrian_dokter', 'asc')->count();
			}
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->where('pengguna_uuid', '=', $request->pengguna_uuid)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('status', '=', 'Kunjungan')
									->where('status_dokter', '=', 'Belum Diperiksa')
									->orderBy('posisi_antrian_dokter', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
									->where('pengguna_uuid', '=', $request->pengguna_uuid)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('status', '=', 'Kunjungan')
									->where('status_dokter', '=', 'Belum Diperiksa')
									->orderBy('posisi_antrian_dokter', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

}