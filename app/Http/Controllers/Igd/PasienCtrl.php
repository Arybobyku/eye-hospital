<?php

namespace App\Http\Controllers\Igd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pasien;
use App\Models\Registrasi;

class PasienCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;
				$data = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->orderBy('rekam_medis', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->orderBy('rekam_medis', 'desc')->count();
			}
			else if ($column == 'tanggal_lahir') {
				$data = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->orderBy('id', 'desc')->count();
			}
			else {
				$data = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('rekam_medis', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('rekam_medis', 'desc')->count();
			}
		}
		else {
			$data = Pasien::where('delete_soft', '=', 1)
									->orderBy('rekam_medis', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Pasien::where('delete_soft', '=', 1)->orderBy('rekam_medis', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pasien dengan nama pasien "'.$request->nama.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = Pasien::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			$pasien = Pasien::where('tahun', '=', date('y'))->orderBy('nomor', 'desc')->first();
			$nomor = 1;
			if ($pasien) { $nomor += $pasien->nomor; }
			$rekam_medis = date('y').''.date('m');
			$angka_nol = '-';
			if ($nomor < 10) { $angka_nol = '0000'; $rekam_medis .= '0000'.$nomor; }
			else if ($nomor > 9 && $nomor < 100) { $angka_nol = '000'; $rekam_medis .= '000'.$nomor; }
			else if ($nomor > 99 && $nomor < 1000) { $angka_nol = '00'; $rekam_medis .= '00'.$nomor; }
			else if ($nomor > 999 && $nomor < 10000) { $angka_nol = '0'; $rekam_medis .= '0'.$nomor; }
			else if ($nomor > 9999 && $nomor < 100000) { $angka_nol = '-'; $rekam_medis .= $nomor; }

			$item = new Pasien();
			$item->uuid = $uuid;
			$item->rekam_medis = $rekam_medis;
			$item->tahun = date('y');
			$item->bulan = date('m');
			$item->angka_nol = $angka_nol;
			$item->nomor = $nomor;
			$item->nama = $request->nama;
			$item->alias = $request->alias ? $request->alias : '-';
			$item->tempat_lahir = $request->tempat_lahir;
			$item->tanggal_lahir = $request->tanggal_lahir;
			$item->no_identitas = $request->no_identitas;
			$item->email = $request->email ? $request->email : '-';
			$item->alamat = $request->alamat ? $request->alamat : '-';
			$item->no_handphone = $request->no_handphone ? $request->no_handphone : '-';
			$item->kodepos = $request->kodepos ? $request->kodepos : '-';
			$item->rt_rw = $request->rt_rw ? $request->rt_rw : '-';
			$item->nama_ayah = $request->nama_ayah ? $request->nama_ayah : '-';
			$item->nama_ibu = $request->nama_ibu ? $request->nama_ibu : '-';
			$item->provinsi_id = $request->provinsi_id ? $request->provinsi_id : 0;
			$item->nama_provinsi = $request->nama_provinsi && $request->nama_provinsi != 'Silahkan Pilih' ? $request->nama_provinsi : '-';
			$item->kab_kota_id = $request->kab_kota_id ? $request->kab_kota_id : 0;
			$item->nama_kab_kota = $request->nama_kab_kota && $request->nama_kab_kota != 'Silahkan Pilih' ? $request->nama_kab_kota : '-';
			$item->kecamatan_id = $request->kecamatan_id ? $request->kecamatan_id : 0;
			$item->nama_kecamatan = $request->nama_kecamatan && $request->nama_kecamatan != 'Silahkan Pilih' ? $request->nama_kecamatan : '-';
			$item->kelurahan_id = $request->kelurahan_id ? $request->kelurahan_id : 0;
			$item->nama_kelurahan = $request->nama_kelurahan && $request->nama_kelurahan != 'Silahkan Pilih' ? $request->nama_kelurahan : '-';
			$item->pendidikan_terakhir = $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '-';
			$item->pekerjaan = $request->pekerjaan ? $request->pekerjaan : '-';
			$item->status_pernikahan = $request->status_pernikahan ? $request->status_pernikahan : '-';
			$item->agama = $request->agama ? $request->agama : '-';
			$item->jenis_kelamin = $request->jenis_kelamin;
			$item->jenis_identitas = $request->jenis_identitas;
			$item->golongan_darah = $request->golongan_darah ? $request->golongan_darah : '-';
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

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		}
		
		return response()->json(['data' => $data]);
	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman detail pasien');
		}

		$registrasi = Registrasi::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->limit(12)->get();
		
		return response()->json(['data' => $data, 'registrasi' => $registrasi]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "'.$request->nama.'".');

		$arr = array(
			'nama' => $request->nama,
			'alias' => $request->alias ? $request->alias : '-',
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $request->tanggal_lahir,
			'no_identitas' => $request->no_identitas,
			'email' => $request->email ? $request->email : '-',
			'alamat' => $request->alamat ? $request->alamat : '-',
			'no_handphone' => $request->no_handphone ? $request->no_handphone : '-',
			'kodepos' => $request->kodepos ? $request->kodepos : '-',
			'rt_rw' => $request->rt_rw ? $request->rt_rw : '-',
			'nama_ayah' => $request->nama_ayah ? $request->nama_ayah : '-',
			'nama_ibu' => $request->nama_ibu ? $request->nama_ibu : '-',
			'provinsi_id' => $request->provinsi_id ? $request->provinsi_id : 0,
			'nama_provinsi' => $request->nama_provinsi && $request->nama_provinsi != 'Silahkan Pilih' ? $request->nama_provinsi : '-',
			'kab_kota_id' => $request->kab_kota_id ? $request->kab_kota_id : 0,
			'nama_kab_kota' => $request->nama_kab_kota && $request->nama_kab_kota != 'Silahkan Pilih' ? $request->nama_kab_kota : '-',
			'kecamatan_id' => $request->kecamatan_id ? $request->kecamatan_id : 0,
			'nama_kecamatan' => $request->nama_kecamatan && $request->nama_kecamatan != 'Silahkan Pilih' ? $request->nama_kecamatan : 0,
			'kelurahan_id' => $request->kelurahan_id ? $request->kelurahan_id : '-',
			'nama_kelurahan' => $request->nama_kelurahan && $request->nama_kelurahan != 'Silahkan Pilih' ? $request->nama_kelurahan : '-',
			'pendidikan_terakhir' => $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '-',
			'pekerjaan' => $request->pekerjaan ? $request->pekerjaan : '-',
			'status_pernikahan' => $request->status_pernikahan ? $request->status_pernikahan : '-',
			'agama' => $request->agama ? $request->agama : '-',
			'jenis_kelamin' => $request->jenis_kelamin,
			'jenis_identitas' => $request->jenis_identitas,
			'golongan_darah' => $request->golongan_darah ? $request->golongan_darah : '-'
		);

		try{
			DB::beginTransaction();

			$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);
			
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
		$data = Pasien::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->limit(15)->get();
		return response()->json(['data' => $data]);
	}

}