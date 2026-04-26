<?php

namespace App\Http\Controllers\Finance;

use App\Exports\DownloadPaketBedah;
use App\Exports\TemplateUploadPaketBedah;
use App\Exports\UploadPaketBEdah;
use App\Http\Controllers\Controller;
use App\Models\CaraBayar;
use App\Models\CaraBayarTindakanRawatJalan;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\ListPaketBedahBaru;
use App\Models\PaketBedah;
use Maatwebsite\Excel\Facades\Excel;

class ListPaketBedahCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$data = ListPaketBedahBaru::where('delete_soft', '=', 1)
									->orderBy('label', 'asc', 'sublabel','asc', 'nama', 'asc', 'id', 'desc')
									->where('paket_bedah_uuid', '=', $request->paket_bedah_uuid)
									->get();

		$total = ListPaketBedahBaru::where('delete_soft', '=', 1)->orderBy('id', 'desc')
							->where('paket_bedah_uuid', '=', $request->paket_bedah_uuid)->count();

		$paketBedah = PaketBedah::where('uuid',$request->paket_bedah_uuid)->first();					
		
		return response()->json(['data' => $data, 'total' => $total, 'paket_bedah'=>$paketBedah]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = ListPaketBedahBaru::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			if ($request->uuid != '' && $request->uuid != ' ' && $request->uuid) {
				
				$arr = array(
					'label' => $request->label,
					'sub_label' => $request->sub_label,
					'nama' => $request->nama,
					'quantity' => $request->quantity,
					'harga' => $request->harga,
				);
				
				$item = ListPaketBedahBaru::where('uuid', '=', $request->uuid)->update($arr);
			}
			else {
				$item = new ListPaketBedahBaru();
				$item->uuid = Uuid::uuid4();
				$item->nama_paket_bedah = $request->nama_paket_bedah;
				$item->paket_bedah_uuid = $request->paket_bedah_uuid;
				$item->label = $request->label;
				$item->sub_label = $request->sub_label;
				$item->nama = $request->nama;
				$item->quantity = $request->quantity;
				$item->harga = $request->harga;
				$item->save();
			}

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e) { 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = ListPaketBedahBaru::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		//$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = ListPaketBedahBaru::where('uuid', '=', $request->uuid)->delete();
			
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
		$data = ListPaketBedah::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}


	public function downloadTemplatePaketBedah($metode, $name) {
	
		$filename = 'template-upload.xlsx';
		return \Excel::download(new TemplateUploadPaketBedah($metode, $name), $filename);
	}

	public function downloadAll() {
	
		$filename = 'list-paket-bedah.xlsx';
		return \Excel::download(new DownloadPaketBedah(), $filename);
	}

	public function uploadPaketBedah(Request $request) {
		$request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new UploadPaketBEdah, $request->file('file'));

        return back()->with('success', 'Upload & import berhasil!');
	}
}