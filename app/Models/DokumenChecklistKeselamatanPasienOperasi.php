<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenChecklistKeselamatanPasienOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_checklist_keselamatan_pasien_operasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Sign In - Sebelum Induksi Anestesi
        'signin_waktu',
        'signin_identitas_benar',
        'signin_area_ditandai',
        'signin_mesin_lengkap',
        'signin_pulse_oksimetri',
        'signin_riwayat_alergi',
        'signin_gangguan_nafas',
        'signin_resiko_perdarahan',
        
        'ttd_signin_dr_anestesi',
        'nama_signin_dr_anestesi',
        'ttd_signin_perawat_anestesi',
        'nama_signin_perawat_anestesi',
        'ttd_signin_perawat',
        'nama_signin_perawat',
        
        // Time Out - Sebelum Insisi
        'timeout_waktu',
        'timeout_perkenalan_tim',
        'timeout_konfirmasi_pasien',
        'timeout_antibiotik',
        'timeout_tindakan_beresiko',
        'timeout_lama_tindakan',
        'timeout_antisipasi_perdarahan',
        'timeout_hal_khusus_anestesi',
        'timeout_kesterilan_alat',
        'timeout_implan_steril',
        'timeout_masalah_alat',
        'timeout_hasil_radiologi',
        
        'ttd_timeout_dr_anestesi',
        'nama_timeout_dr_anestesi',
        'ttd_timeout_perawat_anestesi',
        'nama_timeout_perawat_anestesi',
        'ttd_timeout_perawat_sirkuler',
        'nama_timeout_perawat_sirkuler',
        
        // Sign Out - Sebelum Pasien Meninggalkan Kamar Operasi
        'signout_waktu',
        'signout_konfirmasi_tindakan',
        'signout_kelengkapan_alat',
        'signout_pelabelan_specimen',
        'signout_masalah_peralatan',
        'signout_catatan_recovery',
        
        'ttd_signout_dr_bedah',
        'nama_signout_dr_bedah',
        'ttd_signout_dr_anestesi',
        'nama_signout_dr_anestesi',
        'ttd_signout_perawat_anestesi',
        'nama_signout_perawat_anestesi',
        'ttd_signout_perawat_instrument',
        'nama_signout_perawat_instrument',
        'ttd_signout_perawat_sirkuler',
        'nama_signout_perawat_sirkuler',
        
        'tanggal_pelaksanaan',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pelaksanaan' => 'date',
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

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
} 