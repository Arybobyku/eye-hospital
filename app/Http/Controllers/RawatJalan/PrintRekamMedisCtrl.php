<?php

namespace App\Http\Controllers\RawatJalan;

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
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = DB::table('pemeriksaan_ro')
      ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
      ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot3',
      compact(
        'pasien',
        'ro'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
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
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = DB::table('pemeriksaan_ro')
      ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
      ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot5',
      compact(
        'pasien',
        'ro'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
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

  function printRm1dot10($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ppo = PerawatanPeriOperative::where('pasien_uuid', '=', $uuid)->first();
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->first();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    // $ppo = PerawatanPeriOperative::where('pasien_uuid', '=', $uuid)->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.bedah.rm1dot10',
      compact(
        'pasien',
        'ppo',
        'roperasi',
        'ro',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm1dot8($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'asc')
      ->first();
    //dump($ptk);die();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm1dot8',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm2dot0($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $ckb = ChecklistKesiapanBedah::where('pasien_uuid', '=', $uuid)->first();

    $linen_steril = [
      false,
      false,
      false,
      false,
    ];

    $jsonDatalinen_steril = $ckb->linen_steril;
    if ($jsonDatalinen_steril != '' || $jsonDatalinen_steril != null) {
      $dataArraylinen_steril = json_decode($jsonDatalinen_steril, true);

      foreach ($dataArraylinen_steril as $datalinen_steril) {
        if ("Jas steril" == $datalinen_steril['nama']) {
          $linen_steril[0] = true;
        }
        if ("Duk steril" == $datalinen_steril['nama']) {
          $linen_steril[1] = true;
        }
        if ("Linen meja instrumen" == $datalinen_steril['nama']) {
          $linen_steril[2] = true;
        }
        if ("Kasa" == $datalinen_steril['nama']) {
          $linen_steril[3] = true;
        }
      }
    }

    $alat = [
      false,
      false,
      false,
      false,
      false,

    ];

    $jsonDataalat = $ckb->alat;
    if ($jsonDataalat != '' || $jsonDataalat != null) {
      $dataArrayalat = json_decode($jsonDataalat, true);

      foreach ($dataArrayalat as $dataalat) {
        if ("Casette, selang, Diatermi, dan kenoktor Mesin Phaco sudah tersedia" == $dataalat['nama']) {
          $alat[0] = true;
        }
        if ("Patient plate sudah tersedia" == $dataalat['nama']) {
          $alat[1] = true;
        }
        if ("Instrument steril sesuai dengan kebutuhan sudah tersedia" == $dataalat['nama']) {
          $alat[2] = true;
        }
        if ("Handle Microskop streril" == $dataalat['nama']) {
          $alat[3] = true;
        }
        if ("Kom kidney steril sudah tersedia" == $dataalat['nama']) {
          $alat[4] = true;
        }
      }
    }

    $listrik = [
      false,
      false,
      false,
      false,
      false,
      false,
      false,
      false,
      false,
    ];
    $jsonDatalistrik = $ckb->listrik;

    // Menguraikan JSON menjadi array PHP
    if ($jsonDatalistrik != '' || $jsonDatalistrik != null) {
      $dataArraylistrik = json_decode($jsonDatalistrik, true);

      foreach ($dataArraylistrik as $datalistrik) {
        if ("Mesin anastesi terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[0] = true;
        }
        if ("Mesin Phaco terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[1] = true;
        }
        if ("Light source, monitor Mata terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[2] = true;
        }
        if ("Extention kabel terhubung degan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[3] = true;
        }
        if ("Meja operasi terhubung degan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[4] = true;
        }
        if ("Microskop terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
          $listrik[5] = true;
        }
        if ("Lampu kamar operasi menyala" == $datalistrik['nama']) {
          $listrik[6] = true;
        }
        if ("AC berfungsi dengan baik" == $datalistrik['nama']) {
          $listrik[7] = true;
        }
        if ("Gas medis terhubung dengan mesin, indikator (+)" == $datalistrik['nama']) {
          $listrik[8] = true;
        }
      }
    }

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot0',
      compact('pasien', 'listrik', 'ckb', 'alat', 'linen_steril',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm2dot2($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $lp = LaporanPembedahan::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot2',
      compact('pasien','lp',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm2dot3($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $cok = CatatanOperasiKatarak::where('pasien_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot3',
      compact('pasien', 'cok',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm8dot7($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm8dot7',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm8dot9($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm8dot9',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm4dot9($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
    $kb = KeselamatanBedah::where('pasien_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm4dot9',
      compact('pasien', 'roperasi', 'kb',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm8dot10($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm8dot10',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm1dot9($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm1dot9',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm9dot0($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm9dot0',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm8dot8($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm8dot8',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm9dot1($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm9dot1',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm2dot9($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot9',
      compact('pasien')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function all_bedah($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $ro = DB::table('pemeriksaan_ro')
    //   ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_ro.registrasi_uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
    //   ->where('pemeriksaan_ro.pasien_uuid', '=', $uuid)
    //   ->get();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
      $kb = KeselamatanBedah::where('pasien_uuid', '=', $uuid)->first();
      $cok = CatatanOperasiKatarak::where('pasien_uuid', '=', $uuid)->first();
      $lp = LaporanPembedahan::where('pasien_uuid', '=', $uuid)->first();
      $ckb = ChecklistKesiapanBedah::where('pasien_uuid', '=', $uuid)->first();
      $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'asc')
      ->first();
      $ppo = PerawatanPeriOperative::where('pasien_uuid', '=', $uuid)->first();
      $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->first();
      $linen_steril = [
        false,
        false,
        false,
        false,
      ];
  
      $jsonDatalinen_steril = $ckb->linen_steril;
      if ($jsonDatalinen_steril != '' || $jsonDatalinen_steril != null) {
        $dataArraylinen_steril = json_decode($jsonDatalinen_steril, true);
  
        foreach ($dataArraylinen_steril as $datalinen_steril) {
          if ("Jas steril" == $datalinen_steril['nama']) {
            $linen_steril[0] = true;
          }
          if ("Duk steril" == $datalinen_steril['nama']) {
            $linen_steril[1] = true;
          }
          if ("Linen meja instrumen" == $datalinen_steril['nama']) {
            $linen_steril[2] = true;
          }
          if ("Kasa" == $datalinen_steril['nama']) {
            $linen_steril[3] = true;
          }
        }
      }
  
      $alat = [
        false,
        false,
        false,
        false,
        false,
  
      ];
  
      $jsonDataalat = $ckb->alat;
      if ($jsonDataalat != '' || $jsonDataalat != null) {
        $dataArrayalat = json_decode($jsonDataalat, true);
  
        foreach ($dataArrayalat as $dataalat) {
          if ("Casette, selang, Diatermi, dan kenoktor Mesin Phaco sudah tersedia" == $dataalat['nama']) {
            $alat[0] = true;
          }
          if ("Patient plate sudah tersedia" == $dataalat['nama']) {
            $alat[1] = true;
          }
          if ("Instrument steril sesuai dengan kebutuhan sudah tersedia" == $dataalat['nama']) {
            $alat[2] = true;
          }
          if ("Handle Microskop streril" == $dataalat['nama']) {
            $alat[3] = true;
          }
          if ("Kom kidney steril sudah tersedia" == $dataalat['nama']) {
            $alat[4] = true;
          }
        }
      }
  
      $listrik = [
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
      ];
      $jsonDatalistrik = $ckb->listrik;
  
      // Menguraikan JSON menjadi array PHP
      if ($jsonDatalistrik != '' || $jsonDatalistrik != null) {
        $dataArraylistrik = json_decode($jsonDatalistrik, true);
  
        foreach ($dataArraylistrik as $datalistrik) {
          if ("Mesin anastesi terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[0] = true;
          }
          if ("Mesin Phaco terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[1] = true;
          }
          if ("Light source, monitor Mata terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[2] = true;
          }
          if ("Extention kabel terhubung degan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[3] = true;
          }
          if ("Meja operasi terhubung degan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[4] = true;
          }
          if ("Microskop terhubung dengan sumber listrik, indikator (+)" == $datalistrik['nama']) {
            $listrik[5] = true;
          }
          if ("Lampu kamar operasi menyala" == $datalistrik['nama']) {
            $listrik[6] = true;
          }
          if ("AC berfungsi dengan baik" == $datalistrik['nama']) {
            $listrik[7] = true;
          }
          if ("Gas medis terhubung dengan mesin, indikator (+)" == $datalistrik['nama']) {
            $listrik[8] = true;
          }
        }
      }

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.bedah.all_bedah',
      compact(
        'pasien',
        'ro',
        'kb',
        'cok',
        'lp',
        'ckb',
        'ptk',
        'ppo',
        'roperasi',
        'listrik',
        'alat',
        'linen_steril',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
}
