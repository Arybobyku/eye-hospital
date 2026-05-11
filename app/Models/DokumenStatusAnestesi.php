<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenStatusAnestesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_status_anestesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Identitas Pasien
        'tanggal',
        'no_rm',
        'no_surat',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        'dpjp_anestesi',
        'asisten_anestesi',
        'dpjp_bedah',
        
        // Diagnosis & Pembedahan
        'diagnosis_pra_bedah',
        'jenis_pembedahan',
        'diagnosis_pasca_bedah',
        
        // Teknik Anestesi
        'teknik_sedasi',
        'teknik_sedasi_detail',
        'teknik_anestesi_umum',
        'teknik_anestesi_umum_detail',
        'teknik_lain',
        'teknik_lain_detail',
        'teknik_spinal',
        'teknik_epidural',
        'teknik_kaudal',
        'blok_perifer',
        
        // Alat Khusus
        'alat_hipotensi',
        'alat_tci',
        'alat_cpb',
        'alat_ventilasi_satu_paru',
        'alat_bronkoskopi',
        'alat_glidescope',
        'alat_usg',
        'alat_stimulator_saraf',
        'alat_lainnya_check',
        'alat_lainnya',
        
        // Monitoring
        'monitoring_ekg',
        'monitoring_ekg_lead',
        'monitoring_arteri_line',
        'monitoring_arteri_line_detail',
        'monitoring_etco2',
        'monitoring_stetoskop',
        'monitoring_nibp',
        'monitoring_ngt',
        'monitoring_bis',
        'monitoring_cvp',
        'monitoring_cvp_detail',
        'monitoring_cath_a_pulmo',
        'monitoring_spo2',
        'monitoring_kateter_urine',
        'monitoring_temp',
        'monitoring_lainnya_check',
        'monitoring_lainnya',
        
        // Status Fisik
        'asa',
        'alergi',
        'alergi_detail',
        
        // Penyulit & Cek List
        'penyulit_pra_anestesi',
        'cek_informed_consent',
        'cek_obat_anestesi',
        'cek_tatalaksana_jalan_nafas',
        'cek_mesin_anestesi',
        'cek_monitoring',
        'cek_obat_emergensi',
        'cek_suction_apparatus',
        
        // Penilaian Pra Induksi
        'pra_induksi_jam',
        'pra_induksi_kesadaran',
        'pra_induksi_td',
        'pra_induksi_nadi',
        'pra_induksi_rr',
        'pra_induksi_suhu',
        'pra_induksi_spo2',
        'pra_induksi_lainnya',
        
        'catatan_halaman1',
        
        // HALAMAN 2 - Detail Prosedur
        'infus_perifer_1',
        'infus_perifer_2',
        'cvc',
        
        // Posisi
        'posisi_terlentang',
        'posisi_lithotomi',
        'posisi_prone',
        'posisi_perlindungan_mata',
        'posisi_lateral',
        'posisi_lainnya_check',
        'posisi_lainnya',
        
        // Premedikasi
        'premedikasi_oral',
        'premedikasi_im',
        'premedikasi_iv',
        
        // Induksi
        'induksi_intravena',
        'induksi_inhalasi',
        
        // Tata Laksana Jalan Nafas
        'face_mask_no',
        'oro_nasopharing_no',
        'ett_no',
        'ett_jenis',
        'ett_fiksasi_cm',
        'lma_no',
        'lma_jenis',
        'trakheostomi',
        'bronkoskopi_fiberoptik',
        'glidescope_jalan_nafas',
        'jalan_nafas_lainnya_check',
        'jalan_nafas_lainnya',
        
        // Intubasi
        'intubasi_sesudah_tidur',
        'intubasi_blind',
        'intubasi_oral_nasal',
        'intubasi_nasal_ka_ki',
        'intubasi_trakheostomi',
        'sulit_ventilasi',
        'sulit_intubasi',
        'dengan_stilet',
        'cuff',
        'level_ett',
        'pack',
        
        // Ventilasi
        'ventilasi_spontan',
        'ventilasi_kendali',
        'ventilator_tv',
        'ventilator_rr',
        'ventilator_peep',
        'ventilasi_lainnya',
        
        // Regional / Blok Perifer
        'regional_jenis',
        'regional_lokasi',
        'regional_jarum',
        'regional_kateter',
        'regional_fiksasi_cm',
        'regional_obat',
        'regional_komplikasi',
        'regional_hasil',
        
        // HALAMAN 3 - Monitoring & Penutup
        'obat_infus', // JSON
        'monitoring_fisiologis', // JSON
        
        // Pemantauan
        'pemantauan_cairan_infus',
        'pemantauan_gas',
        'pemantauan_spo2',
        'pemantauan_peco2',
        'pemantauan_fio2',
        'pemantauan_urin',
        'pemantauan_perdarahan',
        'pemantauan_lainnya',
        
        // Durasi
        'lama_pembiusan_jam',
        'lama_pembiusan_menit',
        'lama_pembedahan_jam',
        'lama_pembedahan_menit',
        
        'catatan_halaman3',
        
        // Tanda Tangan
        'ttd_dr_anestesi',
        'nama_dr_anestesi',
        'ttd_dr_anestesi_timestamp',
        'ttd_perawat_anestesi',
        'nama_perawat_anestesi',
        'ttd_perawat_anestesi_timestamp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_lahir' => 'date',
        
        // Boolean - Teknik Anestesi
        'teknik_sedasi' => 'boolean',
        'teknik_anestesi_umum' => 'boolean',
        'teknik_lain' => 'boolean',
        'teknik_spinal' => 'boolean',
        'teknik_epidural' => 'boolean',
        'teknik_kaudal' => 'boolean',
        
        // Boolean - Alat Khusus
        'alat_hipotensi' => 'boolean',
        'alat_tci' => 'boolean',
        'alat_cpb' => 'boolean',
        'alat_ventilasi_satu_paru' => 'boolean',
        'alat_bronkoskopi' => 'boolean',
        'alat_glidescope' => 'boolean',
        'alat_usg' => 'boolean',
        'alat_stimulator_saraf' => 'boolean',
        'alat_lainnya_check' => 'boolean',
        
        // Boolean - Monitoring
        'monitoring_ekg' => 'boolean',
        'monitoring_arteri_line' => 'boolean',
        'monitoring_etco2' => 'boolean',
        'monitoring_stetoskop' => 'boolean',
        'monitoring_nibp' => 'boolean',
        'monitoring_ngt' => 'boolean',
        'monitoring_bis' => 'boolean',
        'monitoring_cvp' => 'boolean',
        'monitoring_cath_a_pulmo' => 'boolean',
        'monitoring_spo2' => 'boolean',
        'monitoring_kateter_urine' => 'boolean',
        'monitoring_temp' => 'boolean',
        'monitoring_lainnya_check' => 'boolean',
        
        // Boolean - Cek List
        'cek_informed_consent' => 'boolean',
        'cek_obat_anestesi' => 'boolean',
        'cek_tatalaksana_jalan_nafas' => 'boolean',
        'cek_mesin_anestesi' => 'boolean',
        'cek_monitoring' => 'boolean',
        'cek_obat_emergensi' => 'boolean',
        'cek_suction_apparatus' => 'boolean',
        
        // Boolean - Posisi
        'posisi_terlentang' => 'boolean',
        'posisi_lithotomi' => 'boolean',
        'posisi_prone' => 'boolean',
        'posisi_perlindungan_mata' => 'boolean',
        'posisi_lainnya_check' => 'boolean',
        
        // Boolean - Tata Laksana Jalan Nafas
        'trakheostomi' => 'boolean',
        'bronkoskopi_fiberoptik' => 'boolean',
        'glidescope_jalan_nafas' => 'boolean',
        'jalan_nafas_lainnya_check' => 'boolean',
        
        // Boolean - Intubasi
        'intubasi_sesudah_tidur' => 'boolean',
        'intubasi_blind' => 'boolean',
        'intubasi_trakheostomi' => 'boolean',
        'dengan_stilet' => 'boolean',
        
        // Boolean - Ventilasi
        'ventilasi_spontan' => 'boolean',
        'ventilasi_kendali' => 'boolean',
        
        // JSON Array
        'obat_infus' => 'array',
        'monitoring_fisiologis' => 'array',
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
                $model->no_surat = "RM 5.2/LA/{$tahun}";
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
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk total lama pembiusan dalam menit
     */
    public function getTotalLamaPembiusanMenitAttribute()
    {
        $jam = (int) ($this->lama_pembiusan_jam ?? 0);
        $menit = (int) ($this->lama_pembiusan_menit ?? 0);
        return ($jam * 60) + $menit;
    }

    /**
     * Accessor untuk total lama pembedahan dalam menit
     */
    public function getTotalLamaPembedahanMenitAttribute()
    {
        $jam = (int) ($this->lama_pembedahan_jam ?? 0);
        $menit = (int) ($this->lama_pembedahan_menit ?? 0);
        return ($jam * 60) + $menit;
    }

    /**
     * Accessor untuk format durasi pembiusan (readable)
     */
    public function getDurasiPembiusanAttribute()
    {
        $jam = $this->lama_pembiusan_jam ?? 0;
        $menit = $this->lama_pembiusan_menit ?? 0;
        
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
    }

    /**
     * Accessor untuk format durasi pembedahan (readable)
     */
    public function getDurasiPembedahanAttribute()
    {
        $jam = $this->lama_pembedahan_jam ?? 0;
        $menit = $this->lama_pembedahan_menit ?? 0;
        
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
    }

    /**
     * Accessor untuk mendapatkan semua teknik anestesi yang digunakan
     */
    public function getTeknikAnestesiUsedAttribute()
    {
        $teknik = [];
        
        if ($this->teknik_sedasi) {
            $teknik[] = 'Sedasi' . ($this->teknik_sedasi_detail ? ' (' . $this->teknik_sedasi_detail . ')' : '');
        }
        if ($this->teknik_anestesi_umum) {
            $teknik[] = 'Anestesi Umum' . ($this->teknik_anestesi_umum_detail ? ' (' . $this->teknik_anestesi_umum_detail . ')' : '');
        }
        if ($this->teknik_spinal) {
            $teknik[] = 'Spinal';
        }
        if ($this->teknik_epidural) {
            $teknik[] = 'Epidural';
        }
        if ($this->teknik_kaudal) {
            $teknik[] = 'Kaudal';
        }
        if ($this->blok_perifer) {
            $teknik[] = 'Blok Perifer: ' . $this->blok_perifer;
        }
        if ($this->teknik_lain && $this->teknik_lain_detail) {
            $teknik[] = 'Lain-lain: ' . $this->teknik_lain_detail;
        }
        
        return $teknik;
    }

    /**
     * Accessor untuk mendapatkan semua monitoring yang digunakan
     */
    public function getMonitoringUsedAttribute()
    {
        $monitoring = [];
        
        if ($this->monitoring_ekg) {
            $monitoring[] = 'EKG' . ($this->monitoring_ekg_lead ? ' Lead ' . $this->monitoring_ekg_lead : '');
        }
        if ($this->monitoring_arteri_line) {
            $monitoring[] = 'Arteri Line' . ($this->monitoring_arteri_line_detail ? ' (' . $this->monitoring_arteri_line_detail . ')' : '');
        }
        if ($this->monitoring_etco2) {
            $monitoring[] = 'EtCO2';
        }
        if ($this->monitoring_stetoskop) {
            $monitoring[] = 'Stetoskop';
        }
        if ($this->monitoring_nibp) {
            $monitoring[] = 'NIBP';
        }
        if ($this->monitoring_ngt) {
            $monitoring[] = 'NGT';
        }
        if ($this->monitoring_bis) {
            $monitoring[] = 'BIS';
        }
        if ($this->monitoring_cvp) {
            $monitoring[] = 'CVP' . ($this->monitoring_cvp_detail ? ' (' . $this->monitoring_cvp_detail . ')' : '');
        }
        if ($this->monitoring_cath_a_pulmo) {
            $monitoring[] = 'Cath A Pulmo';
        }
        if ($this->monitoring_spo2) {
            $monitoring[] = 'SpO2';
        }
        if ($this->monitoring_kateter_urine) {
            $monitoring[] = 'Kateter Urine';
        }
        if ($this->monitoring_temp) {
            $monitoring[] = 'Temperature';
        }
        if ($this->monitoring_lainnya_check && $this->monitoring_lainnya) {
            $monitoring[] = 'Lain-lain: ' . $this->monitoring_lainnya;
        }
        
        return $monitoring;
    }

    /**
     * Scope untuk filter berdasarkan DPJP Anestesi
     */
    public function scopeByDpjpAnestesi($query, $dpjp)
    {
        return $query->where('dpjp_anestesi', 'like', "%{$dpjp}%");
    }

    /**
     * Scope untuk filter berdasarkan DPJP Bedah
     */
    public function scopeByDpjpBedah($query, $dpjp)
    {
        return $query->where('dpjp_bedah', 'like', "%{$dpjp}%");
    }

    /**
     * Scope untuk filter berdasarkan jenis pembedahan
     */
    public function scopeByJenisPembedahan($query, $jenis)
    {
        return $query->where('jenis_pembedahan', 'like', "%{$jenis}%");
    }

    /**
     * Scope untuk filter berdasarkan ASA
     */
    public function scopeByAsa($query, $asa)
    {
        return $query->where('asa', $asa);
    }

    /**
     * Scope untuk anestesi dengan komplikasi
     */
    public function scopeWithKomplikasi($query)
    {
        return $query->where(function($q) {
            $q->where('sulit_ventilasi', '!=', '')
              ->orWhere('sulit_intubasi', '!=', '')
              ->orWhere('regional_komplikasi', '!=', '');
        });
    }

    /**
     * Scope untuk anestesi regional
     */
    public function scopeRegional($query)
    {
        return $query->where(function($q) {
            $q->where('teknik_spinal', true)
              ->orWhere('teknik_epidural', true)
              ->orWhere('teknik_kaudal', true)
              ->orWhere('blok_perifer', '!=', '');
        });
    }

    /**
     * Scope untuk anestesi umum
     */
    public function scopeAnestesiUmum($query)
    {
        return $query->where('teknik_anestesi_umum', true);
    }
}