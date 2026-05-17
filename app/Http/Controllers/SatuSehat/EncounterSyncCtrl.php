<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Services\SatuSehat\EncounterBuilder;
use PenggunaHelp;

class EncounterSyncCtrl extends Controller
{
    private string $error = 'next';
    private int    $take  = 20;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * Dashboard — statistik ringkasan sync encounter.
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $base = DB::table('registrasi')->where('delete_soft', 1);

        $total  = (clone $base)->count();
        $synced = (clone $base)->where('satusehat_encounter_status', 'synced')->count();
        $failed = (clone $base)->where('satusehat_encounter_status', 'failed')->count();

        // Pending = belum di-proses (status NULL dan belum dapat encounter ID)
        $pending = (clone $base)
            ->whereNull('satusehat_encounter_id')
            ->where(function ($q) {
                $q->whereNull('satusehat_encounter_status')
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('satusehat_encounter_status')
                         ->whereNotIn('satusehat_encounter_status', ['synced', 'failed']);
                  });
            })
            ->count();

        // Not eligible = pending tapi pasien belum di-sync ke SatuSehat
        $notEligible = DB::table('registrasi')
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.delete_soft', 1)
            ->whereNull('registrasi.satusehat_encounter_id')
            ->where(function ($q) {
                $q->whereNull('registrasi.satusehat_encounter_status')
                  ->orWhere('registrasi.satusehat_encounter_status', 'failed');
            })
            ->whereNull('pasien.id_satu_sehat')
            ->count();

        // Waktu sync terakhir
        $lastSync = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereNotNull('satusehat_encounter_synced_at')
            ->orderByDesc('satusehat_encounter_synced_at')
            ->value('satusehat_encounter_synced_at');

        return response()->json([
            'data' => [
                'total'        => $total,
                'synced'       => $synced,
                'failed'       => $failed,
                'pending'      => $pending,
                'not_eligible' => $notEligible,
                'last_sync'    => $lastSync,
                'pct_synced'   => $total > 0 ? round(($synced / $total) * 100, 1) : 0,
            ]
        ]);
    }

    /**
     * List registrasi dengan filter status sync (paginasi).
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

        $query = DB::table('registrasi')
            ->select([
                'registrasi.id',
                'registrasi.uuid',
                'registrasi.nomor',
                'registrasi.kode',
                'registrasi.jenis',
                'registrasi.nama_pasien',
                'registrasi.rekam_medis',
                'registrasi.nama_dokter',
                'registrasi.ruang_poliklinik',
                'registrasi.satusehat_location_id',
                'registrasi.tanggal',
                'registrasi.waktu',
                'registrasi.satusehat_encounter_id',
                'registrasi.satusehat_encounter_status',
                'registrasi.satusehat_encounter_synced_at',
                'pasien.id_satu_sehat as patient_ihs_id',
            ])
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.delete_soft', 1);

        // Filter status
        if ($status === 'synced') {
            $query->where('registrasi.satusehat_encounter_status', 'synced');
        } elseif ($status === 'failed') {
            $query->where('registrasi.satusehat_encounter_status', 'failed');
        } elseif ($status === 'pending') {
            $query->whereNull('registrasi.satusehat_encounter_id')
                  ->where(function ($q) {
                      $q->whereNull('registrasi.satusehat_encounter_status')
                        ->orWhere(function ($q2) {
                            $q2->whereNotNull('registrasi.satusehat_encounter_status')
                               ->whereNotIn('registrasi.satusehat_encounter_status', ['synced', 'failed']);
                        });
                  });
        } elseif ($status === 'not_eligible') {
            $query->whereNull('registrasi.satusehat_encounter_id')
                  ->whereNull('pasien.id_satu_sehat');
        }

        // Filter pencarian
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('registrasi.nama_pasien',       'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nomor',            'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.rekam_medis',      'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nama_dokter',      'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.satusehat_encounter_id', 'ilike', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $data  = $query->orderByDesc('registrasi.satusehat_encounter_synced_at')
                       ->orderByDesc('registrasi.id')
                       ->skip($skip)
                       ->take($this->take)
                       ->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Jalankan sync manual via HTTP — memanggil Artisan command secara sinkron.
     * Gunakan batch kecil (default 20) agar tidak timeout di web request.
     */
    public function runSync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        // Cek jumlah pending sebelum sync
        $pendingBefore = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereNull('satusehat_encounter_id')
            ->where(function ($q) {
                $q->whereNull('satusehat_encounter_status')
                  ->orWhere('satusehat_encounter_status', 'failed');
            })
            ->count();

        if ($pendingBefore === 0) {
            return response()->json([
                'data'    => 'berhasil',
                'message' => 'Tidak ada encounter yang perlu disync.',
                'synced'  => 0,
                'failed'  => 0,
                'output'  => '',
            ]);
        }

        $batch = min((int)($request->batch ?? 20), 50); // max 50 per trigger manual

        try {
            $syncedBefore = DB::table('registrasi')->where('satusehat_encounter_status', 'synced')->count();
            $failedBefore = DB::table('registrasi')->where('satusehat_encounter_status', 'failed')->count();

            $exitCode = Artisan::call('satusehat:sync-encounter', [
                '--batch' => $batch,
                '--delay' => 200,
            ]);

            $output = Artisan::output();

            $syncedAfter = DB::table('registrasi')->where('satusehat_encounter_status', 'synced')->count();
            $failedAfter = DB::table('registrasi')->where('satusehat_encounter_status', 'failed')->count();

            $deltaSynced = $syncedAfter - $syncedBefore;
            $deltaFailed = $failedAfter - $failedBefore;

            PenggunaHelp::log("Trigger manual sync Encounter SatuSehat: +{$deltaSynced} synced, +{$deltaFailed} failed");

            return response()->json([
                'data'    => $exitCode === 0 ? 'berhasil' : 'gagal',
                'message' => "Diproses {$batch} encounter per batch.",
                'synced'  => $deltaSynced,
                'failed'  => $deltaFailed,
                'output'  => trim($output),
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
     * Reset status 'failed' → null agar di-retry scheduler berikutnya.
     */
    public function retryFailed(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $count = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->where('satusehat_encounter_status', 'failed')
            ->update(['satusehat_encounter_status' => null]);

        PenggunaHelp::log("Reset {$count} encounter gagal sync SatuSehat untuk diproses ulang.");

        return response()->json(['data' => 'berhasil', 'count' => $count]);
    }

    /**
     * Sync satu registrasi secara langsung (tanpa Artisan command).
     * Dipakai untuk tombol "Sync" per baris di UI.
     */
    public function syncOne(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = $request->uuid;
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID tidak ditemukan.'], 422);
        }

        // Ambil data registrasi + join pasien & pengguna
        $reg = DB::table('registrasi')
            ->select([
                'registrasi.id',
                'registrasi.uuid',
                'registrasi.nomor',
                'registrasi.nama_pasien',
                'registrasi.pasien_uuid',
                'registrasi.pengguna_uuid',
                'registrasi.nama_dokter',
                'registrasi.ruang_poliklinik',
                'registrasi.satusehat_location_id',
                'registrasi.tanggal',
                'registrasi.waktu',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
            ])
            ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
            ->where('registrasi.uuid', $uuid)
            ->first();

        if (!$reg) {
            return response()->json(['data' => 'gagal', 'message' => 'Registrasi tidak ditemukan.'], 404);
        }

        // Pasien harus sudah di-sync
        if (empty($reg->patient_ihs_id)) {
            return response()->json([
                'data'    => 'gagal',
                'message' => 'Pasien belum memiliki ID SatuSehat. Jalankan Patient Sync terlebih dahulu.',
            ], 422);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'encounter_sync';
            $orgId  = (new \App\Services\SatuSehat\Config\ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        try {
            $payload = EncounterBuilder::build($reg, $orgId);
            $result  = $bridge->postJson('Encounter', $payload);

            $encounterId = $result['id'] ?? null;

            if ($encounterId) {
                DB::table('registrasi')->where('uuid', $uuid)->update([
                    'satusehat_encounter_id'        => $encounterId,
                    'satusehat_encounter_status'     => 'synced',
                    'satusehat_encounter_synced_at'  => now(),
                ]);

                PenggunaHelp::log("Sync manual 1 encounter [{$reg->nomor}] → {$encounterId}");

                return response()->json([
                    'data'         => 'berhasil',
                    'encounter_id' => $encounterId,
                    'message'      => "Encounter berhasil dikirim. ID: {$encounterId}",
                ]);
            }

            // Validasi error dari SatuSehat
            $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);

            return response()->json(['data' => 'gagal', 'message' => $errMsg, 'detail' => $result], 422);

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);
            return response()->json(['data' => 'gagal', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update satusehat_location_id untuk satu registrasi (dari UI).
     */
    public function setLocation(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid       = $request->uuid;
        $locationId = trim($request->satusehat_location_id ?? '');

        DB::table('registrasi')->where('uuid', $uuid)->update([
            'satusehat_location_id' => $locationId ?: null,
        ]);

        return response()->json(['data' => 'berhasil']);
    }
}
