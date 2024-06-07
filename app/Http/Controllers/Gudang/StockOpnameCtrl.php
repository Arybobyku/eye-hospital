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

	public function rincian(Request $request){
		$mintaTerima = DB::table('minta_terima_opname')->where('obat_uuid', $request->obat_uuid)
			->where('status', 'Diterima')
			->where('delete_soft', 1)
			->select(
				DB::raw("'keluar' as jenis"), 
				DB::raw("dari_nama_unit as domain"), 
				DB::raw('minta_kecil::text as jumlah_kecil'), 
				DB::raw('minta_besar::text as jumlah_besar'), 
				'tanggal_terima as tanggal', 
				'jam_terima as waktu', 
				'created_at',
			);
		// Pakai kolom jumlah_kecil dan jumlah_besar
		// Asumsi pembelian yang sudah approve saja yang dianggap obat masuk
		$pembelian = DB::table('pembelian_detail', 'detail')
			->join('pembelian', 'detail.pembelian_uuid', '=', 'pembelian.uuid')
			->where('pembelian.status', 'approve')
			->where('detail.obat_uuid', $request->obat_uuid)
			->where('detail.delete_soft', 1)
			->where('pembelian.delete_soft', 1)
			->select(
				DB::raw("'masuk' as jenis"), 
				DB::raw("pembelian.nama_supplier as domain"), 
				DB::raw('jumlah_kecil::text'), 
				DB::raw('jumlah_besar::text'), 
				DB::raw('DATE(detail.created_at) as tanggal'), 
				DB::raw("to_char(detail.created_at, 'hh24:mi') as waktu"), 
				'detail.created_at'
			);
		
		$data = $mintaTerima
			->union($pembelian)
			->orderBy('created_at', 'DESC')
			->paginate(15);

		return response()->json($data);
	}
}