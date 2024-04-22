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

class HistoriKasirRawatInapCtrl extends Controller
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
								// ->whereDate('tanggal_bayar', '!=', date('Y-m-d'))
								->where(function($q){
									$q->where('jenis', '=', 'Rawat Inap');
								})
								->orderBy('no_kwitansi', 'asc')
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								// ->whereDate('tanggal_bayar', '!=', date('Y-m-d'))
								->where(function($q){
									$q->where('jenis', '=', 'Rawat Inap');
								})
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_kwitansi', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									// ->whereDate('tanggal_bayar', '!=', date('Y-m-d'))
									->where(function($q){
										$q->where('jenis', '=', 'Rawat Inap');
									})
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								// ->whereDate('tanggal_bayar', '!=', date('Y-m-d'))
								->where(function($q){
									$q->where('jenis', '=', 'Rawat Inap');
								})
								// ->where(function($q){
								// 	$q->where('status', 'Selesai');
								// })
								->orderBy('no_kwitansi', 'asc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}
	

	public function bayar(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menerima tagihan atas nama pasien '.$data->nama_pasien.' pada tanggal '.date('Y-m-d'));
		}

		$arr = array(
			'status_antrian_kasir' => '-', 
			'kasir_jam_selesai' => date('H:i'),
			'status_kasir' => 'Sudah Bayar',
			'status' => 'Selesai',
			'tanggal_bayar' => date('Y-m-d'),
			'metode_pembayaran' => $request->metode_pembayaran && $request->metode_pembayaran != '' ? $request->metode_pembayaran : '-'
		);
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$tindakan = json_decode($request->tindakan);

		foreach ($tindakan as $row) {
			$item = LayananPasien::find($row->id);
			$item->layanan_uuid = $row->layanan_uuid;
			$item->nama_layanan = $row->nama_layanan;
			$item->tarif = $row->tarif;
			$item->diskon_rp = $row->diskon_rp;
			$item->diskon_persen = $row->diskon_persen;
			$item->total = $row->total;
			$item->save();
		}
		$arr = array('posisi' => 'Bayar');
		$update = LayananPasien::where('registrasi_uuid', '=', $request->uuid)->update($arr);

		$arr = array('status' => 'Aktif');
		$update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

		// Pengurangan qty obat
		$data = Resep::where('registrasi_uuid', '=', $request->uuid)->get();
		$obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->get();

		foreach($data as $row) {
			$cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $row->obat_uuid)->first();
			if ($cek) {
				$hasil = $cek->jumlah_kecil - $row->jumlah_kecil;
				$arr = array('jumlah_kecil' => $hasil);
				$update = StockOpname::where('id', '=', $cek->id)->update($arr);
			}
		}

		foreach($obatracikan as $row) {
			$informasi = json_decode($row->informasi);
			foreach($informasi as $rowin) {
				$cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $row->obat_uuid)->first();
				if ($cek) {
					$hasil = $cek->jumlah_kecil - $rowin->jumlah_kecil;
					$arr = array('jumlah_kecil' => $hasil);
					$update = StockOpname::where('id', '=', $cek->id)->update($arr);
				}
			}
		}

		return response()->json(['data' => 'berhasil']);

	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obat = Resep::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();
		
		return response()->json(['data' => $data, 'obatracikan' => $obatracikan, 'layanan' => $layanan, 'obat' => $obat ]);
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('status_antrian_kasir' => '-', 'last_position' => 'Kasir');
		$cek = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);

		$arr = array('status_antrian_kasir' => 'active', 'kasir_jam_layani' => date('H:i'));
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) { 
			$str = 'Kasir 1'.'='.$request->number;
			$this->jeda(1, $str);
			return response()->json(['data' => 'berhasil']); 
		}

		$get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']); }
		}

		$get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = AntrianKasir::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => '1');
		$panggil = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

		$str = 'Kasir 1'.'='.$request->number;
		$this->jeda(1, $str);
		
		return response()->json(['data' => 'berhasil']);
	}

	private function jeda($delay, $str) {
		$on = Carbon::now()->addSeconds($delay);
		dispatch(new SendAllJob($str))->delay($on);
	}

	public function terima(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$arr = array('approve_panjar' => '1');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		
		return response()->json(['data' => 'berhasil']);
	}


	public function panjar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->where('panjar', '!=', '0')
								->where('status', '=', 'Pending')
								->where(function($q){
									$q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
									->orWhere('status_dokter', '=', 'Sudah Diperiksa');
								})
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', '=', 'Pending')
								->where('panjar', '!=', '0')
								->where(function($q){
									$q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
									->orWhere('status_dokter', '=', 'Sudah Diperiksa');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where('status', '=', 'Pending')
									->where('panjar', '!=', '0')
									->where(function($q){
										$q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
										->orWhere('status_dokter', '=', 'Sudah Diperiksa');
									})
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', '=', 'Pending')
								->where('panjar', '!=', '0')
								->where(function($q){
									$q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
									->orWhere('status_dokter', '=', 'Sudah Diperiksa');
								})
								->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}
}