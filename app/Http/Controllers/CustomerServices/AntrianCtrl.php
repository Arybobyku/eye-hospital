<?php

namespace App\Http\Controllers\CustomerServices;

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
use App\Models\Registrasi;
use App\Models\DisplayAntrian;
use App\Models\LogPengguna;
use App\Jobs\SendCsJob;
use Carbon\Carbon;

class AntrianCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
	}

	public function list(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$data = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('status', '!=', 'selesai')->orderBy('id', 'asc')->limit(15)->get();

		$total = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'asc')->count();

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')))
								->first();

		if ($get) { 
			$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')).'='.$request->number;
			$this->jeda(1, $str);
			return response()->json(['data' => 'berhasil']); 
		}

		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']);  }
		}

		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')))
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = Antrian::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')));
		$panggil = Antrian::where('uuid', '=', $request->antrian_uuid)->update($arr);

		$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai')).'='.$request->number;
		$this->jeda(1, $str);
		
		return response()->json(['data' => 'berhasil']);
	}

	private function jeda($delay, $str) {
		$on = Carbon::now()->addSeconds($delay);
		dispatch(new SendCsJob($str))->delay($on);
	}

	// private function converters($data) {
	// 	if ($data < 10) { return '0'.$data; }
	// 	return $data;
	// }

	// private function bunyibell($str) {
	// 	$waktu = date('H:i:s');
	// 	$queue = DB::table('delay_antrian')->where('jenis', '=', 'cs')->orderBy('id', 'desc')->first();
	// 	if($queue) {

	// 		$deadtime = strtotime($queue->detik);
			
	// 		$sisa = time() - $deadtime;
	// 		if ($sisa > 0) {
	// 			if ($sisa >= 13) {
	// 				if ($this->savedelay($waktu, 2, 'saya')) { $this->jeda(1, $str); }
	// 			}
	// 			else {
	// 				if ($this->savedelay($waktu, 12, 'kami')) { $this->jeda(12, $str); }
	// 			}
	// 		}
	// 		else {
	// 			if ($this->savedelay($waktu, 2, 'kamu')) { $this->jeda(1, $str); }
	// 		}
	// 	}
	// 	else {
	// 		if ($this->savedelay($waktu, 1, 'dia')) { $this->jeda(1, $str); }
	// 	}
	// }

	// private function savedelay($waktu, $sisa, $label) {
	// 	$values = array('uuid' => Uuid::uuid4().'-'.$label, 'sisa' => $sisa, 'detik' => $waktu,'jenis' => 'cs');
	// 	$save = DB::table('delay_antrian')->insert($values);
	// 	if ($save) { return true; }
	// 	return false;
	// }

	public function finish(Request $request) {

		$arr = array('status' => 'selesai');

		$antrian = Antrian::where('uuid', '=', $request->antrian_uuid)->update($arr);
		
		return response()->json(['data' => 'berhasil']);
	}

	public function lihat(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		$data = Registrasi::where('delete_soft', '=', 1)
			->where('nama_dokter', '=', $search)
			->whereDate('tanggal', '=', date('Y-m-d'))
			->where('posisi_antrian_dokter', '!=', 0)
			->orderBy('id', 'desc')
			->skip($skip)->take($this->take)
			->get();
		$total = Registrasi::where('delete_soft', '=', 1)
			->where('nama_dokter', '=', $search)
			->whereDate('tanggal', '=', date('Y-m-d'))
			->where('posisi_antrian_dokter', '!=', 0)
			->orderBy('id', 'desc')->count();
		
		return response()->json(['data' => $data, 'total' => $total]);
	}

}