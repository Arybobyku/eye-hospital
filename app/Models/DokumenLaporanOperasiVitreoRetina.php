<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanOperasiVitreoRetina extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_operasi_vitreo_retina';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        
        // Informasi Operasi
        'tanggal_operasi',
        'jam_mulai_operasi',
        'jam_selesai_operasi',
        'area_operasi_od',
        'area_operasi_os',
        'dpjp_bedah',
        'asisten',
        'perawat_instrumen',
        'diagnosis_pre_operasi',
        'diagnosis_post_operasi',
        'jenis_tindakan_pembedahan',
        
        // Jenis Anestesi
        'anestesi_lokal',
        'anestesi_umum',
        'anestesi_sedasi',
        'anestesi_blok',
        'dpjp_anestesi',
        
        // Peritomi
        'peritomi_360',
        'peritomi_sebagian',
        
        // Kendala Otot
        'kendala_4_rektus',
        'kendala_rektus_superior',
        'kendala_tak_dilakukan',
        
        // Bakel Sklera
        'bakel_sirkuler_5mm',
        'bakel_sirkuler_4mm',
        'bakel_sirkuler_2_5mm',
        'bakel_sirkuler_2mm',
        'bakel_sponge',
        'bakel_tyre',
        'bakel_tyre_type',
        'bakel_tak_dilakukan',
        
        // Ikatan
        'ikatan_sleeve_ni',
        'ikatan_sleeve_ns',
        'ikatan_sleeve_ts',
        'ikatan_sleeve_ti',
        'ikatan_benang_ni',
        'ikatan_benang_ns',
        'ikatan_benang_ts',
        'ikatan_benang_ti',
        
        // Jahitan Bakel
        'jahitan_bakel_5_0',
        'jahitan_bakel_6_0',
        'jahitan_bakel_4_0',
        'jahitan_bakel_5_0_material',
        'jahitan_bakel_nylon',
        'jahitan_bakel_prolene',
        'jahitan_bakel_vycril',
        'jahitan_bakel_vycril_detail',
        
        // Skleretomi & Kanula
        'skleretomi_3_lubang',
        'skleretomi_4_lubang',
        'kanula_3mm',
        'kanula_4mm',
        'kanula_tak_tembus',
        'kanula_3_5mm',
        'kanula_ujung_tak_terlihat',
        
        // Teknik Operasi
        'teknik_pneumatic_retinopexy',
        'teknik_fge',
        'teknik_sice',
        'teknik_core_vitrectomy',
        'teknik_endblock',
        'teknik_ekstirpasi_iol',
        'teknik_reposisi_iol',
        'teknik_iridektomi_perifer',
        'teknik_drainase_cairan',
        'teknik_pneumatic_dysplacement',
        'teknik_kriopeksi',
        'teknik_injeksi_intravitreal',
        'teknik_injeksi_lokasi',
        'teknik_pewarna_membran',
        'teknik_bersihkan_vitreous',
        'teknik_ekstirpasi_benda_asing',
        'teknik_ekstirpasi_lensa',
        'teknik_evakuasi_silicone',
        'teknik_tpa',
        'teknik_ilm_peeling',
        'teknik_membrane_peeling',
        'teknik_lensectomy',
        'teknik_ac_fiksasi',
        'teknik_tidak_dipasang_iol',
        'teknik_fako',
        
        // Drainase & Laser
        'drainase_lubang_retina_baru',
        'drainase_robekan_ada',
        'drainase_external',
        'laser_dilakukan',
        'laser_el',
        'laser_lio',
        'laser_tidak_dilakukan',
        'laser_jumlah',
        'laser_power',
        'laser_time_exposure',
        
        // Tamponade
        'tamponade_cairan',
        'tamponade_c3f8',
        'tamponade_c3f8_persen',
        'tamponade_f6h8',
        'tamponade_silicon_oil',
        'tamponade_silicon_oil_type',
        'tamponade_corneal_debridemant',
        'tamponade_retina_melekat_sempurna',
        'tamponade_sisa_cairan',
        'tamponade_ya',
        'tamponade_udara_steril',
        'tamponade_sf6',
        'tamponade_sf6_persen',
        'tamponade_perfluorocarbon',
        'tamponade_lensa_kontak',
        'tamponade_retina_melekat_tidak_sempurna',
        'tamponade_retina_tak_melekat',
        'tamponade_tidak',
        'tamponade_antibiotik',
        'tamponade_anti_vegf',
        'tamponade_lainnya',
        
        // Specimen
        'jenis_specimen',
        
        // Komplikasi & Perdarahan
        'komplikasi_ya',
        'komplikasi_tidak',
        'komplikasi_detail',
        'perdarahan_ya',
        'perdarahan_tidak',
        'jumlah_perdarahan',
        'transfusi_ya',
        'transfusi_tidak',
        'jumlah_transfusi',
        
        // Gambar Skema
        'gambar_skema',
        
        // Tatalaksana
        'tidur_telungkup_3hr',
        'tidur_telungkup_10hr',
        'tidur_telungkup_1bl',
        'tidur_biasa',
        'lepas_lensa_kontak',
        'tatalaksana_1',
        'tatalaksana_2',
        'tatalaksana_3',
        'tatalaksana_4',
        'tatalaksana_5',
        'tatalaksana_6',
        'tatalaksana_7',
        
        // Stiker & TTD
        'stiker_implant',
        'ttd_dpjp_bedah',
        'ttd_dpjp_bedah_timestamp',
        'nama_dpjp_bedah_ttd',
        'tanggal_selesai_laporan',
        'jam_selesai_laporan',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_operasi' => 'date',
        'tanggal_selesai_laporan' => 'date',
        
        // Boolean casts for all checkboxes
        'area_operasi_od' => 'boolean',
        'area_operasi_os' => 'boolean',
        'anestesi_lokal' => 'boolean',
        'anestesi_umum' => 'boolean',
        'anestesi_sedasi' => 'boolean',
        'anestesi_blok' => 'boolean',
        'peritomi_360' => 'boolean',
        'peritomi_sebagian' => 'boolean',
        'kendala_4_rektus' => 'boolean',
        'kendala_rektus_superior' => 'boolean',
        'kendala_tak_dilakukan' => 'boolean',
        'bakel_sirkuler_5mm' => 'boolean',
        'bakel_sirkuler_4mm' => 'boolean',
        'bakel_sirkuler_2_5mm' => 'boolean',
        'bakel_sirkuler_2mm' => 'boolean',
        'bakel_sponge' => 'boolean',
        'bakel_tyre' => 'boolean',
        'bakel_tak_dilakukan' => 'boolean',
        'ikatan_sleeve_ni' => 'boolean',
        'ikatan_sleeve_ns' => 'boolean',
        'ikatan_sleeve_ts' => 'boolean',
        'ikatan_sleeve_ti' => 'boolean',
        'ikatan_benang_ni' => 'boolean',
        'ikatan_benang_ns' => 'boolean',
        'ikatan_benang_ts' => 'boolean',
        'ikatan_benang_ti' => 'boolean',
        'jahitan_bakel_5_0' => 'boolean',
        'jahitan_bakel_6_0' => 'boolean',
        'jahitan_bakel_4_0' => 'boolean',
        'jahitan_bakel_5_0_material' => 'boolean',
        'jahitan_bakel_nylon' => 'boolean',
        'jahitan_bakel_prolene' => 'boolean',
        'jahitan_bakel_vycril' => 'boolean',
        'skleretomi_3_lubang' => 'boolean',
        'skleretomi_4_lubang' => 'boolean',
        'kanula_3mm' => 'boolean',
        'kanula_4mm' => 'boolean',
        'kanula_tak_tembus' => 'boolean',
        'kanula_ujung_tak_terlihat' => 'boolean',
        'teknik_pneumatic_retinopexy' => 'boolean',
        'teknik_fge' => 'boolean',
        'teknik_sice' => 'boolean',
        'teknik_core_vitrectomy' => 'boolean',
        'teknik_endblock' => 'boolean',
        'teknik_ekstirpasi_iol' => 'boolean',
        'teknik_reposisi_iol' => 'boolean',
        'teknik_iridektomi_perifer' => 'boolean',
        'teknik_drainase_cairan' => 'boolean',
        'teknik_pneumatic_dysplacement' => 'boolean',
        'teknik_kriopeksi' => 'boolean',
        'teknik_injeksi_intravitreal' => 'boolean',
        'teknik_pewarna_membran' => 'boolean',
        'teknik_bersihkan_vitreous' => 'boolean',
        'teknik_ekstirpasi_benda_asing' => 'boolean',
        'teknik_ekstirpasi_lensa' => 'boolean',
        'teknik_evakuasi_silicone' => 'boolean',
        'teknik_tpa' => 'boolean',
        'teknik_ilm_peeling' => 'boolean',
        'teknik_membrane_peeling' => 'boolean',
        'teknik_lensectomy' => 'boolean',
        'teknik_ac_fiksasi' => 'boolean',
        'teknik_tidak_dipasang_iol' => 'boolean',
        'teknik_fako' => 'boolean',
        'drainase_lubang_retina_baru' => 'boolean',
        'drainase_robekan_ada' => 'boolean',
        'drainase_external' => 'boolean',
        'laser_dilakukan' => 'boolean',
        'laser_el' => 'boolean',
        'laser_lio' => 'boolean',
        'laser_tidak_dilakukan' => 'boolean',
        'tamponade_cairan' => 'boolean',
        'tamponade_c3f8' => 'boolean',
        'tamponade_f6h8' => 'boolean',
        'tamponade_silicon_oil' => 'boolean',
        'tamponade_corneal_debridemant' => 'boolean',
        'tamponade_retina_melekat_sempurna' => 'boolean',
        'tamponade_sisa_cairan' => 'boolean',
        'tamponade_ya' => 'boolean',
        'tamponade_udara_steril' => 'boolean',
        'tamponade_sf6' => 'boolean',
        'tamponade_perfluorocarbon' => 'boolean',
        'tamponade_lensa_kontak' => 'boolean',
        'tamponade_retina_melekat_tidak_sempurna' => 'boolean',
        'tamponade_retina_tak_melekat' => 'boolean',
        'tamponade_tidak' => 'boolean',
        'komplikasi_ya' => 'boolean',
        'komplikasi_tidak' => 'boolean',
        'perdarahan_ya' => 'boolean',
        'perdarahan_tidak' => 'boolean',
        'transfusi_ya' => 'boolean',
        'transfusi_tidak' => 'boolean',
        'tidur_telungkup_3hr' => 'boolean',
        'tidur_telungkup_10hr' => 'boolean',
        'tidur_telungkup_1bl' => 'boolean',
        'tidur_biasa' => 'boolean',
        'lepas_lensa_kontak' => 'boolean',
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
                $model->no_surat = "RM 10.1/LOVR/{$tahun}";
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

    /**
     * Accessor untuk format tanggal operasi
     */
    public function getTanggalOperasiFormattedAttribute()
    {
        return $this->tanggal_operasi ? $this->tanggal_operasi->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk durasi operasi
     */
    public function getDurasiOperasiAttribute()
    {
        if (!$this->jam_mulai_operasi || !$this->jam_selesai_operasi) {
            return null;
        }

        try {
            $mulai = \Carbon\Carbon::parse($this->jam_mulai_operasi);
            $selesai = \Carbon\Carbon::parse($this->jam_selesai_operasi);
            
            $diffInMinutes = $mulai->diffInMinutes($selesai);
            
            $jam = floor($diffInMinutes / 60);
            $menit = $diffInMinutes % 60;
            
            if ($jam == 0 && $menit == 0) {
                return '-';
            }
            
            $result = [];
            if ($jam > 0) {
                $result[] = $jam . ' jam';
            }
            if ($menit > 0) {
                $result[] = $menit . ' menit';
            }
            
            return implode(' ', $result);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Accessor untuk area operasi yang dipilih
     */
    public function getAreaOperasiAttribute()
    {
        $areas = [];
        if ($this->area_operasi_od) $areas[] = 'OD';
        if ($this->area_operasi_os) $areas[] = 'OS';
        return !empty($areas) ? implode(', ', $areas) : null;
    }

    /**
     * Accessor untuk jenis anestesi yang digunakan
     */
    public function getJenisAnestesiUsedAttribute()
    {
        $anestesi = [];
        if ($this->anestesi_lokal) $anestesi[] = 'Lokal';
        if ($this->anestesi_umum) $anestesi[] = 'Anestesi Umum';
        if ($this->anestesi_sedasi) $anestesi[] = 'Sedasi';
        if ($this->anestesi_blok) $anestesi[] = 'Anestesi Blok';
        return $anestesi;
    }

    /**
     * Accessor untuk teknik operasi yang digunakan
     */
    public function getTeknikOperasiUsedAttribute()
    {
        $teknik = [];
        
        if ($this->teknik_pneumatic_retinopexy) $teknik[] = 'Pneumatic retinopexy';
        if ($this->teknik_fge) $teknik[] = 'FGE';
        if ($this->teknik_sice) $teknik[] = 'SICE';
        if ($this->teknik_core_vitrectomy) $teknik[] = 'Core Vitrectomy';
        if ($this->teknik_endblock) $teknik[] = 'Endblock/delaminasi';
        if ($this->teknik_fako) $teknik[] = 'FAKO';
        if ($this->teknik_lensectomy) $teknik[] = 'Lensectomy';
        if ($this->teknik_ilm_peeling) $teknik[] = 'ILM peeling';
        if ($this->teknik_membrane_peeling) $teknik[] = 'Membrane Peeling';
        
        return $teknik;
    }

    /**
     * Accessor untuk status retina
     */
    public function getStatusRetinaAttribute()
    {
        if ($this->tamponade_retina_melekat_sempurna) {
            return 'Retina melekat sempurna';
        } elseif ($this->tamponade_retina_melekat_tidak_sempurna) {
            return 'Retina melekat tidak sempurna';
        } elseif ($this->tamponade_retina_tak_melekat) {
            return 'Retina tak melekat';
        }
        return null;
    }

    /**
     * Scope untuk filter berdasarkan DPJP Bedah
     */
    public function scopeByDpjpBedah($query, $dpjp)
    {
        return $query->where('dpjp_bedah', 'like', "%{$dpjp}%");
    }

    /**
     * Scope untuk filter berdasarkan area operasi
     */
    public function scopeByAreaOperasi($query, $area)
    {
        if (strtoupper($area) === 'OD') {
            return $query->where('area_operasi_od', true);
        } elseif (strtoupper($area) === 'OS') {
            return $query->where('area_operasi_os', true);
        }
        return $query;
    }

    /**
     * Scope untuk operasi dengan komplikasi
     */
    public function scopeWithKomplikasi($query)
    {
        return $query->where('komplikasi_ya', true);
    }

    /**
     * Scope untuk operasi dengan perdarahan
     */
    public function scopeWithPerdarahan($query)
    {
        return $query->where('perdarahan_ya', true);
    }

    /**
     * Scope untuk filter berdasarkan tanggal operasi
     */
    public function scopeByTanggalOperasi($query, $tanggal)
    {
        return $query->whereDate('tanggal_operasi', $tanggal);
    }

    /**
     * Scope untuk filter berdasarkan range tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_operasi', [$startDate, $endDate]);
    }

    /**
     * Scope untuk operasi dengan teknik tertentu
     */
    public function scopeByTeknik($query, $teknik)
    {
        $teknikField = 'teknik_' . strtolower(str_replace(' ', '_', $teknik));
        if (in_array($teknikField, $this->fillable)) {
            return $query->where($teknikField, true);
        }
        return $query;
    }

    /**
     * Scope untuk operasi vitrektomi
     */
    public function scopeVitrektomi($query)
    {
        return $query->where(function($q) {
            $q->where('teknik_core_vitrectomy', true)
              ->orWhere('teknik_fge', true)
              ->orWhere('teknik_sice', true);
        });
    }
}