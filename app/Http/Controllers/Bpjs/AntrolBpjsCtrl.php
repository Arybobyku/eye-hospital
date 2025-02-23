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

    public function updateJadwalDokter(Request $request)
    {
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
        // echo $jsonData;

        return $this->bridging->postRequest($endpoint, $jsonData);

    }
    public function tambahAntrean(Registrasi $item, Pasien $pasien)
    {
        $endpoint = "antrean/add";
        echo($item);
        $data = [
            "kodebooking" => $item->nomor,
            "jenispasien" => "Non JKN",
            "nomorkartu" => $item->no_bpjs_kes,
            "nik" => $pasien->no_identitas,
            "nohp" => $item->no_handphone,
            "kodepoli" => "ANA",
            "namapoli" => "MATA",
            "pasienbaru" => "0",
            "norm" => "123345",
            "tanggalperiksa" => "2021-01-28",
            "kodedokter" => "12345",
            "namadokter" => "Dr. Hendra",
            "jampraktek" => "08:00-16:00",
            "jeniskunjungan" => "1",
            "nomorreferensi" => "0001R0040116A000001",
            "nomorantrean" => "A-12",
            "angkaantrean" => "12",
            "estimasidilayani" => 1615869169000,
            "sisakuotajkn" => 5,
            "kuotajkn" => 30,
            "sisakuotanonjkn" => 5,
            "kuotanonjkn" => 30,
            "keterangan" => "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        return $this->bridging->postRequest($endpoint, $jsonData);
    }
    public function tambahAntreanFarmasi(AntrianFarmasi $item)
    {
        $endpoint = "antrean/farmasi/add";
        $data = [
            "kodebooking" => $item->nomor,
            "jenisresep" => $item->jenis, // (racikan / non racikan)
            "nomorantrean" => $item->number,
            "keterangan" => "testing"
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return $this->bridging->postRequest($endpoint, $jsonData);

    }
    public function updateWaktuAntrean(Request $request)
    {
        $endpoint = "antrean/updatewaktu";
        $data = [
            "kodebooking" => "16032021A001",
            "taskid" => 5,
            "waktu" => 1616559330000,
            "jenisresep" => "Tidak ada" // khusus yang sudah implementasi antrean farmasi
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return $this->bridging->postRequest($endpoint, $jsonData);

    }

    public function updateWaktuAntreanFarmasi(PasienBebas $item)
    {
        $endpoint = "antrean/updatewaktu";
        $timestamp = round(microtime(true) * 1000);
        $data = [
            "kodebooking" => $item->nomor,
            "taskid" => 7,
            "waktu" => $timestamp,
            // "jenisresep" => "Tidak ada"// khusus yang sudah implementasi antrean farmasi
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return $this->bridging->postRequest($endpoint, $jsonData);

    }
    public function batalAntrean()
    {   
        $endpoint = "antrean/batal";
        $data = [
            "kodebooking" => "16032021A001",
            "keterangan" => "Testing" 
        ];
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return $this->bridging->postRequest($endpoint, $jsonData);
    
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
