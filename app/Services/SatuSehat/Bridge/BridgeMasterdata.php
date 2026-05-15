<?php

namespace App\Services\SatuSehat\Bridge;

/**
 * Bridge untuk SatuSehat Masterdata API.
 * Endpoint: /masterdata/v1/
 *
 * Digunakan untuk fetch data wilayah (provinsi, kota, kecamatan, kelurahan).
 */
class BridgeMasterdata extends BridgeBase
{
    public function __construct()
    {
        parent::__construct();
        $this->logContext    = 'wilayah';
    }

    protected function baseUrl(): string
    {
        return $this->config->getUrlMasterdata();
    }

    // ── Masterdata Endpoints ──────────────────────────────────────────

    /**
     * Ambil semua provinsi.
     * GET /masterdata/v1/provinces
     */
    public function getProvinces(): array
    {
        return $this->getJson('provinces');
    }

    /**
     * Ambil kota/kabupaten berdasarkan kode provinsi.
     * GET /masterdata/v1/cities?province_codes=XX
     */
    public function getCities(string $provinceCode): array
    {
        return $this->getJson('cities?province_codes=' . urlencode($provinceCode));
    }

    /**
     * Ambil kecamatan berdasarkan kode kota.
     * GET /masterdata/v1/districts?city_codes=XXXX
     */
    public function getDistricts(string $cityCode): array
    {
        return $this->getJson('districts?city_codes=' . urlencode($cityCode));
    }

    /**
     * Ambil kelurahan/desa berdasarkan kode kecamatan.
     * GET /masterdata/v1/sub-districts?district_codes=XXXXXX
     */
    public function getSubDistricts(string $districtCode): array
    {
        return $this->getJson('sub-districts?district_codes=' . urlencode($districtCode));
    }

    /**
     * Ambil data dengan paginasi v2.
     * GET /masterdata/v2/{resource}?current_page=N
     */
    public function getPaginated(string $resource, int $page = 1): array
    {
        // Override base URL ke v2 untuk resource ini
        $v2Url = str_replace('/v1/', '/v2/', $this->baseUrl());
        $raw   = $this->request($v2Url . $resource . '?current_page=' . $page, 'GET', '', $this->accessToken);
        return json_decode($raw, true) ?? [];
    }
}
