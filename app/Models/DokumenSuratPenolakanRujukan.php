<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratPenolakanRujukan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_penolakan_rujukan';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal',
        
        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Yang bertanda tangan (pembuat pernyataan)
        'pembuat_nama',
        'pembuat_nik',
        'pembuat_alamat',
        
        // Data Pasien
        'pasien_nama',
        'pasien_nik',
        'pasien_no_rm',
        'pasien_tanggal_lahir',
        'pasien_alamat',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter_ttd',
        'ttd_pembuat',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'pasien_tanggal_lahir' => 'date',
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