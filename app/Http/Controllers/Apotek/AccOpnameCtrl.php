<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\MintaTerimaOpname;

class AccOpnameCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('(Apotek) Melihat data list table pada halaman data permintaan obat/alkes pada unit apotek');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = MintaTerimaOpname::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%'.$search.'%')
				->select( 'kode', 'tanggal_minta', 'jam_minta', 'dari_unit_uuid', 'dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', DB::raw("count(kode) as jumlah"))
				->groupBy(['kode', 'tanggal_minta', 'jam_minta','dari_unit_uuid','dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status',])
				->where('status', '!=', 'Dibatalkan')
				->where('ke_unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
				->orderBy('kode', 'desc')
				->skip($skip)->take($this->take)
				->get();
			$total = MintaTerimaOpname::where('delete_soft', '=', 1)
				->where($column, 'ilike', '%'.$search.'%')
				->select( 'kode', 'tanggal_minta', 'jam_minta', 'dari_unit_uuid', 'dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', DB::raw("count(kode) as jumlah"))
				->groupBy(['kode', 'tanggal_minta', 'jam_minta','dari_unit_uuid','dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', ])
				->where('status', '!=', 'Dibatalkan')
				->where('ke_unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
				->orderBy('kode', 'desc')
				->count();
		}
		else {
			$data = MintaTerimaOpname::where('delete_soft', '=', 1)
				->select( 'kode', 'tanggal_minta', 'jam_minta', 'dari_unit_uuid', 'dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', DB::raw("count(kode) as jumlah"))
				->groupBy(['kode', 'tanggal_minta', 'jam_minta','dari_unit_uuid','dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit',  'status',])
				->where('status', '!=', 'Dibatalkan')
				->where('ke_unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
				->orderBy('kode', 'desc')
				->skip($skip)->take($this->take)
				->get();

			$total = MintaTerimaOpname::where('delete_soft', '=', 1)
				->select( 'kode', 'tanggal_minta', 'jam_minta', 'dari_unit_uuid', 'dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', DB::raw("count(kode) as jumlah"))
				->groupBy([ 'kode', 'tanggal_minta', 'jam_minta', 'dari_unit_uuid', 'dari_nama_unit', 'ke_unit_uuid', 'ke_nama_unit', 'status', ])
				->where('status', '!=', 'Dibatalkan')
				->where('ke_unit_uuid', '=', 'd88a34c8-f377-4477-88bc-643a8e0e041b')
				->orderBy('kode', 'desc')
				->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function detail(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Apotek) Melihat detail permintaan obat/alkes dengan kode '.$data->kode);
		}

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->get();
		
		return response()->json(['data' => $data]);
	}

	public function proses(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Bedah) Memproses permintaan obat/alkes dari unit '.$data->dari_nama_unit.' dengan kode permintaan '.$data->kode);
		}

		$arr = array(
			'status' => 'Diproses',
			'proses_pengguna_id' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Id')),
			'proses_pengguna_uuid' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')),
			'proses_pengguna_nama' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama')),
			'tanggal_proses' => date('Y-m-d'),
			'jam_proses' => date('H:i')
		);
		
		try{
			DB::beginTransaction();

			$batal = MintaTerimaOpname::where('kode', '=', $request->kode)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function kirim(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = MintaTerimaOpname::where('kode', '=', $request->kode)->first();
		if ($data) {
			PenggunaHelp::log('(Gudang Farmasi) Mengirim obat/alkes ke unit '.$data->dari_nama_unit.' dengan kode permintaan '.$data->kode);
		}

		$arr = array(
			'status' => 'Dikirim',
			'pengirim_pengguna_id' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Id')),
			'pengirim_pengguna_uuid' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')),
			'pengirim_pengguna_nama' => Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama')),
			'tanggal_kirim' => date('Y-m-d'),
			'jam_kirim' => date('H:i')
		);
		
		try{
			DB::beginTransaction();

			$batal = MintaTerimaOpname::where('kode', '=', $request->kode)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}