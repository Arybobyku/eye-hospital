<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * SatuSehatLocationResolver
 *
 * Menyediakan lookup SatuSehat Location ID dari tabel satusehat_locations.
 * Semua hasil di-cache 24 jam agar tidak query DB setiap kali pasien masuk ruangan.
 *
 * Cara pakai:
 *   // Lookup generik berdasarkan keyword (alias atau nama)
 *   $locationId = SatuSehatLocationResolver::resolve('Front Office');
 *
 *   // Lookup khusus RO
 *   $roId = SatuSehatLocationResolver::resolveRo();
 *
 *   // Lookup Poli berdasarkan nama poli dari registrasi.ruang_poliklinik
 *   $poliId = SatuSehatLocationResolver::resolvePoli('Poli Mata');
 *
 * Invalidasi cache (jika Location di SatuSehat berubah):
 *   php artisan cache:clear
 */
class SatuSehatLocationResolver
{
    /**
     * Lookup SatuSehat Location ID berdasarkan keyword.
     * Cocokkan ke kolom `alias` dan `nama` di tabel satusehat_locations.
     * Hasil di-cache selama 24 jam.
     *
     * @param  string $keyword  Kata kunci pencarian (alias atau nama partial)
     * @return string|null      satusehat_id (FHIR Location.id), atau null jika tidak ditemukan
     */
    public static function resolve(string $keyword): ?string
    {
        if (empty(trim($keyword))) {
            return null;
        }

        $cacheKey = 'satusehat_loc_' . md5(strtolower(trim($keyword)));

        return Cache::remember($cacheKey, 86400, function () use ($keyword) {
            $loc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->where(function ($q) use ($keyword) {
                    $q->where('alias', 'ilike', '%' . $keyword . '%')
                      ->orWhere('nama',  'ilike', '%' . $keyword . '%');
                })
                ->select('satusehat_id')
                ->first();

            return $loc?->satusehat_id ?? null;
        });
    }

    /**
     * Lookup Location ID untuk ruang Front Office (pendaftaran).
     * Prioritas: "Front Office Lantai 1" → "Front Office" → nama mengandung "Front Office".
     *
     * @return string|null
     */
    public static function resolveFrontOffice(): ?string
    {
        return Cache::remember('satusehat_loc_front_office', 86400, function () {
            $loc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->where('alias', 'ilike', '%Front Office%')
                      ->orWhere('nama',  'ilike', '%Front Office%');
                })
                ->orderByRaw("CASE WHEN alias ilike '%Lantai 1%' OR nama ilike '%Lantai 1%' THEN 0 ELSE 1 END")
                ->select('satusehat_id')
                ->first();

            return $loc?->satusehat_id ?? null;
        });
    }

    /**
     * Lookup Location ID untuk ruang Refraksi Optisi (RO).
     *
     * @return string|null
     */
    public static function resolveRo(): ?string
    {
        return Cache::remember('satusehat_loc_ro', 86400, function () {
            $loc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->where('alias', 'ilike', '%Refraksi Optisi%')
                      ->orWhere('alias', 'ilike', '%Refraksi%')
                      ->orWhere('nama',  'ilike', '%Refraksi Optisi%')
                      ->orWhere('nama',  'ilike', '%Refraksi%');
                })
                ->orderByRaw("CASE WHEN alias ilike '%Refraksi Optisi%' OR nama ilike '%Refraksi Optisi%' THEN 0 ELSE 1 END")
                ->select('satusehat_id')
                ->first();

            return $loc?->satusehat_id ?? null;
        });
    }

    /**
     * Lookup Location ID untuk poli dokter berdasarkan nama poli dari registrasi.ruang_poliklinik.
     * Contoh: "Poli Mata" → cari alias/nama yang mengandung "Poli Mata".
     *
     * @param  string $poliName  Nilai dari registrasi.ruang_poliklinik
     * @return string|null
     */
    public static function resolvePoli(string $poliName): ?string
    {
        if (empty(trim($poliName)) || $poliName === '-' || $poliName === '0') {
            return null;
        }

        $cacheKey = 'satusehat_loc_poli_' . md5(strtolower(trim($poliName)));

        return Cache::remember($cacheKey, 86400, function () use ($poliName) {
            $loc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->where(function ($q) use ($poliName) {
                    $q->where('alias', 'ilike', '%' . $poliName . '%')
                      ->orWhere('nama',  'ilike', '%' . $poliName . '%');
                })
                ->select('satusehat_id')
                ->first();

            return $loc?->satusehat_id ?? null;
        });
    }
}
