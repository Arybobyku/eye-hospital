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
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenSuratPernyataanBatalOperasi;
use App\Models\HasilRadiologi;
use App\Models\HasilLaboratorium;
use App\Models\DokumenPersetujuanAnestesi;
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
use App\Models\DokumenFormTransferPasien;
use App\Models\DokumenPelaksanaanPencegahanPasienJatuh;
use App\Models\DokumenChecklistKeselamatanPasienOperasi;
use App\Models\DokumenEvaluasiPraAnesthesi;
use App\Models\DokumenSuratPengantarRawatInap;
use App\Models\DokumenPenilaianPraAnestesiSedasi;
use App\Models\PengkajianDataUmumPasien;
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


    
    // public function storeLaporanPembedahan(Request $request) TBD Konfirm ulang ke boby
    // {
    //     try {
    //         DB::beginTransaction();

    //         // Konversi checkbox boolean dari string
    //         $booleanFields = [
    //             'anestesi_umum',
    //             'anestesi_spiral',
    //             'anestesi_epidural',
    //             'anestesi_bsp',
    //             'anestesi_csp',
    //             'anestesi_lokal',
    //         ];

    //         $data = $request->all();

    //         foreach ($booleanFields as $field) {
    //             if (isset($data[$field])) {
    //                 $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
    //             }
    //         }

    //         $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
    //         $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
    //         $pengguna_sername = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));

    //         // Tambahkan user yang membuat
    //         $data['created_by'] = $pengguna_nama;

    //         // Simpan data
    //         $laporan = DokumenLaporanPembedahan::create($data);

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Laporan Pembedahan berhasil disimpan',
    //             'data' => $laporan,
    //         ], 201);

    //     } catch (Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Gagal menyimpan Laporan Pembedahan',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

/**
 * Get Single Pengkajian Data Umum (untuk edit)
 */
