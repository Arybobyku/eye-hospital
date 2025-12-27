<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use App\Models\DokumenAsuhanGizi;
use App\Models\DokumenBalanceCairanHarian;
use App\Models\DokumenDietitianPasienBaru;
use App\Models\DokumenFormLaserBargage;
use App\Models\DokumenLaporanPembedahan;
use App\Models\DokumenPersetujuanPenolakanTindakanDokter;
use App\Models\DokumenResumePerawatanRawatJalan;
use App\Models\DokumenSuratBalasanKonsul;
use App\Models\DokumenSuratKonsul;
use App\Models\DokumenSuratKontrol;
use App\Models\DokumenSuratPenolakanRujukan;
use App\Models\DokumenSuratPernyataanBatalOperasi;
use App\Models\DokumenSuratPernyataanPasienUmum;
use App\Models\DokumenPersetujuanUmum;
use App\Models\DokumenTindakanLaserLPI;
use App\Models\DokumenTindakanLaserPRP;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\PemeriksaanRo;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\DokumenLaporanOperasiTrabekulektomi;
use App\Models\DokumenLaporanOperasiPterygium;
use App\Models\DokumenLaporanEksisiPalpebra;
use Cookie;
use Crypt;
use DB;
use Illuminate\Http\Request;
use PenggunaHelp;
use Ramsey\Uuid\Uuid;

class PasienCtrl extends Controller
{
    private $take = 15;

    private $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
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

        if ($request->search != '') {
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
            } elseif ($column == 'tanggal_lahir') {
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
            } else {
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
        } else {
            $data = Pasien::where('delete_soft', '=', 1)
                ->where('rekam_medis', '!=', 'AP020739')
                ->orderBy('status', 'desc')
                ->skip($skip)->take($this->take)
                ->get();

            $total = Pasien::where('delete_soft', '=', 1)->where('rekam_medis', '!=', 'AP020739')->orderBy('status', 'desc')->count();

        }

