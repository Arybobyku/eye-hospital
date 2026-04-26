<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\RunningImage;

class RunningImageCtrl extends Controller
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
			$data = RunningImage::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = RunningImage::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = RunningImage::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = RunningImage::where('delete_soft', '=', 1)->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = RunningImage::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$file = $request->file('datafile');
			$file_extension = $file->getClientOriginalExtension(); //** get filename extension
			$fileName = 'sliderfile/'.Uuid::uuid4().'_files.'. $file_extension;
			$uploaded = Storage::put('public/'.$fileName, file_get_contents($file->getRealPath()));

			$item = new RunningImage();
			$item->uuid = $uuid;
			$item->content = 'storage/'.$fileName;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function block(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = RunningImage::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		//$arr = array('status' => 'block');
		
		try{
			DB::beginTransaction();
			$crumbs = explode("/", $data->content);
			$filese = 'public/'.$crumbs[1].'/'.$crumbs[2];
			if(\Storage::exists($filese)){
				\Storage::delete($filese);
			}
			$remove = RunningImage::where('uuid', '=', $request->uuid)->delete();
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}