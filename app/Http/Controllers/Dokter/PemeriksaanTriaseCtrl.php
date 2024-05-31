<?php

namespace App\Http\Controllers\Dokter;

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
use App\Models\Resep;
use App\Models\AntrianPoli;

class PemeriksaanTriaseCtrl extends Controller
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
								->where('berkebutuhan_khusus', '=', 'Ya, Benar');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data = $data->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')
								->where(function($q) {
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q) {
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs kesehatan')
								->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS Sehat')
								->where('carabayar_nama', '!=', 'BPJS-Sehat')
								->where('carabayar_nama', '!=', 'BPJS_Sehat')
								->where('carabayar_nama', '!=', 'BPJS SEHAT')
								->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								->where('carabayar_nama', '!=', 'bpjs sehat')
								->where('carabayar_nama', '!=', 'bpjs-sehat')
								->where('carabayar_nama', '!=', 'bpjs_sehat')
								->where('berkebutuhan_khusus', '=', 'Ya, Benar');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$total = $total->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'asc')
									->orderBy('status_dokter', 'asc')
									->where(function($q) {
										$q->where('status', 'Kunjungan')
											->orWhere('status', 'Selesai');
									})
								// 	->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
									->where('berkebutuhan_khusus', '=', 'Ya, Benar');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data = $data->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('berkebutuhan_khusus', '=', 'Ya, Benar')
								->whereDate('tanggal', '=', date('Y-m-d'));
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$total = $total->where(function($q) {
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')
								->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

}