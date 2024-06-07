<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;


class VclaimCtrl extends Controller
{
	protected $bridging;

	public function __construct()
	{
		$this->bridging = new BridgeVclaim();
	}

	// Example To use get Referensi diagnosa
	// Name of Method example
	public function diagnosa($kode = "a32")
	{
		return "asw";
		//$endpoint = 'referensi/diagnosa/' . $kode;
		//return $this->bridging->getRequest($endpoint);
	}

}