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
use App\Models\CaraBayarTindakanBedah;

class TarifBedahCtrl extends Controller
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
					'tindakan_bedah_uuid' => $request->tindakan_uuid,
					'nama_tindakan_bedah' => $request->tindakan_nama,
					'jenis_tindakan_bedah' => $request->jenis_tindakan_bedah,
					'vvip_harga' => $request->vvip_harga,
					'vip_harga' => $request->vip_harga,
					'kelas1_harga' => $request->kelas1_harga,
					'kelas2_harga' => $request->kelas2_harga,
					'kelas3_harga' => $request->kelas3_harga,
					'default' => $request->default != '' && $request->default ? $request->default : 'Tidak'
				);
				
				$item = CaraBayarTindakanBedah::where('uuid', '=', $request->uuid)->update($arr);
			}
			else {
				$item = new CaraBayarTindakanBedah();
				$item->uuid = Uuid::uuid4();
				$item->carabayar_uuid = $request->carabayar_uuid;
				$item->carabayar_nama = $request->carabayar_nama;
				$item->tindakan_bedah_uuid = $request->tindakan_uuid;
				$item->nama_tindakan_bedah = $request->tindakan_nama;
				$item->jenis_tindakan_bedah = $request->jenis_tindakan_bedah;
				$item->vvip_harga = $request->vvip_harga;
				$item->vip_harga = $request->vip_harga;
				$item->kelas1_harga = $request->kelas1_harga;
				$item->kelas2_harga = $request->kelas2_harga;
				$item->kelas3_harga = $request->kelas3_harga;
				$item->default = $request->default != '' && $request->default ? $request->default : 'Tidak';
				$item->save();
			}

			$item = CaraBayarTindakanBedah::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();

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

		$get = CaraBayarTindakanBedah::where('uuid', '=', $request->uuid)->first();
		PenggunaHelp::log('Menghapus 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$get->nama_tindakan_rawat_jalan);

		try{
			DB::beginTransaction();

			$remove = CaraBayarTindakanBedah::where('uuid', '=', $request->uuid)->delete();
			$item = CaraBayarTindakanBedah::where('carabayar_uuid', '=', $request->carabayar_uuid)->get();
			DB::commit();

			return response()->json(['data' => 'berhasil', 'item' => $item]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}