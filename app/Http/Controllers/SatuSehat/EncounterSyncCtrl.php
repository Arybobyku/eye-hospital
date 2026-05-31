<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
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

    // ── Helper: normalise & clamp date range ─────────────────────────────────
    private function parseDateRange(Request $request): array
    {
        $today     = date('Y-m-d');
        $firstDay  = date('Y-m-01');          // 1st of current month

        $dateFrom = $request->date_from ?? $firstDay;
        $dateTo   = $request->date_to   ?? $today;

        // Pastikan format valid; fallback ke default kalau tidak
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) $dateFrom = $firstDay;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo))   $dateTo   = $today;

        // from tidak boleh lebih besar dari to
        if ($dateFrom > $dateTo) [$dateFrom, $dateTo] = [$dateTo, $dateFrom];

        return [$dateFrom, $dateTo];
    }

    /**
     * Dashboard — statistik ringkasan sync encounter.
     * Filter date range: date_from .. date_to (default: bulan ini).
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        [$dateFrom, $dateTo] = $this->parseDateRange($request);

        $base = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereBetween('tanggal', [$dateFrom, $dateTo]);

        $total  = (clone $base)->count();
        $synced = (clone $base)->where('satusehat_encounter_status', 'synced')->count();
        $failed = (clone $base)->where('satusehat_encounter_status', 'failed')->count();

        // Pending = belum di-proses (status NULL/non-final, belum dapat encounter ID)
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

        // Not eligible = pasien belum di-sync ke SatuSehat
        $notEligible = DB::table('registrasi')
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.delete_soft', 1)
            ->whereBetween('registrasi.tanggal', [$dateFrom, $dateTo])
            ->whereNull('registrasi.satusehat_encounter_id')
            ->where(function ($q) {
                $q->whereNull('registrasi.satusehat_encounter_status')
                  ->orWhere('registrasi.satusehat_encounter_status', 'failed');
            })
            ->whereNull('pasien.id_satu_sehat')
            ->count();

        // Waktu sync terakhir dalam range
        $lastSync = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereBetween('tanggal', [$dateFrom, $dateTo])
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
                'date_from'    => $dateFrom,
                'date_to'      => $dateTo,
                'pct_synced'   => $total > 0 ? round(($synced / $total) * 100, 1) : 0,
            ]
        ]);
    }

    /**
     * List registrasi dengan filter status sync + date range (paginasi).
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

        [$dateFrom, $dateTo] = $this->parseDateRange($request);

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
                'registrasi.satusehat_encounter_fhir_status',
                'registrasi.satusehat_encounter_synced_at',
                'registrasi.satusehat_careplan_kontrol_id',
                'registrasi.satusehat_careplan_kontrol_status',
                'registrasi.satusehat_careplan_kontrol_synced_at',
                'pasien.id_satu_sehat as patient_ihs_id',
                // Tanggal kontrol dari pemeriksaan dokter (subquery — ambil terbaru)
                DB::raw("(
                    SELECT pd.tanggal_kontrol_selanjutnya
                    FROM pemeriksaan_dokter pd
                    WHERE pd.registrasi_uuid = registrasi.uuid
                      AND pd.tanggal_kontrol_selanjutnya IS NOT NULL
                    ORDER BY pd.id DESC
                    LIMIT 1
                ) AS tanggal_kontrol_selanjutnya"),
            ])
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.delete_soft', 1)
            ->whereBetween('registrasi.tanggal', [$dateFrom, $dateTo]);

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
                $q->where('registrasi.nama_pasien',            'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nomor',                 'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.rekam_medis',           'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nama_dokter',           'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.satusehat_encounter_id','ilike', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $data  = $query->orderByDesc('registrasi.tanggal')
                       ->orderByDesc('registrasi.satusehat_encounter_synced_at')
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

        // Artisan::call() berjalan synchronous di process yang sama.
        // Batch 20–50 encounter × waktu API SatuSehat per call mudah melebihi 30 detik.
        set_time_limit(300); // 5 menit cukup untuk batch 50 encounter

        [$dateFrom, $dateTo] = $this->parseDateRange($request);

        // Cek jumlah pending dalam range sebelum sync
        $pendingBefore = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereBetween('tanggal', [$dateFrom, $dateTo])
            ->whereNull('satusehat_encounter_id')
            ->where(function ($q) {
                $q->whereNull('satusehat_encounter_status')
                  ->orWhere('satusehat_encounter_status', 'failed');
            })
            ->count();

        if ($pendingBefore === 0) {
            return response()->json([
                'data'    => 'berhasil',
                'message' => 'Tidak ada encounter yang perlu disync pada rentang tanggal ini.',
                'synced'  => 0,
                'failed'  => 0,
                'output'  => '',
            ]);
        }

        $batch = min((int)($request->batch ?? 20), 50); // max 50 per trigger manual

        try {
            $syncedBefore = DB::table('registrasi')
                ->where('satusehat_encounter_status', 'synced')
                ->whereBetween('tanggal', [$dateFrom, $dateTo])
                ->count();
            $failedBefore = DB::table('registrasi')
                ->where('satusehat_encounter_status', 'failed')
                ->whereBetween('tanggal', [$dateFrom, $dateTo])
                ->count();

            $exitCode = Artisan::call('satusehat:sync-encounter', [
                '--batch'     => $batch,
                '--delay'     => 200,
                '--date-from' => $dateFrom,
                '--date-to'   => $dateTo,
            ]);

            $output = Artisan::output();

            $syncedAfter = DB::table('registrasi')
                ->where('satusehat_encounter_status', 'synced')
                ->whereBetween('tanggal', [$dateFrom, $dateTo])
                ->count();
            $failedAfter = DB::table('registrasi')
                ->where('satusehat_encounter_status', 'failed')
                ->whereBetween('tanggal', [$dateFrom, $dateTo])
                ->count();

            $deltaSynced = $syncedAfter - $syncedBefore;
            $deltaFailed = $failedAfter - $failedBefore;

            PenggunaHelp::log("Trigger manual sync Encounter SatuSehat ({$dateFrom}~{$dateTo}): +{$deltaSynced} synced, +{$deltaFailed} failed");

            return response()->json([
                'data'    => $exitCode === 0 ? 'berhasil' : 'gagal',
                'message' => "Diproses {$batch} encounter per batch ({$dateFrom} s/d {$dateTo}).",
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
     * Hanya me-reset registrasi dalam date range yang dipilih.
     */
    public function retryFailed(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        [$dateFrom, $dateTo] = $this->parseDateRange($request);

        $count = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereBetween('tanggal', [$dateFrom, $dateTo])
            ->where('satusehat_encounter_status', 'failed')
            ->update(['satusehat_encounter_status' => null]);

        PenggunaHelp::log("Reset {$count} encounter gagal sync SatuSehat ({$dateFrom}~{$dateTo}) untuk diproses ulang.");

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

        // Satu call API SatuSehat bisa memakan 10–30 detik.
        set_time_limit(120); // 2 menit cukup untuk satu encounter

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
                    'satusehat_encounter_id'             => $encounterId,
                    'satusehat_encounter_status'         => 'synced',
                    'satusehat_encounter_fhir_status'    => 'arrived',
                    'satusehat_encounter_synced_at'      => now(),
                ]);

                // Seed initial status history: arrived
                $alreadySeeded = DB::table('satusehat_encounter_status_history')
                    ->where('registrasi_uuid', $uuid)
                    ->exists();
                if (!$alreadySeeded) {
                    $waktuStr  = $reg->waktu ?? '00:00';
                    $periodStr = $reg->tanggal . ' ' . $waktuStr . ':00+07:00';
                    DB::table('satusehat_encounter_status_history')->insert([
                        'registrasi_uuid'        => $uuid,
                        'satusehat_encounter_id' => $encounterId,
                        'status'                 => 'arrived',
                        'period_start'           => $periodStr,
                        'period_end'             => null,
                        'catatan'                => 'Encounter pertama kali dikirim ke SatuSehat',
                        'updated_by'             => PenggunaHelp::nama() ?? 'system',
                        'created_at'             => now(),
                    ]);
                }

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
     * Ambil riwayat status FHIR untuk satu registrasi.
     */
    public function statusHistory(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = $request->uuid;
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID tidak ditemukan.'], 422);
        }

        $history = DB::table('satusehat_encounter_status_history')
            ->where('registrasi_uuid', $uuid)
            ->orderBy('period_start')
            ->get();

        return response()->json(['data' => $history]);
    }

    /**
     * Update FHIR Encounter status — kirim PUT ke SatuSehat dan catat ke history.
     *
     * Body: { uuid, status, period_start (opsional), catatan (opsional) }
     * Status valid: arrived | in-progress | finished | cancelled
     */
    public function updateStatus(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid      = $request->uuid;
        $newStatus = $request->status;

        if (!$uuid || !$newStatus) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID dan status wajib diisi.'], 422);
        }

        if (!array_key_exists($newStatus, EncounterBuilder::FHIR_STATUSES)) {
            return response()->json(['data' => 'gagal', 'message' => 'Status tidak valid: ' . $newStatus], 422);
        }

        // Ambil registrasi + join pasien & pengguna
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
                'registrasi.satusehat_location_ro_id',
                'registrasi.satusehat_location_poli_id',
                'registrasi.satusehat_encounter_id',
                'registrasi.satusehat_encounter_fhir_status',
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

        if (empty($reg->satusehat_encounter_id)) {
            return response()->json([
                'data'    => 'gagal',
                'message' => 'Encounter belum di-sync ke SatuSehat. Lakukan sync terlebih dahulu.',
            ], 422);
        }

        $oldStatus   = $reg->satusehat_encounter_fhir_status ?? 'arrived';
        $periodStart = $request->period_start
            ?? now('Asia/Jakarta')->format('Y-m-d\TH:i:sP');
        $catatan     = $request->catatan ?? null;

        // Jangan proses jika status sama
        if ($oldStatus === $newStatus) {
            return response()->json([
                'data'    => 'skip',
                'message' => 'Status sudah ' . $newStatus . ', tidak ada perubahan.',
            ]);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'encounter_update_status';
            $orgId  = (new \App\Services\SatuSehat\Config\ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        // ── Tutup period_end pada status sebelumnya ──────────────────────
        DB::table('satusehat_encounter_status_history')
            ->where('registrasi_uuid', $uuid)
            ->whereNull('period_end')
            ->update(['period_end' => $periodStart]);

        // ── Insert status baru ke history ────────────────────────────────
        DB::table('satusehat_encounter_status_history')->insert([
            'registrasi_uuid'        => $uuid,
            'satusehat_encounter_id' => $reg->satusehat_encounter_id,
            'status'                 => $newStatus,
            'period_start'           => $periodStart,
            'period_end'             => null,
            'catatan'                => $catatan,
            'updated_by'             => PenggunaHelp::nama() ?? 'system',
            'created_at'             => now(),
        ]);

        // ── Update kolom FHIR status di registrasi ───────────────────────
        DB::table('registrasi')->where('uuid', $uuid)->update([
            'satusehat_encounter_fhir_status' => $newStatus,
        ]);

        // ── Bangun payload PUT (full resource wajib dikirim ulang) ───────
        // Refresh $reg agar fhir_status sudah terupdate
        $reg->satusehat_encounter_fhir_status = $newStatus;

        try {
            $payload        = EncounterBuilder::build($reg, $orgId);
            $payload['id']  = $reg->satusehat_encounter_id; // wajib ada untuk PUT

            $result = $bridge->putJson('Encounter/' . $reg->satusehat_encounter_id, $payload);

            Log::channel('satusehat')->info('[EncounterStatus] PUT berhasil', [
                'uuid'         => $uuid,
                'encounter_id' => $reg->satusehat_encounter_id,
                'old_status'   => $oldStatus,
                'new_status'   => $newStatus,
                'response_id'  => $result['id'] ?? null,
            ]);

            PenggunaHelp::log("Update FHIR Encounter status [{$reg->nomor}]: {$oldStatus} → {$newStatus}");

            return response()->json([
                'data'       => 'berhasil',
                'message'    => 'Status encounter diperbarui: ' . $oldStatus . ' → ' . $newStatus,
                'new_status' => $newStatus,
            ]);

        } catch (\Throwable $e) {
            // Rollback: hapus history baru & kembalikan status lama
            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', $newStatus)
                ->whereNull('period_end')
                ->delete();

            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', $oldStatus)
                ->update(['period_end' => null]);

            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_fhir_status' => $oldStatus,
            ]);

            Log::channel('satusehat')->error('[EncounterStatus] Gagal PUT ke SatuSehat', [
                'uuid'  => $uuid,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'data'    => 'gagal',
                'message' => 'Gagal mengirim ke SatuSehat: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil detail FHIR Encounter langsung dari SatuSehat API.
     * Endpoint: GET /Encounter/{encounter_id}
     */
    public function encounterDetail(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = $request->uuid;
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID tidak ditemukan.'], 422);
        }

        $reg = DB::table('registrasi')
            ->where('uuid', $uuid)
            ->select('satusehat_encounter_id', 'nomor', 'nama_pasien')
            ->first();

        if (!$reg || empty($reg->satusehat_encounter_id)) {
            return response()->json(['data' => 'gagal', 'message' => 'Encounter belum di-sync.'], 422);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'encounter_detail';
            $result = $bridge->getJson('Encounter/' . $reg->satusehat_encounter_id);

            return response()->json(['data' => $result]);
        } catch (\Throwable $e) {
            return response()->json([
                'data'    => 'gagal',
                'message' => 'Gagal mengambil detail dari SatuSehat: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil daftar FHIR Condition yang terkait dengan Encounter ini dari SatuSehat.
     * Query: GET /Condition?encounter={encounter_id}
     */
    public function conditions(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = $request->uuid;
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID tidak ditemukan.'], 422);
        }

        $reg = DB::table('registrasi')
            ->where('uuid', $uuid)
            ->select('satusehat_encounter_id', 'nomor', 'nama_pasien')
            ->first();

        if (!$reg || empty($reg->satusehat_encounter_id)) {
            return response()->json(['data' => 'gagal', 'message' => 'Encounter belum di-sync.'], 422);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'encounter_conditions';

            $result = $bridge->getJson('Condition?encounter=' . urlencode($reg->satusehat_encounter_id));

            // Flatten tiap entry menjadi array ringkas
            $entries = $result['entry'] ?? [];
            $total   = $result['total'] ?? count($entries);

            $conditions = array_map(function ($entry) {
                $res  = $entry['resource'] ?? [];
                $code = ($res['code']['coding'][0] ?? []);
                $cat  = ($res['category'][0]['coding'][0] ?? []);
                $cs   = ($res['clinicalStatus']['coding'][0] ?? []);

                return [
                    'id'              => $res['id'] ?? null,
                    'kode_icd'        => $code['code']    ?? null,
                    'display_icd'     => $code['display'] ?? null,
                    'category_code'   => $cat['code']     ?? null,
                    'category_display'=> $cat['display']  ?? null,
                    'clinical_status' => $cs['code']      ?? null,
                    'subject'         => $res['subject']  ?? null,
                    'encounter'       => $res['encounter'] ?? null,
                    'last_updated'    => $res['meta']['lastUpdated'] ?? null,
                ];
            }, $entries);

            return response()->json([
                'data'       => $conditions,
                'total'      => $total,
                'encounter_id' => $reg->satusehat_encounter_id,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'data'    => 'gagal',
                'message' => 'Gagal mengambil Conditions dari SatuSehat: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ambil daftar Observation dari SatuSehat untuk satu encounter.
     * Juga mengembalikan status sync CPPT lokal agar UI dapat membandingkan.
     */
    public function observations(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $uuid = $request->uuid;
        if (!$uuid) {
            return response()->json(['data' => 'gagal', 'message' => 'UUID tidak ditemukan.'], 422);
        }

        $reg = DB::table('registrasi')
            ->where('uuid', $uuid)
            ->select('satusehat_encounter_id', 'nomor', 'nama_pasien')
            ->first();

        if (!$reg || empty($reg->satusehat_encounter_id)) {
            return response()->json(['data' => 'gagal', 'message' => 'Encounter belum di-sync.'], 422);
        }

        // ── Ambil status CPPT lokal ─────────────────────────────────────────
        $cpptRows = DB::table('cppt')
            ->where('registrasi_uuid', $uuid)
            ->whereNotNull('asesmen')
            ->where(DB::raw("TRIM(asesmen)"), '!=', '')
            ->select([
                'uuid',
                'sebagai',
                'nama_pengguna',
                'nama_dokter',
                'satusehat_observation_id',
                'satusehat_observation_status',
                'satusehat_observation_synced_at',
            ])
            ->orderBy('id')
            ->get();

        // ── Ambil Observation dari SatuSehat ────────────────────────────────
        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'encounter_observations';

            $result  = $bridge->getJson('Observation?encounter=' . urlencode($reg->satusehat_encounter_id));
            $entries = $result['entry'] ?? [];
            $total   = $result['total'] ?? count($entries);

            $observations = array_map(function ($entry) {
                $res  = $entry['resource'] ?? [];
                $code = ($res['code']['coding'][0] ?? []);
                $cat  = ($res['category'][0]['coding'][0] ?? []);
                $perf = ($res['performer'][0] ?? []);

                return [
                    'id'              => $res['id'] ?? null,
                    'status'          => $res['status'] ?? null,
                    'code'            => $code['code']    ?? null,
                    'code_display'    => $code['display'] ?? null,
                    'category_code'   => $cat['code']     ?? null,
                    'category_display'=> $cat['display']  ?? null,
                    'value_string'    => $res['valueString'] ?? null,
                    'effective'       => $res['effectiveDateTime'] ?? null,
                    'performer_ref'   => $perf['reference'] ?? null,
                    'performer_name'  => $perf['display']   ?? null,
                    'subject'         => $res['subject']    ?? null,
                    'last_updated'    => $res['meta']['lastUpdated'] ?? null,
                ];
            }, $entries);

            return response()->json([
                'data'         => $observations,
                'total'        => $total,
                'encounter_id' => $reg->satusehat_encounter_id,
                'cppt_local'   => $cpptRows,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'data'       => 'gagal',
                'cppt_local' => $cpptRows,
                'message'    => 'Gagal mengambil Observations dari SatuSehat: ' . $e->getMessage(),
            ], 500);
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
