<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;


class DokterCtrl extends Controller
{

	private $take = 15, $error = 'next';


	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->bridging = new BridgeVclaim();
	}
	public function list(Request $request)
	{


		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		//PenggunaHelp::log('(Bedah) Melihat data list table pada halaman data permintaan obat/alkes pada unit bedah');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		if ($search != '' || $column != '') {

			$endpoint = 'referensi/Dokter/' . $search;
		} else {
			$endpoint = 'referensi/Dokter/surma';
		}
		$result = $this->bridging->getRequest($endpoint);
		$data = json_decode($result);
		$total = 0;
		$data = $data->response;
		$data = $data->Dokter;

		return response()->json(['data' => $data, 'total' => $total]);

	}

	public function minta(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$permintaan = json_decode($request->permintaan);
		$tgl = date('Y-m-d');
		$jam = date('H:i');
		$kode = 'RQ' . date('ymd');
		if ($request->kode == '') {
			$get = MintaTerimaOpname::where('delete_soft', '=', '1')->orderBy('kode', 'desc')->first();
			$angka = 1;
			if ($get) {
				$temp = $get->kode;
				$temp = (int) substr($temp, 8);
				$angka = $temp + 1;
			}
			if ($angka > 0 && $angka < 10) {
				$kode .= '00' . $angka;
			} else if ($angka > 9 && $angka < 100) {
				$kode .= '0' . $angka;
			} else if ($angka > 99 && $angka < 1000) {
				$kode .= $angka;
			}
			PenggunaHelp::log('(Bedah) Melakukan request/permintaan data obat/alkes ke gudang sebanyak ' . count($permintaan) . ' item obat/alkes dengan kode ' . $kode);
		} else {
			$get = MintaTerimaOpname::where('delete_soft', '=', '1')->where('kode', '=', $request->kode)->orderBy('kode', 'desc')->first();
			$kode = $get->kode;
			$tgl = $get->tanggal_minta;
			$jam = $get->jam_minta;
			$remove = MintaTerimaOpname::where('kode', '=', $request->kode)->delete();
			PenggunaHelp::log('(Bedah) Melakukan perubahan request/permintaan data obat/alkes ke gudang sebanyak ' . count($permintaan) . ' item obat/alkes dengan kode ' . $kode);
		}


		try {
			DB::beginTransaction();

			foreach ($permintaan as $row) {
				$item = new MintaTerimaOpname();
				$item->uuid = Uuid::uuid4();
				$item->kode = $kode;
				$item->minta_pengguna_id = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Id'));
				$item->minta_pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
				$item->minta_pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
				$item->tanggal_minta = $tgl;
				$item->jam_minta = $jam;
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
				$item->minta_kecil = $row->minta_kecil;
				$item->minta_besar = $row->minta_besar;
				$item->dari_unit_uuid = $row->dari_unit_uuid;
				$item->dari_nama_unit = $row->dari_nama_unit;
				$item->status = 'Permintaan';
				$item->save();
			}


			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function detail(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Bedah) Melihat detail permintaan obat/alkes dengan kode ' . $data->kode);
		}

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->get();

		return response()->json(['data' => $data]);
	}

	public function batal(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Bedah) Membatalkan permintaan obat/alkes ke gudang farmasi dengan kode permintaan ' . $data->kode);
		}

		$arr = array('status' => 'Dibatalkan');

		try {
			DB::beginTransaction();

			$batal = MintaTerimaOpname::where('kode', '=', $request->kode)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function terima(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Bedah) Menerima obat/alkes dari gudang farmasi dengan kode permintaan ' . $data->kode);
		}

		$arr = array(
			'status' => 'Diterima',
			'penerima_pengguna_id' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Id')),
			'penerima_pengguna_uuid' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid')),
			'penerima_pengguna_nama' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama')),
			'tanggal_terima' => date('Y-m-d'),
			'jam_terima' => date('H:i')
		);

		try {
			DB::beginTransaction();

			$terima = MintaTerimaOpname::where('kode', '=', $request->kode)->update($arr);

			$msg = MintaTerimaOpname::where('kode', '=', $request->kode)->get();

			// penambahan
			foreach ($msg as $row) {
				$stockopname = StockOpname::where('obat_uuid', '=', $row->obat_uuid)
					->where('unit_uuid', '=', $row->dari_unit_uuid)
					->first();
				if ($stockopname) {
					$kecil = ((float) $stockopname->jumlah_kecil + (float) $row->minta_kecil);
					$besar = ((float) $kecil / (float) $row->hitung_kecil);
					$arrin = array(
						'jumlah_kecil' => $kecil,
						'jumlah_besar' => $besar
					);
					$update = StockOpname::where('id', '=', $stockopname->id)->update($arrin);
				} else {
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

					$besar = ((float) $row->minta_kecil / (float) $row->hitung_kecil);

					$stockopname->jumlah_kecil = $row->minta_kecil;
					$stockopname->jumlah_besar = $besar;

					$stockopname->unit_uuid = 'd88a34c8-f377-4477-88bc-643a8e0e041b';
					$stockopname->nama_unit = 'Apotek';
					$stockopname->save();
				}
			}

			// Pengurangan 
			foreach ($msg as $row) {
				$stockopname = StockOpname::where('obat_uuid', '=', $row->obat_uuid)
					->where('unit_uuid', '=', $row->ke_unit_uuid)
					->first();
				if ($stockopname) {
					$kecil = ((float) $stockopname->jumlah_kecil - (float) $row->minta_kecil);
					$besar = ((float) $kecil / (float) $row->hitung_kecil);
					$arrin = array(
						'jumlah_kecil' => $kecil,
						'jumlah_besar' => $besar,
					);
					$update = StockOpname::where('id', '=', $stockopname->id)->update($arrin);
				}
			}


			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

}