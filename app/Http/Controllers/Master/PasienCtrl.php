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
use App\Models\DokumenLaporanEksisiChalazion;
use App\Models\DokumenAsesmenKeperawatanRawatInap;
use App\Models\DokumenPulangAtasPermintaanSendiri;
use App\Models\DokumenTindakanLaserCapsulotomy;
use App\Models\DokumenKronologisPasien;
use App\Models\DokumenTindakanEpilasi;
use App\Models\DokumenCatatanOperasi;
use App\Models\DokumenResumeMedisRawatJalan;
use App\Models\DokumenResumeMedisRawatInap;
use App\Models\DokumenCPPTRawatInap;
use App\Models\DokumenMonitoringEfekSampingObat;
use App\Models\DokumenCatatanKeperawatan;
use App\Models\DokumenStatusAnestesi;
use App\Models\DokumenLaporanOperasiVitreoRetina;

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
    public function storeAsesmenKeperawatanRawatInap(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            
            // Ambil data pengguna dari Cookie (encrypted)
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
            
            $uuid = $request->input('uuid');
            
            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);
            unset($data['id']); // Hindari mass assignment 'id'
            
            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenAsesmenKeperawatanRawatInap::where('uuid', $uuid)->first();
                
                if (!$dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
                
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Asesmen Awal Keperawatan Rawat Inap berhasil diupdate';
                
            } else {
                // CREATE: buat baru
                $data['tanggal'] = date('Y-m-d');
                $data['created_by'] = $pengguna_nama;
                $data['id'] = '';
                $dokumen = DokumenAsesmenKeperawatanRawatInap::create($data);
                $action = 'create';
                $message = 'Asesmen Awal Keperawatan Rawat Inap berhasil disimpan';
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
                'message' => 'Gagal menyimpan Asesmen Awal Keperawatan Rawat Inap',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function storeLaporanEksisiChalazion(Request $request)
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
                $dokumen = DokumenLaporanEksisiChalazion::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Laporan Eksisi Chalazion berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenLaporanEksisiChalazion::create($data);
                $action = 'create';
                $message = 'Laporan Eksisi Chalazion berhasil disimpan';
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
                'message' => 'Gagal menyimpan Laporan Eksisi Chalazion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDokumenPulangAPS(Request $request)
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
                $dokumen = DokumenPulangAtasPermintaanSendiri::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Pulang APS berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenPulangAtasPermintaanSendiri::create($data);
                $action = 'create';
                $message = 'Dokumen Pulang APS berhasil disimpan';
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
                'message' => 'Gagal menyimpan Dokumen Pulang APS',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeTindakanLaserCapsulotomy(Request $request)
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

            // Convert checkbox values to boolean
            $data['mata_od'] = filter_var($data['mata_od'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['mata_os'] = filter_var($data['mata_os'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenTindakanLaserCapsulotomy::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Tindakan Laser Capsulotomy berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenTindakanLaserCapsulotomy::create($data);
                $action = 'create';
                $message = 'Tindakan Laser Capsulotomy berhasil disimpan';
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
                'message' => 'Gagal menyimpan Tindakan Laser Capsulotomy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeTindakanEpilasi(Request $request)
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

            // Convert checkbox values to boolean
            $data['mata_od'] = filter_var($data['mata_od'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['mata_os'] = filter_var($data['mata_os'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenTindakanEpilasi::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Tindakan Epilasi berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenTindakanEpilasi::create($data);
                $action = 'create';
                $message = 'Tindakan Epilasi berhasil disimpan';
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
                'message' => 'Gagal menyimpan Tindakan Epilasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeKronologisPasien(Request $request)
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

            // Convert checkbox values to boolean
            $data['lokasi_kecelakaan_lalu_lintas'] = filter_var($data['lokasi_kecelakaan_lalu_lintas'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['lokasi_rumah'] = filter_var($data['lokasi_rumah'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['lokasi_lainnya_check'] = filter_var($data['lokasi_lainnya_check'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenKronologisPasien::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Kronologis Pasien berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenKronologisPasien::create($data);
                $action = 'create';
                $message = 'Form Kronologis Pasien berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Kronologis Pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeCatatanOperasi(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');
            unset($data['uuid']);

            // Convert all checkbox values to boolean
            $booleanFields = [
                // Anesthesi
                'anesthesi_topikal', 'anesthesi_intracamelar', 'anesthesi_retrobulbar',
                'anesthesi_nu', 'anesthesi_subconjunctival', 'anesthesi_xylocain', 'anesthesi_lidocain',
                // Insisi
                'insisi_kornea', 'insisi_limbus', 'insisi_sclera',
                // Wound
                'wound_main_port', 'wound_two_side_port', 'wound_one_side_port',
                'wound_keratome', 'wound_crescen_knife',
                // Capsulotomi
                'capsulotomi_ccc', 'capsulotomi_xmas_tree', 'capsulotomi_linear',
                'capsulotomi_can_opener', 'capsulotomi_tryphan_blue',
                // Teknik
                'teknik_ctr', 'teknik_kapsulotomi_posterior', 'teknik_vitrektomi_anterior',
                // Cairan
                'cairan_rl', 'cairan_bss',
                // Lensa
                'lensa_dalam_kantung', 'lensa_diluar_kantung', 'lensa_bilik_mata_depan',
                'lensa_afakia', 'lensa_sulcus_siliaris', 'lensa_fiksasi_scleral',
                // Visko
                'visko_hpmc', 'visko_viscoat', 'visko_hyaluronic_acid',
                // Benang
                'benang_tanpa_jahitan', 'benang_ethylon', 'benang_vicryl',
                // Komplikasi
                'komplikasi_tidak_ada', 'komplikasi_pcr', 'komplikasi_prolaps_vitreous',
                'komplikasi_drop_nucleus', 'komplikasi_perdarahan', 'komplikasi_corneal_burn',
                'komplikasi_convert_ecce', 'komplikasi_convert_icce',
                // Perawatan
                'perawatan_pulang', 'perawatan_opname',
                // Instruksi
                'instruksi_perban_2jam', 'instruksi_obat_setelah_buka',
                'instruksi_perban_tutup_kembali', 'instruksi_pantangan',
            ];

            foreach ($booleanFields as $field) {
                $data[$field] = filter_var($data[$field] ?? false, FILTER_VALIDATE_BOOLEAN);
            }

            if ($uuid) {
                // UPDATE
                $dokumen = DokumenCatatanOperasi::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Catatan Operasi berhasil diupdate';

            } else {
                // CREATE
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenCatatanOperasi::create($data);
                $action = 'create';
                $message = 'Catatan Operasi berhasil disimpan';
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
                'message' => 'Gagal menyimpan Catatan Operasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeResumeMedisRawatJalan(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            
            // Ambil data pengguna dari Cookie (encrypted)
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
            
            $uuid = $request->input('uuid');
            
            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);
            unset($data['id']); // Hindari mass assignment 'id'
            
            if ($uuid) {
                // UPDATE: cari berdasarkan UUID
                $dokumen = DokumenResumeMedisRawatJalan::where('uuid', $uuid)->first();
                
                if (!$dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
                
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Resume Medis Rawat Jalan berhasil diupdate';
                
            } else {
                // CREATE: buat baru
                $data['tanggal'] = date('Y-m-d');
                $data['created_by'] = $pengguna_nama;
                $data['id'] = '';
                $dokumen = DokumenResumeMedisRawatJalan::create($data);
                $action = 'create';
                $message = 'Resume Medis Rawat Jalan berhasil disimpan';
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
                'message' => 'Gagal menyimpan Asesmen Awal Keperawatan Rawat Inap',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeResumeMedisRawatInap(Request $request)
    {
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']); // Hindari mass assignment 'id'
        
        // ===== HANDLING KHUSUS UNTUK TERAPI PULANG (JSON) =====
        if (isset($data['terapi_pulang'])) {
            // Jika dari frontend datang sebagai string JSON, decode dulu
            if (is_string($data['terapi_pulang'])) {
                $data['terapi_pulang'] = json_decode($data['terapi_pulang'], true);
            }
            
            // Validasi bahwa terapi_pulang adalah array
            if (!is_array($data['terapi_pulang'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format terapi pulang tidak valid',
                ], 400);
            }
        }
        
        // ===== CONVERT CHECKBOX BOOLEAN =====
        // Frontend mengirim true/false sebagai string atau boolean
        $booleanFields = [
            'kondisi_sembuh',
            'kondisi_pindah_rs',
            'kondisi_pulang_sendiri',
            'kondisi_meninggal',
            'kondisi_lainnya'
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenResumeMedisRawatInap::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Resume Medis Rawat Inap berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $data['id'] = '';
            $data['tanggal'] = date('Y-m-d');
            $dokumen = DokumenResumeMedisRawatInap::create($data);
            $action = 'create';
            $message = 'Resume Medis Rawat Inap berhasil disimpan';

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
            'message' => 'Gagal menyimpan Resume Medis Rawat Inap',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeCPPTRawatInap(Request $request)
{
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']); // Hindari mass assignment 'id'
        
        // ===== HANDLING KHUSUS UNTUK CPPT_ROWS (JSON) =====
        if (isset($data['cppt_rows'])) {
            // Jika dari frontend datang sebagai string JSON, decode dulu
            if (is_string($data['cppt_rows'])) {
                $data['cppt_rows'] = json_decode($data['cppt_rows'], true);
            }
            
            // Validasi bahwa cppt_rows adalah array
            if (!is_array($data['cppt_rows'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format CPPT rows tidak valid',
                ], 400);
            }
            
            // Validasi minimal ada 1 entri
            if (empty($data['cppt_rows'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Minimal harus ada 1 catatan perkembangan pasien',
                ], 400);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenCPPTRawatInap::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'CPPT Rawat Inap berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $data['tanggal'] = date('Y-m-d');
            $data['id'] = '';
            $dokumen = DokumenCPPTRawatInap::create($data);
            $action = 'create';
            $message = 'CPPT Rawat Inap berhasil disimpan';
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
            'message' => 'Gagal menyimpan CPPT Rawat Inap',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function storeMonitoringEfekSampingObat(Request $request)
{
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']);
        
        // ===== HANDLING KHUSUS UNTUK SEJARAH_MEDIS_ROWS (JSON) =====
        if (isset($data['sejarah_medis_rows'])) {
            if (is_string($data['sejarah_medis_rows'])) {
                $data['sejarah_medis_rows'] = json_decode($data['sejarah_medis_rows'], true);
            }
            
            if (!is_array($data['sejarah_medis_rows'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format sejarah medis tidak valid',
                ], 400);
            }
        }
        
        // ===== CONVERT CHECKBOX BOOLEAN =====
        $booleanFields = [
            'penilaian_ketidakpatuhan',
            'penilaian_pengetahuan_kurang',
            'penilaian_cara_salah',
            'penilaian_komunikasi_kurang',
            'penilaian_efek_samping',
            'penilaian_masalah_lain'
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenMonitoringEfekSampingObat::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Monitoring Efek Samping Obat berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $data['tanggal'] = date('Y-m-d');
            $data['id'] = '';
            $dokumen = DokumenMonitoringEfekSampingObat::create($data);
            $action = 'create';
            $message = 'Monitoring Efek Samping Obat berhasil disimpan';
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
            'message' => 'Gagal menyimpan Monitoring Efek Samping Obat',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function storeCatatanKeperawatan(Request $request)
{
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']);
        
        // ===== HANDLING KHUSUS UNTUK CATATAN_ROWS (JSON) =====
        if (isset($data['catatan_rows'])) {
            if (is_string($data['catatan_rows'])) {
                $data['catatan_rows'] = json_decode($data['catatan_rows'], true);
            }
            
            if (!is_array($data['catatan_rows'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format catatan rows tidak valid',
                ], 400);
            }
            
            // Validasi minimal ada 1 entri
            if (empty($data['catatan_rows'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Minimal harus ada 1 catatan keperawatan',
                ], 400);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenCatatanKeperawatan::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Catatan Keperawatan berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = date('Y-m-d');
            $data['created_by'] = $pengguna_nama;
            $data['id'] = '';
            $dokumen = DokumenCatatanKeperawatan::create($data);
            $action = 'create';
            $message = 'Catatan Keperawatan berhasil disimpan';
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
            'message' => 'Gagal menyimpan Catatan Keperawatan',
            'error' => $e->getMessage(),
        ], 500);
    }

}
public function storeStatusAnestesi(Request $request)
{
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']);
        
        // ===== HANDLING KHUSUS UNTUK OBAT_INFUS (JSON) =====
        if (isset($data['obat_infus'])) {
            if (is_string($data['obat_infus'])) {
                $data['obat_infus'] = json_decode($data['obat_infus'], true);
            }
            
            if (!is_array($data['obat_infus'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format obat infus tidak valid',
                ], 400);
            }
        }
        
        // ===== HANDLING KHUSUS UNTUK MONITORING_FISIOLOGIS (JSON) =====
        if (isset($data['monitoring_fisiologis'])) {
            if (is_string($data['monitoring_fisiologis'])) {
                $data['monitoring_fisiologis'] = json_decode($data['monitoring_fisiologis'], true);
            }
            
            if (!is_array($data['monitoring_fisiologis'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format monitoring fisiologis tidak valid',
                ], 400);
            }
        }
        
        // ===== CONVERT CHECKBOX BOOLEAN =====
        $booleanFields = [
            'teknik_sedasi',
            'teknik_anestesi_umum',
            'teknik_lain',
            'teknik_spinal',
            'teknik_epidural',
            'teknik_kaudal',
            'alat_hipotensi',
            'alat_tci',
            'alat_cpb',
            'alat_ventilasi_satu_paru',
            'alat_bronkoskopi',
            'alat_glidescope',
            'alat_usg',
            'alat_stimulator_saraf',
            'alat_lainnya_check',
            'monitoring_ekg',
            'monitoring_arteri_line',
            'monitoring_etco2',
            'monitoring_stetoskop',
            'monitoring_nibp',
            'monitoring_ngt',
            'monitoring_bis',
            'monitoring_cvp',
            'monitoring_cath_a_pulmo',
            'monitoring_spo2',
            'monitoring_kateter_urine',
            'monitoring_temp',
            'monitoring_lainnya_check',
            'cek_informed_consent',
            'cek_obat_anestesi',
            'cek_tatalaksana_jalan_nafas',
            'cek_mesin_anestesi',
            'cek_monitoring',
            'cek_obat_emergensi',
            'cek_suction_apparatus',
            'posisi_terlentang',
            'posisi_lithotomi',
            'posisi_prone',
            'posisi_perlindungan_mata',
            'posisi_lainnya_check',
            'trakheostomi',
            'bronkoskopi_fiberoptik',
            'glidescope_jalan_nafas',
            'jalan_nafas_lainnya_check',
            'intubasi_sesudah_tidur',
            'intubasi_blind',
            'intubasi_trakheostomi',
            'dengan_stilet',
            'ventilasi_spontan',
            'ventilasi_kendali'
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenStatusAnestesi::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Status Anestesi berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            if (empty($data['tanggal'])) {
                $data['tanggal'] = date('Y-m-d');
            }
            $data['id'] = '';
            $dokumen = DokumenStatusAnestesi::create($data);
            $action = 'create';
            $message = 'Status Anestesi berhasil disimpan';
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
            'message' => 'Gagal menyimpan Status Anestesi',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeLaporanOperasiVitreoRetina(Request $request)
{
    try {
        DB::beginTransaction();
        $data = $request->all();
        
        // Ambil data pengguna dari Cookie (encrypted)
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']);
        
        // ===== CONVERT CHECKBOX BOOLEAN =====
        $booleanFields = [
            'area_operasi_od',
            'area_operasi_os',
            'anestesi_lokal',
            'anestesi_umum',
            'anestesi_sedasi',
            'anestesi_blok',
            'peritomi_360',
            'peritomi_sebagian',
            'kendala_4_rektus',
            'kendala_rektus_superior',
            'kendala_tak_dilakukan',
            'bakel_sirkuler_5mm',
            'bakel_sirkuler_4mm',
            'bakel_sirkuler_2_5mm',
            'bakel_sirkuler_2mm',
            'bakel_sponge',
            'bakel_tyre',
            'bakel_tak_dilakukan',
            'ikatan_sleeve_ni',
            'ikatan_sleeve_ns',
            'ikatan_sleeve_ts',
            'ikatan_sleeve_ti',
            'ikatan_benang_ni',
            'ikatan_benang_ns',
            'ikatan_benang_ts',
            'ikatan_benang_ti',
            'jahitan_bakel_5_0',
            'jahitan_bakel_6_0',
            'jahitan_bakel_4_0',
            'jahitan_bakel_5_0_material',
            'jahitan_bakel_nylon',
            'jahitan_bakel_prolene',
            'jahitan_bakel_vycril',
            'skleretomi_3_lubang',
            'skleretomi_4_lubang',
            'kanula_3mm',
            'kanula_4mm',
            'kanula_tak_tembus',
            'kanula_ujung_tak_terlihat',
            'teknik_pneumatic_retinopexy',
            'teknik_fge',
            'teknik_sice',
            'teknik_core_vitrectomy',
            'teknik_endblock',
            'teknik_ekstirpasi_iol',
            'teknik_reposisi_iol',
            'teknik_iridektomi_perifer',
            'teknik_drainase_cairan',
            'teknik_pneumatic_dysplacement',
            'teknik_kriopeksi',
            'teknik_injeksi_intravitreal',
            'teknik_pewarna_membran',
            'teknik_bersihkan_vitreous',
            'teknik_ekstirpasi_benda_asing',
            'teknik_ekstirpasi_lensa',
            'teknik_evakuasi_silicone',
            'teknik_tpa',
            'teknik_ilm_peeling',
            'teknik_membrane_peeling',
            'teknik_lensectomy',
            'teknik_ac_fiksasi',
            'teknik_tidak_dipasang_iol',
            'teknik_fako',
            'drainase_lubang_retina_baru',
            'drainase_robekan_ada',
            'drainase_external',
            'laser_dilakukan',
            'laser_el',
            'laser_lio',
            'laser_tidak_dilakukan',
            'tamponade_cairan',
            'tamponade_c3f8',
            'tamponade_f6h8',
            'tamponade_silicon_oil',
            'tamponade_corneal_debridemant',
            'tamponade_retina_melekat_sempurna',
            'tamponade_sisa_cairan',
            'tamponade_ya',
            'tamponade_udara_steril',
            'tamponade_sf6',
            'tamponade_perfluorocarbon',
            'tamponade_lensa_kontak',
            'tamponade_retina_melekat_tidak_sempurna',
            'tamponade_retina_tak_melekat',
            'tamponade_tidak',
            'komplikasi_ya',
            'komplikasi_tidak',
            'perdarahan_ya',
            'perdarahan_tidak',
            'transfusi_ya',
            'transfusi_tidak',
            'tidur_telungkup_3hr',
            'tidur_telungkup_10hr',
            'tidur_telungkup_1bl',
            'tidur_biasa',
            'lepas_lensa_kontak'
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenLaporanOperasiVitreoRetina::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Laporan Operasi Vitreo Retina berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            if (empty($data['tanggal_operasi'])) {
                $data['tanggal_operasi'] = date('Y-m-d');
            }
            $data['id'] = '';
            $dokumen = DokumenLaporanOperasiVitreoRetina::create($data);
            $action = 'create';
            $message = 'Laporan Operasi Vitreo Retina berhasil disimpan';
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
            'message' => 'Gagal menyimpan Laporan Operasi Vitreo Retina',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
