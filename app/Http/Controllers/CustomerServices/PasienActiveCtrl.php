<?php

namespace App\Http\Controllers\CustomerServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;
use DateTime;

use App\Models\Pasien;
use App\Models\UploadSuratPersetujuan;
use App\Models\Registrasi;
use App\Models\SuratPersetujuan;
use PDF;


class PasienActiveCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('nomor', 'desc')
								->where(function($q){
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								->whereDate('tanggal', '=', date('Y-m-d'))
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('status', 'Kunjungan')
										->orWhere('status', 'Selesai');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('nomor', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('nomor', 'desc')
									->where(function($q){
										$q->where('status', 'Kunjungan')
											->orWhere('status', 'Selesai');
									})
									->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Kunjungan')
								->orWhere('status', 'Selesai');
						})
						->orderBy('nomor', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function listbelum(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('nomor', 'asc')
								->where(function($q){
									$q->where('status', 'Kunjungan');
								})
								->whereDate('tanggal', '=', date('Y-m-d'))
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('status', 'Kunjungan');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('nomor', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('nomor', 'asc')
									->where(function($q){
										$q->where('status', 'Kunjungan');
									})
									->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Kunjungan');
						})
						->orderBy('nomor', 'asc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function listsudah(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('nomor', 'asc')
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->whereDate('tanggal', '=', date('Y-m-d'))
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('nomor', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('nomor', 'asc')
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->whereDate('tanggal', '=', date('Y-m-d'))
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Selesai');
						})
						->orderBy('nomor', 'asc')->count();

		}
		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function informasi(Request $request) {
		$all = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Selesai');
						})
						->orderBy('nomor', 'asc')->count();

		$belum = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Kunjungan');
						})
						->orderBy('nomor', 'asc')->count();
		$sudah = Registrasi::where('delete_soft', '=', 1)
						->whereDate('tanggal', '=', date('Y-m-d'))
						->where(function($q){
							$q->where('status', 'Selesai');
						})
						->orderBy('nomor', 'asc')->count();

		return response()->json(['all' => $all, 'belum' => $belum, 'sudah' => $sudah]);
	}

	

}