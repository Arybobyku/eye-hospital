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
use App\Models\CaraBayarTindakanRawatJalan;
use App\Models\CaraBayarTindakanNonBedah;
use App\Models\CaraBayarTindakanBedah;
use App\Models\CaraBayarKamar;

class TarifCtrl extends Controller
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
			PenggunaHelp::log('Mengambil infomasi tentang tarif dari metode pembayaran dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit tarif metode pembayaran');
		}

		$tindakanrawatjalan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $request->uuid)->get();
		$tindakannonbedah = CaraBayarTindakanNonBedah::where('carabayar_uuid', '=', $request->uuid)->get();
		$tindakanbedah = CaraBayarTindakanBedah::where('carabayar_uuid', '=', $request->uuid)->get();
		$jeniskamar = CaraBayarKamar::where('carabayar_uuid', '=', $request->uuid)->get();
		
		return response()->json(['data' => $data, 
			'tindakanrawatjalan' => $tindakanrawatjalan,
			'tindakannonbedah' => $tindakannonbedah,
			'tindakanbedah' => $tindakanbedah,
			'jeniskamar' => $jeniskamar,
		]);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$request->nama);

		try{
			DB::beginTransaction();

			$item = new Tarif();
			$item->uuid = Uuid::uuid4();
			$item->nama = $request->nama;
			$item->harga = $request->harga;
			$item->carabayar_uuid = $request->carabayar_uuid;
			$item->carabayar_nama = $request->carabayar_nama;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menghapus 1 tarif pada metode pembayaran '.$request->carabayar_nama.' dengan nama layanan/tindakan '.$request->nama);

		try{
			DB::beginTransaction();

			$item = new Tarif();
			$item->uuid = Uuid::uuid4();
			$item->nama = $request->nama;
			$item->harga = $request->harga;
			$item->carabayar_uuid = $request->carabayar_uuid;
			$item->carabayar_nama = $request->carabayar_nama;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}