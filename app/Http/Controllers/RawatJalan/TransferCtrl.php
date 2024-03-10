<?php

namespace App\Http\Controllers\RawatJalan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\PenanggungJawab;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\LayananPasien;
use App\Models\CaraBayarKamar;
use App\Models\KamarInap;
use App\Models\PasienTransfer;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;

class TransferCtrl extends Controller
{

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function addtransfer(Request $request) {
		try{
			$arr = null;
			if ($request->nama_dokter != '' && $request->nama_dokter != 'Silahkan Pilih') {
				$arr = array(
					'transfer_pengguna_uuid' => $request->pengguna_uuid,
					'transfer_nama_dokter' => $request->nama_dokter
				);
			}
			else {
				$arr = array(
					'transfer_pengguna_uuid' => '-',
					'transfer_nama_dokter' => '-'
				);
			}
			
			$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

			$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

			return response()->json(['data' => $data]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function gettransfer(Request $request) {
		$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
		return response()->json(['data' => $data]);
	}

	public function removetransfer(Request $request) {
		$data = PasienTransfer::where('uuid', '=', $request->uuid)->delete();
		$data = PasienTransfer::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();

			return response()->json(['data' => $data]);
	}

}