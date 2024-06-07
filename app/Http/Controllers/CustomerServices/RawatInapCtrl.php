<?php

namespace App\Http\Controllers\CustomerServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;

use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\PenanggungJawab;
use App\Models\LayananPasien;
use App\Models\CaraBayarKamar;
use App\Models\KamarInap;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;

class RawatInapCtrl extends Controller
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
								//->where('status', 'Rawat Inap')
								//->where('masuk_kamar', '=', '-')
								->skip($skip)->take($this->take)
								->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								//->where('status', 'Rawat Inap')
								//->where('masuk_kamar', '=', '-')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = Registrasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
									// ->where('status', 'Rawat Inap')
									// ->where('masuk_kamar', '=', '-')
									->skip($skip)->take($this->take)
									->get();

			$total = Registrasi::where('delete_soft', '=', 1)
								// ->where('status', 'Rawat Inap')
								// ->where('masuk_kamar', '=', '-')
								->orderBy('id', 'desc')
								->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function registrasi(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		try{

			$cekkamar = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->first();

			if ($cekkamar->sisa > 0) {

				DB::beginTransaction();

				$kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
											->where('carabayar_uuid', '=', $request->carabayar_uuid)->first();
				$harga = 0;
				if ($kamar) {
					$harga = $kamar->harga;
				}

				$registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
												->where('no_gelang', '!=', '-')->orderBy('id', 'desc')->first();

				$nomor = 1;
				if ($registrasi) { 
					$potong_kalimat = substr($registrasi->no_gelang,-5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor += $potong_kalimat;
				}

				if ($nomor < 9) { $nomor = '0000'.$nomor; }
				else if ($nomor > 9 && $nomor < 100) { $nomor = '000'.$nomor; }
				else if ($nomor > 99 && $nomor < 1000) { $nomor = '00'.$nomor; }
				else if ($nomor > 999 && $nomor < 10000) { $nomor = '0'.$nomor; }

				$nomor = date('Y').date('m').date('d').$nomor;				

				$arr = array('sisa' => ((int)$cekkamar->sisa - 1));
				$update = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->update($arr);
				
				$reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

				$item = new LayananPasien();
				$item->uuid = Uuid::uuid4();
				$item->registrasi_uuid = $reg->uuid;
				$item->no_pendaftaran = $reg->no_pendaftaran;
				$item->registrasi_kode = $reg->kode;
				$item->registrasi_nomor = $reg->nomor;
				$item->registrasi_jenis = $reg->jenis;
				$item->pasien_uuid = $reg->pasien_uuid;
				$item->rekam_medis = $reg->rekam_medis;
				$item->nama_pasien = $reg->nama_pasien;
				$item->pengguna_uuid = $reg->pengguna_uuid;
				$item->nama_dokter = $reg->nama_dokter;
							
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
						
				$item->carabayar_uuid = $reg->carabayar_uuid;
				$item->carabayar_nama = $reg->carabayar_nama;

				$item->layanan_uuid = $request->jenis_kamar_uuid;
				$item->nama_layanan = $request->nama_jenis_kamar;
				$item->tarif = $harga;
				$item->total = $harga;
				$item->jenis = 'Kamar Inap';
				$item->save();

				$arr = array(
					'masuk_kamar' => 'ya',
					'no_gelang' => $nomor,
					'kamar_inap_uuid' => $request->kamar_inap_uuid,
					'kamar_inap_nama' => $request->kamar_inap_nama,
					'kamar_inap_lantai' => $request->kamar_inap_lantai,
					'kamar_inap_jumlah_bed' => $request->kamar_inap_jumlah_bed,
					'jenis_kamar_uuid' => $request->jenis_kamar_uuid,
					'nama_jenis_kamar' => $request->nama_jenis_kamar,
					'harga_kamar' => $harga
				);


				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				
				DB::commit();

				return response()->json(['data' => 'berhasil']);
			}

			return response()->json(['data' => 'full']);
			
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function pindahkamar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		try{

			$cekkamar = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->first();

			if ($cekkamar->sisa > 0) {

				DB::beginTransaction();

				$remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
					->where('jenis', '=', 'Kamar Inap')->delete();

				$kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
											->where('carabayar_uuid', '=', $request->carabayar_uuid)->first();
				$harga = 0;
				if ($kamar) {
					$harga = $kamar->harga;
				}

				$arr = array('sisa' => ((int)$cekkamar->sisa - 1));
				$update = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->update($arr);
				
				$reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

				$arr = array('sisa' => ((int)$cekkamar->sisa + 1));
				$update = KamarInap::where('uuid', '=', $reg->kamar_inap_uuid)->update($arr);

				$item = new LayananPasien();
				$item->uuid = Uuid::uuid4();
				$item->registrasi_uuid = $reg->uuid;
				$item->no_pendaftaran = $reg->no_pendaftaran;
				$item->registrasi_kode = $reg->kode;
				$item->registrasi_nomor = $reg->nomor;
				$item->registrasi_jenis = $reg->jenis;
				$item->pasien_uuid = $reg->pasien_uuid;
				$item->rekam_medis = $reg->rekam_medis;
				$item->nama_pasien = $reg->nama_pasien;
				$item->pengguna_uuid = $reg->pengguna_uuid;
				$item->nama_dokter = $reg->nama_dokter;
							
				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
						
				$item->carabayar_uuid = $reg->carabayar_uuid;
				$item->carabayar_nama = $reg->carabayar_nama;

				$item->layanan_uuid = $request->jenis_kamar_uuid;
				$item->nama_layanan = $request->nama_jenis_kamar;
				$item->tarif = $harga;
				$item->total = $harga;
				$item->jenis = 'Kamar Inap';
				$item->save();

				$arr = array(
					'kamar_inap_uuid' => $request->kamar_inap_uuid,
					'kamar_inap_nama' => $request->kamar_inap_nama,
					'kamar_inap_lantai' => $request->kamar_inap_lantai,
					'kamar_inap_jumlah_bed' => $request->kamar_inap_jumlah_bed,
					'jenis_kamar_uuid' => $request->jenis_kamar_uuid,
					'nama_jenis_kamar' => $request->nama_jenis_kamar,
					'harga_kamar' => $harga
				);


				$update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
				
				DB::commit();

				return response()->json(['data' => 'berhasil']);
			}

			return response()->json(['data' => 'full']);
			
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

}