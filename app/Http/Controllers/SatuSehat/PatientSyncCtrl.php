<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Pasien;
use PenggunaHelp;

class PatientSyncCtrl extends Controller
{
    private string $error = 'next';
    private int    $take  = 20;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * Dashboard — statistik ringkasan sync pasien.
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $base = Pasien::where('delete_soft', 1);

        $total   = (clone $base)->count();
        $synced  = (clone $base)->where('satusehat_sync_status', 'synced')->count();
        $notFound= (clone $base)->where('satusehat_sync_status', 'not_found')->count();
        $failed  = (clone $base)->where('satusehat_sync_status', 'failed')->count();
        $pending = (clone $base)
            ->whereNull('id_satu_sehat')
            ->where(function ($q) {
                // NULL tidak tertangkap whereNotIn di PostgreSQL — harus eksplisit
                $q->whereNull('satusehat_sync_status')
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('satusehat_sync_status')
                         ->whereNotIn('satusehat_sync_status', ['synced', 'not_found', 'failed']);
                  });
            })
            ->count();

        // Waktu sync terakhir
        $lastSync = Pasien::where('delete_soft', 1)
            ->whereNotNull('satusehat_synced_at')
            ->orderByDesc('satusehat_synced_at')
            ->value('satusehat_synced_at');

        /**
         * Pasien yang TIDAK memiliki kode wilayah BPS minimal (province + city).
         * Dihitung via LEFT JOIN ke tabel master wilayah.
         * Pasien ini akan dikirim ke SatuSehat tanpa extension administrativeCode.
         */
        $noAreaCode = DB::table('pasien')
            ->leftJoin('provinsi', 'pasien.provinsi_id', '=', 'provinsi.id')
            ->leftJoin('kab_kota', 'pasien.kab_kota_id', '=', 'kab_kota.id')
            ->where('pasien.delete_soft', 1)
            ->where(function ($q) {
                $q->whereNull('provinsi.satusehat_code')
                  ->orWhereNull('kab_kota.satusehat_code');
            })
            ->count();

        /**
         * Pasien dengan semua 4 level kode wilayah BPS terisi (via master wilayah).
         * Province, city, district, village: semua dari relasi FK ke tabel master.
         */
        $wilayahComplete = DB::table('pasien')
            ->leftJoin('provinsi',  'pasien.provinsi_id',  '=', 'provinsi.id')
            ->leftJoin('kab_kota',  'pasien.kab_kota_id',  '=', 'kab_kota.id')
            ->leftJoin('kecamatan', 'pasien.kecamatan_id', '=', 'kecamatan.id')
            ->leftJoin('kelurahan', 'pasien.kelurahan_id', '=', 'kelurahan.id')
            ->where('pasien.delete_soft', 1)
            ->whereNotNull('provinsi.satusehat_code')
            ->whereNotNull('kab_kota.satusehat_code')
            ->whereNotNull('kecamatan.satusehat_code')
            ->whereNotNull('kelurahan.satusehat_code')
            ->count();

        return response()->json([
            'data' => [
                'total'            => $total,
                'synced'           => $synced,
                'not_found'        => $notFound,
                'failed'           => $failed,
                'pending'          => $pending,
                'no_area_code'     => $noAreaCode,
                'wilayah_complete' => $wilayahComplete,
                'last_sync'        => $lastSync,
                'pct_synced'       => $total > 0 ? round(($synced / $total) * 100, 1) : 0,
            ]
        ]);
    }

    /**
     * List pasien dengan filter status sync (paginasi).
     */
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $page   = max(1, (int)($request->page ?? 1));
        $skip   = ($page - 1) * $this->take;
        $status = $request->status ?? 'all';
        $search = trim($request->search ?? '');

        $query = Pasien::from('pasien')
            ->where('pasien.delete_soft', 1)
            ->leftJoin('provinsi',  'pasien.provinsi_id',  '=', 'provinsi.id')
            ->leftJoin('kab_kota',  'pasien.kab_kota_id',  '=', 'kab_kota.id')
            ->leftJoin('kecamatan', 'pasien.kecamatan_id', '=', 'kecamatan.id')
            ->leftJoin('kelurahan', 'pasien.kelurahan_id', '=', 'kelurahan.id')
            ->select([
                'pasien.id', 'pasien.uuid', 'pasien.rekam_medis',
                'pasien.nama', 'pasien.no_identitas', 'pasien.jenis_identitas',
                'pasien.id_satu_sehat', 'pasien.satusehat_sync_status', 'pasien.satusehat_synced_at',
                // Nama wilayah untuk label
                'pasien.nama_provinsi', 'pasien.nama_kab_kota', 'pasien.nama_kecamatan', 'pasien.nama_kelurahan',
                // Kode BPS dari tabel master wilayah (via FK)
                DB::raw("provinsi.satusehat_code  AS master_province_code"),
                DB::raw("kab_kota.satusehat_code  AS master_city_code"),
                DB::raw("kecamatan.satusehat_code AS master_district_code"),
                DB::raw("kelurahan.satusehat_code AS master_subdistrict_code"),
                // Ringkasan: apakah minimal province+city tersedia?
                DB::raw("
                    CASE WHEN
                        provinsi.satusehat_code IS NOT NULL
                        AND kab_kota.satusehat_code IS NOT NULL
                    THEN true ELSE false END AS has_area_code
                "),
            ]);

        // Filter status
        if ($status === 'synced') {
            $query->where('satusehat_sync_status', 'synced');
        } elseif ($status === 'not_found') {
            $query->where('satusehat_sync_status', 'not_found');
        } elseif ($status === 'failed') {
            $query->where('satusehat_sync_status', 'failed');
        } elseif ($status === 'pending') {
            $query->whereNull('id_satu_sehat')
                  ->where(function ($q) {
                      $q->whereNull('satusehat_sync_status')
                        ->orWhere(function ($q2) {
                            $q2->whereNotNull('satusehat_sync_status')
                               ->whereNotIn('satusehat_sync_status', ['synced', 'not_found', 'failed']);
                        });
                  });
        } elseif ($status === 'no_area_code') {
            // Pasien yang tidak punya kode wilayah BPS (province atau city) di master data
            $query->where(function ($q) {
                $q->whereNull('provinsi.satusehat_code')
                  ->orWhereNull('kab_kota.satusehat_code');
            });
        } elseif ($status === 'wilayah_complete') {
            // Pasien dengan semua 4 level kode wilayah BPS terisi dari master data
            $query->whereNotNull('provinsi.satusehat_code')
                  ->whereNotNull('kab_kota.satusehat_code')
                  ->whereNotNull('kecamatan.satusehat_code')
                  ->whereNotNull('kelurahan.satusehat_code');
        }

        // Filter pencarian
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama',          'ilike', '%' . $search . '%')
                  ->orWhere('rekam_medis', 'ilike', '%' . $search . '%')
                  ->orWhere('no_identitas','ilike', '%' . $search . '%')
                  ->orWhere('id_satu_sehat','ilike', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $data  = $query->orderByDesc('satusehat_synced_at')
                       ->orderByDesc('id')
                       ->skip($skip)
                       ->take($this->take)
                       ->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Jalankan sync manual via HTTP — memanggil Artisan command secara sinkron.
     */
    public function runSync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $pendingBefore = Pasien::where('delete_soft', 1)
            ->whereNull('id_satu_sehat')
            ->where(function ($q) {
                $q->whereNull('satusehat_sync_status')
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('satusehat_sync_status')
                         ->whereNotIn('satusehat_sync_status', ['synced', 'not_found']);
                  });
            })
            ->count();

        if ($pendingBefore === 0) {
            return response()->json([
                'data'      => 'berhasil',
                'message'   => 'Tidak ada pasien yang perlu disync.',
                'synced'    => 0,
                'not_found' => 0,
                'failed'    => 0,
                'output'    => '',
            ]);
        }

        $batch = min((int)($request->batch ?? 30), 100);

        try {
            $syncedBefore   = Pasien::where('satusehat_sync_status', 'synced')->count();
            $notFoundBefore = Pasien::where('satusehat_sync_status', 'not_found')->count();
            $failedBefore   = Pasien::where('satusehat_sync_status', 'failed')->count();

            $exitCode = Artisan::call('satusehat:sync-patient', [
                '--batch' => $batch,
                '--delay' => 200,
            ]);

            $output = Artisan::output();

            $syncedAfter   = Pasien::where('satusehat_sync_status', 'synced')->count();
            $notFoundAfter = Pasien::where('satusehat_sync_status', 'not_found')->count();
            $failedAfter   = Pasien::where('satusehat_sync_status', 'failed')->count();

            $deltaSync     = $syncedAfter   - $syncedBefore;
            $deltaNotFound = $notFoundAfter - $notFoundBefore;
            $deltaFailed   = $failedAfter   - $failedBefore;

            PenggunaHelp::log("Trigger manual sync SatuSehat: +{$deltaSync} synced, +{$deltaNotFound} not_found, +{$deltaFailed} failed");

            return response()->json([
                'data'      => $exitCode === 0 ? 'berhasil' : 'gagal',
                'message'   => "Diproses {$batch} pasien per batch.",
                'synced'    => $deltaSync,
                'not_found' => $deltaNotFound,
                'failed'    => $deltaFailed,
                'output'    => trim($output),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data'    => 'gagal',
                'message' => $e->getMessage(),
                'output'  => '',
            ], 500);
        }
    }

    /**
     * Create satu pasien ke SatuSehat (POST Patient).
     * Digunakan untuk per-row action di UI.
     */
    public function createOne(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid   = $request->uuid;
        $method = $request->method ?? 'nik';

        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID pasien diperlukan.'], 422);
        }

        $pasien = Pasien::where('uuid', $uuid)->where('delete_soft', 1)
            ->select(['id', 'uuid', 'nama', 'no_identitas', 'jenis_kelamin', 'tanggal_lahir',
                      'alamat', 'nama_kab_kota', 'kodepos', 'no_handphone',
                      'status_pernikahan', 'nama_provinsi', 'nama_kecamatan', 'nama_kelurahan',
                      'rt_rw',
                      // FK ke tabel master wilayah
                      'provinsi_id', 'kab_kota_id', 'kecamatan_id', 'kelurahan_id'])
            ->first();

        if (!$pasien) {
            return response()->json(['data' => 'gagal', 'message' => 'Pasien tidak ditemukan.'], 404);
        }

        $nik = trim($pasien->no_identitas ?? '');
        if (!preg_match('/^\d{16}$/', $nik)) {
            return response()->json([
                'data'    => 'gagal',
                'message' => "NIK tidak valid (harus 16 digit angka): {$nik}",
            ], 422);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'patient_sync';
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        try {
            $payload = $this->buildPatientPayload($pasien, $method);
            $result  = $bridge->postJson('Patient', $payload);

            $ihsId = $result['id'] ?? null;

            if ($ihsId) {
                DB::table('pasien')->where('uuid', $uuid)->update([
                    'id_satu_sehat'         => $ihsId,
                    'satusehat_sync_status' => 'synced',
                    'satusehat_synced_at'   => now(),
                ]);

                PenggunaHelp::log("Create Patient SatuSehat [{$pasien->nama}]: {$ihsId}");

                return response()->json([
                    'data'          => 'berhasil',
                    'id_satu_sehat' => $ihsId,
                    'message'       => "Pasien berhasil didaftarkan. IHS ID: {$ihsId}",
                ]);
            }

            // SatuSehat mengembalikan error
            $issue   = $result['issue'][0] ?? [];
            $errCode = $issue['details']['coding'][0]['code'] ?? ($issue['code'] ?? '');
            $errMsg  = $issue['diagnostics'] ?? json_encode($result);

            // Cek duplikat — pasien sudah ada di SatuSehat
            if (stripos($errMsg, 'duplicate') !== false || stripos($errCode, 'duplicate') !== false) {
                $existing   = $bridge->getJson('Patient?identifier=' . urlencode('https://fhir.kemkes.go.id/id/nik|' . $nik));
                $existingId = $existing['entry'][0]['resource']['id'] ?? null;
                if ($existingId) {
                    DB::table('pasien')->where('uuid', $uuid)->update([
                        'id_satu_sehat'         => $existingId,
                        'satusehat_sync_status' => 'synced',
                        'satusehat_synced_at'   => now(),
                    ]);
                    return response()->json([
                        'data'          => 'berhasil',
                        'id_satu_sehat' => $existingId,
                        'message'       => "Pasien sudah terdaftar (duplikat). IHS ID diambil: {$existingId}",
                    ]);
                }
            }

            DB::table('pasien')->where('uuid', $uuid)->update(['satusehat_sync_status' => 'failed']);

            return response()->json(['data' => 'gagal', 'message' => $errMsg, 'detail' => $result], 422);

        } catch (\Throwable $e) {
            DB::table('pasien')->where('uuid', $uuid)->update(['satusehat_sync_status' => 'failed']);
            return response()->json(['data' => 'gagal', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create batch pasien ke SatuSehat — hanya untuk yang status = 'not_found', id_satu_sehat masih NULL,
     * dan SEMUA 4 level kode wilayah BPS sudah terisi di tabel master (province, city, district, village).
     *
     * Pasien dengan wilayah tidak lengkap dilewati agar tidak dikirim payload tanpa administrativeCode
     * yang berisiko ditolak SatuSehat. Lengkapi dulu via Dashboard → SatuSehat → Wilayah → Sync ke Master.
     */
    public function createBulk(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $method = $request->method ?? 'nik';
        $batch  = min((int)($request->batch ?? 20), 50);

        $candidates = DB::table('pasien')
            ->leftJoin('provinsi',  'pasien.provinsi_id',  '=', 'provinsi.id')
            ->leftJoin('kab_kota',  'pasien.kab_kota_id',  '=', 'kab_kota.id')
            ->leftJoin('kecamatan', 'pasien.kecamatan_id', '=', 'kecamatan.id')
            ->leftJoin('kelurahan', 'pasien.kelurahan_id', '=', 'kelurahan.id')
            ->where('pasien.delete_soft', 1)
            ->where('pasien.satusehat_sync_status', 'not_found')
            ->whereNull('pasien.id_satu_sehat')
            ->whereNotNull('pasien.no_identitas')
            ->where('pasien.no_identitas', '!=', '')
            ->where('pasien.no_identitas', '!=', '-')
            ->whereRaw("pasien.no_identitas ~ '^[0-9]{16}$'")
            // Hanya pasien dengan kode wilayah BPS LENGKAP (semua 4 level)
            ->whereNotNull('provinsi.satusehat_code')
            ->whereNotNull('kab_kota.satusehat_code')
            ->whereNotNull('kecamatan.satusehat_code')
            ->whereNotNull('kelurahan.satusehat_code')
            ->select([
                'pasien.id', 'pasien.uuid', 'pasien.nama', 'pasien.no_identitas',
                'pasien.jenis_kelamin', 'pasien.tanggal_lahir',
                'pasien.alamat', 'pasien.nama_kab_kota', 'pasien.kodepos', 'pasien.no_handphone',
                'pasien.status_pernikahan', 'pasien.nama_provinsi', 'pasien.nama_kecamatan', 'pasien.nama_kelurahan',
                'pasien.rt_rw',
                'pasien.provinsi_id', 'pasien.kab_kota_id', 'pasien.kecamatan_id', 'pasien.kelurahan_id',
            ])
            ->limit($batch)
            ->get();

        if ($candidates->isEmpty()) {
            // Cek apakah ada kandidat yang tidak memenuhi syarat wilayah
            $totalNotFound = DB::table('pasien')
                ->where('delete_soft', 1)
                ->where('satusehat_sync_status', 'not_found')
                ->whereNull('id_satu_sehat')
                ->whereRaw("no_identitas ~ '^[0-9]{16}$'")
                ->count();

            $message = $totalNotFound > 0
                ? "Tidak ada kandidat dengan wilayah BPS lengkap (4 level). Ada {$totalNotFound} pasien belum terdaftar, tapi kode wilayah belum lengkap — sync master wilayah terlebih dahulu."
                : 'Tidak ada pasien "tidak ditemukan" yang bisa didaftarkan.';

            return response()->json([
                'data'    => 'berhasil',
                'message' => $message,
                'created' => 0,
                'failed'  => 0,
            ]);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'patient_sync';
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        $created = 0;
        $failed  = 0;
        $log     = [];

        foreach ($candidates as $pasien) {
            try {
                $payload = $this->buildPatientPayload($pasien, $method);
                $result  = $bridge->postJson('Patient', $payload);
                $ihsId   = $result['id'] ?? null;

                if ($ihsId) {
                    DB::table('pasien')->where('uuid', $pasien->uuid)->update([
                        'id_satu_sehat'         => $ihsId,
                        'satusehat_sync_status' => 'synced',
                        'satusehat_synced_at'   => now(),
                    ]);
                    $created++;
                    $log[] = "✓ [{$pasien->nama}] → {$ihsId}";
                } else {
                    $issue  = $result['issue'][0] ?? [];
                    $errMsg = $issue['diagnostics'] ?? json_encode($result);
                    if (stripos($errMsg, 'duplicate') !== false) {
                        $nik      = trim($pasien->no_identitas);
                        $existing = $bridge->getJson('Patient?identifier=' . urlencode('https://fhir.kemkes.go.id/id/nik|' . $nik));
                        $existId  = $existing['entry'][0]['resource']['id'] ?? null;
                        if ($existId) {
                            DB::table('pasien')->where('uuid', $pasien->uuid)->update([
                                'id_satu_sehat'         => $existId,
                                'satusehat_sync_status' => 'synced',
                                'satusehat_synced_at'   => now(),
                            ]);
                            $created++;
                            $log[] = "✓ [{$pasien->nama}] duplikat → {$existId}";
                            continue;
                        }
                    }
                    DB::table('pasien')->where('uuid', $pasien->uuid)->update(['satusehat_sync_status' => 'failed']);
                    $failed++;
                    $log[] = "✗ [{$pasien->nama}] {$errMsg}";
                }
            } catch (\Throwable $e) {
                DB::table('pasien')->where('uuid', $pasien->uuid)->update(['satusehat_sync_status' => 'failed']);
                $failed++;
                $log[] = "✗ [{$pasien->nama}] " . $e->getMessage();
            }

            usleep(200000); // 200ms delay
        }

        PenggunaHelp::log("Create bulk Patient SatuSehat: +{$created} berhasil, +{$failed} gagal (wilayah lengkap)");

        return response()->json([
            'data'    => 'berhasil',
            'message' => "Diproses {$candidates->count()} pasien (wilayah BPS lengkap).",
            'created' => $created,
            'failed'  => $failed,
            'output'  => implode("\n", $log),
        ]);
    }

    /**
     * Build FHIR Patient resource payload dari data pasien lokal.
     *
     * Kode wilayah BPS (administrativeCode) diambil dari tabel master via FK:
     *   provinsi_id  → provinsi.satusehat_code
     *   kab_kota_id  → kab_kota.satusehat_code
     *   kecamatan_id → kecamatan.satusehat_code
     *   kelurahan_id → kelurahan.satusehat_code
     *
     * Pastikan master wilayah sudah di-sync via Dashboard → SatuSehat → Wilayah.
     * Minimal province + city harus tersedia agar extension administrativeCode disertakan.
     * SatuSehat memvalidasi konsistensi hierarki kode BPS (Rule 10621–10623).
     */
    private function buildPatientPayload(object $pasien, string $method = 'nik'): array
    {
        $nik    = trim($pasien->no_identitas ?? '');
        $system = $method === 'nik_ibu'
            ? 'https://fhir.kemkes.go.id/id/nik-ibu'
            : 'https://fhir.kemkes.go.id/id/nik';

        // Gender mapping
        $genderRaw = strtolower(trim($pasien->jenis_kelamin ?? ''));
        $gender = match(true) {
            in_array($genderRaw, ['laki-laki', 'laki laki', 'l', 'male'])   => 'male',
            in_array($genderRaw, ['perempuan', 'p', 'female', 'wanita'])    => 'female',
            default                                                          => 'unknown',
        };

        // Marital status mapping
        $maritalRaw  = strtolower(trim($pasien->status_pernikahan ?? ''));
        $maritalCode = match(true) {
            str_contains($maritalRaw, 'menikah') && !str_contains($maritalRaw, 'belum') && !str_contains($maritalRaw, 'cerai') => 'M',
            str_contains($maritalRaw, 'belum')   => 'U',
            str_contains($maritalRaw, 'hidup')   => 'D',
            str_contains($maritalRaw, 'mati')    => 'W',
            default                              => 'U',
        };
        $maritalDisplay = ['M' => 'Married', 'U' => 'Unmarried', 'D' => 'Divorced', 'W' => 'Widowed'][$maritalCode] ?? 'Unmarried';

        $payload = [
            'resourceType' => 'Patient',
            'meta'         => ['profile' => ['https://fhir.kemkes.go.id/r4/StructureDefinition/Patient']],
            'identifier'   => [[
                'use'    => 'official',
                'system' => $system,
                'value'  => $nik,
            ]],
            'active'           => true,
            'name'             => [['use' => 'official', 'text' => strtoupper($pasien->nama ?? '')]],
            'gender'           => $gender,
            'birthDate'        => $pasien->tanggal_lahir ?? null,
            'deceasedBoolean'  => false,
            'maritalStatus'    => [
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-MaritalStatus',
                    'code'    => $maritalCode,
                    'display' => $maritalDisplay,
                ]],
                'text' => $maritalDisplay,
            ],
            'multipleBirthInteger' => 0,
            'communication'    => [[
                'language' => [
                    'coding' => [[
                        'system'  => 'urn:ietf:bcp:47',
                        'code'    => 'id-ID',
                        'display' => 'Indonesian',
                    ]],
                    'text' => 'Indonesian',
                ],
                'preferred' => true,
            ]],
        ];

        // Telecom (handphone)
        $hp = trim($pasien->no_handphone ?? '');
        if ($hp && $hp !== '-') {
            $payload['telecom'] = [[
                'system' => 'phone',
                'value'  => $hp,
                'use'    => 'mobile',
            ]];
        }

        // Address
        $alamat = trim($pasien->alamat ?? '');
        if ($alamat && $alamat !== '-') {
            $payload['address'] = [[
                'use'        => 'home',
                'line'       => [$alamat],
                'city'       => $pasien->nama_kab_kota ?? '',
                'postalCode' => $pasien->kodepos ?? '',
                'country'    => 'ID',
            ]];

            /**
             * Kode administratif BPS/SatuSehat — diambil dari tabel master wilayah via FK.
             *
             * Struktur kode BPS bersifat prefix-bertingkat (divalidasi SatuSehat Rule 10621–10623):
             *   Province    : 2 digit  (misal "31")
             *   City        : 4 digit  = province + 2  (misal "3171")
             *   District    : 6 digit  = city + 2      (misal "317101")
             *   Sub-district: 10 digit = district + 4  (misal "3171010001")
             *
             * Pastikan tabel master sudah di-sync via Dashboard → SatuSehat → Wilayah.
             */
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

            /**
             * Validasi hierarki — jika kode tidak konsisten, hapus level yang salah
             * daripada mengirim payload yang pasti ditolak SatuSehat.
             */
            if ($cityCode && $provinceCode && !str_starts_with($cityCode, $provinceCode)) {
                $cityCode        = '';
                $districtCode    = '';
                $subdistrictCode = '';
            }
            if ($districtCode && $cityCode && !str_starts_with($districtCode, $cityCode)) {
                $districtCode    = '';
                $subdistrictCode = '';
            }
            if ($subdistrictCode && $districtCode && !str_starts_with($subdistrictCode, $districtCode)) {
                $subdistrictCode = '';
            }

            // Sertakan extension hanya jika minimal province + city tersedia dan konsisten
            if ($provinceCode && $cityCode) {
                $adminExt = [
                    ['url' => 'province', 'valueCode' => $provinceCode],
                    ['url' => 'city',     'valueCode' => $cityCode],
                ];
                if ($districtCode)    $adminExt[] = ['url' => 'district', 'valueCode' => $districtCode];
                if ($subdistrictCode) $adminExt[] = ['url' => 'village',  'valueCode' => $subdistrictCode];

                $payload['address'][0]['extension'] = [[
                    'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                    'extension' => $adminExt,
                ]];
            }
            // Jika belum ada kode atau tidak konsisten → address tetap dikirim tanpa extension
        }

        return $payload;
    }

    /**
     * Reset status 'failed' → null agar di-retry scheduler berikutnya.
     */
    public function retryFailed(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $count = Pasien::where('delete_soft', 1)
            ->where('satusehat_sync_status', 'failed')
            ->update(['satusehat_sync_status' => null]);

        PenggunaHelp::log("Reset {$count} pasien gagal sync SatuSehat untuk diproses ulang.");

        return response()->json(['data' => 'berhasil', 'count' => $count]);
    }
}
