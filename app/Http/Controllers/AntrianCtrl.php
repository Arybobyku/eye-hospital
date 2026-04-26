<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use Storage;
use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Antrian;
use App\Models\AntrianPoli;
use App\Models\PasienBebas;
use App\Models\AntrianRo;
use App\Models\AntrianKasir;
use App\Models\AntrianFarmasi;
use App\Models\DisplayAntrian;
use App\Models\LogPengguna;
use App\Models\RunningText;

class AntrianCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
	}

	public function ambil() {
		return view('ambil-antrian-gabungan');
	}

	public function load(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$number = 1;
		$numberbebas = 1;
		$bebas = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
		$antrian = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
		if ($antrian) { $number += $antrian->number; }
		if ($bebas) { $numberbebas += $bebas->number; }
		return response()->json(['number' => $number, 'numberbebas' => $numberbebas]);
	}

	public function data(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat halaman data profile');

		$biodata = DB::table('biodata')->orderBy('id','asc')->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))->first();
		$logpengguna = DB::table('log_pengguna')->orderBy('id','asc')
										->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
										->limit(15)
										->get();
		
		return response()->json([
			'biodata' => $biodata,
			'logpengguna' => $logpengguna,
		]);
	}

	public function slider(Request $request) {


		$slider = DB::table('running_image')->orderBy('id','asc')->get();
		
		return response()->json(['slider' => $slider]);
	}

	public function add(Request $request) {

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Antrian::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		$item = new Antrian();
		$item->uuid = $uuid;
		$item->kode = 'A';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		$item = new AntrianPoli();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'A';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		$item = new AntrianRo();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'A';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		$item = new AntrianKasir();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'A';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		$item = new AntrianFarmasi();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'A';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		$pdf = \App::make('dompdf.wrapper');
    $jenis = $request->jenis;
    $number = $request->number;
		$kode = 'A';

    $customPaper = array(0,0,649,1063);
    $pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0,0,220, 220),'potrait');
    $content = $pdf->download()->getOriginalContent();
    Storage::put('public/antrian/number.pdf', $content);
		
		return response()->json(['data' => 'berhasil']);
	}

	public function cs(Request $request) {
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-cs', compact('text'));
	}

	public function poli(Request $request) {
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-poli', compact('text'));
	}

	public function all(Request $request) {
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-all', compact('text'));
	}

	public function displaycs(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('pemanggil', '!=', '-')->get();
		return response()->json(['hasil' => $get]);
	}

	public function displaypoli(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('pemanggil', '!=', '-')
								->where(function($q){
									$q->where('pemanggil', '=', '1')
									->orWhere('pemanggil', '=', '2')
									->orWhere('pemanggil', '=', '3');
								})->get();
		$ro = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
						->where('pemanggil', '!=', '-')
						->get();
		return response()->json(['hasil' => $get, 'ro' => $ro]);
	}

	public function displayall(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('pemanggil', '!=', '-')
								->where(function($q){
									$q->where('pemanggil', '=', '3')
									->orWhere('pemanggil', '=', '4');
								})->get();
		$kasir = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
						->where('pemanggil', '!=', '-')
						->get();
		$farmasi = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
						->where('pemanggil', '!=', '-')
						->get();
		return response()->json(['hasil' => $get, 'kasir' => $kasir, 'farmasi' => $farmasi]);
	}

}