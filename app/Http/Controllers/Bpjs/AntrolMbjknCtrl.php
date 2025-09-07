<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use App\Models\AntrianPoli;
use App\Models\AntrianFarmasi;
use App\Models\AntrianRo;
use App\Models\MasterDokterBpjs;
use App\Models\MasterKuotaAntrian;
use App\Models\MasterPoliBpjs;
use App\Models\Pasien;
use App\Models\Pengguna;
use App\Models\Registrasi;
use App\Models\WsAuth;
use App\Models\RegistrasiOperasi;
use App\Services\Bpjs\Bridging\Antrol\BridgeAntrol;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;
use DB;
use Cookie;
use Crypt;
use Illuminate\Support\Facades\Hash;
use PenggunaHelp;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AntrolMbjknCtrl extends Controller
{
    protected $bridging;

    

    public function __construct()
    {
        $this->bridging = new BridgeAntrol();
    }

    public function dashboardPerTanggal($params1, $params2)
    {
        $endpoint = "dashboard/waktutunggu/tanggal/{$params1}/waktu/{$params2}";
        return $this->bridging->getRequest($endpoint);
    }

    public function listTask()
    {
        $endpoint = 'antrean/getlisttask';
        return $this->bridging->getRequest($endpoint);
    }

    public function antrianBelumDilayani()
    {
        $endpoint = 'antrean/pendaftaran/aktif';
        return $this->bridging->getRequest($endpoint);
    }

    public function referensiPoli()
    {
        $endpoint = 'ref/poli';
        return $this->bridging->getRequest($endpoint);
    }

    public function referensiPoliFingerPrint()
    {
        $endpoint = 'ref/poli/fp';
        return $this->bridging->getRequest($endpoint);
    }

    public function referensiDokter()
    {
        $endpoint = 'ref/dokter';
        return $this->bridging->getRequest($endpoint);
    }

    public function referensiJadwalDokter($params1, $params2)
    {
        $endpoint = "jadwaldokter/kodepoli/{$params1}/tanggal/{$params2}";
        return $this->bridging->getRequest($endpoint);
    }

    
    public function referensiPasienFingerPrint($nik, $noidentitas)
    {
        $endpoint = "ref/pasien/fp/identitas/{$nik}/noidentitas/{$noidentitas}";
        return $this->bridging->getRequest($endpoint);
    }

    public function generateToken(Request $request) 
    {
        $username = $request->header('X-username');
        $password = $request->header('X-password');

        if(!$username || !$password) {
            return response()->json(['message' => 'Username atau Password tidak tersedia'],400);
        }

        $user = WsAuth::where('username', $username)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid Username or Password'],401);
        }
        
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "response" => [
                "token" => $token
            ],
            "metadata" => [
                "message" => "Ok",
                "code" => 200
            ]
            ]);
    }

    public function getPayload()
    {
        try {
            $token = JWTAuth::getToken(); // Get the token from the request
            $payload = JWTAuth::getPayload($token); // Decode the payload

            return response()->json([
                'payload' => $payload->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid token'
            ], 401);
        }
    }

    public function statusAntrean(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');
        
        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }

            $tanggal = $request->tanggalperiksa;

            if (!\DateTime::createFromFormat('Y-m-d', $tanggal) || $tanggal != date('Y-m-d', strtotime($tanggal))) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd',
                        'code'    => 201
                    ]
                ], 201);
            }

            if ($tanggal < date('Y-m-d')) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Tanggal Periksa Tidak Berlaku',
                        'code'    => 201
                    ]
                ], 201);
            }

            $antreanPoli = AntrianPoli::where('kode_poli', $request->kodepoli)
            ->where('tanggal', $request->tanggalperiksa)
            ->exists();
            if(!$antreanPoli) {
                return response()->json([
                    'metadata' => [
                        "message" => "Poli tidak ditemukan",
                        "code" => "201"
                    ]
                ], 201);
            }


            
            // $request->validate([
            //     'kodepoli' => 'string|max:10',
            //     'kodedokter' => 'integer',
            //     'tanggalperiksa' => 'date_format:Y-m-d',
            //     'jampraktek' => 'string'
            // ]);
            
            
            $namaDokter = MasterDokterBpjs::where('kodedokter', $request->kodedokter)
            ->value('namadokter');

            $jadwal = $this->referensiJadwalDokter($request->kodepoli, $request->tanggalperiksa);
            if($jadwal['metadata']['code'] == 1) {
                return response()->json([
                    'metadata' => [
                        "message" => "Poli tidak ditemukan",
                        "code" => "201"
                    ]
                ], 201);
            }
            // $kodedokter = array_column($jadwal['response'], 'kodedokter');
            // if (!in_array($request->kodedokter, $kodedokter)) {
            //     return response()->json([
            //         'metadata' => [
            //             "message" => "Jadwal Dokter {$namaDokter} Tersebut Belum Tersedia, Silahkan Reschedule Tanggal dan Jam Praktek Lainnya ",
            //             "code" => "201"
            //         ]
            //     ], 201);
            // }

            $masterKuotaAntrian = MasterKuotaAntrian::first();

            // Safely destructure quotas
            $kuotaJkn = $masterKuotaAntrian->kuota_jkn ?? 0;
            $kuotaNonJkn = $masterKuotaAntrian->kuota_non_jkn ?? 0;

            // Fetch Antrian Data once
            $data = AntrianPoli::where('kode_poli', $request->kodepoli)
                ->where('kode_dokter', $request->kodedokter)
                ->where('tanggal', $request->tanggalperiksa)
                ->get();

            // Calculate total antrian and retrieve 'poli' from the first record
            $totalAntrian = $data->count();
            $poli = $data->first()->poli ?? null;

            // Calculate remaining quotas
            $sisaKuotaJkn = $kuotaJkn - max(0, $data->where('is_jkn', "1")->count());
            $sisaKuotaNonJkn = $kuotaNonJkn - max(0, $data->where('is_jkn', "0")->count());

            $namaDokter = optional(
                MasterDokterBpjs::where('kodedokter', $request->kodedokter)->first()
            )->namadokter;

            $antreanPanggil = $data->where('panggil', 1)->max('number');
            if(!$antreanPanggil) {
                $antreanPanggil = 1;
            }
            $sisaAntrean = $data->where('panggil', 0)->count();
            return response()->json([
                'response' => [
                    "namapoli" => $poli,
                    "namadokter" => $namaDokter,
                    "totalantrean" => $totalAntrian,
                    "sisaantrean" => $sisaAntrean,
                    "antreanpanggil" => "P-{$antreanPanggil}",
                    "sisakuotajkn" => $sisaKuotaJkn,
                    "kuotajkn" => $kuotaJkn,
                    "sisakuotanonjkn" => $sisaKuotaNonJkn,
                    "kuotanonjkn" => $kuotaNonJkn,
                    "keterangan" => "",
                ],
                
                "metadeta" => [
                    'message' => 'Ok',
                    'code' => '200'
                ],
                ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }

    public function ambilAntrean(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            DB::beginTransaction();

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            // $request->validate([
            //     "nomorkartu" => "string",
            //     "nik" => "string",
            //     "nohp" => "string",
            //     "kodepoli" => "string",
            //     "norm" => "string",
            //     "tanggalperiksa" => "string",
            //     "kodedokter" => "string",
            //     "jampraktek" => "string",
            //     "jeniskunjungan" => "string",
            //     "nomorreferensi" => "string"
            // ]);
            
            $pasien = Pasien::where('rekam_medis', $request->norm)
            ->first();

            $uuidpasien = $pasien->uuid;
            $namapasien = $pasien->nama;

            if(!$pasien) {
                return response()->json([
                    'response' => [
                        'message' => "No rm tidak terdaftar silahkan daftar pada info pasien baru"
                    ],
                    'metadata' => [
                        "message" => "Ok",
                        'code' => "404"
                    ]
                ],404);
            }
            
            $data = AntrianPoli::where('tanggal', $request->tanggalperiksa)
                ->get();
                

            
            $exists = AntrianPoli::where('tanggal', $request->tanggalperiksa)
            ->where('uuid_pasien', $uuidpasien)
            ->where('kode_poli', $request->kodepoli) // tambahkan cek kodepoli
            ->exists();
            
            if ($exists) {
                return response()->json([
                    'metadata' => [
                        "message" => "Nomor Antrean Hanya Dapat Diambil 1 Kali Pada Tanggal Yang Sama untuk poli yang sama",
                        "code" => "201"
                    ],
                ], 201);
            }
            
            
            $poli = MasterPoliBpjs::where('kdsubspesialis', $request->kodepoli)
            ->value('nmpoli');

            $namaDokter = MasterDokterBpjs::where('kodedokter', $request->kodedokter)
            ->value('namadokter');

            $namaAsli = Pengguna::where('kode_dokter_bpjs_kes', $request->kodedokter)
            ->value('nama');

            $angkaAntrean = $data->max('number') + 1;
            $formattedAntrean = 'P-' . str_pad($angkaAntrean, 3, '0', STR_PAD_LEFT);

            $jadwal = json_decode($this->referensiJadwalDokter($request->kodepoli, $request->tanggalperiksa),true);
            if($jadwal['metadata']['code'] == 1) {
                return response()->json([
                    'metadata' => [
                        "message" => "Pendaftaran ke poli sedang tutup",
                        "code" => "201"
                    ]
                ], 201);
            }
            $kodedokter = array_column($jadwal['response'], 'kodedokter');
            if (!in_array($request->kodedokter, $kodedokter)) {
                return response()->json([
                    'metadata' => [
                        "message" => "Jadwal Dokter {$namaDokter} Tersebut Belum Tersedia, Silahkan Reschedule Tanggal dan Jam Praktek Lainnya ",
                        "code" => "201"
                    ]
                ], 201);
            }

            //Input registrasi
            $registrasinomors = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
            ->where('status', '=', 'Kunjungan')->orderBy('nomor', 'desc')->sharedLock()->first();

            $nomor = 1;
			$nomor_ = '';
            if ($registrasinomors) {
                $potong_kalimat = substr($registrasinomors->nomor, -5);
                $potong_kalimat = (int) $potong_kalimat;
                $nomor += $potong_kalimat;
            }

            if ($nomor < 10) {
                $nomor = '0000' . $nomor;
            } else if ($nomor > 9 && $nomor < 100) {
                $nomor = '000' . $nomor;
            } else if ($nomor > 99 && $nomor < 1000) {
                $nomor = '00' . $nomor;
            } else if ($nomor > 999 && $nomor < 10000) {
                $nomor = '0' . $nomor;
            }

            $nomor_ = date('Y') . date('m') . date('d') . $nomor;
            // $nomor_ = '2025081400008';

            $no = 1;
				$nopendaftaran = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('jalur_masuk', '=', 'Instalasi Gawat Darurat')
					->orderBy('no_pendaftaran', 'desc')->first();
				if ($nopendaftaran) { 
					$temp = explode("-", $nopendaftaran->no_pendaftaran);
					$no += (int) $temp[1]; 
				}
				if ($no < 9) { $no = '00'.$no; }
				else if ($no > 9 && $no < 100) { $no = '0'.$no; }
				else if ($no > 99 && $no < 1000) { $no = ''.$no; }
				$no_pendaftaran = 'G-'.$no;
            $uuidRegis = '';
		    $loop = false;
		    do {
			    $uuidRegis = Uuid::uuid4();
			    $check = Registrasi::where('uuid', '=', $uuidRegis)->first();
			    if (!$check) {
				    $loop = true;
			    }
		    } while ($loop == false);
            
            $item = new Registrasi();
            $item -> uuid = $uuidRegis;
            $item -> kode = "RJ";
            $item -> rekam_medis = $request->norm;
            $item -> jenis = "Rawat Jalan";
            $item -> nomor = $nomor_;
            $item -> pasien_uuid = $uuidpasien;
            $item -> nama_pasien = $namapasien;
            $item -> tanggal_lahir = $pasien->tanggal_lahir;
            $item -> jenis_identitas = $pasien->jenis_identitas;
            $item -> no_identitas = $pasien->no_identitas;
            $item -> jenis_kelamin = $pasien->jenis_kelamin;
            $item -> no_handphone = $pasien->no_handphone;
            $item -> agama =  $pasien -> agama;
            $item -> photos = "-";
            $item -> pengguna_uuid = "49e7cf52-9bfd-4933-b42e-0444af1eaeb7";
            $item -> nama_dokter = $namaAsli;
            $item -> carabayar_uuid = "e3ed042d-2b41-4672-bcc2-7a816a622667";
            $item -> carabayar_nama = "BPJS Kesehatan";
            $item -> pengguna_umum_uuid = "-";
            $item -> nama_dokter_umum = "-";
            $item -> tanggal = date("Y-m-d");
            $item -> waktu = date('H:i');
            $item -> no_pendaftaran = $no_pendaftaran;
            $item -> cara_masuk = "Datang Sendiri";
            $item -> nama_asuransi = "Silahkan Pilih";
			$item->last_position = 'Pendaftaran';
			$item->status = 'Kunjungan';
            $item->status_ro = 'Belum diperiksa';
            $item->status_dokter = 'Belum diperiksa';
            $item->status_kasir = 'Belum bayar';
            $item->status_farmasi = 'Belum bayar';
            $item->no_antrian_poli = $formattedAntrean;
            $item->no_bpjs_kes = $request->nomorkartu;
            $item->kode_poli_bpjs = $request->kodepoli;
            $item->nama_poli_bpjs = $poli;
            $item->kode_dokter_bpjs = $request->kodedokter;
            $item->nama_dokter_bpjs = $namaAsli;
            $item->jadwal_dokter_bpjs = $request->jampraktek;
            $item->is_integrated_antrol = '1';
            $item->is_jkn = '1';
			$item->save();

            $uuidPoli = '';
		    $loop = false;
		    do {
			    $uuidPoli = Uuid::uuid4();
			    $check = AntrianPoli::where('uuid', '=', $uuidPoli)->first();
			    if (!$check) {
				    $loop = true;
			    }
		    } while ($loop == false);
            $item = new AntrianPoli();
            $item->uuid = $uuidPoli;
            $item->kode = 'P';
            $item->number = $angkaAntrean;
            $item->jenis = 'Rawat Jalan';
            $item->tanggal = $request->tanggalperiksa;
            $item->pemanggil = '-';
            $item->status = 'Pending';
            $item->poli = $poli;
            $item->is_jkn = 1;
            $item->kode_poli = $request->kodepoli;
            $item->uuid_pasien = $uuidpasien;
            $item->kode_dokter = $request->kodedokter;
            $item->uuid_registrasi = $uuidRegis;

            $item->save();

            $masterKuotaAntrian = MasterKuotaAntrian::first();
            $kuotaJkn = $masterKuotaAntrian->kuota_jkn ?? 0;
            $kuotaNonJkn = $masterKuotaAntrian->kuota_non_jkn ?? 0;
            $sisaKuotaJkn = $kuotaJkn - max(0, $data->where('is_jkn', "1")->count());
            $sisaKuotaNonJkn = $kuotaNonJkn - max(0, $data->where('is_jkn', "0")->count());

            DB::commit();
            return response()->json([
                'response' => [
                    "nomorantrean" => $formattedAntrean,
                    "angkaantrean"=> $angkaAntrean,
                    "kodebooking"=> $nomor_,
                    "norm"=> $request->norm,
                    "namapoli"=> $poli,
                    "namadokter"=> $namaDokter,
                    "estimasidilayani"=> "",
                    "sisakuotajkn"=> $sisaKuotaJkn,
                    "kuotajkn"=> $kuotaJkn,
                    "sisakuotanonjkn"=> $sisaKuotaNonJkn,
                    "kuotanonjkn"=> $kuotaNonJkn,
                    "keterangan"=> "Peserta harap 60 menit lebih awal guna pencatatan administrasi."
                ],
                'metadata' => [
                    "message" => "Ok",
                    "code" => "200"
                ],
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 500);
        }
        
        
    }

    public function sisaAntrean(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }

            $request->validate([
                "kodebooking" => "string",
            ]);
            
            $data = AntrianPoli::join('registrasi', 'antrian_poli.uuid_registrasi', '=', 'registrasi.uuid')
            ->where('registrasi.nomor', $request->kodebooking)
            ->first(['antrian_poli.*']);

            if(!$data){
                return response()->json([
                    'metadata' => [
                        'message' => 'Antrean tidak ditemukan',
                        'code' => 201
                    ]
                ], 201);
            }
            $antreanPanggil = $data->where('panggil', 1)->where('tanggal', $data->tanggal)->max('number');
            if(!$antreanPanggil) {
                $antreanPanggil = 1;
            }
            $sisaAntrean = $data->where('panggil', 0)->where('tanggal', $data->tanggal)->count();
            $formattedAntrean = $data->kode . '-' . str_pad($data->number, 3, '0', STR_PAD_LEFT);
            $poli = $data->poli;
            $namaDokter = MasterDokterBpjs::where('kodedokter', $data->kode_dokter)
            ->value('namadokter');
            return response()->json([
                "response" => [
                    "nomorantrean" => $formattedAntrean,
                    "namapoli" => $poli,
                    "namadokter" => $namaDokter,
                    "sisaantrean" => $sisaAntrean,
                    "antreanpanggil" => $antreanPanggil,
                    "waktutunggu" => 9000,
                    "keterangan" => ""
                ],
                "metadata" => [
                    "message" => "Ok",
                    "code" => "200"
                ],
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
        
    }

    public function batalAntrean(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            // $request->validate([
            //     "kodebooking" => "string",
            //     "keterangan" => "string",
            // ]);

            $uuid = Registrasi::where('nomor', $request->kodebooking)
            ->value('uuid');

            $data = AntrianPoli::where('uuid_registrasi', $uuid)
            ->first();
            if($data->status == "Cancel") {
                return response()->json([
                    "metadata" => [
                        "code" => "201",
                        "message" => "Antrean Tidak Ditemukan atau Sudah Dibatalkan"
                    ]
                ]);
            }
            else if ($data) {
                $data->status = 'Cancel';
                $data->save();
            } else if(!$data) {
                return response()->json([
                    "metadata" => [
                        "code" => "201",
                        "message" => "Antrean Tidak Ditemukan"
                    ]
                ]);
            }

            return response()->json([
                "metadata" => [
                    "message" => "Ok",
                    "code" => "200"
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }

    public function checkIn(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            // $request->validate([
            //     "kodebooking" => "string",
            //     "waktu" => "string",
            // ]);

            $uuid = Registrasi::where('nomor', $request->kodebooking)
            ->value('uuid');

            $data = AntrianPoli::where('uuid_registrasi', $uuid)
            ->first();
            if ($data) {
                $data->status = 'active';
                $data->save();
            } else if(!$data) {
                return response()->json([
                    "metadata" => [
                        "code" => "201",
                        "message" => "Kode Booking Tidak Ditemukan"
                    ]
                ]);
            }
            return response()->json([
                "metadata" => [
                    "code" => "200",
                    "message" => "Ok"
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }

    public function infoPasienBaru(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            // $validated = $request->validate([
            //     'nomorkartu'   => 'string',
            //     'nik'          => 'string',
            //     'nomorkk'      => 'string',
            //     'nama'         => 'string',
            //     'jeniskelamin' => 'string',
            //     'tanggallahir' => 'string',
            //     'nohp'         => 'string',
            //     'alamat'       => 'string',
            //     'kodeprop'     => 'string',
            //     'namaprop'     => 'string',
            //     'kodedati2'    => 'string',
            //     'namadati2'    => 'string',
            //     'kodekec'      => 'string',
            //     'namakec'      => 'string',
            //     'kodekel'      => 'string',
            //     'namakel'      => 'string',
            // ]);
            
            $pasien = Pasien::where('tahun', '=', date('y'))->orderBy('nomor', 'desc')->first();
			$nomor = 1;
			if ($pasien) {
				$nomor += $pasien->nomor;
			}
			$rekam_medis = date('y') . '' . date('m');
			$angka_nol = '-';
			if ($nomor < 10) {
				$angka_nol = '0000';
				$rekam_medis .= '0000' . $nomor;
			} else if ($nomor > 9 && $nomor < 100) {
				$angka_nol = '000';
				$rekam_medis .= '000' . $nomor;
			} else if ($nomor > 99 && $nomor < 1000) {
				$angka_nol = '00';
				$rekam_medis .= '00' . $nomor;
			} else if ($nomor > 999 && $nomor < 10000) {
				$angka_nol = '0';
				$rekam_medis .= '0' . $nomor;
			} else if ($nomor > 9999 && $nomor < 100000) {
				$angka_nol = '-';
				$rekam_medis .= $nomor;
			}

            $rtRw = ($request->rt && $request->rw)
                ? ($request->rt . '-' . $request->rw)
                : 'rtrw';
                
               
            $uuidPasien = '';
            $loop = false;
            do {
                $uuidPasien = Uuid::uuid4();
                $check = Pasien::where('uuid', '=', $uuidPasien)->first();
                if(!$check) {
                    $loop = true;
                }
            } while ($loop == false);


            $uuidRegis = '';
            $loop = false;
            do {
                $uuidRegis = Uuid::uuid4();
                $check = Registrasi::where('uuid', '=', $uuidRegis)->first();
                if(!$check) {
                    $loop = true;
                }
            } while ($loop == false);
           
            


            $pasien = new Pasien();
            $pasien->uuid = $uuidPasien;
            $pasien->rekam_medis = $rekam_medis;
            $pasien->angka_nol = $angka_nol;
            $pasien->no_bpjs = $request->nomorkartu;
            $pasien->jenis_identitas = 'KTP';
            $pasien->no_identitas = $request->nik;
            $pasien->no_kk = $request->nomorkk;
            $pasien->nama = $request->nama;
            $pasien->jenis_kelamin = $request->jeniskelamin;
            $pasien->tanggal_lahir = $request->tanggallahir;
            $pasien->no_handphone = $request->nohp;
            $pasien->alamat = $request->alamat;
            $pasien->provinsi_id = $request->kodeprop;
            $pasien->nama_provinsi = $request->namaprop;
            $pasien->kab_kota_id = $request->kodedati2;
            $pasien->nama_kab_kota = $request->namadati2;
            $pasien->kecamatan_id = $request->kodekec;
            $pasien->nama_kecamatan = $request->namakec;
            $pasien->kelurahan_id = $request->kodekel;
            $pasien->nama_kelurahan = $request->namakel;
            $pasien->rt_rw = $rtRw;
            $pasien->save();


            
         
            $nomor = 1;
				$nomor_ = '';

				$registrasinomors = Registrasi::whereDate('tanggal', '=', date('Y-m-d'))
					->where('status', '=', 'Kunjungan')->orderBy('nomor', 'desc')->sharedLock()->first();

				if ($registrasinomors) {
					$potong_kalimat = substr($registrasinomors->nomor, -5);
					$potong_kalimat = (int) $potong_kalimat;
					$nomor += $potong_kalimat;
				}

				if ($nomor < 10) {
					$nomor = '0000' . $nomor;
				} else if ($nomor > 9 && $nomor < 100) {
					$nomor = '000' . $nomor;
				} else if ($nomor > 99 && $nomor < 1000) {
					$nomor = '00' . $nomor;
				} else if ($nomor > 999 && $nomor < 10000) {
					$nomor = '0' . $nomor;
				}

				$nomor_ = date('Y') . date('m') . date('d') . $nomor;


                $registrasi = new Registrasi();
                $registrasi->uuid = $uuidRegis;
                $registrasi->kode = 'RJ';
                $registrasi->nomor = $nomor_;
                $registrasi->jenis = 'Rawat Jalan';
                $registrasi->pasien_uuid = $uuidPasien;
                $registrasi->rekam_medis = $rekam_medis;
                $registrasi->tanggal_lahir = $request->tanggallahir;
                $registrasi->jenis_identitas = 'KTP';
                $registrasi->no_identitas = $request->nik;
                $registrasi->nama_pasien = $request->nama;
                $registrasi->jenis_kelamin = $request->jeniskelamin;
                $registrasi->no_handphone = $request->nohp;
                $registrasi->save();

            return response()->json([
                'response' => [
                    "norm" => $rekam_medis,
                    "uuidPasien" => $uuidPasien,
                    "uuidRegis" => $uuidRegis,
                    "nomor" => $nomor_,
                    "rtrw" => $rtRw,
                    
                ],
                "metadata" => [
                    "message" => "Harap datang ke admisi untuk melengkapi data rekam medis"
                ]
            ]);
            
        } catch (\Exception $e) {
            return $e;
            // return response()->json([
            //     'error' => $e
            // ], 401);
        }


        
    }

    public function jadwalOperasiRs(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');
        $tanggalAwal = $request->tanggalawal;
        $tanggalAkhir = $request->tanggalakhir;
        // echo($tanggalAwal);
        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }
        
        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            // Query Dari index list Data bedah pasien
                $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah','registrasi_operasi.nama_layanan AS nama_layanan',  
                'registrasi_operasi.tanggal AS tanggal_operasi')
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')
                    ->orWhere('registrasi.paket_bedah_uuid', '!=', '')
                    ->orWhereNotNull('registrasi.paket_bedah_uuid');
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->where('registrasi.nama_paket_bedah', '!=', '')
                ->whereNotNull('registrasi.nama_paket_bedah');

            $data = $data
                ->whereBetween('registrasi_operasi.tanggal', [$tanggalAwal, $tanggalAkhir])
                ->orderBy('registrasi_operasi.tanggal', 'desc') // tambahin filter tanggal
                ->get();

            return response()->json([
                'response' => [
                    'list' => $data->map(function($item) {
                        return [
                            'kodebooking'    => $item->registrasi_nomor,
                            'tanggaloperasi' => $item->tanggal_operasi,
                            'jenistindakan'  => $item->nama_layanan,   // sesuaikan field di tabel
                            'kodepoli'       => $item->kode_poli_bpjs,        // sesuaikan field di tabel
                            'namapoli'       => $item->nama_poli_bpjs,        // sesuaikan field di tabel
                            'terlaksana'     => 0,
                            'nopeserta'      => $item->no_bpjs_kes,
                            'lastupdate'     => $item->updated_at, // ms
                        ];
                    })
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code'    => 200
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 401);
        }
        
    }

    public function jadwalOperasiPasien(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');
        $noPeserta = $request->nopeserta;

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            // Query Dari index list Data bedah pasien
                $data = Registrasi::select('registrasi.*', 'registrasi_operasi.nama_dokter AS nama_dokter_bedah', 'registrasi_operasi.tanggal AS tanggal_operasi')
                ->join('registrasi_operasi', 'registrasi.uuid', '=', 'registrasi_operasi.registrasi_uuid')
                ->where('registrasi.delete_soft', '=', 1)
                ->where('registrasi.apakah_paket', '=', 'Ya')
                ->where('bedah_status', '!=', 'Selesai Dioperasi')
                ->where(function ($q) {
                    $q->where('registrasi.paket_bedah_uuid', '!=', '-')
                    ->orWhere('registrasi.paket_bedah_uuid', '!=', '')
                    ->orWhereNotNull('registrasi.paket_bedah_uuid');
                })
                ->where('registrasi.nama_paket_bedah', '!=', '-')
                ->where('registrasi.nama_paket_bedah', '!=', '')
                ->whereNotNull('registrasi.nama_paket_bedah');

            $data = $data
                ->where('registrasi.no_bpjs_kes', $noPeserta)
                ->orderBy('registrasi_operasi.tanggal', 'desc') // tambahin filter tanggal
                ->get();

            return response()->json([
                'response' => [
                    'list' => $data->map(function($item) {
                        return [
                            'kodebooking'    => $item->registrasi_nomor,
                            'tanggaloperasi' => $item->tanggal_operasi,
                            'jenistindakan'  => $item->nama_layanan,   // sesuaikan field di tabel
                            'kodepoli'       => $item->kode_poli_bpjs,        // sesuaikan field di tabel
                            'namapoli'       => $item->nama_poli_bpjs,        // sesuaikan field di tabel
                            'terlaksana'     => 0,
                            'nopeserta'      => $item->no_bpjs_kes,
                        ];
                    })
                ],
                'metadata' => [
                    'message' => 'Ok',
                    'code'    => 200
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 401);
        }
        
    }

    public function ambilAntreanFarmasi(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            $request->validate([
                'kodebooking'   => 'string',
            ]);

            $data = AntrianFarmasi::where('tanggal', Carbon::today()->toDateString())
                ->where('kode', 'A')
                ->get();

            $angkaAntrean = $data->max('number') + 1;
            $formattedAntrean = 'A-' . str_pad($angkaAntrean, 3, '0', STR_PAD_LEFT);
            $uuid= Registrasi::where('nomor', $request->kodebooking)->first();
            if($uuid) {
                $pasien = $uuid->pasien_uuid;
                $registrasi = $uuid->uuid;
                $uuidFarmasi = '';
                $loop = false;
                do {
                    $uuidFarmasi = Uuid::uuid4();
                    $check = Pasien::where('uuid', '=', $uuidFarmasi)->first();
                    if(!$check) {
                        $loop = true;
                    }
                } while ($loop == false);
            }

            $antrian = new AntrianFarmasi();
            $antrian->uuid = $uuidFarmasi;
            $antrian->kode = 'A';
            $antrian->number = $angkaAntrean;
            $antrian->jenis = "Umum";
            $antrian->tanggal = Carbon::today()->toDateString();
            $antrian->pemanggil = '-';
            $antrian->status = 'active';
            $antrian->delete_soft = '1';
            $antrian->nomor = $request->kodebooking;
            $antrian->panggil = '0';
            $antrian->uuid_pasien = $pasien;
            $antrian->uuid_registrasi = $registrasi;
            $antrian->save();


            return response()->json([
                'response' => [
                    'jenisresep' => $antrian->jenis,
                    'nomorantrean' => $formattedAntrean,
                    'keterangan' => ''
                ],
                'metadata' => [
                    'message' => "Ok",
                    'code' => 200
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }

    public function statusAntreanFarmasi(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        
        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            $request->validate([
                'kodebooking'   => 'string',
            ]);

            $data = AntrianFarmasi::where('nomor', $request->kodebooking)->first();


            return response()->json([
                'response' => [
                    'jenisresep' => $data->jenis,
                    'totalantrean' => 2,
                    'sisaantrean' => 1,
                    'antreanpanggil' => 1,
                    'keterangan' => ""
                ],
                'metadata' => [
                    'message' => "Ok",
                    'code' => 200
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }
    public function jadwalOperasi(Request $request)
    {
        $token = $request->header('x-token');
        $username = $request->header('x-username');

        
        if(!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        try {

            $payload = JWTAuth::setToken($token)->getPayload();
            
            $tokenUsername = $payload->get('username');

            if ($username !== $tokenUsername) {
                return response()->json([
                    'metadata' => [
                        'message' => 'Username does not match token data',
                        'code' => 403
                    ]
                ], 403);
            }
            
            $request->validate([
                'kodebooking'   => 'string',
            ]);

            $data = AntrianFarmasi::where('nomor', $request->kodebooking)->first();


            return response()->json([
                'response' => [
                    'jenisresep' => $data->jenis,
                    'totalantrean' => 2,
                    'sisaantrean' => 1,
                    'antreanpanggil' => 1,
                    'keterangan' => ""
                ],
                'metadata' => [
                    'message' => "Ok",
                    'code' => 200
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }
   
}
