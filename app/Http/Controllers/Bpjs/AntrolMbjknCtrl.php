<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
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
                'kodepoli' => 'required|string|max:10',
                'kodedokter' => 'required|integer',
                'tanggalperiksa' => 'required|date_format:Y-m-d',
                'jampraktek' => 'required|string'
            ]);
            
            $respPoli = $request -> kodepoli;

            return response()->json([
                'response' => [
                    "namapoli" => "",
                    "namadokter" => "",
                    "totalantrean" => "",
                    "sisaantrean" => "",
                    "antreanpanggil" => "",
                    "sisakuotajkn" => "",
                    "kuotajkn" => "",
                    "sisakuotanonjkn" => "",
                    "kuotajkn" => "",
                    "keterangan" => "",
                ],
                "metadeta" => [
                    'message' => 'Ok',
                    'code' => '200'
                ]
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
                "nomorkartu" => "required|string",
                "nik" => "required|string",
                "nohp" => "required|string",
                "kodepoli" => "required|string",
                "norm" => "required|string",
                "tanggalperiksa" => "required|string",
                "kodedokter" => "required|string",
                "jampraktek" => "required|string",
                "jeniskunjungan" => "required|string",
                "nomorreferensi" => "required|string"
            ]);
            

            return response()->json([
                'response' => [
                    "nomorantrean" => "",
                    "angkaantrean"=> "",
                    "kodebooking"=> "",
                    "norm"=> "",
                    "namapoli"=> "",
                    "namadokter"=> "",
                    "estimasidilayani"=> "",
                    "sisakuotajkn"=> "",
                    "kuotajkn"=> "",
                    "sisakuotanonjkn"=> "",
                    "kuotanonjkn"=> "",
                    "keterangan"=> "Peserta harap 60 menit lebih awal guna pencatatan administrasi."
                ],
                'metadata' => [
                    "message" => "Ok",
                    "code" => "200"
                ]
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
                "kodebooking" => "required|string",
            ]);
            

            return response()->json([
                'nomor kartu' => "ini dia"
            ]);
            
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
                "kodebooking" => "required|string",
                "keterangan" => "required|string",
            ]);

            return response()->json([
                'nomor kartu' => "ini dia"
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
                "kodebooking" => "required|string",
                "waktu" => "required|string",
            ]);

            return response()->json([
                'nomor kartu' => "ini dia"
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
            
            $request->validate([
                'nomorkartu'   => 'required|string',
                'nik'          => 'required|string',
                'nomorkk'      => 'required|string',
                'nama'         => 'required|string',
                'jeniskelamin' => 'required|string',
                'tanggallahir' => 'required|string',
                'nohp'         => 'required|string',
                'alamat'       => 'required|string',
                'kodeprop'     => 'required|string',
                'namaprop'     => 'required|string',
                'kodedati2'    => 'required|string',
                'namadati2'    => 'required|string',
                'kodekec'      => 'required|string',
                'namakec'      => 'required|string',
                'kodekel'      => 'required|string',
                'namakel'      => 'required|string',
                'rw'           => 'required|string',
                'rt'           => 'required|string'
            ]);

            return response()->json([
                'nomor kartu' => "ini dia"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
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
                'kodebooking'   => 'required|string',
            ]);

            return response()->json([
                'nomor kartu' => "ini dia"
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
                'kodebooking'   => 'required|string',
            ]);

            return response()->json([
                'nomor kartu' => "ini dia"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], 401);
        }
        
    }
}
