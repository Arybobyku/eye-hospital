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
use Illuminate\Support\Facades\Crypt;  // ✅ TAMBAHKAN INI
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

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
                    'table' => 'dokumen_form_laser_barrage',
                    'type' => 'dokumen_form_laser_barrage',
                    'label' => 'Form Laser Bargage',
                    'icon' => 'fa-laser-pointer',
                    'color' => '#FF6B35', // Orange terang
                ],
                [
                    'table' => 'dokumen_laporan_pembedahan',
                    'type' => 'laporan_bedah',
                    'label' => 'Laporan Pembedahan',
                    'icon' => 'fa-user-doctor',
                    'color' => '#E63946', // Merah bedah
                ],
                [
                    'table' => 'dokumen_balance_cairan_harian',
                    'type' => 'balance_cairan_harian',
                    'label' => 'Balance Cairan Harian',
                    'icon' => 'fa-droplet',
                    'color' => '#4FC3F7', // Biru air
                ],
                [
                    'table' => 'dokumen_resume_perawatan_rawat_jalan',
                    'type' => 'resume_perawatan_rawat_jalan',
                    'label' => 'Resume Perawatan Rawat Jalan',
                    'icon' => 'fa-clipboard-check',
                    'color' => '#26A69A', // Teal
                ],
                [
                    'table' => 'dokumen_surat_penolakan_rujukan',
                    'type' => 'surat_penolakan_rujukan',
                    'label' => 'Surat Penolakan Rujukan',
                    'icon' => 'fa-ban',
                    'color' => '#EF5350', // Merah penolakan
                ],
                [
                    'table' => 'dokumen_surat_kontrol',
                    'type' => 'surat_kontrol_ulang',
                    'label' => 'Surat Kontrol Ulang',
                    'icon' => 'fa-calendar-check',
                    'color' => '#AB47BC', // Ungu
                ],
                [
                    'table' => 'dokumen_surat_konsul',
                    'type' => 'surat_konsul',
                    'label' => 'Surat Konsultasi',
                    'icon' => 'fa-comments-medical',
                    'color' => '#FF9800', // Orange gelap
                ],
                [
                    'table' => 'dokumen_surat_balasan_konsul',
                    'type' => 'surat_balasan_konsul',
                    'label' => 'Surat Balasan Konsultasi',
                    'icon' => 'fa-reply-all',
                    'color' => '#FFA726', // Orange terang
                ],
                [
                    'table' => 'dokumen_surat_pernyataan_batal_operasi',
                    'type' => 'surat_pernyataan_batal_operasi',
                    'label' => 'Surat Pernyataan Batal Operasi',
                    'icon' => 'fa-file-circle-xmark',
                    'color' => '#D32F2F', // Merah tua
                ],
                [
                    'table' => 'dokumen_surat_pernyataan_pasien_umum',
                    'type' => 'surat_pernyataan_pasien_umum',
                    'label' => 'Surat Pernyataan Pasien Umum',
                    'icon' => 'fa-file-signature',
                    'color' => '#5C6BC0', // Indigo
                ],
                [
                    'table' => 'dokumen_dietitian_pasien_baru',
                    'type' => 'dokumen_dietitian_pasien_baru',
                    'label' => 'Dietitian Pasien Baru',
                    'icon' => 'fa-apple-whole',
                    'color' => '#66BB6A', // Hijau segar
                ],
                [
                    'table' => 'dokumen_asuhan_gizi',
                    'type' => 'dokumen_asuhan_gizi',
                    'label' => 'Dokumen Asuhan Gizi',
                    'icon' => 'fa-utensils',
                    'color' => '#8BC34A', // Hijau lime
                ],
                [
                    'table' => 'dokumen_tindakan_laser_lpi',
                    'type' => 'dokumen_tindakan_laser_lpi',
                    'label' => 'Dokumen Tindakan Laser LPI',
                    'icon' => 'fa-circle-radiation',
                    'color' => '#00BCD4', // Cyan
                ],
                [
                    'table' => 'dokumen_ceklist_kesiapan_bedah',
                    'type' => 'dokumen_ceklist_kesiapan_bedah',
                    'label' => 'Dokumen Ceklist Kesiapan Bedah',
                    'icon' => 'fa-eye',
                    'color' => '#0D47A1', // Biru sangat tua
                ],
                [
                    'table' => 'form_edukasi_pasien_dan_keluarga_rawat_jalan',
                    'type' => 'form_edukasi_pasien_dan_keluarga_rawat_jalan',
                    'label' => 'Form Edukasi Pasien Dan Keluarga Rawat Jalan',
                    'icon' => 'fa-eye',
                    'color' => '#0F5DBB', // Biru tua
                ],
                [
                    'table' => 'form_persetujuan_umum_pasien_keluarga',
                    'type' => 'form_persetujuan_umum_pasien_keluarga',
                    'label' => 'Form Persetujuan Umum Pasien Keluarga',
                    'icon' => 'fa-eye',
                    'color' => '#1565C0', // Biru solid
                ],
                [
                    'table' => 'form_proses_perawatan_peri_operative',
                    'type' => 'form_proses_perawatan_peri_operative',
                    'label' => 'Form Proses Perawatan Peri Operative',
                    'icon' => 'fa-eye',
                    'color' => '#1976D2', // Biru medium
                ],
                [
                    'table' => 'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap',
                    'type' => 'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap',
                    'label' => 'Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap',
                    'icon' => 'fa-eye',
                    'color' => '#1E88E5', // Biru cerah (masih aman)
                ],
                [
                    'table' => 'penolakan_tindakan_anestesi',
                    'type' => 'penolakan_tindakan_anestesi',
                    'label' => 'Penolakan Tindakan Anestesi',
                    'icon' => 'fa-eye',
                    'color' => '#0d6ec4',
                    'filter' => ['jenis_form' => 'penolakan'], // 🔥 FILTER KHUSUS
                ],
                [
                    'table' => 'penolakan_tindakan_anestesi',
                    'type' => 'penolakan_tindakan_anestesi',
                    'label' => 'Persetujuan Tindakan Anestesi',
                    'icon' => 'fa-eye',
                    'color' => '#043f72',
                    'filter' => ['jenis_form' => 'persetujuan'], // 🔥 FILTER KHUSUS
                ],
                [
                    'table' => 'form_pengkajian_keperawatan_mata_rawat_jalan',
                    'type' => 'form_pengkajian_keperawatan_mata_rawat_jalan',
                    'label' => 'Form Pengkajian Keperawatan Mata Rawat Jalan',
                    'icon' => 'fa-eye',
                    'color' => '#1C7ED6', // Biru medium terang
                ],
                [
                    'table' => 'form_laporan_injeksi',
                    'type' => 'form_laporan_injeksi',
                    'label' => 'Form Laporan Injeksi',
                    'icon' => 'fa-eye',
                    'color' => '#1864AB', // Biru tenang
                ],
                [
                    'table' => 'form_permintaan_pulang',
                    'type' => 'form_permintaan_pulang',
                    'label' => 'Form Permintaan Pulang',
                    'icon' => 'fa-eye',
                    'color' => '#1450A3', // Biru agak tua
                ],
                [
                    'table' => 'voucher_rawat_inap',
                    'type' => 'voucher_rawat_inap',
                    'label' => 'Voucher Rawat Inap',
                    'icon' => 'fa-eye',
                    'color' => '#0B5394', // Biru dalam
                ],
                [
                    'table' => 'form_reaksi_transfusi_darah',
                    'type' => 'form_reaksi_transfusi_darah',
                    'label' => 'Form Reaksi Transfusi Darah',
                    'icon' => 'fa-eye',
                    'color' => '#083D77', // Biru paling gelap
                ],
                [
                    'table' => 'dokumen_tindakan_laser_prp',
                    'type' => 'dokumen_tindakan_laser_prp',
                    'label' => 'Dokumen Tindakan Laser PRP',
                    'icon' => 'fa-bolt',
                    'color' => '#0097A7', // Cyan gelap
                ],
                [
                    'table' => 'dokumen_laporan_operasi_trabekulektomi',
                    'type' => 'dokumen_laporan_operasi_trabekulektomi',
                    'label' => 'Dokumen Laporan Operasi Trabekulektomi',
                    'icon' => 'fa-eye-dropper',
                    'color' => '#7B1FA2', // Ungu tua
                ],
                [
                    'table' => 'dokumen_laporan_operasi_pterygium',
                    'type' => 'dokumen_laporan_operasi_pterygium',
                    'label' => 'Dokumen Laporan Operasi Pterygium',
                    'icon' => 'fa-eye-low-vision',
                    'color' => '#C2185B', // Pink tua
                ],
                [
                    'table' => 'dokumen_laporan_eksisi_palpebra',
                    'type' => 'dokumen_laporan_eksisi_palpebra',
                    'label' => 'Dokumen Laporan Eksisi Palbebra',
                    'icon' => 'fa-scissors',
                    'color' => '#F57C00', // Orange tua
                ],
                [
                    'table' => 'dokumen_laporan_eksisi_chalazion',
                    'type' => 'dokumen_laporan_eksisi_chalazion',
                    'label' => 'Dokumen Laporan Eksisi Chalazion',
                    'icon' => 'fa-scalpel-line-dashed',
                    'color' => '#FF5722', // Deep Orange
                ],
                [
                    'table' => 'dokumen_pulang_atas_permintaan_sendiri',
                    'type' => 'dokumen_pulang_atas_permintaan_sendiri',
                    'label' => 'Dokumen Pulang Atas Permintaan Sendiri',
                    'icon' => 'fa-person-walking-arrow-right',
                    'color' => '#607D8B', // Blue Grey
                ],
                [
                    'table' => 'dokumen_tindakan_laser_capsulotomy',
                    'type' => 'dokumen_tindakan_laser_capsulotomy',
                    'label' => 'Dokumen Tindakan Laser Capsulotomy',
                    'icon' => 'fa-burst',
                    'color' => '#00ACC1', // Cyan accent
                ],
                [
                    'table' => 'dokumen_tindakan_epilasi',
                    'type' => 'dokumen_tindakan_epilasi',
                    'label' => 'Dokumen Tindakan Epilasi',
                    'icon' => 'fa-hand-sparkles',
                    'color' => '#9C27B0', // Purple
                ],
                [
                    'table' => 'dokumen_kronologis_pasien',
                    'type' => 'dokumen_kronologis_pasien',
                    'label' => 'Dokumen Kronologi Pasien',
                    'icon' => 'fa-hand-sparkles',
                    'color' => '#9C27B0', // Purple
                ],
                [
                    'table' => 'dokumen_catatan_operasi',
                    'type' => 'dokumen_catatan_operasi',
                    'label' => 'Dokumen Catatan Operasi',
                    'icon' => 'fa-hand-sparkles',
                    'color' => '#9C27B0', // Purple
                ],
                [
                    'table' => 'dokumen_resume_medis_rawat_jalan',
                    'type' => 'resume_medis_rawat_jalan',
                    'label' => 'Dokumen Resume Medis Rawat Jalan',
                    'icon' => 'fa-hand-sparkles',
                    'color' => '#2196F3', // Blue
                ],
                [
                    'table' => 'dokumen_resume_medis_rawat_inap',
                    'type' => 'resume_medis_rawat_inap',
                    'label' => 'Dokumen Resume Medis Rawat Inap',
                    'icon' => 'fa-hand-sparkles',
                    'color' => '#4CAF50', // Green
                ],
                [
                    'table' => 'dokumen_asesmen_keperawatan_rawat_inap',
                    'type' => 'asesmen_keperawatan_rawat_inap',
                    'label' => 'Dokumen Assesmen Keperawatan Rawat Inap',
                    'icon' => 'fa fa-bed',
                    'color' => '#FF9800', // Orange
                ],
                [
                    'table' => 'dokumen_cppt_rawat_inap',
                    'type' => 'cppt_rawat_inap',
                    'label' => 'Dokumen CPPT Rawat Inap',
                    'icon' => 'fa fa-bed',
                    'color' => '#E91E63', // Pink
                ],
                [
                    'table' => 'dokumen_monitoring_efek_samping_obat',
                    'type' => 'monitoring_efek_samping_obat',
                    'label' => 'Dokumen Monitoring Efek Samping Obat',
                    'icon' => 'fa fa-glass',
                    'color' => '#1ABC9C', // Turquoise
                ],
                [
                    'table' => 'dokumen_catatan_keperawatan',
                    'type' => 'catatan_keperawatan',
                    'label' => 'Dokumen Catatan Keperawatan',
                    'icon' => 'fa fa-bed',
                    'color' => '#673AB7', // Depp Purple
                ],
                [
                    'table' => 'dokumen_form_laser_fokal',
                    'type' => 'dokumen_form_laser_fokal',
                    'label' => 'Dokumen Form Laser Fokal',
                    'icon' => 'fa fa-bed',
                    'color' => '#673AB7', // Depp Purple
                ],
                [
                    'table' => 'dokumen_status_anestesi',
                    'type' => 'status_anestesi',
                    'label' => 'Dokumen Status Anestesi',
                    'icon' => 'fa fa-bed',
                    'color' => '#FF0000', // RED
                ],
                [
                    'table' => 'dokumen_laporan_operasi_vitreo_retina',
                    'type' => 'laporan_operasi_vitreo_retina',
                    'label' => 'Dokumen Laporan Operasi Vitreo Retina',
                    'icon' => 'fa fa-eye',
                    'color' => '#FF0000', // rED
                ],

            ];
            // ✨ GET TOTAL COUNT (sum dari setiap tabel)
            $total = 0;
            foreach ($documentConfigs as $config) {
                $count = \DB::table($config['table'])
                    ->where('uuid_pasien', $uuid_pasien)
                    ->whereNull('deleted_at');

            if (isset($config['filter'])) {
                foreach ($config['filter'] as $key => $value) {
                    $count->where($key, $value);
                }
            }

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
                        'created_by',
                        'updated_at',
                        'updated_by',
                        \DB::raw("'{$config['type']}' as document_type"),
                        \DB::raw("'{$config['label']}' as document_label"),
                        \DB::raw("'{$config['icon']}' as document_icon"),
                        \DB::raw("'{$config['color']}' as document_color")
                    )
                    ->where('uuid_pasien', $uuid_pasien)
                    ->whereNull('deleted_at');

                                // 🔥 APPLY FILTER JIKA ADA
            if (isset($config['filter'])) {
                foreach ($config['filter'] as $key => $value) {
                    $query->where($key, $value);
                }
            }

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
            'dokumen_form_laser_barrage' => [
                'tanggal' => 'tanggal',
                'waktu' => 'created_at',
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
            'dokumen_surat_konsul' => [
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
            'dokumen_surat_pernyataan_pasien_umum' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_dietitian_pasien_baru' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_ceklist_kesiapan_bedah' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_edukasi_pasien_dan_keluarga_rawat_jalan' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_persetujuan_umum_pasien_keluarga' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_proses_perawatan_peri_operative' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'penolakan_tindakan_anestesi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_pengkajian_keperawatan_mata_rawat_jalan' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_laporan_injeksi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_permintaan_pulang' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'voucher_rawat_inap' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'form_reaksi_transfusi_darah' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_asuhan_gizi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_tindakan_laser_lpi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_tindakan_laser_prp' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_laporan_operasi_trabekulektomi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_laporan_operasi_pterygium' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_laporan_eksisi_palpebra' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_laporan_eksisi_chalazion' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_pulang_atas_permintaan_sendiri' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_tindakan_laser_capsulotomy' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_tindakan_epilasi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_kronologis_pasien' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_catatan_operasi' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_resume_medis_rawat_jalan' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_resume_medis_rawat_inap' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_asesmen_keperawatan_rawat_inap' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_form_laser_fokal' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'      
            ],
            'dokumen_laporan_operasi_vitreo_retina' => [
                'tanggal' => 'created_at',
                'waktu' => 'created_at',
                // 'user_pelaksana' => 'pembedahan',
                // 'detail_info' => 'jenis_operasi_detail'
            ],
            'dokumen_status_anestesi' => [
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
                'dokumen_form_laser_barrage' => 'dokumen_form_laser_barrage',
                'laporan_bedah' => 'laporan_pembedahan',
                'informed_consent' => 'dokumen_informed_consent',
                'surat_pernyataan_pasien_umum' => 'dokumen_surat_pernyataan_pasien_umum',
                'surat_balasan_konsul' => 'dokumen_surat_balasan_konsul',
                'surat_konsul' => 'dokumen_surat_konsul',
                'surat_pernyataan_batal_operasi' => 'dokumen_surat_pernyataan_batal_operasi',
                'surat_kontrol_ulang' => 'dokumen_surat_kontrol',
                'surat_penolakan_rujukan' => 'dokumen_surat_penolakan_rujukan',
                'resume_perawatan_rawat_jalan' => 'dokumen_resume_perawatan_rawat_jalan',
                'balance_cairan_harian' => 'dokumen_balance_cairan_harian',
                'balance_cairan_harian' => 'dokumen_balance_cairan_harian',
                'dokumen_dietitian_pasien_baru' => 'dokumen_dietitian_pasien_baru',
                'dokumen_asuhan_gizi' => 'dokumen_asuhan_gizi',
                'dokumen_tindakan_laser_lpi' => 'dokumen_tindakan_laser_lpi',
                'dokumen_ceklist_kesiapan_bedah' => 'dokumen_ceklist_kesiapan_bedah',
                'form_edukasi_pasien_dan_keluarga_rawat_jalan' => 'form_edukasi_pasien_dan_keluarga_rawat_jalan',
                'form_persetujuan_umum_pasien_keluarga' => 'form_persetujuan_umum_pasien_keluarga',
                'form_proses_perawatan_peri_operative' => 'form_proses_perawatan_peri_operative',
                'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap' => 'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap',
                'penolakan_tindakan_anestesi' => 'penolakan_tindakan_anestesi',
                'persetujuan_tindakan_anestesi' => 'penolakan_tindakan_anestesi',
                'form_pengkajian_keperawatan_mata_rawat_jalan' => 'form_pengkajian_keperawatan_mata_rawat_jalan',
                'form_laporan_injeksi' => 'form_laporan_injeksi',
                'form_permintaan_pulang' => 'form_permintaan_pulang',
                'form_reaksi_transfusi_darah' => 'form_reaksi_transfusi_darah',
                'voucher_rawat_inap' => 'voucher_rawat_inap',
                'dokumen_tindakan_laser_prp' => 'dokumen_tindakan_laser_prp',
                'dokumen_laporan_operasi_trabekulektomi' => 'dokumen_laporan_operasi_trabekulektomi',
                'dokumen_laporan_operasi_pterygium' => 'dokumen_laporan_operasi_pterygium',
                'dokumen_laporan_eksisi_palpebra' => 'dokumen_laporan_eksisi_palpebra',
                'dokumen_laporan_eksisi_chalazion' => 'dokumen_laporan_eksisi_chalazion',
                'dokumen_pulang_atas_permintaan_sendiri' => 'dokumen_pulang_atas_permintaan_sendiri',
                'dokumen_tindakan_laser_capsulotomy' => 'dokumen_tindakan_laser_capsulotomy',
                'dokumen_tindakan_epilasi' => 'dokumen_tindakan_epilasi',
                'dokumen_kronologis_pasien' => 'dokumen_kronologis_pasien',
                'dokumen_catatan_operasi' => 'dokumen_catatan_operasi',
                'asesmen_keperawatan_rawat_inap' => 'dokumen_asesmen_keperawatan_rawat_inap',
                'resume_medis_rawat_jalan' => 'dokumen_resume_medis_rawat_jalan',
                'resume_medis_rawat_inap' => 'dokumen_resume_medis_rawat_inap',
                'cppt_rawat_inap' => 'dokumen_cppt_rawat_inap',
                'monitoring_efek_samping_obat' => 'dokumen_monitoring_efek_samping_obat',
                'catatan_keperawatan' => 'dokumen_catatan_keperawatan',
                'dokumen_form_laser_fokal' => 'dokumen_form_laser_fokal',
                'laporan_operasi_vitreo_retina' => 'dokumen_laporan_operasi_vitreo_retina',
                'status_anestesi' => 'dokumen_status_anestesi',
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

                //tambahkan untuk delete disini
                'dokumen_ceklist_kesiapan_bedah' => 'dokumen_ceklist_kesiapan_bedah',
                'form_edukasi_pasien_dan_keluarga_rawat_jalan' => 'form_edukasi_pasien_dan_keluarga_rawat_jalan',
                'form_persetujuan_umum_pasien_keluarga' => 'form_persetujuan_umum_pasien_keluarga',
                'form_proses_perawatan_peri_operative' => 'form_proses_perawatan_peri_operative',
                'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap' => 'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap',
                'penolakan_tindakan_anestesi' => 'penolakan_tindakan_anestesi',
                'persetujuan_tindakan_anestesi' => 'penolakan_tindakan_anestesi',
                'form_pengkajian_keperawatan_mata_rawat_jalan' => 'form_pengkajian_keperawatan_mata_rawat_jalan',
                'form_laporan_injeksi' => 'form_laporan_injeksi',
                'form_permintaan_pulang' => 'form_permintaan_pulang',
                'voucher_rawat_inap' => 'voucher_rawat_inap',
                'form_reaksi_transfusi_darah' => 'form_reaksi_transfusi_darah',
                'dokumen_form_laser_fokal' => 'dokumen_form_laser_fokal',
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
