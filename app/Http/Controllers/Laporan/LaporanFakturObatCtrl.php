<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\FakturObat;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;

class LaporanFakturObatCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function datapage(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data histori pengguna');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		//$search = $request->search; $column = $request->column;

		$data = DB::table('pembelian_detail')
								->select([
									'nama_supplier',
									'no_faktur',
									DB::raw("count(no_faktur) as jumlah"),
									DB::raw("sum(jumlah_kecil * harga_kecil) as total"),
									'penerima'
								])
								->groupBy([
									'nama_supplier',
									'no_faktur',
									'penerima'
								])
								->whereDate('tanggal_faktur', '=', $request->dari)
								->get();
		
		$total = DB::table('pembelian_detail')
							->select([
								'nama_supplier',
								'no_faktur',
								DB::raw("count(no_faktur) as jumlah"),
								DB::raw("sum(jumlah_kecil * harga_kecil) as total"),
								'penerima'
							])
							->groupBy([
								'nama_supplier',
								'no_faktur',
								'penerima'
							])
							->whereDate('tanggal_faktur', '=', $request->dari)
							->count();
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function dataexcel($dari) {
		$filename = date('Y-m-d').'-Faktur Obat.xlsx';
		return \Excel::download(new FakturObat($dari), $filename);
	}


}