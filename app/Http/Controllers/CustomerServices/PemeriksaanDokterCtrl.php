<?php

namespace App\Http\Controllers\CustomerServices;

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
use App\Models\AntrianPoli;

class PemeriksaanDokterCtrl extends Controller
{

	private $take = 35, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function rawatjalan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$no_pendaftaran = $request->no_pendaftaran; 
		$pengguna_uuid = $request->pengguna_uuid; 
		$berkebutuhan_khusus = $request->berkebutuhan_khusus;
		$antrian_saya = Registrasi::where('delete_soft', '=', 1)
								->where('ruang_poliklinik', '!=', '0')
								->where('pengguna_uuid', '=', $pengguna_uuid)
								->where('berkebutuhan_khusus', '=', $berkebutuhan_khusus)
								->where('no_pendaftaran', '=', $no_pendaftaran)
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', 'Kunjungan')
								->orderBy('status_dokter', 'asc')
								->orderBy('posisi_antrian_dokter', 'asc')
								->first();

		$antrian_aktif = Registrasi::where('delete_soft', '=', 1)
								->where('ruang_poliklinik', '!=', '0')
								->where('pengguna_uuid', '=', $pengguna_uuid)
								->where('berkebutuhan_khusus', '=', $berkebutuhan_khusus)
								->where('status_antrian_dokter', '=', 'active')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', 'Kunjungan')
								->orderBy('status_dokter', 'asc')
								->orderBy('posisi_antrian_dokter', 'asc')
								->first();

		$antrian_all = Registrasi::where('delete_soft', '=', 1)
								->where('ruang_poliklinik', '!=', '0')
								->where('pengguna_uuid', '=', $pengguna_uuid)
								->where('berkebutuhan_khusus', '=', $berkebutuhan_khusus)
								->where('status_dokter', '=', 'Belum Diperiksa')
								->whereDate('tanggal', '=', date('Y-m-d'))
								->where('status', 'Kunjungan')
								->orderBy('status_dokter', 'asc')
								->orderBy('posisi_antrian_dokter', 'asc')
								->get();
		$no_poli = 0;
		$antrian_saat_ini = '0';
		$antrian_no = 0;
		$msg = '';
		
		if ($antrian_saya) {

			if ($antrian_aktif && $antrian_aktif->no_pendaftaran == $no_pendaftaran) {
				if ($antrian_aktif->status_dokter == 'Sudah Diperiksa') {
					$msg = 'No antrian '.$no_pendaftaran.' sudah dilakukan pemeriksaan oleh dokter '.$request->nama_dokter.'.';
				}
				else {
					$msg = 'No antrian '.$no_pendaftaran.' sedang dilakukan pemeriksaan oleh dokter '.$request->nama_dokter.'.';
				}
			}
			else {
				$antrian_no = 1;
				foreach ($antrian_all as $row) {
					if ($row->id == $antrian_saya->id) {
						$no_poli = $antrian_saya->ruang_poliklinik;
						break;
					}
					else {
						$antrian_no += 1;
					}
				}
			}
			
		}

		if ($antrian_aktif) {
			$antrian_saat_ini = $antrian_aktif->no_pendaftaran;
		}
		else {
			if ($antrian_saya) {
				$msg = 'Dokter '.$request->nama_dokter.' belum memulai pemanggilan pemeriksaan pasien.';
				$antrian_saat_ini = 'A-000';
			}
			else {
				$msg = 'No antrian '.$no_pendaftaran.' tidak terdaftar didalam pemeriksaan dokter '.$request->nama_dokter.'.';
				$antrian_saat_ini = 'A-000';
			}
			
		}
		
		
		return response()->json([
			'no_poli' => $no_poli,
			'antrian_saat_ini' => $antrian_saat_ini,
			'antrian_no' => $antrian_no,
			'msg' => $msg
		]);
	
	}

}