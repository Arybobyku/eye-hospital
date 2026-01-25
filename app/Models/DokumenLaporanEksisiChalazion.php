<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanEksisiChalazion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_eksisi_chalazion';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Data Pasien
        'nama_pasien',
        'no_rm_pasien',
        'jenis_kelamin_display',
        'tanggal_lahir_display',
        
        // Data Bedah (5 fields)
        'diagnosa_pra_bedah',
        'tindakan',
        'diagnosa_post_bedah',
        'unit_pembedahan',
        'terapi_pasca_bedah',
        
        // Tanda Tangan
        'ttd_perawat',
        'nama_perawat',
        'ttd_operator',
        'nama_operator',
        
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