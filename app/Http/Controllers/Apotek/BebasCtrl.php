<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\ResepBebas;
use App\Models\ResepRacikanBebas;
use App\Models\LayananPasien;
use App\Models\PasienBebas;
use App\Jobs\SendAllJob;
use Carbon\Carbon;
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;


class BebasCtrl extends Controller
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
			$data = PasienBebas::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('pembayaran', '=', 'Belum Bayar')
								->where('status', '!=', 'batal')
								->orderBy('no_invoice', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('pembayaran', '=', 'Belum Bayar')
								->where('status', '!=', 'batal')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_invoice', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('pembayaran', '=', 'Belum Bayar')
									->where('status', '!=', 'batal')
									->orderBy('no_invoice', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('pembayaran', '=', 'Belum Bayar')
									->where('status', '!=', 'batal')
									->orderBy('no_invoice', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function listbayar(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data unit');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			$data = PasienBebas::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('pembayaran', '=', 'Sudah Bayar')
								->where('status', '!=', 'batal')
								->orderBy('no_invoice', 'asc')
								->skip($skip)->take($this->take)
								->get();
			$total = PasienBebas::where('delete_soft', '=', 1)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('pembayaran', '=', 'Sudah Bayar')
								->where('status', '!=', 'batal')
								->where($column, 'ilike', '%'.$search.'%')
								->orderBy('no_invoice', 'asc')->count();
		}
		else {
			$data = PasienBebas::where('delete_soft', '=', 1)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('pembayaran', '=', 'Sudah Bayar')
									->where('status', '!=', 'batal')
									->orderBy('no_invoice', 'asc')
									->skip($skip)->take($this->take)
									->get();

			$total = PasienBebas::where('delete_soft', '=', 1)
									->whereDate('tanggal', '=', date('Y-m-d'))
									->where('pembayaran', '=', 'Sudah Bayar')
									->where('status', '!=', 'batal')
									->orderBy('no_invoice', 'asc')
									->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function call(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$cek = PasienBebas::where('uuid', '=', $request->uuid)->first();

		$arr = array('active_call' => '-');
		$update = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);

		if ($cek->farmasi_jam_layani == '-') {
			$arr = array('active_call' => 'active', 'farmasi_jam_layani' => date('H:i'));
		}
		else {
			$arr = array('active_call' => 'active');
		}
		$update = PasienBebas::where('uuid', '=', $request->uuid)->update($arr);

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) { 
			$str = 'Farmasi 1'.'='.$request->number.'=bebas';
			$this->jeda(1, $str);
			return response()->json(['data' => 'success']); 
		}

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
								->where('number', '=', $request->number)->first();
		if ($get) {
			if ($get->pemanggil != '-') { return response()->json(['data' => 'cannot']); }
		}

		$get = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', '1')
								->first();

		if ($get) {
				$arr = array('pemanggil' => '-');
				$update = PasienBebas::where('uuid', '=', $get->uuid)->update($arr);
		}

		$arr = array('pemanggil' => '1');
		$panggil = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

		$str = 'Farmasi 1'.'='.$request->number.'=bebas';
		$this->jeda(1, $str);
		
		return response()->json(['data' => 'success']);
	}

	private function jeda($delay, $str) {
		$on = Carbon::now()->addSeconds($delay);
		dispatch(new SendAllJob($str))->delay($on);
	}

	public function selesai(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('active_call' => '-', 'active_call_kasir' => '-', 'status' => 'deactive', 'farmasi_jam_selesai' => date('H:i'));
		$update = PasienBebas::where('uuid', '=', $request->uuid)->update($arr);
		return response()->json(['data' => 'success']);
	}

	public function batal(Request $request) {
		date_default_timezone_set("Asia/Jakarta");

		$arr = array('status' => 'batal', 'farmasi_jam_selesai' => date('H:i'));
		$update = PasienBebas::where('uuid', '=', $request->uuid)->update($arr);
		$data = PasienBebas::where('uuid', '=', $request->uuid)->first();

		$response = "";
		// if ($data->is_integrated_antrol == 1) {
		$response = app(AntrolBpjsCtrl::class)->batalAntreanFarmasiBebas($data);
		// }
		// return response()->json(['data' => 'success']);
		return response()->json([
				'data' => 'success',
				'bpjs'=> $response
			]);
	}

	public function antrian(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			$item = new PasienBebas();
			$item->uuid = Uuid::uuid4();;
			$item->kode = 'K';
			$item->number = $request->number;
			$item->jenis = $request->jenis;
			$item->tanggal = date('Y-m-d');
			$item->jam = date('H:i');
			$item->carabayar_uuid = '1bddd542-fd1e-4b6a-b629-53bd35428796';
			$item->carabayar_nama = 'Umum';
			$item->save();

			$pdf = \App::make('dompdf.wrapper');
			$jenis = $request->jenis;
			$number = $request->number;
			$kode = 'K';

			$customPaper = array(0,0,649,1063);
			$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0,0,220, 220),'potrait');
			$content = $pdf->download()->getOriginalContent();
			Storage::put('public/antrian/numberbebas.pdf', $content);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}


	public function addpembeli(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try {
			DB::beginTransaction();

			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 5; $i++) {
					$n = rand(0, $alphaLength);
					$pass[] = $alphabet[$n];
			}

			$str = date('d').date('i').implode($pass); //turn the array into a string

			$no_invoice = '';
			$invoice = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
									->where('no_invoice', '!=', '-')
									->orderBy('no_invoice', 'desc')->first();
			$nomor_i = 1;
			if ($invoice) {
				$potong_kalimat = substr($invoice->no_invoice,-5);
				$potong_kalimat = (int) $potong_kalimat;
				$nomor_i += $potong_kalimat;
			}
			if ($nomor_i < 10) { $nomor_i = '0000'.$nomor_i; }
			else if ($nomor_i > 9 && $nomor_i < 100) { $nomor_i = '000'.$nomor_i; }
			else if ($nomor_i > 99 && $nomor_i < 1000) { $nomor_i = '00'.$nomor_i; }
			else if ($nomor_i > 999 && $nomor_i < 10000) { $nomor_i = '0'.$nomor_i; }
			$no_invoice = date('Ymd').$nomor_i;

			$item = new PasienBebas();
			$item->uuid = Uuid::uuid4();;
			$item->kode = $str;
			$item->number = 0;
			$item->tanggal = date('Y-m-d');
			$item->jam = date('H:i');
			$item->carabayar_uuid = '1bddd542-fd1e-4b6a-b629-53bd35428796';
			$item->carabayar_nama = 'Umum';
			$item->nama_pasien = $request->nama;
			$item->no_antrian = $request->no_antrian;
			$item->jenis = $request->jenis;
			$item->no_invoice = $no_invoice;
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		}
		catch(Exception $e){ 
			DB::rollback(); 
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function add(Request $request) { 

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		//PenggunaHelp::log('Menambahkan data unit dengan nama "'.$request->nama.'".');

		try{
			DB::beginTransaction();

			$remove = ResepBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->delete();

			$obat = json_decode($request->obat);

			if($obat){
				foreach ($obat as $row) {
					$item = new ResepBebas();
					$item->uuid = Uuid::uuid4();

					$item->pasienbebas_uuid = $request->pasienbebas_uuid;
					$item->ada_tindakan = 'Ya';
					$item->layanan_uuid = '-';
					$item->nama_layanan = '-';
					$item->tarif_layanan = 0;
					$item->default_layanan = '-';
					$item->jenis_layanan = '-';

					$item->registrasi_uuid = '-';
					$item->no_pendaftaran = '-';
					$item->registrasi_kode = '-';
					$item->registrasi_nomor = '-';
					$item->registrasi_jenis = '-';
					$item->pasien_uuid = '-';
					$item->rekam_medis = '-';
					$item->nama_pasien = '-';
					$item->dokter_uuid = '-';
					$item->nama_dokter = '-';

					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;
						
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
				}
			}

			$remove = ResepRacikanBebas::where('pasienbebas_uuid', '=', $request->pasienbebas_uuid)->delete();
			$obatracikan = json_decode($request->obatracikan);
			if($obatracikan){
				foreach ($obatracikan as $row) {
					$item = new ResepRacikanBebas();
					$item->uuid = Uuid::uuid4();
					$item->pasienbebas_uuid = $request->pasienbebas_uuid;
					$item->ada_tindakan = 'Ya';
					$item->layanan_uuid = '-';
					$item->nama_layanan = '-';
					$item->tarif_layanan = 0;
					$item->default_layanan = '-';
					$item->jenis_layanan = '-';

					$item->registrasi_uuid = '-';
					$item->no_pendaftaran = '-';
					$item->registrasi_kode = '-';
					$item->registrasi_nomor = '-';
					$item->registrasi_jenis = '-';
					$item->pasien_uuid = '-';
					$item->rekam_medis = '-';
					$item->nama_pasien = '-';
					$item->dokter_uuid = '-';
					$item->nama_dokter = '-';
								
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');

					$item->carabayar_uuid = $request->carabayar_uuid;
					$item->carabayar_nama = $request->carabayar_nama;

					$item->label = $row->label;
					$item->kemasan = $row->kemasan;
					$item->jumlah = $row->jumlah;
					$item->signa = $row->signa;
					$item->total = $row->total;
					$item->informasi = $row->informasi;
					$item->save();
				}
			}

			$remove = LayananPasien::where('pasien_uuid', '=', $request->pasienbebas_uuid)->delete();

			$tindakan = json_decode($request->tindakan);
			if($tindakan){
				foreach ($tindakan as $row) {
					$item = new LayananPasien();
					$item->uuid = Uuid::uuid4();
					$item->registrasi_uuid = '-';
					$item->no_pendaftaran = '-';
					$item->registrasi_kode = '-';
					$item->registrasi_nomor = '-';
					$item->registrasi_jenis = '-';
					$item->pasien_uuid = $request->pasienbebas_uuid;
					$item->rekam_medis = '-';
					$item->nama_pasien = '-';
					$item->pengguna_uuid = '-';
					$item->nama_dokter = '-';
						
					$item->tanggal = date('Y-m-d');
					$item->waktu = date('H:i');
					
					$item->carabayar_uuid = 'umum';
					$item->carabayar_nama = 'umum';
					$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
					$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
					$item->tarif = $row->harga;
					$item->total = $row->harga;
					$item->jenis = 'Tindakan Obat Bebas';
					$item->default = $row->default;
					$item->save();
				}
			}

			$arr = array('ada_obat' => 'Ya');
			$update = PasienBebas::where('uuid', '=', $request->pasienbebas_uuid)->update($arr);

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

		$detail = PasienBebas::where('uuid', '=', $request->uuid)->first();
		$data = ResepBebas::where('pasienbebas_uuid', '=', $request->uuid)->get();
		$obatracikan = ResepRacikanBebas::where('pasienbebas_uuid', '=', $request->uuid)
						->orderBy('id', 'desc')->get();
		$layanan = LayananPasien::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit unit');
		// }
		
		return response()->json(['data' => $data, 'layanan' => $layanan, 'obatracikan' => $obatracikan, 'detail' => $detail, 'dfd' => $request->uuid]);
	}

	public function update(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Mengupdate data unit dengan nama "'.$request->nama.'".');

		$arr = array(
				'nama' => $request->nama
		);

		try{
			DB::beginTransaction();

			$update = Unit::where('uuid', '=', $request->uuid)->update($arr);
			
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

		$data = Unit::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
		}

		$arr = array('delete_soft' => 0);
		
		try{
			DB::beginTransaction();

			$remove = Unit::where('uuid', '=', $request->uuid)->update($arr);
			
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
		$data = Unit::where('delete_soft', '=', '1')->where('nama', 'ilike', '%'.$request->keyword.'%')->select(['id', 'uuid', 'nama'])->limit(10)->get();
		return response()->json(['data' => $data]);
	}

}