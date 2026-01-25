<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenTindakanLaserPRP extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_tindakan_laser_prp';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_tindakan',
        
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
        
        // Form Fields
        'diagnosa',
        'parameter_laser',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_tindakan' => 'date',
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