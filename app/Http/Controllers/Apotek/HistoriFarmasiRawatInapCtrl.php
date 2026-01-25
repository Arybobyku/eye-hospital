<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\AntrianFarmasi;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class HistoriFarmasiRawatInapCtrl extends Controller
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
								->orderBy('id', 'desc')
								->where('ada_obat', '=', 'Ya')
								->where(function($q){
									$q->where('status', '!=', 'Batal');
								})
								->where('jenis', '=', 'Rawat Inap')
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where(function($q){
									$q->where('status', '!=', 'Batal');
								})
								->where('jenis', '=', 'Rawat Inap')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where('ada_obat', '=', 'Ya')
									->where(function($q){
										$q->where('status', '!=', 'Batal');
									})
									->where('jenis', '=', 'Rawat Inap')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where(function($q){
									$q->where('status', '!=', 'Batal');
								})
								->where('jenis', '=', 'Rawat Inap')
								->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

}