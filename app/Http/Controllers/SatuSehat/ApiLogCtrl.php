<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PenggunaHelp;

class ApiLogCtrl extends Controller
{
    private string $error = 'next';
    private int    $take  = 25;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
    }

    /**
     * Dashboard statistik API logs.
     */
    public function dashboard(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $total   = DB::table('satusehat_api_logs')->count();
        $success = DB::table('satusehat_api_logs')->where('is_success', true)->count();
        $failed  = DB::table('satusehat_api_logs')->where('is_success', false)->count();

        // Stats per konteks
        $byContext = DB::table('satusehat_api_logs')
            ->selectRaw("context, COUNT(*) as total, SUM(CASE WHEN is_success THEN 1 ELSE 0 END) as success")
            ->groupBy('context')
            ->orderByDesc('total')
            ->get();

        // Rata-rata durasi
        $avgDuration = DB::table('satusehat_api_logs')
            ->whereNotNull('duration_ms')
            ->avg('duration_ms');

        // Log terakhir
        $lastLog = DB::table('satusehat_api_logs')
            ->orderByDesc('created_at')
            ->value('created_at');

        return response()->json([
            'data' => [
                'total'        => $total,
                'success'      => $success,
                'failed'       => $failed,
                'avg_duration' => $avgDuration ? round($avgDuration) : 0,
                'last_log'     => $lastLog,
                'by_context'   => $byContext,
            ]
        ]);
    }

    /**
     * List API logs dengan filter + paginasi.
     */
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $page    = max(1, (int)($request->page ?? 1));
        $skip    = ($page - 1) * $this->take;
        $method  = $request->method  ?? 'all';  // all | GET | POST | PUT | PATCH
        $context = $request->context ?? 'all';  // all | patient_sync | encounter_sync | wilayah | etc
        $status  = $request->status  ?? 'all';  // all | success | failed
        $search  = trim($request->search ?? '');

        $query = DB::table('satusehat_api_logs');

        if ($method !== 'all') {
            $query->where('method', strtoupper($method));
        }
        if ($context !== 'all') {
            $query->where('context', $context);
        }
        if ($status === 'success') {
            $query->where('is_success', true);
        } elseif ($status === 'failed') {
            $query->where('is_success', false);
        }
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('url', 'ilike', '%' . $search . '%')
                  ->orWhere('request_body',  'ilike', '%' . $search . '%')
                  ->orWhere('response_body', 'ilike', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $data  = $query->orderByDesc('id')
                       ->skip($skip)
                       ->take($this->take)
                       ->select([
                           'id', 'method', 'url', 'http_code', 'context',
                           'duration_ms', 'is_success', 'created_at',
                           // Potong body agar tidak terlalu besar di list
                           DB::raw("LEFT(request_body, 500)  AS request_body"),
                           DB::raw("LEFT(response_body, 500) AS response_body"),
                       ])
                       ->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Detail 1 log entry (body lengkap).
     */
    public function detail(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $id  = (int)($request->id ?? 0);
        $row = DB::table('satusehat_api_logs')->find($id);

        if (!$row) {
            return response()->json(['data' => 'gagal', 'message' => 'Log tidak ditemukan.'], 404);
        }

        return response()->json(['data' => $row]);
    }

    /**
     * Hapus log lama (default: lebih dari 30 hari).
     */
    public function clear(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $days = max(1, (int)($request->days ?? 30));

        $deleted = DB::table('satusehat_api_logs')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        PenggunaHelp::log("Clear API logs SatuSehat (>{$days} hari): {$deleted} records dihapus.");

        return response()->json([
            'data'    => 'berhasil',
            'message' => "{$deleted} log dihapus (lebih dari {$days} hari).",
            'deleted' => $deleted,
        ]);
    }

    /**
     * Hapus semua log.
     */
    public function clearAll(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $deleted = DB::table('satusehat_api_logs')->delete();

        PenggunaHelp::log("Clear ALL API logs SatuSehat: {$deleted} records dihapus.");

        return response()->json([
            'data'    => 'berhasil',
            'message' => "Semua {$deleted} log berhasil dihapus.",
            'deleted' => $deleted,
        ]);
    }
}
