<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\Facades\DB;

/**
 * PatientBuilder — satu-satunya tempat untuk build FHIR Patient payload.
 *
 * Dipakai oleh:
 *   - App\Http\Controllers\SatuSehat\PatientSyncCtrl  (createOne / createBulk via HTTP)
 *   - App\Jobs\SyncPasienToSatuSehat                  (auto-sync saat pasien baru dibuat)
 *   - App\Console\Commands\SyncPatientSatuSehat        (batch via Artisan — jika perlu POST)
 *
 * Perubahan format payload cukup dilakukan di sini.
 */
class PatientBuilder
{
    // ── FHIR code system URLs ─────────────────────────────────────────────────
    private const NIK_SYSTEM     = 'https://fhir.kemkes.go.id/id/nik';
    private const NIK_IBU_SYSTEM = 'https://fhir.kemkes.go.id/id/nik-ibu';
    private const PROFILE_URL    = 'https://fhir.kemkes.go.id/r4/StructureDefinition/Patient';
    private const ADMIN_CODE_URL = 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode';
    private const MARITAL_SYSTEM = 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus';
    private const LANG_SYSTEM    = 'urn:ietf:bcp:47';

    /**
     * Build FHIR Patient resource payload dari satu baris data pasien.
     *
     * @param  object $pasien  Baris pasien — harus memiliki field:
     *                         nama, no_identitas, jenis_kelamin, tanggal_lahir,
     *                         alamat, nama_kab_kota, kodepos, no_handphone,
     *                         status_pernikahan, nama_provinsi, nama_kecamatan, nama_kelurahan,
     *                         rt_rw, provinsi_id, kab_kota_id, kecamatan_id, kelurahan_id
     * @param  string $method  'nik' (default) atau 'nik_ibu'
     * @return array           FHIR Patient payload siap di-POST ke API
     */
    public static function build(object $pasien, string $method = 'nik'): array
    {
        $nik    = trim($pasien->no_identitas ?? '');
        $system = $method === 'nik_ibu' ? self::NIK_IBU_SYSTEM : self::NIK_SYSTEM;

        // ── Gender ────────────────────────────────────────────────────────
        $genderRaw = strtolower(trim($pasien->jenis_kelamin ?? ''));
        $gender = match(true) {
            in_array($genderRaw, ['laki-laki', 'laki laki', 'l', 'male']) => 'male',
            in_array($genderRaw, ['perempuan', 'p', 'female', 'wanita'])  => 'female',
            default                                                         => 'unknown',
        };

        // ── Marital status ────────────────────────────────────────────────
        $maritalRaw  = strtolower(trim($pasien->status_pernikahan ?? ''));
        $maritalCode = match(true) {
            str_contains($maritalRaw, 'menikah') && !str_contains($maritalRaw, 'belum') && !str_contains($maritalRaw, 'cerai') => 'M',
            str_contains($maritalRaw, 'belum')  => 'U',
            str_contains($maritalRaw, 'hidup')  => 'D',
            str_contains($maritalRaw, 'mati')   => 'W',
            default                             => 'U',
        };
        $maritalDisplay = ['M' => 'Married', 'U' => 'Unmarried', 'D' => 'Divorced', 'W' => 'Widowed'][$maritalCode] ?? 'Unmarried';

        // ── Payload dasar ─────────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Patient',
            'meta'         => ['profile' => [self::PROFILE_URL]],
            'identifier'   => [[
                'use'    => 'official',
                'system' => $system,
                'value'  => $nik,
            ]],
            'active'              => true,
            'name'                => [['use' => 'official', 'text' => strtoupper($pasien->nama ?? '')]],
            'gender'              => $gender,
            'birthDate'           => $pasien->tanggal_lahir ?? null,
            'deceasedBoolean'     => false,
            'maritalStatus'       => [
                'coding' => [[
                    'system'  => self::MARITAL_SYSTEM,
                    'code'    => $maritalCode,
                    'display' => $maritalDisplay,
                ]],
                'text' => $maritalDisplay,
            ],
            'multipleBirthInteger' => 0,
            'communication'       => [[
                'language' => [
                    'coding' => [[
                        'system'  => self::LANG_SYSTEM,
                        'code'    => 'id-ID',
                        'display' => 'Indonesian',
                    ]],
                    'text' => 'Indonesian',
                ],
                'preferred' => true,
            ]],
        ];

        // ── Telecom ───────────────────────────────────────────────────────
        $hp = trim($pasien->no_handphone ?? '');
        if ($hp && $hp !== '-') {
            $payload['telecom'] = [['system' => 'phone', 'value' => $hp, 'use' => 'mobile']];
        }

        // ── Address + BPS administrativeCode ─────────────────────────────
        $alamat = trim($pasien->alamat ?? '');
        if ($alamat && $alamat !== '-') {
            $payload['address'] = [[
                'use'        => 'home',
                'line'       => [$alamat],
                'city'       => $pasien->nama_kab_kota ?? '',
                'postalCode' => $pasien->kodepos ?? '',
                'country'    => 'ID',
            ]];

            // Kode BPS dari tabel master wilayah via FK
            $provinceCode    = '';
            $cityCode        = '';
            $districtCode    = '';
            $subdistrictCode = '';

            if (!empty($pasien->provinsi_id)) {
                $provinceCode = (string)(DB::table('provinsi')
                    ->where('id', $pasien->provinsi_id)->value('satusehat_code') ?? '');
            }
            if (!empty($pasien->kab_kota_id)) {
                $cityCode = (string)(DB::table('kab_kota')
                    ->where('id', $pasien->kab_kota_id)->value('satusehat_code') ?? '');
            }
            if (!empty($pasien->kecamatan_id)) {
                $districtCode = (string)(DB::table('kecamatan')
                    ->where('id', $pasien->kecamatan_id)->value('satusehat_code') ?? '');
            }
            if (!empty($pasien->kelurahan_id)) {
                $subdistrictCode = (string)(DB::table('kelurahan')
                    ->where('id', $pasien->kelurahan_id)->value('satusehat_code') ?? '');
            }

            // Validasi hierarki BPS (Rule 10621–10623 SatuSehat)
            if ($cityCode && $provinceCode && !str_starts_with($cityCode, $provinceCode)) {
                $cityCode = $districtCode = $subdistrictCode = '';
            }
            if ($districtCode && $cityCode && !str_starts_with($districtCode, $cityCode)) {
                $districtCode = $subdistrictCode = '';
            }
            if ($subdistrictCode && $districtCode && !str_starts_with($subdistrictCode, $districtCode)) {
                $subdistrictCode = '';
            }

            // Sertakan extension hanya jika minimal province + city tersedia
            if ($provinceCode && $cityCode) {
                $adminExt = [
                    ['url' => 'province', 'valueCode' => $provinceCode],
                    ['url' => 'city',     'valueCode' => $cityCode],
                ];
                if ($districtCode)    $adminExt[] = ['url' => 'district', 'valueCode' => $districtCode];
                if ($subdistrictCode) $adminExt[] = ['url' => 'village',  'valueCode' => $subdistrictCode];

                $payload['address'][0]['extension'] = [[
                    'url'       => self::ADMIN_CODE_URL,
                    'extension' => $adminExt,
                ]];
            }
        }

        return $payload;
    }
}
