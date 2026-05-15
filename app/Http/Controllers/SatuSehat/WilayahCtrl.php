<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\SatuSehat\Bridge\BridgeMasterdata;
use PenggunaHelp;

class WilayahCtrl extends Controller
{
    private string $error = 'next';
    private int    $take  = 25;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * Dashboard statistik wilayah yang sudah di-cache.
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $counts = DB::table('satusehat_wilayah')
            ->selectRaw("level, COUNT(*) as total")
            ->groupBy('level')
            ->pluck('total', 'level')
            ->toArray();

        $lastFetch = DB::table('satusehat_wilayah')
            ->max('fetched_at');

        // Berapa pasien yang belum punya kode wilayah SatuSehat
        $missingProvince    = DB::table('pasien')->where('delete_soft', 1)->whereNull('ss_province_code')->count();
        $missingCity        = DB::table('pasien')->where('delete_soft', 1)->whereNull('ss_city_code')->count();
        $missingDistrict    = DB::table('pasien')->where('delete_soft', 1)->whereNull('ss_district_code')->count();
        $missingSubdistrict = DB::table('pasien')->where('delete_soft', 1)->whereNull('ss_subdistrict_code')->count();

        return response()->json([
            'data' => [
                'province'            => (int)($counts['province']    ?? 0),
                'city'                => (int)($counts['city']        ?? 0),
                'district'            => (int)($counts['district']    ?? 0),
                'sub_district'        => (int)($counts['sub_district'] ?? 0),
                'last_fetch'          => $lastFetch,
                'missing_province'    => $missingProvince,
                'missing_city'        => $missingCity,
                'missing_district'    => $missingDistrict,
                'missing_subdistrict' => $missingSubdistrict,
            ]
        ]);
    }

    /**
     * List wilayah dengan filter level + pencarian + paginasi.
     */
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $page        = max(1, (int)($request->page ?? 1));
        $skip        = ($page - 1) * $this->take;
        $level       = $request->level ?? 'province';  // province|city|district|sub_district
        $search      = trim($request->search ?? '');
        $parentCode  = trim($request->parent_code ?? '');

        $query = DB::table('satusehat_wilayah')->where('level', $level);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', '%' . $search . '%')
                  ->orWhere('code', 'ilike', '%' . $search . '%');
            });
        }

        if ($parentCode !== '') {
            $query->where('parent_code', $parentCode);
        }

        $total = $query->count();
        $data  = $query->orderBy('code')
                       ->skip($skip)
                       ->take($this->take)
                       ->select(['id', 'level', 'code', 'name', 'parent_code', 'fetched_at'])
                       ->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Fetch & cache wilayah dari SatuSehat Masterdata API.
     *
     * Request body:
     *   level       : 'province' | 'city' | 'district' | 'sub_district'
     *   parent_code : kode parent (wajib untuk city/district/sub_district)
     */
    public function fetch(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $level      = $request->level ?? 'province';
        $parentCode = trim($request->parent_code ?? '');

        if (in_array($level, ['city', 'district', 'sub_district']) && $parentCode === '') {
            return response()->json([
                'data'    => 'gagal',
                'message' => "Kode parent wajib diisi untuk fetch level {$level}.",
            ], 422);
        }

        try {
            $bridge = new BridgeMasterdata();
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        try {
            $items = match($level) {
                'province'     => $this->parseItems($bridge->getProvinces()),
                'city'         => $this->parseItems($bridge->getCities($parentCode)),
                'district'     => $this->parseItems($bridge->getDistricts($parentCode)),
                'sub_district' => $this->parseItems($bridge->getSubDistricts($parentCode)),
                default        => [],
            };

            if (empty($items)) {
                return response()->json([
                    'data'    => 'gagal',
                    'message' => "Tidak ada data yang dikembalikan dari SatuSehat untuk level {$level}.",
                ]);
            }

            $now    = now();
            $saved  = 0;

            foreach ($items as $item) {
                $code = $item['code'] ?? null;
                if (!$code) continue;

                DB::table('satusehat_wilayah')->upsert(
                    [
                        'level'       => $level,
                        'code'        => $code,
                        'name'        => $item['name'] ?? '',
                        'parent_code' => $parentCode ?: null,
                        'raw_data'    => json_encode($item),
                        'fetched_at'  => $now,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ],
                    ['code'],                           // unique key
                    ['name', 'parent_code', 'raw_data', 'fetched_at', 'updated_at'] // update columns
                );
                $saved++;
            }

            PenggunaHelp::log("Fetch wilayah SatuSehat [{$level}] parent={$parentCode}: {$saved} records disimpan.");

            return response()->json([
                'data'    => 'berhasil',
                'message' => "{$saved} data wilayah {$level} berhasil disimpan.",
                'count'   => $saved,
            ]);

        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Ambil daftar wilayah untuk dropdown (cascading select).
     * Digunakan di form pasien untuk pilih kode wilayah.
     */
    public function select(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $level      = $request->level ?? 'province';
        $parentCode = trim($request->parent_code ?? '');

        $query = DB::table('satusehat_wilayah')
            ->where('level', $level)
            ->select(['code', 'name']);

        if ($parentCode !== '') {
            $query->where('parent_code', $parentCode);
        }

        $data = $query->orderBy('name')->get();

        return response()->json(['data' => $data]);
    }

    /**
     * Sinkronisasi kode SatuSehat ke tabel master wilayah lokal.
     * Mencocokkan nama wilayah (case-insensitive) antara cache satusehat_wilayah
     * dan tabel provinsi / kab_kota / kecamatan / kelurahan.
     *
     * Request body:
     *   level : 'province' | 'city' | 'district' | 'sub_district'
     */
    public function syncToMaster(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $level = $request->level ?? 'province';

        // Mapping level → tabel lokal & kolom nama
        $tableMap = [
            'province'     => ['table' => 'provinsi',  'name_col' => 'nama'],
            'city'         => ['table' => 'kab_kota',  'name_col' => 'nama'],
            'district'     => ['table' => 'kecamatan', 'name_col' => 'nama'],
            'sub_district' => ['table' => 'kelurahan', 'name_col' => 'nama'],
        ];

        if (!isset($tableMap[$level])) {
            return response()->json(['data' => 'gagal', 'message' => 'Level tidak valid.'], 422);
        }

        $tbl     = $tableMap[$level]['table'];
        $nameCol = $tableMap[$level]['name_col'];

        // Ambil semua data dari cache SatuSehat untuk level ini
        $ssCodes = DB::table('satusehat_wilayah')
            ->where('level', $level)
            ->select(['code', 'name'])
            ->get()
            ->keyBy(fn($r) => strtoupper(trim($r->name)));

        if ($ssCodes->isEmpty()) {
            return response()->json([
                'data'    => 'gagal',
                'message' => "Cache SatuSehat untuk level {$level} kosong. Lakukan Fetch terlebih dahulu.",
            ]);
        }

        // Ambil semua data lokal yang belum punya SS code
        $localItems = DB::table($tbl)
            ->where('delete_soft', 1)
            ->whereNull('satusehat_code')
            ->select(['id', $nameCol . ' as nama'])
            ->get();

        $matched   = 0;
        $unmatched = [];

        foreach ($localItems as $item) {
            $normalizedName = strtoupper(trim($item->nama));

            // Coba exact match dulu
            if (isset($ssCodes[$normalizedName])) {
                DB::table($tbl)->where('id', $item->id)->update([
                    'satusehat_code' => $ssCodes[$normalizedName]->code,
                ]);
                $matched++;
                continue;
            }

            // Coba partial match (nama lokal ada di nama SS atau sebaliknya)
            $found = false;
            foreach ($ssCodes as $ssName => $ssItem) {
                if (str_contains($ssName, $normalizedName) || str_contains($normalizedName, $ssName)) {
                    DB::table($tbl)->where('id', $item->id)->update([
                        'satusehat_code' => $ssItem->code,
                    ]);
                    $matched++;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $unmatched[] = $item->nama;
            }
        }

        $unmatchedCount = count($unmatched);
        PenggunaHelp::log("Sync wilayah SatuSehat ke master [{$level}]: +{$matched} matched, {$unmatchedCount} tidak cocok.");

        return response()->json([
            'data'      => 'berhasil',
            'message'   => "{$matched} data {$level} berhasil diupdate. {$unmatchedCount} tidak cocok.",
            'matched'   => $matched,
            'unmatched' => $unmatchedCount,
            'unmatched_list' => array_slice($unmatched, 0, 20), // max 20 untuk ditampilkan
        ]);
    }

    /**
     * Statistik kode SatuSehat di tabel master wilayah lokal.
     */
    public function masterStats(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $stats = [];
        $tableMap = [
            'province'     => 'provinsi',
            'city'         => 'kab_kota',
            'district'     => 'kecamatan',
            'sub_district' => 'kelurahan',
        ];

        foreach ($tableMap as $level => $tbl) {
            $hasCol = Schema::hasColumn($tbl, 'satusehat_code');
            if ($hasCol) {
                $total   = DB::table($tbl)->where('delete_soft', 1)->count();
                $filled  = DB::table($tbl)->where('delete_soft', 1)->whereNotNull('satusehat_code')->count();
                $stats[$level] = [
                    'total'   => $total,
                    'filled'  => $filled,
                    'missing' => $total - $filled,
                    'pct'     => $total > 0 ? round(($filled / $total) * 100, 1) : 0,
                ];
            } else {
                $stats[$level] = ['total' => 0, 'filled' => 0, 'missing' => 0, 'pct' => 0];
            }
        }

        return response()->json(['data' => $stats]);
    }

    /**
     * Fetch SEMUA level wilayah sekaligus: province → city → district → [sub_district].
     *
     * Request body:
     *   with_district    : bool (default true)
     *   with_subdistrict : bool (default false)
     */
    public function fetchAll(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        @set_time_limit(600);
        @ini_set('max_execution_time', '600');

        $withDistrict    = filter_var($request->with_district    ?? 'true',  FILTER_VALIDATE_BOOLEAN);
        $withSubdistrict = filter_var($request->with_subdistrict ?? 'false', FILTER_VALIDATE_BOOLEAN);

        try {
            $bridge = new BridgeMasterdata();
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        $log   = [];
        $total = ['province' => 0, 'city' => 0, 'district' => 0, 'sub_district' => 0];
        $now   = now();

        // ── Step 1: Provinsi ──────────────────────────────────────────────
        try {
            $items = $this->parseItems($bridge->getProvinces());
            $saved = $this->upsertItems('province', null, $items, $now);
            $total['province'] = $saved;
            $log[] = "[1/4] Provinsi: {$saved} records disimpan.";
        } catch (\Throwable $e) {
            $log[] = "[1/4] GAGAL fetch Provinsi: " . $e->getMessage();
        }

        // ── Step 2: Kota/Kab per Provinsi ────────────────────────────────
        $provinceCodes = DB::table('satusehat_wilayah')
            ->where('level', 'province')->pluck('code')->toArray();

        $cityCount = 0;
        foreach ($provinceCodes as $pCode) {
            try {
                $items = $this->parseItems($bridge->getCities($pCode));
                $cityCount += $this->upsertItems('city', $pCode, $items, $now);
            } catch (\Throwable $e) {
                $log[] = "  GAGAL fetch Kota [{$pCode}]: " . $e->getMessage();
            }
        }
        $total['city'] = $cityCount;
        $log[] = "[2/4] Kota/Kab: {$cityCount} records disimpan dari " . count($provinceCodes) . " provinsi.";

        // ── Step 3: Kecamatan per Kota ────────────────────────────────────
        if ($withDistrict) {
            $cityCodes = DB::table('satusehat_wilayah')
                ->where('level', 'city')->pluck('code')->toArray();

            $districtCount = 0;
            foreach ($cityCodes as $cCode) {
                try {
                    $items = $this->parseItems($bridge->getDistricts($cCode));
                    $districtCount += $this->upsertItems('district', $cCode, $items, $now);
                } catch (\Throwable $e) {
                    $log[] = "  GAGAL fetch Kecamatan [{$cCode}]: " . $e->getMessage();
                }
            }
            $total['district'] = $districtCount;
            $log[] = "[3/4] Kecamatan: {$districtCount} records disimpan dari " . count($cityCodes) . " kota.";
        } else {
            $log[] = "[3/4] Kecamatan: dilewati (opsi dinonaktifkan).";
        }

        // ── Step 4: Kelurahan per Kecamatan ──────────────────────────────
        if ($withSubdistrict) {
            $districtCodes = DB::table('satusehat_wilayah')
                ->where('level', 'district')->pluck('code')->toArray();

            $subCount = 0;
            foreach ($districtCodes as $dCode) {
                try {
                    $items = $this->parseItems($bridge->getSubDistricts($dCode));
                    $subCount += $this->upsertItems('sub_district', $dCode, $items, $now);
                } catch (\Throwable $e) {
                    $log[] = "  GAGAL fetch Kelurahan [{$dCode}]: " . $e->getMessage();
                }
            }
            $total['sub_district'] = $subCount;
            $log[] = "[4/4] Kelurahan: {$subCount} records disimpan dari " . count($districtCodes) . " kecamatan.";
        } else {
            $log[] = "[4/4] Kelurahan: dilewati (opsi dinonaktifkan).";
        }

        $grandTotal = array_sum($total);
        PenggunaHelp::log("Fetch All Wilayah SatuSehat selesai: {$grandTotal} total records.");

        return response()->json([
            'data'    => 'berhasil',
            'message' => "Fetch selesai. Total {$grandTotal} data wilayah disimpan.",
            'total'   => $total,
            'log'     => $log,
        ]);
    }

    /**
     * Sinkronisasi SEMUA level wilayah ke tabel master lokal sekaligus.
     * Hanya mengisi record yang satusehat_code-nya masih NULL.
     */
    public function syncAllToMaster(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $tableMap = [
            'province'     => ['table' => 'provinsi',  'name_col' => 'nama'],
            'city'         => ['table' => 'kab_kota',  'name_col' => 'nama'],
            'district'     => ['table' => 'kecamatan', 'name_col' => 'nama'],
            'sub_district' => ['table' => 'kelurahan', 'name_col' => 'nama'],
        ];

        $results      = [];
        $totalMatched = 0;

        foreach ($tableMap as $level => $map) {
            $tbl     = $map['table'];
            $nameCol = $map['name_col'];

            $ssCodes = DB::table('satusehat_wilayah')
                ->where('level', $level)
                ->select(['code', 'name'])
                ->get()
                ->keyBy(fn($r) => strtoupper(trim($r->name)));

            if ($ssCodes->isEmpty()) {
                $results[$level] = ['matched' => 0, 'unmatched' => 0, 'note' => 'cache kosong'];
                continue;
            }

            $localItems = DB::table($tbl)
                ->where('delete_soft', 1)
                ->whereNull('satusehat_code')
                ->select(['id', $nameCol . ' as nama'])
                ->get();

            $matched   = 0;
            $unmatched = 0;

            foreach ($localItems as $item) {
                $normalizedName = strtoupper(trim($item->nama));

                if (isset($ssCodes[$normalizedName])) {
                    DB::table($tbl)->where('id', $item->id)
                        ->update(['satusehat_code' => $ssCodes[$normalizedName]->code]);
                    $matched++;
                    continue;
                }

                $found = false;
                foreach ($ssCodes as $ssName => $ssItem) {
                    if (str_contains($ssName, $normalizedName) || str_contains($normalizedName, $ssName)) {
                        DB::table($tbl)->where('id', $item->id)
                            ->update(['satusehat_code' => $ssItem->code]);
                        $matched++;
                        $found = true;
                        break;
                    }
                }
                if (!$found) $unmatched++;
            }

            $results[$level]  = ['matched' => $matched, 'unmatched' => $unmatched];
            $totalMatched    += $matched;
        }

        PenggunaHelp::log("Sync All Wilayah ke Master: {$totalMatched} total records diupdate.");

        return response()->json([
            'data'          => 'berhasil',
            'message'       => "Sync selesai. Total {$totalMatched} data master diupdate.",
            'total_matched' => $totalMatched,
            'results'       => $results,
        ]);
    }

    /**
     * Helper: upsert batch items ke satusehat_wilayah. Returns saved count.
     */
    private function upsertItems(string $level, ?string $parentCode, array $items, $now): int
    {
        $saved = 0;
        foreach ($items as $item) {
            $code = $item['code'] ?? null;
            if (!$code) continue;

            DB::table('satusehat_wilayah')->upsert(
                [
                    'level'       => $level,
                    'code'        => $code,
                    'name'        => $item['name'] ?? '',
                    'parent_code' => $parentCode,
                    'raw_data'    => json_encode($item),
                    'fetched_at'  => $now,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ],
                ['code'],
                ['name', 'parent_code', 'raw_data', 'fetched_at', 'updated_at']
            );
            $saved++;
        }
        return $saved;
    }

    /**
     * Parse array items dari response SatuSehat Masterdata API.
     * Response format v1: {"data": [{"code":"11","display":"ACEH"}, ...]}
     */
    private function parseItems(array $response): array
    {
        // Format v1: {data: [{code, display}]}
        $raw = $response['data'] ?? $response;

        if (!is_array($raw)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'code' => $item['code']    ?? $item['id']      ?? null,
                'name' => $item['display'] ?? $item['name']    ?? $item['nama'] ?? '',
            ];
        }, $raw);
    }
}
