<?php

namespace App\Http\Controllers\RawatJalan;

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

class PrintRekamMedisCtrl extends Controller
{

  public function __construct()
  {
    date_default_timezone_set("Asia/Jakarta");
    $this->error = PenggunaHelp::acl();
  }

  function print($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();

    $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printRm1dot1($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot1',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm1dot2($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-jalan.rm1dot2', compact('pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  function printRm1dot3($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-jalan.rm1dot3')->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  function printRm1dot4($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = DB::table('pemeriksaan_ro')
      ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
      ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot4',
      compact(
        'pasien',
        'ro'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm1dot5($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-jalan.rm1dot5')->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot');
  }
  function printRm1dot6($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');
    $pdf->loadView('print-rekam-medis.rawat-jalan.rm1dot6', compact('pasien'))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }

  function all($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = DB::table('pemeriksaan_ro')
      ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
      ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.all',
      compact(
        'pasien',
        'ro'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printRm1dot7($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = DB::table('pemeriksaan_ro')
      ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
      ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot7',
      compact(
        'pasien',
        'ro'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
}
