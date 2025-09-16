<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\RuangPoli;

use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Biodata;
use App\Models\LogPengguna;


class RuangPoliCtrl extends Controller
{

	private $take = 15, $error = 'next';


	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		// $this->bridging = new BridgeVclaim();
	}
	public function list(Request $request)
	{


		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		//PenggunaHelp::log('(Bedah) Melihat data list table pada halaman data permintaan obat/alkes pada unit bedah');

		$data = RuangPoli::orderBy('ruang_poli', 'asc')
		->get();

		$total = RuangPoli::count();

		return response()->json(['data' => $data, 'total' => $total]);

	}
	public function detail(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = RuangPoli::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data Ruang Poli "' . $data->ruang_poli . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman detail Ruang Poli');
		}


		return response()->json(['data' => $data]);
	}
	public function update(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$biodata = Biodata::where('uuid', '=', $request->dokter_uuid)->first();
		$dokterBpjs = Pengguna::where('uuid', '=', $biodata->pengguna_uuid)->first();
		// dd($request->dokter_uuid);
		$arr = ['dokter_uuid' => $biodata->pengguna_uuid,
				'nama_dokter' => $request->nama_dokter,
				'kode_dokter_bpjs' => $dokterBpjs->kode_dokter_bpjs_kes,
			];
		$update = RuangPoli::where('uuid', '=', $request->uuid)->update($arr);
		return response()->json([
			'data' => 'success'
		]);
	}
	public function referensiRuangPoli($param1)
    {

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$ruangPoli = RuangPoli::where('kode_dokter_bpjs', '=', $param1)->first();


        if (!$ruangPoli) {
            return response()->json(['message' => 'Ruang Poli tidak ditemukan'], 404);
        }

        return response()->json($ruangPoli);
    }

}