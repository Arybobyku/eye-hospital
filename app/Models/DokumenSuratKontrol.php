<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratKontrol extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_kontrol';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_surat',
        
        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Informasi Pasien
        'nama_pasien',
        'tempat_tanggal_lahir',
        'no_rm_pasien',
        
        // Diagnosa
        'diagnosa',
        
        // Tindak Lanjut
        'pengobatan_dengan_obat',
        
        // Kontrol Lebih Lanjut
        'tanggal_kontrol_rs',
        'tanggal_kontrol_faskes',
        'status_sembuh',
        
        // Tanda Tangan
        'ttd_dpjp',
        'nama_dpjp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kontrol_rs' => 'date',
        'tanggal_kontrol_faskes' => 'date',
        'status_sembuh' => 'boolean',
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