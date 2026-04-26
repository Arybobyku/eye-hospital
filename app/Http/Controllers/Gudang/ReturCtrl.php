<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Retur;
use App\Models\ReturObat;

class ReturCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('(Gudang Farmasi) Melihat data list table pada halaman data permintaan obat/alkes pada unit gudang farmasi');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;
		$from = $request->from;
		$to = $request->to;

		if ($request->search != "") {
			$data = DB::table('retur')
							->leftjoin('retur_obat', 'retur.kode_retur', '=', 'retur_obat.kode_retur')
							->where('retur.'.$column, 'ilike', '%'.$search.'%')
							->select(
								'retur.uuid as uuid',
								'retur.kode_retur as kode_retur',
								'retur.nama_supplier as nama_supplier',
								'retur.tanggal_retur as tanggal_retur',
								'retur.status as status',
								DB::raw("count(retur_obat.kode_retur) as jumlah"))
								->groupBy([
									'retur.uuid', 
									'retur.kode_retur', 
									'retur.nama_supplier',
									'retur.tanggal_retur',
									'retur.status'
								])
							->where('retur.delete_soft', '=', 1)
							->orderBy('retur.kode_retur', 'desc')
							->skip($skip)->take($this->take)
							->get();
							
			$total = DB::table('retur')
							->leftjoin('retur_obat', 'retur.kode_retur', '=', 'retur_obat.kode_retur')
							->where('retur.'.$column, 'ilike', '%'.$search.'%')
							->select(
								'retur.uuid as uuid',
								'retur.kode_retur as kode_retur',
								'retur.nama_supplier as nama_supplier',
								'retur.tanggal_retur as tanggal_retur',
								'retur.status as status',
								DB::raw("count(retur_obat.kode_retur) as jumlah"))
								->groupBy([
									'retur.uuid', 
									'retur.kode_retur', 
									'retur.nama_supplier',
									'retur.tanggal_retur',
									'retur.status'
								])
							->where('retur.delete_soft', '=', 1)
							->orderBy('retur.kode_retur', 'desc')
							->skip($skip)->take($this->take)
							->count();
		}
		else {
			$data = DB::table('retur')
							->leftjoin('retur_obat', 'retur.kode_retur', '=', 'retur_obat.kode_retur')
							->select(
								'retur.uuid as uuid',
								'retur.kode_retur as kode_retur',
								'retur.nama_supplier as nama_supplier',
								'retur.tanggal_retur as tanggal_retur',
								'retur.status as status',
								DB::raw("count(retur_obat.kode_retur) as jumlah"))
								->groupBy([
									'retur.uuid', 
									'retur.kode_retur', 
									'retur.nama_supplier',
									'retur.tanggal_retur',
									'retur.status'
								])
							->where('retur.delete_soft', '=', 1)
							->orderBy('retur.kode_retur', 'desc')
							->skip($skip)->take($this->take)
							->get();

			$total = DB::table('retur')
							->leftjoin('retur_obat', 'retur.kode_retur', '=', 'retur_obat.kode_retur')
							->select(
								'retur.uuid as uuid',
								'retur.kode_retur as kode_retur',
								'retur.nama_supplier as nama_supplier',
								'retur.tanggal_retur as tanggal_retur',
								'retur.status as status',
								DB::raw("count(retur_obat.kode_retur) as jumlah"))
								->groupBy([
									'retur.uuid', 
									'retur.kode_retur', 
									'retur.nama_supplier',
									'retur.tanggal_retur',
									'retur.status'
								])
							->where('retur.delete_soft', '=', 1)
							->orderBy('retur.kode_retur', 'desc')
							->skip($skip)->take($this->take)
							->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data pembelian dengan nomor retur "'.$request->no_faktur.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Retur::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$retur = Retur::orderBy('kode_retur', 'desc')->first();

			$nomor = 1;
			if ($retur) { 
				$potong_kalimat = substr($retur->kode_retur,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor += $potong_kalimat;
			}

			if ($nomor < 9) { $nomor = '0000'.$nomor; }
			else if ($nomor > 9 && $nomor < 100) { $nomor = '000'.$nomor; }
			else if ($nomor > 99 && $nomor < 1000) { $nomor = '00'.$nomor; }
			else if ($nomor > 999 && $nomor < 10000) { $nomor = '0'.$nomor; }

			$kode_retur = date('Y').date('m').date('d').$nomor;

			$item = new Retur();
			$item->uuid = $uuid;
			$item->kode_retur = $kode_retur;
			$item->supplier_uuid = $request->supplier_uuid;
			$item->nama_supplier = $request->nama_supplier;
			$item->tanggal_retur = $request->tanggal_retur;
			$item->keterangan = $request->keterangan;
			$item->penerima = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
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

		$data = Retur::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pembelian dengan kode retur "'.$data->kode_retur.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit faktur');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Mengupdate data pembelian dengan nomor faktur "'.$request->no_faktur.'".');

		$arr = array(
			'supplier_uuid' => $request->supplier_uuid,
			'nama_supplier' => $request->nama_supplier,
			'tanggal_retur' => $request->tanggal_retur,
			'keterangan' => $request->keterangan,
		);

		try{
			DB::beginTransaction();

			$update = Retur::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Retur::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data pembelian dengan kode retur "'.$data->kode_retur.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Retur::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function obat(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Retur::where('uuid', '=', $request->uuid)->first();
		$dataobat = ReturObat::where('retur_uuid', '=', $request->uuid)->get();
		if ($data) {
			PenggunaHelp::log('Mengambil data pembelian dengan kode retur "'.$data->kode_retur.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit faktur');
		}
		
		return response()->json(['data' => $data, 'dataobat' => $dataobat]);
	}

	public function addobat(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data obat pada pembelian dengan nomor faktur '.$request->no_faktur);

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = ReturObat::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try {
			DB::beginTransaction();

			$remove = ReturObat::where('kode_retur', '=', $request->kode_retur)->delete();

			$data = json_decode($request->dataobat);

			foreach($data as $row) {
					$item = new ReturObat();
					$item->uuid = Uuid::uuid4();
					$item->retur_uuid = $row->retur_uuid;
					$item->supplier_uuid = $row->supplier_uuid;
					$item->nama_supplier = $row->nama_supplier;
					$item->obat_uuid = $row->obat_uuid;
					$item->nama = $row->nama;
					$item->kategori = $row->kategori;
					$item->formularium = $row->formularium;
					$item->golongan = $row->golongan;
					$item->satuan_uuid_besar = $row->satuan_uuid_besar;
					$item->nama_satuan_besar = $row->nama_satuan_besar;
					$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
					$item->nama_satuan_kecil = $row->nama_satuan_kecil;
					$item->hitung_besar = $row->hitung_besar;
					$item->hitung_kecil = $row->hitung_kecil;
					$item->jumlah_kecil = $row->jumlah_kecil;
					$item->jumlah_besar = $row->jumlah_besar;
					$item->harga_kecil = $row->harga_kecil;
					$item->harga_besar = $row->harga_besar;
					$item->batch = $row->batch;
					$item->expired_date = $row->expired_date;
					$item->kode_retur = $row->kode_retur;
					$item->tanggal_retur = $row->tanggal_retur;
					$item->keterangan = $row->keterangan;
					$item->penerima = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
					$item->save();
			}

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}

	}

	public function approve(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Retur::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Melakukan approve data faktur pembelian dengan nomor faktur "'.$data->no_faktur.'" dan id "'.$data->id.'".');
		}

		$arr = array('status' => 'approve');
		
		try{
			DB::beginTransaction();

			$detail = ReturObat::where('kode_retur', '=', $data->kode_retur)->get();
			if (count($detail) > 0) {
				foreach ($detail as $row) {
					$stockopname = StockOpname::where('obat_uuid', '=', $row->obat_uuid)->first();

					if ($stockopname) {
						$arrin = array(
							'jumlah_besar' => ($stockopname->jumlah_besar + $row->jumlah_besar),
							'jumlah_kecil' => ($stockopname->jumlah_kecil + $row->jumlah_kecil)
						);
						$update = StockOpname::where('id', '=', $stockopname->id)->update($arrin);
					}
				}
			}

			$approve = Retur::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}