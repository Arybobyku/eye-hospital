<?php

namespace App\Http\Controllers\Asuransi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Bedah;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\PaketBedah;
use App\Models\ListPaketBedah;


class PasienRawatJalanCtrl extends Controller
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
			$data = Registrasi::with('layanan')->where('delete_soft', '=', 1);
			if ($column == 'metodebayar') {
				$data = $data->where(function($q) use($search) {
					$q->where('carabayar_nama', 'ilike', '%'.$search.'%')
						->orWhere('nama_asuransi', 'ilike', '%'.$search.'%');
				});
			}
			else {
				$data = $data->where($column, 'ilike', '%'.$search.'%');
			}
								
			$data = $data->where(function($q){
									$q->where('carabayar_nama', '!=', 'Umum')
										->where('carabayar_nama', '!=', 'BPJS Kesehatan');
								})
								->where(function($q){
									$q->where('carabayar_uuid', '!=', '1bddd542-fd1e-4b6a-b629-53bd35428796')
										->where('carabayar_uuid', '!=', 'e3ed042d-2b41-4672-bcc2-7a816a622667')
										->where('carabayar_uuid', '!=', 'd494b806-9af6-4ccc-af2a-50be75e0814f')
										->where('carabayar_uuid', '!=', '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3')
										->where('carabayar_uuid', '!=', 'bca360e3-aadc-4b7c-8308-0f0ba85876e1')
										->where('carabayar_uuid', '!=', 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740')
										->where('carabayar_uuid', '!=', '50f0abb5-2a71-4e86-bd36-a238ef3fa118');
								})
								->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs kesehatan')
								->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS Sehat')
								->where('carabayar_nama', '!=', 'BPJS-Sehat')
								->where('carabayar_nama', '!=', 'BPJS_Sehat')
								->where('carabayar_nama', '!=', 'BPJS SEHAT')
								->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								->where('carabayar_nama', '!=', 'bpjs sehat')
								->where('carabayar_nama', '!=', 'bpjs-sehat')
								->where('carabayar_nama', '!=', 'bpjs_sehat')
								->where('status', '!=', 'Batal')
								->where('status', '!=', 'Rawat Inap')
								->where('is_asuransi', '=', 'ya')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::with('layanan')->where('delete_soft', '=', 1);

			if ($column == 'metodebayar') {
				$total = $total->where(function($q) use($search) {
					$q->where('carabayar_nama', 'ilike', '%'.$search.'%')
						->orWhere('nama_asuransi', 'ilike', '%'.$search.'%');
				});
			}
			else {
				$total = $total->where($column, 'ilike', '%'.$search.'%');
			}
								
			$total = $total->where(function($q){
									$q->where('carabayar_nama', '!=', 'Umum')
										->where('carabayar_nama', '!=', 'BPJS Kesehatan');
								})
								->where(function($q){
									$q->where('carabayar_uuid', '!=', '1bddd542-fd1e-4b6a-b629-53bd35428796')
										->where('carabayar_uuid', '!=', 'e3ed042d-2b41-4672-bcc2-7a816a622667')
										->where('carabayar_uuid', '!=', 'd494b806-9af6-4ccc-af2a-50be75e0814f')
										->where('carabayar_uuid', '!=', '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3')
										->where('carabayar_uuid', '!=', 'bca360e3-aadc-4b7c-8308-0f0ba85876e1')
										->where('carabayar_uuid', '!=', 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740')
										->where('carabayar_uuid', '!=', '50f0abb5-2a71-4e86-bd36-a238ef3fa118');
								})
								->where('status', '!=', 'Batal')
								->where('status', '!=', 'Rawat Inap')
								->where('is_asuransi', '=', 'ya')
								->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs kesehatan')
								->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS Sehat')
								->where('carabayar_nama', '!=', 'BPJS-Sehat')
								->where('carabayar_nama', '!=', 'BPJS_Sehat')
								->where('carabayar_nama', '!=', 'BPJS SEHAT')
								->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								->where('carabayar_nama', '!=', 'bpjs sehat')
								->where('carabayar_nama', '!=', 'bpjs-sehat')
								->where('carabayar_nama', '!=', 'bpjs_sehat')
								->orderBy('id', 'desc')
								->count();
		}
		else {
			$data = Registrasi::with('layanan')->where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where(function($q){
										$q->where('carabayar_nama', '!=', 'Umum')
											->where('carabayar_nama', '!=', 'BPJS Kesehatan');
									})
									->where(function($q){
										$q->where('carabayar_uuid', '!=', '1bddd542-fd1e-4b6a-b629-53bd35428796')
											->where('carabayar_uuid', '!=', 'e3ed042d-2b41-4672-bcc2-7a816a622667')
											->where('carabayar_uuid', '!=', 'd494b806-9af6-4ccc-af2a-50be75e0814f')
											->where('carabayar_uuid', '!=', '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3')
											->where('carabayar_uuid', '!=', 'bca360e3-aadc-4b7c-8308-0f0ba85876e1')
											->where('carabayar_uuid', '!=', 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740')
											->where('carabayar_uuid', '!=', '50f0abb5-2a71-4e86-bd36-a238ef3fa118');
									})
									->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs kesehatan')
								->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS Sehat')
								->where('carabayar_nama', '!=', 'BPJS-Sehat')
								->where('carabayar_nama', '!=', 'BPJS_Sehat')
								->where('carabayar_nama', '!=', 'BPJS SEHAT')
								->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								->where('carabayar_nama', '!=', 'bpjs sehat')
								->where('carabayar_nama', '!=', 'bpjs-sehat')
								->where('carabayar_nama', '!=', 'bpjs_sehat')
									->where('status', '!=', 'Batal')
									->where('status', '!=', 'Rawat Inap')
									->where('is_asuransi', '=', 'ya')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::with('layanan')->where('delete_soft', '=', 1)->orderBy('id', 'desc')
									->where(function($q){
										$q->where('carabayar_nama', '!=', 'Umum')
											->where('carabayar_nama', '!=', 'BPJS Kesehatan');
									})
									->where(function($q){
										$q->where('carabayar_uuid', '!=', '1bddd542-fd1e-4b6a-b629-53bd35428796')
											->where('carabayar_uuid', '!=', 'e3ed042d-2b41-4672-bcc2-7a816a622667')
											->where('carabayar_uuid', '!=', 'd494b806-9af6-4ccc-af2a-50be75e0814f')
											->where('carabayar_uuid', '!=', '91cf4fa7-f35f-41e2-8e29-0ed6a3982da3')
											->where('carabayar_uuid', '!=', 'bca360e3-aadc-4b7c-8308-0f0ba85876e1')
											->where('carabayar_uuid', '!=', 'f93e2aeb-0f76-4f16-8bc0-b291eb16e740')
											->where('carabayar_uuid', '!=', '50f0abb5-2a71-4e86-bd36-a238ef3fa118');
									})
									->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs kesehatan')
								->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								->where('carabayar_nama', '!=', 'BPJS Sehat')
								->where('carabayar_nama', '!=', 'BPJS-Sehat')
								->where('carabayar_nama', '!=', 'BPJS_Sehat')
								->where('carabayar_nama', '!=', 'BPJS SEHAT')
								->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								->where('carabayar_nama', '!=', 'bpjs sehat')
								->where('carabayar_nama', '!=', 'bpjs-sehat')
								->where('carabayar_nama', '!=', 'bpjs_sehat')
									->where('status', '!=', 'Batal')
									->where('status', '!=', 'Rawat Inap')
									->where('is_asuransi', '=', 'ya')
									->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function disetujui(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('is_approve' => 'ya', 'status_penjamin' => 'disetujui');
		
		try{
			DB::beginTransaction();

			$remove = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function diterima(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Bedah::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('is_pay' => 'ya');
		
		try{
			DB::beginTransaction();

			$remove = Bedah::where('uuid', '=', $request->uuid)->update($arr);

			$remove = Registrasi::where('uuid', '=', $data->registrasi_uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function detail(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Bedah::where('uuid', '=', $request->uuid)->first();
		$paket = PaketBedah::where('uuid', '=', $data->paket_uuid)->first();
		$list_paket = ListPaketBedah::where('paket_bedah_uuid', '=', $data->paket_uuid)->get();
		return response()->json(['paket' => $paket, 'list_paket' => $list_paket]);
	}

	public function edit(Request $request) {
		$data = Registrasi::where('uuid', '=',  $request->uuid)->first();
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {
		$arr = array('cover_asuransi' => $request->cover_asuransi, 'is_pay' => 'ya');
		$update = Registrasi::where('uuid', '=',  $request->uuid)->update($arr);
		return response()->json(['hasil' => 'berhasil']);
	}

}