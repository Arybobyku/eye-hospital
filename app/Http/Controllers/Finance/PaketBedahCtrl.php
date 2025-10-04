<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PaketBedah;
use App\Models\ListPaketBedahBaru;

class PaketBedahCtrl extends Controller
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
			$data = PaketBedah::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = PaketBedah::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = PaketBedah::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = PaketBedah::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = PaketBedah::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$item = new PaketBedah();
			$item->uuid = $uuid;
			$item->nama = $request->nama;
			$item->total = $request->total;
			$item->pengguna_uuid = $request->pengguna_uuid && $request->pengguna_uuid != '' ? $request->pengguna_uuid : '-';
			$item->nama_dokter = $request->nama_dokter && $request->nama_dokter != '' && $request->nama_dokter != 'Silahkan Pilih' ? $request->nama_dokter : '-';
			$item->keterangan = $request->keterangan;
			$item->harga_sudah_ditentukan = $request->harga_sudah_ditentukan;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function edit(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = PaketBedah::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data unit dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama,
				'total' => $request->total,
				'pengguna_uuid' => $request->pengguna_uuid && $request->pengguna_uuid != '' ? $request->pengguna_uuid : '-',
				'nama_dokter' => $request->nama_dokter && $request->nama_dokter != '' && $request->nama_dokter != 'Silahkan Pilih' ? $request->nama_dokter : '-',
				'keterangan' => $request->keterangan,
				'harga_sudah_ditentukan' => $request->harga_sudah_ditentukan,
		);

		try{
			DB::beginTransaction();

			$update = PaketBedah::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = PaketBedah::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = PaketBedah::where('uuid', '=', $request->uuid)->update($arr);
			$remove = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function duplicate(Request $request) {

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
	
		$paketLama = PaketBedah::where('uuid', $request->uuid)->first();
	
		if (!$paketLama) {
			return response()->json(['data' => 'Data tidak ditemukan']);
		}
	
		PenggunaHelp::log('Menggandakan data paket bedah dengan nama "' . $paketLama->nama . '" dan id "' . $paketLama->id . '".');
	
		try {
			DB::beginTransaction();
	
			// Generate UUID baru untuk master
			$uuidBaru = Uuid::uuid4();
	
			// Duplikasi master
			$paketBaru = new PaketBedah();
			$paketBaru->uuid = $uuidBaru;
			$paketBaru->nama = $paketLama->nama . ' (Copy)';
			$paketBaru->total = $paketLama->total;
			$paketBaru->pengguna_uuid = $paketLama->pengguna_uuid;
			$paketBaru->nama_dokter = $paketLama->nama_dokter;
			$paketBaru->keterangan = $paketLama->keterangan;
			$paketBaru->uuid_carabayar = $paketLama->uuid_carabayar;
			$paketBaru->nama_carabayar = $paketLama->nama_carabayar;
			$paketBaru->save();
	
			// Duplikasi detail
			$detailLama = ListPaketBedahBaru::where('paket_bedah_uuid', $paketLama->uuid)->get();
	
			foreach ($detailLama as $detail) {
				$detailBaru = new ListPaketBedahBaru();
				$detailBaru->uuid = Uuid::uuid4();
				$detailBaru->paket_bedah_uuid = $uuidBaru; // relasi ke paket baru
				$detailBaru->nama_paket_bedah = $detail->nama_paket_bedah;
				$detailBaru->label = $detail->label;
				$detailBaru->sub_label = $detail->sub_label;
				$detailBaru->nama = $detail->nama;
				$detailBaru->quantity = $detail->quantity;
				$detailBaru->harga = $detail->harga;
				$detailBaru->save();
			}
	
			DB::commit();
	
			return response()->json(['data' => 'berhasil']);
		}
		catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal', 'error' => $e->getMessage()]);
		}
	}
	

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = PaketBedah::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}