<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Biodata;
use App\Models\LogPengguna;

class ProfileCtrl extends Controller
{

	private $take = 10, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function data(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat halaman data profile');

		$biodata = DB::table('biodata')->orderBy('id','asc')->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))->first();
		$logpengguna = DB::table('log_pengguna')->orderBy('id','desc')
										->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
										->limit(15)
										->get();
		
		return response()->json([
			'biodata' => $biodata,
			'logpengguna' => $logpengguna,
		]);
	}

	public function edit(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$biodata = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->first();
		if ($biodata) {
			PenggunaHelp::log('Mengambil data pengguna dengan nama "'.$biodata->nama_pengguna.'" dan id "'.$biodata->id.'" untuk ditampilkan dihalaman edit pengguna');
		}
		
		return response()->json(['biodata' => $biodata]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$username = Pengguna::where('username', '=', $request->username)->first();
		if ($username) { return response()->json(['data' => 'username']); }

		PenggunaHelp::log('Mengupdate data profile milik sendiri.');

		$arr_pengguna = array(
			'nama' => $request->nama_pengguna,
			'email' => $request->email_pengguna
		);

		$arr_biodata = array(
			'sebagai_pengguna' => $request->sebagai_pengguna,
			'nama_pengguna' => $request->nama_pengguna,
			'email_pengguna' => $request->email_pengguna,
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $request->tanggal_lahir,
			'jenis_kelamin' => $request->jenis_kelamin,
			'agama' => $request->agama,
			'status_pernikahan' => $request->status_pernikahan ? $request->status_pernikahan : '',
			'pendidikan_terakhir' => $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '',
			'golongan_darah' => $request->golongan_darah ? $request->golongan_darah : '',
			'no_handphone' => $request->no_handphone,
			'ktp' => $request->ktp,
			'sima' => $request->sima ? $request->sima : '',
			'simc' => $request->simc ? $request->simc : '',
			'passpor' => $request->passpor ? $request->passpor : '',
			'npwp' => $request->npwp ? $request->npwp : '',
			'alamat' => $request->alamat,
			'provinsi_id' => $request->provinsi_id,
			'nama_provinsi' => $request->nama_provinsi,
			'kab_kota_id' => $request->kab_kota_id,
			'nama_kab_kota' => $request->nama_kab_kota,
			'kecamatan_id' => $request->kecamatan_id,
			'nama_kecamatan' => $request->nama_kecamatan,
			'kelurahan_id' => $request->kelurahan_id,
			'nama_kelurahan' => $request->nama_kelurahan,
			'kodepos' => $request->kodepos ? $request->kodepos : '',
			'rt_rw' => $request->rt_rw ? $request->rt_rw : '',
			'darurat_nama' => $request->darurat_nama ? $request->darurat_nama : '',
			'darurat_jenis_kelamin' => $request->darurat_jenis_kelamin ? $request->darurat_jenis_kelamin : '',
			'darurat_no_handphone' => $request->darurat_no_handphone ? $request->darurat_no_handphone : '',
			'darurat_hubungan' => $request->darurat_hubungan ? $request->darurat_hubungan : '',
			'bank_nama' => $request->bank_nama ? $request->bank_nama : '',
			'bank_an' => $request->bank_an ? $request->bank_an : '',
			'bank_norek' => $request->bank_norek ? $request->bank_norek : ''
		);

		try{
			DB::beginTransaction();

			$update_pengguna = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr_pengguna);
			$update_biodata = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->update($arr_biodata);

			Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Sebagai'));

			$minutes = time() + 60 * 60 * 10; // 10 jam
			Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Sebagai', Crypt::encrypt($request->sebagai_pengguna), $minutes));
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function password(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		if ($request->confirm_password != $request->password_baru) { return response()->json(['hasil' => 'notsame']); }

		PenggunaHelp::log('Merubah data password sendiri');
		
		$pengguna = Pengguna::where('uuid', '=', $request->pengguna_uuid)->first();
		$arr_pengguna = array('password' => bcrypt($request->password_baru));

		if (\Hash::check($request->password_lama, $pengguna->password)) {
			try{
				DB::beginTransaction();
	
				$update_pengguna = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr_pengguna);
				
				DB::commit();
	
				return response()->json(['data' => 'berhasil']);
			}
			catch(Exception $e){ 
				DB::rollback(); 
				return response()->json(['hasil' => 'gagal']);
			}
		}

		return response()->json(['hasil' => 'wrong']);
	}

}