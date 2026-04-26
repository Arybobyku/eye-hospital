<?php

namespace App\Http\Controllers\Gudang;

use App\Exports\TemplateInputStockOpname;
use App\Exports\UploadInputStockOpname;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\LabelStockOpname;
use App\Models\Obat;
use App\Models\StockCatat;
use App\Models\StockOpname;
use Maatwebsite\Excel\Facades\Excel;


class LabelStockOpnameCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function list(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		if ($request->search != "") {
			$data = LabelStockOpname::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%' . $search . '%')
				->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
				->orderBy('id', 'desc')
				->skip($skip)->take($this->take)
				->get();
			$total = LabelStockOpname::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%' . $search . '%')
				->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
				->orderBy('id', 'desc')->count();
		} else {
			$data = LabelStockOpname::where('delete_soft', '=', 1)
				->orderBy('id', 'desc')
				->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
				->skip($skip)->take($this->take)
				->get();

			$total = LabelStockOpname::where('delete_soft', '=', 1)
				->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
				->orderBy('id', 'desc')->count();
		}

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function add(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan data unit dengan nama "' . $request->nama . '".');

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = LabelStockOpname::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		try {
			DB::beginTransaction();

			$item = new LabelStockOpname();
			$item->uuid = $uuid;
			$item->nama = $request->nama;
			$item->tanggal = $request->tanggal;
			$item->jam = $request->jam;
			$item->unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
			$item->nama_unit = 'Gudang Farmasi';
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function edit(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = LabelStockOpname::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data unit dengan nama "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman edit unit');
		}

		return response()->json(['data' => $data]);
	}

	public function update(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Mengupdate data unit dengan nama "' . $request->nama . '".');

		$arr = array(
			'nama' => $request->nama,
			'tanggal' => $request->tanggal,
			'jam' => $request->jam,
		);

		try {
			DB::beginTransaction();

			$update = LabelStockOpname::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = LabelStockOpname::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "' . $data->nama . '" dan id "' . $data->id . '".');
		}

		$arr = array('delete_soft' => 0);

		try {
			DB::beginTransaction();

			$remove = LabelStockOpname::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$data = LabelStockOpname::where('delete_soft', '=', '1')->where('nama', 'ilike', '%' . $request->keyword . '%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

	public function getbalance(Request $request)
	{

		$data = StockCatat::where('label_stockopname_uuid', '=', $request->uuid)->get();

		return response()->json(['data' => $data]);
	}

	public function addbalance(Request $request)
	{

		try {
			DB::beginTransaction();

			$data = StockCatat::where('label_stockopname_uuid', '=', $request->label_stockopname_uuid)->delete();

			$obat = json_decode($request->obat);

			foreach ($obat as $row) {
				$item = new StockCatat();
				$item->uuid = Uuid::uuid4();
				$item->label_stockopname_uuid = $request->label_stockopname_uuid;
				$item->obat_uuid = $row->obat_uuid;
				$item->nama = $row->nama;
				$item->kategori = $row->kategori;
				$item->formularium = $row->formularium;
				$item->golongan = $row->golongan;
				$item->jenis = $row->jenis;
				$item->satuan_kekuatan = $row->satuan_kekuatan;
				$item->jumlah_kekuatan = $row->jumlah_kekuatan;
				$item->satuan_uuid_besar = $row->satuan_uuid_besar;
				$item->nama_satuan_besar = $row->nama_satuan_besar;
				$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
				$item->nama_satuan_kecil = $row->nama_satuan_kecil;
				$item->hitung_besar = $row->hitung_besar;
				$item->hitung_kecil = $row->hitung_kecil;
				$item->unit_uuid = 'bc0582ff-ce98-45f4-b361-ecef5b686a0f';
				$item->nama_unit = 'Gudang Farmasi';
				$item->before_jumlah_kecil = $row->before_jumlah_kecil;
				$item->before_jumlah_besar = $row->before_jumlah_besar;
				$item->after_jumlah_kecil = $row->after_jumlah_kecil;
				$item->after_jumlah_besar = $row->after_jumlah_besar;
				$item->selisih_jumlah_kecil = $row->selisih_jumlah_kecil;
				$item->selisih_jumlah_besar = $row->selisih_jumlah_besar;
				$item->labeling = $row->labeling;
				$item->save();
			}

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function prosesbalance(Request $request)
	{
		try {
			DB::beginTransaction();

			$data = StockCatat::where('label_stockopname_uuid', '=', $request->label_stockopname_uuid)->get();

			foreach ($data as $row) {
				$arr = array(
					'jumlah_kecil' => $row->after_jumlah_kecil,
					'jumlah_besar' => $row->after_jumlah_besar
				);
				$update = StockOpname::where('obat_uuid', '=', $row->obat_uuid)
					->where('unit_uuid', '=', 'bc0582ff-ce98-45f4-b361-ecef5b686a0f')
					->update($arr);
			}

			$arr = array('status' => 'Selesai');
			$update = LabelStockOpname::where('uuid', '=', $request->label_stockopname_uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function downloadTemplate($name, $tanggal, $waktu)
	{
		$filename = 'template-input-stockopname.xlsx';
		return \Excel::download(new TemplateInputStockOpname($name, $tanggal, $waktu, 'Gudang Farmasi'), $filename);
	}

	public function uploadTemplate(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:xlsx,csv,xls',
		]);

		Excel::import(new UploadInputStockOpname, $request->file('file'));

		return response()->json(['data' => 'berhasil']);
	}
}
