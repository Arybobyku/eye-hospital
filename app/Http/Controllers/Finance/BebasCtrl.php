<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\ResepBebas;
use App\Models\StockOpname;
use App\Models\LayananPasien;
use App\Models\ResepRacikanBebas;
use App\Models\PasienBebas;
use App\Jobs\SendAllJob;
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;
use Carbon\Carbon;

class BebasCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = PasienBebas::where('delete_soft', '=', 1)
								->where('pembayaran', '=', 'Belum Bayar')
								->where('status', '!=', 'batal')
								->where('ada_obat', '=', 'Ya')
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('id', 'asc')
								->orderBy('number', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->where('pembayaran', '=', 'Belum Bayar')
								->where('status', '!=', 'batal')
								->where('ada_obat', '=', 'Ya')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('number', 'asc')
								->orderBy('id', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->where('pembayaran', '=', 'Belum Bayar')
									->where('status', '!=', 'batal')
									->where('ada_obat', '=', 'Ya')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->where('pembayaran', '=', 'Belum Bayar')
									->where('status', '!=', 'batal')
									->where('ada_obat', '=', 'Ya')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function listbayar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = PasienBebas::where('delete_soft', '=', 1)
								->where('pembayaran', '=', 'Sudah Bayar')
								->where('status', '!=', 'batal')
								->where('ada_obat', '=', 'Ya')
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('id', 'asc')
								->orderBy('number', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->where('pembayaran', '=', 'Sudah Bayar')
								->where('status', '!=', 'batal')
								->where('ada_obat', '=', 'Ya')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('number', 'asc')
								->orderBy('id', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->where('pembayaran', '=', 'Sudah Bayar')
									->where('status', '!=', 'batal')
									->where('ada_obat', '=', 'Ya')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->where('pembayaran', '=', 'Sudah Bayar')
									->where('status', '!=', 'batal')
									->where('ada_obat', '=', 'Ya')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$cek = PasienBebas::where('uuid', '=', $request->uuid)->first();

		$arr = array('active_call_kasir' => '-');
		$update = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);

		$arr = array('active_call_kasir' => 'active');
		$update = PasienBebas::where('uuid', '=', $request->uuid)->update($arr);

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil_kasir', '=', '1')
								->first();

		if ($get) { 
			$str = 'Kasir 1'.'='.$request->number.'=bebask';
			$this->jeda(1, $str);
			return response()->json(['data' => 'success']); 
		}

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil_kasir != '-') { return response()->json(['data' => 'cannot']); }
		}

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil_kasir', '=', '1')
								->first();

		if ($get) {
				$arr = array('pemanggil_kasir' => '-');
				$update = PasienBebas::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil_kasir' => '1');
		$panggil = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

		$str = 'Kasir 1'.'='.$request->number.'=bebask';
		$this->jeda(1, $str);
		
		return response()->json(['data' => 'success']);
	}

	private function jeda($delay, $str) {
		$on = Carbon::now()->addSeconds($delay);
		dispatch(new SendAllJob($str))->delay($on);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			// $invoice = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->where('no_invoice', '!=', '-')->orderBy('no_invoice', 'desc')->first();
			// $no_invoice = date('ymd').'00001';
			// $nomor_i = 1;
			// if ($invoice) {
			// 	$potong_kalimat = substr($invoice->no_invoice,-5);
			// 	$potong_kalimat = (int) $potong_kalimat;
			// 	$nomor_i += $potong_kalimat;
			// }
			// if ($nomor_i < 10) { $nomor_i = '0000'.$nomor_i; }
			// else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
			// else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
			// else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
			// $no_invoice = date('Ymd').$nomor_i;

			$arr = array('pembayaran' => 'Sudah Bayar', 'tanggal_bayar' => date('Y-m-d'), 'metode_pembayaran' => $request->metode_pembayaran);
			$update = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->update($arr);
			$item = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();


			// Pengurangan qty obat
			$data = ResepBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->get();
			$obatracikan = ResepRacikanBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->get();

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
					$cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $rowin->obat_uuid)->first();
					if ($cek) {
						$hasil = $cek->jumlah_kecil - $rowin->jumlah_kecil;
						$arr = array('jumlah_kecil' => $hasil);
						$update = StockOpname::where('id', '=', $cek->id)->update($arr);
					}
				}
			}

			$cek = LayananPasien::where('pasien_uuid', '=', $request->pasienbebas_uuid)->first();
			if ($cek) {
				$arr = array('posisi' => 'Bayar');
				$update = LayananPasien::where('pasien_uuid', '=', $request->pasienbebas_uuid)->update($arr);
			}
			$response = '';
			if ($item->is_bpjs == 1){
				$response = app(AntrolBpjsCtrl::class)->updateWaktuAntreanFarmasi($item);
			}
			DB::commit();

			// return response()->json(['data' => 'berhasil']);
					return response()->json([
		    'status' => 'success',
		    'bpjs_response' => $response // Kirim response dari BPJS ke frontend buat testing
		]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$detail = PasienBebas::where('uuid', '=', $request->uuid)->first();
		$data = ResepBebas::where('pasienbebas_uuid', '=', $request->uuid)->get();
		$obatracikan = ResepRacikanBebas::where('pasienbebas_uuid', '=', $request->uuid)->get();
		$layanan = LayananPasien::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		// }
		
		return response()->json(['data' => $data, 'layanan' => $layanan, 'obatracikan' => $obatracikan, 'detail' => $detail]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data unit dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama
		);

		try{
			DB::beginTransaction();

			$update = Unit::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Unit::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Unit::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Unit::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}