<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\TindakanPasien;
use App\Exports\TindakanPasienV2;
use App\Exports\RegistrasiPasien;
use App\Models\LogPengguna;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;

class LaporanKeuanganCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function tindakan($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid, $layanan_uuid, $jenis_registrasi)
	{
		set_time_limit(3000);
		$filename = date('Y-m-d') . '-Tindakan ke Pasien.xlsx';
		return \Excel::download(new TindakanPasien($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid, $layanan_uuid), $filename);
	}

	public function tindakanv2($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid, $layanan_uuid, $jenis_registrasi)
	{
		set_time_limit(3000);
		$filename = date('Y-m-d') . '-Tindakan ke Pasien v2.xlsx';
		return \Excel::download(new TindakanPasienV2($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid, $layanan_uuid, $jenis_registrasi), $filename);

		// $export = new TindakanPasienV2(
		// 	$dari,
		// 	$ke,
		// 	$carabayar_uuid,
		// 	$asuransi_uuid,
		// 	$dokter_uuid,
		// 	$layanan_uuid,
		// 	$jenis_registrasi
		// );

		// // ⬇️ PANGGIL view() LANGSUNG
		// return $export->view();
	}

	public function registrasi($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid)
	{
		$filename = date('Y-m-d') . '- Registrasi Pasien.xlsx';
		return \Excel::download(new RegistrasiPasien($dari, $ke, $carabayar_uuid, $asuransi_uuid, $dokter_uuid), $filename);
	}
}
