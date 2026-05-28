<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenEvaluasiPraAnestesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_evaluasi_pra_anestesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_ttd',

        // Header
        'diagnosa_medis',
        'tanggal',
        'jam',
        'ruangan',
        'umur',
        'jk',
        'menikah',
        'pekerjaan',

        // Kebiasaan
        'merokok',
        'merokok_sebanyak',
        'kopi_teh_soda',
        'kopi_teh_soda_sebanyak',
        'alkohol',
        'alkohol_sebanyak',
        'olahraga_rutin',
        'olahraga_rutin_sebanyak',

        // Pengobatan
        'obat_resep',
        'obat_bebas',
        'aspirin_rutin',
        'aspirin_dosis',
        'obat_anti_sakit',
        'obat_anti_sakit_dosis',
        'injeksi_steroid',
        'injeksi_steroid_info',
        'alergi_obat',
        'alergi_obat_daftar',
        'alergi_lateks',
        'alergi_plaster',
        'alergi_makanan',

        // Riwayat Keluarga
        'kel_perdarahan',
        'kel_serangan_jantung',
        'kel_pembekuan',
        'kel_hipertensi',
        'kel_pembuluh_darah',
        'kel_tuberkulosis',
        'kel_operasi_jantung',
        'kel_penyakit_berat_lainnya',
        'kel_diabetes',
        'kel_jelaskan',

        // Komunikasi
        'bahasa_indonesia',
        'bahasa_lainnya_cb',
        'bahasa_lainnya',
        'gangguan_penglihatan',
        'gangguan_pendengaran',
        'gangguan_bicara',

        // Riwayat Penyakit Pasien
        'rp_perdarahan',
        'rp_serangan_jantung',
        'rp_pembekuan',
        'rp_hepatitis',
        'rp_sakit_maag',
        'rp_sleep_apnea',
        'rp_stroke',
        'rp_penyakit_berat_lainnya',
        'rp_sesak_napas',
        'rp_asma',
        'rp_diabetes',
        'rp_pingsan',
        'rp_jelaskan',
        'transfusi_darah',
        'transfusi_darah_tahun',
        'hiv_diperiksa',
        'hiv_tahun',
        'hiv_hasil',
        'kemoterapi_radioterapi',
        'lensa_kontak',
        'kacamata',
        'alat_bantu_dengar',
        'gigi_palsu_alat',
        'riwayat_operasi',
        'anestesi_lokal_komplikasi',
        'anestesi_regional_komplikasi',
        'anestesi_umum_komplikasi',
        'tgl_terakhir_periksa',
        'tempat_periksa',
        'penyakit_gangguan',

        // Khusus Perempuan
        'jumlah_kehamilan',
        'jumlah_anak',
        'menstruasi_terakhir',
        'menyusui',

        // Dokter - Kajian Sistem
        'dok_hilangnya_gigi',
        'dok_sakit_dada',
        'dok_mobilisasi_lider',
        'dok_denyut_jantung',
        'dok_lebar_perotok',
        'dok_muntah',
        'dok_sakit_tenggorokan',
        'dok_perut_pusing',
        'dok_sesak_nafas',
        'dok_kejang',
        'dok_baru_infeksi',
        'dok_sedang_hamil',
        'dok_saluran_nafas_atas',
        'dok_pingsan',
        'dok_menstruasi_tidak_normal',
        'dok_obesitas',
        'dok_stroke',
        'dok_keterangan',
        'dok_periode_tidak_stabil',

        // Keadaan Umum
        'kesadaran',
        'visue',
        'faring',
        'gigi_palsu',

        // Pemeriksaan Fisik
        'tinggi',
        'berat',
        'td',
        'nadi',
        'suhu',
        'paru_paru',
        'jantung',
        'abdomen',
        'ekstrimitas',
        'neurologi',
        'fisik_keterangan',

        // Laboratorium
        'lab_hb_ht',
        'lab_rontgen_dada',
        'lab_pt_aptt',
        'lab_ekg',
        'lab_tes_kehamilan',
        'lab_co2',
        'lab_kalium',
        'lab_kreatinin',
        'lab_uream',
        'lab_glukosa',
        'lab_lain_lain',
        'lab_keterangan',

        // Diagnosis
        'asa_klasifikasi',

        // Rekomendasi Anestesi
        'rek_anestesi_umum',
        'rek_au_intevena',
        'rek_au_sungkup_muka',
        'rek_au_lma',
        'rek_au_ett',
        'rek_regional',
        'rek_reg_spinal',
        'rek_reg_epidural',
        'rek_reg_cse',
        'rek_reg_pnb',
        'rek_umum_plus_regional',
        'puasa_mulai_jam',
        'puasa_mulai_tanggal',
        'rencana_elasi_jam',
        'rencana_elasi_tanggal',
        'rencana_operasi_jam',
        'rencana_operasi_tanggal',

        // TTD
        'ttd_dokter',
        'nama_dokter',
        'ttd_dokter_timestamp',

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
                $model->no_surat = 'RM 4.10/EPA/22';
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
