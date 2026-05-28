<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPengkajianAwalMedisMata extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_pengkajian_awal_medis_mata';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',

        // Header
        'tanggal',
        'jam',

        // Alergi & Sumber Data
        'alergi',
        'sumber_pasien',
        'sumber_keluarga',
        'sumber_teman',
        'sumber_lainnya',
        'sumber_lainnya_text',

        // Penilaian Nyeri
        'skala_nyeri',
        'skala_nyeri_text',
        'nyeri_ada',
        'nyeri_lokasi',
        'nyeri_karakteristik',
        'nyeri_durasi',
        'nyeri_frekuensi',

        // Anamnesa
        'keluhan_utama',
        'riwayat_penyakit_sekarang',
        'riwayat_penyakit_dahulu',
        'riwayat_pengobatan',

        // Riwayat Penyakit Keluarga
        'rpk_hipertensi',
        'rpk_diabetes',
        'rpk_jantung',
        'rpk_stroke',
        'rpk_dialysis',
        'rpk_asthma',
        'rpk_kejang',
        'rpk_liver',
        'rpk_cancer',
        'rpk_tbc',
        'rpk_glaukoma',
        'rpk_std',
        'rpk_perdarahan',
        'rpk_lain_lain',
        'rpk_lain_lain_text',

        // Riwayat Operasi & Transfusi
        'riwayat_operasi',
        'riwayat_operasi_keterangan',
        'riwayat_transfusi',
        'reaksi_transfusi',
        'reaksi_transfusi_text',

        // Sosial
        'riwayat_sosial',

        // Tanda-Tanda Vital
        'keadaan_umum',
        'gizi',
        'gcs_e',
        'gcs_m',
        'gcs_v',
        'bb',
        'tindakan_resusitasi',
        'tensi',
        'suhu_ttv',
        'nadi_ttv',
        'respirasi',
        'saturasi_o2',
        'oksigen_jenis',
        'oksigen_lainnya_text',

        // Pemeriksaan Fisik
        'pf_ku_baik',
        'pf_ku_sedang',
        'pf_ku_lemah',
        'pf_ku_buruk',
        'pf_kes_cm',
        'pf_kes_somnolen',
        'pf_kes_koma',
        'pf_gcs_e',
        'pf_gcs_v',
        'pf_gcs_m',
        'tekanan_darah',
        'nadi_pf',
        'nadi_regularitas',
        'rr',
        'spo2',
        'temp',
        'reflex_cahaya',
        'akral',
        'kepala',
        'leher',
        'jantung_inspeksi',
        'jantung_palpasi',
        'jantung_perkusi',
        'jantung_auskultasi',

        // Pemeriksaan Mata
        'mata_visus_od',
        'mata_visus_os',
        'mata_pgbm_od',
        'mata_pgbm_os',
        'mata_palpebra_sup_od',
        'mata_palpebra_sup_os',
        'mata_palpebra_inf_od',
        'mata_palpebra_inf_os',
        'mata_kornea_od',
        'mata_kornea_os',
        'mata_iris_od',
        'mata_iris_os',
        'mata_konjungtiva_od',
        'mata_konjungtiva_os',
        'mata_sekret_od',
        'mata_sekret_os',
        'mata_tio_od',
        'mata_tio_os',
        'mata_pupil_reflek_od',
        'mata_pupil_reflek_os',
        'mata_pupil_ukuran_od',
        'mata_pupil_ukuran_os',
        'mata_pupil_isokor_od',
        'mata_pupil_isokor_os',

        // Penunjang & Diagnosa
        'status_lokalis',
        'pemeriksaan_penunjang',
        'diagnosa_kerja',
        'diagnosa_diferensial',
        'terapi',
        'rencana_kerja',

        // Hasil & Disposisi
        'hasil_pembedahan',
        'cb_boleh_pulang',
        'disposisi_pulang_jam',
        'disposisi_pulang_tanggal',
        'cb_kontrol_poliklinik',
        'kontrol_poliklinik',
        'kontrol_tujuan',
        'kontrol_tanggal',
        'cb_dirawat_ruangan',
        'cb_dirawat_kelas',
        'dirawat_ruangan',
        'dirawat_kelas',
        'rekomendasi',
        'catatan_penting',

        // TTD
        'kota_ttd',
        'tanggal_ttd',
        'jam_ttd',
        'ttd_dpjp',
        'nama_dpjp',
        'ttd_dpjp_timestamp',

        // Meta
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $model->no_surat = 'RM 7.7/PAMM/22';
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
