<?php

namespace App\Http\Controllers\RawatJalan;

use App\Models\CatatanOperasiKatarak;
use App\Models\EdukasiPasien;
use App\Models\KeselamatanBedah;
use App\Models\LaporanPembedahan;
use App\Models\PemeriksaanDokterIcd10;
use App\Models\PerawatanPeriOperative;
use App\Models\RegistrasiOperasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChecklistKesiapanBedah;
use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\Pasien;
use App\Models\PencegahanPasienJatuh;
use App\Models\PersetujuanTindakanKedokteran;
use App\Models\Registrasi;
use App\Models\DokumenResumeMedisRawatInap;
use App\Models\DokumenResumePerawatanRawatJalan;
use App\Models\DokumenCPPTRawatInap;
use App\Models\DokumenResumeMedisRawatJalan;
use App\Models\DokumenCatatanKeperawatan;
use App\Models\DokumenMonitoringEfekSampingObat;
use App\Models\Cppt;
use App\Models\DokumenSuratBalasanKonsul;
use App\Models\DokumenProtokolTindakanTerapi;
use App\Models\DokumenSuratKeteranganHasilPemeriksaanMata;
use App\Models\DokumenSuratKeteranganMata;
use App\Models\DokumenInformasiTindakanAnastesi;
use App\Models\DokumenPersiapanPeralatanAnestesi;
use App\Models\DokumenCPPTRawatJalan;
use App\Models\DokumenCatatanPerkembanganTerintegrasi;
use App\Models\DokumenPemberianEdukasiPasienTerintegrasi;
use App\Models\DokumenChecklistKeselamatanPasienOperasi;
use App\Models\DokumenEvaluasiPraAnestesi;
use App\Models\DokumenPengkajianAwalMedisMata;
use App\Models\DokumenPenilaianRisikoJatuhPasienGeriatri;
use App\Models\DokumenSuratKonsul;
use App\Models\DokumenTindakanLaserPRP;
use App\Models\DokumenSuratKontrol;
use App\Models\DokumenSuratPenolakanRujukan;
use App\Models\DokumenSuratPernyataanPasienUmum;
use App\Models\DokumenPersetujuanUmum;
use App\Models\DokumenLaporanOperasiTrabekulektomi;
use App\Models\DokumenLaporanOperasiPterygium;
use App\Models\DokumenLaporanEksisiChalazion;
use App\Models\DokumenLaporanEksisiPalpebra;
use App\Models\DokumenTindakanLaserCapsulotomy;
use App\Models\DokumenLaporanOperasiVitreoRetina;
use App\Models\DokumenTindakanEpilasi;
use App\Models\DokumenFormLaserBarrage;
use App\Models\DokumenFormLaserFokal;
use App\Models\DokumenAsuhanGizi;
use App\Models\DokumenCatatanOperasi;
use App\Models\DokumenSuratPernyataanBatalOperasi;
use App\Models\DokumenTindakanLaserLPI;
use App\Models\DokumenDietitianPasienBaru;
use App\Models\DokumenKronologisPasien;
use App\Models\DokumenPersetujuanPenolakanTindakanDokter;
use App\Models\PemeriksaanDokterIcd9;
use App\Models\DokumenCeklistKesiapanBedah;
use App\Models\FormEdukasiPasienDanKeluargaRawatJalan;
use App\Models\FormPersetujuanUmumPasienKeluarga;
use App\Models\FormProsesPerawatanPeriOperative;
use App\Models\FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap;
use App\Models\PenolakanTindakanAnestesi;
use App\Models\FormPengkajianKeperawatanMataRawatJalan;
use App\Models\FormLaporanInjeksi;
use App\Models\FormPermintaanPulang;
use App\Models\VoucherRawatInap;
use App\Models\FormReaksiTransfusiDarah;
use App\Models\DokumenAsesmenKeperawatanRawatInap;
use App\Models\Pengguna;
use App\Models\Resep;
use App\Models\ResepRacikan;
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

    $item = FormPersetujuanUmumPasienKeluarga::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $item->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot1',
      compact('pasien', 'item')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

