<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Label;
use App\Models\HakAkses;

class LabelCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data label');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Label::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = Label::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Label::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Label::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data label dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Label::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$item = new Label();
			$item->uuid = $uuid;
			$item->nama = $request->nama;
			$item->based = $request->based;
			$item->icon = $request->icon;
			$item->link = $request->link;
			$item->posisi = $request->posisi;
			$item->save();

			$label_uuid = $uuid;

			$uuid = ''; $loop = false;
			do { $uuid = Uuid::uuid4(); $check = HakAkses::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

			$item = new HakAkses;
			$item->uuid = $uuid;
			$item->pengguna_uuid =Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
			$item->nama_pengguna = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
			$item->username_pengguna = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
			$item->label_uuid = $label_uuid;
			$item->label_based = $request->based;
			$item->label_nama = $request->nama;
			$item->label_icon = $request->icon;
			$item->label_link = $request->link;
			$item->label_posisi = $request->posisi;
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

		$data = Label::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data label dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit label');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data label dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama,
				'based' => $request->based,
				'icon' => $request->icon,
				'link' => $request->link,
				'posisi' => $request->posisi,
		);

		$arr_pengguna = array(
			'label_based' => $request->based,
			'label_nama' => $request->nama,
			'label_icon' => $request->icon,
			'label_link' => $request->link,
			'label_posisi' => $request->posisi
		);

		try{
			DB::beginTransaction();

			$update = Label::where('uuid', '=', $request->uuid)->update($arr);

			$update = HakAkses::where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
								->where('label_uuid', '=', $request->uuid)->update($arr_pengguna);
			
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

		$data = Label::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data label dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Label::where('uuid', '=', $request->uuid)->delete();
			$remove = HakAkses::where('label_uuid', '=', $request->uuid)->delete();
			
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
		$data = Label::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama', 'link', 'icon', 'posisi'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}