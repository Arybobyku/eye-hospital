<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\HargaObat;

class HargaObatCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman harga obat/alkes');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = HargaObat::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = HargaObat::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = HargaObat::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = HargaObat::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$exist = HargaObat::where('delete_soft', '=', '1')->where('obat_uuid', '=', $request->obat_uuid)->first();

		if ($exist) {
			return response()->json(['data' => 'exist']);
		}

		PenggunaHelp::log('Menambahkan data harga obat/alkes dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = HargaObat::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$item = new HargaObat();
			$item->uuid = $uuid;
			$item->obat_uuid = $request->obat_uuid;
			$item->nama = $request->nama;
			$item->satuan_uuid_besar = $request->satuan_uuid_besar;
			$item->nama_satuan_besar = $request->nama_satuan_besar;
			$item->satuan_uuid_kecil = $request->satuan_uuid_kecil;
			$item->nama_satuan_kecil = $request->nama_satuan_kecil;
			$item->hitung_besar = $request->hitung_besar;
			$item->hitung_kecil = $request->hitung_kecil;
			$item->kategori = $request->kategori;
			$item->formularium = $request->formularium;
			$item->golongan = $request->golongan;
			$item->harga_netto = $request->harga_netto;
			$item->harga_netto_discount = $request->harga_netto_discount;
			$item->harga_netto_ppn = $request->harga_netto_ppn;
			$item->hpp = $request->hpp;
			$item->margin_resep = $request->margin_resep;
			$item->margin_non_resep = $request->margin_non_resep;
			$item->hja_resep = $request->hja_resep;
			$item->hja_non_resep = $request->hja_non_resep;
			$item->hja_resep_besar = $request->hja_resep_besar;
			$item->hja_non_resep_besar = $request->hja_non_resep_besar;
			$item->keterangan = $request->keterangan;
			$item->last_update = date('d/m/Y H:i');
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

		$data = HargaObat::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data harga obat/alkes dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit harga obat/alkes');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data harga obat/alkes dengan nama "'.$request->nama.'".');

		$arr = array(
			'obat_uuid' => $request->obat_uuid,
			'nama' => $request->nama,
			'satuan_uuid_besar' => $request->satuan_uuid_besar,
			'nama_satuan_besar' => $request->nama_satuan_besar,
			'satuan_uuid_kecil' => $request->satuan_uuid_kecil,
			'nama_satuan_kecil' => $request->nama_satuan_kecil,
			'hitung_besar' => $request->hitung_besar,
			'hitung_kecil' => $request->hitung_kecil,
			'kategori' => $request->kategori,
			'formularium' => $request->formularium,
			'golongan' => $request->golongan,
			'harga_netto' => $request->harga_netto,
			'harga_netto_discount' => $request->harga_netto_discount,
			'harga_netto_ppn' => $request->harga_netto_ppn,
			'hpp' => $request->hpp,
			'margin_resep' => $request->margin_resep,
			'margin_non_resep' => $request->margin_non_resep,
			'hja_resep' => $request->hja_resep,
			'hja_non_resep' => $request->hja_non_resep,
			'hja_resep_besar' => $request->hja_resep_besar,
			'hja_non_resep_besar' => $request->hja_non_resep_besar,
			'keterangan' => $request->keterangan,
			'last_update' => date('d/m/Y H:i')
		);

		try{
			DB::beginTransaction();

			$update = HargaObat::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = HargaObat::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data harga obat/alkes dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = HargaObat::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = HargaObat::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}