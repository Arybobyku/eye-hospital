<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\KontrolPasien;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
class LaporanKontrolCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function registrasi($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid) {
		$filename = date('Y-m-d').'- Kontrol Pasien.xlsx';
		return \Excel::download(new KontrolPasien($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid), $filename);
	}

}