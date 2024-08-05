<?php

namespace App\Http\Controllers\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\JadwalKontrol;
use App\Models\KamarInap;
use App\Models\LayananPasien;
use App\Models\ListPaketBedahBaru;
use App\Models\Registrasi;
use App\Models\RegistrasiOperasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PasienCtrl extends Controller
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
                                ->where($column, 'ilike', '%'.$search.'%');

            $data = $data->orderBy('id', 'desc')
                                ->where('status', 'Rawat Inap')
                                ->where('jenis', '=', 'Rawat Inap')
                                // ->where('tanggal_keluar_inap', '<', '2000-01-01')
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
                                ->skip($skip)->take($this->take)
                                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('status', 'Rawat Inap')
                                // ->where('tanggal_keluar_inap', '<', '2000-01-01')
                                ->where('jenis', '=', 'Rawat Inap');
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
            // ->where('masuk_kamar', '=', 'ya');
            $total = $total->where($column, 'ilike', '%'.$search.'%')
                                ->orderBy('id', 'desc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                                    ->orderBy('id', 'desc')
                                    // ->where('tanggal_keluar_inap', '<', '2000-01-01')
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
                                    ->where('status', 'Rawat Inap')
                                    // ->where('tanggal_keluar_inap', '<', '2000-01-01')
                                    ->where('jenis', '=', 'Rawat Inap');

            $data = $data->skip($skip)->take($this->take)
                                    ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                                ->where('status', 'Rawat Inap')
                                ->where('jenis', '=', 'Rawat Inap')
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
                                ->orderBy('id', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function getlayanan(Request $request)
    {
        $data = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('layanan_uuid', '!=', 'obatan')
                                ->where('others', '=', '0')->get();

        return response()->json(['data' => $data]);
    }

    public function getresep(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        $obat = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
                        ->where('jenis', '=', 'Rawat Inap')
                        ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)
                        ->where('jenis', '=', 'Rawat Inap')
                        ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'obat' => $obat, 'obatracikan' => $obatracikan]);
    }

    public function add(Request $request)
    {
        $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

        $item = new LayananPasien();
        $item->uuid = Uuid::uuid4();
        $item->registrasi_uuid = $request->registrasi_uuid;
        $item->no_pendaftaran = $reg->no_pendaftaran;
        $item->registrasi_kode = $reg->kode;
        $item->registrasi_nomor = $reg->nomor;
        $item->registrasi_jenis = $reg->jenis;
        $item->pasien_uuid = $reg->pasien_uuid;
        $item->rekam_medis = $reg->rekam_medis;
        $item->nama_pasien = $reg->nama_pasien;
        $item->pengguna_uuid = $reg->pengguna_uuid;
        // $item->nama_dokter = $reg->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->carabayar_uuid = $reg->carabayar_uuid;
        $item->carabayar_nama = $reg->carabayar_nama;

        $item->layanan_uuid = $request->layanan_uuid;
        $item->nama_layanan = $request->nama_layanan;
        $cek = explode(' ', $request->nama_layanan);
        if (count($cek) > 0) {
            if ($cek[0] == 'Jasa' && $request->nama_layanan == 'Jasa Perawat Ruangan') {
                $item->jenis = 'Perawat Ruangan';
                $item->nama_dokter = $reg->nama_dokter;
            } elseif ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                $item->jenis = 'Honor';
                if ($request->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
                    $item->nama_dokter = 'dr. Eric Jansen';
                } else {
                    $item->nama_dokter = $reg->nama_dokter;
                }
            } elseif ($cek[0] == 'Kamar') {
                $item->jenis = 'Kamar';
                $item->nama_dokter = $reg->nama_dokter;
            } else {
                $item->jenis = 'Rawat Inap';
                $item->nama_dokter = $reg->nama_dokter;
            }
        } else {
            $item->jenis = 'Rawat Inap';
            $item->nama_dokter = $reg->nama_dokter;
        }
        $item->tarif = $request->tarif;
        $item->total = $request->tarif;
        $item->save();

        $this->registrasi_number($request->registrasi_uuid);
        $this->registrasi_jam_selesai($request->registrasi_uuid);

        $data = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('layanan_uuid', '!=', 'obatan')
                                ->where('others', '=', '0')->get();

        return response()->json(['data' => $data]);
    }

    private function registrasi_jam_selesai($uuid)
    {
        $arr = ['tanggal_selesai_periksa' => date('Y-m-d'), 'dokter_jam_selesai' => date('H:i')];
        $update = Registrasi::where('uuid', '=', $uuid)->update($arr);
    }

    private function registrasi_number($uuid)
    {
        $cek = Registrasi::where('uuid', '=', $uuid)->first();

        if ($cek) {
            if ($cek->no_kwitansi == '-' || $cek->no_kwitansi == '' || $cek->no_kwitansi == ' ') {
                $no_kwitansi = '';
                $kwitansi = '';
                $kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('no_kwitansi', '!=', '-')
                                ->where('jenis', '=', 'Rawat Inap')
                                ->orderBy('no_kwitansi', 'desc')->first();
                $no_kwitansi = 'RI/RSKMPV/8875/'.date('Ymd').'00001';

                $nomor_k = 1;
                if ($kwitansi) {
                    $potong_kalimat = substr($kwitansi->no_kwitansi, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_k += $potong_kalimat;
                }
                if ($nomor_k < 10) {
                    $nomor_k = '0000'.$nomor_k;
                } elseif ($nomor_k > 9 && $nomor_k < 100) {
                    $nomor_k = '000'.$nomor_k;
                } elseif ($nomor_k > 99 && $nomor_k < 1000) {
                    $nomor_k = '00'.$nomor_k;
                } elseif ($nomor_k > 999 && $nomor_k < 10000) {
                    $nomor_k = '0'.$nomor_k;
                }
                $no_kwitansi = 'RI/RSKMPV/8875/'.date('Ymd').$nomor_k;

                $invoice = '';
                $no_invoice = '';

                $invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('no_invoice', '!=', '-')
                                ->where('jenis', '=', 'Rawat Inap')
                                ->orderBy('no_invoice', 'desc')->first();
                $no_invoice = date('Ymd').'00001';

                $nomor_i = 1;
                if ($invoice) {
                    $potong_kalimat = substr($invoice->no_invoice, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_i += $potong_kalimat;
                }
                if ($nomor_i < 10) {
                    $nomor_i = '0000'.$nomor_i;
                } elseif ($nomor_i > 9 && $nomor_i < 100) {
                    $nomor_i = '000'.$nomor_i;
                } elseif ($nomor_i > 99 && $nomor_i < 1000) {
                    $nomor_i = '00'.$nomor_i;
                } elseif ($nomor_i > 999 && $nomor_i < 10000) {
                    $nomor_i = '0'.$nomor_i;
                }
                $no_invoice = date('Ymd').$nomor_i;

                $resep = '';
                $no_resep = '';

                $resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
                                ->where('no_resep', '!=', '-')
                                ->where('jenis', '=', 'Rawat Inap')
                                ->orderBy('no_resep', 'desc')->first();
                $no_resep = date('Ymd').'00001';

                $nomor_r = 1;
                if ($resep) {
                    $potong_kalimat = substr($resep->no_resep, -5);
                    $potong_kalimat = (int) $potong_kalimat;
                    $nomor_r += $potong_kalimat;
                }
                if ($nomor_r < 10) {
                    $nomor_r = '0000'.$nomor_r;
                } elseif ($nomor_r > 9 && $nomor_r < 100) {
                    $nomor_r = '000'.$nomor_r;
                } elseif ($nomor_r > 99 && $nomor_r < 1000) {
                    $nomor_r = '00'.$nomor_r;
                } elseif ($nomor_r > 999 && $nomor_r < 10000) {
                    $nomor_r = '0'.$nomor_r;
                }
                $no_resep = date('Ymd').$nomor_r;

                $arr = [
                    'no_kwitansi' => $no_kwitansi,
                    'no_invoice' => $no_invoice,
                    'no_resep' => $no_resep,
                ];

                $update = Registrasi::where('uuid', '=', $uuid)->update($arr);
            }
        }
    }

    public function remove(Request $request)
    {
        $remove = LayananPasien::where('uuid', '=', $request->uuid)->delete();

        $data = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('layanan_uuid', '!=', 'obatan')
                                ->where('others', '=', '0')->get();

        return response()->json(['data' => $data]);
    }

    public function getobat(Request $request)
    {
        $data = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('jenis', '=', 'Rawat Inap')->get();

        return response()->json(['data' => $data]);
    }

    public function addobat(Request $request)
    {
        $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

        $item = new Resep();
        $item->uuid = Uuid::uuid4();
        $item->registrasi_uuid = $reg->uuid;
        $item->no_pendaftaran = $reg->no_pendaftaran;
        $item->registrasi_kode = $reg->kode;
        $item->registrasi_nomor = $reg->nomor;
        $item->registrasi_jenis = $reg->jenis;
        $item->pasien_uuid = $reg->pasien_uuid;
        $item->rekam_medis = $reg->rekam_medis;
        $item->nama_pasien = $reg->nama_pasien;
        $item->dokter_uuid = $reg->pengguna_uuid;
        $item->nama_dokter = $reg->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->obat_uuid = $request->obat_uuid;
        $item->nama_obat = $request->nama;
        $item->kategori = $request->kategori;
        $item->formularium = $request->formularium;
        $item->golongan = $request->golongan;
        $item->satuan_uuid_besar = $request->satuan_uuid_besar;
        $item->nama_satuan_besar = $request->nama_satuan_besar;
        $item->satuan_uuid_kecil = $request->satuan_uuid_kecil;
        $item->nama_satuan_kecil = $request->nama_satuan_kecil;
        $item->hitung_besar = $request->hitung_besar;
        $item->hitung_kecil = $request->hitung_kecil;
        $item->harga_netto = $request->harga_netto;
        $item->harga_netto_discount = $request->harga_netto_discount;
        $item->harga_netto_ppn = $request->harga_netto_ppn;
        $item->hpp = $request->hpp;
        $item->hja_resep = $request->hja_resep;
        $item->hja_non_resep = $request->hja_non_resep;
        $item->hja_resep_besar = $request->hja_resep_besar;
        $item->hja_non_resep_besar = $request->hja_non_resep_besar;
        $item->margin_resep = $request->margin_resep;
        $item->margin_non_resep = $request->margin_non_resep;
        $item->jumlah_kecil = $request->jumlah_kecil;
        $item->jumlah_besar = $request->jumlah_besar;
        $item->signa = $request->signa;
        $item->total = $request->total;
        $item->jenis = 'Rawat Inap';
        $item->save();

        $tarif = (int) $request->hja_resep * (int) $request->jumlah_kecil;

        $ceklayanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                    ->where('jenis', '=', 'Obat-Obatan')
                                    ->first();

        if ($ceklayanan) {
            $tarif += $ceklayanan->tarif;
            $arr = ['tarif' => $tarif, 'total' => $tarif];
            $update = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                    ->where('jenis', '=', 'Obat-Obatan')
                                    ->update($arr);
        } else {
            $item = new LayananPasien();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $request->registrasi_uuid;
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

            $item->layanan_uuid = 'obatan';
            $item->nama_layanan = 'Obat-obatan';
            $item->tarif = $tarif;
            $item->total = $tarif;
            $item->jenis = 'Obat-Obatan';
            $item->save();
        }

        $this->registrasi_number($request->registrasi_uuid);
        $this->registrasi_jam_selesai($request->registrasi_uuid);

        $cek_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();
        if (count($cek_resep) > 0) {
            $arr = ['ada_obat' => 'Ya'];
            $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
        } else {
            $arr = ['ada_obat' => 'Tidak'];
            $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
        }

        $data = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('jenis', '=', 'Rawat Inap')->get();

        return response()->json(['data' => $data]);
    }

    public function removeobat(Request $request)
    {
        $resep = Resep::where('uuid', '=', $request->uuid)->first();

        $tarif = (int) $resep->hja_resep * (int) $resep->jumlah_kecil;

        $ceklayanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                    ->where('jenis', '=', 'Obat-Obatan')
                                    ->first();

        if ($ceklayanan) {
            $sisa = $ceklayanan->tarif - $tarif;

            if ($sisa < 1) {
                $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                    ->where('jenis', '=', 'Obat-Obatan')
                                    ->delete();
            } else {
                $arr = ['tarif' => $sisa, 'total' => $sisa];
                $update = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                    ->where('jenis', '=', 'Obat-Obatan')
                                    ->update($arr);
            }
        }
        $remove = Resep::where('uuid', '=', $request->uuid)->delete();

        $cek_resep = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->get();
        if (count($cek_resep) > 0) {
            $arr = ['ada_obat' => 'Ya'];
            $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
        } else {
            $arr = ['ada_obat' => 'Tidak'];
            $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
        }

        $data = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
                                ->where('jenis', '=', 'Rawat Inap')->get();

        return response()->json(['data' => $data]);
    }

    public function addresep(Request $request)
    {
        $req = Registrasi::where('uuid', '=', $request->uuid)->first();
        $remove = Resep::where('registrasi_uuid', '=', $req->uuid)->where('jenis', '=', 'Rawat Inap')->delete();
        $obat = json_decode($request->obat);

        $nama_layanan = 'Obat-obatan';
        $tarif = 0;

        foreach ($obat as $row) {
            $item = new Resep();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $req->uuid;
            $item->no_pendaftaran = $req->no_pendaftaran;
            $item->registrasi_kode = $req->kode;
            $item->registrasi_nomor = $req->nomor;
            $item->registrasi_jenis = $req->jenis;
            $item->pasien_uuid = $req->pasien_uuid;
            $item->rekam_medis = $req->rekam_medis;
            $item->nama_pasien = $req->nama_pasien;
            $item->dokter_uuid = $req->pengguna_uuid;
            $item->nama_dokter = $req->nama_dokter;

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
            $item->jenis = 'Rawat Inap';
            $item->save();

            $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
            $tarif += $hasil;
        }

        // Bagian obat racikan

        $remove = ResepRacikan::where('registrasi_uuid', '=', $req->uuid)->where('jenis', '=', 'Rawat Inap')->delete();

        $obatracikan = json_decode($request->obatracikan);

        $nama_layanan_racikan = 'Obat Racikan';
        $tarifracikan = 0;

        foreach ($obatracikan as $row) {
            $item = new ResepRacikan();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $req->uuid;
            $item->no_pendaftaran = $req->no_pendaftaran;
            $item->registrasi_kode = $req->kode;
            $item->registrasi_nomor = $req->nomor;
            $item->registrasi_jenis = $req->jenis;
            $item->pasien_uuid = $req->pasien_uuid;
            $item->rekam_medis = $req->rekam_medis;
            $item->nama_pasien = $req->nama_pasien;
            $item->dokter_uuid = $req->pengguna_uuid;
            $item->nama_dokter = $req->nama_dokter;

            $item->tanggal = date('Y-m-d');
            $item->waktu = date('H:i');

            $item->label = $row->label;
            $item->kemasan = $row->kemasan;
            $item->jumlah = $row->jumlah;
            $item->signa = $row->signa;
            $item->total = $row->total;
            $item->informasi = $row->informasi;
            $item->jenis = 'Rawat Inap';
            $item->save();

            $tarifracikan += $row->total;
        }

        $this->registrasi_number($request->uuid);

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $obat = Resep::where('registrasi_uuid', '=', $request->uuid)
                        ->where('jenis', '=', 'Rawat Inap')
                        ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
                        ->where('jenis', '=', 'Rawat Inap')
                        ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'obat' => $obat, 'obatracikan' => $obatracikan]);
    }

    public function calculateDaysInHospital($tglMasuk, $waktuMasuk, $tglKeluar, $waktuKeluar)
    {
        // Gabungkan tanggal dan waktu
        $dateTimeMasuk = Carbon::parse("$tglMasuk $waktuMasuk");
        $dateTimeKeluar = Carbon::parse("$tglKeluar $waktuKeluar");

        // Set waktu pergantian hari
        $shiftChangeTime = Carbon::parse("$tglMasuk 10:00");

        // Hitung selisih waktu masuk dan keluar
        $totalDays = $dateTimeMasuk->diffInDays($dateTimeKeluar);

        // Jika tanggal masuk dan keluar sama, cek waktu masuk dan keluar
        if ($totalDays == 0) {
            if ($dateTimeMasuk->format('H:i') < '10:00' && $dateTimeKeluar->format('H:i') >= '10:00') {
                return 2; // Menghitung dua hari jika waktu masuk sebelum 10:00 dan waktu keluar setelah 10:00
            }

            return 1; // Menghitung satu hari jika tidak
        }

        // Tambahkan 1 hari jika waktu masuk sebelum 10:00 dan 1 hari lagi jika waktu keluar setelah 10:00
        if ($dateTimeMasuk->format('H:i') < '10:00') {
            ++$totalDays;
        }
        if ($dateTimeKeluar->format('H:i') >= '10:00') {
            ++$totalDays;
        }

        return $totalDays;
    }

    public function pulang(Request $request)
    {
        try {
            // $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
            $data = Registrasi::where('uuid', '=', $request->uuid)->first();
            $billKamar = LayananPasien::where('registrasi_uuid', $request->uuid)->where('jenis', 'Kamar Inap')->first();
            $cekkamar = KamarInap::where('uuid', '=', $data->kamar_inap_uuid)->first();
            echo 'Reg UUID';
            echo $request->uuid;
            echo 'Kamar UUID';
            echo $data->kamar_inap_uuid;
            $tglMasuk = $data->tanggal_masuk_inap;
            $waktuMasuk = $data->waktu_masuk_inap;
            $tglKeluar = $request->tanggal_keluar_inap;
            $waktuKeluar = $request->waktu_keluar_inap;
            $daysInHospital = $this->calculateDaysInHospital($tglMasuk, $waktuMasuk, $tglKeluar, $waktuKeluar);

            $arrKamar = [
                'qty' => $daysInHospital,
                'total' => $billKamar->tarif * $daysInHospital,
            ];
            echo 'arrKamar';
            echo $daysInHospital;
            LayananPasien::where('registrasi_uuid', $request->uuid)->where('jenis', 'Kamar Inap')->update($arrKamar);
            $arr = ['sisa' => ((int) $cekkamar->sisa + 1)];
            $update = KamarInap::where('uuid', '=', $data->kamar_inap_uuid)->update($arr);

            $arr2 = [
                'tanggal_keluar_inap' => $request->tanggal_keluar_inap,
                'waktu_keluar_inap' => $request->waktu_keluar_inap,
            ];
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr2);

            return response()->json(['hasil' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function addjadwalkontrol(Request $request)
    {
        try {
            $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

            $cek = JadwalKontrol::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();

            if ($cek) {
                $arr = ['tanggal' => $request->tanggal, 'waktu' => $request->waktu];
                $update = JadwalKontrol::where('uuid', '=', $cek->uuid)->update($arr);
            } else {
                $item = new JadwalKontrol();
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

                $item->tanggal = $request->tanggal;
                $item->waktu = $request->waktu;
                $item->save();
            }

            return response()->json(['hasil' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function addpaket(Request $request)
    {
        try {
            $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

            $apakah_paket = 'Tidak';
            if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
                $apakah_paket = 'Ya';
            }

            $arr = [
                'paket_bedah_uuid' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->paket_uuid : '-',
                'nama_paket_bedah' => $request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih' ? $request->nama_paket : '-',
                'apakah_paket' => $apakah_paket,
            ];

            Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
            RegistrasiOperasi::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();

            $item = new RegistrasiOperasi();
            $item->uuid = Uuid::uuid4();
            $item->carabayar_uuid = $reg->carabayar_uuid;
            $item->carabayar_nama = $reg->carabayar_nama;
            $item->asuransi_uuid = $reg->asuransi_uuid;
            $item->nama_asuransi = $reg->nama_asuransi;
            $item->jenis_pembayaran = $reg->carabayar_nama;

            $item->registrasi_uuid = $request->registrasi_uuid;
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
            echo 'waktu:';
            echo  $request->harga_paket;
            $item->layanan_uuid = $request->paket_uuid;
            $item->nama_layanan = $request->nama_paket;
            $item->tarif = $request->harga_paket;
            $item->defaults = 'Tidak';
            $item->jenis = 'One Day Care';
            // $item->keterangan = $request->keterangan;

            if ($reg->carabayar_nama == 'Umum' || $reg->carabayar_nama == 'BPJS Kesehatan') {
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

            $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)->where('is_paket_bedah', '=', 1)->delete();
            // APAKAH PERLU INSERT KE REGISTRAS OPERASI ? -Yudha
            if ($request->nama_paket != '' && $request->nama_paket != 'Silahkan Pilih') {
                $listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->paket_uuid)->get();

                foreach ($listpaket as $row) {
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
                    $item->is_paket_bedah = '1';

                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');

                    $item->carabayar_uuid = $reg->carabayar_uuid;
                    $item->carabayar_nama = $reg->carabayar_nama;
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
            }

            $this->registrasi_number($request->registrasi_uuid);
            $this->registrasi_jam_selesai($request->registrasi_uuid);

            return response()->json(['hasil' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function getjadwalkontrol(Request $request)
    {
        $data = JadwalKontrol::where('registrasi_uuid', '=', $request->registrasi_uuid)->first();
        $tanggal = '';
        $waktu = '';
        $uuid = '';
        if ($data) {
            $uuid = $data->uuid;
            $tanggal = $data->tanggal;
            $waktu = $data->waktu;
        }

        return response()->json(['uuid' => $uuid, 'tanggal' => $tanggal, 'waktu' => $waktu]);
    }

    public function detailpulang(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $waktu = '';
        $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        if ($reg) {
            $waktu = $reg->waktu_keluar_inap;
            $tanggal = $reg->tanggal_keluar_inap;
        }

        return response()->json(['data' => $reg, 'waktu_keluar_inap' => $waktu,  'tanggal_keluar_inap' => $tanggal]);
    }

    public function getpaket(Request $request)
    {
        $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

        return response()->json(['data' => $reg]);
    }
}
