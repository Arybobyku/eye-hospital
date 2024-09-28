<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Bpjs\Bridging\Antrol\BridgeAntrol;

class AntrolController extends Controller
{
	protected $bridging;
	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->bridging = new BridgeAntrol();
	}


	public function getReferensiPoli(Request $request)
	{
		$data = [
			"list" => [
				[
					"nmpoli" => "AKUPUNTUR MEDIK",
					"nmsubspesialis" => "AKUPUNTUR MEDIK",
					"kdsubspesialis" => "AKP",
					"kdpoli" => "AKP"
				],
				[
					"nmpoli" => "ANAK",
					"nmsubspesialis" => "ANAK ALERGI IMUNOLOGI",
					"kdsubspesialis" => "027",
					"kdpoli" => "ANA"
				]
			]
		];

		return response()->json($data);
	}

	public function getReferensiDokter(Request $request)
	{
		$data = [
			"list" => [
				[
					"namadokter" => "drg. Kusumawati Sukadi, Sp.BM",
					"kodedokter" => 700
				],
				[
					"namadokter" => "Dr. Dr. Noer Rachma, Sp.KFR",
					"kodedokter" => 854
				]
			]
		];

		return response()->json($data);
	}

	public function getReferensiJadwalDokter(Request $request)
	{
		$data = [
			"list" => [
				[
					"kodesubspesialis" => "ANA",
					"hari" => 4,
					"kapasitaspasien" => 54,
					"libur" => 0,
					"namahari" => "KAMIS",
					"jadwal" => "08:00 - 12:00",
					"namasubspesialis" => "ANAK",
					"namadokter" => "DR. OKTORA WAHYU WIJAYANTO, SP.A",
					"kodepoli" => "ANA",
					"namapoli" => "Anak",
					"kodedokter" => 33690
				],
				[
					"kodesubspesialis" => "ANA",
					"hari" => 4,
					"kapasitaspasien" => 20,
					"libur" => 0,
					"namahari" => "KAMIS",
					"jadwal" => "13:00 - 17:00",
					"namasubspesialis" => "ANAK",
					"namadokter" => "DR. OKTORA WAHYU WIJAYANTO, SP.A",
					"kodepoli" => "ANA",
					"namapoli" => "Anak",
					"kodedokter" => 33690
				]
			]
		];

		return response()->json($data);
	}

	public function getAntrian(Request $request)
	{

		$result = $this->bridging->getRequest('ref/poli');
		return response()->json($result);
		//$endpoint = 'referensi/diagnosa/' . $kode;
		//return $this->bridging->getRequest($endpoint);
	}
}