function printGeneral($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    $item = DokumenPersetujuanUmum::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $item->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.general',
      compact('pasien', 'item')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printRm1dot2($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    $edukasiPasien = FormEdukasiPasienDanKeluargaRawatJalan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $edukasiPasien->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot2',
      compact('pasien', 'edukasiPasien')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printRm1dot3($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pengkajian = FormPengkajianKeperawatanMataRawatJalan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $pengkajian->uuid_pasien)->first();
    $dataRo = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();



    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot3',
      compact(
        'pasien',
        'dataRo',
        'pengkajian',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm1dot4($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
    $dataRo = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    $dataDokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
    $icd10 = PemeriksaanDokter::with(['pemeriksaanDokterIcdten'])
      ->where('pasien_uuid', $uuid)
      ->get();

    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot4',
      compact(
        'pasien',
        'dataRo',
        'dataDokter',
        'icd10',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm1dot5($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $cppt = Cppt::where('pasien_uuid', '=', $uuid)->get();
    $cppt = DB::table('cppt')
      ->leftJoin('pengguna', 'cppt.pengguna_uuid', '=', 'pengguna.uuid')
      ->where('cppt.pasien_uuid', '=', $uuid)
      ->select(
        'cppt.*',
        DB::raw('pengguna.nama as pengguna_nama_pengguna'), // Add all other biodata fields similarly
      )
      ->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot5',
      compact(
        'pasien',
        'cppt',
      ),
    )->setPaper('a4', 'potrait',);


    return $pdf->stream();
  }
  function printRm1dot6($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = PemeriksaanRO::with(['pemeriksaanDokter', 'pemeriksaanDokterIcdnine', 'pemeriksaanDokterIcdten', 'resep', 'registrasi'])
      ->where('pasien_uuid', $uuid)
      ->get();
    // $pdf->loadView('print.printrekammedis', compact('registrasi', 'pemeriksaanro', 'pemeriksaandokter', 'pasien'))->setPaper('a4', 'potrait');

    $pdf->loadView('print-rekam-medis.rawat-jalan.rm1dot6', compact('pasien', 'ro',))->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot3');
  }
  function all($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ep = EdukasiPasien::where('pasien_uuid', '=', $uuid)->first();
    $cppt = Cppt::where('pasien_uuid', '=', $uuid)->get();
    $dataRo = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    $dataDokter = PemeriksaanDokter::where('pasien_uuid', '=', $uuid)->first();
    $ro = PemeriksaanRO::with(['pemeriksaanDokter', 'pemeriksaanDokterIcdnine', 'pemeriksaanDokterIcdten', 'resep', 'registrasi'])
      ->where('pasien_uuid', $uuid)
      ->get();


    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.all',
      compact(
        'pasien',
        'ro',
        'ep',
        'cppt',
        'dataRo',
        'dataDokter'
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printRm1dot7($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ro = PemeriksaanRO::with(['pemeriksaanDokter', 'pemeriksaanDokterIcdnine', 'pemeriksaanDokterIcdten', 'resep'])
      ->where('pasien_uuid', $uuid)
      ->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.rm1dot7',
      compact(
        'pasien',
        'ro',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm1dot10($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    $perawatanPeriOperative = FormProsesPerawatanPeriOperative::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $perawatanPeriOperative->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.bedah.rm1dot10',
      compact('pasien', 'perawatanPeriOperative')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }
  function printRm1dot8($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenPersetujuanPenolakanTindakanDokter::where('id', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    // $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
    // $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
    //   ->orderBy('created_at', 'asc')
    //   ->first();
    // //dump($ptk);die();
    // $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm1dot8',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printRm2dot0($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    $ckb = DokumenCeklistKesiapanBedah::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $ckb->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot0',
      compact('pasien', 'ckb')
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
      compact('pasien', 'lp',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  function printRm2dot3($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenCatatanOperasi::where('uuid', '=', $uuid)->first();
    $cok = CatatanOperasiKatarak::where('pasien_uuid', '=', $data->uuid_pasien)->first();

    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot3',
      compact('pasien', 'cok', 'data')
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
    $jenistindakan = DB::table('laporan_injeksi_av')
      ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
      ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
      ->get();
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm8dot7',
      compact('pasien', 'jenistindakan')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
    // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  }
  // function printRm8dot9($uuid)
  // {
  //   $pdf = \App::make('dompdf.wrapper');
  //   // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
  //   // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
  //   // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
  //   $tindakan3 = DB::table('laporan_injeksi_av')
  //   ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
  //   ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
  //   ->first();
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.bedah.rm8dot9',
  //     compact('pasien', 'tindakan3')
  //   )->setPaper('a4', 'potrait');


  //   return $pdf->stream();
  //   // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  // }
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
  // function printRm8dot10($uuid)
  // {
  //   $pdf = \App::make('dompdf.wrapper');
  //   // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
  //   // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
  //   // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
  //   $tindakan4 = DB::table('laporan_injeksi_av')
  //   ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
  //   ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
  //   ->first();
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.bedah.rm8dot10',
  //     compact('pasien', 'tindakan4')
  //   )->setPaper('a4', 'potrait');


  //   return $pdf->stream();
  //   // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  // }
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
  // function printRm9dot0($uuid)
  // {
  //   $pdf = \App::make('dompdf.wrapper');
  //   // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
  //   // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
  //   // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
  //   $tindakan5 = DB::table('laporan_injeksi_av')
  //   ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
  //   ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
  //   ->first();
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.bedah.rm9dot0',
  //     compact('pasien', 'tindakan5')
  //   )->setPaper('a4', 'potrait');


  //   return $pdf->stream();
  //   // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  // }
  // function printRm8dot8($uuid)
  // {
  //   $pdf = \App::make('dompdf.wrapper');
  //   // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
  //   // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
  //   // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
  //   $tindakan2 = DB::table('laporan_injeksi_av')
  //   ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
  //   ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
  //   ->first();
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.bedah.rm8dot8',
  //     compact('pasien', 'tindakan2')
  //   )->setPaper('a4', 'potrait');


  //   return $pdf->stream();
  //   // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  // }
  // function printRm9dot1($uuid)
  // {
  //   $pdf = \App::make('dompdf.wrapper');
  //   // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
  //   // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
  //   // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();
  //   $tindakan6 = DB::table('laporan_injeksi_av')
  //   ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
  //   ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
  //   ->get();
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.bedah.rm9dot1',
  //     compact('pasien', 'tindakan6')
  //   )->setPaper('a4', 'potrait');


  //   return $pdf->stream();
  //   // return view('print-rekam-medis.rawat-jalan.rm1dot1',compact('pasien'));
  // }
  function printRm2dot9($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    // $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    // $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    // $pemeriksaandokter = PemeriksaanDokter::where('registrasi_uuid', '=', $uuid)->first();

    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $ppj = PencegahanPasienJatuh::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.bedah.rm2dot9',
      compact('pasien', 'ppj',)
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
    $ppj = PencegahanPasienJatuh::where('pasien_uuid', '=', $uuid)->first();
    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'asc')
      ->first();
    $jenistindakan = DB::table('laporan_injeksi_av')
      ->leftJoin('list_form_tindakan_operasi', 'laporan_injeksi_av.uuid', '=', 'list_form_tindakan_operasi.form_laporan_uuid')
      ->where('laporan_injeksi_av.pasien_uuid', '=', $uuid)
      ->get();
    $ppo = PerawatanPeriOperative::where('pasien_uuid', '=', $uuid)->first();
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->first();
    $linen_steril = [
      false,
      false,
      false,
      false,
    ];

    $jsonDatalinen_steril = $ckb != null || $ckb->linen_steril;
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

    if ($ckb != null) {
      $jsonDataalat = $ckb->alat;
    }
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
        'ppj',
        'jenistindakan',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function cppt($uuid)
  {
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $cppt = Cppt::where('pasien_uuid', '=', $uuid)
      ->orderByRaw("
            CASE
            WHEN sebagai = 'PERAWAT' THEN 1
            WHEN sebagai = 'RO' THEN 2
            WHEN sebagai = 'DOKTER' THEN 3
            END
            ")
      ->orderBy('created_at', 'desc')
      ->get();

    $registrasi = Registrasi::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'desc')
      ->get();

    return view('print-rekam-medis.rawat-jalan.cppt', compact('pasien', 'cppt', 'registrasi'));
  }

  function printSuratKonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratKonsul::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.general.suratkonsul',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printFormLaserBarrage($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenFormLaserBarrage::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formlaserbarrage',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printEvaluasiPraAnesthesi($uuid)
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
      'print-rekam-medis.general.evaluasipraanesthesi',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printFormLaserFokal($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenFormLaserFokal::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formlaserfokal',
      compact('pasien',  'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printFormTindakanEpilasi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenTindakanEpilasi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formtindakanepilasi',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }


  public function printLaporanInjeksi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $injeksi = FormLaporanInjeksi::where('uuid', '=', $uuid)->first();

    // Ambil data pasien dari uuid_pasien yang ada di form
    $pasien = Pasien::where('uuid', '=', $injeksi->uuid_pasien)->first();

    // Data tambahan (jika diperlukan)
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $injeksi->uuid_pasien)->latest()->first();
    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $injeksi->uuid_pasien)
      ->orderBy('created_at', 'asc')
      ->first();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $injeksi->uuid_pasien)->first();

    // Load view dengan semua data
    $pdf->loadView(
      'print-rekam-medis.general.laporaninjeksi',
      compact('pasien', 'ro', 'roperasi', 'ptk', 'injeksi')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  function printTindakanLaserLPI($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenTindakanLaserLPI::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.tindakanlaserlpi',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printFormLaserPRP($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenTindakanLaserPRP::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formlaserprp',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printFormLaserCapsulotomy($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenTindakanLaserCapsulotomy::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formlasercapsulotomy',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printSuratBalasanKonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratBalasanKonsul::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratbalasankonsul',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  public function printFormPermintaanPulang($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    // Ambil data form permintaan pulang berdasarkan uuid
    $formPulang = FormPermintaanPulang::where('uuid', '=', $uuid)->first();

    // Cek apakah data ditemukan
    if (!$formPulang) {
      abort(404, 'Data form permintaan pulang tidak ditemukan');
    }

    // Ambil data pasien berdasarkan uuid_pasien dari form
    $pasien = Pasien::where('uuid', '=', $formPulang->uuid_pasien)->first();

    if (!$pasien) {
      abort(404, 'Data pasien tidak ditemukan');
    }

    $pdf->loadView(
      'print-rekam-medis.general.formpermintaanpulang',
      compact('pasien', 'formPulang')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  function printSuratPenolakanRujukan($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratPenolakanRujukan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratpenolakanrujukan',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printSuratPengantarUntukDiRawatInap($uuid)
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
      'print-rekam-medis.general.suratpengantaruntukdirawatinap',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printFormCpptRanap($uuid)
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
      'print-rekam-medis.general.formcpptranap',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    // Ambil data pengkajian keperawatan mata berdasarkan uuid
    $edukasiPasien = FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap::where('uuid', '=', $uuid)->first();

    // Cek apakah data ditemukan
    if (!$edukasiPasien) {
      abort(404, 'Data pengkajian keperawatan mata tidak ditemukan');
    }

    // Ambil data pasien berdasarkan uuid_pasien dari pengkajian
    $pasien = Pasien::where('uuid', '=', $edukasiPasien->uuid_pasien)->first();

    if (!$pasien) {
      abort(404, 'Data pasien tidak ditemukan');
    }

    $pdf->loadView(
      'print-rekam-medis.general.pendidikanedukasipasienkeluargaterintegrasirawatinap',
      compact('pasien', 'edukasiPasien')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  //   function printCatatanKeperawatan ($uuid)
  // {
  //       $pdf = \App::make('dompdf.wrapper');
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
  //   $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
  //     ->orderBy('created_at', 'asc')
  //     ->first();
  //   //dump($ptk);die();
  //   $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.general.catatankeperawatan',
  //     compact('pasien', 'ro', 'roperasi', 'ptk',)
  //   )->setPaper('a4', 'potrait');

  //   return $pdf->stream();
  // }
  function printResumeMedis($uuid)
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
      'print-rekam-medis.general.resumemedis',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printLaporanEksisiChalazion($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenLaporanEksisiChalazion::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.laporaneksisichalazion',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printLaporanOperasiTrabekulektomi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenLaporanOperasiTrabekulektomi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.laporanoperasitrabekulektomi',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printLaporanOperasiPterygium($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenLaporanOperasiPterygium::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.laporanoperasipterygium',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printLaporanEksisiPalbera($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenLaporanEksisiPalpebra::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.laporaneksisipalbera',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printBalanceCairanHarian($uuid)
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
      'print-rekam-medis.general.BalanceCairanHarian',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printKunjunganAwalDietitianPadaPasienBaru($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenDietitianPasienBaru::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.kunjunganawaldietitianpadapasienbaru',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printAsuhanGizi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenAsuhanGizi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.asuhangizi',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printSuratPernyataanPasienUmum($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratPernyataanPasienUmum::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratpernyataanpasienumum',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printSuratKontrolUlang($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratKontrol::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratkontrolulang',
      compact('pasien', 'data')
    )->setPaper('a4', 'landscape');

    return $pdf->stream();
  }
  function printFormulirKonsulDanJawabanKonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = \App\Models\DokumenFormulirKonsulDanJawabanKonsul::where('uuid', $uuid)->firstOrFail();
    $pasien = \App\Models\Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formulirkonsuldanjawabankonsul',
      compact('data', 'pasien')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }
  function printVoucherRawatInap($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');

    $voucher = VoucherRawatInap::where('uuid', $uuid)->firstOrFail();

    $pasien = Pasien::where('uuid', $voucher->uuid_pasien)->first();

    $roperasi = RegistrasiOperasi::where('pasien_uuid', $voucher->uuid_pasien)
      ->latest()
      ->first();

    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', $voucher->uuid_pasien)
      ->orderBy('created_at', 'asc')
      ->first();

    $ro = PemeriksaanRo::where('pasien_uuid', $voucher->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.general.voucherrawatinap',
      compact('pasien', 'ro', 'roperasi', 'ptk', 'voucher')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  function printProsesPerawatanPeriOperatif($uuid)
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
      'print-rekam-medis.general.prosesperawatanperioperatif',
      compact('pasien', 'ro', 'roperasi', 'ptk',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  //   function printMonitoringEfekSampingObat ($uuid)
  // {
  //       $pdf = \App::make('dompdf.wrapper');
  //   $pasien = Pasien::where('uuid', '=', $uuid)->first();
  //   $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
  //   $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
  //     ->orderBy('created_at', 'asc')
  //     ->first();
  //   //dump($ptk);die();
  //   $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
  //   $pdf->loadView(
  //     'print-rekam-medis.general.monitoringefeksampingobat',
  //     compact('pasien', 'ro', 'roperasi', 'ptk',)
  //   )->setPaper('a4', 'potrait');

  //   return $pdf->stream();
  // }

  function printFormReaksiTransfusiDarah($uuid)
  {
      $pdf = \App::make('dompdf.wrapper');
      $formData = FormReaksiTransfusiDarah::where('uuid', '=', $uuid)->first();

      if (!$formData) {
          abort(404, 'Data form tidak ditemukan');
      }

      $pasien = Pasien::where('uuid', '=', $formData->uuid_pasien)->first();
      $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
      $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
        ->orderBy('created_at', 'asc')
        ->first();
      $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();

      // Karena Model sudah decode otomatis, langsung gunakan saja
      $pemberianDarah = $formData->pemberian_darah ?? [];

      // Pastikan selalu array
      if (!is_array($pemberianDarah)) {
          $pemberianDarah = [];
      }

      $pdf->loadView(
        'print-rekam-medis.general.formreaksitransfusidarah',
        compact('pasien', 'ro', 'roperasi', 'ptk', 'formData', 'pemberianDarah')
      )->setPaper('a4', 'portrait');

      return $pdf->stream();
  }

  function printFormulirReaksiTranfusiDarah($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'asc')
      ->first();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();

    // Karena Model sudah decode otomatis, langsung gunakan saja
    $pemberianDarah = $formData->pemberian_darah ?? [];

    // Pastikan selalu array
    if (!is_array($pemberianDarah)) {
      $pemberianDarah = [];
    }

    $pdf->loadView(
      'print-rekam-medis.general.formreaksitransfusidarah',
      compact('pasien', 'ro', 'roperasi', 'ptk', 'formData', 'pemberianDarah')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }
  function printPenolakanTindakanAnestesi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $penolakan = PenolakanTindakanAnestesi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $penolakan->uuid_pasien)->first();
    $roperasi = RegistrasiOperasi::where('pasien_uuid', '=', $uuid)->latest();
    $ptk = PersetujuanTindakanKedokteran::where('pasien_uuid', '=', $uuid)
      ->orderBy('created_at', 'asc')
      ->first();
    //dump($ptk);die();
    $ro = PemeriksaanRo::where('pasien_uuid', '=', $uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.general.penolakantindakananestesi',
      compact('pasien', 'ro', 'roperasi', 'ptk', 'penolakan',)
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function suratpernyataanbataloperasi($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenSuratPernyataanBatalOperasi::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratpernyataanbataloperasi',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printRacikanObat($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
    $racikans = ResepRacikan::where('registrasi_uuid', $uuid)->get();
    $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.obat.printRacikanResepObat',
      compact(
        'pasien',
        'racikans',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printResumeMedisRawatInap($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenResumeMedisRawatInap::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = Pasien::where('uuid', '=', $data->pasien_uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.rawat-inap.formresumerawatinap',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printResumeMedisPerawatanRawatJalan($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenResumePerawatanRawatJalan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = Pasien::where('uuid', '=', $data->pasien_uuid)->first();
    $pdf->loadView(
      'print-rekam-medis.general.resumeperawatanrawatjalan',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printCpptRawatInap($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenCPPTRawatInap::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $pdf->loadView(
      'print-rekam-medis.general.formcpptranap',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printResumeMedisRawatJalan($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenResumeMedisRawatJalan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $pdf->loadView(
      'print-rekam-medis.general.formresumemedisrawatjalan',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

  function printCatatanKeperawatan($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenCatatanKeperawatan::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $pdf->loadView(
      'print-rekam-medis.general.catatankeperawatan',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }
  function printMonitoringEfekSampingObat($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenMonitoringEfekSampingObat::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $pdf->loadView(
      'print-rekam-medis.general.monitoringefeksampingobat',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printKronologis($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenKronologisPasien::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.kronologis',
      compact('pasien', 'data')
    )->setPaper('a4', 'potrait');

    return $pdf->stream();
  }


  function printLaporanOperasiVitreoRetina($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenLaporanOperasiVitreoRetina::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $dokumen = $data;
    $pdf->loadView(
      'print-rekam-medis.general.formlaporanoperasivitreoretina',
      compact(
        'dokumen',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }
  function printAsessmenAwalKeperawatanRawatInap($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $data = DokumenAsesmenKeperawatanRawatInap::where('uuid', '=', $uuid)->first();
    $pasien = Pasien::where('uuid', '=', $data->uuid_pasien)->first();
    $registrasi = '';
    $pdf->loadView(
      'print-rekam-medis.rawat-inap.formassesmen',
      compact(
        'data',
        'pasien',
        'registrasi',
      ),
    )->setPaper('a4', 'potrait');


    return $pdf->stream();
  }

  function printCPPTPoli($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
    $pasien = Pasien::where('uuid', '=', $uuid)->first();
    // $cppt = Cppt::where('pasien_uuid', '=', $uuid)->get();
    $cppt = DB::table('cppt')
      ->leftJoin('pengguna', 'cppt.pengguna_uuid', '=', 'pengguna.uuid')
      ->where('cppt.pasien_uuid', '=', $uuid)
      ->select(
        'cppt.*',
        DB::raw('pengguna.nama as pengguna_nama_pengguna'), // Add all other biodata fields similarly
      )->orderBy('cppt.id', 'desc')
      ->get();

    $pdf->loadView(
      'print-rekam-medis.rawat-jalan.cppt-poli',
      compact(
        'pasien',
        'cppt',
      ),
    )->setPaper('a4', 'potrait',);


    return $pdf->stream();
  }

  public function printProtokolTindakanTerapi($uuid)
  {
    $pdf     = \App::make('dompdf.wrapper');
    $data    = DokumenProtokolTindakanTerapi::where('uuid', $uuid)->first();
    $pasien  = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.protokoltindakanterapi',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printSuratKeteranganHasilPemeriksaanMata($uuid)
  {
    $pdf    = \App::make('dompdf.wrapper');
    $data   = DokumenSuratKeteranganHasilPemeriksaanMata::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratketeranganhasilpemeriksaanmata',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printSuratKeteranganMata($uuid)
  {
    $pdf    = \App::make('dompdf.wrapper');
    $data   = DokumenSuratKeteranganMata::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.suratketeranganmata',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printPersiapanPeralatanAnestesi($uuid)
  {
    $pdf    = \App::make('dompdf.wrapper');
    $data   = DokumenPersiapanPeralatanAnestesi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.persiapanperalatananestesi',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printCpptRawatJalan($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '512M');

    $pdf    = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'    => false,
      'isHtml5ParserEnabled' => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'   => 'a4',
      'dpi'                => 96,
      'chunkSize'          => 512,
    ]);

    $data   = DokumenCPPTRawatJalan::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.formcpptrawatjalan',
      compact('data', 'pasien')
    )->setPaper('a4', 'landscape');

    return $pdf->stream();
  }

  public function printCatatanPerkembanganTerintegrasi($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '512M');

    $pdf    = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'    => false,
      'isHtml5ParserEnabled' => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'   => 'a4',
      'dpi'                => 96,
      'chunkSize'          => 512,
    ]);

    $data   = DokumenCatatanPerkembanganTerintegrasi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.catatanperkembanganterintegrasi',
      compact('data', 'pasien')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printPemberianEdukasiPasienTerintegrasi($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '512M');

    $pdf    = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'         => false,
      'isHtml5ParserEnabled'    => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'        => 'a4',
      'dpi'                     => 96,
      'chunkSize'               => 512,
    ]);

    $data   = DokumenPemberianEdukasiPasienTerintegrasi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.pemberianedukasipasienterintegrasi',
      compact('data', 'pasien')
    )->setPaper('a4', 'landscape');

    return $pdf->stream();
  }

  public function printChecklistKeselamatanPasienOperasi($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '256M');

    $pdf = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'         => false,
      'isHtml5ParserEnabled'    => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'        => 'a4',
      'dpi'                     => 96,
    ]);

    $raw    = DokumenChecklistKeselamatanPasienOperasi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $raw->uuid_pasien)->first();

    // Map ke field yang dipakai blade rm4dot9
    $kb = (object) [
      'si_jam'       => $raw->signin_waktu,
      'si_bagian_1'  => $raw->signin_q1,
      'si_bagian_2'  => $raw->signin_q2,
      'si_bagian_3'  => $raw->signin_q3,
      'si_bagian_4'  => $raw->signin_q4,
      'si_bagian_5'  => $raw->signin_q5,
      'si_bagian_6'  => $raw->signin_q6,
      'si_bagian_7'  => $raw->signin_q7,
      'si_nama'      => $raw->signin_nama_perawat,

      'to_jam'        => $raw->timeout_waktu,
      'to_bagian_1'   => $raw->timeout_q1,
      'to_bagian_2'   => $raw->timeout_q1,
      'to_bagian_2_1' => $raw->timeout_q2,
      'to_bagian_2_2' => $raw->timeout_q3,
      'to_bagian_2_3' => $raw->timeout_q4_tindakan_beresiko,
      'to_bagian_3'   => $raw->timeout_q4_lama_tindakan,
      'to_bagian_4_1' => $raw->timeout_q4_antisipasi_perdarahan,
      'to_bagian_4_2' => $raw->timeout_q5,
      'to_bagian_5'   => $raw->timeout_q6_kesterilan,
      'to_bagian_6'   => $raw->timeout_q6_implan,
      'so_asisten_1'  => $raw->timeout_q6_masalah_alat,
      'so_penata'     => $raw->timeout_q6_radiologi,
      'to_nama'       => $raw->timeout_nama_perawat_sirkuler,

      'so_jam'       => $raw->signout_waktu,
      'so_bagian_1'  => $raw->signout_q1,
      'so_bagian_2'  => $raw->signout_q2,
      'so_bagian_3'  => $raw->signout_q3,
      'so_bagian_4'  => $raw->signout_q4,
      'so_bagian_5'  => $raw->signout_q5,

      'nama_operator'      => $raw->signout_nama_dr_bedah,
      'nama_ahli_anastesi' => $raw->signout_nama_dr_anestesi,
      'asisten_operasi'    => $raw->signout_nama_perawat_anestesi,
      'scrub_nurses'       => $raw->signout_nama_perawat_instrument,
      'created_at'         => $raw->created_at,
    ];
    $data = $raw;

    $pdf->loadView(
      'print-rekam-medis.bedah.rm4dot9',
      compact('pasien', 'kb','data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printInformasiTindakanAnastesi($uuid)
  {
    $pdf    = \App::make('dompdf.wrapper');
    $data   = DokumenInformasiTindakanAnastesi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.informasitindakananastesi',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printEvaluasiPraAnestesiLampiran($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '256M');

    $pdf = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'         => false,
      'isHtml5ParserEnabled'    => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'        => 'a4',
      'dpi'                     => 96,
    ]);

    $epa    = DokumenEvaluasiPraAnestesi::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $epa->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.general.evaluasipraanesthesi',
      compact('pasien', 'epa')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printPengkajianAwalMedisMata($uuid)
  {
    set_time_limit(0);
    ini_set('memory_limit', '256M');

    $pdf = \App::make('dompdf.wrapper');
    $pdf->setOptions([
      'isRemoteEnabled'         => false,
      'isHtml5ParserEnabled'    => true,
      'isFontSubsettingEnabled' => true,
      'defaultPaperSize'        => 'a4',
      'dpi'                     => 96,
    ]);

    $pamm   = DokumenPengkajianAwalMedisMata::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $pamm->uuid_pasien)->first();

    $pdf->loadView(
      'print-rekam-medis.general.pengkajianawalmedisMata',
      compact('pasien', 'pamm')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }

  public function printPenilaianRisikoJatuhPasienGeriatri($uuid)
  {
    $pdf    = \App::make('dompdf.wrapper');
    $data   = DokumenPenilaianRisikoJatuhPasienGeriatri::where('uuid', $uuid)->first();
    $pasien = Pasien::where('uuid', $data->uuid_pasien)->first();
    $pdf->loadView(
      'print-rekam-medis.general.penilaianrisikoJatuhPasienGeriatri',
      compact('pasien', 'data')
    )->setPaper('a4', 'portrait');

    return $pdf->stream();
  }
}
