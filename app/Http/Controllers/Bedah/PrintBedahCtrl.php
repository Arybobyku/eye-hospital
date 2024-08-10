<?php

namespace App\Http\Controllers\Bedah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\Resep;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use PDF;

class PrintBedahCtrl extends Controller
{

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

  function print($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
        $firstRegistrasi = Registrasi::where('pasien_uuid', '=', $pasien->uuid)->first();
    
    $pdf->loadView('print.printpersetujuan', compact('pasien','registrasi','firstRegistrasi'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
  }
}
