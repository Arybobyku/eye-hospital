<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PDF;
use PenggunaHelp;

use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\LayananPasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\SuratIstirahat;
use App\Models\SuratKonsul;
use App\Models\SuratBalasanKonsul;
use App\Models\ResepKacamata;
use App\Models\Bedah;
use App\Models\AntrianPoli;
use App\Events\NewTradeAll;
use App\Models\Pasien;

class CetakanCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function suratistirahat(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		try{
			DB::beginTransaction();

			//$remove = SuratIstirahat::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
			$surat_ke = 1;
			$cek = SuratIstirahat::select('surat_ke')->orderBy('id','desc')->first();
			if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }

			if ($surat_ke > 9999) { $surat_ke = 1; }

			$item = new SuratIstirahat();
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

			$item->jumlah_hari = $request->jumlah_hari;
			$item->mulai_tanggal = $request->mulai_tanggal;
			$item->sampai_tanggal = $request->sampai_tanggal;
			$item->diagnosa = $request->diagnosa;
			$item->surat_ke = $surat_ke;
			$item->save();

			DB::commit();

			$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
			$suratistirahat = SuratIstirahat::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratkonsul = SuratKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratbalasankonsul = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratresepkacamata = ResepKacamata::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
		
			return response()->json([
				'data' => $data,
				'suratistirahat' => $suratistirahat,
				'suratkonsul' => $suratkonsul,
				'suratbalasankonsul' => $suratbalasankonsul,
				'suratresepkacamata' => $suratresepkacamata,
			]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function suratkonsul(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		try{
			DB::beginTransaction();

			// $remove = SuratKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
			$surat_ke = 1;
			$cek = SuratKonsul::select('surat_ke')->orderBy('id','desc')->first();
			if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }

			if ($surat_ke > 9999) { $surat_ke = 1; }

			$item = new SuratKonsul();
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

			$item->yth = $request->yth;
			$item->di = $request->di;
			$item->diagnosa = $request->diagnosa;
			$item->tindakan = $request->tindakan;
			$item->surat_ke = $surat_ke;
			$item->save();

			DB::commit();

			$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
			$suratistirahat = SuratIstirahat::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratkonsul = SuratKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratbalasankonsul = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratresepkacamata = ResepKacamata::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();

			return response()->json([
				'data' => $data,
				'suratistirahat' => $suratistirahat,
				'suratkonsul' => $suratkonsul,
				'suratbalasankonsul' => $suratbalasankonsul,
				'suratresepkacamata' => $suratresepkacamata,
			]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function suratbalasankonsul(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		try{
			DB::beginTransaction();

			// $remove = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete()
			$surat_ke = 1;
			$cek = SuratBalasanKonsul::select('surat_ke')->orderBy('id','desc')->first();
			if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }
			
			if ($surat_ke > 9999) { $surat_ke = 1; }

			$item = new SuratBalasanKonsul();
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

			$item->yth = $request->yth;
			$item->di = $request->di;
			$item->diagnosa = $request->diagnosa;
			$item->tindakan = $request->tindakan;
			$item->surat_ke = $surat_ke;
			$item->save();

			DB::commit();

			$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
			$suratistirahat = SuratIstirahat::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratkonsul = SuratKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratbalasankonsul = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratresepkacamata = ResepKacamata::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();

			return response()->json([
				'data' => $data,
				'suratistirahat' => $suratistirahat,
				'suratkonsul' => $suratkonsul,
				'suratbalasankonsul' => $suratbalasankonsul,
				'suratresepkacamata' => $suratresepkacamata,
			]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function resepkacamatas(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "'.$request->nama_pasien.'".');

		try{
			DB::beginTransaction();

			// $remove = ResepKacamata::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
			$surat_ke = 1;
			$cek = ResepKacamata::select('surat_ke')->orderBy('id','desc')->first();
			if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }

			if ($surat_ke > 9999) { $surat_ke = 1; }

			$item = new ResepKacamata();
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

			$item->m1 = $request->m1;
			$item->m2 = $request->m2;
			$item->r1 = $request->r1;
			$item->r2 = $request->r2;
			$item->r3 = $request->r3;
			$item->r4 = $request->r4;
			$item->surat_ke = $surat_ke;
			$item->save();

			DB::commit();

			$data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
			$suratistirahat = SuratIstirahat::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratkonsul = SuratKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratbalasankonsul = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();
			$suratresepkacamata = ResepKacamata::where('registrasi_uuid', '=', $request->registrasi_uuid)->orderBy('id', 'desc')->first();

			return response()->json([
				'data' => $data,
				'suratistirahat' => $suratistirahat,
				'suratkonsul' => $suratkonsul,
				'suratbalasankonsul' => $suratbalasankonsul,
				'suratresepkacamata' => $suratresepkacamata,
			]);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	
	public function printsuratistirahat($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$surat = SuratIstirahat::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
    
    $pdf->loadView('print.printketerangansakit', compact('registrasi', 'surat'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
  }

	public function printsuratkonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = SuratKonsul::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
		$keluhan_utama = '';
		if ($ro) { $keluhan_utama = $ro->keluhan_utama; }
    
    $pdf->loadView('print.printkonsul', compact('registrasi', 'biodata', 'surat', 'keluhan_utama'))->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

	public function printsuratbalasankonsul($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = SuratBalasanKonsul::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
		$keluhan_utama = '';
		if ($ro) { $keluhan_utama = $ro->keluhan_utama; }
    
    $pdf->loadView('print.printbalasankonsul', compact('registrasi', 'biodata', 'surat', 'keluhan_utama'))->setPaper('a4', 'potrait');

		
    return $pdf->stream();
  }

	public function printresepkacamata($uuid)
  {
    $pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('uuid', '=', $uuid)->first();
		$biodata = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->select('tanggal_lahir')->first();
		$surat = ResepKacamata::where('registrasi_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$ro = PemeriksaanRo::where('registrasi_uuid', '=', $uuid)->first();
    
    $pdf->loadView('print.printresepkacamata', compact('registrasi', 'biodata', 'surat', 'ro'))->setPaper('a4', 'potrait');

    return $pdf->stream();
  }

	public function cetakan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();

		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$suratistirahat = SuratIstirahat::where('registrasi_uuid', '=', $request->uuid)->orderBy('id', 'desc')->first();
		$suratkonsul = SuratKonsul::where('registrasi_uuid', '=', $request->uuid)->orderBy('id', 'desc')->first();
		$suratbalasankonsul = SuratBalasanKonsul::where('registrasi_uuid', '=', $request->uuid)->orderBy('id', 'desc')->first();
		$suratresepkacamata = ResepKacamata::where('registrasi_uuid', '=', $request->uuid)->orderBy('id', 'desc')->first();

		return response()->json([
			'data' => $data,
			'suratistirahat' => $suratistirahat,
			'suratkonsul' => $suratkonsul,
			'suratbalasankonsul' => $suratbalasankonsul,
			'suratresepkacamata' => $suratresepkacamata,
		]);
	}

	public function histori(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
		}

		$histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
									->orderBy('id', 'desc')->limit(12)->get();
		
		return response()->json(['data' => $data, 'histori' => $histori]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama,
				'kode' => $request->kode
		);

		try{
			DB::beginTransaction();

			$update = Icd9::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function remove(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Icd9::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data icd 9 dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Icd9::where('uuid', '=', $request->uuid)->update($arr);
			
			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('status_antrian_dokter' => '-');
		$cek = Registrasi::where('pengguna_uuid', '=', $request->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

		$arr = array('status_antrian_dokter' => 'active', 'dokter_jam_periksa' => date('H:i'));
		$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', $request->ruang_poliklinik)
								->first();

		if ($get) { 
			$str = 'Poliklinik '.$request->ruang_poliklinik.'='.$request->number;
			event(new NewTradeAll($str));
			return response()->json(['data' => 'berhasil']); 
		}

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']);  }
		}

		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', $request->ruang_poliklinik)
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = AntrianPoli::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => $request->ruang_poliklinik);
		$panggil = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);
		
		$str = 'Poliklinik '.$request->ruang_poliklinik.'='.$request->number;
		event(new NewTradeAll($str));

		return response()->json(['data' => 'berhasil']);
	}

	public function api(Request $request) {
		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }
		$data = Icd9::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama', 'kode'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}