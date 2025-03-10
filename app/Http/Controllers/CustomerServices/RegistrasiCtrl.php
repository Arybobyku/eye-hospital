<?php

namespace App\Http\Controllers\CustomerServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;

use App\Models\Pasien;
use App\Models\Pengguna;
use App\Models\Registrasi;
use App\Models\PenanggungJawab;
use App\Models\LayananPasien;
use App\Models\CaraBayarTindakanRawatJalan;
use App\Events\NewTradeRo;
use App\Models\AntrianRo;
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;

class RegistrasiCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function page(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman registrasi');
		}

		$registrasi = Registrasi::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->limit(12)->get();
		$kunjungan = Registrasi::where('pasien_uuid', '=', $request->uuid)
			->where('status', '=', 'Kunjungan')->orderBy('id', 'desc')->first();
		$pj = '';
		if ($kunjungan) {
			$pj = PenanggungJawab::where('registrasi_uuid', '=', $kunjungan->uuid)->first();
		}
		$refPoli = app(AntrolBpjsCtrl::class)->referensiPoli();
		$refPoliArray = json_decode($refPoli, true);

		return response()->json(['data' => $data, 'registrasi' => $registrasi, 'kunjungan' => $kunjungan, 'pj' => $pj, 'poli_bpjs' => $refPoliArray]);
	}

	public function rawatjalan(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "' . $request->nama . '".');

		try {

			DB::beginTransaction();

			if ($request->uuid != '') {

				$posisi_antrian_dokter = 1;
				$arr = array();
				$registrasi = Registrasi::where('uuid', '=', $request->uuid)->first();

				$registrasi_uuid = $registrasi->uuid;
				$registrasi_kode = $registrasi->kode;
				$registrasi_nomor = $registrasi->nomor;
				$registrasi_jenis = $registrasi->jenis;

				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';
				if ($request->carabayar_nama != 'Umum' && $request->carabayar_nama != 'BPJS Kesehatan') {
					$status_penjamin = 'tunda';
					$is_approve = 'tidak';
					$is_pay = 'tidak';
					$is_asuransi = 'ya';
				}

				if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
					$status_penjamin = 'disetujui';
					$is_approve = 'ya';
					$is_pay = 'tidak';
					$is_asuransi = 'tidak';
				}

				if ($request->berkebutuhan_khusus == 'Ya, Benar') {

					if ($registrasi->ruang_poliklinik != $request->ruang_poliklinik) {

						$registrasi_poli = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
							->where('status', '=', 'Kunjungan')
							->where('ruang_poliklinik', '=', $request->ruang_poliklinik)
							->orderBy('posisi_antrian_dokter', 'desc')
							->first();


						if ($registrasi_poli) {
							$posisi_antrian_dokter += $registrasi_poli->posisi_antrian_dokter;
						}

						$arr = array(
							'pengguna_uuid' => $request->pengguna_uuid,
							'nama_dokter' => $request->nama_dokter,
							'no_pendaftaran' => $request->no_pendaftaran,
							'cara_masuk' => $request->cara_masuk,
							'rujukan' => $request->rujukan,
							'carabayar_uuid' => $request->carabayar_uuid,
							'carabayar_nama' => $request->carabayar_nama,
							'asuransi_uuid' => $request->asuransi_uuid ? $request->asuransi_uuid : '-',
							'nama_asuransi' => $request->nama_asuransi ? $request->nama_asuransi : '-',
							'ruang_poliklinik' => $request->ruang_poliklinik ? $request->ruang_poliklinik : 0,
							'berkebutuhan_khusus' => $request->berkebutuhan_khusus,
							'posisi_antrian_dokter' => $posisi_antrian_dokter,
							'keterangan_berkebutuhan' => $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-',
							'status_penjamin' => $status_penjamin,
							'is_approve' => $is_approve,
							'is_pay' => $is_pay,
							'is_asuransi' => $is_asuransi,
						);
					} else {
						$arr = array(
							'pengguna_uuid' => $request->pengguna_uuid,
							'nama_dokter' => $request->nama_dokter,
							'no_pendaftaran' => $request->no_pendaftaran,
							'cara_masuk' => $request->cara_masuk,
							'rujukan' => $request->rujukan,
							'carabayar_uuid' => $request->carabayar_uuid,
							'carabayar_nama' => $request->carabayar_nama,
							'asuransi_uuid' => $request->asuransi_uuid ? $request->asuransi_uuid : '-',
							'nama_asuransi' => $request->nama_asuransi ? $request->nama_asuransi : '-',
							'ruang_poliklinik' => $request->ruang_poliklinik ? $request->ruang_poliklinik : 0,
							'berkebutuhan_khusus' => $request->berkebutuhan_khusus,
							'keterangan_berkebutuhan' => $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-',
							'status_penjamin' => $status_penjamin,
							'is_approve' => $is_approve,
							'is_pay' => $is_pay,
							'is_asuransi' => $is_asuransi,
						);
					}
				} else {
					$arr = array(
						'pengguna_uuid' => $request->pengguna_uuid,
						'nama_dokter' => $request->nama_dokter,
						'no_pendaftaran' => $request->no_pendaftaran,
						'cara_masuk' => $request->cara_masuk,
						'rujukan' => $request->rujukan,
						'carabayar_uuid' => $request->carabayar_uuid,
						'carabayar_nama' => $request->carabayar_nama,
						'asuransi_uuid' => $request->asuransi_uuid ? $request->asuransi_uuid : '-',
						'nama_asuransi' => $request->nama_asuransi ? $request->nama_asuransi : '-',
						'status_penjamin' => $status_penjamin,
						'is_approve' => $is_approve,
						'is_pay' => $is_pay,
						'is_asuransi' => $is_asuransi,
					);
				}

				$update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

				$arr = array(
					'nama' => $request->nama,
					'hubungan' => $request->hubungan,
					'alamat' => $request->alamat,
					'jenis_identitas' => $request->jenis_identitas,
					'no_identitas' => $request->no_identitas,
					'no_handphone' => $request->no_handphone,
				);
				$update = PenanggungJawab::where('registrasi_uuid', '=', $request->uuid)->update($arr);

				$rekammedis = $request->rekam_medis;
				$result = substr($rekammedis, 0, 1);

				$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();

				//if ($request->carabayar_nama == 'Umum') {
				if ($result == '0') {
					$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
					$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				} else {
					$check = Registrasi::where('status', '=', 'Selesai')->where('pasien_uuid', '=', $request->pasien_uuid)->first();
					if ($check) {
						$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
						$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
					} else {
						$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
						$this->savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
					}
				}
				// }
				// else {
				// 	$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// }
			} else {
				$uuid = '';
				$loop = false;
				do {
					$uuid = Uuid::uuid4();
					$check = Registrasi::where('uuid', '=', $uuid)->first();
					if (!$check) {
						$loop = true;
					}
				} while ($loop == false);

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

				$latestAntrianRO = AntrianRo::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

				$latestNumber = $latestAntrianRO->number ?? 0;
				$latestNumber = $latestNumber + 1;
				$kodeRo = 'R-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

				$antrianRO = new AntrianRo();
				$antrianRO->uuid = $uuidRO;
				$antrianRO->kode = 'R';
				$antrianRO->is_jkn = 0;
				// BPJS
				$antrianRO->kode_poli =  $request->kode_poli_bpjs;
				$antrianRO->poli = $request->nama_poli_bpjs;
				$antrianRO->uuid_pasien =  $request->pasien_uuid;
				$antrianRO->kode_dokter =  $request->kode_dokter_bpjs;
				$antrianRO->uuid_registrasi =  $uuid;

				$antrianRO->number = $latestNumber;
				$antrianRO->jenis = $request->jenis;
				$antrianRO->tanggal = date('Y-m-d');
				$antrianRO->save();

				// End Antrian RO

				$photos = $request->photos;
				$photos = str_replace('data:image/jpeg;base64,', '', $photos);
				$photos = str_replace(' ', '+', $photos);
				$data_photos = base64_decode($photos);
				$filename = 'pasien/' . $uuid . '_pasien.jpg';
				Storage::put('public/' . $filename, $data_photos);

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
				$item->photos = 'storage/' . $filename;

				$item->pasien_uuid = $request->pasien_uuid ? $request->pasien_uuid : '-';
				$item->rekam_medis = $request->rekam_medis ? $request->rekam_medis : '-';
				$item->nama_pasien = $request->nama_pasien ? $request->nama_pasien : '-';
				$item->tanggal_lahir = $request->tanggal_lahir ? $request->tanggal_lahir : '-';
				$item->jenis_identitas = $request->jenis_identitas ? $request->jenis_identitas : '-';
				$item->no_identitas = $request->no_identitas ? $request->no_identitas : '-';
				$item->jenis_kelamin = $request->jenis_kelamin ? $request->jenis_kelamin : '-';
				$item->no_handphone = $request->no_handphone ? $request->no_handphone : '-';
				$item->agama = $request->agama ? $request->agama : '-';

				$item->tanggal = date('Y-m-d');
				$item->waktu = date('H:i');

				// if ($request->carabayar_nama == 'BPJS Kesehatan') { // GET DARI API BPJS
				// 	$dokterLocal = Pengguna::where('kode_dokter_bpjs_kes', '=', $request->dokter_bpjs)->first();
				// 	$item->pengguna_uuid = $dokterLocal->uuid;
				// 	$item->nama_dokter = $dokterLocal->nama;
				// 	$item->kode_dokter_bpjs = $request->kode_dokter_bpjs;
				// 	$item->nama_dokter_bpjs = $request->nama_dokter_bpjs;
				// 	$item->jadwal_dokter_bpjs = $request->jadwal_dokter_bpjs;
				// 	$item->kode_poli_bpjs = $request->kode_poli_bpjs;
				// 	$item->nama_poli_bpjs = $request->nama_poli_bpjs;
				// } else {
				// 	$item->pengguna_uuid = $request->pengguna_uuid ? $request->pengguna_uuid : '-';
				// 	$item->nama_dokter = $request->nama_dokter ? $request->nama_dokter : '-';
				// }

				$dokterLocal = Pengguna::where('kode_dokter_bpjs_kes', '=', $request->dokter_bpjs)->first();
				$item->pengguna_uuid = $dokterLocal->uuid;
				$item->nama_dokter = $dokterLocal->nama;
				$item->kode_dokter_bpjs = $request->kode_dokter_bpjs;
				$item->nama_dokter_bpjs = $request->nama_dokter_bpjs;
				$item->jadwal_dokter_bpjs = $request->jadwal_dokter_bpjs;
				$item->kode_poli_bpjs = $request->kode_poli_bpjs;
				$item->nama_poli_bpjs = $request->nama_poli_bpjs;

				$item->no_pendaftaran = $request->no_pendaftaran ? $request->no_pendaftaran : '-';
				$item->cara_masuk = $request->cara_masuk ? $request->cara_masuk : '-';
				$item->rujukan = $request->rujukan ? $request->rujukan : '-';
				$item->carabayar_uuid = $request->carabayar_uuid ? $request->carabayar_uuid : '-';
				$item->carabayar_nama = $request->carabayar_nama ? $request->carabayar_nama : '-';
				$item->no_bpjs_kes = $request->no_bpjs_kes;
				$item->carabayar_nama = $request->carabayar_nama ? $request->carabayar_nama : '-';
				$item->asuransi_uuid = $request->asuransi_uuid ? $request->asuransi_uuid : '-';
				$item->nama_asuransi = $request->nama_asuransi ? $request->nama_asuransi : '-';
				$item->posisi_antrian_ro = $posisi_antrian_ro;
				$item->posisi_antrian_dokter = $posisi_antrian_dokter;
				$item->ruang_poliklinik = $request->ruang_poliklinik ? $request->ruang_poliklinik : 0;
				$item->berkebutuhan_khusus = $request->berkebutuhan_khusus ? $request->berkebutuhan_khusus : '-';
				$item->keterangan_berkebutuhan = $request->keterangan_berkebutuhan ? $request->keterangan_berkebutuhan : '-';
				$item->no_antrian_ro = $kodeRo;
				$item->is_integrated_antrol = 1;
				$status_penjamin = '-';
				$is_approve = '-';
				$is_pay = '-';
				$is_asuransi = '-';
				if ($request->carabayar_nama != 'Umum' && $request->carabayar_nama != 'BPJS Kesehatan') {
					$status_penjamin = 'tunda';
					$is_approve = 'tidak';
					$is_pay = 'tidak';
					$is_asuransi = 'ya';
				}

				if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
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
				$item->save();
				echo ("poli_bpjs" . $request->poli_bpjs);
				$item->is_asuransi = $is_asuransi;

				$arr = array('status' => 'Kunjungan');
				$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);
				// if ($item->carabayar_nama == 'BPJS Kesehatan') {

				// }


				$registrasi_uuid = $uuid;
				$registrasi_kode = 'RJ';
				$registrasi_nomor = $nomor;
				$registrasi_jenis = 'Rawat Jalan';

				$data = new PenanggungJawab();
				$data->uuid = Uuid::uuid4();
				$data->registrasi_uuid = $uuid;
				$data->registrasi_no_pendaftaran = $request->no_pendaftaran;
				$data->registrasi_tipe = 'Rawat Jalan';
				$data->registrasi_kode = 'RJ';
				$data->registrasi_nomor = $nomor;
				$data->registrasi_jenis = 'Rawat Jalan';
				$data->pasien_uuid = $request->pasien_uuid;
				$data->rekam_medis = $request->rekam_medis;
				$data->nama_pasien = $request->nama_pasien;
				$data->pengguna_uuid = $request->pengguna_uuid;
				$data->nama_dokter = $request->nama_dokter;

				$data->nama = $request->nama;
				$data->hubungan = $request->hubungan;
				$data->alamat = $request->alamat;
				$data->jenis_identitas = $request->jenis_identitas;
				$data->no_identitas = $request->no_identitas;
				$data->no_handphone = $request->no_handphone;
				$data->save();


				$pasien = Pasien::where('uuid', $request->pasien_uuid)->first();
				$response = app(AntrolBpjsCtrl::class)->tambahAntrean($item, $pasien);

				$rekammedis = $request->rekam_medis;
				$result = substr($rekammedis, 0, 1);
				// if ($request->carabayar_nama == 'Umum') {

				// }
				// else {
				// 	$remove = LayananPasien::where('registrasi_uuid', '=', $registrasi_uuid)->where('default', '=', 'Ya')->delete();
				// }

				
				if ($result == '0') {
					$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
				} else {
					$check = Registrasi::where('status', '=', 'Selesai')->where('pasien_uuid', '=', $request->pasien_uuid)->first();
					if ($check) {
						$this->savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
					} else {
						$this->savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis);
					}
				}



				$arr = array('status' => 'Kunjungan');
				$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);

				$str = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Sebagai')) . '=' . 'Registrasi';
				event(new NewTradeRo($str));
			}



			DB::commit();

			// return response()->json(['data' => 'berhasil']);
			return response()->json([
				'data' => 'success',
				'bpjs'=> $response
			]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	private function savepasienlama($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis)
	{
		$tindakan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $request->carabayar_uuid)->where('default', '=', 'Ya')
			->where('tindakan_rawat_jalan_uuid', '!=', '6808853b-2aad-4ebd-acee-ec9980a2407d')
			->select(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->groupBy(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->get();
		foreach ($tindakan as $row) {
			$item = new LayananPasien();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $registrasi_uuid;
			$item->no_pendaftaran = $request->no_pendaftaran;
			$item->registrasi_kode = $registrasi_kode;
			$item->registrasi_nomor = $registrasi_nomor;
			$item->registrasi_jenis = $registrasi_jenis;
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

	private function savepasienbaru($request, $registrasi_uuid, $registrasi_kode, $registrasi_nomor, $registrasi_jenis)
	{
		$tindakan = CaraBayarTindakanRawatJalan::where('carabayar_uuid', '=', $request->carabayar_uuid)->where('default', '=', 'Ya')
			->select(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->groupBy(['tindakan_rawat_jalan_uuid', 'nama_tindakan_rawat_jalan', 'harga'])
			->where('tindakan_rawat_jalan_uuid', '!=', 'c13bf9c8-151f-4718-85de-e4d65cf667a8')->get();
		foreach ($tindakan as $row) {
			$item = new LayananPasien();
			$item->uuid = Uuid::uuid4();
			$item->registrasi_uuid = $registrasi_uuid;
			$item->no_pendaftaran = $request->no_pendaftaran;
			$item->registrasi_kode = $registrasi_kode;
			$item->registrasi_nomor = $registrasi_nomor;
			$item->registrasi_jenis = $registrasi_jenis;
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

	public function editrawatjalan(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		$penanggungjawab = PenanggungJawab::where('registrasi_uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman registrasi');
		}

		return response()->json(['data' => $data, 'penanggungjawab' => $penanggungjawab]);
	}

	public function cancelrawatjalan(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$data = Registrasi::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman registrasi');
		}
		$response = "";
		if ($data->is_integrated_antrol == 1) {
			$response = app(AntrolBpjsCtrl::class)->batalAntreanFarmasiBebas($data);
		}

		$arr = array('status' => 'Batal');
		$item = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

		$arr = array('status' => 'Aktif');
		$pasien = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

		// return response()->json(['data' => $data]);
		return response()->json([
				'data' => $data,
				'bpjs'=> $response
			]);
	}

	public function api(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$data = Pasien::where('delete_soft', '=', '1')->where('nama', 'ilike', '%' . $request->keyword . '%')->limit(15)->get();
		return response()->json(['data' => $data]);
	}
}
