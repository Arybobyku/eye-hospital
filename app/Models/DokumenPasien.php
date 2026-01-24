<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPasien extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pasien';

    protected $fillable = [
        'uuid',
        'pasien_uuid',
        'jenis_dokumen',
        'nama_file',
        'file_path',
        'keterangan',
        'tanggal_upload',
        'waktu_upload',
        'uploaded_by_uuid',
        'uploaded_by_nama',
        'is_verified',
        'verified_by_uuid',
        'verified_by_nama',
        'verified_at',
        'delete_soft'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        // 'tanggal_upload' => 'date',
        'tanggal_upload' => 'string',  // ← Jangan cast ke date
        'waktu_upload' => 'string', 
    ];

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_uuid', 'uuid');
    }

    // Relasi ke Pengguna (uploader)
    public function uploader()
    {
        return $this->belongsTo(Pengguna::class, 'uploaded_by_uuid', 'uuid');
    }

    // Relasi ke Pengguna (verifier)
    public function verifier()
    {
        return $this->belongsTo(Pengguna::class, 'verified_by_uuid', 'uuid');
    }
}