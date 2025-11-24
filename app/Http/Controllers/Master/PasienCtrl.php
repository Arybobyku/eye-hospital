<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use App\Models\DokumenFormLaserBargage;
use App\Models\DokumenLaporanPembedahan;
use App\Models\DokumenPersetujuanPenolakanTindakanDokter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Storage;
use DateTime;

use App\Models\Pasien;
use App\Models\Resep;
use App\Models\LayananPasien;
use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanRo;
use App\Models\UploadSuratPersetujuan;
use App\Models\Registrasi;
use App\Models\SuratPersetujuan;
use App\Models\PenanggungJawab;
use PDF;


class PasienCtrl extends Controller
{

	private $take = 15, $error = 'next';

	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		$this->error = PenggunaHelp::acl(); 
	}

	public function list(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
			if ($column == 'usia') {
				$tahun = date('Y');
				$tahun = $tahun - $search;
				$data = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereYear('tanggal_lahir', '=', $tahun)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
			else if ($column == 'tanggal_lahir') {
				$data = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->whereDate($column, '=', $search)
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
			else {
				$data = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->where($column, 'ilike', '%'.$search.'%')
								->where('rekam_medis', '!=', 'AP020739')
								->orderBy('status', 'desc')->count();
			}
		}
		else {
			$data = Pasien::where('delete_soft', '=', 1)
									->where('rekam_medis', '!=', 'AP020739')
									->orderBy('status', 'desc')
									->skip($skip)->take($this->take)
									->get();

			$total = Pasien::where('delete_soft', '=', 1)->where('rekam_medis', '!=', 'AP020739')->orderBy('status', 'desc')->count();

		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function search(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; $column = $request->column;

		if ($request->search != "") {
				$data = Pasien::where('delete_soft', '=', 1)
								->where(function ($q) use ($search) {
									$q->where('nama', 'ilike', '%' . $search . '%')
									->orWhere('no_identitas', 'ilike', '%' . $search . '%')
									->orWhere('rekam_medis', 'ilike', '%' . $search . '%');
								})
								->skip($skip)->take($this->take)
								->get();
				$total = Pasien::where('delete_soft', '=', 1)
								->where(function ($q) use ($search) {
									$q->where('nama', 'ilike', '%' . $search . '%')
									->orWhere('no_identitas', 'ilike', '%' . $search . '%')
									->orWhere('rekam_medis', 'ilike', '%' . $search . '%');
								})
								->orderBy('status', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function history(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; 

		if ($request->search != "") {
				$data = Registrasi::where('delete_soft', '=', 1)
								->where('pasien_uuid', '=', $search)
								->orderBy('tanggal', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Registrasi::where('delete_soft', '=', 1)
								->where('pasien_uuid', '=', $search)
								->orderBy('tanggal', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}

	public function soap(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		PenggunaHelp::log('Melihat data list table pada halaman data pasien');

		$list = ''; $total = '';
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; 

		if ($request->search != "") {
				$data = Cppt::with('registrasi','pemeriksaanDokter')
				                ->where('pasien_uuid', '=', $search)
				                // ->where('sebagai', '=', 'DOKTER')
								->orderBy('created_at', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = Cppt::where('pasien_uuid', '=', $search)
				                // ->where('sebagai', '=', 'DOKTER')
								->orderBy('created_at', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);
	
	}


	public function obat(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Resep::join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
						->where('registrasi.status', '=', 'Selesai')
						->select('resep.*')
						->where('resep.pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}


	public function tindakanPasien(Request $request) {

		$data = LayananPasien::join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('layanan_pasien.*')
							->where('layanan_pasien.pasien_uuid', '=', $request->search)
							->where('layanan_pasien.jenis', '!=', 'Obat-Obatan')
							->get();

		$total = LayananPasien::join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('layanan_pasien.*')
							->where('layanan_pasien.pasien_uuid', '=', $request->search)
							->where('layanan_pasien.jenis', '!=', 'Obat-Obatan')
							->count();
	
		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function tandaUmumPasien(Request $request) {

		$data = PemeriksaanRo::join('registrasi', 'pemeriksaan_ro.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('pemeriksaan_ro.*')
							->where('pemeriksaan_ro.pasien_uuid', '=', $request->search)
							->get();

		$total = PemeriksaanRo::join('registrasi', 'pemeriksaan_ro.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('pemeriksaan_ro.*')
							->where('pemeriksaan_ro.pasien_uuid', '=', $request->search)
							->count();
	
		return response()->json(['data' => $data, 'total' => $total]);
	}

	public function tindakan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = LayananPasien::join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
							->where('registrasi.status', '=', 'Selesai')
							->select('layanan_pasien.*')
							->where('layanan_pasien.pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}

	public function kunjungan(Request $request) {

		if ($this->error != 'next') { return response()->json(['data' => $this->error]); }

		$data = Registrasi::where('status', '=', 'Selesai')
							->where('pasien_uuid', '=', $request->uuid)->get();
		// if ($data) {
		// 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
		// }
		
		return response()->json(['data' => $data]);
	}


	public function dokumenPersetujuanPenolakan(Request $request){
		if ($this->error != 'next') {
			return response()->json(['data' => $this->error]);
		}

		$data = DokumenPersetujuanPenolakanTindakanDokter::store($request);

		return response()->json(['data' => $data]);

	}
	public function listDokumenPersetujuanPenolakan(Request $request){
		$page = $request->page - 1; $skip = $page * $this->take;
		$search = $request->search; 

		if ($request->search != "") {
				$data = DokumenPersetujuanPenolakanTindakanDokter::join('pasien', 'dokumen_persetujuan_penolakan_tindakan_dokter.uuid_pasien', '=', 'pasien.uuid')
				  ->where('uuid_pasien', '=', $search)
								->orderBy('date', 'desc')
								->skip($skip)->take($this->take)
								->get();
				$total = DokumenPersetujuanPenolakanTindakanDokter::join('pasien', 'dokumen_persetujuan_penolakan_tindakan_dokter.uuid_pasien', '=', 'pasien.uuid')
				  ->where('uuid_pasien', '=', $search)
								->orderBy('date', 'desc')
								->orderBy('date', 'desc')->count();
		}
		
		return response()->json(['data' => $data, 'total' => $total]);

	}

	public function storeLaporanPembedahan(Request $request)
    {
        try {
            DB::beginTransaction();

            // Konversi checkbox boolean dari string
            $booleanFields = [
                'anestesi_umum', 
                'anestesi_spiral', 
                'anestesi_epidural',
                'anestesi_bsp', 
                'anestesi_csp', 
                'anestesi_lokal'
            ];

            $data = $request->all();
            
            foreach ($booleanFields as $field) {
                if (isset($data[$field])) {
                    $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
                }
            }

            // Tambahkan user yang membuat
            $data['created_by'] = Auth::user()->name ?? 'System';

            // Simpan data
            $laporan = DokumenLaporanPembedahan::create($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Laporan Pembedahan berhasil disimpan',
                'data' => $laporan
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Laporan Pembedahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

	public function storeFormLaseBarage(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['created_by'] = Auth::user()->name ?? 'System';

            // Simpan data
            $dokumen = DokumenFormLaserBargage::create($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Form Laser Bargage berhasil disimpan',
                'data' => $dokumen
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Form Laser Bargage',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}