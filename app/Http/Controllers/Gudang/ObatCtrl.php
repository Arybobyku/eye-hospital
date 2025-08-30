<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Obat;

class ObatCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman master obat/alkes');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Obat::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = Obat::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Obat::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Obat::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		$checkObat = Obat::where('nama', '=', $request->nama)->where('delete_soft', '=', 1)->first();

		if($checkObat) {
			return response()->json(['hasil' => 'Obat sudah ada di master data'], 500);
		}
		if ($this->error != 'next') 
			{ return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data master obat/alkes dengan nama "'.$request->nama.'".');



		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Obat::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$item = new Obat();
			$item->uuid = $uuid;
			$item->nama = $request->nama;
			$item->keterangan = $request->keterangan;
			$item->satuan_uuid_besar = $request->satuan_uuid_besar;
			$item->nama_satuan_besar = $request->nama_satuan_besar;
			$item->satuan_uuid_kecil = $request->satuan_uuid_kecil;
			$item->nama_satuan_kecil = $request->nama_satuan_kecil;
			$item->hitung_besar = $request->hitung_besar;
			$item->hitung_kecil = $request->hitung_kecil;
			$item->kategori = $request->kategori && $request->kategori != '' ? $request->kategori : '-';
			$item->formularium = $request->formularium && $request->formularium != '' ? $request->formularium : '-';
			$item->golongan = $request->golongan && $request->golongan != '' ? $request->golongan : '-';
			$item->min_stock = $request->min_stock;
			$item->jenis = $request->jenis;
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

		$data = Obat::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data master obat/alkes dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit master obat/alkes');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data master obat/alker dengan nama "'.$request->nama.'".');

		$arr = array(
			'nama' => $request->nama,
			'keterangan' => $request->keterangan,
			'satuan_uuid_besar' => $request->satuan_uuid_besar,
			'nama_satuan_besar' => $request->nama_satuan_besar,
			'satuan_uuid_kecil' => $request->satuan_uuid_kecil,
			'nama_satuan_kecil' => $request->nama_satuan_kecil,
			'hitung_besar' => $request->hitung_besar,
			'hitung_kecil' => $request->hitung_kecil,
			'kategori' => $request->kategori,
			'formularium' => $request->formularium,
			'golongan' => $request->golongan,
			'min_stock' => $request->min_stock,
			'jenis' => $request->jenis,
		);

		try{
			DB::beginTransaction();

			$update = Obat::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Obat::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data obat/alkes dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Obat::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Obat::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}