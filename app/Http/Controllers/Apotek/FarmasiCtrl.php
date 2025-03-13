<?php

namespace App\Http\Controllers\Apotek;

use App\Http\Controllers\Controller;
use App\Jobs\SendAllJob;
use App\Models\AntrianFarmasi;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\AntrianKasir;
use App\Http\Controllers\Bpjs\AntrolBpjsCtrl;


class FarmasiCtrl extends Controller
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
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('id', 'desc')
                                ->where('ada_obat', '=', 'Ya')
                                ->where('jenis', '=', 'Rawat Jalan')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where(function ($q) {
                                    $q->where('status', 'Kunjungan');
                                })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->skip($skip)->take($this->take)
                                ->get();
            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('ada_obat', '=', 'Ya')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('jenis', '=', 'Rawat Jalan')->where('approvement_obat', 'no')
                                ->where(function ($q) {
                                    $q->where('status', 'Kunjungan');
                                })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('id', 'desc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                                    ->orderBy('id', 'desc')
                                    ->where('ada_obat', '=', 'Ya')
                                    // ->whereDate('tanggal', '=', date('Y-m-d'))
                                    ->where('jenis', '=', 'Rawat Jalan')->where('approvement_obat', 'no')

                                    ->where(function ($q) {
                                        $q->where('status', 'Kunjungan');
                                    })
                                    ->where(function ($q) {
                                        $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                    })
                                    ->skip($skip)->take($this->take)
                                    ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('ada_obat', '=', 'Ya')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('jenis', '=', 'Rawat Jalan')
                                ->where(function ($q) {
                                    $q->where('status', 'Kunjungan');
                                })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->orderBy('tanggal', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function listbayar(Request $request)
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
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('tanggal', 'desc')
                                ->where('ada_obat', '=', 'Ya')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('jenis', '=', 'Rawat Jalan')
                                 ->where(function ($q) {
                                     $q->where('status', 'Selesai');
                                 })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->skip($skip)->take($this->take)
                                ->get();
            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('ada_obat', '=', 'Ya')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('jenis', '=', 'Rawat Jalan')
                                 ->where(function ($q) {
                                     $q->where('status', 'Selesai');
                                 })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('tanggal', 'desc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                                    ->orderBy('tanggal', 'desc')
                                    ->where('ada_obat', '=', 'Ya')
                                    // ->whereDate('tanggal', '=', date('Y-m-d'))
                                    ->where('jenis', '=', 'Rawat Jalan')
                                     ->where(function ($q) {
                                         $q->where('status', 'Selesai');
                                     })
                                    ->where(function ($q) {
                                        $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                    })
                                    ->skip($skip)->take($this->take)
                                    ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('ada_obat', '=', 'Ya')
                                // ->whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('jenis', '=', 'Rawat Jalan')
                                ->where(function ($q) {
                                    $q->where('status', 'Selesai');
                                })
                                ->where(function ($q) {
                                    $q->where('status_dokter', '=', 'Sudah Diperiksa');
                                })
                                ->orderBy('tanggal', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function bayar(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Menerima tagihan atas nama pasien '.$data->nama_pasien.' pada tanggal '.date('Y-m-d'));
        }

        $arr = [
            'status_antrian_kasir' => '-',
            'kasir_jam_selesai' => date('H:i'),
            'status_kasir' => 'Sudah Bayar',
            'status' => 'Selesai',
            'tanggal_bayar' => date('Y-m-d'),
        ];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        $arr = ['posisi' => 'Bayar'];
        $update = LayananPasien::where('registrasi_uuid', '=', $request->uuid)->update($arr);

        $arr = ['status' => 'Aktif'];
        $update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

        return response()->json(['data' => 'berhasil']);
    }

    public function detail(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
        }

        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
                        ->orderBy('id', 'desc')->get();

        $obat = Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_tambahan', 0)->where('is_bedah', 0)
                        ->orderBy('id', 'desc')->get();

        $obatbedah = Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_tambahan', 0)->where('is_bedah', 1)
                        ->orderBy('id', 'desc')->get();

        $obattambahan = Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_tambahan', 1)->where('is_bedah', 1)
                        ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
                        ->orderBy('id', 'desc')->get();

        $obatracikanbedah = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
                        ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'layanan' => $layanan, 'obat' => $obat, 'obatracikan' => $obatracikan, 'obatbedah' => $obatbedah, 'obatracikanbedah' => $obatracikanbedah, 'obattambahan' => $obattambahan]);
    }

    public function editobat(Request $request)
    {
        try {
            \DB::beginTransaction();

            $obat = json_decode($request->obat);
            $obatbedah = json_decode($request->obatbedah);
            $obatTambahan = json_decode($request->obattambahan);

            if (count($obat) > 0) {
                $nama_layanan = 'Obat-obatan';
                $tarif = 0;

                $delete = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

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
                    $item->total = $row->total;
                    $item->is_tambahan = 0;
                    $item->save();

                    $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                    $tarif += $hasil;
                }

                $detele = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatan')->delete();

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
                $delete_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 0)->delete();
                $detele_tindakan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatan')->delete();
                $cek = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatracikan')->first();
                if (!$cek) {
                    $arr = ['ada_obat' => 'Tidak'];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                }
            }

            if (count($obatbedah) > 0) {
                $nama_layanan = 'Obat-obatan Pasca Bedah';
                $tarif = 0;

                foreach ($obatbedah as $row) {
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
                    $item->total = $row->total;
                    $item->is_tambahan = 0;
                    $item->is_bedah = 1;
                    $item->save();

                    $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                    $tarif += $hasil;
                }

                $detele = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatanbedah')->delete();

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

                $item->layanan_uuid = 'obatanbedah';
                $item->nama_layanan = $nama_layanan;
                $item->tarif = $tarif;
                $item->total = $tarif;
                $item->jenis = 'Obat-Obatan Pasca Bedah';
                $item->default = 'Tidak';
                $item->save();
            } else {
                $delete_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 0)->where('is_bedah', 1)->delete();
                $detele_tindakan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatanbedah')->delete();
                $cek = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatracikan')->orwhere('layanan_uuid', '=', 'obatan')->orwhere('layanan_uuid', '=', 'obatracikanbedah')->first();
                if (!$cek) {
                    $arr = ['ada_obat' => 'Tidak'];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                }
            }
            if (count($obatTambahan) > 0) {
                $tarif = 0;
                $nama_layanan = 'Obat/Vit Tambahan';

                foreach ($obatTambahan as $row) {
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
                    $item->total = $row->total;
                    $item->is_tambahan = 1;
                    $item->save();

                    $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                    $tarif += $hasil;
                }
                $detele = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatantambahan')->delete();

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

                $item->layanan_uuid = 'obatantambahan';
                $item->nama_layanan = $nama_layanan;
                $item->tarif = $tarif;
                $item->total = $tarif;
                $item->jenis = 'Obat/Vitamin Tambahan';
                $item->default = 'Tidak';
                $item->save();
            } else {
                $delete_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_tambahan', 1)->where('is_bedah', 0)->delete();
                $detele_tindakan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatantambahan')->delete();
                $cek = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('layanan_uuid', '=', 'obatracikan')->orwhere('layanan_uuid', '=', 'obatan')->orwhere('layanan_uuid', '=', 'obatanbedah')->orwhere('layanan_uuid', '=', 'obatracikanbedah')->first();
                if (!$cek) {
                    $arr = ['ada_obat' => 'Tidak'];
                    $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
                }
            }

            \DB::commit();

            return response()->json(['data' => 'success']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function approvement(Request $request)
    {
        // TODO: GENERATE NEXT ANTRIAN KASIR
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
        }

        // START Antrian Kasir
        if ($data->no_antrian_kasir == null) {
            $uuidKasir = '';
            $loop = false;
            do {
                $uuidKasir = Uuid::uuid4();
                $check = AntrianKasir::where('uuid', '=', $uuidKasir)->first();
                if (!$check) {
                    $loop = true;
                }
            } while ($loop == false);

            $latestAntrianKasir = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

            $latestNumber = $latestAntrianKasir->number ?? 0;
            $latestNumber = $latestNumber + 1;
            $kodeKasir = 'K-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

            $antrianKasir = new AntrianKasir();
            $antrianKasir->uuid = $uuidKasir;
            $antrianKasir->kode = 'K';
            $antrianKasir->number = $latestNumber;
            $antrianKasir->jenis = $data->jenis;
            $antrianKasir->tanggal = date('Y-m-d');

            // BPJS
            $antrianKasir->kode_poli=  $data->kode_poli_bpjs;
            $antrianKasir->poli=  $data->nama_poli_bpjs;
            $antrianKasir->uuid_pasien =  $data->pasien_uuid;
            $antrianKasir->kode_dokter =  $data->kode_dokter_bpjs;
            $antrianKasir->uuid_registrasi =  $data->uuid;

            $antrianKasir->save();

            Registrasi::where('uuid', $request->uuid)
                ->update(['no_antrian_kasir' => $kodeKasir]);
        }
        // End Antrian Kasir

        $arr = ['approvement_obat' => 'yes'];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        return response()->json(['data' => 'success']);
    }

    public function call(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');


        $item = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('number', '=', $request->number)->first();
        $kodeBooking = $item->nomor;
        $taskId = 6;
        
        $arr = ['status_antrian_farmasi' => '-', 'last_position' => 'Farmasi'];
        $cek = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);
        
        $arr = ['status_antrian_farmasi' => 'active', 'farmasi_jam_layani' => date('H:i')];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
        
        $get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
        ->where('number', '=', $request->number)
        ->where('pemanggil', '=', '1')
        ->first();
        echo("kode book".$kodeBooking);
        if ($get) {
            $str = 'Farmasi 1='.$request->number.'=kunjungan';
            $this->jeda(1, $str);
		    
            $response = app(AntrolBpjsCtrl::class)->updateWaktuAntreanFarmasi($kodeBooking, $taskId);
            // return response()->json(['data' => 'success']);
            return response()->json(['data' => 'success', 'bpjs' => $response]);

        }

        $get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('number', '=', $request->number)->first();

        if ($get) {
            if ($get->pemanggil != '-') {
                return response()->json(['data' => 'cannot']);
            }
        }

        $get = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('pemanggil', '=', '1')
                                ->first();

        if ($get) {
            $arr = ['pemanggil' => '-'];
            $update = AntrianFarmasi::where('uuid', '=', $get->uuid)->update($arr);
        }

        $arr = ['pemanggil' => '1'];
        $panggil = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

        $str = 'Farmasi 1='.$request->number.'=kunjungan';
        $this->jeda(1, $str);
		$response = app(AntrolBpjsCtrl::class)->updateWaktuAntreanFarmasi($kodeBooking, $taskId);

        return response()->json(['data' => 'success', 'bpjs' => $response]);
        
    }

    private function jeda($delay, $str)
    {
        $on = Carbon::now()->addSeconds($delay);
        dispatch(new SendAllJob($str))->delay($on);
    }

    public function terima(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "'.$data->nama_pasien);
        }

        $arr = ['approve_panjar' => '1'];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        return response()->json(['data' => 'success']);
    }

    public function panjar(Request $request)
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
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('id', 'desc')
                                ->where('panjar', '!=', '0')
                                ->where('status', '=', 'Pending')
                                ->where('status_dokter', '=', 'Sudah Diperiksa')
                                ->skip($skip)->take($this->take)
                                ->get();
            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('status', '=', 'Pending')
                                ->where('panjar', '!=', '0')
                                ->where('status_dokter', '=', 'Sudah Diperiksa')
                                ->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('id', 'desc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                                    ->orderBy('id', 'desc')
                                    ->where('status', '=', 'Pending')
                                    ->where('panjar', '!=', '0')
                                    ->where('status_dokter', '=', 'Sudah Diperiksa')
                                    ->skip($skip)->take($this->take)
                                    ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('status', '=', 'Pending')
                                ->where('panjar', '!=', '0')
                                ->where('status_dokter', '=', 'Sudah Diperiksa')->where('status', 'Kunjungan')->orderBy('id', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }
}
