<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Bedah;
use App\Models\KwitansiTagihan;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\PasienBebas;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepBebas;
use App\Models\ResepRacikan;
use App\Models\ResepRacikanBebas;
use App\Models\RincianTagihan;
use App\Models\RincianTagihanBebas;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class PrintKasirCtrl extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = \PenggunaHelp::acl();
    }

    public function print($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
        $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();
        $rawatjalan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Jalan')
                                ->select(
                                    'jenis',
                                    \DB::raw('sum(tarif) as total_tarif')
                                )
                ->groupBy('jenis')
                                ->get();

        $honorbedah = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'HONOR BEDAH')->orWhere('jenis', '=', 'Honor Operator Bedah')
                                ->select(
                                    'jenis',
                                    'nama_dokter',
                                    \DB::raw('sum(tarif) as total_tarif')
                                )
                ->groupBy('jenis', 'nama_dokter')
                                ->get();

        $groupping = LayananPasien::where('registrasi_uuid', '=', $uuid)->select('jenis')
                                            ->groupBy('jenis')
                                            ->where('jenis', '!=', 'Rawat Jalan')
                                            ->where('jenis', '!=', 'Administrasi')
                                            ->where('jenis', '!=', 'Honor')
                                            ->where('jenis', '!=', 'HONOR BEDAH')
                                            ->where('jenis', '!=', 'Honor Operator Bedah')
                                            ->where('jenis', '!=', 'Obat-Obatan')
                                            ->where('jenis', '!=', 'Obat-Obatan')
                                            ->where('jenis', '!=', 'Obat Racikan')
                                            ->get();
        $collection = new Collection();

        foreach ($groupping as $value) {
            $tmp = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', $value->jenis)
                                ->select(
                                    'jenis',
                                    \DB::raw('sum(tarif) as total_tarif')
                                )
                ->groupBy('jenis')
                                ->first();

            if ($tmp) {
                $collection->push((object) [
                    'jenis' => $tmp->jenis,
                    'tarif' => $tmp->total_tarif,
                ]);
            }
        }

        $resep = Resep::where('registrasi_uuid', '=', $uuid)->get();
        $resepracikan = ResepRacikan::where('registrasi_uuid', '=', $uuid)->get();

        $room = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Room')->get();

        $diskon = 0;

        $getdiskon = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        foreach ($getdiskon as $row) {
            if ($row->diskon_rp) {
                $diskon += $row->diskon_rp;
            }

            if ($row->diskon_persen > 0) {
                $diskon_persen = (int) ($row->tarif * ($row->diskon_persen / 100));
                $diskon += $diskon_persen;
            }
        }

        $diskon_obat_data = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatan')->first();
        $diskon_obat_data_racikan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatracikan')->first();

        $total_obat = 0;

        if ($diskon_obat_data) {
            $total_obat += $diskon_obat_data->tarif;
        }

        if ($diskon_obat_data_racikan) {
            $total_obat += $diskon_obat_data_racikan->tarif;
        }

        $administrasi = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Administrasi')->get();

        $honor = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor')->get();

        $surat_ke = 1;
        $cek = KwitansiTagihan::select('surat_ke')->orderBy('id', 'desc')->first();
        if ($cek) {
            $surat_ke += (int) $cek->surat_ke;
        }

        if ($surat_ke > 9999) {
            $surat_ke = 1;
        }

        $item = new KwitansiTagihan();
        $item->uuid = Uuid::uuid4();
        $item->registrasi_uuid = $registrasi->uuid;
        $item->no_pendaftaran = $registrasi->no_pendaftaran;
        $item->registrasi_kode = $registrasi->kode;
        $item->registrasi_nomor = $registrasi->nomor;
        $item->registrasi_jenis = $registrasi->jenis;

        $item->pasien_uuid = $registrasi->pasien_uuid;
        $item->rekam_medis = $registrasi->rekam_medis;
        $item->nama_pasien = $registrasi->nama_pasien;
        $item->dokter_uuid = $registrasi->pengguna_uuid;
        $item->nama_dokter = $registrasi->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->surat_ke = $surat_ke;
        $item->save();

        $surat = KwitansiTagihan::select('surat_ke')->where('registrasi_uuid', '=', $registrasi->uuid)->orderBy('id', 'desc')->first();

        $pdf->loadView('print.printcashier', compact('collection', 'registrasi', 'pasien', 'surat', 'layananpasien',
            'rawatjalan', 'administrasi', 'room', 'honor', 'honorbedah', 'total_obat', 'diskon'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function claim($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
        $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();
        $rawatjalan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Jalan')
                                ->select(
                                    'jenis',
                                    \DB::raw('sum(tarif) as total_tarif')
                                )
                ->groupBy('jenis')
                                ->get();

        $resep = Resep::where('registrasi_uuid', '=', $uuid)->get();
        $resepracikan = ResepRacikan::where('registrasi_uuid', '=', $uuid)->get();

        $room = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Room')->get();

        $diskon = 0;

        $getdiskon = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        foreach ($getdiskon as $row) {
            if ($row->diskon_rp) {
                $diskon += $row->diskon_rp;
            }

            if ($row->diskon_persen > 0) {
                $diskon_persen = (int) ($row->tarif * ($row->diskon_persen / 100));
                $diskon += $diskon_persen;
            }
        }

        $diskon_obat_data = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatan')->first();
        $diskon_obat_data_racikan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatracikan')->first();

        $total_obat = 0;

        if ($diskon_obat_data) {
            $total_obat = $diskon_obat_data->total;
        }

        if ($diskon_obat_data_racikan) {
            $total_obat = $diskon_obat_data_racikan->total;
        }

        $administrasi = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Administrasi')->get();

        $honor = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor')->get();

        // $surat_ke = 1;
        // $cek = KwitansiTagihan::select('surat_ke')->orderBy('id','desc')->first();
        // if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }

        // if ($surat_ke > 9999) { $surat_ke = 1; }

        // $item = new KwitansiTagihan();
        // $item->uuid = Uuid::uuid4();
        // $item->registrasi_uuid = $registrasi->uuid;
        // $item->no_pendaftaran = $registrasi->no_pendaftaran;
        // $item->registrasi_kode = $registrasi->kode;
        // $item->registrasi_nomor = $registrasi->nomor;
        // $item->registrasi_jenis = $registrasi->jenis;

        // $item->pasien_uuid = $registrasi->pasien_uuid;
        // $item->rekam_medis = $registrasi->rekam_medis;
        // $item->nama_pasien = $registrasi->nama_pasien;
        // $item->dokter_uuid = $registrasi->pengguna_uuid;
        // $item->nama_dokter = $registrasi->nama_dokter;

        // $item->tanggal = date('Y-m-d');
        // $item->waktu = date('H:i');

        // $item->surat_ke = $surat_ke;
        // $item->save();

        $surat = '-';

        $pdf->loadView('print.printclaim', compact('registrasi', 'pasien', 'surat', 'layananpasien',
            'rawatjalan', 'administrasi', 'room', 'honor', 'total_obat', 'diskon'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function pengantar($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
        $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();
        $rawatjalan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Jalan')
                                ->select(
                                    'jenis',
                                    \DB::raw('sum(tarif) as total_tarif')
                                )
                ->groupBy('jenis')
                                ->get();

        $resep = Resep::where('registrasi_uuid', '=', $uuid)->get();
        $resepracikan = ResepRacikan::where('registrasi_uuid', '=', $uuid)->get();

        $room = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Room')->get();

        $diskon = 0;

        $getdiskon = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        foreach ($getdiskon as $row) {
            if ($row->diskon_rp) {
                $diskon += $row->diskon_rp;
            }

            if ($row->diskon_persen > 0) {
                $diskon_persen = (int) ($row->tarif * ($row->diskon_persen / 100));
                $diskon += $diskon_persen;
            }
        }

        $diskon_obat_data = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatan')->first();
        $diskon_obat_data_racikan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatracikan')->first();

        $total_obat = 0;

        if ($diskon_obat_data) {
            $total_obat = $diskon_obat_data->total;
        }

        if ($diskon_obat_data_racikan) {
            $total_obat = $diskon_obat_data_racikan->total;
        }

        $administrasi = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Administrasi')->get();

        $honor = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor')->get();

        // $surat_ke = 1;
        // $cek = KwitansiTagihan::select('surat_ke')->orderBy('id','desc')->first();
        // if ($cek) { $surat_ke = $surat_ke + (int) $cek->surat_ke; }

        // if ($surat_ke > 9999) { $surat_ke = 1; }

        // $item = new KwitansiTagihan();
        // $item->uuid = Uuid::uuid4();
        // $item->registrasi_uuid = $registrasi->uuid;
        // $item->no_pendaftaran = $registrasi->no_pendaftaran;
        // $item->registrasi_kode = $registrasi->kode;
        // $item->registrasi_nomor = $registrasi->nomor;
        // $item->registrasi_jenis = $registrasi->jenis;

        // $item->pasien_uuid = $registrasi->pasien_uuid;
        // $item->rekam_medis = $registrasi->rekam_medis;
        // $item->nama_pasien = $registrasi->nama_pasien;
        // $item->dokter_uuid = $registrasi->pengguna_uuid;
        // $item->nama_dokter = $registrasi->nama_dokter;

        // $item->tanggal = date('Y-m-d');
        // $item->waktu = date('H:i');

        // $item->surat_ke = $surat_ke;
        // $item->save();

        $surat = '-';

        $pdf->loadView('print.printpengantar', compact('registrasi', 'pasien', 'surat', 'layananpasien',
            'rawatjalan', 'administrasi', 'room', 'honor', 'total_obat', 'diskon'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function printinap($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();
        $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();
        $rawatjalan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Jalan')
                                ->select(
                                    'jenis',
                                    \DB::raw('sum(total) as total_total')
                                )
                ->groupBy('jenis')
                                ->get();

        $resep = Resep::where('registrasi_uuid', '=', $uuid)->get();
        $resepracikan = ResepRacikan::where('registrasi_uuid', '=', $uuid)->get();

        $total_obat = 0;

        foreach ($resep as $value) {
            $total_obat += $value->total;
        }

        foreach ($resepracikan as $value) {
            $total_obat += $value->total;
        }

        $administrasi = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Administrasi')->get();

        $honor = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor')->get();

        $surat_ke = 1;
        $cek = KwitansiTagihan::select('surat_ke')->orderBy('id', 'desc')->first();
        if ($cek) {
            $surat_ke += (int) $cek->surat_ke;
        }

        if ($surat_ke > 9999) {
            $surat_ke = 1;
        }

        $item = new KwitansiTagihan();
        $item->uuid = Uuid::uuid4();
        $item->registrasi_uuid = $registrasi->uuid;
        $item->no_pendaftaran = $registrasi->no_pendaftaran;
        $item->registrasi_kode = $registrasi->kode;
        $item->registrasi_nomor = $registrasi->nomor;
        $item->registrasi_jenis = $registrasi->jenis;

        $item->pasien_uuid = $registrasi->pasien_uuid;
        $item->rekam_medis = $registrasi->rekam_medis;
        $item->nama_pasien = $registrasi->nama_pasien;
        $item->dokter_uuid = $registrasi->pengguna_uuid;
        $item->nama_dokter = $registrasi->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->surat_ke = $surat_ke;
        $item->save();

        $surat = KwitansiTagihan::select('surat_ke')->where('registrasi_uuid', '=', $registrasi->uuid)->orderBy('id', 'desc')->first();

        $pdf->loadView('print.printcashierbedah', compact('registrasi', 'pasien', 'surat', 'layananpasien',
            'rawatjalan', 'administrasi', 'honor', 'total_obat'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function printrincian($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        $rawatjalan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Jalan')
                                ->select(
                                    'nama_dokter',
                                    'nama_layanan',
                                    'tarif',
                                    \DB::raw('count(nama_layanan) as jumlah_nama_layanan'),
                                    \DB::raw('sum(diskon_rp) as total_diskon_rp'),
                                    \DB::raw('sum(diskon_persen) as total_diskon_persen'),
                                    \DB::raw('sum(total) as total_total'),
                                    'created_at'
                                )
                ->groupBy('nama_dokter', 'nama_layanan', 'tarif', 'created_at')
                                ->orderBy('nama_dokter', 'asc')
                                ->get();
        $administrasi = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Administrasi')->get();
        $room = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Room')->get();
        $honor = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor')->get();
        $rawatinap = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Rawat Inap')->get();
        $bedah = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Operasi/Bedah')->get();

        $obatan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatan')->first();

        $obatracikan = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatracikan')->first();
        $bedah = Bedah::where('registrasi_uuid', '=', $uuid)->get();
        $pasien = Pasien::where('uuid', '=', $registrasi->pasien_uuid)->first();

        $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        $honorbedah = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', 'Honor Dokter Bedah Mata')->get();

        $resep_obat = Resep::join('obat', 'resep.obat_uuid', '=', 'obat.uuid')
                            ->where('obat.jenis', '!=', 'Alkes')
                            ->where('resep.registrasi_uuid', '=', $uuid)
                            ->select(['resep.*'])
                            ->get();

        $resep_alkes = Resep::join('obat', 'resep.obat_uuid', '=', 'obat.uuid')
                            ->where('obat.jenis', '=', 'Alkes')
                            ->where('resep.registrasi_uuid', '=', $uuid)
                            ->select(['resep.*'])
                            ->get();

        $resepracikan = ResepRacikan::where('registrasi_uuid', '=', $uuid)->get();

        $groupping = LayananPasien::where('registrasi_uuid', '=', $uuid)->select('jenis')
                                            ->groupBy('jenis')
                                            ->where('jenis', '!=', 'Rawat Jalan')
                                            ->where('jenis', '!=', 'Administrasi')
                                            ->where('jenis', '!=', 'Honor')
                                            ->where('jenis', '!=', 'Honor Dokter Bedah Mata')
                                            ->where('jenis', '!=', 'Obat-Obatan')
                                            ->where('jenis', '!=', 'Obat-Obatan')
                                            ->where('jenis', '!=', 'Obat Racikan')
                                            ->get();
        $collection = new Collection();

        foreach ($groupping as $value) {
            $tmp = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('jenis', '=', $value->jenis)->get();

            if (count($tmp) > 0) {
                $collection->push((object) [
                    'data' => $tmp,
                ]);
            }
        }

        $surat_ke = 1;
        $cek = RincianTagihan::select('surat_ke')->orderBy('id', 'desc')->first();
        if ($cek) {
            $surat_ke += (int) $cek->surat_ke;
        }

        if ($surat_ke > 9999) {
            $surat_ke = 1;
        }

        $diskon = 0;

        $getdiskon = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        foreach ($getdiskon as $row) {
            if ($row->diskon_rp > 0) {
                $diskon += $row->diskon_rp;
            }

            if ($row->diskon_persen > 0) {
                $diskon_persen = (int) ($row->tarif * ($row->diskon_persen / 100));
                $diskon += $diskon_persen;
            }
        }

        $diskon_rp = 0;
        $diskon_persen = 0;
        $diskonobat = LayananPasien::where('registrasi_uuid', '=', $uuid)->where('layanan_uuid', '=', 'obatan')->first();

        if ($diskonobat) {
            $diskon_rp = $diskonobat->diskon_rp;
            $diskon_persen = $diskonobat->diskon_persen;
        }

        $item = new RincianTagihan();
        $item->uuid = Uuid::uuid4();
        $item->registrasi_uuid = $registrasi->uuid;
        $item->no_pendaftaran = $registrasi->no_pendaftaran;
        $item->registrasi_kode = $registrasi->kode;
        $item->registrasi_nomor = $registrasi->nomor;
        $item->registrasi_jenis = $registrasi->jenis;

        $item->pasien_uuid = $registrasi->pasien_uuid;
        $item->rekam_medis = $registrasi->rekam_medis;
        $item->nama_pasien = $registrasi->nama_pasien;
        $item->dokter_uuid = $registrasi->pengguna_uuid;
        $item->nama_dokter = $registrasi->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->surat_ke = $surat_ke;
        $item->save();

        $surat = RincianTagihan::select('surat_ke')->where('registrasi_uuid', '=', $registrasi->uuid)->orderBy('id', 'desc')->first();

        $pdf->loadView('print.printcashierrincian',
            compact('layananpasien', 'registrasi', 'collection', 'pasien', 'surat', 'honor', 'rawatjalan', 'bedah', 'administrasi', 'diskon', 'diskon_rp', 'diskon_persen',
                'resep_obat', 'room', 'resep_alkes', 'honorbedah', 'resepracikan', 'rawatinap', 'bedah', 'obatan', 'obatracikan'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function printbeli($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pasien = PasienBebas::where('uuid', '=', $uuid)->first();
        $resep = ResepBebas::where('pasienbebas_uuid', '=', $uuid)->get();
        // $resepracikan = ResepRacikanBebas::where('pasienbebas_uuid', '=', $uuid)->get();

        $resep_obat = ResepBebas::join('obat', 'resepbebas.obat_uuid', '=', 'obat.uuid')
                            ->where('obat.jenis', '!=', 'Alkes')
                            ->where('resepbebas.pasienbebas_uuid', '=', $uuid)->get();

        $resep_alkes = ResepBebas::join('obat', 'resepbebas.obat_uuid', '=', 'obat.uuid')
                            ->where('obat.jenis', '=', 'Alkes')
                            ->where('resepbebas.pasienbebas_uuid', '=', $uuid)->get();

        $resepracikan = ResepRacikanBebas::where('pasienbebas_uuid', '=', $uuid)->get();

        $rawatjalan = LayananPasien::where('pasien_uuid', '=', $uuid)->where('jenis', '=', 'Tindakan Obat Bebas')
                                ->select(
                                    'nama_layanan',
                                    'tarif',
                                    \DB::raw('count(nama_layanan) as jumlah_nama_layanan'),
                                    \DB::raw('sum(diskon_rp) as total_diskon_rp'),
                                    \DB::raw('sum(diskon_persen) as total_diskon_persen'),
                                    \DB::raw('sum(total) as total_total'),
                                    'created_at'
                                )
                ->groupBy('nama_layanan', 'tarif', 'created_at')
                                ->orderBy('nama_layanan', 'asc')
                                ->get();

        $surat_ke = 1;
        $cek = RincianTagihanBebas::select('surat_ke')->orderBy('id', 'desc')->first();
        if ($cek) {
            $surat_ke += (int) $cek->surat_ke;
        }

        if ($surat_ke > 9999) {
            $surat_ke = 1;
        }

        $item = new RincianTagihanBebas();
        $item->uuid = Uuid::uuid4();
        $item->pasienbebas_uuid = $pasien->uuid;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->surat_ke = $surat_ke;
        $item->save();

        $surat = RincianTagihanBebas::select('surat_ke')->where('pasienbebas_uuid', '=', $pasien->uuid)->orderBy('id', 'desc')->first();

        $pdf->loadView('print.printcashierbeli', compact('rawatjalan', 'pasien', 'surat', 'resep', 'resep_obat', 'resep_alkes',
            'resepracikan'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function panjar($uuid)
    {
        $pdf = \App::make('dompdf.wrapper');
        $registrasi = Registrasi::where('uuid', '=', $uuid)->first();
        // $layananpasien = LayananPasien::where('registrasi_uuid', '=', $uuid)->get();

        $pdf->loadView('print.printpanjar', compact('registrasi'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }
}
