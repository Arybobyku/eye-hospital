<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Services\Satusehat\FHIR\Location;
use App\Services\Satusehat\FHIR\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Satusehat\FHIR\Patient;
use App\Services\Satusehat\FHIR\Practitioner;
use App\Services\Satusehat\OAuth2Client;

class SatuSehatPatientController extends Controller
{
    var $client;

    public function __construct()
    {
        $this->client = new OAuth2Client();
    }

    public function setPatient($id)
    {
        try {
            $pasien = Pasien::where('uuid', '=', $id)->first();
            $patient = new Patient();
            $jenisIdentitas = '';
            if ($pasien->jenis_identitas == 'KTP') {
                $jenisIdentitas = 'nik';
            }
            $patient->addIdentifier($jenisIdentitas, $pasien->no_identitas);
            $patient->setAddress([
                'address' => $pasien->alamat,
                'city' => $pasien->nama_kab_kota,
                'postalCode' => $pasien->kodepos,
                'country' =>  'INDONESIA',
                'city' =>  $pasien->nama_kab_kota,
                'provinceCode' =>  $pasien->provinsi_id,
                'cityCode' =>  $pasien->kab_kota_id,
                'districtCode' =>  $pasien->kecamatan_id,
                'villageCode' =>  $pasien->kelurahan_id,
                'rt' =>  $pasien->rt_rw,
                'rw' =>  $pasien->rt_rw,
            ]);
            $patient->setGender($pasien->jenis_kelamin);
            $patient->addTelecom($pasien->no_handphone, 'phone', 'mobile');
            $patient->setMultipleBirth(1);
            $patient->setBirthDate($pasien->tanggal_lahir);
            $patient->setName($pasien->nama);

            return $patient->json();
            $result = $patient->post();
            return $result;
        } catch (\Exception $err) {
            Log::error('Error registering patient: ' . $err->getMessage());

            return response()->json([
                'error' => $err->getMessage(), // Include the error message
                'trace' => $err->getTraceAsString() // Optionally include the stack trace
            ], 500);
        }
    }

    public function getPatient($id)
    {
        try {
            $result = $this->client->get_by_id('Patient', $id);
            return $result;
        } catch (\Exception $err) {
            Log::error('Error registering patient: ' . $err->getMessage());

            return response()->json([
                'error' => $err->getMessage(), // Include the error message
                'trace' => $err->getTraceAsString() // Optionally include the stack trace
            ], 500);
        }
    }

    public function setPraktisi()
    {
    }

    public function getPraktisi(Request $request)
    {
        try {
            $praktisi = new Practitioner();
            $nik = $request->query('nik');
            if ($nik) {
                return $praktisi->getSSNik($nik);
            }
            return $request;
        } catch (\Exception $err) {
            Log::error('Error registering patient: ' . $err->getMessage());

            return response()->json([
                'error' => $err->getMessage(), // Include the error message
                'trace' => $err->getTraceAsString() // Optionally include the stack trace
            ], 500);
        }
    }

    public function setOrganisasi()
    {
        $organisasi = new Organization();
        // SET INDETIFIER
        $organisasi->addIdentifier('SO00001');
        $organisasi->setName('RUMAH SAKIT MATA PRIMA VISION');
        return $organisasi->json();
    }

    public function getOrganisasi()
    {
        $organisasi = new Organization();
        $organisasi->addIdentifier('');
    }

    public function setLocation()
    {
        try {
            $location = new Location();
            $location->addIdentifier('{kode_unik_lokasi}'); // unique string free text (increments / UUID / inisial)
            $location->setName('{nama_lokasi}'); // string free text
            $location->addPhysicalType('{tipe_lokasi}'); // ro = ruangan, bu = bangunan, wi = sayap gedung, ve = kendaraan, ho = rumah, ca = kabined, rd = jalan, area = area. Default bila tidak dideklarasikan = ruangan
            $location->json();
        } catch (\Exception $err) {
            Log::error('Error registering patient: ' . $err->getMessage());

            return response()->json([
                'error' => $err->getMessage(), // Include the error message
                'trace' => $err->getTraceAsString() // Optionally include the stack trace
            ], 500);
        }
    }
}
