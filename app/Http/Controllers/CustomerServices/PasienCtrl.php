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
use DateTime;

use App\Models\Pasien;
use App\Models\UploadSuratPersetujuan;
use App\Models\Registrasi;
use App\Models\SuratPersetujuan;
use App\Models\PenanggungJawab;
use PhpOffice\PhpWord\TemplateProcessor;
use PDF;


class PasienCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct()
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl();
	}

	public function list(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;
				$data = Pasien::where('delete_soft', '=', 1)
					->whereYear('tanggal_lahir', '=', $tahun)
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::where('delete_soft', '=', 1)
					->whereYear('tanggal_lahir', '=', $tahun)
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')->count();
			} else if ($column == 'tanggal_lahir') {
				$data = Pasien::where('delete_soft', '=', 1)
					->whereDate($column, '=', $search)
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::where('delete_soft', '=', 1)
					->whereDate($column, '=', $search)
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')->count();
			} else {
				$data = Pasien::where('delete_soft', '=', 1)
					->where($column, 'ilike', '%' . $search . '%')
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::where('delete_soft', '=', 1)
					->where($column, 'ilike', '%' . $search . '%')
					->where('rekam_medis', '!=', 'AP020739')
					->where('rekam_medis', '!=', 'AP026418')
					->where('status', '=', 'Aktif')
					->orderBy('rekam_medis', 'desc')->count();
			}
		} else {
			$data = Pasien::where('delete_soft', '=', 1)
				->where('rekam_medis', '!=', 'AP020739')
				->where('rekam_medis', '!=', 'AP026418')
				->where('status', '=', 'Aktif')
				->orderBy('rekam_medis', 'desc')
				->skip($skip)->take($this->take)
				->get();

			$total = Pasien::where('delete_soft', '=', 1)
				->where('rekam_medis', '!=', 'AP020739')
				->where('rekam_medis', '!=', 'AP026418')
				->where('status', '=', 'Aktif')
				->orderBy('rekam_medis', 'desc')->count();
		}

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function listkunjungan(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = '';
		$total = '';
		$page = $request->page - 1;
		$skip = $page * $this->take;
		$search = $request->search;
		$column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;

				$data = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid = (
						SELECT a2.uuid 
						FROM registrasi as a2 
						WHERE a2.pasien_uuid = pasien.uuid 
						ORDER BY a2.created_at DESC 
						LIMIT 1
					)');
				})
					->where('pasien.delete_soft', '=', 1)
					->whereYear('pasien.tanggal_lahir', '=', $tahun)
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('pasien.status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid = (
						SELECT a2.uuid 
						FROM registrasi as a2 
						WHERE a2.pasien_uuid = pasien.uuid 
						ORDER BY a2.created_at DESC 
						LIMIT 1
					)');
				})
					->where('pasien.delete_soft', '=', 1)
					->whereYear('pasien.tanggal_lahir', '=', $tahun)
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('pasien.status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->count();
			} else if ($column == 'tanggal_lahir') {
				$data = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid IN (select MAX(a2.uuid) from registrasi as a2 join pasien as u2 on u2.uuid = a2.pasien_uuid group by u2.uuid)');
				})
					->where('pasien.delete_soft', '=', 1)
					->whereDate('pasien.' . $column, '=', $search)
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('pasien.status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid IN (select MAX(a2.uuid) from registrasi as a2 join pasien as u2 on u2.uuid = a2.pasien_uuid group by u2.uuid)');
				})
					->where('pasien.delete_soft', '=', 1)
					->whereDate('pasien.' . $column, '=', $search)
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->count();
			} else {
				$data = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid IN (select MAX(a2.uuid) from registrasi as a2 join pasien as u2 on u2.uuid = a2.pasien_uuid group by u2.uuid)');
				})
					->where('pasien.delete_soft', '=', 1)
					->where('pasien.' . $column, 'ilike', '%' . $search . '%')
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('pasien.status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->skip($skip)->take($this->take)
					->get();
				$total = Pasien::leftJoin('registrasi', function ($query) {
					$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
						->whereRaw('registrasi.uuid IN (select MAX(a2.uuid) from registrasi as a2 join pasien as u2 on u2.uuid = a2.pasien_uuid group by u2.uuid)');
				})
					->where('pasien.delete_soft', '=', 1)
					->where('pasien.' . $column, 'ilike', '%' . $search . '%')
					->where('pasien.rekam_medis', '!=', 'AP020739')
					->where('pasien.rekam_medis', '!=', 'AP026418')
					->where('pasien.status', '!=', 'Aktif')
					->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
					->orderBy('registrasi.nomor', 'desc')
					->count();
			}
		} else {
			$data = Pasien::leftJoin('registrasi', function ($query) {
				// TODO CHECK	
				$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
					->whereRaw('registrasi.uuid = (
										SELECT a2.uuid 
										FROM registrasi as a2 
										WHERE a2.pasien_uuid = pasien.uuid 
										ORDER BY a2.created_at DESC 
										LIMIT 1
									)');
			})
				->where('pasien.delete_soft', '=', 1)
				->where('pasien.rekam_medis', '!=', 'AP020739')
				->where('pasien.rekam_medis', '!=', 'AP026418')
				->where('pasien.status', '!=', 'Aktif')
				->skip($skip)->take($this->take)
				->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
				->orderBy('registrasi.nomor', 'desc')
				->get();

			$total = Pasien::leftJoin('registrasi', function ($query) {
				$query->on('registrasi.pasien_uuid', '=', 'pasien.uuid')
					->whereRaw('registrasi.uuid = (
					SELECT a2.uuid 
					FROM registrasi as a2 
					WHERE a2.pasien_uuid = pasien.uuid 
					ORDER BY a2.created_at DESC 
					LIMIT 1
				)');
			})
				->where('pasien.delete_soft', '=', 1)
				->where('pasien.rekam_medis', '!=', 'AP020739')
				->where('pasien.rekam_medis', '!=', 'AP026418')
				->where('pasien.status', '!=', 'Aktif')
				->select('pasien.*', 'registrasi.nomor', 'registrasi.no_antrian_ro', 'registrasi.no_antrian_poli', 'registrasi.no_antrian_farmasi', 'registrasi.no_antrian_kasir')
				->orderBy('registrasi.nomor', 'desc')
				->count();
		}

		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function uploadfile(Request $request)
	{
		$file = $request->file('datafile');
		$file_extension = $file->getClientOriginalExtension(); //** get filename extension
		$fileName = 'suratpersetujuan/' . $request->pasien_uuid . '_files.' . $file_extension;
		$uploaded = Storage::put('public/' . $fileName, file_get_contents($file->getRealPath()));

		$pasien = Pasien::where('uuid', '=', $request->pasien_uuid)->select('uuid', 'nama', 'rekam_medis')->first();

		$arr = array('status' => 'non');
		$non = UploadSuratPersetujuan::where('pasien_uuid', '=', $request->pasien_uuid)->update($arr);

		$item = new UploadSuratPersetujuan();
		$item->pasien_uuid = $pasien->uuid;
		$item->rekam_medis = $pasien->rekam_medis;
		$item->nama_pasien = $pasien->nama;
		$item->filename = 'storage/' . $fileName;
		$item->tanggal = date('Y-m-d');
		$item->jam = date('H:i');
		$item->save();

		return response()->json(['data' => 'berhasil']);
	}

	public function suratpersetujuan(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan data pasien dengan nama pasien "' . $request->nama_pasien . '".');

		try {
			DB::beginTransaction();

			// $remove = suratpersetujuan::where('pasien_uuid', '=', $request->pasien_uuid)->delete();
			$surat_ke = 1;
			$cek = SuratPersetujuan::select('surat_ke')->orderBy('id', 'desc')->first();
			if ($cek) {
				$surat_ke = $surat_ke + (int) $cek->surat_ke;
			}

			if ($surat_ke > 9999) {
				$surat_ke = 1;
			}

			$item = new SuratPersetujuan();
			$item->uuid = Uuid::uuid4();;
			$item->pasien_uuid = $request->pasien_uuid;
			$item->rekam_medis = $request->rekam_medis;
			$item->nama_pasien = $request->nama_pasien;
			$item->tempat_lahir = $request->tempat_lahir;
			$item->tanggal_lahir = $request->tanggal_lahir;
			$item->no_identitas = $request->no_identitas;
			$item->no_handphone = $request->no_handphone;
			$item->jenis_kelamin = $request->jenis_kelamin;
			$item->jenis_identitas = $request->jenis_identitas;
			$item->tanggal = date('Y-m-d');
			$item->waktu = date('H:i');
			$item->pelepasan_informasi = $request->pelepasan_informasi;
			$item->penerima = $request->penerima;
			$item->surat_ke = $surat_ke;
			$item->save();

			DB::commit();

			$data = Pasien::where('uuid', '=', $request->pasien_uuid)->first();

			return response()->json(['data' => $data]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function printsuratpersetujuan($uuid)
	{
		$pdf = \App::make('dompdf.wrapper');
		$surat = suratpersetujuan::where('pasien_uuid', '=', $uuid)->orderBy('id', 'desc')->first();

		$pdf->loadView('print.printpersetujuan', compact('surat'))->setPaper('a4', 'potrait');


		return $pdf->stream();
	}

	public function add(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Menambahkan data pasien dengan nama pasien "' . $request->nama . '".');

		$uuid = '';
		$loop = false;
		do {
			$uuid = Uuid::uuid4();
			$check = Pasien::where('uuid', '=', $uuid)->first();
			if (!$check) {
				$loop = true;
			}
		} while ($loop == false);

		try {
			DB::beginTransaction();

			$pasien = Pasien::where('tahun', '=', date('y'))->orderBy('nomor', 'desc')->first();
			$nomor = 1;
			if ($pasien) {
				$nomor += $pasien->nomor;
			}
			$rekam_medis = date('y') . '' . date('m');
			$angka_nol = '-';
			if ($nomor < 10) {
				$angka_nol = '0000';
				$rekam_medis .= '0000' . $nomor;
			} else if ($nomor > 9 && $nomor < 100) {
				$angka_nol = '000';
				$rekam_medis .= '000' . $nomor;
			} else if ($nomor > 99 && $nomor < 1000) {
				$angka_nol = '00';
				$rekam_medis .= '00' . $nomor;
			} else if ($nomor > 999 && $nomor < 10000) {
				$angka_nol = '0';
				$rekam_medis .= '0' . $nomor;
			} else if ($nomor > 9999 && $nomor < 100000) {
				$angka_nol = '-';
				$rekam_medis .= $nomor;
			}
			$item = new Pasien();
			$item->uuid = $uuid;
			$item->rekam_medis = $rekam_medis;
			$item->tahun = date('y');
			$item->bulan = date('m');
			$item->angka_nol = $angka_nol;
			$item->nomor = $nomor;
			$item->nama = $request->nama;
			$item->no_ktp = $request->no_ktp;
			$item->no_bpjs = $request->no_bpjs;
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
			$item->nama_provinsi = $request->nama_provinsi ? $request->nama_provinsi : '-';
			$item->kab_kota_id = $request->kab_kota_id ? $request->kab_kota_id : 0;
			$item->nama_kab_kota = $request->nama_kab_kota ? $request->nama_kab_kota : '-';
			$item->kecamatan_id = $request->kecamatan_id ? $request->kecamatan_id : 0;
			$item->nama_kecamatan = $request->nama_kecamatan ? $request->nama_kecamatan : '-';
			$item->kelurahan_id = $request->kelurahan_id ? $request->kelurahan_id : 0;
			$item->nama_kelurahan = $request->nama_kelurahan && $request->nama_kelurahan != 'Silahkan Pilih'  ? $request->nama_kelurahan : '-';
			$item->pendidikan_terakhir = $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '-';
			$item->pekerjaan = $request->pekerjaan ? $request->pekerjaan : '-';
			$item->status_pernikahan = $request->status_pernikahan ? $request->status_pernikahan : '-';
			$item->agama = $request->agama ? $request->agama : '';
			$item->jenis_kelamin = $request->jenis_kelamin;
			$item->jenis_identitas = $request->jenis_identitas;
			$item->golongan_darah = $request->golongan_darah ? $request->golongan_darah : '-';
			$item->sebutan = $request->sebutan ? $request->sebutan : '-';
			$umur = $this->hitung_umur($request->tanggal_lahir);
			$kelompok_umur_nama = '-';
			$kelompok_umur_posisi = '-';
			$kelompok_umur_minimal = 0;
			$kelompok_umur_maksimal = 0;
			if ($umur <= 2) {
				$kelompok_umur_nama = 'Bayi';
				$kelompok_umur_posisi = '0-2 Tahun';
				$kelompok_umur_minimal = 0;
				$kelompok_umur_maksimal = 2;
			} else if ($umur > 2 && $umur <= 5) {
				$kelompok_umur_nama = 'Balita';
				$kelompok_umur_posisi = '3-5 Tahun';
				$kelompok_umur_minimal = 3;
				$kelompok_umur_maksimal = 5;
			} else if ($umur > 5 && $umur <= 18) {
				$kelompok_umur_nama = 'Anak-Anak';
				$kelompok_umur_posisi = '6-18 Tahun';
				$kelompok_umur_minimal = 6;
				$kelompok_umur_maksimal = 18;
			} else if ($umur > 18 && $umur <= 60) {
				$kelompok_umur_nama = 'Dewasa';
				$kelompok_umur_posisi = '19-60 Tahun';
				$kelompok_umur_minimal = 19;
				$kelompok_umur_maksimal = 60;
			} else if ($umur > 60) {
				$kelompok_umur_nama = 'Lansia';
				$kelompok_umur_posisi = '>61 Tahun';
				$kelompok_umur_minimal = 61;
				$kelompok_umur_maksimal = 200;
			}
			$item->kelompok_umur_nama = $kelompok_umur_nama;
			$item->kelompok_umur_posisi = $kelompok_umur_posisi;
			$item->kelompok_umur_minimal = $kelompok_umur_minimal;
			$item->kelompok_umur_maksimal = $kelompok_umur_maksimal;
			$item->is_printer_card = 'Belum';
			$item->save();

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	private function hitung_umur($tanggal_lahir)
	{
		$birthDate = new DateTime($tanggal_lahir);
		$today = new DateTime("today");
		if ($birthDate > $today) {
			exit("0 tahun 0 bulan 0 hari");
		}
		$y = $today->diff($birthDate)->y;
		$m = $today->diff($birthDate)->m;
		$d = $today->diff($birthDate)->d;
		//return $y." tahun ".$m." bulan ".$d." hari";
		return $y;
	}

	public function edit(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman edit pasien');
		}

		return response()->json(['data' => $data]);
	}

	public function detail(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = Pasien::where('uuid', '=', $request->uuid)->first();
		if ($data) {
			PenggunaHelp::log('Mengambil data pasien dengan nama pasien "' . $data->nama . '" dan id "' . $data->id . '" untuk ditampilkan dihalaman detail pasien');
		}

		$registrasi = Registrasi::where('pasien_uuid', '=', $request->uuid)->orderBy('id', 'desc')->limit(12)->get();

		return response()->json(['data' => $data, 'registrasi' => $registrasi]);
	}

	public function update(Request $request)
	{

		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		PenggunaHelp::log('Mengupdate data icd 9 dengan nama "' . $request->nama . '".');

		$umur = $this->hitung_umur($request->tanggal_lahir);
		$kelompok_umur_nama = '-';
		$kelompok_umur_posisi = '-';
		$kelompok_umur_minimal = 0;
		$kelompok_umur_maksimal = 0;
		if ($umur <= 2) {
			$kelompok_umur_nama = 'Bayi';
			$kelompok_umur_posisi = '0-2 Tahun';
			$kelompok_umur_minimal = 0;
			$kelompok_umur_maksimal = 2;
		} else if ($umur > 2 && $umur <= 5) {
			$kelompok_umur_nama = 'Balita';
			$kelompok_umur_posisi = '3-5 Tahun';
			$kelompok_umur_minimal = 3;
			$kelompok_umur_maksimal = 5;
		} else if ($umur > 5 && $umur <= 18) {
			$kelompok_umur_nama = 'Anak-Anak';
			$kelompok_umur_posisi = '6-18 Tahun';
			$kelompok_umur_minimal = 6;
			$kelompok_umur_maksimal = 18;
		} else if ($umur > 18 && $umur <= 60) {
			$kelompok_umur_nama = 'Dewasa';
			$kelompok_umur_posisi = '19-60 Tahun';
			$kelompok_umur_minimal = 19;
			$kelompok_umur_maksimal = 60;
		} else if ($umur > 60) {
			$kelompok_umur_nama = 'Lansia';
			$kelompok_umur_posisi = '>61 Tahun';
			$kelompok_umur_minimal = 61;
			$kelompok_umur_maksimal = 200;
		}

		$arr = array(
			'nama' => $request->nama,
			'no_ktp' => $request->no_ktp,
			'no_bpjs' => $request->no_bpjs,
			'alias' => $request->alias ? $request->alias : '-',
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $request->tanggal_lahir,
			'no_identitas' => $request->no_identitas,
			'email' => $request->email ? $request->email : '-',
			'alamat' => $request->alamat ? $request->alamat : '',
			'no_handphone' => $request->no_handphone ? $request->no_handphone : '-',
			'kodepos' => $request->kodepos ? $request->kodepos : '-',
			'rt_rw' => $request->rt_rw ? $request->rt_rw : '-',
			'nama_ayah' => $request->nama_ayah ? $request->nama_ayah : '-',
			'nama_ibu' => $request->nama_ibu ? $request->nama_ibu : '-',
			'provinsi_id' => $request->provinsi_id ? $request->provinsi_id : 0,
			'nama_provinsi' => $request->nama_provinsi ? $request->nama_provinsi : '-',
			'kab_kota_id' => $request->kab_kota_id ? $request->kab_kota_id : 0,
			'nama_kab_kota' => $request->nama_kab_kota ? $request->nama_kab_kota : '-',
			'kecamatan_id' => $request->kecamatan_id ? $request->kecamatan_id : 0,
			'nama_kecamatan' => $request->nama_kecamatan ? $request->nama_kecamatan : '-',
			'kelurahan_id' => $request->kelurahan_id ? $request->kelurahan_id : 0,
			'nama_kelurahan' => $request->nama_kelurahan && $request->nama_kelurahan != 'Silahkan Pilih'  ? $request->nama_kelurahan : '-',
			'pendidikan_terakhir' => $request->pendidikan_terakhir ? $request->pendidikan_terakhir : '-',
			'pekerjaan' => $request->pekerjaan ? $request->pekerjaan : '-',
			'status_pernikahan' => $request->status_pernikahan ? $request->status_pernikahan : '-',
			'agama' => $request->agama ? $request->agama : '',
			'jenis_kelamin' => $request->jenis_kelamin,
			'jenis_identitas' => $request->jenis_identitas,
			'golongan_darah' => $request->golongan_darah ? $request->golongan_darah : '-',
			'sebutan' => $request->sebutan ? $request->sebutan : '-',
			'kelompok_umur_nama' => $kelompok_umur_nama,
			'kelompok_umur_posisi' => $kelompok_umur_posisi,
			'kelompok_umur_minimal' => $kelompok_umur_minimal,
			'kelompok_umur_maksimal' => $kelompok_umur_maksimal,
		);

		try {
			DB::beginTransaction();

			$update = Pasien::where('uuid', '=', $request->uuid)->update($arr);

			DB::commit();

			return response()->json(['data' => 'berhasil']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['hasil' => 'gagal']);
		}
	}

	public function api(Request $request)
	{
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}
		$data = Pasien::where('delete_soft', '=', '1')->where('nama', 'ilike', '%' . $request->keyword . '%')->limit(15)->get();
		return response()->json(['data' => $data]);
	}

	public function pdf($uuid)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pasien = Pasien::where('uuid', '=', $uuid)->first();
		$arr = array('is_printer_card' => 'Sudah');
		$update = Pasien::where('uuid', '=', $uuid)->update($arr);
		$customPaper = array(0, 0, 260, 425);
		$pdf->loadView('print.cetakkartu', compact('pasien'))->setPaper($customPaper, 'landscape');
		return $pdf->stream();
	}

	public function label($uuid)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pasien = Pasien::where('uuid', '=', $uuid)->first();
		$customPaper = array(0, 0, 118, 285);
		$pdf->loadView('print.cetaklabel', compact('pasien'))->setPaper($customPaper, 'landscape');
		return $pdf->stream();
	}

	public function identitaspasien($uuid)
	{
		$pdf = \App::make('dompdf.wrapper');
		$registrasi = Registrasi::where('pasien_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$pasien = Pasien::where('uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$penanggungjawab = PenanggungJawab::where('pasien_uuid', '=', $uuid)->orderBy('id', 'desc')->first();
		$pdf->loadView('print.cetakidentitas', compact('pasien', 'registrasi', 'penanggungjawab'))->setPaper('a4', 'potrait');
		return $pdf->stream();
	}

	public function listpemeriksaan($uuid)
	{
		$registrasi = Registrasi::select([
			DB::raw("CONCAT(registrasi.kode, registrasi.nomor) as kode"),
			'registrasi.tanggal',
			'registrasi.uuid',
			'registrasi.nama_dokter',
			'p_ro.tekanan_darah',
			'p_ro.berat_badan',
			'p_ro.tinggi_badan',
			'p_ro.suhu',
			'p_ro.ocular_dextra_autoref',
			'p_ro.ocular_dextra_visus',
			'p_ro.ocular_dextra_tonometri',
			'p_ro.ocular_sinistra_autoref',
			'p_ro.ocular_sinistra_visus',
			'p_ro.ocular_sinistra_tonometri',
		])->where('registrasi.pasien_uuid', $uuid)
			->leftJoin('pemeriksaan_dokter', 'pemeriksaan_dokter.registrasi_uuid', '=', 'registrasi.uuid')
			// Entah kenapa, pemeriksaan_ro dapat diinput lebih dari sekali untuk satu registrasi
			->leftJoinSub(
				fn($q) => $q->from('pemeriksaan_ro')->select([
					'registrasi_uuid',
					'tekanan_darah',
					'berat_badan',
					'tinggi_badan',
					'suhu',
					'ocular_dextra_autoref',
					'ocular_dextra_visus',
					'ocular_dextra_tonometri',
					'ocular_sinistra_autoref',
					'ocular_sinistra_visus',
					'ocular_sinistra_tonometri'
				])->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY created_at DESC) as urutan'),
				'p_ro',
				fn($q) => $q->on('p_ro.registrasi_uuid', '=', 'registrasi.uuid')->where('p_ro.urutan', '=', 1)
			)
			->orderBy('registrasi.created_at', 'DESC');

		return response()->json($registrasi->get());
	}

	public function cetaksuratsakit($uuid)
	{
		$pasien = Pasien::where('uuid', '=', $uuid)->orderBy('id', 'desc')->first();

		$values = [
			'nama' => $pasien->nama,
			'rekam_medis' => $pasien->rekam_medis,
			'now' => now()->locale('id_ID')->isoFormat('MMMM YYYY')
		];

		$template = new TemplateProcessor(resource_path("doc_templates/suratsakit.docx"));
		$template->setValues($values);

		Storage::makeDirectory('tmp');
		$storagePath = storage_path("/app/tmp/Surat Sakit - {$pasien->rekam_medis} - {$pasien->nama}.docx");

		$template->saveAs($storagePath);

		return response()->download($storagePath, "Surat Sakit - {$pasien->rekam_medis} - {$pasien->nama}.docx")
			->deleteFileAfterSend();
	}

	public function cetaksuratsehat($uuid)
	{
		$pasien = Registrasi::select([
			'pasien.tanggal_lahir',
			'pasien.alamat',
			'pasien.nama',
			'pasien.rekam_medis',
			'p_ro.tekanan_darah',
			'p_ro.berat_badan',
			'p_ro.tinggi_badan',
			'p_ro.suhu',
		])->where('registrasi.uuid', $uuid)
			->join('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
			// Entah kenapa, pemeriksaan_ro dapat diinput lebih dari sekali untuk satu registrasi
			->leftJoinSub(
				fn($q) => $q->from('pemeriksaan_ro')->select([
					'registrasi_uuid',
					'tekanan_darah',
					'berat_badan',
					'tinggi_badan',
					'suhu',
				])->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY created_at DESC) as urutan'),
				'p_ro',
				fn($q) => $q->on('p_ro.registrasi_uuid', '=', 'registrasi.uuid')->where('p_ro.urutan', '=', 1)
			)->first();

		$values = [
			'nama' => $pasien->nama,
			'age' => now()->diffInYears(\Carbon\Carbon::parse($pasien->tanggal_lahir)),
			'address' => $pasien->alamat,
			'height' => $pasien->tinggi_badan,
			'weight' => $pasien->berat_badan,
			'blood_pressure' => $pasien->tekanan_darah,
			'temp' => $pasien->suhu,
			'now' => now()->locale('id_ID')->isoFormat('MMMM YYYY')
		];

		$template = new TemplateProcessor(resource_path("doc_templates/suratsehat.docx"));
		$template->setValues($values);

		Storage::makeDirectory('tmp');
		$storagePath = storage_path("/app/tmp/Surat Sehat - {$pasien->rekam_medis} - {$pasien->nama}.docx");

		$template->saveAs($storagePath);

		return response()->download($storagePath, "Surat Sehat - {$pasien->rekam_medis} - {$pasien->nama}.docx")
			->deleteFileAfterSend();
	}

	public function cetaksuratro($uuid)
	{
		$pasien = Registrasi::select([
			'pasien.tanggal_lahir',
			'pasien.alamat',
			'pasien.nama',
			'pasien.rekam_medis',
			'registrasi.tanggal',
			DB::raw('pemeriksaan_dokter.tanggal as tanggal_periksa'),
			'p_ro.ocular_dextra_autoref',
			'p_ro.ocular_dextra_visus',
			'p_ro.ocular_dextra_tonometri',
			'p_ro.ocular_sinistra_autoref',
			'p_ro.ocular_sinistra_visus',
			'p_ro.ocular_sinistra_tonometri',
		])->where('registrasi.uuid', $uuid)
			->leftJoin('pemeriksaan_dokter', 'pemeriksaan_dokter.registrasi_uuid', '=', 'registrasi.uuid')
			->join('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
			// Entah kenapa, pemeriksaan_ro dapat diinput lebih dari sekali untuk satu registrasi
			->leftJoinSub(
				fn($q) => $q->from('pemeriksaan_ro')->select([
					'registrasi_uuid',
					'tekanan_darah',
					'berat_badan',
					'tinggi_badan',
					'suhu',
					'ocular_dextra_autoref',
					'ocular_dextra_visus',
					'ocular_dextra_tonometri',
					'ocular_sinistra_autoref',
					'ocular_sinistra_visus',
					'ocular_sinistra_tonometri'
				])->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY created_at DESC) as urutan'),
				'p_ro',
				fn($q) => $q->on('p_ro.registrasi_uuid', '=', 'registrasi.uuid')->where('p_ro.urutan', '=', 1)
			)->first();

		$values = [
			'nama' => $pasien->nama,
			'rekam_medis' => $pasien->rekam_medis,
			'tanggal' => $pasien->tanggal_periksa ?? $pasien->tanggal,
			'autorefkeratometry_od' => $pasien->ocular_dextra_autoref,
			'autorefkeratometry_os' => $pasien->ocular_sinistra_autoref,
			'visus_od' => $pasien->ocular_dextra_visus,
			'visus_os' => $pasien->ocular_sinistra_visus,
			'tonometry_od' => $pasien->ocular_dextra_tonometri,
			'tonometry_os' => $pasien->ocular_sinistra_tonometri,
			'slit_lamp' => '',
			'funduscopy' => '',
			'diagnosa' => '',
			'anjuran' => '',
			'now' => now()->locale('id_ID')->isoFormat('MMMM YYYY')
		];

		$template = new TemplateProcessor(resource_path("doc_templates/suratro.docx"));
		$template->setValues($values);

		Storage::makeDirectory('tmp');
		$storagePath = storage_path("/app/tmp/Surat RO - {$pasien->rekam_medis} - {$pasien->nama}.docx");

		$template->saveAs($storagePath);

		return response()->download($storagePath, "Surat RO - {$pasien->rekam_medis} - {$pasien->nama}.docx")
			->deleteFileAfterSend();
	}
}
