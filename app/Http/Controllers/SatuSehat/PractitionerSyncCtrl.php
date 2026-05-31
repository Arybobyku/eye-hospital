<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use PenggunaHelp;

class PractitionerSyncCtrl extends Controller
{
    private string $error = 'next';

    /** Jumlah dokter per halaman list */
    private int $take = 20;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    // ── Dashboard — statistik ringkasan sync dokter ───────────────────────
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $base = DB::table('pengguna')
            ->where('delete_soft', 1)
            ->whereRaw("sebagai ILIKE '%dokter%'");

        $total    = (clone $base)->count();
        $synced   = (clone $base)->whereNotNull('satusehat_ihs_id')
                                  ->where('satusehat_sync_status', 'synced')
                                  ->count();
        $notFound = (clone $base)->where('satusehat_sync_status', 'not_found')->count();
        $failed   = (clone $base)->where('satusehat_sync_status', 'failed')->count();
        $noNik    = (clone $base)->where(function ($q) {
            $q->whereNull('nik')->orWhere('nik', '')->orWhere('nik', '-');
        })->count();
        $pending  = (clone $base)
            ->whereNull('satusehat_ihs_id')
            ->where(function ($q) {
                $q->whereNull('satusehat_sync_status')
                  ->orWhereNotIn('satusehat_sync_status', ['synced', 'not_found', 'failed']);
            })
            ->count();

        $lastSync = DB::table('pengguna')
            ->where('delete_soft', 1)
            ->whereRaw("sebagai ILIKE '%dokter%'")
            ->whereNotNull('satusehat_synced_at')
            ->orderByDesc('satusehat_synced_at')
            ->value('satusehat_synced_at');

