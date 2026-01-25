<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenDietitianPasienBaru extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_dietitian_pasien_baru';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_asesmen',
        
        // Data Default
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Data Pasien
        'nama_pasien',
        'no_rm_pasien',
        
        // 1. Diagnosa Medis
        'diagnosa_medis',
        
        // 2. Risiko Malnutrisi
        'risiko_malnutrisi',
        
        // 3. Kondisi Khusus
        'kondisi_khusus',
        'kondisi_khusus_keterangan',
        
        // 4. Alergi Makanan
        'alergi_telur',
        'alergi_susu',
        'alergi_kacang',
        'alergi_gluten',
        'alergi_udang',
        'alergi_ikan',
        'alergi_hazelnut',
        'alergi_lainnya',
        
        // 5. Preskripsi Diet
        'preskripsi_diet',
        'preskripsi_diet_keterangan',
        
        // 6. Tindak Lanjut
        'tindak_lanjut',
        
        // 7. Kesimpulan
        'kesimpulan',
        
        // Tanda Tangan
        'ttd_dietitian',
        'nama_dietitian',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_asesmen' => 'date',
        'alergi_telur' => 'boolean',
        'alergi_susu' => 'boolean',
        'alergi_kacang' => 'boolean',
        'alergi_gluten' => 'boolean',
        'alergi_udang' => 'boolean',
        'alergi_ikan' => 'boolean',
        'alergi_hazelnut' => 'boolean',
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

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}