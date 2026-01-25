<?php

namespace App\Http\Controllers\Preview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\TindakanPasien;
use App\Exports\RegistrasiPasien;
use App\Exports\CetakKartuStock;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\StockOpname;
use App\Models\LayananPasien;
use App\Models\ResepRacikan;

class KartuStockCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function stock($posisi, $dari, $ke) {
		$uuid = '';
		$nama = '';
		if ($posisi == 'kartustockall') { $uuid = 'all'; $nama = 'All Kartu Stock'; }

		$filename = date('Y-m-d').'- Kartu Stock Obat-Alkes - '.$nama.'.xlsx';
		return \Excel::download(new CetakKartuStock($posisi, $dari, $ke), $filename);
	}

}