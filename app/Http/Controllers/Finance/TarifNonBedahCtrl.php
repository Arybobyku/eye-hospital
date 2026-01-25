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
use App\Models\CaraBayarTindakanNonBedah;

class TarifNonBedahCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$request->tindakan_nama);

		try{
			DB::beginTransaction();

			if ($request->uuid != '' && $request->uuid != ' ' && $request->uuid) {
				
				$arr = array(
					'carabayar_uuid' => $request->carabayar_uuid,
					'carabayar_nama' => $request->carabayar_nama,
					'tindakan_rawat_jalan_uuid' => $request->tindakan_uuid,
					'nama_tindakan_rawat_jalan' => $request->tindakan_nama,
					'harga' => $request->harga,
					'default' => $request->default != '' && $request->default ? $request->default : 'Tidak'
				);
				
				$item = CaraBayarTindakanNonBedah::where('uuid', '=', $request->uuid)->update($arr);
			}
			else {

					$item = new CaraBayarTindakanNonBedah();
					$item->uuid = Uuid::uuid4();
					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
					$item->tindakan_non_bedah_uuid = $request->tindakan_uuid;
					$item->nama_tindakan_non_bedah = $request->tindakan_nama;
					$item->harga = $request->harga;
					$item->default = $request->default != '' && $request->default ? $request->default : 'Tidak';
					$item->save();
			}

			$item = CaraBayarTindakanNonBedah::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();

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

		$get = CaraBayarTindakanNonBedah::where('uuid', '=', $request->uuid)->first();
		PenggunaHelp::log('Menghapus 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$get->nama_tindakan_rawat_jalan);

		try{
			DB::beginTransaction();

			$remove = CaraBayarTindakanNonBedah::where('uuid', '=', $request->uuid)->delete();
			$item = CaraBayarTindakanNonBedah::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();
			DB::commit();

			return response()->json(['data' => 'berhasil', 'item' => $item]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}