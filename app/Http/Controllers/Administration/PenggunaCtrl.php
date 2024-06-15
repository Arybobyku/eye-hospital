<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Biodata;
use App\Models\Label;
use App\Models\HakAkses;

class PenggunaCtrl extends Controller
{

	private $take = 10, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pengguna');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;
				$data = Biodata::where('delete_soft', '=', 1)
								->whereYear($column, '=', $tahun)
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->where('id', '!=', '5')
								->get();
				$total = Biodata::where('delete_soft', '=', 1)
								->whereYear($column, '=', $tahun)
								->where('id', '!=', '5')
								->orderBy('id', 'desc')->count();
			}
			else if ($column == 'posisi_pengguna') {
				$posisi = strtolower($search) == 'dokter' ? '8808' : '8807';
				$data = Biodata::where('delete_soft', '=', 1)
								->where($column, '=', $posisi)
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->where('id', '!=', '5')
								->get();
				$total = Biodata::where('delete_soft', '=', 1)
								->where($column, '=', $posisi)
								->where('id', '!=', '5')
								->orderBy('id', 'desc')->count();
			}
			else if ($column == 'tanggal_lahir') {
				$data = Biodata::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->orderBy('id', 'desc')
								->where('id', '!=', '5')
								->skip($skip)->take($this->take)
								->get();
				$total = Biodata::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('id', '!=', '5')
								->orderBy('id', 'desc')->count();
			}
			else {
				$data = Biodata::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('id', '!=', '5')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Biodata::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('id', '!=', '5')
								->orderBy('id', 'desc')->count();
			}
			
		}
		else {
			$data = Biodata::where('delete_soft', '=', 1)
									->where('id', '!=', '5')
									->orderBy('id', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Biodata::where('delete_soft', '=', 1)->where('id', '!=', '5')->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$username = Pengguna::where('username', '=', $request->username)->first();
		if ($username) { return response()->json(['data' => 'username']); }

		PenggunaHelp::log('Menambahkan data pengguna dengan nama "'.$request->nama.'".');

		$uuid = ''; $loop = false; $pengguna_uuid = '';
		do { $uuid = Uuid::uuid4(); $check = Pengguna::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();
			$pengguna_uuid = $uuid;
			$item = new Pengguna();
			$item->uuid = $uuid;
			$item->nama = $request->nama_pengguna;
			$item->username = $request->username_pengguna;
			$item->password = bcrypt('12345');
			$item->posisi = $request->posisi_pengguna;
			$item->sebagai = $request->sebagai_pengguna;
			$item->email = $request->email_pengguna;
			$item->save();

			$pengguna_id = $item->id;

			$uuid = ''; $loop = false;
			do { $uuid = Uuid::uuid4(); $check = Biodata::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

			$item = new Biodata();
			$item->uuid = $uuid;
			$item->pengguna_id = $pengguna_id;
			$item->pengguna_uuid = $pengguna_uuid;
			$item->nama_pengguna = $request->nama_pengguna;
			$item->username_pengguna = $request->username_pengguna;
			$item->posisi_pengguna = $request->posisi_pengguna;
			$item->sebagai_pengguna = $request->sebagai_pengguna;
			$item->email_pengguna = $request->email_pengguna;
			$item->tempat_lahir = $request->tempat_lahir;
			$item->tanggal_lahir = $request->tanggal_lahir;
			$item->jenis_kelamin = $request->jenis_kelamin;
			$item->agama = $request->agama;
			$item->status_pernikahan = $request->status_pernikahan ? $request->status_pernikahan : '';
			$item->pendidikan_terakhir = $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '';
			$item->golongan_darah = $request->golongan_darah ? $request->golongan_darah : '';
			$item->no_handphone = $request->no_handphone;
			$item->ktp = $request->ktp;
			$item->sima = $request->sima ? $request->sima : '';
			$item->simc = $request->simc ? $request->simc : '';
			$item->passpor = $request->passpor ? $request->passpor : '';
			$item->npwp = $request->npwp ? $request->npwp : '';
			$item->alamat = $request->alamat;
			$item->provinsi_id = $request->provinsi_id;
			$item->nama_provinsi = $request->nama_provinsi;
			$item->kab_kota_id = $request->kab_kota_id;
			$item->nama_kab_kota = $request->nama_kab_kota;
			$item->kecamatan_id = $request->kecamatan_id;
			$item->nama_kecamatan = $request->nama_kecamatan;
			$item->kelurahan_id = $request->kelurahan_id;
			$item->nama_kelurahan = $request->nama_kelurahan;
			$item->kodepos = $request->kodepos ? $request->kodepos : '';
			$item->rt_rw = $request->rt_rw ? $request->rt_rw : '';
			$item->darurat_nama = $request->darurat_nama ? $request->darurat_nama : '';
			$item->darurat_no_handphone = $request->darurat_no_handphone ? $request->darurat_no_handphone : '';
			$item->darurat_hubungan = $request->darurat_hubungan ? $request->darurat_hubungan : '';
			$item->bank_nama = $request->bank_nama ? $request->bank_nama : '';
			$item->bank_an = $request->bank_an ? $request->bank_an : '';
			$item->bank_norek = $request->bank_norek ? $request->bank_norek : '';
			$item->mulai_bekerja = $request->mulai_bekerja;
			$item->bpjs_ketenagakerjaan = $request->bpjs_ketenagakerjaan ? $request->bpjs_ketenagakerjaan : '';
			$item->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan ? $request->no_bpjs_ketenagakerjaan : '';
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

		$data = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pengguna dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pengguna');
		}
		
		return response()->json(['data' => $data]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$username = Pengguna::where('username', '=', $request->username)->first();
		if ($username) { return response()->json(['data' => 'username']); }

		PenggunaHelp::log('Mengupdate data pengguna dengan nama "'.$request->nama.'".');

		$arr_pengguna = array(
			'nama' => $request->nama_pengguna,
			'username' => $request->username_pengguna,
			'posisi' => $request->posisi_pengguna,
			'sebagai' => $request->sebagai_pengguna,
			'email' => $request->email_pengguna
		);

		$arr_biodata = array(
			'nama_pengguna' => $request->nama_pengguna,
			'username_pengguna' => $request->username_pengguna,
			'posisi_pengguna' => $request->posisi_pengguna,
			'sebagai_pengguna' => $request->sebagai_pengguna,
			'email_pengguna' => $request->email_pengguna,
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $request->tanggal_lahir,
			'jenis_kelamin' => $request->jenis_kelamin,
			'agama' => $request->agama,
			'status_pernikahan' => $request->status_pernikahan,
			'pendidikan_terakhir' => $request->pendidikan_terakhir,
			'golongan_darah' => $request->golongan_darah,
			'no_handphone' => $request->no_handphone,
			'ktp' => $request->ktp,
			'sima' => $request->sima,
			'simc' => $request->simc,
			'passpor' => $request->passpor,
			'npwp' => $request->npwp,
			'alamat' => $request->alamat,
			'provinsi_id' => $request->provinsi_id,
			'nama_provinsi' => $request->nama_provinsi,
			'kab_kota_id' => $request->kab_kota_id,
			'nama_kab_kota' => $request->nama_kab_kota,
			'kecamatan_id' => $request->kecamatan_id,
			'nama_kecamatan' => $request->nama_kecamatan,
			'kelurahan_id' => $request->kelurahan_id,
			'nama_kelurahan' => $request->nama_kelurahan,
			'kodepos' => $request->kodepos,
			'rt_rw' => $request->rt_rw,
			'darurat_nama' => $request->darurat_nama,
			'darurat_no_handphone' => $request->darurat_no_handphone,
			'darurat_hubungan' => $request->darurat_hubungan,
			'bank_nama' => $request->bank_nama,
			'bank_an' => $request->bank_an,
			'bank_norek' => $request->bank_norek,
			'mulai_bekerja' => $request->mulai_bekerja,
			'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
			'no_bpjs_ketenagakerjaan' => $request->no_bpjs_ketenagakerjaan
		);

		try{
			DB::beginTransaction();

			$update_pengguna = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr_pengguna);
			$update_biodata = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->update($arr_biodata);
			
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

		$data = Pengguna::where('uuid', '=', $request->pengguna_uuid)->first();
		if ($data) {
			PenggunaHelp::log('Memblokir data pengguna dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array(
			'status' => 'block',
			'delete_soft' => 0
		);
		
		try{
			DB::beginTransaction();

			$block = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr);
			$block = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function active(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Pengguna::where('uuid', '=', $request->pengguna_uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengaktifkan data pengguna dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array(
			'status' => 'active',
			'delete_soft' => 1
		);
		
		try{
			DB::beginTransaction();

			$active = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr);
			$active = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function reset(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Pengguna::where('uuid', '=', $request->pengguna_uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mereset password data pengguna dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('password' => bcrypt('12345'));
		
		try{
			DB::beginTransaction();

			$reset = Pengguna::where('uuid', '=', $request->pengguna_uuid)->update($arr);
			
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

		$data = Biodata::where('status', '=', 'active')->where('id', '!=', '5')->where('nama_pengguna', 'ilike', '%'.$request->keyword.'%')->limit(10)->get();
		return response()->json(['data' => $data]);
	}

	public function dokter(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Biodata::where('status', '=', 'active')
							->where('nama_pengguna', 'ilike', '%'.$request->keyword.'%')
							->where('posisi', '=', '8808')
							->limit(10)->get();
		return response()->json(['data' => $data]);
	}

	public function look(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->first();
		$hakakses = Label::where('status', '=', 'active')->where('id', '!=', 50)->orderby('based', 'asc')->get();
		$userakses = HakAkses::where('pengguna_uuid', '=', $request->pengguna_uuid)->get();

		if ($data) {
			PenggunaHelp::log('Mengambil data hak akses pengguna dengan nama "'.$data->nama_pengguna.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit hak akses');
		}
		
		return response()->json(['hakakses' => $hakakses, 'userakses' => $userakses, 'pengguna' => $data]);
	}

	public function updatehakakses(Request $request) {
		$data = json_decode($request->hakakses);
		$remove = HakAkses::where('pengguna_uuid', '=', $request->pengguna_uuid)->delete();
		if (count($data) > 0) {
			
			$str = "INSERT INTO hak_akses(uuid, pengguna_uuid, nama_pengguna, username_pengguna, label_uuid, label_based, label_nama, label_icon, label_link, label_posisi) VALUES";
			foreach ($data as $key => $value) {
				$str .= "('".Uuid::uuid4()."','".$request->pengguna_uuid."', '".$request->nama_pengguna."', '".$request->username_pengguna."',
				'".$value->uuid."', '".$value->based."', '".$value->nama."', '".$value->icon."', '".$value->link."', '".$value->posisi."'),";
			}
			$str = substr($str, 0, -1);
			$str .= ';';
			$save = DB::insert($str);
		}
		
		
		return response()->json(['data' => 'berhasil']);
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Biodata::where('pengguna_uuid', '=', $request->pengguna_uuid)->first();

		if ($data) {
			PenggunaHelp::log('Mengambil data pengguna dengan nama "'.$data->nama_pengguna.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman detail pengguna');
		}
		
		return response()->json(['detail' => $data]);
	}

}