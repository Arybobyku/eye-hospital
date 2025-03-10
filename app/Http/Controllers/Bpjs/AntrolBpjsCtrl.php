<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use App\Services\Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Helpers\ResponseFormatter;
use App\Models\Registrasi;
use App\Models\Pasien;
use App\Models\PasienBebas;
use App\Models\Antrian;
use App\Models\AntrianFarmasi;
use App\Models\AntrolLogs;
use App\Models\Pengguna;
use App\Models\MasterDokterBpjs;
use App\Models\MasterPoliBpjs;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Services\Bpjs\Bridging\Vclaim\BridgeVclaim;
use DB;
use Cookie;
use Crypt;
use PenggunaHelp;
use Svg\Tag\Rect;

class AntrolBpjsCtrl extends Controller
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

    public function dashboardPerBulan($params1, $params2, $params3)
    {
        $endpoint = "dashboard/waktutunggu/bulan/{$params1}/tahun/{$params2}/waktu/{$params3}";
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
    public function syncPoli()
    {
        $endpoint = 'ref/poli';
        $jsonString = $this->bridging->getRequest($endpoint);

        // Convert to PHP object
        $result = json_decode($jsonString);
        if (!empty($result->response)) {
            foreach ($result->response as $poli) {
                MasterPoliBpjs::updateOrCreate(
                    ['kdsubspesialis' => $poli->kdsubspesialis],  // Search by `kdsubspesialis`
                    [
                        'nmpoli' => $poli->nmpoli,
                        'nmsubspesialis' => $poli->nmsubspesialis,
                        'kdsubspesialis' => $poli->kdsubspesialis,
                        'kdpoli' => $poli->kdpoli
                    ]
                );
            }
        }

        return 'ok';
    }

    public function syncDokter()
    {
        $endpoint = 'ref/dokter';
        $jsonString = $this->bridging->getRequest($endpoint);

        // Convert to PHP object
        $result = json_decode($jsonString);
        if (!empty($result->response)) {
            foreach ($result->response as $dokter) {
                MasterDokterBpjs::updateOrCreate(
                    ['nik' => $dokter->nik],  // Search by `kdsubspesialis`
                    [
                        'nmpoli' => $dokter->nik,
                        'namadokter' => $dokter->namadokter,
                        'kodedokter' => $dokter->kodedokter,
                    ]
                );
            }
        }

        return 'ok';
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

    public function referensiDokterByKode($kodeDokterBpjs)
    {
        $endpoint = 'ref/dokter';
        $response = $this->bridging->getRequest($endpoint);

        // Pastikan response dari API BPJS valid
        if (!isset($response['list']) || !is_array($response['list'])) {
            return response()->json(['message' => 'Data dokter tidak ditemukan'], 404);
        }

        // Cari dokter berdasarkan kode_dokter_bpjs_kes
        $dokter = collect($response['list'])->firstWhere('kodedokter', $kodeDokterBpjs);

        if (!$dokter) {
            return response()->json(['message' => 'Dokter dengan kode tersebut tidak ditemukan'], 404);
        }

        return response()->json($dokter);
    }


    public function referensiJadwalDokter($params1, $params2)
    {
        $endpoint = "jadwaldokter/kodepoli/{$params1}/tanggal/{$params2}";
        return $this->bridging->getRequest($endpoint);
    }

    public function referensiJadwalDokterByKodeDokter($params1, $params2, $kodeDokterBpjs)
    {
        $endpoint = "jadwaldokter/kodepoli/{$params1}/tanggal/{$params2}";
        return $this->bridging->getRequest($endpoint);
        // Pastikan response dari API BPJS valid
        if (!isset($response['list']) || !is_array($response['list'])) {
            return response()->json(['message' => 'Data dokter tidak ditemukan'], 404);
        }

        // Cari dokter berdasarkan kode_dokter_bpjs_kes
        $dokter = collect($response['list'])->firstWhere('kodedokter', $kodeDokterBpjs);

        if (!$dokter) {
            return response()->json(['message' => 'Dokter dengan kode tersebut tidak ditemukan'], 404);
        }

        return response()->json($dokter);
    }

    public function referensiPasienFingerPrint($nik, $noidentitas)
    {
        $endpoint = "ref/pasien/fp/identitas/{$nik}/noidentitas/{$noidentitas}";
        return $this->bridging->getRequest($endpoint);
    }

    public function updateJadwalDokter(Request $request)
    {
        $result = null;
        $endpoint = "jadwaldokter/updatejadwaldokter";
        $data = [
            "kodepoli" => "ANA",
            "kodesubspesialis" => "ANA",
            "kodedokter" => 12346,
            "jadwal" => [
                [
                    "hari" => "1",
                    "buka" => "08:00",
                    "tutup" => "10:00"
                ],
                [
                    "hari" => "2",
                    "buka" => "15:00",
                    "tutup" => "17:00"
                ]
            ]
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'updateJadwalDokter';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;

    }
    public function tambahAntrean(Registrasi $item, Pasien $pasien)
    {
        $result = null;
        $endpoint = "antrean/add";
        $dokter = Pengguna::where('uuid', '=', $item->pengguna_uuid)->first();
        if (!$dokter) {
            return response()->json(['message' => 'Dokter tidak ditemukan'], 404);
        }

        // Ambil dokter dari API BPJS berdasarkan kode_dokter_bpjs_kes
        // $dokterBpjs = $this->referensiDokterByKode($dokter->kode_dokter_bpjs_kes);
        $nomorOnly = preg_replace('/\D/', '', $item->no_pendaftaran);
        // if (!isset($dokterBpjs['kode'])) {
        //     return response()->json(['message' => 'Dokter tidak ditemukan di BPJS'], 404);
        // }

        $jumlahRegistrasi = Registrasi::where("pasien_uuid", "=", $pasien->uuid)->count() > 1 ? "0" : "1";

        $data = [
            "kodebooking" => $item->nomor,
            "jenispasien" => $item->carabayar_nama == 'BPJS Kesehatan' ? "JKN" : "NON JKN",
            "nomorkartu" => $item->no_bpjs_kes ?? "",
            "nik" => $pasien->no_identitas ?? "",
            "nohp" => $item->no_handphone ?? "",
            "kodepoli" => $item->kode_poli_bpjs ?? "",
            "namapoli" => $item->nama_poli_bpjs ?? "",
            "pasienbaru" => $jumlahRegistrasi ?? "",
            "norm" => $pasien->rekam_medis ?? "",
            "tanggalperiksa" => $item->tanggal ?? "",
            "kodedokter" => $item->kode_dokter_bpjs ?? "",
            "namadokter" => $item->nama_dokter_bpjs ?? "",
            "jampraktek" => $item->jadwal_dokter_bpjs ?? "",
            "jeniskunjungan" => "1",
            "nomorreferensi" => "0001R0040116A000001",
            "nomorantrean" => $item->no_pendaftaran,
            "angkaantrean" => $nomorOnly,
            "estimasidilayani" => 1615869169000,
            "sisakuotajkn" => 5,
            "kuotajkn" => 30,
            "sisakuotanonjkn" => 5,
            "kuotanonjkn" => 30,
            "keterangan" => "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $result = null;
        $endpoint = "antrean/farmasi/add";
        $data = [
            "kodebooking" => $item->nomor,
            "jenisresep" => $item->jenis, // (racikan / non racikan)
            "nomorantrean" => $item->number,
            "keterangan" => "Testing"
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'tambahAntrean';
        $antrolLogs->uuid_register = $item->uuid;
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }
    public function tambahAntreanFarmasi(AntrianFarmasi $item)
    {
        $result = null;
        $endpoint = "antrean/farmasi/add";
        $data = [
            "kodebooking" => $item->nomor,
            "jenisresep" => $item->jenis, // (racikan / non racikan)
            "nomorantrean" => $item->number,
            "keterangan" => "Testing"
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'tambahAntreanFarmasi';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }

    public function updateWaktuAntrean(Request $request)
    {
        $result = null;
        $endpoint = "antrean/updatewaktu";
        $data = [
            "kodebooking" => "16032021A001",
            "taskid" => 5,
            "waktu" => 1616559330000,
            "jenisresep" => "Tidak ada" // khusus yang sudah implementasi antrean farmasi
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'updateWaktuAntrean';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }

    public function updateWaktuAntreanFarmasi(PasienBebas $item)
    {
        $endpoint = "antrean/updatewaktu";
        $result = null;
        $timestamp = round(microtime(true) * 1000);
        $data = [
            "kodebooking" => $item->nomor,
            "taskid" => 7,
            "waktu" => $timestamp,
            // "jenisresep" => "Tidak ada"// khusus yang sudah implementasi antrean farmasi
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'updateWaktuAntreanFarmasi';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }

    public function batalAntrean(Registrasi $item)
    {
        $result = null;
        $endpoint = "antrean/batal";
        $data = [
            "kodebooking" => $item->nomor,
            "keterangan" => "Batal Antrean"
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'batalAntrean';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }

    public function batalAntreanFarmasiBebas(PasienBebas $item)
    {
        $result = null;
        $endpoint = "antrean/batal";
        $data = [
            "kodebooking" => $item->nomor,
            "keterangan" => "Batal Antrean"
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        $antrolLogs = new AntrolLogs();
        $antrolLogs->action = 'batalAntrean';
        $antrolLogs->payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $antrolLogs->save();
        try {
            $result = $this->bridging->postRequest($endpoint, $jsonData);
        } catch (\Exception $e) {
            $antrolLogs->response = json_encode($e, JSON_UNESCAPED_UNICODE);
            $antrolLogs->update();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        $antrolLogs->response = $result;
        $antrolLogs->update();
        return $result;
    }

    public function listWaktuTaskId()
    {
        $endpoint = "antrean/getlisttask";
        $data = [
            "kodebooking" => "Y03-20#1617068533",
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return $this->bridging->postRequest($endpoint, $jsonData);
    }
}
