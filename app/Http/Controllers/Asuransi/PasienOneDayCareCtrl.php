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
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\PaketBedah;
use App\Models\ListPaketBedah;
use App\Models\RegistrasiOperasi;


class PasienOneDayCareCtrl extends Controller
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
			$data = RegistrasiOperasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('jenis_pembayaran', '=', 'Asuransi')
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
								->where('jenis', '=', 'One Day Care')
								->where('posisi', '!=', 'Selesai')
								->orderBy('id', 'desc')
								->skip($skip)->take($this->take)
								->get();
			$total = RegistrasiOperasi::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
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
								->where('posisi', '!=', 'Selesai')
								->where('jenis', '=', 'One Day Care')
								->where('jenis_pembayaran', '=', 'Asuransi')
								->orderBy('id', 'desc')->count();
		}
		else {
			$data = RegistrasiOperasi::where('delete_soft', '=', 1)
									->orderBy('id', 'desc')
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
									->where('jenis_pembayaran', '=', 'Asuransi')
									->where('jenis', '=', 'One Day Care')
									->where('posisi', '!=', 'Selesai')
									->skip($skip)->take($this->take)
									->get();

			$total = RegistrasiOperasi::where('delete_soft', '=', 1)
								->where('posisi', '!=', 'Selesai')
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
								->where('jenis', '=', 'One Day Care')->where('jenis_pembayaran', '=', 'Asuransi')->orderBy('id', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function approve(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = RegistrasiOperasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('posisi' => 'Disetujui', 'tanggal_disetujui_asuransi' => date('Y-m-d'), 'jam_disetujui_asuransi' => date('H:i'));
		
		try{
			DB::beginTransaction();

			$remove = RegistrasiOperasi::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function deny(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = RegistrasiOperasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('posisi' => 'Ditolak', 'tanggal_disetujui_asuransi' => date('Y-m-d'), 'jam_disetujui_asuransi' => date('H:i'));
		
		try{
			DB::beginTransaction();

			$remove = RegistrasiOperasi::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function dikirim(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = RegistrasiOperasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('posisi' => 'Dikirim', 'tanggal_kirim_ke_asuransi' => date('Y-m-d'), 'jam_kirim_ke_asuransi' => date('H:i'));
		
		try{
			DB::beginTransaction();

			$update = RegistrasiOperasi::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = RegistrasiOperasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			//PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('posisi' => 'Selesai', 'tanggal_pendaftaran' => date('Y-m-d'), 'jam_pendaftaran_pasien' => date('H:i'));
		
		try{
			DB::beginTransaction();

			$remove = RegistrasiOperasi::where('uuid', '=', $request->uuid)->update($arr);

			// Disini letak pendaftaran baru register baru

			$registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->select('nomor')->first();

			$nomor = 1;
			if ($registrasi) { 
				$potong_kalimat = substr($registrasi->nomor,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor += $potong_kalimat;
			}

			if ($nomor < 9) { $nomor = '0000'.$nomor; }
			else if ($nomor > 9 && $nomor < 100) { $nomor = '000'.$nomor; }
			else if ($nomor > 99 && $nomor < 1000) { $nomor = '00'.$nomor; }
			else if ($nomor > 999 && $nomor < 10000) { $nomor = '0'.$nomor; }

			$nomor = date('Y').date('m').date('d').$nomor;
			$nomor_bedah = $nomor;
			$uuid = Uuid::uuid4();
			$uuid_bedah = $uuid;
				
			$item = new Registrasi();
			$item->uuid = $uuid;
			$item->kode = 'ODC';
			$item->nomor = $nomor;
			$item->jenis = 'One Day Care';
			$item->jalur_masuk = 'Rawat Jalan';

			$item->pasien_uuid = $data->pasien_uuid;
			$item->rekam_medis = $data->rekam_medis;
			$item->nama_pasien = $data->nama_pasien;

			$item->pengguna_uuid = $data->pengguna_uuid;
			$item->nama_dokter = $data->nama_dokter;
			$item->carabayar_uuid = $data->carabayar_uuid;
			$item->carabayar_nama = $data->carabayar_nama;
			$item->asuransi_uuid = $data->asuransi_uuid;
			$item->nama_asuransi = $data->nama_asuransi;

			$reg = Registrasi::where('uuid', '=', $data->registrasi_uuid)->first();
			$item->photos = $reg->photos;
			$item->cara_masuk = $reg->cara_masuk;
			$item->rujukan = $reg->rujukan;

			$item->tanggal_lahir = $reg->tanggal_lahir;
			$item->jenis_identitas = $reg->jenis_identitas;
			$item->no_identitas = $reg->no_identitas;
			$item->jenis_kelamin = $reg->jenis_kelamin;
			$item->no_handphone = $reg->no_handphone;
			$item->agama = $reg->agama;

			$item->tanggal = date('Y-m-d');
			$item->waktu = date('H:i');
			$item->no_pendaftaran = '-';
			$item->status = 'One Day Care';
			
			$status_penjamin = '-';
			$is_approve = '-';
			$is_pay = '-';
			$is_asuransi = '-';
			if ($data->carabayar_nama != 'Umum' && $data->carabayar_nama != 'BPJS Kesehatan') {
				$status_penjamin = 'disetujui';
				$is_approve = 'ya';
				$is_pay = 'tidak';
				$is_asuransi = 'ya';
			}

			if ($data->carabayar_nama == 'Umum' || $data->carabayar_nama == 'BPJS Kesehatan') {
				$status_penjamin = 'disetujui';
				$is_approve = 'ya';
				$is_pay = 'tidak';
				$is_asuransi = 'tidak';
			}
			$item->status_penjamin = $status_penjamin;
			$item->is_approve = $is_approve;
			$item->is_pay = $is_pay;
			$item->is_asuransi = $is_asuransi;
			$item->last_position = 'Pendaftaran';
			$item->jenis_pasien = 'One Day Care';

			$kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_kwitansi', '!=', '-')->orderBy('id', 'desc')->first();
			$no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').'00001';
			$nomor_i = 1;
			if ($kwitansi) {
				$potong_kalimat = substr($kwitansi->no_invoice,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor_i += $potong_kalimat;
			}
			if ($nomor_i < 9) { $nomor_i = '0000'.$nomor_i; }
			else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
			else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
			else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
			$no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').$nomor_i;

			$invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_invoice', '!=', '-')->orderBy('id', 'desc')->first();
			$no_invoice = date('Ymd').'00001';
			$nomor_i = 1;
			if ($invoice) {
				$potong_kalimat = substr($invoice->no_invoice,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor_i += $potong_kalimat;
			}
			if ($nomor_i < 9) { $nomor_i = '0000'.$nomor_i; }
			else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
			else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
			else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
			$no_invoice = date('Ymd').$nomor_i;

			$resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_resep', '!=', '-')->orderBy('id', 'desc')->first();
			$no_resep = date('Ymd').'00001';
			$nomor_r = 1;
			if ($resep) {
				$potong_kalimat = substr($resep->no_resep,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor_r += $potong_kalimat;
			}
			if ($nomor_r < 9) { $nomor_r = '0000'.$nomor_r; }
			else if ($nomor_r > 9 && $nomor_r < 100) { $nomor_r = '000'.$nomor_r; }
			else if ($nomor_r > 99 && $nomor_r < 1000) { $nomor_r = '00'.$nomor_r; }
			else if ($nomor_r > 999 && $nomor_r < 10000) { $nomor_r = '0'.$nomor_r; }
			$no_resep = date('Ymd').$nomor_r;

			$item->no_invoice = $no_kwitansi;
			$item->no_kwitansi = $no_invoice;
			$item->no_resep = $no_resep;

			$item->registrasi_uuid_old = $data->registrasi_uuid;
			$item->kode_old = $data->registrasi_kode;
			$item->nomor_old = $data->registrasi_nomor;
			$item->jenis_old = $data->registrasi_jenis;
			$item->save();

			/* Bagian Data Bedah */
			$item = new Bedah();
			$item->uuid = Uuid::uuid4();
			$item->jenis = $data->jenis;

			$item->registrasi_uuid = $uuid_bedah;
			$item->no_pendaftaran = '-';
			$item->registrasi_kode = 'ODC';
			$item->registrasi_nomor = $nomor_bedah;
			$item->registrasi_jenis = 'One Day Care';

			$item->pasien_uuid = $data->pasien_uuid;
			$item->rekam_medis = $data->rekam_medis;
			$item->nama_pasien = $data->nama_pasien;
			$item->pengguna_uuid = $data->pengguna_uuid;
			$item->nama_dokter = $data->nama_dokter;

			$item->tanggal = $data->tanggal;
			$item->waktu = $data->waktu;

			$item->paket_uuid = $data->layanan_uuid;
			$item->nama_paket = $data->nama_layanan;
			$item->harga_paket = $data->tarif;
			$item->keterangan = $data->keterangan;
			$item->save();

			$arr = array('status' => 'One Day Care');
			$update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
			
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
		$data = RegistrasiOperasi::where('uuid', '=', $request->uuid)->first();
		$paket = PaketBedah::where('uuid', '=', $data->layanan_uuid)->first();
		$list_paket = ListPaketBedah::where('paket_bedah_uuid', '=', $data->layanan_uuid)->get();
		return response()->json(['paket' => $paket, 'list_paket' => $list_paket]);
	}

}