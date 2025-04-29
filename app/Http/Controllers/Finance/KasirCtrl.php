<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Jobs\SendAllJob;
use App\Models\AntrianFarmasi;
use App\Models\AntrianKasir;
use App\Models\LayananPasien;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use App\Models\StockOpname;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class KasirCtrl extends Controller
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
            $data = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.' . $column, 'ilike', '%' . $search . '%')
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->orderBy('registrasi.no_kwitansi', 'desc')
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Kunjungan');
                    $q->orWhere('registrasi.status', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->select(['registrasi.*', 'pasien.sebutan as sebutan'])
                ->get();

            $total = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Kunjungan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->where('registrasi.' . $column, 'ilike', '%' . $search . '%')
                ->orderBy('registrasi.no_kwitansi', 'desc')->count();
        } else {
            $data = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->orderBy('registrasi.no_kwitansi', 'desc')
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Kunjungan');

                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.status', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->select(['registrasi.*', 'pasien.sebutan as sebutan'])
                ->get();

            $total = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');

                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.jenis', '=', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Kunjungan');

                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                    $q->orWhere('registrasi.status', 'Rawat Inap');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->orderBy('registrasi.no_kwitansi', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function listsudahbayar(Request $request)
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
            $data = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.' . $column, 'ilike', '%' . $search . '%')
                ->whereDate('registrasi.tanggal_bayar', '=', date('Y-m-d'))
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                })
                ->orderBy('registrasi.no_kwitansi', 'desc')
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Selesai');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->select(['registrasi.*', 'pasien.sebutan as sebutan'])
                ->get();
            $total = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->whereDate('registrasi.tanggal_bayar', '=', date('Y-m-d'))
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Selesai');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->where($column, 'ilike', '%' . $search . '%')
                ->orderBy('registrasi.no_kwitansi', 'desc')->count();
        } else {
            $data = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->orderBy('registrasi.no_kwitansi', 'desc')
                ->whereDate('registrasi.tanggal_bayar', '=', date('Y-m-d'))
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Selesai');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->select(['registrasi.*', 'pasien.sebutan as sebutan'])
                ->get();

            $total = Registrasi::join('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->whereDate('registrasi.tanggal_bayar', '=', date('Y-m-d'))
                ->where(function ($q) {
                    $q->where('registrasi.jenis', '=', 'Rawat Jalan');
                    $q->orWhere('registrasi.jenis', '=', 'One Day Care');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status', 'Selesai');
                })
                ->where(function ($q) {
                    $q->where('registrasi.status_dokter', '=', 'Sudah Diperiksa');
                })
                ->orderBy('registrasi.no_kwitansi', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function getpanjar(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();

        $panjar = 0;
        $keterangan = '';
        if ($data) {
            $panjar = $data->panjar;
            $keterangan = $data->keterangan_panjar;
        }

        return response()->json(['panjar' => $panjar, 'keterangan' => $keterangan]);
    }

    public function addpanjar(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $arr = [
            'panjar' => $request->panjar,
            'approve_panjar' => '1',
            'keterangan_panjar' => $request->keterangan,
            'tanggal_panjar' => date('Y-m-d'),
            'jam_panjar' => date('H:i:s'),
        ];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        return response()->json(['data' => 'berhasil']);
    }

    public function hapusbiaya(Request $request)
    {
        $cek = LayananPasien::where('uuid', '=', $request->uuid)->first();
        if ($cek && $cek->jenis == 'Obat-Obatan') {
            $remove = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
        }
        if ($cek && $cek->jenis == 'Obat Racikan') {
            $remove = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)->delete();
        }
        $remove = LayananPasien::where('uuid', '=', $request->uuid)->delete();

        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        $obat = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'obatracikan' => $obatracikan, 'layanan' => $layanan, 'obat' => $obat]);
    }

    public function perbaharuibiaya(Request $request)
    {
        $arr = ['tarif' => $request->tarif, 'total' => $request->total];
        $update = LayananPasien::where('uuid', '=', $request->uuid)->update($arr);

        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        $obat = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'obatracikan' => $obatracikan, 'layanan' => $layanan, 'obat' => $obat]);
    }

    public function bayar(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Menerima tagihan atas nama pasien ' . $data->nama_pasien . ' pada tanggal ' . date('Y-m-d'));
        }

        try {
            \DB::beginTransaction();

            $metode_pembayaran = $request->metode_pembayaran && $request->metode_pembayaran != '' ? $request->metode_pembayaran : '-';
            $arr = [
                'status_antrian_kasir' => '-',
                'kasir_jam_selesai' => date('H:i'),
                'status_kasir' => 'Sudah Bayar',
                'status' => 'Selesai',
                'tanggal_bayar' => date('Y-m-d'),
                'metode_pembayaran' => $metode_pembayaran,
                'diskon_persen' => $request->diskon_persen,
                'diskon_rp' => $request->diskon_rp,

            ];
            // var_dump( $request->diskon_rp);
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

            $tindakan = json_decode($request->tindakan);

            foreach ($tindakan as $row) {
                $item = LayananPasien::find($row->id);
                $item->layanan_uuid = $row->layanan_uuid;
                $item->nama_layanan = $row->nama_layanan;
                $item->tarif = $row->tarif;
                $item->diskon_rp = $row->diskon_rp;
                $item->diskon_persen = $row->diskon_persen;
                $item->total = $row->total;
                $item->save();
            }
            $arr = ['posisi' => 'Bayar'];
            $update = LayananPasien::where('registrasi_uuid', '=', $request->uuid)->update($arr);

            $arr = ['status' => 'Aktif'];
            $update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

            // Pengurangan qty obat
            $data = Resep::where('registrasi_uuid', '=', $request->uuid)->get();
            $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->get();

            foreach ($data as $row) {
                $cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $row->obat_uuid)->first();
                if ($cek) {
                    $hasil = $cek->jumlah_kecil - $row->jumlah_kecil;
                    $arr = ['jumlah_kecil' => $hasil];
                    $update = StockOpname::where('id', '=', $cek->id)->update($arr);
                }
            }

            foreach ($obatracikan as $row) {
                $informasi = json_decode($row->informasi);
                foreach ($informasi as $rowin) {
                    $cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $rowin->obat_uuid)->first();
                    if ($cek) {
                        $hasil = $cek->jumlah_kecil - $rowin->jumlah_kecil;
                        $arr = ['jumlah_kecil' => $hasil];
                        $update = StockOpname::where('id', '=', $cek->id)->update($arr);
                    }
                }
            }

            $arr = [
                'status' => 'Selesai',
            ];
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);


            $registrasi = Registrasi::where('uuid', '=', $request->uuid)->first();
            // Start Antrian Farmasi
            if ($registrasi->no_antrian_farmasi == null && (count($data) > 0 || count($obatracikan) > 0)) {
                // Create Antrian Farmasi
                $uuidFarmasi = '';
                $loop = false;
                do {
                    $uuidFarmasi = Uuid::uuid4();
                    $check = AntrianFarmasi::where('uuid', '=', $uuidFarmasi)->first();
                    if (!$check) {
                        $loop = true;
                    }
                } while ($loop == false);

                $latestAntrianRO = AntrianFarmasi::whereDate('tanggal', '=', date('Y-m-d'))->orderBy('id', 'desc')->first();

                $latestNumber = $latestAntrianRO->number ?? 0;
                $latestNumber = $latestNumber + 1;
                $kodeFarmasi = 'F-' . str_pad($latestNumber, 3, '0', STR_PAD_LEFT);

                $antrianFarmasi = new AntrianFarmasi();
                $antrianFarmasi->uuid = $uuidFarmasi;
                $antrianFarmasi->kode = 'F';
                $antrianFarmasi->number = $latestNumber;
                $antrianFarmasi->jenis = $registrasi->jenis;
                $antrianFarmasi->tanggal = date('Y-m-d');

                // BPJS
                $antrianFarmasi->kode_poli =  $registrasi->kode_poli_bpjs;
                $antrianFarmasi->poli =  $registrasi->nama_poli_bpjs;
                $antrianFarmasi->uuid_pasien =  $registrasi->pasien_uuid;
                $antrianFarmasi->kode_dokter =  $registrasi->kode_dokter_bpjs;
                $antrianFarmasi->uuid_registrasi =  $registrasi->uuid;

                $antrianFarmasi->save();

                Registrasi::where('uuid', $registrasi->uuid)
                    ->update(['no_antrian_farmasi' => $kodeFarmasi]);
            }
            // End Antrian Farmasi

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function cancelbayar(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            \PenggunaHelp::log('Membatalkan pembayaran atas nama pasien ' . $data->nama_pasien . ' pada tanggal ' . date('Y-m-d'));
        }

        $arr = [
            'status_antrian_kasir' => '-',
            'kasir_jam_selesai' => '-',
            'status_kasir' => 'Belum Bayar',
            'status' => 'Kunjungan',
            'tanggal_bayar' => '1990-01-01',
            'metode_pembayaran' => '-',
        ];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        $arr = ['posisi' => 'menunggu'];
        $update = LayananPasien::where('registrasi_uuid', '=', $request->uuid)->update($arr);

        $arr = ['status' => 'Kunjungan'];
        $update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

        // Pengurangan qty obat
        $data = Resep::where('registrasi_uuid', '=', $request->uuid)->get();
        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->get();

        foreach ($data as $row) {
            $cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $row->obat_uuid)->first();
            if ($cek) {
                $hasil = $cek->jumlah_kecil + $row->jumlah_kecil;
                $arr = ['jumlah_kecil' => $hasil];
                $update = StockOpname::where('id', '=', $cek->id)->update($arr);
            }
        }

        foreach ($obatracikan as $row) {
            $informasi = json_decode($row->informasi);
            foreach ($informasi as $rowin) {
                $cek = StockOpname::where('nama_unit', '=', 'Apotek')->where('obat_uuid', '=', $rowin->obat_uuid)->first();
                if ($cek) {
                    $hasil = $cek->jumlah_kecil + $rowin->jumlah_kecil;
                    $arr = ['jumlah_kecil' => $hasil];
                    $update = StockOpname::where('id', '=', $cek->id)->update($arr);
                }
            }
        }

        return response()->json(['data' => 'berhasil']);
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

        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->get();

        $obat = Resep::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
            ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $data, 'obatracikan' => $obatracikan, 'layanan' => $layanan, 'obat' => $obat]);
    }

    public function call(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $arr = ['status_antrian_kasir' => '-', 'last_position' => 'Kasir'];
        $cek = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->update($arr);

        $arr = ['status_antrian_kasir' => 'active', 'kasir_jam_layani' => date('H:i')];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        $get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('number', '=', $request->number)
            ->where('pemanggil', '=', '1')
            ->first();

        $arr = array('panggil' => 1);
        $update = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('number', '=', $request->number)->update($arr);

        if ($get) {
            $str = 'Kasir 1=' . $request->number;
            $this->jeda(1, $str);

            return response()->json(['data' => 'berhasil']);
        }

        $get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('number', '=', $request->number)->first();
        if ($get) {
            if ($get->pemanggil != '-') {
                return response()->json(['data' => 'cannot']);
            }
        }

        $get = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('pemanggil', '=', '1')
            ->first();

        if ($get) {
            $arr = ['pemanggil' => '-'];
            $update = AntrianKasir::where('uuid', '=', $get->uuid)->update($arr);
        }

        $arr = ['pemanggil' => '1'];
        $panggil = AntrianKasir::whereDate('tanggal', '=', date('Y-m-d'))->where('number', '=', $request->number)->update($arr);

        $str = 'Kasir 1=' . $request->number;
        $this->jeda(1, $str);

        return response()->json(['data' => 'berhasil']);
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
            \PenggunaHelp::log('Mengambil data icd 9 dengan nama "' . $data->nama_pasien);
        }

        $arr = ['approve_panjar' => '1'];
        $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

        return response()->json(['data' => 'berhasil']);
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
                ->where($column, 'ilike', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->where('panjar', '!=', '0')
                ->where('status', '=', 'Pending')
                ->where(function ($q) {
                    $q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
                        ->orWhere('status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->get();
            $total = Registrasi::where('delete_soft', '=', 1)
                ->where('status', '=', 'Pending')
                ->where('panjar', '!=', '0')
                ->where(function ($q) {
                    $q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
                        ->orWhere('status_dokter', '=', 'Sudah Diperiksa');
                })
                ->where($column, 'ilike', '%' . $search . '%')
                ->orderBy('id', 'desc')->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->orderBy('id', 'desc')
                ->where('status', '=', 'Pending')
                ->where('panjar', '!=', '0')
                ->where(function ($q) {
                    $q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
                        ->orWhere('status_dokter', '=', 'Sudah Diperiksa');
                })
                ->skip($skip)->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                ->where('status', '=', 'Pending')
                ->where('panjar', '!=', '0')
                ->where(function ($q) {
                    $q->where('status_dokter', '=', 'Sudah Diperiksa (Pending)')
                        ->orWhere('status_dokter', '=', 'Sudah Diperiksa');
                })
                ->orderBy('id', 'desc')->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }
}
