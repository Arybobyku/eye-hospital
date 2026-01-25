<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenKronologisPasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_kronologis_pasien';

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
        'nik_pasien',
        'tanggal_lahir_display',
        
        // Data Pembuat Kronologis (4 fields)
        'nama_pembuat',
        'alamat_pembuat',
        'nik_pembuat',
        'hubungan_pasien',
        'hubungan_pasien_lainnya',
        
        // Data Kronologis Kejadian
        'tanggal_kejadian',
        'jam_kejadian',
        'tempat_kejadian',
        
        // Saat kejadian
        'saat_kejadian',
        
        // Lokasi kejadian (checkboxes)
        'lokasi_kecelakaan_lalu_lintas',
        'lokasi_rumah',
        'lokasi_lainnya_check',
        'lokasi_lainnya',
        
        // Detail
        'detail_kronologis',
        
        // Tanggal TTD
        'tanggal_ttd',
        
        // Tanda Tangan
        'ttd_pembuat',
        'nama_pembuat_ttd',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'tanggal_ttd' => 'date',
        'lokasi_kecelakaan_lalu_lintas' => 'boolean',
        'lokasi_rumah' => 'boolean',
        'lokasi_lainnya_check' => 'boolean',
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