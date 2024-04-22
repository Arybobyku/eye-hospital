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
use App\Exports\CetakStock;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\StockOpname;
use App\Models\LayananPasien;
use App\Models\ResepRacikan;

class StockCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function stock($posisi) {
		$uuid = '';
		$nama = '';
		if ($posisi == 'apotek') { $uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b'; $nama = 'Apotek'; }
		else if ($posisi == 'gudang') { $uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f'; $nama = 'Gudang Farmasi'; }
		else if ($posisi == 'bedah') { $uuid = 'c7887937-6e20-45dd-b437-f0ee6dccc1fa'; $nama = 'Bedah Central'; }
		else if ($posisi == 'rawatjalan') { $uuid = '60df3cd5-57c2-4f05-b5fa-dffba34400dc'; $nama = 'Rawat Jalan'; }

		$filename = date('Y-m-d').'- Stock Obat-Alkes '.$nama.'.xlsx';
		return \Excel::download(new CetakStock($posisi), $filename);
	}

}