<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormPersetujuanUmumPasienKeluarga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_persetujuan_umum_pasien_keluarga';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // ===== Persetujuan Memberikan Informasi Kepada =====
        'info_kepada_a',
        'info_kepada_b',
        'info_kepada_c',
        
        // ===== Tanggal & Waktu =====
        'tanggal',
        'waktu',
        
        // ===== Tanda Tangan Dokter =====
        'ttd_dokter',
        'nama_dokter_ttd',
        
        // ===== Tanda Tangan Keluarga/Pasien =====
        'ttd_keluarga',
        'nama_keluarga_ttd',
        
        // ===== Audit =====
        'created_by',
        'updated_by',

    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
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
     * Relasi ke tabel Pasien (jika ada)
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}