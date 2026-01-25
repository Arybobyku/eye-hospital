<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\AntrianFarmasi;
use App\Jobs\SendAllJob;
use Carbon\Carbon;

class FarmasiRawatInapCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->where('ada_obat', '=', 'Ya')
								->where('jenis', '=', 'Rawat Inap')
								->where(function($q){
									$q->where('status', 'Rawat Inap');
								})
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where('jenis', '=', 'Rawat Inap')
								->where(function($q){
									$q->where('status', 'Kunjungan');
								})
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where('ada_obat', '=', 'Ya')
									->where('jenis', '=', 'Rawat Inap')
									->where(function($q){
										$q->where('status', 'Rawat Inap');
									})
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where('jenis', '=', 'Rawat Inap')
								->where(function($q){
									$q->where('status', 'Rawat Inap');
								})
								->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function listbayar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_kwitansi', 'asc')
								->where('ada_obat', '=', 'Ya')
								->where('jenis', '=', 'Rawat Inap')
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->where('jenis', '=', 'Rawat Inap')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_kwitansi', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('no_kwitansi', 'asc')
									->where('ada_obat', '=', 'Ya')
									->where('jenis', '=', 'Rawat Inap')
									->where(function($q){
										$q->where('status', 'Selesai');
									})
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('ada_obat', '=', 'Ya')
								->where('jenis', '=', 'Rawat Inap')
								->where(function($q){
									$q->where('status', 'Selesai');
								})
								->orderBy('no_kwitansi', 'asc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function bayar(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menerima tagihan atas nama pasien '.$data->nama_pasien.' pada tanggal '.date('Y-m-d'));
		}

		$arr = array(
			'status_antrian_kasir' => '-', 
			'kasir_jam_selesai' => date('H:i'),
			'status_kasir' => 'Sudah Bayar',
			'status' => 'Selesai',
			'tanggal_bayar' => date('Y-m-d')
		);
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$arr = array('posisi' => 'Bayar');
		$update = LayananPasien::where('registrasi_uuid', '=', $request->uuid)->update($arr);

		$arr = array('status' => 'Aktif');
		$update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
		return response()->json(['data' => 'berhasil']);

	}

	public function detail(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obat = Resep::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();

		$obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();
		
		return response()->json(['data' => $data, 'layanan' => $layanan, 'obat' => $obat, 'obatracikan' => $obatracikan ]);
	}

	public function editobat(Request $request) {

		try{
			DB::beginTransaction();

			$obat = json_decode($request->obat);

			if (count($obat) > 0) {

				$nama_layanan = 'Obat-obatan';
				$tarif = 0;

				$delete = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

				foreach ($obat as $row) {
					$item = new Resep();
					$item->uuid = Uuid::uuid4();
					$item->registrasi_uuid = $request->registrasi_uuid;
					$item->no_pendaftaran = $request->no_pendaftaran;
					$item->registrasi_kode = $request->kode;
					$item->registrasi_nomor = $request->nomor;
					$item->registrasi_jenis = $request->jenis;
					$item->pasien_uuid = $request->pasien_uuid;
					$item->rekam_medis = $request->rekam_medis;
					$item->nama_pasien = $request->nama_pasien;
					$item->dokter_uuid = $request->pengguna_uuid;
					$item->nama_dokter = $request->nama_dokter;
								
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');

					$item->obat_uuid = $row->obat_uuid;
					$item->nama_obat = $row->nama;
					$item->kategori = $row->kategori;
					$item->formularium = $row->formularium;
					$item->golongan = $row->golongan;
					$item->satuan_uuid_besar = $row->satuan_uuid_besar;
					$item->nama_satuan_besar = $row->nama_satuan_besar;
					$item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
					$item->nama_satuan_kecil = $row->nama_satuan_kecil;
					$item->hitung_besar = $row->hitung_besar;
					$item->hitung_kecil = $row->hitung_kecil;
					$item->harga_netto = $row->harga_netto;
					$item->harga_netto_discount = $row->harga_netto_discount;
					$item->harga_netto_ppn = $row->harga_netto_ppn;
					$item->hpp = $row->hpp;
					$item->hja_resep = $row->hja_resep;
					$item->hja_non_resep = $row->hja_non_resep;
					$item->hja_resep_besar = $row->hja_resep_besar;
					$item->hja_non_resep_besar = $row->hja_non_resep_besar;
					$item->margin_resep = $row->margin_resep;
					$item->margin_non_resep = $row->margin_non_resep;
					$item->jumlah_kecil = $row->jumlah_kecil;
					$item->jumlah_besar = $row->jumlah_besar;
					$item->signa = $row->signa;
					$item->total = $row->total;
					$item->save();

					$hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
					$tarif = $tarif + $hasil;
				}

				$detele = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatan')->delete();

				$item = new LayananPasien();
				$item->uuid = Uuid::uuid4();
				$item->registrasi_uuid = $request->registrasi_uuid;
				$item->no_pendaftaran = $request->no_pendaftaran;
				$item->registrasi_kode = $request->kode;
				$item->registrasi_nomor = $request->nomor;
				$item->registrasi_jenis = $request->jenis;
				$item->pasien_uuid = $request->pasien_uuid;
				$item->rekam_medis = $request->rekam_medis;
				$item->nama_pasien = $request->nama_pasien;
				$item->pengguna_uuid = $request->pengguna_uuid;
				$item->nama_dokter = $request->nama_dokter;
							
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
						
				$item->carabayar_uuid = $request->carabayar_uuid;
				$item->carabayar_nama = $request->carabayar_nama;

				$item->layanan_uuid = 'obatan';
				$item->nama_layanan = $nama_layanan;
				$item->tarif = $tarif;
				$item->total = $tarif;
				$item->jenis = 'Obat-Obatan';
				$item->default = 'Tidak';
				$item->save();
			}
			else {
				$delete_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
				$detele_tindakan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatan')->delete();
				$cek = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatracikan')->first();
				if (!$cek) {
					$arr = array('ada_obat' => 'Tidak');
					$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				}
			}

			DB::commit();

			return response()->json(['data' => 'success']);

		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function approvement(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$arr = array('approvement_obat' => 'yes');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		
		return response()->json(['data' => 'success']);
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('status_antrian_farmasi' => '-', 'last_position' => 'Farmasi');
		$cek = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);

		$arr = array('status_antrian_farmasi' => 'active', 'farmasi_jam_layani' => date('H:i'));
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) { 
			$str = 'Farmasi 1'.'='.$request->number.'=kunjungan';
			$this->jeda(1, $str);
			return response()->json(['data' => 'success']); 
		}

		$get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']); }
		}

		$get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = AntrianFarmasi::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => '1');
		$panggil = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

		$str = 'Farmasi 1'.'='.$request->number.'=kunjungan';
		$this->jeda(1, $str);
		
		return response()->json(['data' => 'success']);
	}

	private function jeda($delay, $str) {
		$on = Carbon::now()->addSeconds($delay);
		dispatch(new SendAllJob($str))->delay($on);
	}

	public function terima(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$arr = array('approve_panjar' => '1');
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		
		return response()->json(['data' => 'success']);
	}


	public function panjar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = Registrasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')
								->where('panjar', '!=', '0')
								->where('status', '=', 'Pending')
								->where('status_dokter', '=', 'Sudah Diperiksa')
								->skip($skip)->take($this->take)
								->get();
			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', '=', 'Pending')
								->where('panjar', '!=', '0')
								->where('status_dokter', '=', 'Sudah Diperiksa')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									->where('status', '=', 'Pending')
									->where('panjar', '!=', '0')
									->where('status_dokter', '=', 'Sudah Diperiksa')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->where('status', '=', 'Pending')
								->where('panjar', '!=', '0')
								->where('status_dokter', '=', 'Sudah Diperiksa')->where('status', 'Kunjungan')->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}
}