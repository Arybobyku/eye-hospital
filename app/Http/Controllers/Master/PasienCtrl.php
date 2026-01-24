<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use Illuminate\Support\Facades\Storage;
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
use App\models\DokumenPasien;
use App\Models\DokumenCeklistKesiapanBedah;
use App\Models\FormEdukasiPasienDanKeluargaRawatJalan;
use App\Models\FormPersetujuanUmumPasienKeluarga;
use App\Models\FormProsesPerawatanPeriOperative;
use App\Models\FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap;
use App\Models\PenolakanTindakanAnestesi;
use App\Models\FormPengkajianKeperawatanMataRawatJalan;
use App\Models\FormLaporanInjeksi;
use App\Models\FormPermintaanPulang;
use App\Models\VoucherRawatInap;
use App\Models\FormReaksiTransfusiDarah;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\PemeriksaanRo;
use App\Models\Registrasi;
use App\Models\Resep;
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
    public function dokumenPersetujuanUmum(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $pasien = Pasien::where('uuid', $request->uuid_pasien)->first();
        $data = DokumenPersetujuanUmum::create([
            'uuid_pasien' => $request->uuid_pasien,
            'no_rm' => $request->kodeMR,
            'nik' => $pasien->no_ktp,
            'nama_pasien' => $request->nama,
            'nama_pemberi_informasi' => $request->nama_pemberi_informasi,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $pasien->jenis_kelamin,
            'resume_rows' => $request->resume_rows ?: null,
            'catatan' => '',
            'pasien_ttd' => $request->pasien_ttd,
            'nama_terang_pasien' => $request->nama_terang_pasien,
            'pemberi_inf_ttd' => $request->pemberi_inf_ttd,
            'nama_terang_pemberi_inf' => $request->nama_terang_pemberi_inf,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // $data = DokumenPersetujuanPenolakanTindakanDokter::store($request);

        return response()->json(['data' => $data]);

    }

    public function listDokumenPersetujuanUmum(Request $request)
    {
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;

        if ($request->search != '') {
            $data = DokumenPersetujuanUmum::where('uuid_pasien', '=', $search)
                ->orderBy('created_at', 'desc')
                ->skip($skip)->take($this->take)
                ->get();
            $total = DokumenPersetujuanUmum::where('uuid_pasien', '=', $search)
                ->orderBy('created_at', 'desc')
                ->orderBy('created_at', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);

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
        public function dokumenList(Request $request) {
        		if ($this->error != 'next') { 
        			return response()->json(['data' => $this->error]); 
        		}

        		PenggunaHelp::log('Melihat data list dokumen pasien');

        		$search = $request->search;
            	$limit = $request->limit ?? 100;

        		if ($request->search != "") {

        		$data = DokumenPasien::where('delete_soft', '=', 1)
                    ->where('pasien_uuid', '=', $search)
                    ->orderBy('tanggal_upload', 'desc')
                    ->orderBy('waktu_upload', 'desc')
                    ->limit($limit) // Pakai limit dari request
                    ->get();

        			$total = DokumenPasien::where('delete_soft', '=', 1)
        				->where('pasien_uuid', '=', $search)
        				->count();
        		} else {
        			$data = [];
        			$total = 0;
        		}

        		return response()->json(['data' => $data, 'total' => $total]);
        	}

        	public function dokumenStore(Request $request) {
        		if ($this->error != 'next') { 
        			return response()->json(['error' => $this->error], 403); 
        		}

        		$request->validate([
        			'pasien_uuid' => 'required',
        			'jenis_dokumen' => 'required|string',
        			'file' => 'required|file|mimes:pdf,bmp,jpg,jpeg,png|max:1024',
        			'keterangan' => 'nullable|string'
        		]);

        		try {
        			$pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $nama_pengguna = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));

        			$file = $request->file('file');
        			$filename = time() . '_' . $file->getClientOriginalName();
        			$path = $file->storeAs('dokumen_pasien', $filename, 'public');

        			$dokumen = new DokumenPasien();
        			$dokumen->uuid = Uuid::uuid4();
        			$dokumen->pasien_uuid = $request->pasien_uuid;
        			$dokumen->jenis_dokumen = $request->jenis_dokumen;
        			$dokumen->nama_file = $file->getClientOriginalName();
        			$dokumen->file_path = $path;
        			$dokumen->keterangan = $request->keterangan;
        			$dokumen->tanggal_upload = date('Y-m-d');
        			$dokumen->waktu_upload = date('H:i:s');
        			$dokumen->uploaded_by_uuid = $pengguna_uuid;
        			$dokumen->uploaded_by_nama = $nama_pengguna;
        			$dokumen->is_verified = false;
        			$dokumen->delete_soft = 1;
        			$dokumen->save();

        			PenggunaHelp::log('Menambah dokumen pasien: ' . $dokumen->nama_file);

        			return response()->json([
        				'success' => true, 
        				'message' => 'Dokumen berhasil diupload',
        				'data' => $dokumen
        			], 201);

        		} catch (\Exception $e) {
        			return response()->json([
        				'success' => false,
        				'message' => 'Gagal mengupload dokumen: ' . $e->getMessage()
        			], 500);
        		}
        	}

        	public function dokumenUpdate(Request $request) {
        		if ($this->error != 'next') { 
        			return response()->json(['error' => $this->error], 403); 
        		}

        		$request->validate([
        			'uuid' => 'required',
        			'jenis_dokumen' => 'required|string',
        			'file' => 'nullable|file|mimes:pdf,bmp,jpg,jpeg,png|max:1024',
        			'keterangan' => 'nullable|string'
        		]);

        		try {
        			$dokumen = DokumenPasien::where('uuid', $request->uuid)
        				->where('delete_soft', 1)
        				->first();

        			if (!$dokumen) {
        				return response()->json([
        					'success' => false,
        					'message' => 'Dokumen tidak ditemukan'
        				], 404);
        			}

        			if ($dokumen->is_verified) {
        				return response()->json([
        					'success' => false,
        					'message' => 'Dokumen yang sudah diverifikasi tidak dapat diubah'
        				], 403);
        			}

        			$dokumen->jenis_dokumen = $request->jenis_dokumen;
        			$dokumen->keterangan = $request->keterangan;

        			if ($request->hasFile('file')) {
        				Storage::disk('public')->delete($dokumen->file_path);

        				$file = $request->file('file');
        				$filename = time() . '_' . $file->getClientOriginalName();
        				$path = $file->storeAs('dokumen_pasien', $filename, 'public');

        				$dokumen->nama_file = $file->getClientOriginalName();
        				$dokumen->file_path = $path;
        			}

        			$dokumen->save();

        			PenggunaHelp::log('Mengubah dokumen pasien: ' . $dokumen->nama_file);

        			return response()->json([
        				'success' => true,
        				'message' => 'Dokumen berhasil diupdate',
        				'data' => $dokumen
        			]);

        		} catch (\Exception $e) {
        			return response()->json([
        				'success' => false,
        				'message' => 'Gagal mengupdate dokumen: ' . $e->getMessage()
        			], 500);
        		}
        	}
        	public function dokumenPrint($uuid) {
        	    if ($this->error != 'next') { 
        	        return redirect('/')->with('error', 'Unauthorized');
        	    }

        	    try {
        	        $dokumen = DokumenPasien::where('uuid', $uuid)
        	            ->where('delete_soft', 1)
        	            ->first();

        	        if (!$dokumen) {
        	            abort(404, 'Dokumen tidak ditemukan');
        	        }

        	        $filePath = storage_path('app/public/' . $dokumen->file_path);

        	        if (!file_exists($filePath)) {
        	            abort(404, 'File tidak ditemukan di server');
        	        }

        	        PenggunaHelp::log('Membuka dokumen pasien: ' . $dokumen->nama_file);

        	        // Return file untuk ditampilkan di browser (bukan download)
        	        return response()->file($filePath, [
        	            'Content-Type' => mime_content_type($filePath),
        	            'Content-Disposition' => 'inline; filename="' . $dokumen->nama_file . '"'
        	        ]);

        	    } catch (\Exception $e) {
        	        abort(500, 'Gagal membuka dokumen: ' . $e->getMessage());
        	    }
        	}

        	public function dokumenDelete(Request $request) {
        		if ($this->error != 'next') { 
        			return response()->json(['error' => $this->error], 403); 
        		}

        		try {
        			$dokumen = DokumenPasien::where('uuid', $request->uuid)
        				->where('delete_soft', 1)
        				->first();

        			if (!$dokumen) {
        				return response()->json([
        					'success' => false,
        					'message' => 'Dokumen tidak ditemukan'
        				], 404);
        			}

        			if ($dokumen->is_verified) {
        				return response()->json([
        					'success' => false,
        					'message' => 'Dokumen yang sudah diverifikasi tidak dapat dihapus'
        				], 403);
        			}

        			$dokumen->delete_soft = 0;
        			$dokumen->save();

        			Storage::disk('public')->delete($dokumen->file_path);

        			PenggunaHelp::log('Menghapus dokumen pasien: ' . $dokumen->nama_file);

        			return response()->json([
        				'success' => true,
        				'message' => 'Dokumen berhasil dihapus'
        			]);

        		} catch (\Exception $e) {
        			return response()->json([
        				'success' => false,
        				'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()
        			], 500);
        		}
        	}
        	public function dokumenVerify(Request $request) {
            if ($this->error != 'next') { 
                return response()->json(['error' => $this->error], 403); 
            }

            try {
                $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
                $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));

                // Ambil posisi dari database
                $user = \App\Models\Pengguna::where('uuid', $pengguna_uuid)->first();

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan'
                    ], 401);
                }

                // ✅ Cek apakah super admin
                if ($user->posisi != 9987) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hanya Super Admin yang dapat memverifikasi dokumen'
                    ], 403);
                }

                $dokumen = DokumenPasien::where('uuid', $request->uuid)
                    ->where('delete_soft', 1)
                    ->first();

                if (!$dokumen) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Dokumen tidak ditemukan'
                    ], 404);
                }

                $dokumen->is_verified = true;
                $dokumen->verified_by_uuid = $pengguna_uuid;
                $dokumen->verified_by_nama = $pengguna_nama;
                $dokumen->verified_at = now();
                $dokumen->save();

                PenggunaHelp::log('Memverifikasi dokumen pasien: ' . $dokumen->nama_file);

                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil diverifikasi',
                    'data' => $dokumen
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memverifikasi dokumen: ' . $e->getMessage()
                ], 500);
            }
        }

        	public function dokumenDownload(Request $request) {
        		if ($this->error != 'next') { 
        			return response()->json(['error' => $this->error], 403); 
        		}

        		try {
        			$dokumen = DokumenPasien::where('uuid', $request->uuid)
        				->where('delete_soft', 1)
        				->first();

        			if (!$dokumen) {
        				return response()->json([
        					'success' => false,
        					'message' => 'Dokumen tidak ditemukan'
        				], 404);
        			}

        			$filePath = storage_path('app/public/' . $dokumen->file_path);

        			if (!file_exists($filePath)) {
        				return response()->json([
        					'success' => false,
        					'message' => 'File tidak ditemukan di server'
        				], 404);
        			}

        			PenggunaHelp::log('Mendownload dokumen pasien: ' . $dokumen->nama_file);

        			return response()->download($filePath, $dokumen->nama_file);

        		} catch (\Exception $e) {
        			return response()->json([
        				'success' => false,
        				'message' => 'Gagal mendownload dokumen: ' . $e->getMessage()
        			], 500);
        		}
        	}
        	public function getUserInfo(Request $request) {
            try {
                $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
                $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));

                // Query database untuk ambil posisi
                $user = \App\Models\Pengguna::where('uuid', $pengguna_uuid)->first();

                return response()->json([
                    'success' => true,
                    'uuid' => $pengguna_uuid,
                    'nama' => $pengguna_nama,
                    'posisi' => $user ? $user->posisi : null,
                    'is_super_admin' => $user && $user->posisi == 9987
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        //batas

    public function storeDokumenCeklistKesiapanBedah(Request $request)
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
                $dokumen = DokumenCeklistKesiapanBedah::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Dokumen Ceklist kesiapan bedah berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenCeklistKesiapanBedah::create($data);
                $action = 'create';
                $message = 'Dokumen Ceklist kesiapan bedah berhasil disimpan';
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
                'message' => 'Gagal menyimpan Dokumen Ceklist kesiapan bedah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeFormPersetujuanUmumPasienKeluarga(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            unset($data['uuid']);

            if ($uuid) {
                $dokumen = FormPersetujuanUmumPasienKeluarga::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Persetujuan Umum Pasien Keluarga berhasil diupdate';

            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormPersetujuanUmumPasienKeluarga::create($data);
                $action = 'create';
                $message = 'Form Persetujuan Umum Pasien Keluarga berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Persetujuan Umum Pasien Keluarga',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFormEdukasiPasienDanKeluargaRawatJalan(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

            $uuid = $request->input('uuid');

            unset($data['uuid']);

            if ($uuid) {
                $dokumen = FormEdukasiPasienDanKeluargaRawatJalan::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Edukasi Pasien Dan Keluarga Rawat Jalan berhasil diupdate';

            } else {
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormEdukasiPasienDanKeluargaRawatJalan::create($data);
                $action = 'create';
                $message = 'Form Edukasi Pasien Dan Keluarga Rawat Jalan berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Edukasi Pasien Dan Keluarga Rawat Jalan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFormProsesPerawatanPeriOperative(Request $request)
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
                $dokumen = FormProsesPerawatanPeriOperative::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Proses Perawatan Peri Operative berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormProsesPerawatanPeriOperative::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Proses Perawatan Peri Operative berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Proses Perawatan Peri Operative',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap(Request $request)
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
                $dokumen = FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storePenolakanTindakanAnestesi(Request $request)
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
                $dokumen = PenolakanTindakanAnestesi::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Penolakan Tindakan Anestesi berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = PenolakanTindakanAnestesi::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Penolakan Tindakan Anestesi berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Penolakan Tindakan Anestesi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeFormPengkajianKeperawatanMataRawatJalan(Request $request)
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
                $dokumen = FormPengkajianKeperawatanMataRawatJalan::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Pengkajian Keperawatan Mata Rawat Jalan berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormPengkajianKeperawatanMataRawatJalan::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Pengkajian Keperawatan Mata Rawat Jalan berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Pengkajian Keperawatan Mata Rawat Jalan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeFormLaporanInjeksi(Request $request)
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
                $dokumen = FormLaporanInjeksi::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Laporan Injeksi berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormLaporanInjeksi::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Laporan Injeksi berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Laporan Injeksi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFormPermintaanPulang(Request $request)
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
                $dokumen = FormPermintaanPulang::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Permintaan Pulang berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormPermintaanPulang::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Permintaan Pulang berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Permintaan Pulang',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeVoucherRawatInap(Request $request)
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
                $dokumen = VoucherRawatInap::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Voucher Rawat Inap berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = VoucherRawatInap::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Voucher Rawat Inap berhasil disimpan';
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
                'message' => 'Gagal menyimpan Voucher Rawat Inap',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function storeFormReaksiTransfusiDarah(Request $request)
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
                $dokumen = FormReaksiTransfusiDarah::where('uuid', $uuid)->first();
            
                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }
            
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Reaksi Transfusi Darah berhasil diupdate';
            
            } else {
                // CREATE: buat baru
                $data['created_by'] = $pengguna_nama;
                $dokumen = FormReaksiTransfusiDarah::create($data); // ← PERBAIKI INI (tambahkan 'a')
                $action = 'create';
                $message = 'Form Reaksi Transfusi Darah berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Reaksi Transfusi Darah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
    

}
