<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\PasienTransfer;
use App\Models\AntrianPoli;

class PemeriksaanTransferCtrl extends Controller
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
								->where($column, 'ilike', '%'.$search.'%');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('transfer_pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data = $data->whereDate('tanggal', '=', date('Y-m-d'))
								->where('transfer_pengguna_uuid', '!=', '-')
								->where('status', '!=', 'Batal')
								->where('status', '!=', 'Selesai')
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1);
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('transfer_pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$total = $total->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('transfer_pengguna_uuid', '!=', '-')
								->where('status', '!=', 'Batal')
								->where('status', '!=', 'Selesai')
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'asc')
									->orderBy('status_dokter', 'asc');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$data = $data->where('transfer_pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$data = $data->whereDate('tanggal', '=', date('Y-m-d'))
									->where('transfer_pengguna_uuid', '!=', '-')
									->where('status', '!=', 'Batal')
									->where('status', '!=', 'Selesai')
								// 	->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('transfer_pengguna_uuid', '!=', '-')
								->where('status', '!=', 'Batal')
								// ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
								// ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
								// ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
								// ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
								// ->where('carabayar_nama', '!=', 'BPJS Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS-Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS_Sehat')
								// ->where('carabayar_nama', '!=', 'BPJS SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
								// ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
								// ->where('carabayar_nama', '!=', 'bpjs sehat')
								// ->where('carabayar_nama', '!=', 'bpjs-sehat')
								// ->where('carabayar_nama', '!=', 'bpjs_sehat')
								->where('status', '!=', 'Selesai');
			if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
				$total = $total->where('transfer_pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
			}
			$total = $total->orderBy('id', 'asc')
								->orderBy('status_dokter', 'asc')
								->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		$uuid = ''; $loop = false;
		do { $uuid = Uuid::uuid4(); $check = PemeriksaanDokter::where('uuid', '=', $uuid)->first(); if (!$check) { $loop = true; } }while($loop == false);

		try{
			DB::beginTransaction();

			//return response()->json(['data' => $request]);

			if ($request->uuid != '') {
				
				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid);
				if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
					$remove = $remove->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
				}		
				$remove = $remove->delete();
				$tindakan = json_decode($request->tindakan);

				foreach ($tindakan as $row) {
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
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					if ($row->default == 'Ya' || $row->default == 'YA') {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
							}
							else {
								$item->jenis = 'Administrasi';
							}
						}
						else {
							$item->jenis = 'Administrasi';
						}
					}
					else {
						$cek = explode(" ",$row->nama_tindakan_rawat_jalan);
						if (count($cek) > 0) {
							if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
								$item->jenis = 'Honor';
							}
							else if ($cek[0] == 'Administrasi') {
								$item->jenis = 'Administrasi';
							}
							else if ($cek[0] == 'Operation' || $cek[0] == 'Room') {
								$item->jenis = 'Room';
							}
							else {
								$item->jenis = 'Rawat Jalan';
							}
						}
						else {
							$item->jenis = 'Rawat Jalan';
						}
					}
					$item->default = $row->default;
					$item->save();
				}

				$arr = array(
					'transfer_status' => 'Sudah Diperiksa', 
					'transfer_jam_selesai' => date('H:i'),
				);	
			
				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

			}

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

		// $data = 

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		if ($data->transfer_jam_mulai == '-') {
			$arr = array('transfer_jam_mulai' => date('H:i'));
			$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
		}
		

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();
		
		$pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $request->uuid)
									->orderBy('id', 'desc')->first();

		$kunjungan = PemeriksaanDokter::where('registrasi_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->first();

		$layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid);
		if (Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
			$layanan = $layanan->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
		}
		$layanan = $layanan->where('nama_layanan', '!=', 'Obat-obatan')
							->where('nama_layanan', '!=', 'Obat Racikan')
							->orderBy('id', 'desc')->get();

		$apotek = $this->apotek();
		$apotekracikan = $this->apotek();
		$carabayartindakanrawatjalan = $this->carabayartindakanrawatjalan();
		$tindakanrawatjalan = $this->tindakanrawatjalan();
		$paketbedah = $this->paketbedah();
		$carabayar = $this->carabayar();
		$asuransi = $this->asuransi();
		
		return response()->json([
			'data' => $data, 
			'histori' => $histori, 
			'pemeriksaanro' => $pemeriksaanro, 
			'kunjungan' => $kunjungan, 
			'layanan' => $layanan, 
			'apotek' => $apotek,
			'apotekracikan' => $apotekracikan,
			'carabayartindakanrawatjalan' => $carabayartindakanrawatjalan,
			'tindakanrawatjalan' => $tindakanrawatjalan,
			'paketbedah' => $paketbedah,
			'carabayar' => $carabayar,
			'asuransi' => $asuransi,
		]);
	}

	private function apotek() {
		return DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
									->orderBy('harga_obat.nama','asc')
									->where('harga_obat.delete_soft', '=', '1')
									->where('stock_opname.nama_unit', '=', 'Apotek')
									->select([
										'harga_obat.id as harga_obat_id',
										'harga_obat.obat_uuid as obat_uuid',
										'harga_obat.nama as nama',
										'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
										'harga_obat.nama_satuan_besar as nama_satuan_besar',
										'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
										'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
										'harga_obat.hitung_besar as hitung_besar',
										'harga_obat.hitung_kecil as hitung_kecil',
										'harga_obat.kategori as kategori',
										'harga_obat.formularium as formularium',
										'harga_obat.golongan as golongan',
										'harga_obat.jenis as jenis',
										'harga_obat.harga_netto as harga_netto',
										'harga_obat.harga_netto_discount as harga_netto_discount',
										'harga_obat.harga_netto_ppn as harga_netto_ppn',
										'harga_obat.hpp as hpp',
										'harga_obat.margin_resep as margin_resep',
										'harga_obat.margin_non_resep as margin_non_resep',
										'harga_obat.hja_resep as hja_resep',
										'harga_obat.hja_resep_besar as hja_resep_besar',
										'harga_obat.hja_non_resep as hja_non_resep',
										'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
										'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
										'stock_opname.nama_satuan_besar as nama_satuan_besar',
										'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
										'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
										'stock_opname.hitung_besar as hitung_besar',
										'stock_opname.hitung_kecil as hitung_kecil',
										'stock_opname.jumlah_kecil as jumlah_kecil',
										'stock_opname.jumlah_besar as jumlah_besar',
										'stock_opname.nama_unit as nama_unit'
									])
									->where('stock_opname.jumlah_kecil', '>', 0)
									->get();
	}

	private function paketbedah() {
		return DB::table('paket_bedah')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayartindakanrawatjalan() {
		return DB::table('carabayar_tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function tindakanrawatjalan() {
		return DB::table('tindakan_rawat_jalan')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function carabayar() {
		return DB::table('carabayar')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

	private function asuransi() {
		return DB::table('asuransi')->orderBy('id','asc')->where('delete_soft', '=', '1')->get();
	}

}