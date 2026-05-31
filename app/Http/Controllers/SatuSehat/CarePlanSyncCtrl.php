<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\CarePlanBuilder;
use App\Jobs\SyncCarePlanToSatuSehat;
use PenggunaHelp;

class CarePlanSyncCtrl extends Controller
{
    private string $error = 'next';
    private int    $take  = 20;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * Dashboard — statistik ringkasan sync CarePlan.
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $base = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->where('status_dokter', 'Sudah Diperiksa');

        $total  = (clone $base)->count();
        $synced = (clone $base)->where('satusehat_careplan_status', 'synced')->count();
        $failed = (clone $base)->where('satusehat_careplan_status', 'failed')->count();

        $pending = (clone $base)
            ->whereNull('satusehat_careplan_id')
            ->where(function ($q) {
                $q->whereNull('satusehat_careplan_status')
                  ->orWhereNotIn('satusehat_careplan_status', ['synced', 'failed']);
            })
            ->count();

        $waitingEncounter = (clone $base)
            ->whereNull('satusehat_careplan_id')
            ->where('satusehat_careplan_status', 'waiting_encounter')
            ->count();

        $waitingPatient = (clone $base)
            ->whereNull('satusehat_careplan_id')
            ->where('satusehat_careplan_status', 'waiting_patient')
            ->count();

        $lastSync = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereNotNull('satusehat_careplan_synced_at')
            ->orderByDesc('satusehat_careplan_synced_at')
            ->value('satusehat_careplan_synced_at');

