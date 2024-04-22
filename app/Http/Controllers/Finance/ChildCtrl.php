<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\CaraBayar;
use App\Models\Asuransi;

class ChildCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function data(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = CaraBayar::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil infomasi tentang child dari metode pembayaran dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit child metode pembayaran');
		}

		$child = Asuransi::where('carabayar_uuid', '=', $request->uuid)->get();
		
		return response()->json(['data' => $data, 'child' => $child]);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan/ child pada metode pembayaran '.$request->carabayar_nama.' dengan nama '.$request->nama);

		try{
			DB::beginTransaction();

			$item = new Asuransi();
			$item->uuid = Uuid::uuid4();
			$item->nama = $request->nama;
			$item->carabayar_uuid = $request->carabayar_uuid;
			$item->carabayar_nama = $request->carabayar_nama;
			$item->save();

			$item = Asuransi::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();

			DB::commit();

			return response()->json(['data' => 'berhasil', 'item' => $item]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$get = Asuransi::where('uuid', '=', $request->uuid)->first();
		PenggunaHelp::log('Menghapus child pada metode pembayaran '.$request->carabayar_nama.' dengan nama '.$get->nama);

		try{
			DB::beginTransaction();

			$remove = Asuransi::where('uuid', '=', $request->uuid)->delete();

			$item = Asuransi::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();

			DB::commit();

			return response()->json(['data' => 'berhasil', 'item' => $item]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}