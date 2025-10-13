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
use App\Models\KamarInap;
use App\Models\RunningText;

class RoomCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
	}

	public function status() {
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('room', compact('text'));
	}

	public function load(Request $request) {
		date_default_timezone_set("Asia/Jakarta");
		$number = 1;
		$data = DB::table('kamar_inap as ki')
			->leftJoin('registrasi as r', function ($join) {
				$join->on('ki.uuid', '=', 'r.kamar_inap_uuid')
					->where('r.status', '=', 'Rawat Inap');
			})
			->select(
				'ki.nama_jenis_kamar',
				DB::raw('SUM(ki.jumlah_bed) AS jumlah'),
				DB::raw('COUNT(r.id) AS dipakai'),
				DB::raw('(SUM(ki.jumlah_bed) - COUNT(r.id)) AS sisa')
			)
			->groupBy('ki.nama_jenis_kamar')
			->get();

		return response()->json(['data' => $data]);
	}

}