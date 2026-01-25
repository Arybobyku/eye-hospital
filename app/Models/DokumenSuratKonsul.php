<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratKonsul extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_konsul';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal',
        
        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Kepada Yang Terhormat
        'tujuan_nama_dokter',
        'tujuan_lokasi',
        
        // Informasi Pasien
        'pasien_nama',
        'pasien_umur',
        'keluhan_utama',
        'diagnosa_sementara',
        
        // Pengobatan & Tindakan
        'pengobatan_tindakan',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter_pengirim',
        
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

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}