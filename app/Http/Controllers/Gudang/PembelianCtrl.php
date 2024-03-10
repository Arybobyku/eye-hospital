<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\StockOpname;
use App\Models\StockOpnameHistori;

class PembelianCtrl extends Controller
{
	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pembelian');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = DB::table('pembelian')
								->leftjoin('pembelian_detail', 'pembelian.no_faktur', '=', 'pembelian_detail.no_faktur')
								->where('pembelian.'.$column, 'ilike', '%'.$search.'%')
								->select(
									'pembelian.uuid as uuid',
									'pembelian.no_faktur as no_faktur',
									'pembelian.tanggal_faktur as tanggal_faktur',
									'pembelian.nama_supplier as nama_supplier',
									'pembelian.ppn as ppn',
									'pembelian.pembayaran as pembayaran',
									'pembelian.status as status',
									'pembelian.jangka_waktu as jangka_waktu',
									DB::raw("count(pembelian_detail.no_faktur) as jumlah"))
									->groupBy([
										'pembelian.uuid', 
										'pembelian.no_faktur', 
										'pembelian.tanggal_faktur',
										'pembelian.nama_supplier',
										'pembelian.ppn',
										'pembelian.pembayaran',
										'pembelian.status',
										'pembelian.jangka_waktu'
									])
								->orderBy('pembelian.tanggal_faktur', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = DB::table('pembelian')->where($column, 'ilike', '%'.$search.'%')->count();
			// $total = DB::table('pembelian')
			// 					->leftjoin('pembelian_detail', 'pembelian.no_faktur', '=', 'pembelian_detail.no_faktur')
			// 					->where('pembelian.'.$column, 'ilike', '%'.$search.'%')
			// 					->select(
			// 						'pembelian.uuid as uuid',
			// 						'pembelian.no_faktur as no_faktur',
			// 						'pembelian.tanggal_faktur as tanggal_faktur',
			// 						'pembelian.nama_supplier as nama_supplier',
			// 						'pembelian.ppn as ppn',
			// 						'pembelian.pembayaran as pembayaran',
			// 						'pembelian.status as status',
			// 						'pembelian.jangka_waktu as jangka_waktu',
			// 						DB::raw("count(pembelian_detail.no_faktur) as jumlah"))
			// 					->groupBy([
			// 							'pembelian.uuid', 
			// 							'pembelian.no_faktur', 
			// 							'pembelian.tanggal_faktur',
			// 							'pembelian.nama_supplier',
			// 							'pembelian.ppn',
			// 							'pembelian.pembayaran',
			// 							'pembelian.status',
			// 							'pembelian.jangka_waktu'
			// 						])
			// 					->orderBy('pembelian.tanggal_faktur', 'desc')
			// 					->count();

			
			// $data = Pembelian::where('delete_soft', '=', 1)
			// 					->where($column, 'ilike', '%'.$search.'%')
			// 					->orderBy('id', 'desc')
			// 					->skip($skip)->take($this->take)
			// 					->get();
			// $total = Pembelian::where('delete_soft', '=', 1)
			// 					->where($column, 'ilike', '%'.$search.'%')
			// 					->orderBy('id', 'desc')->count();
		}
		else {
			$data = DB::table('pembelian')
								->leftjoin('pembelian_detail', 'pembelian.no_faktur', '=', 'pembelian_detail.no_faktur')
								->select(
									'pembelian.uuid as uuid',
									'pembelian.no_faktur as no_faktur',
									'pembelian.tanggal_faktur as tanggal_faktur',
									'pembelian.nama_supplier as nama_supplier',
									'pembelian.ppn as ppn',
									'pembelian.pembayaran as pembayaran',
									'pembelian.status as status',
									'pembelian.jangka_waktu as jangka_waktu',
									DB::raw("count(pembelian_detail.no_faktur) as jumlah"))
									->groupBy([
										'pembelian.uuid', 
										'pembelian.no_faktur', 
										'pembelian.tanggal_faktur',
										'pembelian.nama_supplier',
										'pembelian.ppn',
										'pembelian.pembayaran',
										'pembelian.status',
										'pembelian.jangka_waktu'
									])
								->orderBy('pembelian.tanggal_faktur', 'desc')
								->skip($skip)->take($this->take)
								->get();
			// $total = DB::table('pembelian')
			// 					->leftjoin('pembelian_detail', 'pembelian.no_faktur', '=', 'pembelian_detail.no_faktur')
			// 					->select(
			// 						'pembelian.uuid as uuid',
			// 						'pembelian.no_faktur as no_faktur',
			// 						'pembelian.tanggal_faktur as tanggal_faktur',
			// 						'pembelian.nama_supplier as nama_supplier',
			// 						'pembelian.ppn as ppn',
			// 						'pembelian.pembayaran as pembayaran',
			// 						'pembelian.status as status',
			// 						'pembelian.jangka_waktu as jangka_waktu',
			// 						DB::raw("count(pembelian_detail.no_faktur) as jumlah"))
			// 					->groupBy([
			// 							'pembelian.uuid', 
			// 							'pembelian.no_faktur', 
			// 							'pembelian.tanggal_faktur',
			// 							'pembelian.nama_supplier',
			// 							'pembelian.ppn',
			// 							'pembelian.pembayaran',
			// 							'pembelian.status',
			// 							'pembelian.jangka_waktu'
			// 						])
			// 					->orderBy('pembelian.tanggal_faktur', 'desc')
			// 					->count();
			$total = DB::table('pembelian')->count();
			// $data = Pembelian::where('delete_soft', '=', 1)
			// 						->orderBy('id', 'desc')
			// 						->skip($skip)->take($this->take)
			// 						->get();

			// $total = Pembelian::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pembelian dengan nomor faktur "'.$request->no_faktur.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Pembelian::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$tempo = '1990-01-01';
			if ($request->jangka_waktu != '' && $request->jangka_waktu != '-' && $request->jangka_waktu  && $request->jangka_waktu != '0' ) {
				$m = $request->tanggal_faktur."+".$request->jangka_waktu." day";
				$date = strtotime($m);
				$tempo = date('Y-m-d', $date);
			}

			$item = new Pembelian();
			$item->uuid = $uuid;
			$item->supplier_uuid = $request->supplier_uuid;
			$item->nama_supplier = $request->nama_supplier;
			$item->ppn = $request->ppn;
			$item->no_faktur = $request->no_faktur;
			$item->tanggal_faktur = $request->tanggal_faktur;
			$item->pembayaran = $request->pembayaran;
			$item->jangka_waktu = $request->jangka_waktu;
			$item->keterangan = $request->keterangan;
			$item->penerima = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
			$item->tempo = $tempo;
			$item->status_pembayaran = $request->pembayaran == 'Tunai' ? 'Sudah Dibayar' : 'Belum Dibayar';
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

		$data = Pembelian::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pembelian dengan nomor faktur "'.$data->no_faktur.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit faktur');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data pembelian dengan nomor faktur "'.$request->no_faktur.'".');

		$tempo = '1990-01-01';
		if ($request->jangka_waktu != '' && $request->jangka_waktu != '-' && $request->jangka_waktu  && $request->jangka_waktu != '0' ) {
			$m = $request->tanggal_faktur."+".$request->jangka_waktu." day";
			$date = strtotime($m);
			$tempo = date('Y-m-d', $date);
		}

		$arr = array(
			'supplier_uuid' => $request->supplier_uuid,
			'nama_supplier' => $request->nama_supplier,
			'ppn' => $request->ppn,
			'no_faktur' => $request->no_faktur,
			'tanggal_faktur' => $request->tanggal_faktur,
			'pembayaran' => $request->pembayaran,
			'jangka_waktu' => $request->jangka_waktu,
			'keterangan' => $request->keterangan,
			'tempo' => $tempo,
			'status_pembayaran' => $request->pembayaran == 'Tunai' ? 'Sudah Dibayar' : 'Belum Dibayar'
		);

		try{
			DB::beginTransaction();

			$update = Pembelian::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Pembelian::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data pembelian dengan nomor faktur "'.$data->no_faktur.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Pembelian::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Pembelian::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Melakukan approve data faktur pembelian dengan nomor faktur "'.$data->no_faktur.'" dan id "'.$data->id.'".');
		}

		$arr = array('status' => 'approve');
		
		try{
			DB::beginTransaction();

			$detail = PembelianDetail::where('no_faktur', '=', $data->no_faktur)->get();
			if (count($detail) > 0) {
				foreach ($detail as $row) {
					$stockopname = StockOpname::where('obat_uuid', '=', $row->obat_uuid)
							->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
							->first();

					if ($stockopname) {
						$arrin = array(
							'jumlah_besar' => ($stockopname->jumlah_besar + $row->jumlah_besar),
							'jumlah_kecil' => ($stockopname->jumlah_kecil + $row->jumlah_kecil)
						);
						$update = StockOpname::where('id', '=', $stockopname->id)->update($arrin);
					}
					else {
						$stockopname = new StockOpname();
						$stockopname->uuid = Uuid::uuid4();
						$stockopname->obat_uuid = $row->obat_uuid;
						$stockopname->nama = $row->nama;
						$stockopname->kategori = $row->kategori;
						$stockopname->formularium = $row->formularium;
						$stockopname->golongan = $row->golongan;
						$stockopname->satuan_uuid_besar = $row->satuan_uuid_besar;
						$stockopname->nama_satuan_besar = $row->nama_satuan_besar;
						$stockopname->satuan_uuid_kecil = $row->satuan_uuid_kecil;
						$stockopname->nama_satuan_kecil = $row->nama_satuan_kecil;
						$stockopname->hitung_besar = $row->hitung_besar;
						$stockopname->hitung_kecil = $row->hitung_kecil;
						$stockopname->jumlah_kecil = $row->jumlah_kecil;
						$stockopname->jumlah_besar = $row->jumlah_besar;
						$stockopname->unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
						$stockopname->nama_unit = 'Gudang Farmasi';
						$stockopname->save();
					}
				}
			}

			$approve = Pembelian::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Pembelian::where('uuid', '=', $request->uuid)->first();
		$dataobat = PembelianDetail::where('pembelian_uuid', '=', $request->uuid)->get();
		if ($data) {
			PenggunaHelp::log('Mengambil data pembelian dengan nomor faktur "'.$data->no_faktur.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit faktur');
		}
		
		return response()->json(['data' => $data, 'dataobat' => $dataobat]);
	}

	public function addobat(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data obat pada pembelian dengan nomor faktur '.$request->no_faktur);

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Pembelian::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try {
			DB::beginTransaction();

			$remove = PembelianDetail::where('no_faktur', '=', $request->no_faktur)->delete();

			$data = json_decode($request->dataobat);

			foreach($data as $row) {
					$item = new PembelianDetail();
					$item->uuid = Uuid::uuid4();
					$item->pembelian_uuid = $row->pembelian_uuid;
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
					$item->harga_kecil_diskon = $row->harga_kecil_diskon;
					$item->harga_besar_diskon = $row->harga_besar_diskon;
					$item->jumlah_diskon = $row->jumlah_diskon != '' || $row->jumlah_diskon ? $row->jumlah_diskon : 0;
					$item->ppn = $row->ppn;
					$item->batch = $row->batch;
					$item->expired_date = $row->expired_date;
					$item->no_faktur = $row->no_faktur;
					$item->tanggal_faktur = $row->tanggal_faktur;
					$item->pembayaran = $row->pembayaran;
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

}