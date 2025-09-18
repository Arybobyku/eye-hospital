<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use Storage;
use PenggunaHelp;

use App\Models\Pengguna;
use App\Models\Antrian;
use App\Models\AntrianPoli;
use App\Models\PasienBebas;
use App\Models\AntrianRo;
use App\Models\RuangPoli;
use App\Models\AntrianKasir;
use App\Models\AntrianFarmasi;
use App\Models\DisplayAntrian;
use App\Models\LogPengguna;
use App\Models\RunningText;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\LayananPasien;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;
use App\Events\NewTradeRo;
use App\Http\Controllers\CustomerServices\RegistrasiCtrl;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;
use Carbon\Carbon;


class AntrianCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
	}

	public function ambil()
	{
		return view('ambil-antrian-gabungan');
	}

	public function load(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$number = 1;
		$numberbebas = 1;
		$numberRo = 1;
		$bebas = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'F')->orderBy('id', 'desc')->first();
		$latestAntrianRO = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
		$antrian = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'CS')->orderBy('id', 'desc')->first();
		if ($antrian) {
			$number += $antrian->number;
		}
		if ($bebas) {
			$numberbebas += $bebas->number;
		}
		if ($latestAntrianRO) {
			$numberRo += $latestAntrianRO->number;
		}
		return response()->json(['number' => $number, 'numberbebas' => $numberbebas, 'numberRo' => $numberRo]);
	}

	public function data(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat halaman data profile');

		$biodata = DB::table('biodata')->orderBy('id', 'asc')->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid')))->first();
		$logpengguna = DB::table('log_pengguna')->orderBy('id', 'asc')
			->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid')))
			->limit(15)
			->get();

		return response()->json([
			'biodata' => $biodata,
			'logpengguna' => $logpengguna,
		]);
	}

	public function slider(Request $request)
	{


		$slider = DB::table('running_image')->orderBy('id', 'asc')->get();

		return response()->json(['slider' => $slider]);
	}

	public function ambilRO(Request $request)
	{

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = AntrianRo::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		$item = new AntrianRo();
		$item->uuid = Uuid::uuid4();
		$item->kode = 'RO';
		$item->number = $request->number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		// $pdf = \App::make('dompdf.wrapper');
		// $jenis = $request->jenis;
		// $number = $request->number;
		// $kode = 'RO';

		// $customPaper = array(0, 0, 649, 1063);
		// $pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		// $content = $pdf->download()->getOriginalContent();
		// Storage::put('public/antrian-ro/number.pdf', $content);

		return response()->json(['data' => 'berhasil']);
	}

	public function add(Request $request)
	{

		$uuid = '';
		$number = $request->number;
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = Antrian::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		$item = new Antrian();
		$item->uuid = $uuid;
		$item->kode = 'CS';
		$latestAntrian = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'CS')->orderBy('id', 'desc')->first();
		
		if ($latestAntrian && $latestAntrian->number >= $request->number) {
			$number = $latestAntrian->number + 1;
			if ($number < 10) {
				$number = '00'.$number;
			} else if ($number  > 9 && $number < 100) {
				$number  = '0'.$number;
			} else if ($number  > 99 && $number  < 1000) {
				$number = $number;
			}
		}

		$item->number = $number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');
		$item->save();

		// $item = new AntrianPoli();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianRo();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianKasir();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		// $item = new AntrianFarmasi();
		// $item->uuid = Uuid::uuid4();
		// $item->kode = 'A';
		// $item->number = $request->number;
		// $item->jenis = $request->jenis;
		// $item->tanggal = date('Y-m-d');
		// $item->save();

		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $request->number;
		$kode = 'CS';

		$customPaper = array(0, 0, 649, 1063);
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		$content = $pdf->download()->getOriginalContent();
		Storage::put('public/antrian/number.pdf', $content);

		return response()->json(['data' => 'berhasil']);
	}

	public function addbebas(Request $request)
	{

		DB::beginTransaction();
		$uuid = '';
		$loop = false;
		$number =  $request->number;
		do {
			$uuid = Uuid::uuid4();
			$check = AntrianFarmasi::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);
		$latestAntrian = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->where('kode', 'F')->orderBy('id', 'desc')->first();
		
		if ($latestAntrian && $latestAntrian->number >= $request->number) {
			$number = $latestAntrian->number + 1;
			if ($number < 10) {
				$number = '00'.$number;
			} else if ($number  > 9 && $number < 100) {
				$number  = '0'.$number;
			} else if ($number  > 99 && $number  < 1000) {
				$number = $number;
			}
		}
		$item = new AntrianFarmasi();
		$item->uuid = $uuid;
		$item->kode = 'F';
		$item->is_bpjs = $request->is_bpjs;
		$item->number = $number;
		$item->jenis = $request->jenis;
		$item->tanggal = date('Y-m-d');

		$nomor = 1;
		$tanggal = date('Ymd');

		// Ambil antrean terakhir untuk hari ini berdasarkan kode
		$lastEntry = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
			->where('kode', '=', 'F')
			->orderBy('id', 'desc')
			->first();

		if ($lastEntry && strlen($lastEntry->nomor) >= 13) {
			// Ambil 5 digit terakhir sebagai nomor antrean
			$lastNumber = (int) substr($lastEntry->nomor, -5);
			$nomor = $lastNumber + 1;
		}

		// Format nomor menjadi 5 digit (00001, 00002, ...)
		$nomor = str_pad($nomor, 5, '0', STR_PAD_LEFT);
		$nomorFormatted = $tanggal . $nomor;

		$item->nomor = 'F'.$nomorFormatted;

		$item->save();

		do {
			$uuidPasienBebas = Uuid::uuid4();
			$check = PasienBebas::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		// Generate Invoice
		$no_invoice = '';
		$invoice = PasienBebas::whereDate('tanggal', '=', date('Y-m-d'))
			->where('no_invoice', '!=', '-')
			->orderBy('no_invoice', 'desc')->first();
		$nomor_i = 1;
		if ($invoice) {
			$potong_kalimat = substr($invoice->no_invoice, -5);
			$potong_kalimat = (int) $potong_kalimat;
			$nomor_i += $potong_kalimat;
		}
		if ($nomor_i < 10) {
			$nomor_i = '0000' . $nomor_i;
		} else if ($nomor_i > 9 && $nomor_i < 100) {
			$nomor_i = '000' . $nomor_i;
		} else if ($nomor_i > 99 && $nomor_i < 1000) {
			$nomor_i = '00' . $nomor_i;
		} else if ($nomor_i > 999 && $nomor_i < 10000) {
			$nomor_i = '0' . $nomor_i;
		}
		$no_invoice = date('Ymd') . $nomor_i;

		// CREATE PASIEN BEBAS
		$pasienBebas = new PasienBebas();
		$pasienBebas->uuid = $uuidPasienBebas;
		$pasienBebas->kode = 'F';
		$pasienBebas->number = $number;
		$pasienBebas->nomor = $nomorFormatted;
		$pasienBebas->jenis = $request->jenis;
		$pasienBebas->no_invoice = $no_invoice;
		$pasienBebas->is_bpjs = $request->is_bpjs;
		$pasienBebas->tanggal = date('Y-m-d');
		$pasienBebas->no_antrian = $item->kode . '-' . str_pad($request->number, 3, '0', STR_PAD_LEFT);
		$pasienBebas->save();


		// Handling BPJS atau tidak
		$response = '';
		// if($request->is_bpjs == '1'){

		// }
		// dd($item);
		// **Panggil tambahAntreanFarmasi dengan cara yang benar**
		$response = app(AntrolBpjsCtrl::class)->tambahAntreanFarmasi($item);
		// dd($response);

		// **Proses PDF**
		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $number;
		$kode = 'F';
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))
			->setPaper([0, 0, 220, 220], 'potrait');
		$content = $pdf->download()->getOriginalContent();
		Storage::put('public/antrian/numberbebas.pdf', $content);

		// **Return response dari BPJS**
		DB::commit();
		// return response()->json(['data' => 'berhasil']);
		return response()->json([
			'status' => 'success',
			'bpjs_response' => $response // Kirim response dari BPJS ke frontend buat testing
		]);
	}

	public function addlamanonbpjs(Request $request)
	{
		try {
			DB::beginTransaction();
			$pasien = Pasien::where('no_ktp', '=', $request->nik)->first();
			if (!$pasien) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'NIK Tidak Ditemukan Silahkan Ambil Nomor Antrian Pasien Baru'
				], 404); // Gunakan status code 404 untuk not found
			}
			//Start Insert Antrian CS
			$latestAntrianCs = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			$numberCs = 1;
			if ($latestAntrianCs) {
				$numberCs = $latestAntrianCs->number + 1;
			}
			$uuid = '';
			$number = $request->number;
			$loop = false;
			do {
				$uuid = Uuid::uuid4();
				$check = Antrian::where('uuid', '=', $uuid)->first();
				if (!$check) {
					$loop = true;
				}
			} while ($loop == false);

			$latestAntrianRO = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			
			$latestNumber = $latestAntrianRO->number ?? 0;
			$latestNumber = $latestNumber + 1;
			$kodeRo = 'RO-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);
			
			$uuid = '';

			$latestAntrianPoli = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			$latestNumberPoli = $latestAntrianPoli->number ?? 0;
			$latestNumberPoli = $latestNumberPoli + 1;

			$ruangPoli = RuangPoli::where('kode_dokter_bpjs', '=', $request->kode_dokter_bpjs)->first();
			$ruangPoliAngka = preg_replace('/\D/', '', $ruangPoli->ruang_poli); 
			$kodePoli = 'P'.$ruangPoliAngka.'-'. str_pad($latestNumberPoli, 3, '0', STR_PAD_LEFT);
			
			
			$loop = false;
				do {
					$uuid = Uuid::uuid4();
					$check = Registrasi::where('uuid', '=', $uuid)->first();
						if (!$check) {
							$loop = true;
						}
				} while ($loop == false);

				$is_jkn = 0;
				
				$registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
				->where('status', '=', 'Kunjungan')->orderBy('posisi_antrian_ro', 'desc')->first();

				$posisi_antrian_dokter = 0;
				if ($request->berkebutuhan_khusus == 'Ya, Benar') {
					$posisi_antrian_dokter = 1;
					$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
						->where('status', '=', 'Kunjungan')
						->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
						->orderBy('posisi_antrian_dokter', 'desc')
						->first();

					if ($registrasi_poli) {
						$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
					}
				}

				$posisi_antrian_ro = 1;
				if ($registrasi) {
					$posisi_antrian_ro += $registrasi->posisi_antrian_ro;
				}

				$loop = false;
				$nomor = 1;
				$nomor_ = '';

				$registrasinomors = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Kunjungan')->orderBy('nomor', 'desc')->sharedLock()->first();

				if ($registrasinomors) {
					$potong_kalimat = substr($registrasinomors->nomor, -5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor += $potong_kalimat;
				}

				if ($nomor < 10) {
					$nomor = '0000' . $nomor;
				} else if ($nomor > 9 && $nomor < 100) {
					$nomor = '000' . $nomor;
				} else if ($nomor > 99 && $nomor < 1000) {
					$nomor = '00' . $nomor;
				} else if ($nomor > 999 && $nomor < 10000) {
					$nomor = '0' . $nomor;
				}

				$nomor_ = date('Y') . date('m') . date('d') . $nomor;
				$registrasi_uuid = $uuid;

				$item = new Registrasi();
				$item->uuid = $uuid;
				$item->kode = 'RJ';
				$item->nomor = $nomor_;
				$item->jenis = 'Rawat Jalan';
				$item->jalur_masuk = 'Rawat Jalan';

				$item->pasien_uuid = $pasien->uuid ? $pasien->uuid : '-';
				$item->rekam_medis = $pasien->rekam_medis ? $pasien->rekam_medis : '-';
				$item->nama_pasien = $pasien->nama ? $pasien->nama : '-';
				$item->tanggal_lahir = $pasien->tanggal_lahir ? $pasien->tanggal_lahir : '-';
				$item->jenis_identitas = $pasien->jenis_identitas ? $pasien->jenis_identitas : '-';
				$item->no_identitas = $pasien->no_identitas ? $pasien->no_identitas : '-';
				$item->jenis_kelamin = $pasien->jenis_kelamin ? $pasien->jenis_kelamin : '-';
				$item->no_handphone = $pasien->no_handphone ? $pasien->no_handphone : '-';
				$item->agama = $pasien->agama ? $pasien->agama : '-';

				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
				$dokterLocal = Pengguna::where('kode_dokter_bpjs_kes', '=', $request->kode_dokter_bpjs)->first();
				$item->pengguna_uuid = $dokterLocal->uuid;
				$item->nama_dokter = $dokterLocal->nama;
				$item->kode_dokter_bpjs = $request->kode_dokter_bpjs;
				$item->nama_dokter_bpjs = $request->nama_dokter_bpjs;
				$item->jadwal_dokter_bpjs = $request->jadwal_dokter_bpjs;
				$item->kode_poli_bpjs = $request->kode_poli_bpjs;
				$item->nama_poli_bpjs = $request->nama_poli_bpjs;				
				$item->ruang_poliklinik = $ruangPoliAngka ? $ruangPoliAngka : 0;
				$item->no_pendaftaran = $kodePoli;
				$item->cara_masuk = 'Datang Sendiri';
				$item->rujukan = $request->rujukan ? $request->rujukan : '-';
				$item->carabayar_uuid = '1bddd542-fd1e-4b6a-b629-53bd35428796';
				$item->carabayar_nama = 'Umum';
				$item->no_bpjs_kes = $pasien->no_bpjs;
				$item->nomorreferensi = "";
				$item->asuransi_uuid = $request->asuransi_uuid ? $request->asuransi_uuid : '-';
				$item->nama_asuransi = $request->nama_asuransi ? $request->nama_asuransi : '-';
				$item->posisi_antrian_ro = $posisi_antrian_ro;
				$item->posisi_antrian_dokter = $posisi_antrian_dokter;
				$item->berkebutuhan_khusus = $request->berkebutuhan_khusus ? $request->berkebutuhan_khusus : '-';
				$item->keterangan_berkebutuhan = $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-';
				$item->no_antrian_ro = $kodeRo;
				$item->no_antrian_poli = $kodePoli;
				$item->is_integrated_antrol = 1;
				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';
				
				// if ($request->carabayar_nama != 'Umum' && $request->carabayar_nama != 'BPJS Kesehatan') {
				// 	$status_penjamin = 'tunda';
				// 	$is_approve = 'tidak';
				// 	$is_pay = 'tidak';
				// 	$is_asuransi = 'ya';
				// }

				// if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
				// 	$status_penjamin = 'disetujui';
				// 	$is_approve = 'ya';
				// 	$is_pay = 'tidak';
				// 	$is_asuransi = 'tidak';
				// }

				$status_penjamin = 'disetujui';
				$is_approve = 'ya';
				$is_pay = 'tidak';
				$is_asuransi = 'tidak';

				$item->status_penjamin = $status_penjamin;
				$item->is_approve = $is_approve;
				$item->is_pay = $is_pay;
				$item->is_asuransi = $is_asuransi;
				$item->last_position = 'Pendaftaran';

				$item->is_jkn = $is_jkn;
				$item->save();

				$arr = array('status' => 'Kunjungan');
				$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);
				$registrasi_uuid = $uuid;
				$registrasi_kode = 'RJ';
				$registrasi_nomor = $nomor;
				$registrasi_jenis = 'Rawat Jalan';

				$rekammedis = $request->rekam_medis;
				$result = substr($rekammedis, 0, 1);
				
				$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis, $pasien, $item);

				$arr = array('status' => 'Kunjungan');
				$pasienUpdate = Pasien::where('uuid', '=', $pasien->uuid)->update($arr);

				// Start Antrian RO
				$uuidRO = '';
				$loop = false;
				do {
					$uuidRO = Uuid::uuid4();
					$check = AntrianRO::where('uuid', '=', $uuidRO)->first();
					if (!$check) {
						$loop = true;
					}
				} while ($loop == false);
				
				$antrianRO = new AntrianRo();
				$antrianRO->uuid = $uuidRO;
				$antrianRO->kode = 'RO';
				$antrianRO->is_jkn = $is_jkn;
				// BPJS
				$antrianRO->kode_poli =  $request->kode_poli_bpjs;
				$antrianRO->poli = $request->nama_poli_bpjs;
				$antrianRO->uuid_pasien =  $pasien->uuid;
				$antrianRO->kode_dokter =  $request->kode_dokter_bpjs;
				$antrianRO->uuid_registrasi =  $registrasi_uuid;

				$antrianRO->number = $latestNumber;
				$antrianRO->jenis = $request->jenis;
				$antrianRO->tanggal = date('Y-m-d');
				$antrianRO->save();

				// End Antrian RO

				// Start Antrian Poli
				$uuidPoli = '';
				$loop = false;
				do {
					$uuidPoli = Uuid::uuid4();
					$check = AntrianPoli::where('uuid', '=', $uuidPoli)->first();
					if (!$check) {
						$loop = true;
					}
				} while ($loop == false);				
				$antrianPoli = new AntrianPoli();
				$antrianPoli->uuid = $uuidPoli;
				$antrianPoli->kode = 'P';
				$antrianPoli->is_jkn = $is_jkn;
				// BPJS
				$antrianPoli->kode_poli =  $request->kode_poli_bpjs;
				$antrianPoli->poli = $request->nama_poli_bpjs;
				$antrianPoli->uuid_pasien =  $pasien->uuid;
				$antrianPoli->kode_dokter =  $request->kode_dokter_bpjs;
				$antrianPoli->uuid_registrasi =  $registrasi_uuid;

				$antrianPoli->number = $latestNumberPoli;
				$antrianPoli->jenis = $request->jenis;
				$antrianPoli->tanggal = date('Y-m-d');
				$antrianPoli->save();
				// End Antrian RO

				$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Sebagai')) . '=' . 'Registrasi';
				event(new NewTradeRo($str));

				DB::commit();
		
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}	

		$response = app(AntrolBpjsCtrl::class)->tambahAntreanPasienLama($item, $pasien);
		$response = json_decode($response);

		// if ($response->metadata->code !== 200) {
		// 	DB::rollBack();
		// 	return response()->json([
		// 		'hasil' => 'gagal',
		// 		'data' => $response->metadata->message ?? 'Terjadi kesalahan'
		// 	], 500);

		// 	$response = app(AntrolBpjsCtrl::class)->batalAntrean($item, $pasien);
		// }

		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $request->number;
		$kode = $antrianRO->kode;

		$customPaper = array(0, 0, 649, 1063);
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		$content = $pdf->download()->getOriginalContent();
		// Storage::put('public/antrian/number.pdf', $content);
		Storage::put('public/antrian/numberRo.pdf', $content);
		return response()->json(['data' => 'berhasil']);
	}

	public function searchnik(Request $request)
	{ 
		$bridging = new BridgeVclaim();
		// $bridging = new BridgeVclaim();
		$today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
		if ($request->section == 'nik_sect') {
			$pasien = Pasien::where('no_ktp', '=', $request->nik)->first();
			if (!$pasien) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'NIK Tidak Ditemukan Silahkan Ambil Nomor Antrian Pasien Baru'
				], 404); // Gunakan status code 404 untuk not found
			}
			$endpoint = '/Peserta/nik/'.$request->nik.'/tglSEP/'.$today;
			$result = $bridging->getRequestNew($endpoint);
			$result = json_decode($result);
			$noKa = $result->response->peserta->noKartu;
			$endpointRujukan = '/Rujukan/Peserta/'.$noKa;
			$resultRujukan = $bridging->getRequestNew($endpointRujukan);
			$resultRujukan = json_decode($resultRujukan);
			if ($resultRujukan->metaData->code != 200) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => $resultRujukan->metaData->message
				], 404);
			} 
		}
		else {
			$endpointRujukan = '/Rujukan/Peserta/'.$request->noKa;
			$resultRujukan = $bridging->getRequestNew($endpointRujukan);
			$resultRujukan = json_decode($resultRujukan);
			// dd($resultRujukan);
			if ($resultRujukan->metaData->code != 200) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => $resultRujukan->metaData->message
				], 404);
			} 	
			$pasien = Pasien::where('no_ktp', '=', $resultRujukan->response->rujukan->peserta->nik)->first();
			if (!$pasien) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'NIK Tidak Ditemukan Silahkan Ambil Nomor Antrian Pasien Baru'
				], 404); // Gunakan status code 404 untuk not found
			}
		}
		return response()->json([
			'hasil' => 'berhasil',
			'data' => $resultRujukan->response->rujukan->noKunjungan
		], 200);
	}

	public function addlamabpjs(Request $request)
	{
		try {
			DB::beginTransaction();
			if ($request->jenis_peserta == "nik_sect") {
			$pasien = Pasien::where('no_ktp', '=', $request->nik)->first();
			if (!$pasien) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'NIK Tidak Ditemukan Silahkan Ambil Nomor Antrian Pasien Baru'
				], 404); // Gunakan status code 404 untuk not found
			}
			} else {
				$pasien = Pasien::where('no_bpjs', '=', $request->bpjs)->first();
				if (!$pasien) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'No. BPJS Tidak Ditemukan Silahkan Ambil Nomor Antrian Pasien Baru'
				], 404); // Gunakan status code 404 untuk not found
			}
			}
			//Start Insert Antrian CS
			$latestAntrianCs = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			$numberCs = 1;
			if ($latestAntrianCs) {
				$numberCs = $latestAntrianCs->number + 1;
			}
			$uuid = '';
			$number = $request->number;
			$loop = false;
			do {
				$uuid = Uuid::uuid4();
				$check = Antrian::where('uuid', '=', $uuid)->first();
				if (!$check) {
					$loop = true;
				}
			} while ($loop == false);

			$latestAntrianRO = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			
			$latestNumber = $latestAntrianRO->number ?? 0;
			$latestNumber = $latestNumber + 1;
			$kodeRo = 'RO-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);
			
			$uuid = '';

			$latestAntrianPoli = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();
			$latestNumberPoli = $latestAntrianPoli->number ?? 0;
			$latestNumberPoli = $latestNumberPoli + 1;

			$ruangPoli = RuangPoli::where('kode_dokter_bpjs', '=', $request->kode_dokter_bpjs)->first();
			$ruangPoliAngka = preg_replace('/\D/', '', $ruangPoli->ruang_poli); 
			$kodePoli = 'P'.$ruangPoliAngka.'-'. str_pad($latestNumberPoli, 3, '0', STR_PAD_LEFT);

			
			$loop = false;
				do {
					$uuid = Uuid::uuid4();
					$check = Registrasi::where('uuid', '=', $uuid)->first();
						if (!$check) {
							$loop = true;
						}
				} while ($loop == false);

				$is_jkn = 0;
				
				$registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
				->where('status', '=', 'Kunjungan')->orderBy('posisi_antrian_ro', 'desc')->first();

				$posisi_antrian_dokter = 0;
				if ($request->berkebutuhan_khusus == 'Ya, Benar') {
					$posisi_antrian_dokter = 1;
					$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
						->where('status', '=', 'Kunjungan')
						->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
						->orderBy('posisi_antrian_dokter', 'desc')
						->first();

					if ($registrasi_poli) {
						$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
					}
				}

				$posisi_antrian_ro = 1;
				if ($registrasi) {
					$posisi_antrian_ro += $registrasi->posisi_antrian_ro;
				}

				$loop = false;
				$nomor = 1;
				$nomor_ = '';

				$registrasinomors = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Kunjungan')->orderBy('nomor', 'desc')->sharedLock()->first();

				if ($registrasinomors) {
					$potong_kalimat = substr($registrasinomors->nomor, -5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor += $potong_kalimat;
				}

				if ($nomor < 10) {
					$nomor = '0000' . $nomor;
				} else if ($nomor > 9 && $nomor < 100) {
					$nomor = '000' . $nomor;
				} else if ($nomor > 99 && $nomor < 1000) {
					$nomor = '00' . $nomor;
				} else if ($nomor > 999 && $nomor < 10000) {
					$nomor = '0' . $nomor;
				}

				$nomor_ = date('Y') . date('m') . date('d') . $nomor;
				$registrasi_uuid = $uuid;

				$item = new Registrasi();
				$item->uuid = $uuid;
				$item->kode = 'RJ';
				$item->nomor = $nomor_;
				$item->jenis = 'Rawat Jalan';
				$item->jalur_masuk = 'Rawat Jalan';

				$item->pasien_uuid = $pasien->uuid ? $pasien->uuid : '-';
				$item->rekam_medis = $pasien->rekam_medis ? $pasien->rekam_medis : '-';
				$item->nama_pasien = $pasien->nama ? $pasien->nama : '-';
				$item->tanggal_lahir = $pasien->tanggal_lahir ? $pasien->tanggal_lahir : '-';
				$item->jenis_identitas = $pasien->jenis_identitas ? $pasien->jenis_identitas : '-';
				$item->no_identitas = $pasien->no_identitas ? $pasien->no_identitas : '-';
				$item->jenis_kelamin = $pasien->jenis_kelamin ? $pasien->jenis_kelamin : '-';
				$item->no_handphone = $pasien->no_handphone ? $pasien->no_handphone : '-';
				$item->agama = $pasien->agama ? $pasien->agama : '-';

				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');
				$dokterLocal = Pengguna::where('kode_dokter_bpjs_kes', '=', $request->kode_dokter_bpjs)->first();
				$item->pengguna_uuid = $dokterLocal->uuid;
				$item->nama_dokter = $dokterLocal->nama;
				$item->kode_dokter_bpjs = $request->kode_dokter_bpjs;
				$item->nama_dokter_bpjs = $request->nama_dokter_bpjs;
				$item->jadwal_dokter_bpjs = $request->jadwal_dokter_bpjs;
				$item->kode_poli_bpjs = $request->kode_poli_bpjs;
				$item->nama_poli_bpjs = $request->nama_poli_bpjs;				
				$item->ruang_poliklinik = $ruangPoliAngka ? $ruangPoliAngka : 0;
				$item->no_pendaftaran = $kodePoli;
				$item->rujukan = $request->rujukan ? $request->rujukan : '-';
				$item->cara_masuk = 'Rujukan dari';
				$item->carabayar_uuid = 'e3ed042d-2b41-4672-bcc2-7a816a622667';
				$item->carabayar_nama = 'BPJS Kesehatan';
				$item->no_bpjs_kes = $pasien->no_bpjs;
				$item->nomorreferensi = "";
				$item->asuransi_uuid = $request->asuransi_uuid ? $request->asuransi_uuid : '-';
				$item->nama_asuransi = $request->nama_asuransi ? $request->nama_asuransi : '-';
				$item->posisi_antrian_ro = $posisi_antrian_ro;
				$item->posisi_antrian_dokter = $posisi_antrian_dokter;
				$item->berkebutuhan_khusus = $request->berkebutuhan_khusus ? $request->berkebutuhan_khusus : '-';
				$item->keterangan_berkebutuhan = $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-';
				$item->no_antrian_ro = $kodeRo;
				$item->no_antrian_poli = $kodePoli;
				$item->is_integrated_antrol = 1;
				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';

				$status_penjamin = 'disetujui';
				$is_approve = 'ya';
				$is_pay = 'tidak';
				$is_asuransi = 'tidak';

				$item->status_penjamin = $status_penjamin;
				$item->is_approve = $is_approve;
				$item->is_pay = $is_pay;
				$item->is_asuransi = $is_asuransi;
				$item->last_position = 'Pendaftaran';

				$item->is_jkn = $is_jkn;
				$item->save();

				$arr = array('status' => 'Kunjungan');
				$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);
				$registrasi_uuid = $uuid;
				$registrasi_kode = 'RJ';
				$registrasi_nomor = $nomor;
				$registrasi_jenis = 'Rawat Jalan';

				$rekammedis = $request->rekam_medis;
				$result = substr($rekammedis, 0, 1);
				
				$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis, $pasien, $item);

				$arr = array('status' => 'Kunjungan');
				$pasienUpdate = Pasien::where('uuid', '=', $pasien->uuid)->update($arr);

				// Start Antrian RO
				$uuidRO = '';
				$loop = false;
				do {
					$uuidRO = Uuid::uuid4();
					$check = AntrianRO::where('uuid', '=', $uuidRO)->first();
					if (!$check) {
						$loop = true;
					}
				} while ($loop == false);
				
				$antrianRO = new AntrianRo();
				$antrianRO->uuid = $uuidRO;
				$antrianRO->kode = 'RO';
				$antrianRO->is_jkn = $is_jkn;
				// BPJS
				$antrianRO->kode_poli =  $request->kode_poli_bpjs;
				$antrianRO->poli = $request->nama_poli_bpjs;
				$antrianRO->uuid_pasien =  $pasien->uuid;
				$antrianRO->kode_dokter =  $request->kode_dokter_bpjs;
				$antrianRO->uuid_registrasi =  $registrasi_uuid;

				$antrianRO->number = $latestNumber;
				$antrianRO->jenis = $request->jenis;
				$antrianRO->tanggal = date('Y-m-d');
				$antrianRO->save();

				// End Antrian RO

				// Start Antrian Poli
				$uuidPoli = '';
				$loop = false;
				do {
					$uuidPoli = Uuid::uuid4();
					$check = AntrianPoli::where('uuid', '=', $uuidPoli)->first();
					if (!$check) {
						$loop = true;
					}
				} while ($loop == false);				
				$antrianPoli = new AntrianPoli();
				$antrianPoli->uuid = $uuidPoli;
				$antrianPoli->kode = 'P';
				$antrianPoli->is_jkn = $is_jkn;
				// BPJS
				$antrianPoli->kode_poli =  $request->kode_poli_bpjs;
				$antrianPoli->poli = $request->nama_poli_bpjs;
				$antrianPoli->uuid_pasien =  $pasien->uuid;
				$antrianPoli->kode_dokter =  $request->kode_dokter_bpjs;
				$antrianPoli->uuid_registrasi =  $registrasi_uuid;

				$antrianPoli->number = $latestNumberPoli;
				$antrianPoli->jenis = $request->jenis;
				$antrianPoli->tanggal = date('Y-m-d');
				$antrianPoli->save();
				// End Antrian RO

				$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Sebagai')) . '=' . 'Registrasi';
				event(new NewTradeRo($str));

				DB::commit();
		
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}	

		$response = app(AntrolBpjsCtrl::class)->tambahAntreanPasienLama($item, $pasien);
		$response = json_decode($response);

		// if ($response->metadata->code !== 200) {
		// 	DB::rollBack();
		// 	return response()->json([
		// 		'hasil' => 'gagal',
		// 		'data' => $response->metadata->message ?? 'Terjadi kesalahan'
		// 	], 500);

		// 	$response = app(AntrolBpjsCtrl::class)->batalAntrean($item, $pasien);
		// }

		$pdf = \App::make('dompdf.wrapper');
		$jenis = $request->jenis;
		$number = $request->number;
		$kode = $antrianRO->kode;

		$customPaper = array(0, 0, 649, 1063);
		$pdf->loadView('cetak-antrian', compact('kode', 'jenis', 'number'))->setPaper(array(0, 0, 220, 220), 'potrait');
		$content = $pdf->download()->getOriginalContent();
		Storage::put('public/antrian/numberRo.pdf', $content);
		return response()->json(['data' => 'berhasil']);
	}

			
	public function addcheckin(Request $request)
    {

        try {
			$uuid = '';
            $uuid = Registrasi::where('nomor', $request->kodebooking)
            ->value('uuid');
			if ($uuid = null || $uuid = '') {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'Kode Booking Tidak Ditemukan'
				], 500);
			}
            $data = AntrianPoli::where('uuid_registrasi', $uuid)
            ->first();
			$dataRo = AntrianRO::where('uuid_registrasi', $uuid)
            ->first();
			if ($dataRo) {
                $dataRo->status = 'active';
                $dataRo->save();
			}
			if ($data) {
                $data->status = 'active';
                $data->save();
			}
			 if(!$data || !$dataRo) {
				return response()->json([
					'hasil' => 'gagal',
					'data' => 'Kode Booking Tidak Ditemukan'
				], 500);
            }
			return response()->json([
				'hasil' => 'berhasil',
				'data' => 'Booking Ditemukan Silahkan'
			], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }
        

	public function cetakAntrianAll($noAntrian, $jenis)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadView('cetak-antrian-all', compact('noAntrian', 'jenis'))->setPaper(array(0, 0, 220, 220), 'potrait');
		return $pdf->stream();
	}

	public function cs(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-cs', compact('text'));
	}

	public function poli(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-poli', compact('text'));
	}

	public function all(Request $request)
	{
		$text = RunningText::where('status', '=', 'active')->orderBy('id', 'desc')->first();
		return view('antrian-all', compact('text'));
	}

	public function displaycs(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = Antrian::whereDate('tanggal', '=', date('Y-m-d'))->where('pemanggil', '!=', '-')->get();
		return response()->json(['hasil' => $get]);
	}

	public function displaypoli(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->where(function ($q) {
				$q->where('pemanggil', '=', '1')
					->orWhere('pemanggil', '=', '2')
					->orWhere('pemanggil', '=', '3');
			})->get();
		$ro = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->get();
		return response()->json(['hasil' => $get, 'ro' => $ro]);
	}

	public function displayall(Request $request)
	{
		date_default_timezone_set("Asia/Jakarta");
		$get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->where(function ($q) {
				$q->where('pemanggil', '=', '3')
					->orWhere('pemanggil', '=', '4');
			})->get();
		$kasir = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->get();
		$farmasi = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
			->where('pemanggil', '!=', '-')
			->get();
		return response()->json(['hasil' => $get, 'kasir' => $kasir, 'farmasi' => $farmasi]);
	}

	public function savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis, $pasien, $itemRegistrasi)
	{
		$dokterLocal = Pengguna::where('kode_dokter_bpjs_kes', '=', $request->dokter_bpjs)->first();
		$tindakan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $itemRegistrasi->carabayar_uuid)->where('default', '=', 'Ya')
			->where('tindakan_rawat_jalan_uuid', '!=', '6808853b-2aad-4ebd-acee-ec9980a2407d')
			->select(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->groupBy(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->get();
		foreach ($tindakan as $row) {
			$item = new LayananPasien();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $registrasi_uuid;
			$item->no_pendaftaran = $itemRegistrasi->no_pendaftaran;
			$item->registrasi_kode = $registrasi_kode;
			$item->registrasi_nomor = $registrasi_nomor;
			$item->registrasi_jenis = $registrasi_jenis;
			$item->pasien_uuid = $pasien->uuid ? $pasien->uuid : '-';
			$item->rekam_medis = $pasien->rekam_medis ? $pasien->rekam_medis : '-';
			$item->nama_pasien = $pasien->nama ? $pasien->nama : '-';
						// $item->pengguna_uuid = $request->pengguna_uuid;
			// $item->nama_dokter = $request->nama_dokter;
			$item->pengguna_uuid = $dokterLocal->uuid;
			$item->nama_dokter = $dokterLocal->nama;

			$item->tanggal = date('Y-m-d');
			$item->waktu = date('H:i');

			$item->carabayar_uuid = $itemRegistrasi->carabayar_uuid;
			$item->carabayar_nama = $itemRegistrasi->carabayar_nama;

			$item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
			$item->nama_layanan = $row->nama_tindakan_rawat_jalan;
			$item->tarif = $row->harga;
			$item->total = $row->harga;
			$item->default = 'Ya';
			$cek = explode(" ", $row->nama_tindakan_rawat_jalan);
			if (count($cek) > 0) {
				if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
					$item->jenis = 'Honor';
				} else {
					$item->jenis = 'Administrasi';
				}
			} else {
				$item->jenis = 'Administrasi';
			}
			$item->save();
		}
	}
}


