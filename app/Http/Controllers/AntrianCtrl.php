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
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;
use App\Models\AntrolLogs;

class AntrianCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
	}

	public function ambil()
	{
		return view('ambil-antrian-gabungan');
	}

	public function load(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$number = 1;
		$numberbebas = 1;
		$bebas = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'F')->orderBy('id', 'desc')->first();
		$antrian = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'CS')->orderBy('id', 'desc')->first();
		if ($antrian) {
			$number += $antrian->number;
		}
		if ($bebas) {
			$numberbebas += $bebas->number;
		}
		return response()->json(['number' => $number, 'numberbebas' => $numberbebas]);
	}

	public function data(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat halaman data profile');

		$biodata = DB::table('biodata')->orderBy('id', 'asc')->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid')))->first();
		$logpengguna = DB::table('log_pengguna')->orderBy('id', 'asc')
			->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid')))
			->limit(15)
			->get();

		return response()->json([
			'biodata' => $biodata,
			'logpengguna' => $logpengguna,
		]);
	}

	public function slider(Request $request)
	{


		$slider = DB::table('running_image')->orderBy('id', 'asc')->get();

		return response()->json(['slider' => $slider]);
	}

	public function ambilRO(Request $request)
	{

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = AntrianRo::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		$item = new AntrianRo();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'RO';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		// $pdf = \App::make('dompdf.wrapper');
		// $jenis = $request->jenis;
		// $number = $request->number;
		// $kode = 'RO';

		// $customPaper = array(0, 0, 649, 1063);
		// $pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		// $content = $pdf->download()->getOriginalContent();
		// Storage::put('public/antrian-ro/number.pdf', $content);

		return response()->json(['data' => 'berhasil']);
	}

	public function add(Request $request)
	{

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = Antrian::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		$item = new Antrian();
		$item->uuid = $uuid;
		$item->kode = 'CS';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		// $item = new AntrianPoli();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianRo();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianKasir();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianFarmasi();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $request->number;
		$kode = 'CS';

		$customPaper = array(0, 0, 649, 1063);
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		$content = $pdf->download()->getOriginalContent();
		Storage::put('public/antrian/number.pdf', $content);

		return response()->json(['data' => 'berhasil']);
	}

	public function addbebas(Request $request)
	{

		DB::beginTransaction();
		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = AntrianFarmasi::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		$item = new AntrianFarmasi();
		$item->uuid = $uuid;
		$item->kode = 'F';
		$item->is_bpjs = $request->is_bpjs;
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');

		$nomor = 1;
		$tanggal = date('Ymd');

		// Ambil antrean terakhir untuk hari ini berdasarkan kode
		$lastEntry = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'F')
			->orderBy('id', 'desc')
			->first();

		if ($lastEntry && strlen($lastEntry->nomor) >= 13) {
			// Ambil 5 digit terakhir sebagai nomor antrean
			$lastNumber = (int) substr($lastEntry->nomor, -5);
			$nomor = $lastNumber + 1;
		}

		// Format nomor menjadi 5 digit (00001, 00002, ...)
		$nomor = str_pad($nomor, 5, '0', STR_PAD_LEFT);
		$nomorFormatted = $tanggal . $nomor;

		$item->nomor = $nomorFormatted;

		$item->save();

		do {
			$uuidPasienBebas = Uuid::uuid4();
			$check = PasienBebas::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		// Generate Invoice
		$no_invoice = '';
		$invoice = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
			->where('no_invoice', '!=', '-')
			->orderBy('no_invoice', 'desc')->first();
		$nomor_i = 1;
		if ($invoice) {
			$potong_kalimat = substr($invoice->no_invoice, -5);
			$potong_kalimat = (int) $potong_kalimat;
			$nomor_i += $potong_kalimat;
		}
		if ($nomor_i < 10) {
			$nomor_i = '0000' . $nomor_i;
		} else if ($nomor_i > 9 && $nomor_i < 100) {
			$nomor_i = '000' . $nomor_i;
		} else if ($nomor_i > 99 && $nomor_i < 1000) {
			$nomor_i = '00' . $nomor_i;
		} else if ($nomor_i > 999 && $nomor_i < 10000) {
			$nomor_i = '0' . $nomor_i;
		}
		$no_invoice = date('Ymd') . $nomor_i;

		// CREATE PASIEN BEBAS
		$pasienBebas = new PasienBebas();
		$pasienBebas->uuid = $uuidPasienBebas;
		$pasienBebas->kode = 'F';
		$pasienBebas->number = $request->number;
		$pasienBebas->nomor = $nomorFormatted;
		$pasienBebas->jenis = $request->jenis;
		$pasienBebas->no_invoice = $no_invoice;
		$pasienBebas->is_bpjs = $request->is_bpjs;
		$pasienBebas->tanggal = date('Y-m-d');
		$pasienBebas->no_antrian = $item->kode . '-' . str_pad($request->number, 3, '0', STR_PAD_LEFT);
		$pasienBebas->save();


		// Handling BPJS atau tidak
		$response = '';
		// if($request->is_bpjs == '1'){

		// }

		// **Panggil tambahAntreanFarmasi dengan cara yang benar**
		$response = app(AntrolBpjsCtrl::class)->tambahAntreanFarmasi($item);

		// **Proses PDF**
		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $request->number;
		$kode = 'F';
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))
			->setPaper([0, 0, 220, 220], 'potrait');
		$content = $pdf->download()->getOriginalContent();
		Storage::put('public/antrian/number.pdf', $content);

		// **Return response dari BPJS**
		DB::commit();
		// return response()->json(['data' => 'berhasil']);
		return response()->json([
			'status' => 'success',
			'bpjs_response' => $response // Kirim response dari BPJS ke frontend buat testing
		]);
	}


	public function cetakAntrianAll($noAntrian, $jenis)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadView('cetak-antrian-all', compact('noAntrian', 'jenis'))->setPaper(array(0, 0, 220, 220), 'potrait');
		return $pdf->stream();
	}

	public function cs(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-cs', compact('text'));
	}

	public function poli(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-poli', compact('text'));
	}

	public function all(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-all', compact('text'));
	}

	public function displaycs(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('pemanggil', '!=', '-')->get();
		return response()->json(['hasil' => $get]);
	}

	public function displaypoli(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->where(function ($q) {
				$q->where('pemanggil', '=', '1')
					->orWhere('pemanggil', '=', '2')
					->orWhere('pemanggil', '=', '3');
			})->get();
		$ro = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->get();
		return response()->json(['hasil' => $get, 'ro' => $ro]);
	}

	public function displayall(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->where(function ($q) {
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
