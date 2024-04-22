<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\SuratIstirahat;
use App\Models\SuratKonsul;
use App\Models\SuratBalasanKonsul;
use App\Models\ResepKacamata;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\Bedah;
use App\Models\RegistrasiOperasi;
use App\Models\AntrianPoli;
use App\Models\Pasien;
use App\Models\CaraBayarKamar;
use App\Jobs\SendPoliJob;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class CetakanCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status_dokter', '=', 'Sudah Diperiksa');

			$data= $data->where('status', 'Kunjungan')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', 'Kunjungan')
								->where('status_dokter', '=', 'Sudah Diperiksa');
								
			$total = $total->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('status_dokter', 'asc')
									->orderBy('posisi_antrian_dokter', 'asc')
									->where('status', 'Kunjungan')
									->where('status_dokter', '=', 'Sudah Diperiksa');

			$data = $data->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1);
								
			$total = $total->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', 'Kunjungan')
								->where('status_dokter', '=', 'Sudah Diperiksa')
								->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function printsuratistirahat($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$surat = SuratIstirahat::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
    
    $pdf->loadView('print.printketerangansakit', compact('registrasi', 'surat'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
  }

	public function printsuratkonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = SuratKonsul::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
		$keluhan_utama = '';
		if ($ro) { $keluhan_utama = $ro->keluhan_utama; }
    
    $pdf->loadView('print.printkonsul', compact('registrasi', 'biodata', 'surat', 'keluhan_utama'))->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

	public function printsuratbalasankonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = SuratBalasanKonsul::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
		$keluhan_utama = '';
		if ($ro) { $keluhan_utama = $ro->keluhan_utama; }
    
    $pdf->loadView('print.printbalasankonsul', compact('registrasi', 'biodata', 'surat', 'keluhan_utama'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
  }

	public function printresepkacamata($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = ResepKacamata::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    
    $pdf->loadView('print.printresepkacamata', compact('registrasi', 'biodata', 'surat', 'ro'))->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

}