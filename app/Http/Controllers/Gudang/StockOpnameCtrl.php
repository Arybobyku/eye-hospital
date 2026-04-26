<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\StockOpname;

class StockOpnameCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data stock opname gudang');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = StockOpname::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('nama_unit', '=', 'Gudang Farmasi')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = StockOpname::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('nama_unit', '=', 'Gudang Farmasi')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = StockOpname::where('delete_soft', '=', 1)
									->where('nama_unit', '=', 'Gudang Farmasi')
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = StockOpname::where('delete_soft', '=', 1)->where('nama_unit', '=', 'Gudang Farmasi')->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

}