<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenAsuhanGizi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_asuhan_gizi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Default (wajib ada)
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Data Pasien
        'nama_pasien',
        'tanggal_lahir_pasien',
        'no_rm_pasien',
        
        // Diagnosa Medis
        'diagnosa_medis',
        
        // Antropometri
        'bb',
        'tb',
        'tinggi_lutut',
        'imt',
        
        // Biokimia
        'biokimia',
        
        // Klinik/Fisik
        'klinik_fisik',
        
        // Riwayat Gizi
        'pola_makan',
        'asupan_gizi',
        
        // Riwayat Personal
        'riwayat_personal',
        
        // Diagnosis/Masalah Gizi
        'diagnosis_masalah_gizi',
        
        // Intervensi Gizi
        'intervensi_gizi',
        
        // Rencana Monitoring dan Evaluasi
        'rencana_monitoring_evaluasi',
        
        // Tanggal & Jam
        'tanggal_asuhan',
        'jam_asuhan',
        
        // Tanda Tangan
        'ttd_ahli_gizi',
        'nama_ahli_gizi',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_asuhan' => 'date',
        'bb' => 'decimal:2',
        'tb' => 'decimal:2',
        'tinggi_lutut' => 'decimal:2',
        'imt' => 'decimal:2',
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
                $model->no_surat = "RM 3.3/AG/{$tahun}";
            }
        });
    }

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
    
    // Accessor untuk kategori IMT
    public function getImtCategoryAttribute()
    {
        if (!$this->imt) return null;
        
        $imt = (float) $this->imt;
        if ($imt < 18.5) return 'Kurus';
        if ($imt < 25) return 'Normal';
        if ($imt < 30) return 'Gemuk';
        return 'Obesitas';
    }
}