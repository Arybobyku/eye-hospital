<?php

namespace App\Http\Controllers\Master;

use App\Exports\RekamMedisExport;
use App\Models\Icd10;
use App\Models\PemeriksaanDokter;
use Maatwebsite\Excel\Facades\Excel;
use PenggunaHelp;

use App\Http\Controllers\Controller;
use App\Models\Registrasi;
use Illuminate\Http\Request;

class RekamMedisCtrl extends Controller
{
    private $take = 15, $error = 'next';

    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->error = PenggunaHelp::acl();
    }

    private function generateListQuery(Request $request)
    {
        $query = Registrasi::select([
            'registrasi.tanggal',
            'registrasi.no_pendaftaran',
            'registrasi.rekam_medis',
            'registrasi.nama_pasien',
            \DB::raw("CASE WHEN pemeriksaan_dokter.pemeriksaan_diagnosa = 'Silahkan Pilih' THEN NULL ELSE pemeriksaan_dokter.pemeriksaan_diagnosa END as pemeriksaan_diagnosa"),
            'registrasi.jenis_kelamin',
            'pasien.kelompok_umur_nama',
            'registrasi.agama',
            'pasien.status_pernikahan',
            'pasien.pekerjaan',
            'pasien.alamat',
            'pasien.nama_kecamatan',
            'pasien.nama_kab_kota',
            'registrasi.cara_masuk',
            'registrasi.jalur_masuk',
            \DB::raw('penanggung_jawab.nama as nama_pj'),
            'registrasi.rujukan',
            'p_ro.kasus_urgent',
            'registrasi.carabayar_nama',
            'registrasi.ruang_poliklinik',
            'registrasi.nama_dokter',
            \DB::raw("CASE WHEN registrasi.tanggal <= registrasi.tanggal_bayar THEN registrasi.tanggal_bayar ELSE NULL END as tanggal_bayar"),
            'registrasi.status',
        ])
            // TODO: Cek apakah pemeriksaan dokter dapat terjadi lebih dari sekali untuk satu registrasi.
            ->leftJoin('pemeriksaan_dokter', 'pemeriksaan_dokter.registrasi_uuid', '=', 'registrasi.uuid')
            ->leftJoin('pasien', 'registrasi.pasien_uuid', '=', 'pasien.uuid')
            // Entah kenapa, pemeriksaan_ro dapat diinput lebih dari sekali untuk satu registrasi
            ->leftJoinSub(
                fn($q) => $q->from('pemeriksaan_ro')->select(['registrasi_uuid', 'kasus_urgent'])
                    ->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY created_at DESC) as urutan'),
                'p_ro',
                fn($q) => $q->on('p_ro.registrasi_uuid', '=', 'registrasi.uuid')->where('p_ro.urutan', '=', 1)
            )
            ->leftJoin('penanggung_jawab', 'penanggung_jawab.registrasi_uuid', '=', 'registrasi.uuid')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739');

        if ($request->dateRange) {
            $query->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        if ($request->jenis_kelamin) {
            $query->where('registrasi.jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->is_surgery) {
            $query->where('registrasi.apakah_paket', 'Ya');
        }

        if ($request->icd10) {
            $query->where('pemeriksaan_dokter.pemeriksaan_diagnosa_kode', $request->icd10);
        }

        if ($request->asuransi) {
            $query->where('registrasi.asuransi_uuid', $request->asuransi);
        }

        if ($request->carabayar) {
            $query->where('registrasi.carabayar_uuid', $request->carabayar);
        }

        return $query;
    }

    public function list(Request $request)
    {
        PenggunaHelp::log('Melihat data list table pada halaman data master rekam medis');

        $data = $this->generateListQuery($request)->paginate(15);

        return response()->json($data);
    }

    public function listexcel(Request $request)
    {
        PenggunaHelp::log('Mengunduh Excel data list table pada halaman data master rekam medis');

        $data = $this->generateListQuery($request)->get();

        return Excel::download(new RekamMedisExport($data), 'Data Rekam Medis.xlsx');
    }

    public function statsjumlahpengunjung(Request $request)
    {
        /**
         * 1. Pasien lama harus memiliki lebih dari satu record registrasi.
         * 2. Harus ada cara untuk mendeteksi suatu record registrasi merupakan kunjungan lama atau baru.
         * 
         * Simpan kodingan sementara yang dapat dipakai sebagai validasi data
         * select(['registrasi.uuid', 'registrasi.tanggal', 'registrasi.nama_pasien'])
         *  ->selectRaw('CASE WHEN r.urutan = 1 THEN TRUE ELSE FALSE END as kunjungan_baru')
         */

        $data = Registrasi::selectRaw('COUNT(registrasi.uuid) FILTER (WHERE r.urutan = 1) as kunjungan_baru')
            ->selectRaw('COUNT(registrasi.uuid) as total_kunjungan')
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739')
            ->joinSub(
                fn($q) => $q->from('registrasi')->select(['uuid'])
                    ->selectRaw('RANK() OVER (PARTITION BY pasien_uuid ORDER BY tanggal ASC) as urutan'),
                'r',
                'r.uuid',
                '=',
                'registrasi.uuid'
            );

        if ($request->dateRange) {
            $data->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        return response()->json($data->first());
    }

    public function statsjumlahkunjungan(Request $request)
    {
        $data = Registrasi::selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'Rawat Jalan') as rawat_jalan")
            ->selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'Rawat Inap') as rawat_inap")
            ->selectRaw("COUNT(registrasi.uuid) FILTER (WHERE registrasi.jalur_masuk = 'One Day Care') as odc")
            ->where('registrasi.delete_soft', 1)
            ->where('registrasi.rekam_medis', '!=', 'AP020739');

        if ($request->dateRange) {
            $data->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
        }

        return response()->json($data->first());
    }

    public function statspenyakitterbanyak(Request $request)
    {
        $data = Icd10::select(['icd_ten.nama', 'icd_ten.kode', \DB::raw('COUNT(pd.uuid) as jumlah')])
            ->leftJoinSub(
                \DB::table('pemeriksaan_dokter')->select(['pemeriksaan_dokter.uuid', 'pemeriksaan_diagnosa_kode'])
                    ->leftJoin('registrasi', 'registrasi.uuid', '=', 'pemeriksaan_dokter.registrasi_uuid')
                    ->where(function ($q) use ($request) {
                        if ($request->dateRange) {
                            $q->where('registrasi.tanggal', '>=', $request->dateRange['start'])
                                ->where('registrasi.tanggal', '<=', $request->dateRange['end']);
                        }

                        return $q;
                    })
                    ->where('registrasi.delete_soft', 1)
                    ->where('registrasi.rekam_medis', '!=', 'AP020739'),
                'pd',
                'pd.pemeriksaan_diagnosa_kode',
                '=',
                'icd_ten.uuid'
            )
            ->where('icd_ten.delete_soft', 1)
            ->groupBy('icd_ten.nama')
            ->groupBy('icd_ten.kode')
            ->orderBy('jumlah', 'DESC')
            ->limit(10);

        return response()->json($data->get());
    }

    public function listLampiran(Request $request)
    {
        try {
            $uuid_pasien = $request->input('uuid_pasien');
            $search = $request->input('search', '');
            $limit = $request->input('limit', 10);
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $limit;

            // ✨ KONFIGURASI DOKUMEN
            $documentConfigs = [
                [
                    'table' => 'dokumen_form_laser_bargage',
                    'type' => 'laser_barbage',
                    'label' => 'Form Laser Bargage',
                    'icon' => 'fa-laser',
                    'color' => '#28a745',
                ],
                [
                    'table' => 'dokumen_laporan_pembedahan',
                    'type' => 'laporan_bedah',
                    'label' => 'Laporan Pembedahan',
                    'icon' => 'fa-procedures',
                    'color' => '#007bff',
                ],
                [
                    'table' => 'dokumen_balance_cairan_harian',
                    'type' => 'balance_cairan_harian',
                    'label' => 'Balance Cairan Harian',
                    'icon' => 'fa-tint',
                    'color' => '#6f42c1',
                ],
                [
                    'table' => 'dokumen_resume_perawatan_rawat_jalan',
                    'type' => 'resume_perawatan_rawat_jalan',
                    'label' => 'Resume Perawatan Rawat Jalan',
                    'icon' => 'fa-file-medical',
                    'color' => '#17a2b8',
                ],
                [
                    'table' => 'dokumen_surat_penolakan_rujukan',
                    'type' => 'surat_penolakan_rujukan',
                    'label' => 'Surat Penolakan Rujukan',
                    'icon' => 'fa-file-medical',
                    'color' => '#17a2b8',
                ],
                [
                    'table' => 'dokumen_surat_kontrol',
                    'type' => 'surat_kontrol_ulang',
                    'label' => 'Surat Kontrol Ulang',
                    'icon' => 'fa-file-medical',
                    'color' => '#17a2b8',
                ],
                [
                    'table' => 'dokumen_surat_balasan_konsul',
                    'type' => 'surat_balasan_konsul',
                    'label' => 'Surat Balasan Konsultasi',
                    'icon' => 'fa-file-medical',
                    'color' => '#17a2b8',
                ],
                [
                    'table' => 'dokumen_surat_pernyataan_batal_operasi',
                    'type' => 'surat_pernyataan_batal_operasi',
                    'label' => 'Surat Pernyataan Batal Operasi',
                    'icon' => 'fa-file-medical',
                    'color' => '#17a2b8',
                ],
                // Tambahkan dokumen baru di sini
            ];

            // ✨ GET TOTAL COUNT (sum dari setiap tabel)
            $total = 0;
            foreach ($documentConfigs as $config) {
                $count = \DB::table($config['table'])
                    ->where('uuid_pasien', $uuid_pasien)
                    ->whereNull('deleted_at');

                if (!empty($search)) {
                    $count->where(function ($q) use ($search) {
                        $q->where('nama', 'ILIKE', "%{$search}%")
                            ->orWhere('no_rm', 'ILIKE', "%{$search}%");
                    });
                }

                $total += $count->count();
            }

            // ✨ GET DATA dengan UNION
            $data = collect();

            foreach ($documentConfigs as $config) {
                $query = \DB::table($config['table'])
                    ->select(
                        'uuid',
                        'uuid_pasien',
                        \DB::raw($this->mapField($config['table'], 'tanggal') . ' as tanggal'),
                        \DB::raw($this->mapField($config['table'], 'waktu') . '::text as waktu'),
                        'no_rm',
                        'nama',
                        'jenis_kelamin',
                        'nik',
                        // \DB::raw($this->mapField($config['table'], 'user_pelaksana') . ' as user_pelaksana'),
                        // \DB::raw($this->mapField($config['table'], 'detail_info') . ' as detail_info'),
                        'created_at',
                        'updated_at',
                        \DB::raw("'{$config['type']}' as document_type"),
                        \DB::raw("'{$config['label']}' as document_label"),
                        \DB::raw("'{$config['icon']}' as document_icon"),
                        \DB::raw("'{$config['color']}' as document_color")
                    )
                    ->where('uuid_pasien', $uuid_pasien)
                    ->whereNull('deleted_at');

                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nama', 'ILIKE', "%{$search}%")
                            ->orWhere('no_rm', 'ILIKE', "%{$search}%");
                    });
                }

                $data = $data->merge($query->get());
            }

            // Sort and paginate in PHP
            $data = $data->sortByDesc(function ($item) {
                return $item->tanggal . ' ' . $item->waktu;
            })->values();

            $paginatedData = $data->slice($offset, $limit)->values();

            $totalPages = ceil($total / $limit);

            return response()->json([
                'status' => true,
                'data' => $paginatedData,
                'pagination' => [
                    'total' => $total,
                    'per_page' => (int)$limit,
                    'current_page' => (int)$page,
                    'total_pages' => $totalPages,
                    'from' => $offset + 1,
                    'to' => min($offset + $limit, $total)
                ],
                'document_types' => array_map(function ($config) {
                    return [
                        'type' => $config['type'],
                        'label' => $config['label'],
                        'icon' => $config['icon'],
                        'color' => $config['color']
                    ];
                }, $documentConfigs)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data lampiran',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function mapField($table, $fieldType)
    {
        $mapping = [
            'dokumen_form_laser_barbage' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                // 'user_pelaksana' => 'dokter_pelaksana',
                // 'detail_info' => 'jenis_laser'
            ],
            'dokumen_laporan_pembedahan' => [
                'tanggal' => 'tanggal_operasi',
                'waktu' => 'jam_mulai',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_balance_cairan_harian' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_resume_perawatan_rawat_jalan' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_surat_penolakan_rujukan' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_surat_kontrol' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_surat_balasan_konsul' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_surat_pernyataan_batal_operasi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            // Tambahkan mapping untuk tabel baru di sini
        ];

        return $mapping[$table][$fieldType] ?? $fieldType;
    }

    /**
     * Helper: Get original field name from alias
     */
    private function getOriginalFieldName($selectFields, $alias)
    {
        foreach ($selectFields as $field) {
            if (is_string($field) && strpos($field, " as {$alias}") !== false) {
                return trim(str_replace(" as {$alias}", '', $field));
            }
        }
        return null;
    }

    /**
     * Get Detail Dokumen by UUID and Type
     */
    public function getDetailLampiran(Request $request, $uuid)
    {
        try {
            $type = $request->input('type');

            // Map document type to table
            $tableMap = [
                'laser_bargage' => 'dokumen_form_laser_bargage',
                'laporan_bedah' => 'laporan_pembedahan',
                'informed_consent' => 'dokumen_informed_consent',
                // Tambahkan mapping baru di sini
            ];

            if (!isset($tableMap[$type])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tipe dokumen tidak valid'
                ], 400);
            }

            $data = \DB::table($tableMap[$type])
                ->where('uuid', $uuid)
                ->whereNull('deleted_at')
                ->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $data,
                'type' => $type
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Dokumen by UUID and Type
     */
    public function deleteLampiran(Request $request, $uuid)
    {
        try {
            $type = $request->input('type');

            $pengguna_nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER') . 'Nama'));

            $tableMap = [
                'laser_bargage' => 'dokumen_form_laser_bargage',
                'laporan_bedah' => 'laporan_pembedahan',
                'informed_consent' => 'dokumen_informed_consent',
            ];

            if (!isset($tableMap[$type])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tipe dokumen tidak valid'
                ], 400);
            }

            \DB::beginTransaction();

            $affected = \DB::table($tableMap[$type])
                ->where('uuid', $uuid)
                ->update([
                    'deleted_at' => now(),
                    'updated_by' => $pengguna_nama
                ]);

            if ($affected === 0) {
                \DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Dokumen berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus dokumen',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