        return response()->json(['data' => $data, 'total' => $total]);

    }

    public function search(Request $request)
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

        if ($request->search != '') {
            $data = Pasien::where('delete_soft', '=', 1)
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'ilike', '%'.$search.'%')
                        ->orWhere('no_identitas', 'ilike', '%'.$search.'%')
                        ->orWhere('rekam_medis', 'ilike', '%'.$search.'%');
                })
                ->skip($skip)->take($this->take)
                ->get();
            $total = Pasien::where('delete_soft', '=', 1)
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'ilike', '%'.$search.'%')
                        ->orWhere('no_identitas', 'ilike', '%'.$search.'%')
                        ->orWhere('rekam_medis', 'ilike', '%'.$search.'%');
                })
                ->orderBy('status', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);

    }

    public function history(Request $request)
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

        if ($request->search != '') {
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

    public function soap(Request $request)
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

        if ($request->search != '') {
            $data = Cppt::with('registrasi', 'pemeriksaanDokter')
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

    public function obat(Request $request)
    {

        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Resep::join('registrasi', 'resep.registrasi_uuid', '=', 'registrasi.uuid')
            ->where('registrasi.status', '=', 'Selesai')
            ->select('resep.*')
            ->where('resep.pasien_uuid', '=', $request->uuid)->get();
        // if ($data) {
        // 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
        // }

        return response()->json(['data' => $data]);
    }

    public function tindakanPasien(Request $request)
    {

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

    public function tandaUmumPasien(Request $request)
    {

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

    public function tindakan(Request $request)
    {

        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = LayananPasien::join('registrasi', 'layanan_pasien.registrasi_uuid', '=', 'registrasi.uuid')
            ->where('registrasi.status', '=', 'Selesai')
            ->select('layanan_pasien.*')
            ->where('layanan_pasien.pasien_uuid', '=', $request->uuid)->get();
        // if ($data) {
        // 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
        // }

        return response()->json(['data' => $data]);
    }

    public function kunjungan(Request $request)
    {

        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('status', '=', 'Selesai')
            ->where('pasien_uuid', '=', $request->uuid)->get();
        // if ($data) {
        // 	PenggunaHelp::log('Mengambil data pasien dengan nama pasien "'.$data->nama.'" dan id "'.$data->id.'" untuk ditampilkan dihalaman edit pasien');
        // }

        return response()->json(['data' => $data]);
    }

    public function dokumenPersetujuanPenolakan(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = DokumenPersetujuanPenolakanTindakanDokter::store($request);

        return response()->json(['data' => $data]);

    }

    public function listDokumenPersetujuanPenolakan(Request $request)
    {
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;

        if ($request->search != '') {
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
                'anestesi_lokal',
            ];

            $data = $request->all();

            foreach ($booleanFields as $field) {
                if (isset($data[$field])) {
                    $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
                }
            }

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_sername = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            // Tambahkan user yang membuat
            $data['created_by'] = $pengguna_nama;

            // Simpan data
            $laporan = DokumenLaporanPembedahan::create($data);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Laporan Pembedahan berhasil disimpan',
                'data' => $laporan,
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Laporan Pembedahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFormLaseBarage(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenFormLaserBargage::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Laser Bargage berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenFormLaserBargage::create($data);
                $action = 'create';
                $message = 'Form Laser Bargage berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Form Laser Bargage',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeBalanceCairanHarian(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $uuid = $request->input('uuid');

            // Decode JSON balance_rows jika dalam bentuk string
            if (isset($data['balance_rows']) && is_string($data['balance_rows'])) {
                $data['balance_rows'] = json_decode($data['balance_rows'], true);
            }

            if ($uuid) {
                // UPDATE MODE
                $dokumen = DokumenBalanceCairanHarian::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                unset($data['uuid']);
                $dokumen->update($data);
                $action = 'update';
                $message = 'Balance Cairan Harian berhasil diupdate';

            } else {
                // CREATE MODE
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenBalanceCairanHarian::create($data);
                $action = 'create';
                $message = 'Balance Cairan Harian berhasil disimpan';
            }

            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            \DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Balance Cairan Harian',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeResumePerawatanRawatJalan(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $uuid = $request->input('uuid');

            // Decode JSON resume_rows jika dalam bentuk string
            if (isset($data['resume_rows']) && is_string($data['resume_rows'])) {
                $data['resume_rows'] = json_decode($data['resume_rows'], true);
            }

            if ($uuid) {
                // UPDATE MODE
                $dokumen = DokumenResumePerawatanRawatJalan::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                unset($data['uuid']);
                $dokumen->update($data);
                $action = 'update';
                $message = 'Resume Perawatan Rawat Jalan berhasil diupdate';

            } else {
                // CREATE MODE
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenResumePerawatanRawatJalan::create($data);
                $action = 'create';
                $message = 'Resume Perawatan Rawat Jalan berhasil disimpan';
            }

            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            \DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Resume Perawatan Rawat Jalan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function listobat(Request $request)
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

        if ($request->search != '') {
            $dataObat = Registrasi::where('delete_soft', '=', 1)->where('ada_obat', 'Ya')
                ->where('pasien_uuid', '=', $search)
                ->orderBy('tanggal', 'desc')
                ->skip($skip)->take($this->take)
                ->get();
            $totalObat = Registrasi::where('delete_soft', '=', 1)->where('ada_obat', 'Ya')
                ->where('pasien_uuid', '=', $search)
                ->orderBy('tanggal', 'desc')->count();

            $dataRacikan = Registrasi::where('delete_soft', 1)
                ->where('pasien_uuid', $search)
                ->whereHas('resepracikan') // hanya registrasi yang punya resepracikan
                ->orderBy('tanggal', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();

            $totalRacikan = Registrasi::where('delete_soft', 1)
                ->where('pasien_uuid', $search)
                ->whereHas('resepracikan') // hanya registrasi yang punya resepracikan
                ->orderBy('tanggal', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->count();
        }

        return response()->json(['dataobat' => $dataObat, 'totalobat' => $totalObat, 'dataracikan' => $dataRacikan, 'totalracikan' => $totalRacikan]);
    }

    public function detailobat(Request $request)
    {

        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        PenggunaHelp::log('Melihat data detail table pada halaman data obat');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $regitrasiId = $request->registrasiId;

        if ($request->search != '') {
            $detailObat = Resep::where('delete_soft', '=', 1)
                ->where('pasien_uuid', '=', $search)
                ->where('registrasi_uuid', '=', $regitrasiId)
                ->orderBy('tanggal', 'desc')
                // ->skip($skip)->take($this->take)
                ->get();
        }

        return response()->json(['data' => $detailObat]);

    }

    public function storeSuratPenolakanRujukan(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratPenolakanRujukan::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Penolakan Rujukan berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratPenolakanRujukan::create($data);
                $action = 'create';
                $message = 'Surat Penolakan Rujukan berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Penolakan Rujukan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeSuratKontrol(Request $request){
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Convert status_sembuh dari string ke boolean
            if (isset($data['status_sembuh'])) {
                $data['status_sembuh'] = filter_var($data['status_sembuh'], FILTER_VALIDATE_BOOLEAN);
            }

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratKontrol::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Kontrol berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratKontrol::create($data);
                $action = 'create';
                $message = 'Surat Kontrol berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Kontrol',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeSuratKonsul(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratKonsul::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Konsul berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratKonsul::create($data);
                $action = 'create';
                $message = 'Surat Konsul berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Konsul',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeSuratBalasanKonsul(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratBalasanKonsul::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Balasan Konsul berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratBalasanKonsul::create($data);
                $action = 'create';
                $message = 'Surat Balasan Konsul berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Balasan Konsul',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeSuratPernyataanBatalOperasi(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratPernyataanBatalOperasi::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Pernyataan Batal Operasi berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratPernyataanBatalOperasi::create($data);
                $action = 'create';
                $message = 'Surat Pernyataan Batal Operasi berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Pernyataan Batal Operasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeSuratPernyataanPasienUmum(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenSuratPernyataanPasienUmum::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Surat Pernyataan Pasien Umum berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenSuratPernyataanPasienUmum::create($data);
                $action = 'create';
                $message = 'Surat Pernyataan Pasien Umum berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Surat Pernyataan Pasien Umum',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDokumenDietitianPasienBaru(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            // Convert checkbox string values to boolean
            $checkboxFields = [
                'alergi_telur', 'alergi_susu', 'alergi_kacang', 'alergi_gluten',
                'alergi_udang', 'alergi_ikan', 'alergi_hazelnut'
            ];
            
            foreach ($checkboxFields as $field) {
                $data[$field] = filter_var($data[$field] ?? false, FILTER_VALIDATE_BOOLEAN);
            }

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenDietitianPasienBaru::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Dietitian Pasien Baru berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenDietitianPasienBaru::create($data);
                $action = 'create';
                $message = 'Dokumen Dietitian Pasien Baru berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Dokumen Dietitian Pasien Baru',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeDokumenAsuhanGizi(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenAsuhanGizi::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Asuhan Gizi berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenAsuhanGizi::create($data);
                $action = 'create';
                $message = 'Dokumen Asuhan Gizi berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Dokumen Asuhan Gizi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDokumenLaserLPI(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenTindakanLaserLPI::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Tindakan Laser LPI berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenTindakanLaserLPI::create($data);
                $action = 'create';
                $message = 'Dokumen Tindakan Laser LPI berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Dokumen Tindakan Laser LPI',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDokumenLaserPRP(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenTindakanLaserPRP::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Tindakan Laser PRP berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenTindakanLaserPRP::create($data);
                $action = 'create';
                $message = 'Dokumen Tindakan Laser PRP berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Dokumen Tindakan Laser PRP',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function listBillPembayaran(Request $request)
    {
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;

        if ($request->search != '') {
            $data = Registrasi::withSum('layanan', 'total')->withSum('layanan', 'diskon_rp')
            ->where('pasien_uuid', $search)
            ->where('status_kasir', 'Sudah Bayar')
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($this->take)
            ->get();
        
            $total = Registrasi::where('pasien_uuid', '=', $search)->where('status_kasir', 'Sudah Bayar')
                ->orderBy('created_at', 'desc')
                ->orderBy('created_at', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function storeLaporanOperasiTrabekulektomi(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenLaporanOperasiTrabekulektomi::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Laporan Operasi Trabekulektomi berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenLaporanOperasiTrabekulektomi::create($data);
                $action = 'create';
                $message = 'Laporan Operasi Trabekulektomi berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Laporan Operasi Trabekulektomi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeLaporanOperasiPterygium(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenLaporanOperasiPterygium::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Laporan Operasi Pterygium berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenLaporanOperasiPterygium::create($data);
                $action = 'create';
                $message = 'Laporan Operasi Pterygium berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Laporan Operasi Pterygium',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeLaporanEksisiPalpebra(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenLaporanEksisiPalpebra::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Laporan Eksisi Palpebra berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenLaporanEksisiPalpebra::create($data);
                $action = 'create';
                $message = 'Laporan Eksisi Palpebra berhasil disimpan';
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan Laporan Eksisi Palpebra',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
