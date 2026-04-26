<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenAsesmenKeperawatanRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_asesmen_keperawatan_rawat_inap';
    protected $guarded = ['id'];
    protected $fillable = [
        'uuid_pasien', 'date', 'time', 'no_rm','no_surat', 'nama', 'tanggal_lahir', 
        'jenis_kelamin', 'nik',
        // Alergi
        'tidak_ada_alergi', 'alergi_obat_check', 'alergi_obat', 'alergi_obat_reaksi',
        'alergi_makanan_check', 'alergi_makanan', 'alergi_makanan_reaksi',
        'alergi_lainnya_check', 'alergi_lainnya', 'alergi_lainnya_reaksi',
        'diberitahu_alergi', 'diberitahu_alergi_pukul', 'gelang_alergi', 'tidak_diketahui',
        // Keadaan Umum
        'kesadaran', 'gcs_e', 'gcs_v', 'gcs_m', 'tekanan_darah', 'nadi', 'rr', 
        'spo2', 'suhu', 'berat_badan', 'tinggi_badan', 'lingkar_kepala', 'lila',
        // Pemeriksaan Fisik
        'pernafasan', 'pernafasan_ket', 'penglihatan', 'penglihatan_ket',
        'pendengaran', 'pendengaran_ket', 'bicara', 'bicara_ket',
        'mulut', 'mulut_ket', 'refleks_menelan', 'refleks_menelan_ket',
        'gastrointestinal', 'gastrointestinal_ket', 'defekasi', 'defekasi_ket',
        'miksi', 'miksi_ket', 'pola_tidur', 'pola_tidur_ket', 
        'kulit', 'kulit_lokasi',
        // Khusus Wanita
        'hamil', 'hpht', 'keluhan_menstruasi',
        // Risiko Jatuh
        'risiko_jatuh', 'gelang_risiko_jatuh', 'segitiga_risiko_jatuh',
        'risiko_jatuh_ke_dokter', 'risiko_jatuh_ke_dokter_pukul',
        // Psikososial
        'psikologis_cemas', 'psikologis_takut', 'psikologis_marah', 
        'psikologis_sedih', 'psikologis_bunuh_diri', 'psikologis_lainnya',
        'hubungan_keluarga', 'tempat_tinggal', 'kerabat_nama', 
        'kerabat_hubungan', 'kerabat_telepon',
        'bahasa_sehari', 'bahasa_daerah_sebutkan', 'perlu_penterjemah', 
        'penterjemah_bahasa', 'spiritual_kepercayaan',
        // Skala Norton
        'norton_fisik', 'norton_mental', 'norton_aktivitas', 
        'norton_mobilitas', 'norton_inkontinensia',
        // Skala Nyeri
        'keluhan_nyeri', 'skala_nyeri', 'nyeri_lokasi', 'nyeri_menjalar', 
        'nyeri_menjalar_ke', 'onset_nyeri',
        'nyeri_ditusuk', 'nyeri_ditikam', 'nyeri_berdenyut', 
        'nyeri_dipukul', 'nyeri_kram', 'nyeri_dibakar',
        'nyeri_tajam', 'nyeri_tumpul', 'nyeri_ditarik',
        'frekuensi_nyeri', 'lama_nyeri', 'nyeri_memburuk', 'nyeri_berkurang',
        // Skrining Gizi
        'gizi_penurunan_bb', 'gizi_asupan_makanan', 'gizi_ke_ahli', 'gizi_ke_ahli_pukul',
        // Status Fungsional
        'status_fungsional', 'status_fungsional_bantuan', 
        'fungsional_ke_dokter', 'fungsional_ke_dokter_pukul',
        // Diagnosa Keperawatan
        'diagnosa_keperawatan', 'diagnosa_tujuan', 'diagnosa_intervensi',
        // Discharge Planning
        'estimasi_pemulangan', 'tahu_rencana_pulang',
        'dp_berpengaruh', 'dp_berpengaruh_ket',
        'dp_mobilitas', 'dp_hygiene', 'dp_obat', 'dp_diet', 'dp_makanan', 
        'dp_lainnya_check', 'dp_lainnya',
        'dp_ada_yang_membantu', 'dp_yang_merawat',
        'dp_peralatan_medis', 'dp_peralatan_medis_ket',
        'dp_alat_bantu', 'dp_alat_bantu_ket',
        'dp_perawatan_lanjutan', 'dp_perawatan_lanjutan_ket',
        'dp_masalah_khusus', 'dp_masalah_khusus_ket',
        'dp_transportasi_aman', 'dp_transportasi_ket',
        'dp_edukasi', 'dp_edukasi_ket',
        // Perawat
        'tanggal_kaji', 'pukul_kaji', 'perawat_nama', 'perawat_ttd',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'tidak_ada_alergi' => 'boolean',
        'alergi_obat_check' => 'boolean',
        'alergi_makanan_check' => 'boolean',
        'alergi_lainnya_check' => 'boolean',
        'tidak_diketahui' => 'boolean',
        'gelang_risiko_jatuh' => 'boolean',
        'segitiga_risiko_jatuh' => 'boolean',
        'psikologis_cemas' => 'boolean',
        'psikologis_takut' => 'boolean',
        'psikologis_marah' => 'boolean',
        'psikologis_sedih' => 'boolean',
        'psikologis_bunuh_diri' => 'boolean',
        'nyeri_ditusuk' => 'boolean',
        'nyeri_ditikam' => 'boolean',
        'nyeri_berdenyut' => 'boolean',
        'nyeri_dipukul' => 'boolean',
        'nyeri_kram' => 'boolean',
        'nyeri_dibakar' => 'boolean',
        'nyeri_tajam' => 'boolean',
        'nyeri_tumpul' => 'boolean',
        'nyeri_ditarik' => 'boolean',
        'dp_mobilitas' => 'boolean',
        'dp_hygiene' => 'boolean',
        'dp_obat' => 'boolean',
        'dp_diet' => 'boolean',
        'dp_makanan' => 'boolean',
        'dp_lainnya_check' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $tahun = config('app.tahun_akreditasi', '22');
                $model->no_surat = "RM 3.8/MESO/{$tahun}";
            }
        });
    }
}   