public function getPengkajianDataUmum($id)
{
    try {
        $data = PengkajianDataUmumPasien::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat data: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Update Pengkajian Data Umum Pasien
 */
public function updatePengkajianDataUmum(Request $request, $id)
{
    try {
        DB::beginTransaction();

        $pengkajian = PengkajianDataUmumPasien::where('id', $id)->first();

        if (!$pengkajian) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update data
        $pengkajian->id = $request->id;
        $pengkajian->uuid_pasien = $request->uuid_pasien;
        $pengkajian->tanggal = $request->tanggal;
        $pengkajian->waktu = $request->waktu;
        $pengkajian->nik = $request->nik;
        $pengkajian->kodemr = $request->kodemr;
        $pengkajian->nama = $request->nama;
        $pengkajian->nama_pasangan = $request->nama_pasangan;
        $pengkajian->nik_pasangan = $request->nik_pasangan;
        $pengkajian->pekerjaan = $request->pekerjaan;
        $pengkajian->alamat = $request->alamat;
        $pengkajian->agama = $request->agama;
        $pengkajian->jenis_kelamin = $request->jenis_kelamin;
        $pengkajian->tempat_tanggal_lahir = $request->tempat_tanggal_lahir;
        $pengkajian->status_pembiayaan = $request->status_pembiayaan;
        $pengkajian->status_perkawinan = $request->status_perkawinan;
        $pengkajian->pendidikan = $request->pendidikan;

        $pengkajian->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $pengkajian
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal update: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Delete Pengkajian Data Umum Pasien
 */
public function deletePengkajianDataUmum($id)
{
    try {
        DB::beginTransaction();

        $pengkajian = PengkajianDataUmumPasien::where('id', $id)->first();

        if (!$pengkajian) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $pengkajian->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus: ' . $e->getMessage()
        ], 500);
    }
}
        /**
     * Store Pengkajian Data Umum Pasien
     */
    public function pengkajianDataUmum(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = PengkajianDataUmumPasien::store($request);

        return response()->json(['data' => $data]);
    }

    /**
     * List Pengkajian Data Umum Pasien
     */
    public function listPengkajianDataUmum(Request $request)
    {
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;

        if ($request->search != '') {
            $data = PengkajianDataUmumPasien::join('pasien', 'pengkajian_data_umum_pasien.uuid_pasien', '=', 'pasien.uuid')
                ->where('uuid_pasien', '=', $search)
                ->orderBy('tanggal', 'desc')
                ->skip($skip)->take($this->take)
                ->get();
                
            $total = PengkajianDataUmumPasien::join('pasien', 'pengkajian_data_umum_pasien.uuid_pasien', '=', 'pasien.uuid')
                ->where('uuid_pasien', '=', $search)
                ->count();
        } else {
            $data = PengkajianDataUmumPasien::join('pasien', 'pengkajian_data_umum_pasien.uuid_pasien', '=', 'pasien.uuid')
                ->where('uuid_pasien', '=', $search)
                ->orderBy('tanggal', 'desc')
                ->skip($skip)->take($this->take)
                ->get();
                
            $total = PengkajianDataUmumPasien::join('pasien', 'pengkajian_data_umum_pasien.uuid_pasien', '=', 'pasien.uuid')
                ->where('uuid_pasien', '=', $search)
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function print($uuid)
{
  $data = HasilLab::where('uuid', $uuid)->firstOrFail();
  $pdf = PDF::loadView('print.lab', compact('data'));
  return $pdf->stream('hasil-lab.pdf');
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
 public function storeLaporanPembedahan(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        // Convert checkbox boolean values untuk jenis anestesi
        $booleanFields = [
            'anestesi_umum',
            'anestesi_bsp',
            'anestesi_spinal',
            'anestesi_csp',
            'anestesi_epidural',
            'anestesi_lokal',
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            } else {
                $data[$field] = false;
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenLaporanPembedahan::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Form Laporan Pembedahan berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenLaporanPembedahan::create($data);
            $action = 'create';
            $message = 'Form Laporan Pembedahan berhasil disimpan';
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
            'message' => 'Gagal menyimpan Form Laporan Pembedahan',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeDokumenFormTransferPasien(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        // Convert checkbox boolean values
        $booleanFields = [
            'mrsa', 'pasien_keluarga_setuju',
            'metode_kursi_roda', 'metode_tempat_tidur', 'metode_brankar',
            'peralatan_portable', 'peralatan_alat_penghisap', 'peralatan_bagging',
            'peralatan_ngt', 'peralatan_ventilator', 'peralatan_kateter_urin',
            'peralatan_pompa_infus',
            'disabilitas_amputasi', 'disabilitas_kontraktur', 'disabilitas_paralisis',
            'disabilitas_ulkus_dikubitus', 'disabilitas_gangguan_mental',
            'disabilitas_bicara', 'disabilitas_pendengaran', 'disabilitas_penglihatan',
            'disabilitas_sensasi',
            'inkontinensia_urin', 'inkontinensia_saliva', 'inkontinensia_alvi',
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            } else {
                $data[$field] = false;
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenFormTransferPasien::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Form Transfer Pasien berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenFormTransferPasien::create($data);
            $action = 'create';
            $message = 'Form Transfer Pasien berhasil disimpan';
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
            'message' => 'Gagal menyimpan Form Transfer Pasien',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function storePenilaianPraAnestesiSedasi(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        unset($data['uuid']);
        
        // Convert boolean fields
        $booleanFields = [
            'alat_bantu_dengar', 'kacamata', 'gigi_palsu',
            'regional_spinal', 'regional_epidural', 'regional_kaudal', 'regional_blok_perifer',
            'monitoring_ekg', 'monitoring_spo2', 'monitoring_nibp', 'monitoring_temp',
            'perawatan_rawat_inap', 'perawatan_rawat_jalan', 'perawatan_icu', 'perawatan_hdu',
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            } else {
                $data[$field] = false;
            }
        }
        
        if ($uuid) {
            $dokumen = DokumenPenilaianPraAnestesiSedasi::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Form Penilaian Pra-Anestesi dan Sedasi berhasil diupdate';
            
        } else {
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenPenilaianPraAnestesiSedasi::create($data);
            $action = 'create';
            $message = 'Form Penilaian Pra-Anestesi dan Sedasi berhasil disimpan';
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
            'message' => 'Gagal menyimpan Form Penilaian Pra-Anestesi dan Sedasi',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function storeDokumenEvaluasiPraAnesthesi(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        // Convert checkbox boolean values
        $booleanFields = [
            'anestesi_umum_intravena',
            'anestesi_umum_sungkup',
            'anestesi_umum_lma',
            'anestesi_umum_pipa',
            'regional_spinal',
            'regional_epidural',
            'regional_kombinasi',
            'regional_peripheral',
            'anestesi_umum_regional',
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            } else {
                $data[$field] = false;
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenEvaluasiPraAnesthesi::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Form Evaluasi Pra Anesthesi berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $data['tanggal'] = date('Y-m-d');
            $dokumen = DokumenEvaluasiPraAnesthesi::create($data);
            $action = 'create';
            $message = 'Form Evaluasi Pra Anesthesi berhasil disimpan';
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
            'message' => 'Gagal menyimpan Form Evaluasi Pra Anesthesi',
            'error' => $e->getMessage(),
        ], 500);
    }
}



    public function storeDokumenPelaksanaanPencegahanPasienJatuh(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        // Convert checkbox boolean values
        $booleanFields = [
            // Risiko Rendah
            'rendah_benda_pribadi',
            'rendah_roda_terkunci',
            'rendah_posisi_rendah',
            'rendah_pagar_pengaman',
            'rendah_monitor_berkala',
            'rendah_edukasi',
            'rendah_pintu_lampu',
            'rendah_alat_bantu',
            'rendah_alas_kaki',
            
            // Risiko Tinggi
            'tinggi_semua_standar',
            'tinggi_gelang_kuning',
            'tinggi_tanda_pintu',
            'tinggi_dekat_nurse',
            'tinggi_kunjungi_1jam',
            'tinggi_edukasi_obat',
            'tinggi_dampingi_kamar_mandi',
            'tinggi_tempat_duduk',
            'tinggi_bel_toilet',
            'tinggi_komunikasi_shift',
        ];
        
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            } else {
                $data[$field] = false;
            }
        }
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenPelaksanaanPencegahanPasienJatuh::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Form Pelaksanaan Pencegahan Pasien Jatuh berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenPelaksanaanPencegahanPasienJatuh::create($data);
            $action = 'create';
            $message = 'Form Pelaksanaan Pencegahan Pasien Jatuh berhasil disimpan';
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
            'message' => 'Gagal menyimpan Form Pelaksanaan Pencegahan Pasien Jatuh',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeSuratPengantarRawatInap(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenSuratPengantarRawatInap::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Surat Pengantar Rawat Inap berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenSuratPengantarRawatInap::create($data);
            $action = 'create';
            $message = 'Surat Pengantar Rawat Inap berhasil disimpan';
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
            'message' => 'Gagal menyimpan Surat Pengantar Rawat Inap',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function storeChecklistKeselamatanPasienOperasi(Request $request)
{
    try {
        DB::beginTransaction();
        
        $data = $request->all();
        
        // Ambil data user dari cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
        
        $uuid = $request->input('uuid');
        
        // Hapus uuid dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        
        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $dokumen = DokumenChecklistKeselamatanPasienOperasi::where('uuid', $uuid)->first();
            
            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
            
            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Checklist Keselamatan Pasien Operasi berhasil diupdate';
            
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $dokumen = DokumenChecklistKeselamatanPasienOperasi::create($data);
            $action = 'create';
            $message = 'Checklist Keselamatan Pasien Operasi berhasil disimpan';
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
            'message' => 'Gagal menyimpan Checklist Keselamatan Pasien Operasi',
            'error' => $e->getMessage(),
        ], 500);
    }
}

   // Get list hasil lab
    public function hasilPemeriksaan(Request $request)
    {
        try {
            $limit = $request->limit ?? 100;
            $page = $request->page ?? 1;
            $search = $request->search ?? '';

            $query = HasilLaboratorium::where('delete_soft', 0);

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('no_periksa', 'ilike', "%{$search}%")
                      ->orWhere('nama_pasien', 'ilike', "%{$search}%")
                      ->orWhere('mr', 'ilike', "%{$search}%")
                      ->orWhere('register', 'ilike', "%{$search}%");
                });
            }

            $data = $query->orderBy('tgl_periksa', 'desc')
                          ->orderBy('jam_periksa', 'desc')
                          ->limit($limit)
                          ->offset(($page - 1) * $limit)
                          ->get();

            $total = $query->count();

            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Upload hasil lab
    public function hasilUploadLaboratorium(Request $request)
    {
        $request->validate([
            'no_periksa' => 'required|string',
            'tgl_periksa' => 'required|date',
            'jam_periksa' => 'required',
            'register' => 'required|string',
            'mr' => 'required|string',
            'nama_pasien' => 'required|string',
            'layanan_dari' => 'required|string',
            'dokter_pengirim' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('hasil_laboratorium', $filename, 'public');

            $hasil = HasilLaboratorium::create([
                'uuid' => Uuid::uuid4()->toString(),
                'no_periksa' => $request->no_periksa,
                'pasien_uuid' => $request->pasien_uuid ?? null,
                'pasien_nama' => $request->nama_pasien,
                'register' => $request->register,
                'mr' => $request->mr,
                'tgl_periksa' => $request->tgl_periksa,
                'jam_periksa' => $request->jam_periksa,
                'layanan_dari' => $request->layanan_dari,
                'dokter_pengirim_uuid' => null,
                'dokter_pengirim' => $request->dokter_pengirim,
                'nama_file' => $file->getClientOriginalName(),
                'file_path' => $path,
                'keterangan' => $request->keterangan,
                'tanggal_upload' => date('Y-m-d'),
                'waktu_upload' => date('H:i:s'),
                'uploaded_by_uuid' => $pengguna_uuid,
                'uploaded_by_nama' => $pengguna_nama,
                'is_verified' => false,
                'delete_soft' => 0
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hasil lab berhasil diupload',
                'data' => $hasil
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update hasil radiologi
public function hasilUpdateRadiologi(Request $request, $uuid)
{
    $request->validate([
        'no_radiologi' => 'required|string',
        'tanggal' => 'required|date',
        'nama_pasien' => 'required|string',
        'register' => 'required|string',
        'pemeriksaan' => 'required|string',
        'dokter_pengirim' => 'required|string',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'keterangan' => 'nullable|string'
    ]);

    try {
        DB::beginTransaction();

        $hasil = HasilRadiologi::where('uuid', $uuid)
                              ->where('delete_soft', 0)
                              ->first();

        if (!$hasil) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $hasil->no_radiologi = $request->no_radiologi;
        $hasil->pasien_nama = $request->nama_pasien;
        $hasil->register = $request->register;
        $hasil->tanggal = $request->tanggal;
        $hasil->pemeriksaan = $request->pemeriksaan;
        $hasil->dokter_pengirim = $request->dokter_pengirim;
        $hasil->keterangan = $request->keterangan;

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($hasil->file_path && Storage::disk('public')->exists($hasil->file_path)) {
                Storage::disk('public')->delete($hasil->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('hasil_radiologi', $filename, 'public');

            $hasil->nama_file = $file->getClientOriginalName();
            $hasil->file_path = $path;
        }

        $hasil->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Hasil radiologi berhasil diupdate',
            'data' => $hasil
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal update: ' . $e->getMessage()
        ], 500);
    }
}

// Delete Lab
public function deleteLab($uuid)
{
    try {
        DB::beginTransaction();

        $hasil = HasilLaboratorium::where('uuid', $uuid)
                                  ->where('delete_soft', 0)
                                  ->first();

        if (!$hasil) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if ($hasil->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang sudah diverifikasi tidak dapat dihapus'
            ], 403);
        }

        // Soft delete
        $hasil->delete_soft = 1;
        $hasil->save();

        // Atau hard delete (jika ingin hapus permanen + file)
        // if ($hasil->file_path && Storage::disk('public')->exists($hasil->file_path)) {
        //     Storage::disk('public')->delete($hasil->file_path);
        // }
        // $hasil->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data lab berhasil dihapus'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus: ' . $e->getMessage()
        ], 500);
    }
}


// Print Lab (untuk menampilkan file PDF)
public function printLab($uuid)
{
    try {
        $hasil = HasilLaboratorium::where('uuid', $uuid)
                                  ->where('delete_soft', 0)
                                  ->first();

        if (!$hasil) {
            abort(404, 'Data tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $hasil->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan di server');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . $hasil->nama_file . '"'
        ]);
    } catch (\Exception $e) {
        abort(500, 'Gagal membuka file: ' . $e->getMessage());
    }
}

// Delete Radiologi
public function deleteRadiologi($uuid)
{
    try {
        DB::beginTransaction();

        $hasil = HasilRadiologi::where('uuid', $uuid)
                               ->where('delete_soft', 0)
                               ->first();

        if (!$hasil) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Soft delete
        $hasil->delete_soft = 1;
        $hasil->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data radiologi berhasil dihapus'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus: ' . $e->getMessage()
        ], 500);
    }
}

// Update method hasilUpdateLaboratorium untuk menerima $uuid parameter
public function hasilUpdateLaboratorium(Request $request, $uuid)
{
    $request->validate([
        'no_periksa' => 'required|string',
        'tgl_periksa' => 'required|date',
        'jam_periksa' => 'required',
        'register' => 'required|string',
        'mr' => 'required|string',
        'nama_pasien' => 'required|string',
        'layanan_dari' => 'required|string',
        'dokter_pengirim' => 'required|string',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'keterangan' => 'nullable|string'
    ]);

    try {
        DB::beginTransaction();

        $hasil = HasilLaboratorium::where('uuid', $uuid)
                                  ->where('delete_soft', 0)
                                  ->first();

        if (!$hasil) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if ($hasil->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang sudah diverifikasi tidak dapat diubah'
            ], 403);
        }

        $hasil->no_periksa = $request->no_periksa;
        $hasil->pasien_nama = $request->nama_pasien;
        $hasil->register = $request->register;
        $hasil->mr = $request->mr;
        $hasil->tgl_periksa = $request->tgl_periksa;
        $hasil->jam_periksa = $request->jam_periksa;
        $hasil->layanan_dari = $request->layanan_dari;
        $hasil->dokter_pengirim = $request->dokter_pengirim;
        $hasil->keterangan = $request->keterangan;

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($hasil->file_path && Storage::disk('public')->exists($hasil->file_path)) {
                Storage::disk('public')->delete($hasil->file_path);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('hasil_laboratorium', $filename, 'public');

            $hasil->nama_file = $file->getClientOriginalName();
            $hasil->file_path = $path;
        }

        $hasil->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Hasil lab berhasil diupdate',
            'data' => $hasil
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal update: ' . $e->getMessage()
        ], 500);
    }
}

    // User info untuk cek permission
    public function userInfo()
    {
        try {
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

            $user = \App\Models\Pengguna::where('uuid', $pengguna_uuid)->first();

            return response()->json([
                'success' => true,
                'can_verify' => $user && $user->posisi == 9987
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
// Get list hasil radiologi
    public function hasilradiologi(Request $request)
    {
        try {
            $limit = $request->limit ?? 100;
            $page = $request->page ?? 1;

            $data = HasilRadiologi::where('delete_soft', 0)
                                  ->orderBy('tanggal', 'desc')
                                  ->limit($limit)
                                  ->offset(($page - 1) * $limit)
                                  ->get();

            $total = HasilRadiologi::where('delete_soft', 0)->count();

            return response()->json([
                'success' => true,
                'data' => $data,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Upload hasil radiologi
    public function hasilUploadRadiologi(Request $request)
    {
        $request->validate([
            'no_radiologi' => 'required|string',
            'tanggal' => 'required|date',
            'nama_pasien' => 'required|string',
            'register' => 'required|string',
            'pemeriksaan' => 'required|string',
            'dokter_pengirim' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('hasil_radiologi', $filename, 'public');

            $hasil = HasilRadiologi::create([
                'uuid' => Uuid::uuid4()->toString(),
                'no_radiologi' => $request->no_radiologi,
                'pasien_uuid' => $request->pasien_uuid ?? null,
                'pasien_nama' => $request->nama_pasien,
                'register' => $request->register,
                'tanggal' => $request->tanggal,
                'pemeriksaan' => $request->pemeriksaan,
                'dokter_pengirim_uuid' => null,
                'dokter_pengirim' => $request->dokter_pengirim,
                'nama_file' => $file->getClientOriginalName(),
                'file_path' => $path,
                'keterangan' => $request->keterangan,
                'tanggal_upload' => date('Y-m-d'),
                'waktu_upload' => date('H:i:s'),
                'uploaded_by_uuid' => $pengguna_uuid,
                'uploaded_by_nama' => $pengguna_nama,
                'is_verified' => false,
                'delete_soft' => 0
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hasil radiologi berhasil diupload',
                'data' => $hasil
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload: ' . $e->getMessage()
            ], 500);
        }
    }

    // View file radiologi
    public function viewFileRadiologi($uuid)
{
    try {
        $hasil = HasilRadiologi::where('uuid', $uuid)
                               ->where('delete_soft', 0)
                               ->first();

        if (!$hasil) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $hasil->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan di server');
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . $hasil->nama_file . '"'
        ]);
    } catch (\Exception $e) {
        abort(500, 'Gagal membuka file: ' . $e->getMessage());
    }
}

}

