<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\Registrasi;
use App\Models\StockOpname;
use App\Models\AntrianKasir;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class KwitansiClaimCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}
	

	public function get(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
		// if ($data) {
		// 	PenggunaHelp::log('Menerima tagihan atas nama pasien '.$data->nama_pasien.' pada tanggal '.date('Y-m-d'));
		// }

		return response()->json(['data' => $data]);

	}

	public function add(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		// }

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();
		$grandtotaltop = 0;
		$hasil = 0;
		if ($request->diskon != 0 && $request->diskon != '0') {
			// foreach ($layanan as $row) {
			// 	$grandtotaltop += $row->total;
			// }

			if ($data->cover_asuransi != 0) {
				$grandtotaltop = $data->cover_asuransi;
				$hasil = (int) ($grandtotaltop - (int) ($grandtotaltop * ($request->diskon/100)));
			}
		}
		
		if ($data->kwitansi_claim != '-') {
			$arr = array('kwitansi_claim' => $request->kwitansi_claim, 'diskon_claim' => $request->diskon, 'total_claim' => $hasil);
			$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
		}
		else {
			$arr = array(
				'kwitansi_claim' => $request->kwitansi_claim, 
				'diskon_claim' => $request->diskon, 
				'total_claim' => $hasil,
				'tanggal_claim' => date('Y-m-d'), 
				'jam_claim' => date('H:i')
			);
			$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
		}
		
		return response()->json(['data' => 'berhasil']);
	}

	public function diterima(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

		$arr = array(
			'status_claim' => 'Sudah Diterima', 
			'tanggal_diterima_claim' => date('Y-m-d'), 
			'jam_diterima_claim' => date('H:i')
		);
		$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

		return response()->json(['data' => 'berhasil']);
	}

}