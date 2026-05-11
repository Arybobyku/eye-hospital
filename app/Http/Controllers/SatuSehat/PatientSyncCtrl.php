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

        return response()->json([
            'data' => [
                'total'      => $total,
                'synced'     => $synced,
                'not_found'  => $notFound,
                'failed'     => $failed,
                'pending'    => $pending,
                'last_sync'  => $lastSync,
                'pct_synced' => $total > 0 ? round(($synced / $total) * 100, 1) : 0,
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
        $status = $request->status ?? 'all'; // all | synced | not_found | failed | pending
        $search = trim($request->search ?? '');

        $query = Pasien::where('delete_soft', 1)
            ->select(['id', 'uuid', 'rekam_medis', 'nama', 'no_identitas', 'jenis_identitas',
                      'id_satu_sehat', 'satusehat_sync_status', 'satusehat_synced_at']);

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
     * Gunakan batch kecil (default 30) agar tidak timeout di web request.
     * Untuk dataset besar, gunakan scheduler atau jalankan via CLI.
     */
    public function runSync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        // Ambil jumlah pending sebelum sync
        // Catatan: whereNotIn tidak menangkap NULL di PostgreSQL — harus pakai orWhereNull
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
                'data'    => 'berhasil',
                'message' => 'Tidak ada pasien yang perlu disync.',
                'synced'  => 0,
                'not_found' => 0,
                'failed'  => 0,
                'output'  => '',
            ]);
        }

        $batch = min((int)($request->batch ?? 30), 100); // max 100 per trigger manual

        try {
            // Snapshot sebelum
            $syncedBefore   = Pasien::where('satusehat_sync_status', 'synced')->count();
            $notFoundBefore = Pasien::where('satusehat_sync_status', 'not_found')->count();
            $failedBefore   = Pasien::where('satusehat_sync_status', 'failed')->count();

            // Jalankan command
            $exitCode = Artisan::call('satusehat:sync-patient', [
                '--batch' => $batch,
                '--delay' => 200,
            ]);

            $output = Artisan::output();

            // Hitung delta
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
