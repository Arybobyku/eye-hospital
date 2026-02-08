<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPersetujuanAnestesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_persetujuan_anestesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal',
        'waktu',
        
        // Data Pasien (Wajib)
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Pemberian Informasi
        'dokter_pelaksana',
        'pemberi_informasi',
        'penerima_informasi',
        
        // 1. Diagnosis
        'diagnosis',
        'diagnosis_check',
        
        // 2. Dasar Diagnosis
        'dasar_diagnosis_klinis',
        'dasar_diagnosis_radiologi',
        'dasar_diagnosis_ekg',
        'dasar_diagnosis_laboratorium',
        'dasar_diagnosis_check',
        
        // 3. Tindakan Anestesi - Umum
        'anestesi_umum_intubasi',
        'anestesi_umum_lma',
        'anestesi_umum_fm',
        'anestesi_umum_tiva',
        
        // 3. Tindakan Anestesi - Regional
        'anestesi_regional_spinal',
        'anestesi_regional_epidural',
        'anestesi_regional_blok_perifier',
        'tindakan_anestesi_check',
        
        // 4. Indikasi & Tujuan
        'indikasi_tujuan',
        'indikasi_tujuan_check',
        
        // 5. Tata Cara
        'tata_cara',
        'tata_cara_check',
        
        // 6. Risiko
        'risiko_shock',
        'risiko_henti_jantung',
        'risiko_meninggal',
        'risiko_check',
        
        // 7. Komplikasi - Anestesi Umum
        'komplikasi_umum_kejang_nafas',
        'komplikasi_umum_kekurangan_o2',
        'komplikasi_umum_kelebihan_co2',
        'komplikasi_umum_aspirasi',
        'komplikasi_umum_tekanan_turun',
        'komplikasi_umum_tekanan_naik',
        'komplikasi_umum_gangguan_irama',
        'komplikasi_umum_kejang_saraf',
        'komplikasi_umum_bangun_lambat',
        'komplikasi_umum_trauma_saraf',
        'komplikasi_umum_gigi_patah',
        'komplikasi_umum_suhu',
        'komplikasi_umum_alergi',
        'komplikasi_umum_cedera_posisi',
        'komplikasi_umum_muntah',
        'komplikasi_umum_perut_kembung',
        'komplikasi_umum_tenggorokan_serak',
        
        // 7. Komplikasi - Anestesi Regional
        'komplikasi_regional_tekanan_turun',
        'komplikasi_regional_spinal_total',
        'komplikasi_regional_reaksi_toksik',
        'komplikasi_regional_alergi',
        'komplikasi_regional_nyeri_kepala',
        'komplikasi_regional_nyeri_punggung',
        'komplikasi_regional_infeksi',
        'komplikasi_regional_tidak_berkemih',
        'komplikasi_regional_cedera_saraf',
        'komplikasi_regional_pendarahan',
        'komplikasi_check',
        
        // 8. Prognosis
        'prognosis',
        'prognosis_check',
        
        // 9. Alternatif
        'alternatif_tindakan',
        'alternatif_check',
        
        // 10. Lain-lain
        'lain_lain',
        'lain_lain_check',
        
        // TTD Pemberi Informasi
        'ttd_dokter_pemberi_info',
        'tanggal_ttd_dokter',
        
        'ttd_penerima_info',
        'tanggal_ttd_penerima',
        
        // Persetujuan
        'nama_pemberi_persetujuan',
        'tgl_lahir_pemberi_persetujuan',
        'jenis_kelamin_pemberi_persetujuan',
        'alamat_pemberi_persetujuan',
        'status_persetujuan',
        'hubungan_pasien',
        'nama_pasien_persetujuan',
        'tgl_lahir_pasien_persetujuan',
        'jenis_kelamin_pasien_persetujuan',
        'alamat_pasien_persetujuan',
        
        'tanggal_persetujuan',
        'waktu_persetujuan',
        
        // TTD Persetujuan
        'ttd_yang_menyatakan',
        'nama_ttd_yang_menyatakan',
        
        'ttd_dokter_persetujuan',
        'nama_ttd_dokter',
        
        'ttd_saksi',
        'nama_ttd_saksi',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
        'tanggal_lahir' => 'date',
        'tanggal_ttd_dokter' => 'datetime',
        'tanggal_ttd_penerima' => 'datetime',
        'tgl_lahir_pemberi_persetujuan' => 'date',
        'tgl_lahir_pasien_persetujuan' => 'date',
        'tanggal_persetujuan' => 'date',
        'waktu_persetujuan' => 'datetime',
        
        // Boolean fields
        'diagnosis_check' => 'boolean',
        'dasar_diagnosis_check' => 'boolean',
        'anestesi_umum_intubasi' => 'boolean',
        'anestesi_umum_lma' => 'boolean',
        'anestesi_umum_fm' => 'boolean',
        'anestesi_umum_tiva' => 'boolean',
        'anestesi_regional_spinal' => 'boolean',
        'anestesi_regional_epidural' => 'boolean',
        'anestesi_regional_blok_perifier' => 'boolean',
        'tindakan_anestesi_check' => 'boolean',
        'indikasi_tujuan_check' => 'boolean',
        'tata_cara_check' => 'boolean',
        'risiko_shock' => 'boolean',
        'risiko_henti_jantung' => 'boolean',
        'risiko_meninggal' => 'boolean',
        'risiko_check' => 'boolean',
        'komplikasi_umum_kejang_nafas' => 'boolean',
        'komplikasi_umum_kekurangan_o2' => 'boolean',
        'komplikasi_umum_kelebihan_co2' => 'boolean',
        'komplikasi_umum_aspirasi' => 'boolean',
        'komplikasi_umum_tekanan_turun' => 'boolean',
        'komplikasi_umum_tekanan_naik' => 'boolean',
        'komplikasi_umum_gangguan_irama' => 'boolean',
        'komplikasi_umum_kejang_saraf' => 'boolean',
        'komplikasi_umum_bangun_lambat' => 'boolean',
        'komplikasi_umum_trauma_saraf' => 'boolean',
        'komplikasi_umum_gigi_patah' => 'boolean',
        'komplikasi_umum_suhu' => 'boolean',
        'komplikasi_umum_alergi' => 'boolean',
        'komplikasi_umum_cedera_posisi' => 'boolean',
        'komplikasi_umum_muntah' => 'boolean',
        'komplikasi_umum_perut_kembung' => 'boolean',
        'komplikasi_umum_tenggorokan_serak' => 'boolean',
        'komplikasi_regional_tekanan_turun' => 'boolean',
        'komplikasi_regional_spinal_total' => 'boolean',
        'komplikasi_regional_reaksi_toksik' => 'boolean',
        'komplikasi_regional_alergi' => 'boolean',
        'komplikasi_regional_nyeri_kepala' => 'boolean',
        'komplikasi_regional_nyeri_punggung' => 'boolean',
        'komplikasi_regional_infeksi' => 'boolean',
        'komplikasi_regional_tidak_berkemih' => 'boolean',
        'komplikasi_regional_cedera_saraf' => 'boolean',
        'komplikasi_regional_pendarahan' => 'boolean',
        'komplikasi_check' => 'boolean',
        'prognosis_check' => 'boolean',
        'alternatif_check' => 'boolean',
        'lain_lain_check' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
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