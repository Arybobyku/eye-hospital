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


class LayananBedahCtrl extends Controller
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
                // ->where('bedah_status', '!=', 'Selesai Dioperasi')
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
                // ->where('bedah_status', '!=', 'Selesai Dioperasi')
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
                // ->where('bedah_status', '!=', 'Selesai Dioperasi')
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
                // ->where('bedah_status', '!=', 'Selesai Dioperasi')
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


    public function edit(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }
        $data = Registrasi::where('uuid', '=', $request->uuid)->first();
        $layanan = LayananPasien::where('registrasi_uuid', '=', $request->uuid);
        if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
            $layanan = $layanan->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
        }
        $layanan = $layanan->where('nama_layanan', '!=', 'Obat-obatan')
            ->where('nama_layanan', '!=', 'Obat Racikan')
            ->orderBy('id', 'desc')->get();

        return response()->json(['data'=> $data, 'layanan' => $layanan ]);
    }


    public function update(Request $request)
    {
        $reg = Registrasi::where('uuid', '=', $request->registrasi_uuid)->first();
    
        // Simpan data lama sebelum dihapus
        $existingQuery = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid);
        if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
            $existingQuery = $existingQuery->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
        }
        $existingData = $existingQuery->get()->keyBy('layanan_uuid');
    
        // Hapus data lama
        $remove = LayananPasien::where('registrasi_uuid', '=', $request->registrasi_uuid);
        if (\Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')) != 'cdc80d09-4b35-4d03-8abe-be86a33e9e08') {
            $remove = $remove->where('pengguna_uuid', '=', \Crypt::decrypt(\Cookie::get(env('APP_IDENTIFIER').'BioUuid')));
        }
        $remove = $remove->delete();
    
        $tindakan = json_decode($request->layanan);
        foreach ($tindakan as $row) {
            $old = $existingData->get($row->tindakan_rawat_jalan_uuid);
    
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
            $item->tanggal = $old ? $old->tanggal : date('Y-m-d');
            $item->waktu = $old ? $old->waktu : date('H:i');
            $item->carabayar_uuid = $reg->carabayar_uuid;
            $item->carabayar_nama = $reg->carabayar_nama;
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
                        $item->nama_dokter = $reg->nama_dokter;
                    } else {
                        $item->jenis = 'Administrasi';
                        $item->nama_dokter = $reg->nama_dokter;
                    }
                } else {
                    $item->jenis = 'Administrasi';
                    $item->nama_dokter = $reg->nama_dokter;
                }
            } else {
                $cek = explode(' ', $row->nama_tindakan_rawat_jalan);
                if (count($cek) > 0) {
                    if ($cek[0] == 'Honor' || $cek[0] == 'Konsul' || $cek[0] == 'Konsultasi' || $cek[0] == 'Gaji') {
                        $item->jenis = 'Honor';
                        if ($row->nama_tindakan_rawat_jalan == 'Konsultasi Dokter Umum') {
                            $item->nama_dokter = 'dr. Eric Jansen';
                        } else {
                            $item->nama_dokter = $reg->nama_dokter;
                        }
                    } elseif ($cek[0] == 'Administrasi') {
                        $item->jenis = 'Administrasi';
                        $item->nama_dokter = $reg->nama_dokter;
                    } elseif ($cek[0] == 'Operation' || $cek[0] == 'Room') {
                        $item->jenis = 'Room';
                        $item->nama_dokter = $reg->nama_dokter;
                    } else {
                        $item->jenis = 'Rawat Jalan';
                        $item->nama_dokter = $reg->nama_dokter;
                    }
                } else {
                    $item->jenis = 'Rawat Jalan';
                    $item->nama_dokter = $reg->nama_dokter;
                }
            }
            $item->default = $row->default;
            $item->save();
        }
    
        return response()->json(['data' => $reg, 'layanan' => $tindakan]);
    }





  
}
