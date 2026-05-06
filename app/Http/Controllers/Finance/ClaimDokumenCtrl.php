<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenPasien;
use DB;

class ClaimDokumenCtrl extends Controller
{
    private $take = 15, $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = \PenggunaHelp::acl();
    }

    public function list(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        \PenggunaHelp::log('Melihat data list table pada halaman Claim Dokumen');

        $search       = $request->search;
        $column       = $request->column ?? 'nama_pasien';
        $page         = max(1, intval($request->page)) - 1;
        $skip         = $page * $this->take;
        $jenis        = $request->jenis;        // 'Rawat Jalan' | 'Rawat Inap' | ''
        $tanggalDari  = $request->tanggal_dari;
        $tanggalSampai= $request->tanggal_sampai;

        $query = DB::table('registrasi as r')
            ->select([
                'r.uuid',
                'r.no_pendaftaran',
                'r.rekam_medis',
                'r.nama_pasien',
                'r.pasien_uuid',
                'r.jenis',
                'r.tanggal',
                'r.nama_dokter',
                'r.carabayar_nama',
                DB::raw("(
                    SELECT COUNT(*) FROM dokumen_resume_medis_rawat_jalan drm
                    WHERE drm.uuid_pasien::text = r.pasien_uuid::text
                      AND drm.tanggal_berobat::text = r.tanggal::text
                      AND drm.deleted_at IS NULL
                ) as ada_resume"),
                DB::raw("(
                    SELECT COUNT(*) FROM dokumen_pasien dp
                    WHERE dp.pasien_uuid::text = r.pasien_uuid::text
                      AND dp.jenis_dokumen IN ('Pemeriksaan Penunjang Mata','Laboratorium','Radiologi','Lainnya')
                      AND dp.delete_soft = 1
                ) as ada_penunjang"),
                DB::raw("(
                    SELECT COUNT(*) FROM dokumen_pasien dl
                    WHERE dl.pasien_uuid::text = r.pasien_uuid::text
                      AND dl.jenis_dokumen NOT IN ('Pemeriksaan Penunjang Mata','Laboratorium','Radiologi','Lainnya')
                      AND dl.delete_soft = 1
                ) as ada_laporan"),
            ])
            ->where('r.delete_soft', 1)
            ->orderBy('r.tanggal', 'desc');

        // Filter jenis (Rawat Jalan / Rawat Inap)
        if (!empty($jenis)) {
            $query->where('r.jenis', $jenis);
        }

        // Filter tanggal registrasi
        if (!empty($tanggalDari)) {
            $query->whereDate('r.tanggal', '>=', $tanggalDari);
        }
        if (!empty($tanggalSampai)) {
            $query->whereDate('r.tanggal', '<=', $tanggalSampai);
        }

        // Search
        if (!empty($search)) {
            $query->where('r.' . $column, 'ilike', '%' . $search . '%');
        }

        $total = $query->count();
        $data  = $query->skip($skip)->take($this->take)->get();

        return response()->json(['data' => $data, 'total' => $total]);
    }

    /**
     * Ambil daftar dokumen penunjang/laporan milik pasien berdasarkan pasien_uuid
     */
    public function getDokumen(Request $request)
    {
        if ($this->error != 'next') {
            return response()->json(['data' => $this->error]);
        }

        $tipe = $request->tipe ?? 'penunjang'; // 'penunjang' | 'laporan'

        $query = DokumenPasien::where('delete_soft', 1)
            ->whereRaw("pasien_uuid::text = ?", [$request->pasien_uuid])
            ->orderBy('tanggal_upload', 'desc');

        if ($tipe === 'penunjang') {
            $query->whereIn('jenis_dokumen', ['Pemeriksaan Penunjang Mata', 'Laboratorium', 'Radiologi', 'Lainnya']);
        } else {
            $query->whereNotIn('jenis_dokumen', ['Pemeriksaan Penunjang Mata', 'Laboratorium', 'Radiologi', 'Lainnya']);
        }

        $data = $query->get(['uuid', 'jenis_dokumen', 'nama_file', 'file_path', 'keterangan', 'tanggal_upload', 'uploaded_by_nama']);

        return response()->json(['data' => $data]);
    }
}
