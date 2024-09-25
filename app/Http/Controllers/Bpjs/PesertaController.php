<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;

class PesertaController extends Controller
{
	protected $bridging;
    public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->bridging = new BridgeVclaim();
	}
}
