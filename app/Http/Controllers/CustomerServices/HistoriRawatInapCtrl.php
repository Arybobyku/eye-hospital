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
use PDF;


class HistoriRawatInapCtrl extends Controller
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
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('tanggal', 'desc')
								->where(function($q){
									$q->where('status', 'Rawat Inap')
										->orWhere('status', 'Selesai');
								})
								->where('jenis', '=', 'Rawat Inap')
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('status', 'Rawat Inap')
										->orWhere('status', 'Selesai');
								})
								->where('jenis', '=', 'Rawat Inap')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('tanggal', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('tanggal', 'asc')
									->where(function($q){
										$q->where('status', 'Rawat Inap')
											->orWhere('status', 'Selesai');
									})
									->where('jenis', '=', 'Rawat Inap')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
						->where(function($q){
							$q->where('status', 'Rawat Inap')
								->orWhere('status', 'Selesai');
						})
						->where('jenis', '=', 'Rawat Inap')
						->orderBy('tanggal', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}	

}