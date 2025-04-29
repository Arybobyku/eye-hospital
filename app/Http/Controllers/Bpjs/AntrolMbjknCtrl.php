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


            $request->validate([
                'kodepoli' => 'string|max:10',
                'kodedokter' => 'integer',
                'tanggalperiksa' => 'date_format:Y-m-d',
                'jampraktek' => 'string'
            ]);
            
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

            return response()->json([
                'response' => [
                    "namapoli" => $poli,
                    "namadokter" => $namaDokter,
                    "totalantrean" => $totalAntrian,
                    "sisaantrean" => 1,
                    "antreanpanggil" => "P-1",
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
                "nomorkartu" => "string",
                "nik" => "string",
                "nohp" => "string",
                "kodepoli" => "string",
                "norm" => "string",
                "tanggalperiksa" => "string",
                "kodedokter" => "string",
                "jampraktek" => "string",
                "jeniskunjungan" => "string",
                "nomorreferensi" => "string"
            ]);
            
            $noRm = Pasien::where('rekam_medis', $request->norm)
            ->get();

            if($noRm->isEmpty()) {
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
            
            $data = AntrianRo::where('tanggal', "2025-03-11")
                ->where('kode', "R")
                ->get();

            $angkaAntrean = $data->max('number') + 1;

            $formattedAntrean = 'R-' . str_pad($angkaAntrean, 3, '0', STR_PAD_LEFT);
            
            $poli = MasterPoliBpjs::where('kdpoli', $request->kodepoli)
            ->value('nmpoli');

            $namaDokter = MasterDokterBpjs::where('kodedokter', $request->kodedokter)
            ->value('namadokter');

            

            $masterKuotaAntrian = MasterKuotaAntrian::first();
            $kuotaJkn = $masterKuotaAntrian->kuota_jkn ?? 0;
            $kuotaNonJkn = $masterKuotaAntrian->kuota_non_jkn ?? 0;
            $sisaKuotaJkn = $kuotaJkn - max(0, $data->where('is_jkn', "1")->count());
            $sisaKuotaNonJkn = $kuotaNonJkn - max(0, $data->where('is_jkn', "0")->count());

            return response()->json([
                'response' => [
                    "nomorantrean" => $formattedAntrean,
                    "angkaantrean"=> $angkaAntrean,
                    "kodebooking"=> "P3140325",
                    "norm"=> $noRm,
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
            ], 401);
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
            
            $data = AntrianRo::join('registrasi', 'antrian_ro.uuid_registrasi', '=', 'registrasi.uuid')
            ->where('registrasi.nomor', $request->kodebooking)
            ->first(['antrian_ro.*']);

            $formattedAntrean = $data->kode . '-' . str_pad($data->number, 3, '0', STR_PAD_LEFT);
            $poli = $data->poli;
            $namaDokter = MasterDokterBpjs::where('kodedokter', $data->kode_dokter)
            ->value('namadokter');
            return response()->json([
                "response" => [
                    "nomorantrean" => $formattedAntrean,
                    "namapoli" => $poli,
                    "namadokter" => $namaDokter,
                    "sisaantrean" => "",
                    "antreanpanggil" => "",
                    "waktutunggu" => 9000,
                    "keterangan" => ""
                ],
                "metadata" => [
                    "message" => "Ok",
                    "code" => "200"
                ],
                $data
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
            
            $request->validate([
                "kodebooking" => "string",
                "keterangan" => "string",
            ]);

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
            
            $request->validate([
                "kodebooking" => "string",
                "waktu" => "string",
            ]);

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
            

            return response()->json([
                'nomor kartu' => "ini dia"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }

    public function jadwalOperasiPasien(Request $request)
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
            

            return response()->json([
                'nomor kartu' => "ini dia"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
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
}
