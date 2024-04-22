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

use App\Models\ResepBebas;
use App\Models\LayananPasienBebas;
use App\Models\PasienBebas;
use App\Jobs\SendAllJob;
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
								->where('status', '=', 'active')
								->where('pembayaran', '=', 'Belum Bayar')
								->where('jenis', '=', '-')
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->orderBy('id', 'asc')
								->orderBy('number', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->where('status', '=', 'active')
								->where('pembayaran', '=', 'Belum Bayar')
								->where('jenis', '=', '-')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('number', 'asc')
								->orderBy('id', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->where('status', '=', 'active')
									->where('pembayaran', '=', 'Belum Bayar')
									->where('jenis', '=', '-')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->where('status', '=', 'active')
									->where('pembayaran', '=', 'Belum Bayar')
									->where('jenis', '=', '-')
									->whereDate('tanggal', '=', date('Y-m-d'))
									->orderBy('id', 'asc')
									->orderBy('number', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function selesai(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('active_call' => '-', 'active_call_kasir' => '-', 'status' => 'deactive', 'farmasi_jam_selesai' => date('H:i'));
		$update = PasienBebas::where('uuid', '=', $request->uuid)->update($arr);
		return response()->json(['data' => 'success']);
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			$item = new LayananPasienBebas();
			$item->uuid = Uuid::uuid4();

			$item->pasienbebas_uuid = $request->pasienbebas_uuid;
			$item->tanggal = date('Y-m-d');
			$item->waktu = date('H:i');
			$item->carabayar_uuid = $request->carabayar_uuid;
			$item->carabayar_nama = $request->carabayar_nama;
			$item->layanan_uuid = $request->layanan_uuid;
			$item->nama_layanan = $request->nama_layanan;
			$item->tarif = $request->tarif;
			$item->jenis = 'Tindakan Pasien Bebas';
			$item->total = $request->tarif;
			$item->save();

			$detail = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();
			$data = LayananPasienBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->get();
			
			$arr = array('ada_tindakan' => 'Ya');
			$update = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->update($arr);
		
			DB::commit();

			return response()->json(['data' => $data, 'detail' => $detail, 'dfd' => $request->pasienbebas_uuid]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$detail = PasienBebas::where('uuid', '=', $request->uuid)->first();
		$data = LayananPasienBebas::where('pasienbebas_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		// }
		
		return response()->json(['data' => $data, 'detail' => $detail, 'dfd' => $request->uuid]);
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();
		// if ($data) {
		// 	PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		// }
		
		try{
			DB::beginTransaction();

			$remove = LayananPasienBebas::where('uuid', '=', $request->uuid)->delete();

			$detail = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->first();
			$data = LayananPasienBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->get();

			if (count($data) < 1) {
				$arr = array('ada_tindakan' => 'Tidak');
				$update = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->update($arr);
			}
			
			DB::commit();

			return response()->json(['data' => $data, 'detail' => $detail, 'dfd' => $request->pasienbebas_uuid]);
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