        return response()->json([
            'data' => [
                'total'     => $total,
                'synced'    => $synced,
                'not_found' => $notFound,
                'failed'    => $failed,
                'no_nik'    => $noNik,
                'pending'   => $pending,
                'last_sync' => $lastSync,
            ]
        ]);
    }

    // ── List — tabel dokter dengan status sync ────────────────────────────
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $search = trim($request->search ?? '');
        $filter = $request->filter  ?? 'all';
        $page   = max(1, (int)($request->page ?? 1));
        $skip   = ($page - 1) * $this->take;

        $query = DB::table('pengguna')
            ->where('delete_soft', 1)
            // ->whereRaw("sebagai ILIKE '%dokter%'")
            ->select([
                'uuid', 'nama', 'nik', 'sebagai',
                'satusehat_ihs_id', 'satusehat_sync_status', 'satusehat_synced_at',
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("nama ILIKE ?", ["%{$search}%"])
                  ->orWhereRaw("nik  ILIKE ?", ["%{$search}%"]);
            });
        }

        // Filter tab
        switch ($filter) {
            case 'synced':
                $query->whereNotNull('satusehat_ihs_id')
                      ->where('satusehat_sync_status', 'synced');
                break;
            case 'not_found':
                $query->where('satusehat_sync_status', 'not_found');
                break;
            case 'failed':
                $query->where('satusehat_sync_status', 'failed');
                break;
            case 'no_nik':
                $query->where(function ($q) {
                    $q->whereNull('nik')->orWhere('nik', '')->orWhere('nik', '-');
                });
                break;
            case 'pending':
                $query->whereNull('satusehat_ihs_id')
                      ->where(function ($q) {
                          $q->whereNull('satusehat_sync_status')
                            ->orWhereNotIn('satusehat_sync_status', ['synced', 'not_found', 'failed']);
                      });
                break;
        }

        $total = (clone $query)->count();
        $data  = $query->orderBy('nama')->skip($skip)->take($this->take)->get();

        $rows = $data->map(fn($r) => [
            'uuid'               => $r->uuid,
            'nama'               => $r->nama,
            'nik'                => $r->nik         ?: '-',
            'sebagai'            => $r->sebagai     ?: '-',
            'satusehat_ihs_id'   => $r->satusehat_ihs_id    ?: null,
            'sync_status'        => $r->satusehat_sync_status ?? null,
            'synced_at'          => $r->satusehat_synced_at  ?? null,
        ])->values()->toArray();

        return response()->json(['data' => $rows, 'total' => $total]);
    }

    // ── Sync satu dokter by UUID — lookup NIK ke SatuSehat ────────────────
    public function syncOne(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = trim($request->uuid ?? '');
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID pengguna diperlukan.'], 422);
        }

        $dokter = DB::table('pengguna')
            ->where('uuid', $uuid)
            ->where('delete_soft', 1)
            ->whereRaw("sebagai ILIKE '%dokter%'")
            ->select(['uuid', 'nama', 'nik', 'sebagai'])
            ->first();

        if (!$dokter) {
            return response()->json(['data' => 'gagal', 'message' => 'Dokter tidak ditemukan.'], 404);
        }

        $nik = trim($dokter->nik ?? '');
        if (!preg_match('/^\d{16}$/', $nik)) {
            return response()->json([
                'data'    => 'gagal',
                'message' => "NIK tidak valid (harus 16 digit angka): {$nik}",
            ], 422);
        }

        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'practitioner_sync';
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        try {
            $identifier = 'https://fhir.kemkes.go.id/id/nik|' . $nik;
            $result     = $bridge->getJson('Practitioner?identifier=' . urlencode($identifier));

            $total   = $result['total']  ?? 0;
            $entries = $result['entry']  ?? [];

            if ($total > 0 && !empty($entries)) {
                $resource = $entries[0]['resource'] ?? [];
                $ihsId    = $resource['id'] ?? null;

                if ($ihsId) {
                    DB::table('pengguna')->where('uuid', $uuid)->update([
                        'satusehat_ihs_id'      => $ihsId,
                        'satusehat_sync_status' => 'synced',
                        'satusehat_synced_at'   => now(),
                    ]);

                    PenggunaHelp::log("Sync Practitioner SatuSehat [{$dokter->nama}]: {$ihsId}");

                    return response()->json([
                        'data'    => 'berhasil',
                        'ihs_id'  => $ihsId,
                        'message' => "Practitioner ditemukan. IHS ID: {$ihsId}",
                        'resource'=> $this->flattenResource($resource),
                    ]);
                }
            }

            // Tidak ditemukan
            DB::table('pengguna')->where('uuid', $uuid)->update([
                'satusehat_sync_status' => 'not_found',
                'satusehat_synced_at'   => now(),
            ]);

            return response()->json([
                'data'    => 'not_found',
                'message' => "Practitioner dengan NIK {$nik} tidak ditemukan di SatuSehat.",
            ]);

        } catch (\Throwable $e) {
            DB::table('pengguna')->where('uuid', $uuid)->update([
                'satusehat_sync_status' => 'failed',
            ]);

            return response()->json([
                'data'    => 'gagal',
                'message' => 'Error saat memanggil SatuSehat API: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Sync bulk — semua dokter yang belum punya IHS ID dan punya NIK ────
    public function syncBulk(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $batch = max(1, min(100, (int)($request->batch ?? 20)));

        $candidates = DB::table('pengguna')
            ->where('delete_soft', 1)
            ->whereRaw("sebagai ILIKE '%dokter%'")
            ->whereNull('satusehat_ihs_id')
            ->whereNotNull('nik')
            ->where('nik', '!=', '')
            ->where('nik', '!=', '-')
            ->whereRaw("nik ~ '^[0-9]{16}$'")
            ->where(function ($q) {
                $q->whereNull('satusehat_sync_status')
                  ->orWhere('satusehat_sync_status', 'failed')
                  ->orWhereNotIn('satusehat_sync_status', ['synced', 'not_found']);
            })
            ->select(['uuid', 'nama', 'nik'])
            ->orderBy('nama')
            ->limit($batch)
            ->get();

        if ($candidates->isEmpty()) {
            // Cek apakah memang tidak ada dokter belum-sync atau semua tidak punya NIK valid
            $totalBelumSync = DB::table('pengguna')
                ->where('delete_soft', 1)
                ->whereRaw("sebagai ILIKE '%dokter%'")
                ->whereNull('satusehat_ihs_id')
                ->count();

            $msg = $totalBelumSync === 0
                ? 'Semua dokter sudah memiliki IHS ID SatuSehat.'
                : 'Tidak ada dokter yang bisa di-sync: pastikan NIK (16 digit) sudah diisi.';

            return response()->json(['data' => 'kosong', 'message' => $msg]);
        }

        try {
            $bridge = new BridgeBase();
            $bridge->logContext = 'practitioner_sync_bulk';
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        $synced   = 0;
        $notFound = 0;
        $failed   = 0;
        $log      = [];

        foreach ($candidates as $dokter) {
            try {
                $identifier = 'https://fhir.kemkes.go.id/id/nik|' . $dokter->nik;
                $result     = $bridge->getJson('Practitioner?identifier=' . urlencode($identifier));

                $total   = $result['total']  ?? 0;
                $entries = $result['entry']  ?? [];

                if ($total > 0 && !empty($entries)) {
                    $resource = $entries[0]['resource'] ?? [];
                    $ihsId    = $resource['id'] ?? null;

                    if ($ihsId) {
                        DB::table('pengguna')->where('uuid', $dokter->uuid)->update([
                            'satusehat_ihs_id'      => $ihsId,
                            'satusehat_sync_status' => 'synced',
                            'satusehat_synced_at'   => now(),
                        ]);
                        $synced++;
                        $log[] = "[OK] {$dokter->nama} → {$ihsId}";
                        continue;
                    }
                }

                // Tidak ditemukan
                DB::table('pengguna')->where('uuid', $dokter->uuid)->update([
                    'satusehat_sync_status' => 'not_found',
                    'satusehat_synced_at'   => now(),
                ]);
                $notFound++;
                $log[] = "[NOT FOUND] {$dokter->nama} (NIK: {$dokter->nik})";

            } catch (\Throwable $e) {
                DB::table('pengguna')->where('uuid', $dokter->uuid)->update([
                    'satusehat_sync_status' => 'failed',
                ]);
                $failed++;
                $log[] = "[FAIL] {$dokter->nama}: " . $e->getMessage();
            }
        }

        PenggunaHelp::log("Sync Bulk Practitioner SatuSehat: {$synced} berhasil, {$notFound} tidak ditemukan, {$failed} gagal");

        return response()->json([
            'data'      => 'selesai',
            'synced'    => $synced,
            'not_found' => $notFound,
            'failed'    => $failed,
            'processed' => $candidates->count(),
            'message'   => "{$synced} berhasil, {$notFound} tidak ditemukan, {$failed} gagal dari {$candidates->count()} dokter.",
            'output'    => implode("\n", $log),
        ]);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Flatten FHIR Practitioner resource menjadi array ringkas.
     */
    private function flattenResource(array $res): array
    {
        $name    = collect($res['name'] ?? [])->firstWhere('use', 'official');
        $ihsNum  = collect($res['identifier'] ?? [])
            ->first(fn($i) => str_contains($i['system'] ?? '', 'nakes-his-number'));
        $nikId   = collect($res['identifier'] ?? [])
            ->first(fn($i) => str_contains($i['system'] ?? '', '/nik'));

        $qual    = $res['qualification'][0] ?? [];
        $qualCode = $qual['code']['coding'][0]['code'] ?? '';
        $qualDisp = $qual['code']['coding'][0]['display'] ?? '';
        $strNum   = $qual['identifier'][0]['value'] ?? '';

        return [
            'ihs_id'        => $res['id']          ?? '',
            'nama'          => $name['text']        ?? '',
            'nik'           => $nikId['value']      ?? '',
            'ihs_number'    => $ihsNum['value']     ?? '',
            'gender'        => $res['gender']       ?? '',
            'birth_date'    => $res['birthDate']    ?? '',
            'qual_code'     => $qualCode,
            'qual_display'  => $qualDisp,
            'str_number'    => $strNum,
            'last_updated'  => $res['meta']['lastUpdated'] ?? '',
        ];
    }
}