        return response()->json([
            'data' => [
                'total'            => $total,
                'synced'           => $synced,
                'failed'           => $failed,
                'pending'          => $pending,
                'waiting_encounter' => $waitingEncounter,
                'waiting_patient'  => $waitingPatient,
                'last_sync'        => $lastSync,
                'pct_synced'       => $total > 0 ? round(($synced / $total) * 100, 1) : 0,
            ]
        ]);
    }

    /**
     * List registrasi yang status_dokter = 'Sudah Diperiksa' dengan filter status CarePlan.
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
                'registrasi.nama_pasien',
                'registrasi.nama_dokter',
                'registrasi.ruang_poliklinik',
                'registrasi.tanggal',
                'registrasi.status_dokter',
                'registrasi.satusehat_encounter_id',
                'registrasi.satusehat_careplan_id',
                'registrasi.satusehat_careplan_status',
                'registrasi.satusehat_careplan_synced_at',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
            ])
            ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.status_dokter', 'Sudah Diperiksa');

        if ($status === 'synced') {
            $query->where('registrasi.satusehat_careplan_status', 'synced');
        } elseif ($status === 'failed') {
            $query->where('registrasi.satusehat_careplan_status', 'failed');
        } elseif ($status === 'pending') {
            $query->whereNull('registrasi.satusehat_careplan_id')
                  ->where(function ($q) {
                      $q->whereNull('registrasi.satusehat_careplan_status')
                        ->orWhereNotIn('registrasi.satusehat_careplan_status', ['synced', 'failed']);
                  });
        } elseif ($status === 'waiting') {
            $query->whereIn('registrasi.satusehat_careplan_status', ['waiting_encounter', 'waiting_patient']);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('registrasi.nama_pasien', 'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nomor',      'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.nama_dokter', 'ilike', '%' . $search . '%')
                  ->orWhere('registrasi.satusehat_careplan_id', 'ilike', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $data  = $query->orderByDesc('registrasi.tanggal')
                       ->orderByDesc('registrasi.id')
                       ->skip($skip)
                       ->take($this->take)
                       ->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Sync satu registrasi secara langsung (tombol Sync per baris di UI).
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
                'registrasi.tanggal',
                'registrasi.waktu',
                'registrasi.jenis',
                'registrasi.status_dokter',
                'registrasi.satusehat_encounter_id',
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

        if (empty($reg->patient_ihs_id)) {
            return response()->json(['data' => 'gagal', 'message' => 'Pasien belum memiliki IHS Number. Jalankan Patient Sync terlebih dahulu.'], 422);
        }

        if (empty($reg->satusehat_encounter_id)) {
            return response()->json(['data' => 'gagal', 'message' => 'Encounter belum ter-sync ke SatuSehat. Jalankan Encounter Sync terlebih dahulu.'], 422);
        }

        try {
            $bridge = new \App\Services\SatuSehat\Bridge\BridgeBase();
            $bridge->logContext = 'careplan_sync';
            $orgId  = (new \App\Services\SatuSehat\Config\ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => 'Gagal inisialisasi token: ' . $e->getMessage()], 500);
        }

        try {
            $payload    = CarePlanBuilder::build($reg, $orgId);
            $result     = $bridge->postJson('CarePlan', $payload);
            $careplanId = $result['id'] ?? null;

            if ($careplanId) {
                DB::table('registrasi')->where('uuid', $uuid)->update([
                    'satusehat_careplan_id'        => $careplanId,
                    'satusehat_careplan_status'     => 'synced',
                    'satusehat_careplan_synced_at'  => now(),
                ]);
                PenggunaHelp::log("Sync manual CarePlan [{$reg->nomor}] → {$careplanId}");

                return response()->json([
                    'data'        => 'berhasil',
                    'careplan_id' => $careplanId,
                    'message'     => "CarePlan berhasil dikirim. ID: {$careplanId}",
                ]);
            }

            $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_status' => 'failed',
            ]);

            return response()->json(['data' => 'gagal', 'message' => $errMsg, 'detail' => $result], 422);

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_status' => 'failed',
            ]);
            return response()->json(['data' => 'gagal', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Bulk dispatch job untuk semua registrasi yang belum ter-sync.
     */
    public function runSync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $batch = min((int)($request->batch ?? 20), 50);

        $registrations = DB::table('registrasi')
            ->select(['registrasi.uuid'])
            ->leftJoin('pasien', 'pasien.uuid', '=', 'registrasi.pasien_uuid')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.status_dokter', 'Sudah Diperiksa')
            ->whereNotNull('registrasi.satusehat_encounter_id')
            ->whereNotNull('pasien.id_satu_sehat')
            ->whereNull('registrasi.satusehat_careplan_id')
            ->where(function ($q) {
                $q->whereNull('registrasi.satusehat_careplan_status')
                  ->orWhere('registrasi.satusehat_careplan_status', 'failed');
            })
            ->limit($batch)
            ->get();

        if ($registrations->isEmpty()) {
            return response()->json([
                'data'      => 'berhasil',
                'message'   => 'Tidak ada CarePlan yang perlu disync.',
                'dispatched' => 0,
            ]);
        }

        $dispatched = 0;
        foreach ($registrations as $reg) {
            SyncCarePlanToSatuSehat::dispatch($reg->uuid);
            $dispatched++;
        }

        PenggunaHelp::log("Dispatch {$dispatched} job CarePlan SatuSehat.");

        return response()->json([
            'data'       => 'berhasil',
            'message'    => "{$dispatched} CarePlan job telah di-dispatch ke queue.",
            'dispatched' => $dispatched,
        ]);
    }

    /**
     * Reset status 'failed' / 'waiting_*' → null agar bisa di-retry.
     */
    public function retryFailed(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $count = DB::table('registrasi')
            ->where('delete_soft', 1)
            ->whereIn('satusehat_careplan_status', ['failed', 'waiting_encounter', 'waiting_patient'])
            ->whereNull('satusehat_careplan_id')
            ->update(['satusehat_careplan_status' => null]);

        PenggunaHelp::log("Reset {$count} CarePlan gagal/waiting untuk diproses ulang.");

        return response()->json(['data' => 'berhasil', 'count' => $count]);
    }
}
