<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenTindakanLaserLPI extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_tindakan_laser_lpi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_tindakan',
        'jam_tindakan',

        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',

        // Data Pasien
        'nama_pasien',
        'no_rm_pasien',
        'tanggal_lahir',

        // Form Fields
        'diagnosa',
        'tindakan_laser_lpi',

        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',

        'created_by',
        'updated_by',

        'mata_kanan',
        'mata_kiri',
    ];

    protected $casts = [
        'tanggal_tindakan' => 'date',
        'tanggal_lahir' => 'date',
        'mata_kanan' => 'boolean',
        'mata_kiri' => 'boolean',
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

    /**
     * Accessor untuk mata yang ditindak
     */
    public function getMataAttribute()
    {
        if ($this->mata_kanan && $this->mata_kiri) {
            return 'ODS (Bilateral)';
        } elseif ($this->mata_kanan) {
            return 'OD (Kanan)';
        } elseif ($this->mata_kiri) {
            return 'OS (Kiri)';
        }
        return 'Tidak dispesifikasi';
    }
}
