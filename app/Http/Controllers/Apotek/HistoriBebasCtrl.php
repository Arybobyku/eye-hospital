<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\ResepBebas;
use App\Models\ResepRacikanBebas;
use App\Models\LayananPasien;
use App\Models\PasienBebas;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class HistoriBebasCtrl extends Controller
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
			$data = PasienBebas::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where(function($q){
									$q->where('pembayaran', '=', 'Sudah Bayar')
									->orWhere('pembayaran', '=', 'Belum Bayar');
								})
								->orderBy('no_invoice', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('pembayaran', '=', 'Sudah Bayar')
									->orWhere('pembayaran', '=', 'Belum Bayar');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_invoice', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->where(function($q){
										$q->where('pembayaran', '=', 'Sudah Bayar')
										->orWhere('pembayaran', '=', 'Belum Bayar');
									})
									->orderBy('no_invoice', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->where(function($q){
										$q->where('pembayaran', '=', 'Sudah Bayar')
										->orWhere('pembayaran', '=', 'Belum Bayar');
									})
									->orderBy('no_invoice', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

}