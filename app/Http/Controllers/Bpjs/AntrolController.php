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

	public function getAntrian(Request $request)
	{

		$result = $this->bridging->getRequest('/ref/poli');
		return response()->json($result);
		//$endpoint = 'referensi/diagnosa/' . $kode;
		//return $this->bridging->getRequest($endpoint);
	}
}
