<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenCatatanOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_catatan_operasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Default
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Data Pasien
        'nama_pasien',
        'no_rm_pasien',
        'nik_pasien',
        'tanggal_lahir_display',
        
        // Info Operasi
        'dokter_bedah',
        'perawat_scrub',
        'tanggal',
        'operasi_mulai',
        'operasi_selesai',
        'dokter_anestesi',
        'diagnosis_pra_bedah',
        'tindakan_operasi',
        'diagnosis_pasca_bedah',
        
        // Anesthesi (7)
        'anesthesi_topikal',
        'anesthesi_intracamelar',
        'anesthesi_retrobulbar',
        'anesthesi_nu',
        'anesthesi_subconjunctival',
        'anesthesi_xylocain',
        'anesthesi_lidocain',
        
        // Insisi (3)
        'insisi_kornea',
        'insisi_limbus',
        'insisi_sclera',
        
        // Wound (5)
        'wound_main_port',
        'wound_two_side_port',
        'wound_one_side_port',
        'wound_keratome',
        'wound_crescen_knife',
        
        // Capsulotomi (5)
        'capsulotomi_ccc',
        'capsulotomi_xmas_tree',
        'capsulotomi_linear',
        'capsulotomi_can_opener',
        'capsulotomi_tryphan_blue',
        
        // Teknik Tambahan (3)
        'teknik_ctr',
        'teknik_kapsulotomi_posterior',
        'teknik_vitrektomi_anterior',
        
        // Cairan Irigasi (2)
        'cairan_rl',
        'cairan_bss',
        
        // Lensa (6)
        'lensa_dalam_kantung',
        'lensa_diluar_kantung',
        'lensa_bilik_mata_depan',
        'lensa_afakia',
        'lensa_sulcus_siliaris',
        'lensa_fiksasi_scleral',
        
        // Viskoelastik (3)
        'visko_hpmc',
        'visko_viscoat',
        'visko_hyaluronic_acid',
        
        // Benang (3)
        'benang_tanpa_jahitan',
        'benang_ethylon',
        'benang_vicryl',
        
        // Komplikasi (8)
        'komplikasi_tidak_ada',
        'komplikasi_pcr',
        'komplikasi_prolaps_vitreous',
        'komplikasi_drop_nucleus',
        'komplikasi_perdarahan',
        'komplikasi_corneal_burn',
        'komplikasi_convert_ecce',
        'komplikasi_convert_icce',
        
        // Perawatan (2)
        'perawatan_pulang',
        'perawatan_opname',
        
        // Instruksi (4)
        'instruksi_perban_2jam',
        'instruksi_obat_setelah_buka',
        'instruksi_perban_tutup_kembali',
        'instruksi_pantangan',
        
        // Catatan & TTD
        'catatan_tambahan',
        'ttd_operator',
        'nama_operator',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        
        // Anesthesi
        'anesthesi_topikal' => 'boolean',
        'anesthesi_intracamelar' => 'boolean',
        'anesthesi_retrobulbar' => 'boolean',
        'anesthesi_nu' => 'boolean',
        'anesthesi_subconjunctival' => 'boolean',
        'anesthesi_xylocain' => 'boolean',
        'anesthesi_lidocain' => 'boolean',
        
        // Insisi
        'insisi_kornea' => 'boolean',
        'insisi_limbus' => 'boolean',
        'insisi_sclera' => 'boolean',
        
        // Wound
        'wound_main_port' => 'boolean',
        'wound_two_side_port' => 'boolean',
        'wound_one_side_port' => 'boolean',
        'wound_keratome' => 'boolean',
        'wound_crescen_knife' => 'boolean',
        
        // Capsulotomi
        'capsulotomi_ccc' => 'boolean',
        'capsulotomi_xmas_tree' => 'boolean',
        'capsulotomi_linear' => 'boolean',
        'capsulotomi_can_opener' => 'boolean',
        'capsulotomi_tryphan_blue' => 'boolean',
        
        // Teknik Tambahan
        'teknik_ctr' => 'boolean',
        'teknik_kapsulotomi_posterior' => 'boolean',
        'teknik_vitrektomi_anterior' => 'boolean',
        
        // Cairan
        'cairan_rl' => 'boolean',
        'cairan_bss' => 'boolean',
        
        // Lensa
        'lensa_dalam_kantung' => 'boolean',
        'lensa_diluar_kantung' => 'boolean',
        'lensa_bilik_mata_depan' => 'boolean',
        'lensa_afakia' => 'boolean',
        'lensa_sulcus_siliaris' => 'boolean',
        'lensa_fiksasi_scleral' => 'boolean',
        
        // Viskoelastik
        'visko_hpmc' => 'boolean',
        'visko_viscoat' => 'boolean',
        'visko_hyaluronic_acid' => 'boolean',
        
        // Benang
        'benang_tanpa_jahitan' => 'boolean',
        'benang_ethylon' => 'boolean',
        'benang_vicryl' => 'boolean',
        
        // Komplikasi
        'komplikasi_tidak_ada' => 'boolean',
        'komplikasi_pcr' => 'boolean',
        'komplikasi_prolaps_vitreous' => 'boolean',
        'komplikasi_drop_nucleus' => 'boolean',
        'komplikasi_perdarahan' => 'boolean',
        'komplikasi_corneal_burn' => 'boolean',
        'komplikasi_convert_ecce' => 'boolean',
        'komplikasi_convert_icce' => 'boolean',
        
        // Perawatan
        'perawatan_pulang' => 'boolean',
        'perawatan_opname' => 'boolean',
        
        // Instruksi
        'instruksi_perban_2jam' => 'boolean',
        'instruksi_obat_setelah_buka' => 'boolean',
        'instruksi_perban_tutup_kembali' => 'boolean',
        'instruksi_pantangan' => 'boolean',
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
                $model->no_surat = "RM 2.3/COK/{$tahun}";
            }
        });
    }

    /**
     * Relasi ke Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}