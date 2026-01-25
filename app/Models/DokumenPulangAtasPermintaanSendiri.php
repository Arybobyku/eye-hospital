<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPulangAtasPermintaanSendiri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_pulang_atas_permintaan_sendiri';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien (7 fields + 3 default)
        'nama_pasien',
        'tempat_tanggal_lahir',
        'no_rm',
        'agama',
        'pekerjaan',
        'alamat',
        'tanggal',
        
        // Data default untuk backend
        'nik',
        'jenis_kelamin',
        'nama',
        
        // Alasan
        'alasan',
        
        // Tanda Tangan
        'ttd_pasien',
        'nama_pasien_ttd',
        'ttd_dpjp',
        'nama_dpjp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
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