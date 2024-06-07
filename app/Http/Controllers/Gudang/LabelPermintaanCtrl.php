<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Exports\PermohonanObatAlkesExport;
use App\Models\LabelPermintaan;
use App\Models\StockPermintaan;
use App\Models\StockOpname;

class LabelPermintaanCtrl extends Controller
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
			$data = LabelPermintaan::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = LabelPermintaan::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = LabelPermintaan::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
									->skip($skip)->take($this->take)
									->get();

			$total = LabelPermintaan::where('delete_soft', '=', 1)
									->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
									->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = LabelPermintaan::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$permintaan = LabelPermintaan::whereDate('tanggal', '=', date('Y-m-d'))
								->where('no_permintaan', '!=', '-')
								->orderBy('no_permintaan', 'desc')->first();
			$nomor_i = 1;
			if ($permintaan) {
				$potong_kalimat = substr($permintaan->no_permintaan,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor_i += $potong_kalimat;
			}
			if ($nomor_i < 10) { $nomor_i = '0000'.$nomor_i; }
			else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
			else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
			else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
			$no_permintaan = date('Ymd').$nomor_i;

			$item = new LabelPermintaan();
			$item->uuid = $uuid;
			$item->no_permintaan = $no_permintaan;
			$item->tanggal = date('Y-m-d');
			$item->jam = date('H:i:s');
			$item->nama_pegawai = $request->nama;
			$item->unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
			$item->nama_unit = 'Gudang Farmasi';
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

		$data = LabelPermintaan::where('uuid', '=', $request->uuid)->first();
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
		);

		try{
			DB::beginTransaction();

			$update = LabelPermintaan::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = LabelPermintaan::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = LabelPermintaan::where('uuid', '=', $request->uuid)->update($arr);
			
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
		$data = LabelPermintaan::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

	public function getpermintaan(Request $request) {

		$data = StockPermintaan::where('label_permintaan_uuid', '=', $request->uuid)->get();

		return response()->json(['data' => $data]);
	}

	public function addpermintaan(Request $request) {
		
		try{
			DB::beginTransaction();

			$data = StockPermintaan::where('label_permintaan_uuid', '=', $request->label_permintaan_uuid)->delete();
			
			$obat = json_decode($request->obat);

			foreach ($obat as $row) {
				$item = new StockPermintaan();
				$item->uuid = Uuid::uuid4();
				$item->label_permintaan_uuid = $request->label_permintaan_uuid;
				$item->obat_uuid = $row->obat_uuid;
				$item->nama = $row->nama;
				$item->kategori = $row->kategori;
				$item->formularium = $row->formularium;
				$item->golongan = $row->golongan;
				$item->jenis = $row->jenis;
				$item->satuan_uuid_besar = $row->satuan_uuid_besar;
				$item->nama_satuan_besar = $row->nama_satuan_besar;
				$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
				$item->nama_satuan_kecil = $row->nama_satuan_kecil;
				$item->hitung_besar = $row->hitung_besar;
				$item->hitung_kecil = $row->hitung_kecil;
				$item->unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
				$item->nama_unit = 'Gudang Farmasi';
				$item->jumlah_kecil = $row->jumlah_kecil;
				$item->jumlah_besar = $row->jumlah_besar;
				$item->harga_netto = $row->harga_netto;
				$item->harga_netto_discount = $row->harga_netto_discount;
				$item->harga_netto_ppn = $row->harga_netto_ppn;
				$item->hpp = $row->hpp;
				$item->margin_resep = $row->margin_resep;
				$item->margin_non_resep = $row->margin_non_resep;
				$item->hja_resep = $row->hja_resep;
				$item->hja_non_resep = $row->hja_non_resep;
				$item->hja_resep_besar = $row->hja_resep_besar;
				$item->hja_non_resep_besar = $row->hja_non_resep_besar;
				$item->jumlah_permintaan_besar = $row->jumlah_permintaan_besar;
				$item->jumlah_permintaan_kecil = $row->jumlah_permintaan_kecil;
				$item->labeling = $row->labeling;
				$item->keterangan = $row->keterangan;
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

	public function cetakpermintaan(Request $request, $uuid) {
    $pdf = \App::make('dompdf.wrapper');
    $label = LabelPermintaan::where('uuid', '=', $uuid)->first();
		$stock = StockPermintaan::where('label_permintaan_uuid', '=', $uuid)->get();
    $pdf->loadView('print.cetakpermintaan', compact('label', 'stock'))->setPaper('a4', 'potrait');;
		return $pdf->stream();
		//return Excel::download(new PermohonanObatAlkesExport($request->label_permohonan_uuid), 'Data Permohonan Obat dan Alkes - '.date('Y-m-d').'.xlsx');
	}

}