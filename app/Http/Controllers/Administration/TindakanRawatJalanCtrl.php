<?php

namespace App\Http\Controllers\Administration;

use App\Exports\UploadInputBukuTarif;
use App\Http\Controllers\Controller;
use App\Models\BukuTarif;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\TindakanRawatJalan;
use Maatwebsite\Excel\Facades\Excel;

class TindakanRawatJalanCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data tindakan rawat jalan');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = BukuTarif::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('sub_label', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = BukuTarif::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = BukuTarif::where('delete_soft', '=', 1)
									->orderBy('sub_label', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = BukuTarif::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}

		return response()->json(['data' => $data, 'total' => $total]);

		if ($request->search != "") {
			$data = TindakanRawatJalan::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = TindakanRawatJalan::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = TindakanRawatJalan::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = TindakanRawatJalan::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data tindakan rawat jalan dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = BukuTarif::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			// DB::beginTransaction();

			// $item = new TindakanRawatJalan();
			// $item->uuid = $uuid;
			// $item->nama = $request->nama;
			// $item->jenis = $request->jenis;
			// $item->save();

			// DB::commit();

			DB::beginTransaction();

			$item = new BukuTarif();
			$item->uuid = $uuid;
			$item->label = $request->label;
			$item->sub_label = $request->sub_label;
			$item->nama = $request->nama;
			$item->harga = $request->harga;
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

		// $data = TindakanRawatJalan::where('uuid', '=', $request->uuid)->first();
		$data = BukuTarif::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data tindakan rawat jalan dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit tindakan rawat jalan');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data tindakan rawat jalan dengan nama "'.$request->nama.'".');

		$arr = array(
				'label' => $request->label,
				'sub_label' => $request->sub_label,
				'nama' => $request->nama,
				'harga' => $request->harga
		);

		try{
			DB::beginTransaction();

			// $update = TindakanRawatJalan::where('uuid', '=', $request->uuid)->update($arr);
			$update = BukuTarif::where('uuid', '=', $request->uuid)->update($arr);
			
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

		// $data = TindakanRawatJalan::where('uuid', '=', $request->uuid)->first();
		$data = BukuTarif::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data tindakan rawat jalan dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			// $remove = TindakanRawatJalan::where('uuid', '=', $request->uuid)->update($arr);
			$remove = BukuTarif::where('uuid', '=', $request->uuid)->update($arr);
			
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
		$data = TindakanRawatJalan::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

	public function uploadTemplate(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:xlsx,csv,xls',
		]);

		Excel::import(new UploadInputBukuTarif, $request->file('file'));

		return response()->json(['data' => 'berhasil']);
	}

}