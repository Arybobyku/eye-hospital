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
use App\Models\Tarif;
use App\Models\CaraBayarKamar;

class TarifKamarCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan jenis kamar '.$request->nama_jenis_kamar);

		try{
			DB::beginTransaction();

			if ($request->uuid != '' && $request->uuid != ' ' && $request->uuid) {
				
				$arr = array(
					'carabayar_uuid' => $request->carabayar_uuid,
					'carabayar_nama' => $request->carabayar_nama,
					'jenis_kamar_uuid' => $request->jenis_kamar_uuid,
					'nama_jenis_kamar' => $request->nama_jenis_kamar,
					'harga' => $request->harga,
					'jenis' => $request->jenis,
					'default' => $request->default != '' && $request->default ? $request->default : 'Tidak'
				);
				
				$item = CaraBayarKamar::where('uuid', '=', $request->uuid)->update($arr);
			}
			else {
				$item = new CaraBayarKamar();
				$item->uuid = Uuid::uuid4();
				$item->carabayar_uuid = $request->carabayar_uuid;
				$item->carabayar_nama = $request->carabayar_nama;
				$item->jenis_kamar_uuid = $request->jenis_kamar_uuid;
				$item->nama_jenis_kamar = $request->nama_jenis_kamar;
				$item->harga = $request->harga;
				$item->jenis = $request->jenis;
				$item->default = $request->default != '' && $request->default ? $request->default : 'Tidak';
				$item->save();
			}

			$item = CaraBayarKamar::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();

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

		$get = CaraBayarKamar::where('uuid', '=', $request->uuid)->first();
		PenggunaHelp::log('Menghapus 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$get->nama_jenis_kamar);

		try{
			DB::beginTransaction();

			$remove = CaraBayarKamar::where('uuid', '=', $request->uuid)->delete();
			$item = CaraBayarKamar::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();
			DB::commit();

			return response()->json(['data' => 'berhasil', 'item' => $item]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}