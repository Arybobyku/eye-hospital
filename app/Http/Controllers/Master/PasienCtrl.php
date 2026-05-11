<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cppt;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenAsuhanGizi;
use App\Models\DokumenBalanceCairanHarian;
use App\Models\DokumenDietitianPasienBaru;
use App\Models\DokumenFormLaserBarrage;
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
use App\Models\DokumenPasien;
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
use App\Models\DokumenFormLaserFokal;
use App\Models\DokumenStatusAnestesi;
use App\Models\DokumenLaporanOperasiVitreoRetina;
use App\Models\Pengguna;
use App\Models\DokumenAsesmenPraOperasi;
use Illuminate\Support\Str;              // ✅ Tambahkan ini


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
                    ->where($column, 'ilike', '%' . $search . '%')
                    ->where('rekam_medis', '!=', 'AP020739')
                    ->orderBy('status', 'desc')
                    ->skip($skip)->take($this->take)
                    ->get();
                $total = Pasien::where('delete_soft', '=', 1)
                    ->where($column, 'ilike', '%' . $search . '%')
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
            $data = Pasien::where('pasien.delete_soft', '=', 1)
                ->leftJoin(DB::raw('(SELECT DISTINCT ON (pasien_uuid) uuid, created_at, photos, status, pasien_uuid FROM registrasi ORDER BY pasien_uuid, id DESC) as registrasi'), 'pasien.uuid', '=', 'registrasi.pasien_uuid')
                ->select(
                    'pasien.*',
                    'registrasi.uuid as registrasi_uuid',
                    'registrasi.created_at as tgl_registrasi',
                    'registrasi.photos as photos',
                    'registrasi.status as status_registrasi'
                )
                ->where(function ($q) use ($search) {
                    $q->where('pasien.nama', 'ilike', '%' . $search . '%')
                        ->orWhere('pasien.no_identitas', 'ilike', '%' . $search . '%')
                        ->orWhere('pasien.rekam_medis', 'ilike', '%' . $search . '%');
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

    public function registrasiList(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('delete_soft', '=', 1)
            ->where('pasien_uuid', '=', $request->pasien_uuid)
            ->orderBy('tanggal', 'desc')
            ->select('uuid', 'tanggal', 'no_pendaftaran', 'nama_dokter', 'nama_pasien', 'rekam_medis')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function soapStore(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        try {
            DB::beginTransaction();

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));

            $registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

            $item = new Cppt();
            $item->uuid            = Uuid::uuid4();
            $item->registrasi_uuid = $request->registrasi_uuid;
            $item->pasien_uuid     = $request->pasien_uuid;
            $item->pengguna_uuid   = $pengguna_uuid;
            $item->nama_pengguna   = $pengguna_nama;
            $item->nama_pasien     = $registrasi ? $registrasi->nama_pasien : '';
            $item->nama_dokter     = $registrasi ? $registrasi->nama_dokter : '';
            $item->rekam_medis     = $registrasi ? $registrasi->rekam_medis : '';
            $item->subjek          = $request->subjek ?? '';
            $item->objek           = $request->objek ?? '';
            $item->asesmen         = $request->asesmen ?? '';
            $item->plan            = $request->plan ?? '';
            $item->sebagai         = 'DOKTER';
            $item->created_at      = now();
            $item->save();

            DB::commit();
            PenggunaHelp::log('Menambahkan data CPPT & SOAP pasien');
            return response()->json(['data' => 'berhasil']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['data' => 'gagal', 'error' => $e->getMessage()], 500);
        }
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
            ->orderBy('pemeriksaan_ro.id', 'desc')
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
            $data = DokumenPersetujuanPenolakanTindakanDokter::where('uuid_pasien', '=', $search)
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

    public function getDokumenPersetujuanPenolakan(Request $request)
    {
        $data = DokumenPersetujuanPenolakanTindakanDokter::find($request->id);
        return response()->json(['data' => $data]);
    }

    public function updateDokumenPersetujuanPenolakan(Request $request)
    {
        try {
            $fields = [
                'date','time','kodemr','nama','usia','alamat','petugas','pemberi_info','penerima_info',
                'diagnosis','diagnosis_ttd','dasar_diagnosis','dasar_diagnosis_ttd',
                'tindakan_kedokteran','tindakan_kedokteran_ttd','indikasi_tindakan','indikasi_tindakan_ttd',
                'tata_cara','tata_cara_ttd','tujuan','tujuan_ttd','risiko','risiko_ttd',
                'komplikasi','komplikasi_ttd','prognosis','prognosis_ttd',
                'alternatif_dan_risiko','alternatif_dan_risiko_ttd',
                'lainlain','lainlain_ttd',
                'menyatakan_menerangkan_ttd','menyatakan_memahami_ttd',
                'yang_bertanda_tangan','berumur','jenis_kelamin','menyatakan','dilakukan_tindakan',
                'yang_menyatakan','yang_menyatakan_ttd','saksi_1','saksi_1_ttd','saksi_2','saksi_2_ttd',
            ];
            $updateData = [];
            foreach ($fields as $f) {
                if ($request->has($f)) $updateData[$f] = $request->$f;
            }
            DokumenPersetujuanPenolakanTindakanDokter::where('id', $request->id)->update($updateData);
            return response()->json(['data' => 'berhasil']);
        } catch (\Exception $e) {
            return response()->json(['data' => 'gagal', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteDokumenPersetujuanPenolakan(Request $request)
    {
        try {
            DokumenPersetujuanPenolakanTindakanDokter::where('id', $request->id)->delete();
            return response()->json(['data' => 'berhasil']);
        } catch (\Exception $e) {
            return response()->json(['data' => 'gagal', 'error' => $e->getMessage()], 500);
        }
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

        // Field date/datetime yang nullable
        $dateFields = [
            'tanggal_lahir',
            'tanggal_operasi',
            'jam_mulai',
            'jam_selesai',
            'tanggal_ttd',
        ];

        $integerFields = [
            'lama_operasi',
            'perdarahan',
        ];

        $imageBase64Fields = [
            'macam_sayatan_gambar',
            'posisi_penderita_gambar',
            'operator_bedah_ttd',
        ];

        $data = $request->except(['teknik_operasi_files', 'teknik_operasi_files_meta']);

        // 1. Konversi boolean
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }

        // 2. Sanitasi date
        foreach ($dateFields as $field) {
            if (isset($data[$field]) && ($data[$field] === '' || $data[$field] === 'null')) {
                $data[$field] = null;
            }
        }

        foreach ($integerFields as $field) {
            if (isset($data[$field]) && ($data[$field] === '' || $data[$field] === 'null')) {
                $data[$field] = null;
            }
        }

        // 3. Sanitasi gambar Base64
        foreach ($imageBase64Fields as $field) {
            if (isset($data[$field]) && ($data[$field] === '' || $data[$field] === 'null')) {
                $data[$field] = null;
            }
        }

        // ==========================================
        // ✨ HANDLE DOKUMENTASI FOTO/PDF (Storage)
        // ==========================================
        $uuidPasien = $request->input('uuid_pasien', 'umum');
        $savedFiles = [];
        $uuid = $request->input('uuid');
        $oldFiles = [];

        // 🔥 Ambil file lama jika edit mode
        if ($uuid) {
            $laporan = DokumenLaporanPembedahan::where('uuid', $uuid)->first();
            if ($laporan && $laporan->teknik_operasi_files) {
                $oldData = $laporan->teknik_operasi_files;
                $oldFiles = is_array($oldData) ? $oldData : json_decode($oldData, true) ?? [];
            }
        }

        // 🔥 Ambil metadata files (cek apakah string JSON atau sudah array)
        $filesMeta = $request->input('teknik_operasi_files_meta');

        if (is_string($filesMeta)) {
            $filesMeta = json_decode($filesMeta, true);
        }

        if (!is_array($filesMeta)) {
            $filesMeta = [];
        }

        // 🔥 Handle file upload baru (dari kamera / upload foto / PDF)
        if ($request->hasFile('teknik_operasi_files')) {
            $uploadedFiles = $request->file('teknik_operasi_files');

            // Pastikan selalu array
            if (!is_array($uploadedFiles)) {
                $uploadedFiles = [$uploadedFiles];
            }

            foreach ($uploadedFiles as $index => $file) {
                if ($file && $file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = "laporan-pembedahan/{$uuidPasien}/" . Str::uuid() . '.' . $extension;

                    // ✅ Simpan ke storage
                    $path = $file->storeAs('public/' . dirname($filename), basename($filename));

                    // Normalize path
                    $cleanPath = str_replace('public/', '', $filename);
                    $cleanPath = str_replace('\\', '/', $cleanPath);

                    $savedFiles[] = [
                        'path' => $cleanPath,
                        'name' => $file->getClientOriginalName(),
                        'type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'pdf',
                        'size' => $file->getSize(),
                    ];

                    \Log::info("✅ File {$index} tersimpan di: {$cleanPath}");
                }
            }
        }

        // 🔥 Gabungkan file lama yang tidak diganti (edit mode)
        if (!empty($filesMeta)) {
            foreach ($filesMeta as $meta) {
                if (isset($meta['is_new']) && !$meta['is_new'] && isset($meta['path'])) {
                    // File lama - pertahankan path
                    $savedFiles[] = [
                        'path' => $meta['path'],
                        'name' => $meta['name'] ?? '',
                        'type' => $meta['type'] ?? 'image',
                        'size' => $meta['size'] ?? 0,
                    ];
                }
            }
        }

        // Simpan ke data
        $data['teknik_operasi_files'] = !empty($savedFiles)
            ? json_encode($savedFiles, JSON_UNESCAPED_SLASHES)
            : null;

        // ❌ HAPUS field lama — tidak dipakai lagi
        unset($data['teknik_operasi_foto']);

        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
        $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

        // Hapus uuid dan id dari data untuk avoid mass assignment issue
        unset($data['uuid']);
        unset($data['id']);

        if ($uuid) {
            // UPDATE: cari berdasarkan UUID
            $laporan = DokumenLaporanPembedahan::where('uuid', $uuid)->first();

            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }

            // ✅ Hapus file lama yang tidak dipakai lagi
            if (!empty($oldFiles)) {
                $newPaths = array_column($savedFiles, 'path');

                foreach ($oldFiles as $oldFile) {
                    if (isset($oldFile['path']) && !in_array($oldFile['path'], $newPaths)) {
                        // File lama tidak ada di data baru → hapus dari storage
                        if (Storage::exists('public/' . $oldFile['path'])) {
                            Storage::delete('public/' . $oldFile['path']);
                            \Log::info("🗑️ File lama dihapus: {$oldFile['path']}");
                        }
                    }
                }
            }

            $data['updated_by'] = $pengguna_nama;
            $data['no_surat'] = 'RM 2.2/LP/22';
            $laporan->update($data);
            $action = 'update';
            $message = 'Laporan Pembedahan berhasil diupdate';
        } else {
            // CREATE: buat baru
            $data['created_by'] = $pengguna_nama;
            $data['no_surat'] = 'RM 2.2/LP/22';
            $laporan = DokumenLaporanPembedahan::create($data);
            $action = 'create';
            $message = 'Laporan Pembedahan berhasil disimpan';
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $laporan,
            'action' => $action,
        ], $action === 'create' ? 201 : 200);

    } catch (Exception $e) {
        DB::rollBack();
        \Log::error('❌ Error storeLaporanPembedahan: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan Laporan Pembedahan',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function storeFormLaserBarrage(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $uuid = $request->input('uuid');
            unset($data['uuid']);

            $data['mata_kanan'] = filter_var($data['mata_kanan'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['mata_kiri'] = filter_var($data['mata_kiri'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($uuid) {
                $dokumen = DokumenFormLaserBarrage::where('uuid', $uuid)->first();
                if (!$dokumen) return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Laser Barrage berhasil diupdate';
            } else {
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenFormLaserBarrage::create($data);
                $action = 'create';
                $message = 'Form Laser Barrage berhasil disimpan';
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => $message, 'data' => $dokumen, 'action' => $action], $action === 'create' ? 201 : 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Gagal menyimpan', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeBalanceCairanHarian(Request $request)
    {
        try {
            \DB::beginTransaction();

            $data = $request->all();

            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
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

            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

    public function storeSuratKontrol(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

            $uuid = $request->input('uuid');

            // Hapus uuid dari data untuk avoid mass assignment issue
            unset($data['uuid']);

            // Convert checkbox string values to boolean
            $checkboxFields = [
                'alergi_telur',
                'alergi_susu',
                'alergi_kacang',
                'alergi_gluten',
                'alergi_udang',
                'alergi_ikan',
                'alergi_hazelnut'
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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

            $uuid = $request->input('uuid');
            unset($data['uuid']);

            // Convert all checkbox values to boolean
            $booleanFields = [
                // Anesthesi
                'anesthesi_topikal',
                'anesthesi_intracamelar',
                'anesthesi_retrobulbar',
                'anesthesi_nu',
                'anesthesi_subconjunctival',
                'anesthesi_xylocain',
                'anesthesi_lidocain',
                // Insisi
                'insisi_kornea',
                'insisi_limbus',
                'insisi_sclera',
                // Wound
                'wound_main_port',
                'wound_two_side_port',
                'wound_one_side_port',
                'wound_keratome',
                'wound_crescen_knife',
                // Capsulotomi
                'capsulotomi_ccc',
                'capsulotomi_xmas_tree',
                'capsulotomi_linear',
                'capsulotomi_can_opener',
                'capsulotomi_tryphan_blue',
                // Teknik
                'teknik_ctr',
                'teknik_kapsulotomi_posterior',
                'teknik_vitrektomi_anterior',
                // Cairan
                'cairan_rl',
                'cairan_bss',
                // Lensa
                'lensa_dalam_kantung',
                'lensa_diluar_kantung',
                'lensa_bilik_mata_depan',
                'lensa_afakia',
                'lensa_sulcus_siliaris',
                'lensa_fiksasi_scleral',
                // Visko
                'visko_hpmc',
                'visko_viscoat',
                'visko_hyaluronic_acid',
                // Benang
                'benang_tanpa_jahitan',
                'benang_ethylon',
                'benang_vicryl',
                // Komplikasi
                'komplikasi_tidak_ada',
                'komplikasi_pcr',
                'komplikasi_prolaps_vitreous',
                'komplikasi_drop_nucleus',
                'komplikasi_perdarahan',
                'komplikasi_corneal_burn',
                'komplikasi_convert_ecce',
                'komplikasi_convert_icce',
                // Perawatan
                'perawatan_pulang',
                'perawatan_opname',
                // Instruksi
                'instruksi_perban_2jam',
                'instruksi_obat_setelah_buka',
                'instruksi_perban_tutup_kembali',
                'instruksi_pantangan',
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
    public function getResumeMedisRawatJalan(Request $request)
    {
        $data = DokumenResumeMedisRawatJalan::where('uuid_pasien', $request->uuid_pasien)
            ->latest()
            ->first();
        return response()->json(['data' => $data]);
    }

    public function storeResumeMedisRawatJalan(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            // Ambil data pengguna dari Cookie (encrypted)
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
                $data['tanggal'] = date('Y-m-d');
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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

    public function storeFormLaserFokal(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

            $uuid = $request->input('uuid');
            unset($data['uuid']);

            // Convert checkbox values to boolean
            $data['mata_kanan'] = filter_var($data['mata_kanan'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $data['mata_kiri'] = filter_var($data['mata_kiri'] ?? false, FILTER_VALIDATE_BOOLEAN);

            if ($uuid) {
                // UPDATE
                $dokumen = DokumenFormLaserFokal::where('uuid', $uuid)->first();

                if (! $dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);
                $action = 'update';
                $message = 'Form Laser Fokal berhasil diupdate';
            } else {
                // CREATE
                $data['created_by'] = $pengguna_nama;
                $dokumen = DokumenFormLaserFokal::create($data);
                $action = 'create';
                $message = 'Form Laser Fokal berhasil disimpan';
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
                'message' => 'Gagal menyimpan Form Laser Fokal',
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

    public function getDokumenPersetujuanUmum(Request $request)
    {
        $data = DokumenPersetujuanUmum::where('uuid', $request->uuid)->first();
        return response()->json(['data' => $data]);
    }

    public function updateDokumenPersetujuanUmum(Request $request)
    {
        try {
            $fields = [
                'nama_pemberi_informasi','nama_penerima_informasi',
                'nama_terang_pasien','nama_terang_pemberi_inf',
                'pasien_ttd','pemberi_inf_ttd',
            ];
            $updateData = [];
            foreach ($fields as $f) {
                if ($request->has($f)) $updateData[$f] = $request->$f;
            }
            DokumenPersetujuanUmum::where('uuid', $request->uuid)->update($updateData);
            return response()->json(['data' => 'berhasil']);
        } catch (\Exception $e) {
            return response()->json(['data' => 'gagal', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteDokumenPersetujuanUmum(Request $request)
    {
        try {
            DokumenPersetujuanUmum::where('uuid', $request->uuid)->delete();
            return response()->json(['data' => 'berhasil']);
        } catch (\Exception $e) {
            return response()->json(['data' => 'gagal', 'error' => $e->getMessage()], 500);
        }
    }

    // public function listBillPembayaran(Request $request)
    // {
    //     $page = $request->page - 1;
    //     $skip = $page * $this->take;
    //     $search = $request->search;

    //     if ($request->search != '') {
    //         $data = Registrasi::withSum('layanan', 'total')->withSum('layanan', 'diskon_rp')
    //             ->where('pasien_uuid', $search)
    //             ->where('status_kasir', 'Sudah Bayar')
    //             ->orderBy('created_at', 'desc')
    //             ->skip($skip)
    //             ->take($this->take)
    //             ->get();

    //         $total = Registrasi::where('pasien_uuid', '=', $search)->where('status_kasir', 'Sudah Bayar')
    //             ->orderBy('created_at', 'desc')
    //             ->orderBy('created_at', 'desc')->count();
    //     }

    //     return response()->json(['data' => $data, 'total' => $total]);
    // }

public function storeAsesmenPraOperasi(Request $request)
{
    try {
        DB::beginTransaction();

        $data = $request->all();

        // Ambil user info dari encrypted cookie
        $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
        $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

        $uuid = $request->input('uuid');
        unset($data['uuid']);
        unset($data['id']);

        // ✅ KONVERSI JENIS KELAMIN
        if (isset($data['jenis_kelamin'])) {
            $jk = $data['jenis_kelamin'];
            if (in_array($jk, ['Perempuan', 'P', 'Female', 'F', 'Wanita'])) {
                $data['jenis_kelamin'] = 'P';
            } elseif (in_array($jk, ['Laki-laki', 'L', 'Male', 'M', 'Pria'])) {
                $data['jenis_kelamin'] = 'L';
            }
        }

        // ✅ SET NOMOR SURAT JIKA KOSONG
        if (empty($data['no_surat'])) {
            $tahun = date('y'); // Format 2 digit tahun
            $data['no_surat'] = "RM 4.0/APO/{$tahun}";
        }

        if ($uuid) {
            // UPDATE
            $dokumen = DokumenAsesmenPraOperasi::where('uuid', $uuid)->first();

            if (!$dokumen) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }

            $data['updated_by'] = $pengguna_nama;
            $dokumen->update($data);
            $action = 'update';
            $message = 'Dokumen Asesmen Pra Operasi berhasil diupdate';
        } else {
            // CREATE
            $data['uuid'] = (string) Str::uuid();
            $data['created_by'] = $pengguna_nama;
            if (empty($data['tanggal'])) {
                $data['tanggal'] = date('Y-m-d');
            }
            $dokumen = DokumenAsesmenPraOperasi::create($data);
            $action = 'create';
            $message = 'Dokumen Asesmen Pra Operasi berhasil disimpan';
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $dokumen,
            'action' => $action,
        ], $action === 'create' ? 201 : 200);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan Dokumen Asesmen Pra Operasi',
            'error' => $e->getMessage(),
        ], 500);
    }
}




    public function dokumenList(Request $request)
    {
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

    public function dokumenStore(Request $request)
    {
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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $nama_pengguna = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

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

    public function dokumenUpdate(Request $request)
    {
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
    public function dokumenPrint($uuid)
    {
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

            // Mapping MIME type berbasis ekstensi (lebih reliable dari mime_content_type)
            $ext = strtolower(pathinfo($dokumen->nama_file, PATHINFO_EXTENSION));
            $mimeMap = [
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png'  => 'image/png',
                'gif'  => 'image/gif',
                'bmp'  => 'image/bmp',
                'webp' => 'image/webp',
                'tiff' => 'image/tiff',
                'tif'  => 'image/tiff',
                'svg'  => 'image/svg+xml',
                'pdf'  => 'application/pdf',
                'doc'  => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls'  => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
            $contentType = $mimeMap[$ext] ?? (mime_content_type($filePath) ?: 'application/octet-stream');

            // Sanitize filename untuk header Content-Disposition
            $safeFilename = rawurlencode($dokumen->nama_file);

            // Return file untuk ditampilkan di browser (bukan download)
            return response()->file($filePath, [
                'Content-Type'        => $contentType,
                'Content-Disposition' => "inline; filename*=UTF-8''{$safeFilename}",
            ]);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuka dokumen: ' . $e->getMessage());
        }
    }

    public function dokumenDelete(Request $request)
    {
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
    public function dokumenVerify(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['error' => $this->error], 403);
        }

        try {
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

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

    public function dokumenDownload(Request $request)
    {
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
    public function getUserInfo(Request $request)
    {
        try {
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

    public function storePenolakanTindakanAnestesi(Request $request)
    {
        try {
            // ✅ Debug: Lihat data yang masuk
            \Log::info('📥 REQUEST DATA:', $request->all());

            // ✅ Validasi input
            $validated = $request->validate([
                'uuid_pasien' => 'required|string',
                'jenis_form' => 'required|in:penolakan,persetujuan',
                'pernyataan_nama' => 'required|string|max:255',
                'pernyataan_tanggal_lahir' => 'required|date',
                // Tambahkan validasi field lain yang required
            ], [
                'uuid_pasien.required' => 'Data pasien harus dipilih',
                'jenis_form.required' => 'Jenis formulir harus dipilih',
                'jenis_form.in' => 'Jenis formulir tidak valid',
                'pernyataan_nama.required' => 'Nama yang menyatakan harus diisi',
                'pernyataan_tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            ]);

            DB::beginTransaction();

            $data = $request->except(['uuid', '_token']);

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));

            $uuid = $request->input('uuid');

            if ($uuid) {
                // ✅ UPDATE MODE
                $dokumen = PenolakanTindakanAnestesi::where('uuid', $uuid)->first();

                if (!$dokumen) {
                    return response()->json([
                        'status' => false,
                        'message' => '❌ Data tidak ditemukan',
                    ], 404);
                }

                $data['updated_by'] = $pengguna_nama;
                $dokumen->update($data);

                $action = 'update';
                $message = 'Form ' . ucfirst($data['jenis_form']) . ' Tindakan Anestesi berhasil diupdate';

            } else {
                // ✅ CREATE MODE
                $data['created_by'] = $pengguna_nama;
                $dokumen = PenolakanTindakanAnestesi::create($data);

                $action = 'create';
                $message = ' Form ' . ucfirst($data['jenis_form']) . ' Tindakan Anestesi berhasil disimpan';
            }

            DB::commit();

            \Log::info('✅ SUCCESS:', [
                'action' => $action,
                'uuid' => $dokumen->uuid,
                'jenis_form' => $dokumen->jenis_form
            ]);

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $dokumen,
                'action' => $action,
            ], $action === 'create' ? 201 : 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => '❌ Validasi gagal',
                'errors' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('❌ ERROR:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => '❌ Gagal menyimpan Form Tindakan Anestesi',
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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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

    public function storeFormPengkajianKeperawatanMataRawatJalan(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            // Ambil user info dari encrypted cookie
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
            $pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
            $pengguna_username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Username'));

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
    public function masterDokter(Request $request)
    {

        $data = Pengguna::whereIn('posisi', ['8808', '8809'])->where('delete_soft', '1')->where('status', 'active')
        ->get();

        return response()->json(['data' => $data]);
    }
}
