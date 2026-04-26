<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Biodata;
use App\Models\Registrasi;
use App\Models\LogPengguna;

class DashboardCtrl extends Controller
{

	private $take = 10, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function data(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat halaman data profile');

		$today = DB::table('registrasi')->whereDate('tanggal', '=', date('Y-m-d'))->count();
		$today = DB::table('registrasi')->whereDate('tanggal', '=', date('Y-m-d'))->count();
		$logpengguna = DB::table('log_pengguna')->orderBy('id','desc')
										->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
										->limit(15)
										->get();
		
		return response()->json([
			'biodata' => $biodata,
			'logpengguna' => $logpengguna,
		]);
	}

}