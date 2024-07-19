<?php

namespace App\Http\Controllers\RawatInap;

use App\Models\CatatanOperasiKatarak;
use App\Models\KeselamatanBedah;
use App\Models\LaporanPembedahan;
use App\Models\PerawatanPeriOperative;
use App\Models\RegistrasiOperasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChecklistKesiapanBedah;
use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\Pasien;
use App\Models\PersetujuanTindakanKedokteran;
use App\Models\Registrasi;
use App\Models\Resep;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use PDF;

class PrintRekamMedisInapCtrl extends Controller
{

  public function __construct()
  {
    date_default_timezone_set("Asia/Jakarta");
    $this->error = PenggunaHelp::acl();
  }
  function printRm1dot1($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-inap.rm1dot1', compact('pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  function printRm2dot5($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-inap.rm2dot5', compact('pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  function printRm2dot6($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-inap.rm2dot6', compact('pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  
}

    