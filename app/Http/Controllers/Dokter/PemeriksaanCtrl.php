<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Jobs\SendAllJob;
use App\Jobs\SendPoliJob;
use App\Models\AntrianPoli;
use App\Models\CaraBayarKamar;
use App\Models\Cppt;
use App\Models\LayananPasien;
use App\Models\ListPaketBedahBaru;
use App\Models\Pasien;
use App\Models\PemeriksaanDokter;
use App\Models\PemeriksaanDokterIcd10;
use App\Models\PemeriksaanDokterIcd9;
use App\Models\PemeriksaanRo;
use App\Models\Registrasi;
use App\Models\RegistrasiOperasi;
use App\Models\Bedah;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\AntrianKasir;
use App\Models\AntrianFarmasi;

class PemeriksaanCtrl extends Controller
{
    private $take = 15;
    private $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = \PenggunaHelp::acl();
    }

    public function list(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $column = $request->column;

        if ($request->search != '') {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->where($column, 'ilike', '%' . $search . '%')
                ->where('ruang_poliklinik', '!=', '0')
                // ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
                // ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
                // ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS-Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS_Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
                // ->where('carabayar_nama', '!=', 'bpjs sehat')
                // ->where('carabayar_nama', '!=', 'bpjs-sehat')
                // ->where('carabayar_nama', '!=', 'bpjs_sehat')
                // ->where('berkebutuhan_khusus', '=', 'Tidak')
                ->where('berkebutuhan_khusus', '!=', 'Ya');
            // ->where('apakah_paket', '=', 'Tidak')
            // ->whereDate('tanggal', '=', date('Y-m-d'));
            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $data = $data->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }
            $data = $data->orderBy('status_dokter', 'asc')
                ->orderBy('tanggal', 'desc')
                ->orderBy('posisi_antrian_dokter', 'asc')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Belum Diperiksa')
                ->skip($skip)->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                // ->where('apakah_paket', '=', 'Tidak')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Belum Diperiksa')
                // ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
                // ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
                // ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS-Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS_Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
                // ->where('carabayar_nama', '!=', 'bpjs sehat')
                // ->where('carabayar_nama', '!=', 'bpjs-sehat')
                // ->where('carabayar_nama', '!=', 'bpjs_sehat')
                ->where('ruang_poliklinik', '!=', '0');

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $total = $total->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $total = $total->where('berkebutuhan_khusus', '=', 'Tidak')
                ->where($column, 'ilike', '%' . $search . '%')
                ->whereDate('tanggal', '=', date('Y-m-d'))
                ->orderBy('tanggal', 'desc')
                ->orderBy('posisi_antrian_dokter', 'asc')
                ->orderBy('status_dokter', 'asc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->orderBy('status_dokter', 'asc')
                ->orderBy('tanggal', 'desc')
                ->orderBy('posisi_antrian_dokter', 'asc')
                // ->where('apakah_paket', '=', 'Tidak')
                // 	->where('carabayar_nama', '!=', 'BPJS Kesehatan')
                // ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
                // ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
                // ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
                // ->where('carabayar_nama', '!=', 'BPJS Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS-Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS_Sehat')
                // ->where('carabayar_nama', '!=', 'BPJS SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
                // ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
                // ->where('carabayar_nama', '!=', 'bpjs sehat')
                // ->where('carabayar_nama', '!=', 'bpjs-sehat')
                // ->where('carabayar_nama', '!=', 'bpjs_sehat')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // });
                ->where('status_dokter', 'Belum Diperiksa');

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $data = $data->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $data = $data->where('ruang_poliklinik', '!=', '0')
                // ->where('berkebutuhan_khusus', '=', 'Tidak')
                ->where('berkebutuhan_khusus', '!=', 'Ya')
                // ->whereDate('tanggal', '=', date('Y-m-d'))
                ->skip($skip)->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                ->where('ruang_poliklinik', '!=', '0');
            // ->where('carabayar_nama', '!=', 'BPJS Kesehatan')
            // ->where('carabayar_nama', '!=', 'Bpjs Kesehatan')
            // ->where('carabayar_nama', '!=', 'bpjs kesehatan')
            // ->where('carabayar_nama', '!=', 'bpjs Kesehatan')
            // ->where('carabayar_nama', '!=', 'bpjs_kesehatan')
            // ->where('carabayar_nama', '!=', 'bpjs-kesehatan')
            // ->where('carabayar_nama', '!=', 'BPJS KESEHATAN')
            // ->where('carabayar_nama', '!=', 'BPJS_KESEHATAN')
            // ->where('carabayar_nama', '!=', 'BPJS-KESEHATAN')
            // ->where('carabayar_nama', '!=', 'BPJS Sehat')
            // ->where('carabayar_nama', '!=', 'BPJS-Sehat')
            // ->where('carabayar_nama', '!=', 'BPJS_Sehat')
            // ->where('carabayar_nama', '!=', 'BPJS SEHAT')
            // ->where('carabayar_nama', '!=', 'BPJS-SEHAT')
            // ->where('carabayar_nama', '!=', 'BPJS_SEHAT')
            // ->where('carabayar_nama', '!=', 'bpjs sehat')
            // ->where('carabayar_nama', '!=', 'bpjs-sehat')
            // ->where('carabayar_nama', '!=', 'bpjs_sehat')
            // ->where('apakah_paket', '=', 'Tidak');

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $total = $total->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $total = $total->where('berkebutuhan_khusus', '=', 'Tidak')
                // ->whereDate('tanggal', '=', date('Y-m-d'))
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Belum Diperiksa')
                ->orderBy('posisi_antrian_dokter', 'asc')
                ->orderBy('status_dokter', 'asc')
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function listhistori(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman data icd 9');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $column = $request->column;

        if ($request->search != '') {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->where($column, 'ilike', '%' . $search . '%')
                ->where('ruang_poliklinik', '!=', '0')
                // ->where('berkebutuhan_khusus', '=', 'Tidak')
                ->where('berkebutuhan_khusus', '!=', 'Ya');
            // ->where('apakah_paket', '=', 'Tidak');
            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $data = $data->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }
            $data = $data->orderBy('status_dokter', 'asc')
                ->orderBy('posisi_antrian_dokter', 'asc')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Sudah Diperiksa')
                ->skip($skip)->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                ->where('apakah_paket', '=', 'Tidak')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Sudah Diperiksa')
                ->where('ruang_poliklinik', '!=', '0');

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $total = $total->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $total = $total
                // ->where('berkebutuhan_khusus', '=', 'Tidak')
                ->where('berkebutuhan_khusus', '!=', 'Ya')
                ->where($column, 'ilike', '%' . $search . '%')
                ->orderBy('posisi_antrian_dokter', 'asc')
                ->orderBy('status_dokter', 'asc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->orderBy('tanggal', 'desc')
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // });
                ->where('status_dokter', 'Sudah Diperiksa');

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $data = $data->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $data = $data->skip($skip)->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1);

            if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                $total = $total->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
            }

            $total = $total
                // ->where(function($q) {
                // 	$q->where('status', 'Kunjungan')
                // 		->orWhere('status', 'Selesai')
                // 		->orWhere('status', 'Rawat Inap');
                // })
                ->where('status_dokter', 'Sudah Diperiksa')
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function add(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Menambahkan data pemeriksaan ro dengan nama pasien "' . $request->nama_pasien . '".');

        $uuid = '';
        $loop = false;
        do {
            $uuid = Uuid::uuid4();
            $check = PemeriksaanDokter::where('uuid', '=', $uuid)->first();
            if (!$check) {
                $loop = true;
            }
        } while ($loop == false);

        try {
            \DB::beginTransaction();

            // return response()->json(['data' => $request]);

            if ($request->uuid != '') {
                $arr = [
                    'posisi_bola_mata' => $request->posisi_bola_mata,
                    'pergerakan_bola_mata' => $request->pergerakan_bola_mata,
                    'ocular_dextra_palpebra' => $request->ocular_dextra_palpebra,
                    'ocular_dextra_conjunctiva' => $request->ocular_dextra_conjunctiva,
                    'ocular_dextra_cornea' => $request->ocular_dextra_cornea,
                    'ocular_dextra_bilik_mata_depan' => $request->ocular_dextra_bilik_mata_depan,
                    'ocular_dextra_pupil_dan_iris' => $request->ocular_dextra_pupil_dan_iris,
                    'ocular_dextra_lensa' => $request->ocular_dextra_lensa,
                    'ocular_dextra_vitreous' => $request->ocular_dextra_vitreous,
                    'ocular_dextra_funduscopy' => $request->ocular_dextra_funduscopy,
                    'ocular_sinistra_palpebra' => $request->ocular_sinistra_palpebra,
                    'ocular_sinistra_conjunctiva' => $request->ocular_sinistra_conjunctiva,
                    'ocular_sinistra_cornea' => $request->ocular_sinistra_cornea,
                    'ocular_sinistra_bilik_mata_depan' => $request->ocular_sinistra_bilik_mata_depan,
                    'ocular_sinistra_pupil_dan_iris' => $request->ocular_sinistra_pupil_dan_iris,
                    'ocular_sinistra_lensa' => $request->ocular_sinistra_lensa,
                    'ocular_sinistra_vitreous' => $request->ocular_sinistra_vitreous,
                    'ocular_sinistra_funduscopy' => $request->ocular_sinistra_funduscopy,
                    'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
                    'pemeriksaan_diagnosa' => $request->pemeriksaan_diagnosa,
                    'pemeriksaan_diagnosa_kode' => $request->pemeriksaan_diagnosa_kode,
                    'pemeriksaan_tindakan' => $request->pemeriksaan_tindakan,
                    'pemeriksaan_tindakan_kode' => $request->pemeriksaan_tindakan_kode,
                    'pemeriksaan_tata_laksana' => $request->pemeriksaan_tata_laksana,
                    'pemeriksaan_prognosa' => $request->pemeriksaan_prognosa,
                    'anamnese' => $request->anamnese,
                    'pilihan_plan' => $request->pilihan_plan,
                    'ttd_dokter' => $request->ttd_dokter,
                    'tanggal_kontrol_selanjutnya' => $request->tanggal_kontrol_selanjutnya,
                ];
                echo 'tanggal_kontrol_selanjutnya';
                echo $request->tanggal_kontrol_selanjutnya;
                $update = PemeriksaanDokter::where('registrasi_uuid', '=', $request->registrasi_uuid)->update($arr);

                PemeriksaanDokterIcd9::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
                $icd9 = json_decode($request->listicd9);
                echo 'uuidicdnine';
                echo $request->listicd9;
                foreach ($icd9 as $row) {
                    $item = new PemeriksaanDokterIcd9();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->pemeriksaan_dokter_uuid = $request->uuid;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->icdnine_uuid = $row->uuid_icdnine;

                    $item->kode_icdnine = $row->kode_icdnine;
                    $item->nama_icdnine = $row->nama_icdnine;
                    $item->save();
                }

                PemeriksaanDokterIcd10::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
                $icd10 = json_decode($request->listicd10);
                foreach ($icd10 as $row) {
                    $item = new PemeriksaanDokterIcd10();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->pemeriksaan_dokter_uuid = $request->uuid;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->icdten_uuid = $row->uuid_icdten;
                    $item->kode_icdten = $row->kode_icdten;
                    $item->nama_icdten = $row->nama_icdten;
                    $item->save();
                }

                $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid);
                if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                    $remove = $remove->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
                }
                $remove = $remove->delete();
                $tindakan = json_decode($request->tindakan);

                foreach ($tindakan as $row) {
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;

                    $item->is_paket_bedah = $row->is_paket_bedah;
                    $item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
                    $item->nama_layanan = $row->nama_tindakan_rawat_jalan;
                    $item->tarif = $row->harga;
                    $item->total = $row->harga;
                    if ($row->default == 'Ya' || $row->default == 'YA') {
                        $cek = explode(' ', $row->nama_tindakan_rawat_jalan);
                        if (count($cek) > 0) {
                            if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                                $item->jenis = 'Honor';
                                $item->nama_dokter = $request->nama_dokter;
                            } else {
                                $item->jenis = 'Administrasi';
                                $item->nama_dokter = $request->nama_dokter;
                            }
                        } else {
                            $item->jenis = 'Administrasi';
                            $item->nama_dokter = $request->nama_dokter;
                        }
                    } else {
                        $cek = explode(' ', $row->nama_tindakan_rawat_jalan);
                        if (count($cek) > 0) {
                            if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                                $item->jenis = 'Honor';
                                if ($row->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
                                    $item->nama_dokter = 'dr. Eric Jansen';
                                } else {
                                    $item->nama_dokter = $request->nama_dokter;
                                }
                            } elseif ($cek[0] == 'Administrasi') {
                                $item->jenis = 'Administrasi';
                                $item->nama_dokter = $request->nama_dokter;
                            } elseif ($cek[0] == 'Operation' || $cek[0] == 'Room') {
                                $item->jenis = 'Room';
                                $item->nama_dokter = $request->nama_dokter;
                            } else {
                                $item->jenis = 'Rawat Jalan';
                                $item->nama_dokter = $request->nama_dokter;
                            }
                        } else {
                            $item->jenis = 'Rawat Jalan';
                            $item->nama_dokter = $request->nama_dokter;
                        }
                    }
                    $item->default = $row->default;
                    $item->save();
                }

                if ($request->pilihan_plan == 'Rawat Inap') {
                    $kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->kamar_inap_jalan_jumlah_bed ?? "-")
                        ->where('carabayar_uuid', '=', $request->carabayar_uuid)
                        ->select('harga')
                        ->first();
                    $harga_kamar = 0;
                    if ($kamar) {
                        $harga_kamar = $kamar->harga;
                    }

                    $arr = [
                        'kode' => 'RI',
                        'jenis' => 'Rawat Inap',
                        'inap_jalan' => 'Rawat Inap Jalan Asuransi',
                        'status_dokter' => 'Sudah Diperiksa',
                        'kamar_inap_uuid' => $request->kamar_inap_jalan_uuid ?? "-",
                        'kamar_inap_nama' => $request->kamar_inap_jalan_nama ?? "-",
                        'kamar_inap_lantai' => $request->kamar_inap_jalan_lantai ?? 0,
                        'kamar_inap_jumlah_bed' => $request->kamar_inap_jalan_jumlah_bed ?? 0,
                        'jenis_kamar_uuid' => $request->kamar_inap_jalan_jumlah_bed ?? "-",
                        'nama_jenis_kamar' => $request->nama_jenis_jalan_kamar ?? "-",
                        'harga_kamar' => $harga_kamar,
                        'status' => 'Rawat Inap',
                    ];

                    $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $reg->uuid;
                    $item->no_pendaftaran = $reg->no_pendaftaran;
                    $item->registrasi_kode = $reg->kode;
                    $item->registrasi_nomor = $reg->nomor;
                    $item->registrasi_jenis = $reg->jenis;
                    $item->pasien_uuid = $reg->pasien_uuid;
                    $item->rekam_medis = $reg->rekam_medis;
                    $item->nama_pasien = $reg->nama_pasien;
                    $item->pengguna_uuid = $reg->pengguna_uuid;
                    $item->nama_dokter = $reg->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $reg->carabayar_uuid;
                    $item->carabayar_nama = $reg->carabayar_nama;

                    $item->layanan_uuid = 'biayakamar';
                    $item->nama_layanan = 'Tarif Kamar Rawat Inap';
                    $item->tarif = $harga_kamar;
                    $item->total = $harga_kamar;
                    $item->jenis = 'Kamar Rawat Inap';
                    $item->default = 'Tidak';
                    $item->save();

                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                    $arr = ['status' => 'Rawat Inap'];
                    $update = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
                } else {
                    $arr = [
                        'kode' => 'RJ',
                        'jenis' => 'Rawat Jalan',
                        'inap_jalan' => '',
                        'kamar_inap_uuid' => '-',
                        'kamar_inap_nama' => '-',
                        'kamar_inap_lantai' => 0,
                        'kamar_inap_jumlah_bed' => 0,
                        'jenis_kamar_uuid' => '-',
                        'nama_jenis_kamar' => '-',
                        'harga_kamar' => 0,
                        'status' => 'Kunjungan',
                    ];

                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                    $arr = ['status' => 'Kunjungan'];
                    $update = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
                }

                if ($request->pilihan_plan == 'Rawat Inap') {
                    echo 'UUID Rwat Inap:';
                    echo $request->kamar_inap_uuid;
                    $kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
                        ->where('carabayar_uuid', '=', $request->carabayar_uuid_bedah)
                        ->select('harga')
                        ->first();
                    $harga_kamar = 0;
                    if ($kamar) {
                        $harga_kamar = $kamar->harga;
                    }

                    $arr = [
                        'kode' => 'RI',
                        'jenis' => 'Rawat Inap',
                        'inap_jalan' => 'Rawat Inap Jalan Asuransi', // CHECK - YUDHA
                        'status_dokter' => 'Sudah Diperiksa',
                        'kamar_inap_uuid' => $request->kamar_inap_uuid,
                        'kamar_inap_nama' => $request->kamar_inap_nama,
                        'kamar_inap_lantai' => $request->kamar_inap_lantai,
                        'kamar_inap_jumlah_bed' => $request->kamar_inap_jumlah_bed,
                        'jenis_kamar_uuid' => $request->jenis_kamar_uuid,
                        'nama_jenis_kamar' => $request->nama_jenis_kamar,
                        'harga_kamar' => $harga_kamar,
                        'status' => 'Rawat Inap',
                    ];

                    $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
                    echo 'UUID Rwat Inap:';
                    echo $request->kamar_inap_uuid;
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $reg->uuid;
                    $item->no_pendaftaran = $reg->no_pendaftaran;
                    $item->registrasi_kode = $reg->kode;
                    $item->registrasi_nomor = $reg->nomor;
                    $item->registrasi_jenis = $reg->jenis;
                    $item->pasien_uuid = $reg->pasien_uuid;
                    $item->rekam_medis = $reg->rekam_medis;
                    $item->nama_pasien = $reg->nama_pasien;
                    $item->pengguna_uuid = $reg->pengguna_uuid;
                    $item->nama_dokter = $reg->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid_bedah;
                    $item->carabayar_nama = $request->carabayar_nama_bedah;

                    $item->layanan_uuid = 'biayakamar';
                    $item->nama_layanan = 'Tarif Kamar Rawat Inap';
                    $item->tarif = $harga_kamar;
                    $item->total = $harga_kamar;
                    $item->jenis = 'Kamar Rawat Inap';
                    $item->default = 'Tidak';
                    $item->save();

                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                    $arr = ['status' => 'Rawat Inap'];
                    $update = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
                } else {
                    $arr = [
                        'kode' => 'RJ',
                        'jenis' => 'Rawat Jalan',
                        'inap_jalan' => '',
                        'kamar_inap_uuid' => '-',
                        'kamar_inap_nama' => '-',
                        'kamar_inap_lantai' => 0,
                        'kamar_inap_jumlah_bed' => 0,
                        'jenis_kamar_uuid' => '-',
                        'nama_jenis_kamar' => '-',
                        'harga_kamar' => 0,
                        'status' => 'Kunjungan',
                    ];

                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                    $arr = ['status' => 'Kunjungan'];
                    $update = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
                }

                $arr = [
                    'ruang_poliklinik' => $request->ruang_poliklinik,
                    'status_dokter' => 'Sudah Diperiksa',
                    'dokter_jam_update' => date('H:i'),
                    'catatan' => $request->catatan,
                ];

                $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                $remove = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

                $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_paket_bedah', 1)->delete();

                $listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid)->get();
                echo 'PILIHAN PLAN:';
                echo $request->pilihan_plan;
                if ($request->pilihan_plan === 'Operasi') {
                    if ($request->paket_uuid != '' && $request->paket_uuid != ' ' && $request->paket_uuid) {
                        $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update([
                            'apakah_paket' => 'Ya',
                        ]);
                        // Periksa asuransinya : jika asuransi maka masuk ke akun asuransi
                        //											 jika umum maka masuk ke dalam bagian umum
                        $jenis_pembayaran = '-';
                        if ($request->carabayar_nama_odc != 'Umum' && $request->carabayar_nama_odc != 'BPJS Kesehatan') {
                            $jenis_pembayaran = 'Asuransi';
                        } else {
                            $jenis_pembayaran = $request->carabayar_nama_odc;
                        }

                        $item = new RegistrasiOperasi();
                        $item->uuid = Uuid::uuid4();
                        $item->carabayar_uuid = $request->carabayar_uuid;
                        $item->carabayar_nama = $request->carabayar_nama_odc;
                        $item->asuransi_uuid = $request->asuransi_uuid;
                        $item->nama_asuransi = $request->nama_asuransi;
                        $item->jenis_pembayaran = $jenis_pembayaran;

                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->no_pendaftaran = $request->no_pendaftaran;
                        $item->registrasi_kode = $request->kode;
                        $item->registrasi_nomor = $request->nomor;
                        $item->registrasi_jenis = $request->jenis;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->pengguna_uuid = $request->pengguna_uuid;
                        $item->nama_dokter = $request->nama_dokter;

                        $item->tanggal = $request->tanggal;
                        $item->waktu = $request->waktu;
                        echo 'waktu:';
                        echo $request->waktu;
                        $item->layanan_uuid = $request->paket_uuid;
                        $item->nama_layanan = $request->nama_paket;
                        $item->tarif = $request->harga_paket;
                        $item->defaults = 'Tidak';
                        $item->jenis = 'One Day Care';
                        $item->keterangan = $request->keterangan;

                        if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
                            $item->tanggal_disetujui_asuransi = date('Y-m-d');
                            $item->jam_disetujui_asuransi = date('H:i');
                            $item->posisi = 'Disetujui';
                            $item->tanggal_kirim_ke_asuransi = date('Y-m-d');
                            $item->jam_kirim_ke_asuransi = date('H:i');
                        } else {
                            $item->posisi = 'Permintaan';
                        }

                        $item->status_berkas = '-';

                        $item->tanggal_masuk_permintaan = date('Y-m-d');
                        $item->jam_masuk_permintaan = date('H:i');
                        $item->save();

                        foreach ($listpaket as $row) {
                            $item = new LayananPasien();
                            $item->uuid = Uuid::uuid4();
                            $item->registrasi_uuid = $request->registrasi_uuid;
                            $item->no_pendaftaran = $request->no_pendaftaran;
                            $item->registrasi_kode = $request->kode;
                            $item->registrasi_nomor = $request->nomor;
                            $item->is_paket_bedah = 1;
                            $item->registrasi_jenis = $request->jenis;
                            $item->pasien_uuid = $request->pasien_uuid;
                            $item->rekam_medis = $request->rekam_medis;
                            $item->nama_pasien = $request->nama_pasien;
                            $item->pengguna_uuid = $request->pengguna_uuid;
                            $item->nama_dokter = $request->nama_dokter;

                            $item->tanggal = date('Y-m-d');
                            $item->waktu = date('H:i');

                            $item->carabayar_uuid = $request->carabayar_uuid;
                            $item->carabayar_nama = $request->carabayar_nama_odc;
                            $item->layanan_uuid = $row->uuid;

                            if ($row->nama == 'Honor Operator Bedah') {
                                $item->nama_layanan = $row->sub_label;
                            } else {
                                $item->nama_layanan = $row->nama;
                            }
                            $item->tarif = $row->harga;
                            $item->total = $row->harga;
                            $item->jenis = $row->label;
                            $item->default = '-';
                            $item->others = 1;
                            $item->save();
                        }
                        //START PANGKAS ALUR
                        $data = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                        $registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->select('nomor')->first();

                        $nomor = 1;
                        if ($registrasi) {
                            $potong_kalimat = substr($registrasi->nomor, -5);
                            $potong_kalimat = (int) $potong_kalimat;
                            $nomor += $potong_kalimat;
                        }

                        if ($nomor < 9) {
                            $nomor = '0000' . $nomor;
                        } elseif ($nomor > 9 && $nomor < 100) {
                            $nomor = '000' . $nomor;
                        } elseif ($nomor > 99 && $nomor < 1000) {
                            $nomor = '00' . $nomor;
                        } elseif ($nomor > 999 && $nomor < 10000) {
                            $nomor = '0' . $nomor;
                        }

                        $nomor = date('Y') . date('m') . date('d') . $nomor;
                        $nomor_bedah = $nomor;
                        $uuid = Uuid::uuid4();
                        $uuid_bedah = $uuid;
                        $regOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                        $arr = [
                            'status_dokter' => 'Sudah Diperiksa',
                            'nama_paket_bedah' => $regOp->nama_layanan,
                            'paket_bedah_uuid' => $regOp->layanan_uuid,
                            'last_position' => 'Pendaftaran',
                        ];

                        Registrasi::where('uuid', '=', $regOp->registrasi_uuid)->update($arr);
                        /* Bagian Data Bedah */
                        $item = new Bedah();
                        $item->uuid = Uuid::uuid4();
                        $item->jenis = $data->jenis;

                        $item->registrasi_uuid = $uuid_bedah;
                        $item->no_pendaftaran = '-';
                        $item->registrasi_kode = 'ODC';
                        $item->registrasi_nomor = $nomor_bedah;
                        $item->registrasi_jenis = 'One Day Care';

                        $item->pasien_uuid = $data->pasien_uuid;
                        $item->rekam_medis = $data->rekam_medis;
                        $item->nama_pasien = $data->nama_pasien;
                        $item->pengguna_uuid = $data->pengguna_uuid;
                        $item->nama_dokter = $data->nama_dokter;

                        $item->tanggal = $data->tanggal;
                        $item->waktu = $data->waktu;

                        $item->paket_uuid = $data->layanan_uuid;
                        $item->nama_paket = $data->nama_layanan;
                        $item->harga_paket = $data->tarif;
                        $item->keterangan = $data->keterangan;
                        $item->save();

                        $arr = ['status' => 'One Day Care'];
                        Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
                        //END PANGKAS ALUR
                    }
                }
                $listpaketbedah = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid_bedah)->get();
                if ($request->paket_uuid_bedah != '' && $request->paket_uuid_bedah != ' ' && $request->paket_uuid_bedah) {
                    // Periksa asuransinya : jika asuransi maka masuk ke akun asuransi
                    //											 jika umum maka masuk ke dalam bagian umum

                    $jenis_pembayaran = '-';
                    if ($request->carabayar_nama_bedah != 'Umum' && $request->carabayar_nama_bedah != 'BPJS Kesehatan') {
                        $jenis_pembayaran = 'Asuransi';
                    } else {
                        $jenis_pembayaran = $request->carabayar_nama_bedah;
                    }

                    $item = new RegistrasiOperasi();
                    $item->uuid = Uuid::uuid4();
                    $item->carabayar_uuid = $request->carabayar_uuid_bedah;
                    $item->carabayar_nama = $request->carabayar_nama_bedah;
                    $item->asuransi_uuid = $request->asuransi_uuid_bedah;
                    $item->nama_asuransi = $request->nama_asuransi_bedah;
                    $item->jenis_pembayaran = $jenis_pembayaran;

                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = $request->tanggal_bedah;
                    $item->waktu = $request->waktu_bedah;

                    $item->layanan_uuid = $request->paket_uuid_bedah;
                    $item->nama_layanan = $request->nama_paket_bedah;
                    $item->tarif = $request->harga_paket_bedah;
                    $item->defaults = 'Tidak';
                    $item->jenis = 'Inap dan Bedah';
                    $item->keterangan = $request->keterangan_bedah;
                    $item->keterangan_inap = $request->keterangan_inap;

                    if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
                        $item->tanggal_disetujui_asuransi = date('Y-m-d');
                        $item->jam_disetujui_asuransi = date('H:i');
                        $item->posisi = 'Disetujui';
                        $item->tanggal_kirim_ke_asuransi = date('Y-m-d');
                        $item->jam_kirim_ke_asuransi = date('H:i');
                    } else {
                        $item->posisi = 'Permintaan';
                    }

                    $item->status_berkas = '-';
                    $item->tanggal_masuk_permintaan = date('Y-m-d');
                    $item->jam_masuk_permintaan = date('H:i');

                    $item->kamar_inap_uuid = $request->kamar_inap_uuid;
                    $item->kamar_inap_nama = $request->kamar_inap_nama;
                    $item->kamar_inap_lantai = $request->kamar_inap_lantai;
                    $item->kamar_inap_jumlah_bed = $request->kamar_inap_jumlah_bed;
                    $item->jenis_kamar_uuid = $request->jenis_kamar_uuid;
                    $item->nama_jenis_kamar = $request->nama_jenis_kamar;

                    $jenis_kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
                        ->where('carabayar_uuid', '=', $request->carabayar_uuid_bedah)
                        ->select('harga')
                        ->first();
                    $harga_kamar = 0;
                    if ($jenis_kamar) {
                        $harga_kamar = $jenis_kamar->harga;
                    }
                    $item->harga_kamar = $harga_kamar;

                    $item->save();

                    foreach ($listpaketbedah as $row) {
                        $item = new LayananPasien();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->no_pendaftaran = $request->no_pendaftaran;
                        $item->registrasi_kode = $request->kode;
                        $item->registrasi_nomor = $request->nomor;
                        $item->is_paket_bedah = 1;
                        $item->registrasi_jenis = $request->jenis;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->pengguna_uuid = $request->pengguna_uuid;
                        $item->nama_dokter = $request->nama_dokter;

                        $item->tanggal = date('Y-m-d');
                        $item->waktu = date('H:i');

                        $item->carabayar_uuid = $request->carabayar_uuid_bedah;
                        $item->carabayar_nama = $request->carabayar_nama_bedah;
                        $item->layanan_uuid = $row->uuid;

                        if ($row->nama == 'Honor Operator Bedah') {
                            $item->nama_layanan = $row->sub_label;
                        } else {
                            $item->nama_layanan = $row->nama;
                        }
                        $item->tarif = $row->harga;
                        $item->total = $row->harga;
                        $item->jenis = $row->label;
                        $item->default = '-';
                        $item->others = 1;
                        $item->save();
                    }

                    //START PANGKAS ALUR
                    $data = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                    $registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->select('nomor')->first();

                    $nomor = 1;
                    if ($registrasi) {
                        $potong_kalimat = substr($registrasi->nomor, -5);
                        $potong_kalimat = (int) $potong_kalimat;
                        $nomor += $potong_kalimat;
                    }

                    if ($nomor < 9) {
                        $nomor = '0000' . $nomor;
                    } elseif ($nomor > 9 && $nomor < 100) {
                        $nomor = '000' . $nomor;
                    } elseif ($nomor > 99 && $nomor < 1000) {
                        $nomor = '00' . $nomor;
                    } elseif ($nomor > 999 && $nomor < 10000) {
                        $nomor = '0' . $nomor;
                    }

                    $nomor = date('Y') . date('m') . date('d') . $nomor;
                    $nomor_bedah = $nomor;
                    $uuid = Uuid::uuid4();
                    $uuid_bedah = $uuid;
                    $regOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                    $arr = [
                        'status_dokter' => 'Sudah Diperiksa',
                        'nama_paket_bedah' => $regOp->nama_layanan,
                        'paket_bedah_uuid' => $regOp->layanan_uuid,
                        'last_position' => 'Pendaftaran',
                    ];

                    Registrasi::where('uuid', '=', $regOp->registrasi_uuid)->update($arr);
                    /* Bagian Data Bedah */
                    $item = new Bedah();
                    $item->uuid = Uuid::uuid4();
                    $item->jenis = $data->jenis;

                    $item->registrasi_uuid = $uuid_bedah;
                    $item->no_pendaftaran = '-';
                    $item->registrasi_kode = 'ODC';
                    $item->registrasi_nomor = $nomor_bedah;
                    $item->registrasi_jenis = 'One Day Care';

                    $item->pasien_uuid = $data->pasien_uuid;
                    $item->rekam_medis = $data->rekam_medis;
                    $item->nama_pasien = $data->nama_pasien;
                    $item->pengguna_uuid = $data->pengguna_uuid;
                    $item->nama_dokter = $data->nama_dokter;

                    $item->tanggal = $data->tanggal;
                    $item->waktu = $data->waktu;

                    $item->paket_uuid = $data->layanan_uuid;
                    $item->nama_paket = $data->nama_layanan;
                    $item->harga_paket = $data->tarif;
                    $item->keterangan = $data->keterangan;
                    $item->save();

                    $arr = ['status' => 'One Day Care'];
                    Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
                    //END PANGKAS ALUR
                }

                $remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 0)->delete();
                $obat = json_decode($request->obat);

                if (count($obat) > 0) {
                    $nama_layanan = 'Obat-obatan';
                    $tarif = 0;

                    foreach ($obat as $row) {
                        $item = new Resep();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->no_pendaftaran = $request->no_pendaftaran;
                        $item->registrasi_kode = $request->kode;
                        $item->registrasi_nomor = $request->nomor;
                        $item->registrasi_jenis = $request->jenis;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->dokter_uuid = $request->pengguna_uuid;
                        $item->nama_dokter = $request->nama_dokter;

                        $item->tanggal = date('Y-m-d');
                        $item->waktu = date('H:i');

                        $item->obat_uuid = $row->obat_uuid;
                        $item->nama_obat = $row->nama;
                        $item->kategori = $row->kategori;
                        $item->formularium = $row->formularium;
                        $item->golongan = $row->golongan;
                        $item->satuan_uuid_besar = $row->satuan_uuid_besar;
                        $item->nama_satuan_besar = $row->nama_satuan_besar;
                        $item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
                        $item->nama_satuan_kecil = $row->nama_satuan_kecil;
                        $item->hitung_besar = $row->hitung_besar;
                        $item->hitung_kecil = $row->hitung_kecil;
                        $item->harga_netto = $row->harga_netto;
                        $item->harga_netto_discount = $row->harga_netto_discount;
                        $item->harga_netto_ppn = $row->harga_netto_ppn;
                        $item->hpp = $row->hpp;
                        $item->hja_resep = $row->hja_resep;
                        $item->hja_non_resep = $row->hja_non_resep;
                        $item->hja_resep_besar = $row->hja_resep_besar;
                        $item->hja_non_resep_besar = $row->hja_non_resep_besar;
                        $item->margin_resep = $row->margin_resep;
                        $item->margin_non_resep = $row->margin_non_resep;
                        $item->jumlah_kecil = $row->jumlah_kecil;
                        $item->jumlah_besar = $row->jumlah_besar;
                        $item->signa = $row->signa;
                        $item->posisimata = $row->posisimata;
                        $item->total = $row->total;
                        $item->save();

                        $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                        $tarif += $hasil;
                    }

                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;

                    $item->layanan_uuid = 'obatan';
                    $item->nama_layanan = $nama_layanan;
                    $item->tarif = $tarif;
                    $item->total = $tarif;
                    $item->jenis = 'Obat-Obatan';
                    $item->default = 'Tidak';
                    $item->save();
                } else {
                    $cek = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 0)->get();

                    if (count($cek) > 1) {
                        $remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 0)->delete();
                    }
                }

                // Bagian untuk obat obatracikan
                $remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_bedah', 0)->delete();
                $obatracikan = json_decode($request->obatracikan);

                if (count($obatracikan) > 0) {
                    $nama_layanan = 'Obat Racikan';
                    $tarif = 0;

                    foreach ($obatracikan as $row) {
                        $item = new ResepRacikan();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->no_pendaftaran = $request->no_pendaftaran;
                        $item->registrasi_kode = $request->kode;
                        $item->registrasi_nomor = $request->nomor;
                        $item->registrasi_jenis = $request->jenis;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->dokter_uuid = $request->pengguna_uuid;
                        $item->nama_dokter = $request->nama_dokter;

                        $item->tanggal = date('Y-m-d');
                        $item->waktu = date('H:i');

                        $item->label = $row->label;
                        $item->kemasan = $row->kemasan;
                        $item->jumlah = $row->jumlah;
                        $item->signa = $row->signa;
                        $item->total = $row->total;
                        $item->informasi = $row->informasi;
                        $item->save();

                        $tarif += $row->total;
                    }

                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;

                    $item->layanan_uuid = 'obatracikan';
                    $item->nama_layanan = $nama_layanan;
                    $item->tarif = $tarif;
                    $item->total = $tarif;
                    $item->jenis = 'Obat Racikan';
                    $item->default = 'Tidak';
                    $item->save();
                } else {
                    $cek = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_bedah', 0)->get();

                    if (count($cek) > 1) {
                        $remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_bedah', 0)->delete();
                    }
                }

                if (count($obat) > 0 || count($obatracikan) > 0) {
                    $cek = Registrasi::where('uuid', '=', $request->registrasi_uuid)->select('rke')->orderBy('rke', 'desc')->first();
                    $nomor = 1;
                    if ($cek) {
                        $nomor += $cek->rke;
                    }
                    $arr = ['ada_obat' => 'Ya', 'rke' => $nomor];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                } else {
                    $arr = ['ada_obat' => 'Tidak', 'rke' => 0];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                }



                $registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

                // Start Antrian Farmasi
                if ($registrasi->no_antrian_farmasi == null && (count($obat) > 0 || count($obatracikan) > 0)) {
                    // Create Antrian RO
                    $uuid = '';
                    $loop = false;
                    do {
                        $uuid = Uuid::uuid4();
                        $check = AntrianFarmasi::where('uuid', '=', $uuid)->first();
                        if (!$check) {
                            $loop = true;
                        }
                    } while ($loop == false);

                    $latestAntrianRO = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

                    $latestNumber = $latestAntrianRO->number ?? 0;
                    $latestNumber = $latestNumber + 1;
                    $kodeFarmasi = 'F-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

                    $antrianFarmasi = new AntrianFarmasi();
                    $antrianFarmasi->uuid = Uuid::uuid4();
                    $antrianFarmasi->kode = 'F';
                    $antrianFarmasi->number = $latestNumber;
                    $antrianFarmasi->jenis = $request->jenis;
                    $antrianFarmasi->tanggal = date('Y-m-d');
                    $antrianFarmasi->save();

                    Registrasi::where('uuid', $request->registrasi_uuid)
                        ->update(['no_antrian_farmasi' => $kodeFarmasi]);
                }
                // End Antrian Farmasi

                // Start Antrian Kasir
                if ($registrasi->no_antrian_kasir == null && (count($obat) == 0 && count($obatracikan) == 0)) {
                    $uuid = '';
                    $loop = false;
                    do {
                        $uuid = Uuid::uuid4();
                        $check = AntrianKasir::where('uuid', '=', $uuid)->first();
                        if (!$check) {
                            $loop = true;
                        }
                    } while ($loop == false);

                    $latestAntrianKasir = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

                    $latestNumber = $latestAntrianKasir->number ?? 0;
                    $latestNumber = $latestNumber + 1;
                    $kodeKasir = 'K-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

                    $antrianKasir = new AntrianKasir();
                    $antrianKasir->uuid = Uuid::uuid4();
                    $antrianKasir->kode = 'K';
                    $antrianKasir->number = $latestNumber;
                    $antrianKasir->jenis = $request->jenis;
                    $antrianKasir->tanggal = date('Y-m-d');
                    $antrianKasir->save();

                    Registrasi::where('uuid', $request->registrasi_uuid)
                        ->update(['no_antrian_kasir' => $kodeKasir]);
                }
                // End Antrian Kasir
            } else {
                $item = new PemeriksaanDokter();
                $item->uuid = $uuid;
                $item->registrasi_uuid = $request->registrasi_uuid;
                $item->no_pendaftaran = $request->no_pendaftaran;
                $item->registrasi_kode = $request->kode;
                $item->registrasi_nomor = $request->nomor;
                $item->registrasi_jenis = $request->jenis;

                $item->pasien_uuid = $request->pasien_uuid;
                $item->rekam_medis = $request->rekam_medis;
                $item->nama_pasien = $request->nama_pasien;
                $item->pengguna_uuid = $request->pengguna_uuid;
                $item->nama_dokter = $request->nama_dokter;
                $item->ttd_dokter = $request->ttd_dokter;

                $item->tanggal = date('Y-m-d');
                $item->waktu = date('H:i');

                $item->posisi_bola_mata = $request->posisi_bola_mata;
                $item->pergerakan_bola_mata = $request->pergerakan_bola_mata;
                $item->ocular_dextra_palpebra = $request->ocular_dextra_palpebra;
                $item->ocular_dextra_conjunctiva = $request->ocular_dextra_conjunctiva;
                $item->ocular_dextra_cornea = $request->ocular_dextra_cornea;
                $item->ocular_dextra_bilik_mata_depan = $request->ocular_dextra_bilik_mata_depan;
                $item->ocular_dextra_pupil_dan_iris = $request->ocular_dextra_pupil_dan_iris;
                $item->ocular_dextra_lensa = $request->ocular_dextra_lensa;
                $item->ocular_dextra_vitreous = $request->ocular_dextra_vitreous;
                $item->ocular_dextra_funduscopy = $request->ocular_dextra_funduscopy;
                $item->ocular_sinistra_palpebra = $request->ocular_sinistra_palpebra;
                $item->ocular_sinistra_conjunctiva = $request->ocular_sinistra_conjunctiva;
                $item->ocular_sinistra_cornea = $request->ocular_sinistra_cornea;
                $item->ocular_sinistra_bilik_mata_depan = $request->ocular_sinistra_bilik_mata_depan;
                $item->ocular_sinistra_pupil_dan_iris = $request->ocular_sinistra_pupil_dan_iris;
                $item->ocular_sinistra_lensa = $request->ocular_sinistra_lensa;
                $item->ocular_sinistra_vitreous = $request->ocular_sinistra_vitreous;
                $item->ocular_sinistra_funduscopy = $request->ocular_sinistra_funduscopy;
                $item->pemeriksaan_penunjang = $request->pemeriksaan_penunjang;
                $item->pemeriksaan_diagnosa = $request->pemeriksaan_diagnosa;
                $item->pemeriksaan_diagnosa_kode = $request->pemeriksaan_diagnosa_kode;
                $item->pemeriksaan_tindakan = $request->pemeriksaan_tindakan;
                $item->pemeriksaan_tindakan_kode = $request->pemeriksaan_tindakan_kode;
                $item->pemeriksaan_tata_laksana = $request->pemeriksaan_tata_laksana;
                $item->pemeriksaan_prognosa = $request->pemeriksaan_prognosa;
                $item->anamnese = $request->anamnese;
                $item->pilihan_plan = $request->pilihan_plan;
                $item->tanggal_kontrol_selanjutnya = $request->tanggal_kontrol_selanjutnya;

                $item->save();

                PemeriksaanDokterIcd9::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
                $icd9 = json_decode($request->listicd9);
                echo 'uuidicdnine';
                echo $request->listicd9;
                foreach ($icd9 as $row) {
                    $item = new PemeriksaanDokterIcd9();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->pemeriksaan_dokter_uuid = $request->uuid;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->icdnine_uuid = $row->uuid_icdnine;

                    $item->kode_icdnine = $row->kode_icdnine;
                    $item->nama_icdnine = $row->nama_icdnine;
                    $item->save();
                }

                PemeriksaanDokterIcd10::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
                $icd10 = json_decode($request->listicd10);
                foreach ($icd10 as $row) {
                    $item = new PemeriksaanDokterIcd10();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->pemeriksaan_dokter_uuid = $request->uuid;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->icdten_uuid = $row->uuid_icdten;
                    $item->kode_icdten = $row->kode_icdten;
                    $item->nama_icdten = $row->nama_icdten;
                    $item->save();
                }

                $remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 0)->delete();

                $obat = json_decode($request->obat);

                $nama_layanan = 'Obat-obatan';
                $tarif = 0;

                foreach ($obat as $row) {
                    $item = new Resep();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->dokter_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->obat_uuid = $row->obat_uuid;
                    $item->nama_obat = $row->nama;
                    $item->kategori = $row->kategori;
                    $item->formularium = $row->formularium;
                    $item->golongan = $row->golongan;
                    $item->satuan_uuid_besar = $row->satuan_uuid_besar;
                    $item->nama_satuan_besar = $row->nama_satuan_besar;
                    $item->satuan_uuid_kecil = $row->satuan_uuid_kecil;
                    $item->nama_satuan_kecil = $row->nama_satuan_kecil;
                    $item->hitung_besar = $row->hitung_besar;
                    $item->hitung_kecil = $row->hitung_kecil;
                    $item->harga_netto = $row->harga_netto;
                    $item->harga_netto_discount = $row->harga_netto_discount;
                    $item->harga_netto_ppn = $row->harga_netto_ppn;
                    $item->hpp = $row->hpp;
                    $item->hja_resep = $row->hja_resep;
                    $item->hja_non_resep = $row->hja_non_resep;
                    $item->hja_resep_besar = $row->hja_resep_besar;
                    $item->hja_non_resep_besar = $row->hja_non_resep_besar;
                    $item->margin_resep = $row->margin_resep;
                    $item->margin_non_resep = $row->margin_non_resep;
                    $item->jumlah_kecil = $row->jumlah_kecil;
                    $item->jumlah_besar = $row->jumlah_besar;
                    $item->signa = $row->signa;
                    $item->posisimata = $row->posisimata;
                    $item->total = $row->total;
                    $item->save();

                    $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                    $tarif += $hasil;
                }

                // Bagian obat racikan

                $remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_bedah', 0)->delete();

                $obatracikan = json_decode($request->obatracikan);

                $nama_layanan_racikan = 'Obat Racikan';
                $tarifracikan = 0;

                foreach ($obatracikan as $row) {
                    $item = new ResepRacikan();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->dokter_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->label = $row->label;
                    $item->kemasan = $row->kemasan;
                    $item->jumlah = $row->jumlah;
                    $item->signa = $row->signa;

                    $item->total = $row->total;
                    $item->informasi = $row->informasi;
                    $item->save();

                    $tarifracikan += $row->total;
                }

                $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid);
                if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
                    $remove = $remove->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
                }
                $remove = $remove->delete();

                $tindakan = json_decode($request->tindakan);

                foreach ($tindakan as $row) {
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    // $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;
                    $item->layanan_uuid = $row->tindakan_rawat_jalan_uuid;
                    $item->nama_layanan = $row->nama_tindakan_rawat_jalan;
                    $item->tarif = $row->harga;
                    $item->total = $row->harga;
                    if ($row->default == 'Ya' || $row->default == 'YA') {
                        $cek = explode(' ', $row->nama_tindakan_rawat_jalan);
                        if (count($cek) > 0) {
                            if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                                $item->jenis = 'Honor';
                                $item->nama_dokter = $request->nama_dokter;
                            } else {
                                $item->jenis = 'Administrasi';
                                $item->nama_dokter = $request->nama_dokter;
                            }
                        } else {
                            $item->jenis = 'Administrasi';
                            $item->nama_dokter = $request->nama_dokter;
                        }
                    } else {
                        $cek = explode(' ', $row->nama_tindakan_rawat_jalan);
                        if (count($cek) > 0) {
                            if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                                $item->jenis = 'Honor';
                                if ($row->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
                                    $item->nama_dokter = 'dr. Eric Jansen';
                                } else {
                                    $item->nama_dokter = $request->nama_dokter;
                                }
                            } elseif ($cek[0] == 'Administrasi') {
                                $item->jenis = 'Administrasi';
                                $item->nama_dokter = $request->nama_dokter;
                            } elseif ($cek[0] == 'Operation' || $cek[0] == 'Room') {
                                $item->jenis = 'Room';
                                $item->nama_dokter = $request->nama_dokter;
                            } else {
                                $item->jenis = 'Rawat Jalan';
                                $item->nama_dokter = $request->nama_dokter;
                            }
                        } else {
                            $item->jenis = 'Rawat Jalan';
                            $item->nama_dokter = $request->nama_dokter;
                        }
                    }
                    $item->default = $row->default;
                    $item->save();
                }

                if (count($obat) > 0) {
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;

                    $item->layanan_uuid = 'obatan';
                    $item->nama_layanan = $nama_layanan;
                    $item->tarif = $tarif;
                    $item->total = $tarif;
                    $item->jenis = 'Obat-Obatan';
                    $item->default = 'Tidak';
                    $item->save();
                }

                if (count($obatracikan) > 0) {
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama;

                    $item->layanan_uuid = 'obatracikan';
                    $item->nama_layanan = $nama_layanan_racikan;
                    $item->tarif = $tarifracikan;
                    $item->total = $tarifracikan;
                    $item->jenis = 'Obat Racikan';
                    $item->default = 'Tidak';
                    $item->save();
                }
                LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_paket_bedah', 1)->delete();
                $remove = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

                if ($request->paket_uuid != '' && $request->paket_uuid != ' ' && $request->paket_uuid) {
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update([
                        'apakah_paket' => 'Ya',
                    ]);

                    // Periksa asuransinya : jika asuransi maka masuk ke akun asuransi
                    //											 jika umum maka masuk ke dalam bagian umum
                    $jenis_pembayaran = '-';
                    if ($request->carabayar_nama_odc != 'Umum' && $request->carabayar_nama_odc != 'BPJS Kesehatan') {
                        $jenis_pembayaran = 'Asuransi';
                    } else {
                        $jenis_pembayaran = $request->carabayar_nama_odc;
                    }

                    $item = new RegistrasiOperasi();
                    $item->uuid = Uuid::uuid4();
                    $item->carabayar_uuid = $request->carabayar_uuid;
                    $item->carabayar_nama = $request->carabayar_nama_odc;
                    $item->asuransi_uuid = $request->asuransi_uuid;
                    $item->nama_asuransi = $request->nama_asuransi;
                    $item->jenis_pembayaran = $jenis_pembayaran;

                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = $request->tanggal;
                    $item->waktu = $request->waktu;

                    $item->layanan_uuid = $request->paket_uuid;
                    $item->nama_layanan = $request->nama_paket;
                    $item->tarif = $request->harga_paket;
                    $item->defaults = 'Tidak';
                    $item->jenis = 'One Day Care';
                    $item->keterangan = $request->keterangan;
                    if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
                        $item->tanggal_disetujui_asuransi = date('Y-m-d');
                        $item->jam_disetujui_asuransi = date('H:i');
                        $item->posisi = 'Disetujui';
                        $item->tanggal_kirim_ke_asuransi = date('Y-m-d');
                        $item->jam_kirim_ke_asuransi = date('H:i');
                    } else {
                        $item->posisi = 'Permintaan';
                    }

                    $item->status_berkas = '-';
                    $item->tanggal_masuk_permintaan = date('Y-m-d');
                    $item->jam_masuk_permintaan = date('H:i');

                    $item->save();

                    $listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid)->get();
                    // UNTUK MASUKAN DETAIL PAKET KE TAGIHAN
                    foreach ($listpaket as $row) {
                        $item = new LayananPasien();
                        $item->uuid = Uuid::uuid4();
                        $item->registrasi_uuid = $request->registrasi_uuid;
                        $item->no_pendaftaran = $request->no_pendaftaran;
                        $item->registrasi_kode = $request->kode;
                        $item->registrasi_nomor = $request->nomor;
                        $item->registrasi_jenis = $request->jenis;
                        $item->pasien_uuid = $request->pasien_uuid;
                        $item->rekam_medis = $request->rekam_medis;
                        $item->nama_pasien = $request->nama_pasien;
                        $item->pengguna_uuid = $request->pengguna_uuid;
                        $item->nama_dokter = $request->nama_dokter;

                        $item->tanggal = date('Y-m-d');
                        $item->waktu = date('H:i');

                        $item->is_paket_bedah = 1;
                        $item->carabayar_uuid = $request->carabayar_uuid;
                        $item->carabayar_nama = $request->carabayar_nama_odc;
                        $item->layanan_uuid = $row->uuid;

                        if ($row->nama == 'Honor Operator Bedah') {
                            $item->nama_layanan = $row->sub_label;
                        } else {
                            $item->nama_layanan = $row->nama;
                        }
                        $item->tarif = $row->harga;
                        $item->total = $row->harga;
                        $item->jenis = $row->label;
                        $item->default = '-';
                        $item->others = 1;
                        $item->save();
                    }
                    //START PANGKAS ALUR
                    $data = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                    $registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->select('nomor')->first();

                    $nomor = 1;
                    if ($registrasi) {
                        $potong_kalimat = substr($registrasi->nomor, -5);
                        $potong_kalimat = (int) $potong_kalimat;
                        $nomor += $potong_kalimat;
                    }

                    if ($nomor < 9) {
                        $nomor = '0000' . $nomor;
                    } elseif ($nomor > 9 && $nomor < 100) {
                        $nomor = '000' . $nomor;
                    } elseif ($nomor > 99 && $nomor < 1000) {
                        $nomor = '00' . $nomor;
                    } elseif ($nomor > 999 && $nomor < 10000) {
                        $nomor = '0' . $nomor;
                    }

                    $nomor = date('Y') . date('m') . date('d') . $nomor;
                    $nomor_bedah = $nomor;
                    $uuid = Uuid::uuid4();
                    $uuid_bedah = $uuid;
                    $regOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

                    $arr = [
                        'status_dokter' => 'Sudah Diperiksa',
                        'nama_paket_bedah' => $regOp->nama_layanan,
                        'paket_bedah_uuid' => $regOp->layanan_uuid,
                        'last_position' => 'Pendaftaran',
                    ];

                    Registrasi::where('uuid', '=', $regOp->registrasi_uuid)->update($arr);
                    /* Bagian Data Bedah */
                    $item = new Bedah();
                    $item->uuid = Uuid::uuid4();
                    $item->jenis = $data->jenis;

                    $item->registrasi_uuid = $uuid_bedah;
                    $item->no_pendaftaran = '-';
                    $item->registrasi_kode = 'ODC';
                    $item->registrasi_nomor = $nomor_bedah;
                    $item->registrasi_jenis = 'One Day Care';

                    $item->pasien_uuid = $data->pasien_uuid;
                    $item->rekam_medis = $data->rekam_medis;
                    $item->nama_pasien = $data->nama_pasien;
                    $item->pengguna_uuid = $data->pengguna_uuid;
                    $item->nama_dokter = $data->nama_dokter;

                    $item->tanggal = $data->tanggal;
                    $item->waktu = $data->waktu;

                    $item->paket_uuid = $data->layanan_uuid;
                    $item->nama_paket = $data->nama_layanan;
                    $item->harga_paket = $data->tarif;
                    $item->keterangan = $data->keterangan;
                    $item->save();

                    $arr = ['status' => 'One Day Care'];
                    Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);
                    //END PANGKAS ALUR
                }

                if ($request->paket_uuid_bedah != '' && $request->paket_uuid_bedah != ' ' && $request->paket_uuid_bedah) {
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update([
                        'apakah_paket' => 'Ya',
                    ]);
                    // Periksa asuransinya : jika asuransi maka masuk ke akun asuransi
                    //											 jika umum maka masuk ke dalam bagian umum

                    $jenis_pembayaran = '-';
                    if ($request->carabayar_nama_bedah != 'Umum' && $request->carabayar_nama_bedah != 'BPJS Kesehatan') {
                        $jenis_pembayaran = 'Asuransi';
                    } else {
                        $jenis_pembayaran = $request->carabayar_nama_bedah;
                    }
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update([
                        'apakah_paket' => 'Ya',
                    ]);
                    $item = new RegistrasiOperasi();
                    $item->uuid = Uuid::uuid4();
                    $item->carabayar_uuid = $request->carabayar_uuid_bedah;
                    $item->carabayar_nama = $request->carabayar_nama_bedah;
                    $item->asuransi_uuid = $request->asuransi_uuid_bedah;
                    $item->nama_asuransi = $request->nama_asuransi_bedah;
                    $item->jenis_pembayaran = $jenis_pembayaran;

                    $item->registrasi_uuid = $request->registrasi_uuid;
                    $item->no_pendaftaran = $request->no_pendaftaran;
                    $item->registrasi_kode = $request->kode;
                    $item->registrasi_nomor = $request->nomor;
                    $item->registrasi_jenis = $request->jenis;
                    $item->pasien_uuid = $request->pasien_uuid;
                    $item->rekam_medis = $request->rekam_medis;
                    $item->nama_pasien = $request->nama_pasien;
                    $item->pengguna_uuid = $request->pengguna_uuid;
                    $item->nama_dokter = $request->nama_dokter;

                    $item->tanggal = $request->tanggal_bedah;
                    $item->waktu = $request->waktu_bedah;

                    $item->layanan_uuid = $request->paket_uuid_bedah;
                    $item->nama_layanan = $request->nama_paket_bedah;
                    $item->tarif = $request->harga_paket_bedah;
                    $item->defaults = 'Tidak';
                    $item->jenis = 'Inap dan Bedah';
                    $item->keterangan = $request->keterangan_bedah;
                    $item->keterangan_inap = $request->keterangan_inap;

                    if ($request->carabayar_nama == 'Umum' || $request->carabayar_nama == 'BPJS Kesehatan') {
                        $item->tanggal_disetujui_asuransi = date('Y-m-d');
                        $item->jam_disetujui_asuransi = date('H:i');
                        $item->posisi = 'Disetujui';
                        $item->tanggal_kirim_ke_asuransi = date('Y-m-d');
                        $item->jam_kirim_ke_asuransi = date('H:i');
                    } else {
                        $item->posisi = 'Permintaan';
                    }

                    $item->status_berkas = '-';
                    $item->tanggal_masuk_permintaan = date('Y-m-d');
                    $item->jam_masuk_permintaan = date('H:i');

                    $item->kamar_inap_uuid = $request->kamar_inap_uuid;
                    $item->kamar_inap_nama = $request->kamar_inap_nama;
                    $item->kamar_inap_lantai = $request->kamar_inap_lantai;
                    $item->kamar_inap_jumlah_bed = $request->kamar_inap_jumlah_bed;
                    $item->jenis_kamar_uuid = $request->jenis_kamar_uuid;
                    $item->nama_jenis_kamar = $request->nama_jenis_kamar;

                    $jenis_kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
                        ->where('carabayar_uuid', '=', $request->carabayar_uuid_bedah)
                        ->select('harga')
                        ->first();
                    $harga_kamar = 0;
                    if ($jenis_kamar) {
                        $harga_kamar = $jenis_kamar->harga;
                    }
                    $item->harga_kamar = $harga_kamar;

                    $item->save();
                }

                $no_kwitansi = '';
                $kwitansi = '';
                if ($request->pilihan_plan == 'Rawat Inap') {
                    $kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('jenis', '=', 'Rawat Inap')
                        ->where('no_kwitansi', '!=', '-')
                        ->orderBy('no_kwitansi', 'desc')->first();
                    $no_kwitansi = 'RI/RSKMPV/8875/' . date('Ymd') . '00001';
                } else {
                    $kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('no_kwitansi', '!=', '-')
                        ->where('jenis', '=', 'Rawat Jalan')
                        ->orderBy('no_kwitansi', 'desc')->first();
                    $no_kwitansi = 'RJ/RSKMPV/8875/' . date('Ymd') . '00001';
                }

                $nomor_i = 1;
                if ($kwitansi) {
                    $potong_kalimat = substr($kwitansi->no_kwitansi, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_i += $potong_kalimat;
                }
                if ($nomor_i < 10) {
                    $nomor_i = '0000' . $nomor_i;
                } elseif ($nomor_i > 9 && $nomor_i < 100) {
                    $nomor_i = '000' . $nomor_i;
                } elseif ($nomor_i > 99 && $nomor_i < 1000) {
                    $nomor_i = '00' . $nomor_i;
                } elseif ($nomor_i > 999 && $nomor_i < 10000) {
                    $nomor_i = '0' . $nomor_i;
                }

                if ($request->pilihan_plan == 'Rawat Inap') {
                    $no_kwitansi = 'RI/RSKMPV/8875/' . date('Ymd') . $nomor_i;
                } else {
                    $no_kwitansi = 'RJ/RSKMPV/8875/' . date('Ymd') . $nomor_i;
                }

                // if ($request->inap_jalan != '') {
                //	$no_kwitansi = 'RI/RSKMPV/8875/'.date('Ymd').'00001';
                // }
                // else {
                //	$no_kwitansi = 'RJ/RSKMPV/8875/'.date('Ymd').'00001';
                // }

                $invoice = '';
                $no_invoice = '';

                if ($request->pilihan_plan == 'Rawat Inap') {
                    $invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('jenis', '=', 'Rawat Inap')
                        ->where('no_invoice', '!=', '-')
                        ->orderBy('no_invoice', 'desc')->first();
                    $no_invoice = date('Ymd') . '00001';
                } else {
                    $invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('no_invoice', '!=', '-')
                        ->where('jenis', '=', 'Rawat Jalan')
                        ->orderBy('no_invoice', 'desc')->first();
                    $no_invoice = date('Ymd') . '00001';
                }

                $nomor_i = 1;
                if ($invoice) {
                    $potong_kalimat = substr($invoice->no_invoice, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_i += $potong_kalimat;
                }
                if ($nomor_i < 10) {
                    $nomor_i = '0000' . $nomor_i;
                } elseif ($nomor_i > 9 && $nomor_i < 100) {
                    $nomor_i = '000' . $nomor_i;
                } elseif ($nomor_i > 99 && $nomor_i < 1000) {
                    $nomor_i = '00' . $nomor_i;
                } elseif ($nomor_i > 999 && $nomor_i < 10000) {
                    $nomor_i = '0' . $nomor_i;
                }
                $no_invoice = date('Ymd') . $nomor_i;

                $resep = '';
                $no_resep = '';

                if ($request->pilihan_plan == 'Rawat Inap') {
                    $resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('jenis', '=', 'Rawat Inap')
                        ->where('no_resep', '!=', '-')
                        ->orderBy('no_resep', 'desc')->first();
                    $no_resep = date('Ymd') . '00001';
                } else {
                    $resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                        ->where('no_resep', '!=', '-')
                        ->where('jenis', '=', 'Rawat Jalan')
                        ->orderBy('no_resep', 'desc')->first();
                    $no_resep = date('Ymd') . '00001';
                }

                $nomor_r = 1;
                if ($resep) {
                    $potong_kalimat = substr($resep->no_resep, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_r += $potong_kalimat;
                }
                if ($nomor_r < 10) {
                    $nomor_r = '0000' . $nomor_r;
                } elseif ($nomor_r > 9 && $nomor_r < 100) {
                    $nomor_r = '000' . $nomor_r;
                } elseif ($nomor_r > 99 && $nomor_r < 1000) {
                    $nomor_r = '00' . $nomor_r;
                } elseif ($nomor_r > 999 && $nomor_r < 10000) {
                    $nomor_r = '0' . $nomor_r;
                }
                $no_resep = date('Ymd') . $nomor_r;

                $arr = [
                    'ruang_poliklinik' => $request->ruang_poliklinik,
                    'status_dokter' => 'Sudah Diperiksa',
                    'dokter_jam_selesai' => date('H:i'),
                    'catatan' => $request->catatan,
                    'no_invoice' => $no_invoice,
                    'no_kwitansi' => $no_kwitansi,
                    'no_resep' => $no_resep,
                    'last_position' => 'Pemeriksaan Dokter (Selesai)',
                ];

                $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                if (count($obat) > 0 || count($obatracikan) > 0) {
                    $cek = Registrasi::where('uuid', '=', $request->registrasi_uuid)->select('rke')->orderBy('rke', 'desc')->first();
                    $nomor = 1;
                    if ($cek) {
                        $nomor += $cek->rke;
                    }
                    $arr = ['ada_obat' => 'Ya', 'rke' => $nomor];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                } else {
                    $arr = ['ada_obat' => 'Tidak', 'rke' => 0];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                }

                if ($request->pilihan_plan == 'Rawat Inap') {
                    $kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->kamar_inap_jalan_jumlah_bed ?? "-")
                        ->where('carabayar_uuid', '=', $request->carabayar_uuid)
                        ->select('harga')
                        ->first();
                    $harga_kamar = 0;
                    if ($kamar) {
                        $harga_kamar = $kamar->harga;
                    }

                    $arr = [
                        'kode' => 'RI',
                        'jenis' => 'Rawat Inap',
                        'inap_jalan' => 'Rawat Inap Jalan Asuransi',
                        'status_dokter' => 'Sudah Diperiksa',
                        'kamar_inap_uuid' => $request->kamar_inap_jalan_uuid ?? "-",
                        'kamar_inap_nama' => $request->kamar_inap_jalan_nama ?? "-",
                        'kamar_inap_lantai' => $request->kamar_inap_jalan_lantai ?? 0,
                        'kamar_inap_jumlah_bed' => $request->kamar_inap_jalan_jumlah_bed ?? 0,
                        'jenis_kamar_uuid' => $request->kamar_inap_jalan_jumlah_bed ?? "-",
                        'nama_jenis_kamar' => $request->nama_jenis_jalan_kamar ?? "-",
                        'harga_kamar' => $harga_kamar,
                        'status' => 'Rawat Inap',
                    ];

                    $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $reg->uuid;
                    $item->no_pendaftaran = $reg->no_pendaftaran;
                    $item->registrasi_kode = $reg->kode;
                    $item->registrasi_nomor = $reg->nomor;
                    $item->registrasi_jenis = $reg->jenis;
                    $item->pasien_uuid = $reg->pasien_uuid;
                    $item->rekam_medis = $reg->rekam_medis;
                    $item->nama_pasien = $reg->nama_pasien;
                    $item->pengguna_uuid = $reg->pengguna_uuid;
                    $item->nama_dokter = $reg->nama_dokter;

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $reg->carabayar_uuid;
                    $item->carabayar_nama = $reg->carabayar_nama;

                    $item->layanan_uuid = 'biayakamar';
                    $item->nama_layanan = 'Tarif Kamar Rawat Inap';
                    $item->tarif = $harga_kamar;
                    $item->total = $harga_kamar;
                    $item->jenis = 'Kamar Rawat Inap';
                    $item->default = 'Tidak';
                    $item->save();

                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

                    $arr = ['status' => 'Rawat Inap'];
                    $update = Pasien::where('uuid', '=', $request->pasien_uuid)->update($arr);
                }

                $registrasi = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

                // Start Antrian Farmasi
                if ($registrasi->no_antrian_farmasi == null && (count($obat) > 0 || count($obatracikan) > 0)) {
                    // Create Antrian RO
                    $uuid = '';
                    $loop = false;
                    do {
                        $uuid = Uuid::uuid4();
                        $check = AntrianFarmasi::where('uuid', '=', $uuid)->first();
                        if (!$check) {
                            $loop = true;
                        }
                    } while ($loop == false);

                    $latestAntrianRO = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

                    $latestNumber = $latestAntrianRO->number ?? 0;
                    $latestNumber = $latestNumber + 1;
                    $kodeFarmasi = 'F-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

                    $antrianFarmasi = new AntrianFarmasi();
                    $antrianFarmasi->uuid = Uuid::uuid4();
                    $antrianFarmasi->kode = 'F';
                    $antrianFarmasi->number = $latestNumber;
                    $antrianFarmasi->jenis = $request->jenis;
                    $antrianFarmasi->tanggal = date('Y-m-d');
                    $antrianFarmasi->save();

                    Registrasi::where('uuid', $request->registrasi_uuid)
                        ->update(['no_antrian_farmasi' => $kodeFarmasi]);
                }
                // End Antrian Farmasi

                // Start Antrian Kasir
                if ($registrasi->no_antrian_kasir == null && (count($obat) == 0 && count($obatracikan) == 0)) {
                    $uuid = '';
                    $loop = false;
                    do {
                        $uuid = Uuid::uuid4();
                        $check = AntrianKasir::where('uuid', '=', $uuid)->first();
                        if (!$check) {
                            $loop = true;
                        }
                    } while ($loop == false);

                    $latestAntrianKasir = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

                    $latestNumber = $latestAntrianKasir->number ?? 0;
                    $latestNumber = $latestNumber + 1;
                    $kodeKasir = 'K-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

                    $antrianKasir = new AntrianKasir();
                    $antrianKasir->uuid = Uuid::uuid4();
                    $antrianKasir->kode = 'K';
                    $antrianKasir->number = $latestNumber;
                    $antrianKasir->jenis = $request->jenis;
                    $antrianKasir->tanggal = date('Y-m-d');
                    $antrianKasir->save();

                    Registrasi::where('uuid', $request->registrasi_uuid)
                        ->update(['no_antrian_kasir' => $kodeKasir]);
                }
                // End Antrian Kasir

            }
            $cppt = Cppt::where('registrasi_uuid', '=', $request->uuid)
                ->where('sebagai', '=', 'DOKTER')
                ->first();

            $pengguna_uuid = \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'Uuid'));
            if ($cppt != null) {
                $arr = [
                    'subjek' => $request->subject,
                    'objek' => $request->object,
                    'asesmen' => $request->assessment,
                    'plan' => $request->plan,
                    'pengguna_uuid' => $pengguna_uuid,
                    'sebagai' => $request->cppt_sebagai,
                    'ttd' => $request->ttd,
                ];
                $update = Cppt::where('uuid', '=', $request->uuid)
                    ->where('sebagai', '=', 'DOKTER')
                    ->update($arr);
            } else {
                $item = new Cppt();
                $item->uuid = Uuid::uuid4();
                $item->registrasi_uuid = $request->registrasi_uuid;
                $item->pasien_uuid = $request->pasien_uuid;
                $item->pengguna_uuid = $pengguna_uuid;
                $item->nama_pengguna = $request->nama_penggunna;
                $item->nama_pasien = $request->nama_pasien;
                $item->nama_dokter = $request->nama_dokter;
                $item->rekam_medis = $request->rekam_medis;
                $item->subjek = $request->subject;
                $item->objek = $request->object;
                $item->asesmen = $request->assessment;
                $item->plan = $request->plan;
                $item->sebagai = $request->cppt_sebagai;
                $item->ttd = $request->ttd;
                $item->save();
            }

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function detail(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
        }

        if ($data->dokter_jam_periksa == '-') {
            $arr = ['dokter_jam_periksa' => date('H:i'), 'last_position' => 'Pemeriksaan Dokter'];
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
        }

        $arr = ['status_antrian_dokter' => '-'];
        $cek = Registrasi::where('pengguna_uuid', '=', $data->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
            ->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

        if ($data) {
            if ($data->dokter_jam_selesai == '-') {
                $arr = ['status_antrian_dokter' => 'active'];
                $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
            }
        }

        $histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
            ->orderBy('id', 'desc')->limit(12)->get();

        $pemeriksaanro = PemeriksaanRo::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->first();

        $kunjungan = PemeriksaanDokter::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->first();

        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid);
        if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
            $layanan = $layanan->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER') . 'BioUuid')));
        }
        $layanan = $layanan->where('nama_layanan', '!=', 'Obat-obatan')
            ->where('nama_layanan', '!=', 'Obat Racikan')
            ->orderBy('id', 'desc')->get();

        $layananjalan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
            ->where(function ($q) {
                $q->where('jenis', '=', 'Room Inap Jalan')
                    ->orWhere('jenis', '=', 'Rawat Inap Jalan');
            })
            ->orderBy('id', 'desc')->get();
        $listicd9 = PemeriksaanDokterIcd9::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->get();

        $listicd10 = PemeriksaanDokterIcd10::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->get();

        $onedaycare = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)
            ->where('jenis', '=', 'One Day Care')
            ->orderBy('id', 'desc')->first();

        $bedah = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)
            ->where('jenis', '=', 'Inap dan Bedah')
            ->orderBy('id', 'desc')->first();

        $obat = Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_tambahan', '=', 0)->where('is_bedah', '=', 0)
            ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', '=', 0)
            ->orderBy('id', 'desc')->get();

        $apotek = $this->apotek();
        $apotekracikan = $this->apotek();
        $paketbedah = $this->paketbedah();
        $icd9 = $this->icd9();
        $icd10 = $this->icd10();
        $carabayartindakanrawatjalan = $this->carabayartindakanrawatjalan();
        $tindakanrawatjalan = $this->tindakanrawatjalan();
        $carabayar = $this->carabayar();
        $asuransi = $this->asuransi();

        $cppt = Cppt::where('registrasi_uuid', '=', $request->uuid)
            ->where('sebagai', '=', 'DOKTER')
            ->orderBy('id', 'desc')->first();

        return response()->json([
            'data' => $data,
            'histori' => $histori,
            'pemeriksaanro' => $pemeriksaanro,
            'kunjungan' => $kunjungan,
            'layanan' => $layanan,
            'bedah' => $bedah,
            'onedaycare' => $onedaycare,
            'obat' => $obat,
            'obatracikan' => $obatracikan,
            'apotek' => $apotek,
            'apotekracikan' => $apotekracikan,
            'paketbedah' => $paketbedah,
            'icd9' => $icd9,
            'icd10' => $icd10,
            'carabayartindakanrawatjalan' => $carabayartindakanrawatjalan,
            'tindakanrawatjalan' => $tindakanrawatjalan,
            'carabayar' => $carabayar,
            'asuransi' => $asuransi,
            'layananjalan' => $layananjalan,
            'listicd9' => $listicd9,
            'listicd10' => $listicd10,
            'cppt' => $cppt,
        ]);
    }

    public function histori(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
        }

        $histori = PemeriksaanDokter::where('pasien_uuid', '=', $data->pasien_uuid)
            ->orderBy('id', 'desc')->limit(15)->get();

        return response()->json(['data' => $data, 'histori' => $histori]);
    }

    public function update(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Mengupdate data icd 9 dengan nama "' . $request->nama . '".');

        $arr = [
            'nama' => $request->nama,
            'kode' => $request->kode,
        ];

        try {
            \DB::beginTransaction();

            $update = Icd9::where('uuid', '=', $request->uuid)->update($arr);

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function remove(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Icd9::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Menghapus data icd 9 dengan nama "' . $data->nama . '" dan id "' . $data->id . '".');
        }

        $arr = ['delete_soft' => 0];

        try {
            \DB::beginTransaction();

            $remove = Icd9::where('uuid', '=', $request->uuid)->update($arr);

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function call(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $cek = Registrasi::where('uuid', '=', $request->uuid)->first();

        $arr = ['status_antrian_dokter' => '-', 'last_position' => 'Pemeriksaan Dokter'];
        $update = Registrasi::where('pengguna_uuid', '=', $request->pengguna_uuid)->whereDate('tanggal', '=', date('Y-m-d'))
            ->where('kode', '=', 'RJ')->where('jenis', '=', 'Rawat Jalan')->update($arr);

        if ($cek->status_dokter != 'Sudah Diperiksa') {
            $arr = ['dokter_jam_periksa' => date('H:i')];
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
        }
        $arr = ['status_antrian_dokter' => 'active'];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        $get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('number', '=', $request->number)
            ->where('pemanggil', '=', $request->ruang_poliklinik)
            ->first();

        if ($get) {
            $str = 'Poliklinik ' . $request->ruang_poliklinik . '=' . $request->number;
            // after 14 Detik
            $on = Carbon::now()->addSeconds(1);
            if ($request->ruang_poliklinik == '1' || $request->ruang_poliklinik == '2' || $request->ruang_poliklinik == '3') {
                dispatch(new SendPoliJob($str))->delay($on);
            } else {
                dispatch(new SendAllJob($str))->delay($on);
            }

            return response()->json(['data' => 'berhasil']);
        }

        $get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('number', '=', $request->number)->first();
        if ($get) {
            if ($get->pemanggil != '-') {
                return response()->json(['data' => 'cannot']);
            }
        }

        $get = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('pemanggil', '=', $request->ruang_poliklinik)
            ->first();

        if ($get) {
            $arr = ['pemanggil' => '-'];
            $update = AntrianPoli::where('uuid', '=', $get->uuid)->update($arr);
        }

        $arr = ['pemanggil' => $request->ruang_poliklinik];
        $panggil = AntrianPoli::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

        $str = 'Poliklinik ' . $request->ruang_poliklinik . '=' . $request->number;
        // after 14 Detik
        $on = Carbon::now()->addSeconds(1);
        if ($request->ruang_poliklinik == '1' || $request->ruang_poliklinik == '2' || $request->ruang_poliklinik == '3') {
            dispatch(new SendPoliJob($str))->delay($on);
        } else {
            dispatch(new SendAllJob($str))->delay($on);
        }

        return response()->json(['data' => 'berhasil']);
    }

    private function apotek()
    {
        return \DB::table('harga_obat')->join('stock_opname', 'harga_obat.obat_uuid', '=', 'stock_opname.obat_uuid')
            ->orderBy('harga_obat.nama', 'asc')
            ->where('harga_obat.delete_soft', '=', '1')
            ->where('stock_opname.nama_unit', '=', 'Apotek')
            ->select([
                'harga_obat.id as harga_obat_id',
                'harga_obat.obat_uuid as obat_uuid',
                'harga_obat.nama as nama',
                'harga_obat.satuan_uuid_besar as satuan_uuid_besar',
                'harga_obat.nama_satuan_besar as nama_satuan_besar',
                'harga_obat.satuan_uuid_kecil as satuan_uuid_kecil',
                'harga_obat.nama_satuan_kecil as nama_satuan_kecil',
                'harga_obat.hitung_besar as hitung_besar',
                'harga_obat.hitung_kecil as hitung_kecil',
                'harga_obat.kategori as kategori',
                'harga_obat.formularium as formularium',
                'harga_obat.golongan as golongan',
                'harga_obat.jenis as jenis',
                'harga_obat.harga_netto as harga_netto',
                'harga_obat.harga_netto_discount as harga_netto_discount',
                'harga_obat.harga_netto_ppn as harga_netto_ppn',
                'harga_obat.hpp as hpp',
                'harga_obat.margin_resep as margin_resep',
                'harga_obat.margin_non_resep as margin_non_resep',
                'harga_obat.hja_resep as hja_resep',
                'harga_obat.hja_resep_besar as hja_resep_besar',
                'harga_obat.hja_non_resep as hja_non_resep',
                'harga_obat.hja_non_resep_besar as hja_non_resep_besar',
                'stock_opname.satuan_uuid_besar as satuan_uuid_besar',
                'stock_opname.nama_satuan_besar as nama_satuan_besar',
                'stock_opname.satuan_uuid_kecil as satuan_uuid_kecil',
                'stock_opname.nama_satuan_kecil as nama_satuan_kecil',
                'stock_opname.hitung_besar as hitung_besar',
                'stock_opname.hitung_kecil as hitung_kecil',
                'stock_opname.jumlah_kecil as jumlah_kecil',
                'stock_opname.jumlah_besar as jumlah_besar',
                'stock_opname.nama_unit as nama_unit',
            ])
            ->where('stock_opname.jumlah_kecil', '>', 0)
            ->get();
    }

    private function paketbedah()
    {
        return \DB::table('paket_bedah')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function icd9()
    {
        return \DB::table('icd_nine')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function icd10()
    {
        return \DB::table('icd_ten')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function carabayartindakanrawatjalan()
    {
        return \DB::table('carabayar_tindakan_rawat_jalan')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function tindakanrawatjalan()
    {
        return \DB::table('tindakan_rawat_jalan')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function carabayar()
    {
        return \DB::table('carabayar')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }

    private function asuransi()
    {
        return \DB::table('asuransi')->orderBy('id', 'asc')->where('delete_soft', '=', '1')->get();
    }
}
