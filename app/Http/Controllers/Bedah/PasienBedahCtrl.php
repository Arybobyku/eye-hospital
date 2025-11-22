<?php

namespace App\Http\Controllers\Bedah;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Bedah;
use App\Models\CaraBayarKamar;
use App\Models\JadwalKontrol;
use App\Models\KamarInap;
use App\Models\LayananPasien;
use App\Models\ListPaketBedahBaru;
use App\Models\PaketBedah;
use App\Models\Pasien;
use App\Models\Registrasi;
use App\Models\RegistrasiOperasi;
use App\Models\Resep;
use App\Models\ResepRacikan;
use Illuminate\Http\Request;
use PenggunaHelp;
use Ramsey\Uuid\Uuid;
use App\Models\LogPengguna;
use Crypt;
use Cookie;


class PasienBedahCtrl extends Controller
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
        $namaDokter = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));
        $sebagai = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Sebagai'));

        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman data unit');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $column = $request->column;

        if ($request->search != '') {
            $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.'.$column, 'ilike', '%'.$search.'%')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->Where('registrasi.nama_paket_bedah', '!=', '')
                ->Where('registrasi.nama_paket_bedah', '!=', null);


                if ($sebagai == 'Dokter') {
                    $data = $data->where('registrasi_operasi.nama_dokter', $namaDokter);
                }
                
                $data = $data->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();
            $total = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.'.$column, 'ilike', '%'.$search.'%')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->Where('registrasi.paket_bedah_uuid', '!=', '')->Where('registrasi.paket_bedah_uuid', '!=', null);
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->Where('registrasi.nama_paket_bedah', '!=', '')
                ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->count();
        } else {
            $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->Where('registrasi.paket_bedah_uuid', '!=', '')->Where('registrasi.paket_bedah_uuid', '!=', null);
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->Where('registrasi.nama_paket_bedah', '!=', '')
                ->Where('registrasi.nama_paket_bedah', '!=', null);

                if ($sebagai == 'Dokter') {
                    $data = $data->where('registrasi_operasi.nama_dokter', $namaDokter);
                }
                
                $data = $data->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();

            $total = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->Where('registrasi.nama_paket_bedah', '!=', '')
                ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function listselesai(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman data unit');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $column = $request->column;

        if ($request->search != '') {
            $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.'.$column, 'ilike', '%'.$search.'%')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })->where('registrasi.nama_paket_bedah', '!=', '-')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', '')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();
            $total = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.'.$column, 'ilike', '%'.$search.'%')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })->where('registrasi.nama_paket_bedah', '!=', '-')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', '')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->count();
        } else {
            $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })->where('registrasi.nama_paket_bedah', '!=', '-')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', '')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();
            $total = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                // ->whereDate('bedah_selesai', '=', date('Y-m-d'))
                ->where('bedah_status', '==', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')->orWhere('registrasi.paket_bedah_uuid', '!=', '')->orWhere('registrasi.paket_bedah_uuid', '!=', null);
                })->where('registrasi.nama_paket_bedah', '!=', '-')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', '')
                                                                      ->Where('registrasi.nama_paket_bedah', '!=', null)
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->orderBy('registrasi.id', 'desc')
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function listhistori(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman data unit');

        $list = '';
        $total = '';
        $page = $request->page - 1;
        $skip = $page * $this->take;
        $search = $request->search;
        $column = $request->column;

        if ($request->search != '') {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->where($column, 'ilike', '%'.$search.'%')
                ->where('apakah_paket', '=', 'Ya')
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('status', '=', 'Selesai');
                })
                ->whereDate('bedah_selesai', '!=', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();
            $total = Registrasi::where('delete_soft', '=', 1)
                ->where($column, 'ilike', '%'.$search.'%')
                ->where('apakah_paket', '=', 'Ya')
                ->whereDate('bedah_selesai', '!=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('status', '=', 'Selesai');
                })
                ->orderBy('id', 'desc')
                ->count();
        } else {
            $data = Registrasi::where('delete_soft', '=', 1)
                ->where('apakah_paket', '=', 'Ya')
                ->whereDate('bedah_selesai', '!=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('status', '=', 'Selesai');
                })
                ->orderBy('id', 'desc')
                ->skip($skip)
                ->take($this->take)
                ->get();

            $total = Registrasi::where('delete_soft', '=', 1)
                ->where('apakah_paket', '=', 'Ya')
                ->whereDate('bedah_selesai', '!=', date('Y-m-d'))
                ->where('bedah_status', '=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('status', '=', 'Selesai');
                })
                ->orderBy('id', 'desc')
                ->count();
        }

        return response()->json(['data' => $data, 'total' => $total]);
    }

    public function proses(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            // PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
        }

        $arr = ['bedah_status' => 'Sedang Dioperasi', 'bedah_mulai' => date('Y-m-d H:i:s')];

        try {
            \DB::beginTransaction();

            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function selesai(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        if ($data) {
            // PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
        }

        $arr = ['bedah_status' => 'Selesai Dioperasi', 'bedah_selesai' => date('Y-m-d H:i:s')];

        try {
            \DB::beginTransaction();

            $registrasi = Registrasi::where('uuid', '=', $data->uuid)->update($arr);

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
        $paket = PaketBedah::where('uuid', '=', $data->paket_bedah_uuid)->first();
        $list_paket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $data->paket_bedah_uuid)->get();

        return response()->json(['paket' => $paket, 'list_paket' => $list_paket]);
    }

    public function inap(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();

        return response()->json(['data' => $data]);
    }

    public function detaildokter(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $reqgOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->first();
        if ($reqgOp) {
            $dokter = $reqgOp->nama_dokter;
        }

        return response()->json(['data' => $data, 'nama_dokter' => $dokter]);
    }

    public function editbedah(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $reqgOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->first();
        if ($reqgOp) {
            $namaPaketBedah = $reqgOp->nama_layanan;
        }

        return response()->json(['data' => $data, 'data_operasi' => $reqgOp, 'namaPaketBedah' => $namaPaketBedah, ]);
    }

    public function dokteradd(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        // Registrasi::where('registrasi_uuid_old', '=', $request->uuid)->delete();

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        echo $request->uuid;

        if ($data) {
            // PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
        }

        // $arr = ['posisi' => 'Selesai', 'tanggal_pendaftaran' => date('Y-m-d'), 'jam_pendaftaran_pasien' => date('H:i')];

        try {
            \DB::beginTransaction();

            $arr = [
                'nama_dokter' => $request->nama_dokter,
                'pengguna_uuid' => $request->uuid_dokter,
            ];
            RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->update($arr);
            LayananPasien::where('registrasi_uuid', '=', $request->uuid)
                ->where('is_paket_bedah', 1)
                ->update($arr);

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }
    public function bedahadd(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        echo $request->uuid;

        if ($data) {
        }


        try {
            DB::beginTransaction();

            $arrRegOp = [
                'nama_layanan' => $request->paketbedah,
                'layanan_uuid' => $request->layanan_uuid,
            ];
            $arrReg = [
                'nama_paket_bedah' => $request->paketbedah,
                'paket_bedah_uuid' => $request->layanan_uuid,
            ];
            $reg = Registrasi::where('uuid', '=', $request->uuid)->first();
            $regOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->first();
            // var_dump($request->uuid);
            // die();
            RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->update($arrRegOp); 
            Registrasi::where('uuid', '=', $request->uuid)->update($arrReg); 
            LayananPasien::where('registrasi_uuid', '=', $request->uuid)->where('is_paket_bedah', 1)->delete();

            $listpaket = ListPaketBedahBaru::where('paket_bedah_uuid', '=', $request->layanan_uuid)->get();
                    // UNTUK MASUKAN DETAIL PAKET KE TAGIHAN
            foreach ($listpaket as $row) {
                    $item = new LayananPasien();
                    $item->uuid = Uuid::uuid4();
                    $item->registrasi_uuid = $request->uuid;
                    $item->registrasi_kode = $reg->kode;
                    $item->registrasi_nomor = $reg->nomor;
                    $item->registrasi_jenis = $reg->jenis;
                    $item->pasien_uuid = $reg->pasien_uuid;
                    $item->rekam_medis = $reg->rekam_medis;
                    $item->nama_pasien = $reg->nama_pasien;
                    $item->pengguna_uuid = $regOp->pengguna_uuid;
                    $item->nama_dokter = $regOp->nama_dokter;
                    
                    $item->tanggal = date('Y-m-d');
                    $item->waktu = date('H:i');
                    
                    $item->is_paket_bedah = 1;
                    $item->carabayar_uuid = $regOp->carabayar_uuid;
                    $item->carabayar_nama = $regOp->carabayar_nama;
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
                    $item->no_pendaftaran = $reg->no_pendaftaran;
                    
                }
            DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function inapadd(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        // Registrasi::where('registrasi_uuid_old', '=', $request->uuid)->delete();

        $data = Registrasi::where('uuid', '=', $request->uuid)->first();

        if ($data) {
            // PenggunaHelp::log('Menghapus data unit dengan nama "'.$data->nama.'" dan id "'.$data->id.'".');
        }

        // $arr = ['posisi' => 'Selesai', 'tanggal_pendaftaran' => date('Y-m-d'), 'jam_pendaftaran_pasien' => date('H:i')];

        try {
            \DB::beginTransaction();
            $kamar = CaraBayarKamar::where('jenis_kamar_uuid', '=', $request->jenis_kamar_uuid)
                ->where('carabayar_uuid', '=', $data->carabayar_uuid)
                ->select('harga')
                ->first();
            $harga_kamar = 0;
            if ($kamar) {
                $harga_kamar = $kamar->harga;
            }
            echo 'jenis kamar uuid';
            echo $request->jenis_kamar_uuid;
            echo 'tanggal masuk inap';

            echo $request->tanggal_masuk_inap;
            echo 'kamar';

            echo $kamar;
            echo $harga_kamar;
            // $remove = RegistrasiOperasi::where('uuid', '=', $request->uuid)->update($arr);

            // Disini letak pendaftaran baru ubah mode register dari odc ke inap
            $registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_gelang', '!=', '-')->orderBy('id', 'desc')->first();
            $nomor = 1;
            if ($registrasi) {
                $potong_kalimat = substr($registrasi->no_gelang, -5);
                $potong_kalimat = (int) $potong_kalimat;
                $nomor += $potong_kalimat;
            }

            if ($nomor < 9) {
                $nomor = '0000'.$nomor;
            } elseif ($nomor > 9 && $nomor < 100) {
                $nomor = '000'.$nomor;
            } elseif ($nomor > 99 && $nomor < 1000) {
                $nomor = '00'.$nomor;
            } elseif ($nomor > 999 && $nomor < 10000) {
                $nomor = '0'.$nomor;
            }

            $nomor = date('Y').date('m').date('d').$nomor;
            $arr = [
                'kode' => 'RI',
                'jenis' => 'Rawat Inap',
                'masuk_kamar' => 'ya',
                'no_gelang' => $nomor,
                'inap_jalan' => 'Rawat Inap Jalan Asuransi',
                'status_dokter' => 'Sudah Diperiksa',
                'tanggal_masuk_inap' => $request->tanggal_masuk_inap,
                'waktu_masuk_inap' => $request->waktu_masuk_inap,
                'kamar_inap_uuid' => $request->kamar_inap_uuid,
                'kamar_inap_nama' => $request->kamar_inap_nama,
                'kamar_inap_lantai' => $request->kamar_inap_lantai,
                'kamar_inap_jumlah_bed' => $request->kamar_inap_jumlah_bed,
                'jenis_kamar_uuid' => $request->jenis_kamar_uuid,
                'nama_jenis_kamar' => $request->nama_jenis_kamar,
                'harga_kamar' => $harga_kamar,
                'status' => 'Rawat Inap',
            ];
            $update = Registrasi::where('uuid', '=', $request->uuid)->update($arr);
            $cekkamar = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->first();
            $arrKamar = ['sisa' => (int) $cekkamar->sisa - 1];
            $update = KamarInap::where('uuid', '=', $request->kamar_inap_uuid)->update($arrKamar);
            $remove = LayananPasien::where('registrasi_uuid', '=', $data->uuid)
                ->where('jenis', '=', 'Kamar Inap')
                ->delete();
            $item = new LayananPasien();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $data->uuid;
            $item->no_pendaftaran = $data->no_pendaftaran;
            $item->registrasi_kode = $data->kode;
            $item->registrasi_nomor = $data->nomor;
            $item->registrasi_jenis = $data->jenis;
            $item->pasien_uuid = $data->pasien_uuid;
            $item->rekam_medis = $data->rekam_medis;
            $item->nama_pasien = $data->nama_pasien;
            $item->pengguna_uuid = $data->pengguna_uuid;
            $item->nama_dokter = $data->nama_dokter;

            $item->tanggal = date('Y-m-d');
            $item->waktu = date('H:i');

            $item->carabayar_uuid = $data->carabayar_uuid;
            $item->carabayar_nama = $data->carabayar_nama;

            $item->layanan_uuid = $request->jenis_kamar_uuid;
            $item->nama_layanan = $request->nama_jenis_kamar;
            $item->tarif = $harga_kamar;
            $item->total = $harga_kamar;
            $item->jenis = 'Kamar Inap';
            $item->save();
            // $registrasi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->select('nomor')->first();

            // $nomor = 1;
            // if ($registrasi) {
            //     $potong_kalimat = substr($registrasi->nomor, -5);
            //     $potong_kalimat = (int) $potong_kalimat;
            //     $nomor += $potong_kalimat;
            // }

            // if ($nomor < 9) {
            //     $nomor = '0000'.$nomor;
            // } elseif ($nomor > 9 && $nomor < 100) {
            //     $nomor = '000'.$nomor;
            // } elseif ($nomor > 99 && $nomor < 1000) {
            //     $nomor = '00'.$nomor;
            // } elseif ($nomor > 999 && $nomor < 10000) {
            //     $nomor = '0'.$nomor;
            // }

            // $nomor = date('Y').date('m').date('d').$nomor;
            // $nomor_bedah = $nomor;
            // $uuid = Uuid::uuid4();
            // $uuid_bedah = $uuid;

            // $item = new Registrasi();
            // $item->uuid = $uuid;
            // $item->kode = 'RI';
            // $item->nomor = $nomor;
            // $item->jenis = 'Rawat Inap';
            // $item->jalur_masuk = 'Rawat Jalan';
            // $item->harga_kamar = $harga_kamar;
            // $item->nama_jenis_kamar = $request->nama_jenis_jalan_kamar;
            // $item->jenis_kamar_uuid = $request->jenis_kamar_jalan_uuid;
            // $item->kamar_inap_jumlah_bed = $request->kamar_inap_jumlah_bed;
            // $item->kamar_inap_lantai = $request->kamar_inap_lantai;
            // $item->kamar_inap_nama = $request->kamar_inap_nama;
            // $item->kamar_inap_uuid = $request->kamar_inap_uuid;
            // $item->status_dokter = $request->kamar_inap_uuid;

            // $item->pasien_uuid = $data->pasien_uuid;
            // $item->rekam_medis = $data->rekam_medis;
            // $item->nama_pasien = $data->nama_pasien;

            // $item->pengguna_uuid = $data->pengguna_uuid;
            // $item->nama_dokter = $data->nama_dokter;
            // $item->carabayar_uuid = $data->carabayar_uuid;
            // $item->carabayar_nama = $data->carabayar_nama;
            // $item->asuransi_uuid = $data->asuransi_uuid;
            // $item->nama_asuransi = $data->nama_asuransi;

            // $reg = Registrasi::where('uuid', '=', $data->registrasi_uuid)->first();
            // $item->photos = $data->photos;
            // $item->cara_masuk = $data->cara_masuk;
            // $item->rujukan = $data->rujukan;

            // $item->tanggal_lahir = $data->tanggal_lahir;
            // $item->jenis_identitas = $data->jenis_identitas;
            // $item->no_identitas = $data->no_identitas;
            // $item->jenis_kelamin = $data->jenis_kelamin;
            // $item->no_handphone = $data->no_handphone;
            // $item->agama = $data->agama;

            // $item->tanggal = date('Y-m-d');
            // $item->waktu = date('H:i');
            // $item->no_pendaftaran = '-';
            // $item->status = 'Rawat Inap';
            // $item->apakah_paket = 'Ya';

            // $status_penjamin = '-';
            // $is_approve = '-';
            // $is_pay = '-';
            // $is_asuransi = '-';
            // if ($data->carabayar_nama != 'Umum' && $data->carabayar_nama != 'BPJS Kesehatan') {
            //     $status_penjamin = 'disetujui';
            //     $is_approve = 'ya';
            //     $is_pay = 'tidak';
            //     $is_asuransi = 'ya';
            // }

            // if ($data->carabayar_nama == 'Umum' || $data->carabayar_nama == 'BPJS Kesehatan') {
            //     $status_penjamin = 'disetujui';
            //     $is_approve = 'ya';
            //     $is_pay = 'tidak';
            //     $is_asuransi = 'tidak';
            // }
            // $item->status_penjamin = $status_penjamin;
            // $item->is_approve = $is_approve;
            // $item->is_pay = $is_pay;
            // $item->is_asuransi = $is_asuransi;
            // $item->last_position = 'Pendaftaran';
            // $item->jenis_pasien = 'Rawat Inap';

            // $kwitansi = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_kwitansi', '!=', '-')->orderBy('id', 'desc')->first();
            // $no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').'00001';
            // $nomor_i = 1;
            // if ($kwitansi) {
            //     $potong_kalimat = substr($kwitansi->no_invoice, -5);
            //     $potong_kalimat = (int) $potong_kalimat;
            //     $nomor_i += $potong_kalimat;
            // }
            // if ($nomor_i < 9) {
            //     $nomor_i = '0000'.$nomor_i;
            // } elseif ($nomor_i > 9 && $nomor_i < 100) {
            //     $nomor_i = '000'.$nomor_i;
            // } elseif ($nomor_i > 99 && $nomor_i < 1000) {
            //     $nomor_i = '00'.$nomor_i;
            // } elseif ($nomor_i > 999 && $nomor_i < 10000) {
            //     $nomor_i = '0'.$nomor_i;
            // }
            // $no_kwitansi = 'RM/RSKMPV/8875/'.date('Ymd').$nomor_i;

            // $invoice = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_invoice', '!=', '-')->orderBy('id', 'desc')->first();
            // $no_invoice = date('Ymd').'00001';
            // $nomor_i = 1;
            // if ($invoice) {
            //     $potong_kalimat = substr($invoice->no_invoice, -5);
            //     $potong_kalimat = (int) $potong_kalimat;
            //     $nomor_i += $potong_kalimat;
            // }
            // if ($nomor_i < 9) {
            //     $nomor_i = '0000'.$nomor_i;
            // } elseif ($nomor_i > 9 && $nomor_i < 100) {
            //     $nomor_i = '000'.$nomor_i;
            // } elseif ($nomor_i > 99 && $nomor_i < 1000) {
            //     $nomor_i = '00'.$nomor_i;
            // } elseif ($nomor_i > 999 && $nomor_i < 10000) {
            //     $nomor_i = '0'.$nomor_i;
            // }
            // $no_invoice = date('Ymd').$nomor_i;

            // $resep = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))->where('no_resep', '!=', '-')->orderBy('id', 'desc')->first();
            // $no_resep = date('Ymd').'00001';
            // $nomor_r = 1;
            // if ($resep) {
            //     $potong_kalimat = substr($resep->no_resep, -5);
            //     $potong_kalimat = (int) $potong_kalimat;
            //     $nomor_r += $potong_kalimat;
            // }
            // if ($nomor_r < 9) {
            //     $nomor_r = '0000'.$nomor_r;
            // } elseif ($nomor_r > 9 && $nomor_r < 100) {
            //     $nomor_r = '000'.$nomor_r;
            // } elseif ($nomor_r > 99 && $nomor_r < 1000) {
            //     $nomor_r = '00'.$nomor_r;
            // } elseif ($nomor_r > 999 && $nomor_r < 10000) {
            //     $nomor_r = '0'.$nomor_r;
            // }
            // $no_resep = date('Ymd').$nomor_r;

            // $item->no_invoice = $no_kwitansi;
            // $item->no_kwitansi = $no_invoice;
            // $item->no_resep = $no_resep;

            // $item->registrasi_uuid_old = $data->uuid;
            // $item->kode_old = $data->registrasi_kode;
            // $item->nomor_old = $data->registrasi_nomor;
            // $item->jenis_old = $data->registrasi_jenis;
            // $item->save();

            $arr = ['status' => 'Rawat Inap'];
            $update = Pasien::where('uuid', '=', $data->pasien_uuid)->update($arr);

            \DB::commit();

            return response()->json(['data' => 'berhasil']);
        } catch (Exception $e) {
            \DB::rollback();

            return response()->json(['hasil' => 'gagal']);
        }
    }

    public function getlayanan(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('layanan_uuid', '!=', 'obatan')
            ->where('jenis', '=', $request->jenis)
            ->get();

        return response()->json(['data' => $data, 'layanan' => $layanan]);
    }

    public function getresep(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();

        $obat = Resep::where('registrasi_uuid', '=', $request->uuid)
            // ->where('jenis', '=', $request->jenis)
            ->where('is_bedah', '=', 1)
            ->orderBy('id', 'desc')
            ->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
            ->where('is_bedah', '=', 1)
            ->orderBy('id', 'desc')
            ->get();

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
        $item->nama_dokter = $reg->nama_dokter;

        $item->tanggal = date('Y-m-d');
        $item->waktu = date('H:i');

        $item->carabayar_uuid = $reg->carabayar_uuid;
        $item->carabayar_nama = $reg->carabayar_nama;

        $item->layanan_uuid = $request->layanan_uuid;
        $item->nama_layanan = $request->nama_layanan;
        $item->tarif = $request->tarif;
        $item->total = $request->tarif;
        $item->jenis = $request->jenis;
        $item->save();

        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();

        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('layanan_uuid', '!=', 'obatan')
            ->where('jenis', '=', $request->jenis)
            ->get();

        return response()->json(['data' => $data, 'layanan' => $layanan]);
    }

    public function remove(Request $request)
    {
        $remove = LayananPasien::where('uuid', '=', $request->uuid)->delete();

        $data = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('layanan_uuid', '!=', 'obatan')
            ->where('jenis', '=', $request->jenis)
            ->get();

        return response()->json(['data' => $data, 'layanan' => $layanan]);
    }

    public function getobat(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        // echo 'uuid';
        // echo $request->registrasi_uuid;
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $obatbedah = Resep::where('registrasi_uuid', '=', $request->uuid)
            ->where('jenis', '=', $request->jenis)
            ->orderBy('id', 'desc')
            ->get();

        $obatracikan = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)
            ->where('jenis', '=', $request->jenis)
            ->orderBy('id', 'desc')
            ->get();

        // return response()->json(['data' => $data]);
        return response()->json(['data' => $data, 'obatbedah' => $obatbedah, 'obatracikan' => $obatracikan]);
    }

    public function addobat(Request $request)
    {
        $reg = Registrasi::where('uuid', '=', $request->uuid)->first();
        echo 'req uuid php';
        echo $request->uuid;
        echo $request->registrasi_uuid;
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
        $item->jenis = $request->jenis.' (Obatan)';
        $item->save();

        $tarif = (int) $request->hja_resep * (int) $request->jumlah_kecil;

        $ceklayanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('nama_layanan', '=', 'Obat-Obatan '.$request->jenis)
            ->where('jenis', '=', $request->jenis)
            ->first();

        if ($ceklayanan) {
            $tarif += $ceklayanan->tarif;
            $arr = ['tarif' => $tarif, 'total' => $tarif];
            $update = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                ->where('nama_layanan', '=', 'Obat-Obatan '.$request->jenis)
                ->where('jenis', '=', $request->jenis)
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
            $item->nama_layanan = 'Obat-Obatan '.$request->jenis;
            $item->tarif = $tarif;
            $item->total = $tarif;
            $item->jenis = $request->jenis;
            $item->save();
        }

        $arr = ['ada_obat' => 'Ya'];
        $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);

        $data = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('jenis', '=', $request->jenis.' (Obatan)')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function removeobat(Request $request)
    {
        $resep = Resep::where('uuid', '=', $request->uuid)->first();

        $tarif = (int) $resep->hja_resep * (int) $resep->jumlah_kecil;

        $ceklayanan = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('nama_layanan', '=', 'Obat-Obatan '.$request->jenis)
            ->where('jenis', '=', $request->jenis)
            ->first();

        if ($ceklayanan) {
            $sisa = $ceklayanan->tarif - $tarif;

            if ($sisa < 1) {
                $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                    ->where('nama_layanan', '=', 'Obat-Obatan '.$request->jenis)
                    ->where('jenis', '=', $request->jenis)
                    ->delete();
            } else {
                $arr = ['tarif' => $sisa, 'total' => $sisa];
                $update = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid)
                    ->where('nama_layanan', '=', 'Obat-Obatan '.$request->jenis)
                    ->where('jenis', '=', $request->jenis)
                    ->update($arr);
            }
        }
        $remove = Resep::where('uuid', '=', $request->registrasi_uuid)->delete();

        $data = Resep::where('registrasi_uuid', '=', $request->registrasi_uuid)
            ->where('jenis', '=', $request->jenis.' (Obatan)')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function addresep(Request $request)
    {
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $dataOp = RegistrasiOperasi::where('registrasi_uuid', '=', $request->uuid)->first();
        Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->delete();
        $obat = json_decode($request->obat);

        if (count($obat) > 0) {
            $nama_layanan = 'Obat-obatan Pasca Bedah';
            $tarif = 0;

            foreach ($obat as $row) {
                $item = new Resep();
                $item->uuid = Uuid::uuid4();
                $item->registrasi_uuid = $request->uuid;
                $item->no_pendaftaran = $data->no_pendaftaran;
                $item->registrasi_kode = $data->kode;
                $item->registrasi_nomor = $data->nomor;
                $item->registrasi_jenis = $data->jenis;
                $item->pasien_uuid = $data->pasien_uuid;
                $item->rekam_medis = $data->rekam_medis;
                $item->nama_pasien = $data->nama_pasien;
                $item->dokter_uuid = $dataOp->pengguna_uuid;
                $item->nama_dokter = $dataOp->nama_dokter;

                $item->tanggal =  $row->tanggal ??  date('Y-m-d');
                $item->waktu =  $row->waktu ?? date('H:i');

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
                $item->is_bedah = 1;
                $item->save();

                $hasil = (int) $row->hja_resep * (int) $row->jumlah_kecil;
                $tarif += $hasil;
            }
            LayananPasien::where('registrasi_uuid', '=', $request->uuid)->where('layanan_uuid', '=', 'obatanbedah')->delete();

            $item = new LayananPasien();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $request->uuid;
            $item->no_pendaftaran = $data->no_pendaftaran;
            $item->registrasi_kode = $data->kode;
            $item->registrasi_nomor = $data->nomor;
            $item->registrasi_jenis = $data->jenis;
            $item->pasien_uuid = $data->pasien_uuid;
            $item->rekam_medis = $data->rekam_medis;
            $item->nama_pasien = $data->nama_pasien;
            $item->pengguna_uuid = $dataOp->pengguna_uuid;
            $item->nama_dokter = $dataOp->nama_dokter;

            $item->tanggal = date('Y-m-d');
            $item->waktu = date('H:i');

            $item->carabayar_uuid = $data->carabayar_uuid;
            $item->carabayar_nama = $data->carabayar_nama;

            $item->layanan_uuid = 'obatanbedah';
            $item->nama_layanan = $nama_layanan;
            $item->tarif = $tarif;
            $item->total = $tarif;
            $item->jenis = 'Obat-Obatan Pasca Bedah';
            $item->default = 'Tidak';
            $item->save();
        } else {
            $cek = Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->get();

            if (count($cek) > 1) {
                Resep::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->delete();
            }
        }

        // Bagian untuk obat obatracikan
        ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->delete();
        $obatracikan = json_decode($request->obatracikan);

        if (count($obatracikan) > 0) {
            $nama_layanan = 'Obat Racikan Pasca Bedah';
            $tarif = 0;

            foreach ($obatracikan as $row) {
                $item = new ResepRacikan();
                $item->uuid = Uuid::uuid4();
                $item->registrasi_uuid = $request->uuid;
                $item->no_pendaftaran = $data->no_pendaftaran;
                $item->registrasi_kode = $data->kode;
                $item->registrasi_nomor = $data->nomor;
                $item->registrasi_jenis = $data->jenis;
                $item->pasien_uuid = $data->pasien_uuid;
                $item->rekam_medis = $data->rekam_medis;
                $item->nama_pasien = $data->nama_pasien;
                $item->dokter_uuid = $dataOp->pengguna_uuid;
                $item->nama_dokter = $dataOp->nama_dokter;

                $item->tanggal =  $row->tanggal ??  date('Y-m-d');
                $item->waktu =  $row->waktu ?? date('H:i');

                $item->label = $row->label;
                $item->kemasan = $row->kemasan;
                $item->jumlah = $row->jumlah;
                $item->signa = $row->signa;
                $item->total = $row->total;
                $item->informasi = $row->informasi;
                $item->is_bedah = 1;
                $item->save();

                $tarif += $row->total;
            }
            LayananPasien::where('registrasi_uuid', '=', $request->uuid)->where('layanan_uuid', '=', 'obatracikanbedah')->delete();

            $item = new LayananPasien();
            $item->uuid = Uuid::uuid4();
            $item->registrasi_uuid = $request->uuid;
            $item->no_pendaftaran = $data->no_pendaftaran;
            $item->registrasi_kode = $data->kode;
            $item->registrasi_nomor = $data->nomor;
            $item->registrasi_jenis = $data->jenis;
            $item->pasien_uuid = $data->pasien_uuid;
            $item->rekam_medis = $data->rekam_medis;
            $item->nama_pasien = $data->nama_pasien;
            $item->pengguna_uuid = $dataOp->pengguna_uuid;
            $item->nama_dokter = $dataOp->nama_dokter;

            $item->tanggal = date('Y-m-d');
            $item->waktu = date('H:i');

            $item->carabayar_uuid = $dataOp->carabayar_uuid;
            $item->carabayar_nama = $dataOp->carabayar_nama;

            $item->layanan_uuid = 'obatracikanbedah';
            $item->nama_layanan = $nama_layanan;
            $item->tarif = $tarif;
            $item->total = $tarif;
            $item->jenis = 'Obat Racikan Pasca Bedah';
            $item->default = 'Tidak';
            $item->save();
        } else {
            $cek = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->get();

            if (count($cek) > 1) {
                $remove = ResepRacikan::where('registrasi_uuid', '=', $request->uuid)->where('is_bedah', 1)->delete();
            }
        }

        if (count($obat) > 0 || count($obatracikan) > 0) {
            $cek = Registrasi::where('uuid', '=', $request->uuid)->select('rke')->orderBy('rke', 'desc')->first();
            $nomor = 1;
            if ($cek) {
                $nomor += $cek->rke;
            }
            if ($data->rke != null && $data->rke != '') {
                $arr = ['ada_obat' => 'Ya',
                ];
            } else {
                $arr = ['ada_obat' => 'Ya',
                    'rke' => $nomor,
                ];
            }
            Registrasi::where('uuid', '=', $request->uuid)->update($arr);
        } else {
            // $arr = ['ada_obat' => 'Tidak',
            //  'rke' => 0
            // ];
            // $update = Registrasi::where('uuid', '=', $request->registrasi_uuid)->update($arr);
        }

        return response()->json(['data' => $data, 'obat' => $obat, 'obatracikan' => $obatracikan]);
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
}
