<?php

namespace App\Http\Controllers\Bedah;

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

		PenggunaHelp::log('Melihat data list table pada halaman data stock opname bedah');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = StockOpname::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = StockOpname::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = StockOpname::where('delete_soft', '=', 1)
									->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = StockOpname::where('delete_soft', '=', 1)->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function ambil(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengambil data obat/alkes pada stock opname. nama yang mengambil '.$request->nama);

		try{
			DB::beginTransaction();

			$arr = array(
				'jumlah_kecil' => (float) $request->minta_kecil,
				'jumlah_besar' => (float) $request->minta_besar,
			);

			$stockopname = StockOpname::where('obat_uuid', '=', $request->obat_uuid)
											->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')
											->update($arr );
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function kembali(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengambil data obat/alkes pada stock opname. nama yang mengambil '.$request->nama);

		try{
			DB::beginTransaction();

			$arr = array(
				'jumlah_kecil' => (float) $request->minta_kecil,
				'jumlah_besar' => (float) $request->minta_besar,
			);

			$stockopname = StockOpname::where('obat_uuid', '=', $request->obat_uuid)
											->where('unit_uuid', '=', 'c7887937-6e20-45dd-b437-f0ee6dccc1fa')
											->update($arr );
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}