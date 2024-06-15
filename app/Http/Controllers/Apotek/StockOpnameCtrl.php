<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use App\Models\MintaTerimaOpname;
use App\Models\Resep;
use App\Models\ResepBebas;
use App\Models\ResepRacikan;
use App\Models\ResepRacikanBebas;
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
								->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = StockOpname::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = StockOpname::where('delete_soft', '=', 1)
									->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = StockOpname::where('delete_soft', '=', 1)->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')->orderBy('id', 'desc')->count();

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
											->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
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
											->where('unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
											->update($arr );
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function rincian(Request $request){
		$mintaTerima = DB::table('minta_terima_opname')->where('obat_uuid', $request->obat_uuid)
			->where('status', 'Diterima')
			->where('delete_soft', 1)
			->select(
				DB::raw("'masuk' as jenis"), 
				DB::raw("'Apotek' as domain"), 
				DB::raw('minta_kecil::text as jumlah_kecil'), 
				DB::raw('minta_besar::text as jumlah_besar'), 
				'tanggal_terima as tanggal', 
				'jam_terima as waktu', 
				'created_at',
			);
		$resep = DB::table('resep')->where('obat_uuid', $request->obat_uuid)
			->where('delete_soft', 1)
			->select(
				DB::raw("'keluar' as jenis"), 
				DB::raw("'Resep' as domain"), 
				DB::raw("'1' AS jumlah_kecil"), 
				DB::raw("'1' AS jumlah_besar"), 
				'tanggal', 
				'waktu', 
				'created_at'
			);
		$resepBebas = DB::table('resepbebas')->where('obat_uuid', $request->obat_uuid)
			->where('delete_soft', 1)
			->select(
				DB::raw("'keluar' as jenis"), 
				DB::raw("'Resep Bebas' as domain"), 
				DB::raw("'1' AS jumlah_kecil"), 
				DB::raw("'1' AS jumlah_besar"), 
				'tanggal', 
				'waktu', 
				'created_at'
			);
		$resepRacikan = DB::table('resepracikan')
			->joinSub(
				DB::table('resepracikan')->select('id', DB::raw('jsonb_array_elements(informasi::jsonb) AS elements')),
				'subquery', 'resepracikan.id', '=', 'subquery.id'
			)
			->where('delete_soft', 1)
			->whereRaw("subquery.elements::json->>'obat_uuid' = ?", [$request->obat_uuid])
			->select(
				DB::raw("'keluar' as jenis"), 
				DB::raw("'Resep Racikan' as domain"), 
				DB::raw("subquery.elements::json->>'jumlah_kecil' as jumlah_kecil"), 
				DB::raw("subquery.elements::json->>'jumlah_besar' as jumlah_besar"), 
				'tanggal', 
				'waktu', 
				'resepracikan.created_at'
			);
		$resepRacikanBebas = DB::table('resepracikanbebas')
			->joinSub(
				DB::table('resepracikanbebas')->select('id', DB::raw('jsonb_array_elements(informasi::jsonb) AS elements')),
				'subquery', 'resepracikanbebas.id', '=', 'subquery.id'
			)
			->where('delete_soft', 1)
			->whereRaw("subquery.elements::json->>'obat_uuid' = ?", [$request->obat_uuid])
			->select(
				DB::raw("'keluar' as jenis"), 
				DB::raw("'Resep Racikan Bebas' as domain"), 
				DB::raw("subquery.elements::json->>'jumlah_kecil' as jumlah_kecil"),  
				DB::raw("subquery.elements::json->>'jumlah_besar' as jumlah_besar"), 
				'tanggal', 
				'waktu', 
				'resepracikanbebas.created_at'
			);
		
		$data = $mintaTerima
			->union($resep)
			->union($resepBebas)
			->union($resepRacikan)
			->union($resepRacikanBebas)
			->orderBy('created_at', 'DESC')
			->paginate(15);

		return response()->json($data);
	}
}