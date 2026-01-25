<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanOperasiPterygium extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_operasi_pterygium';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_operasi',
        
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
        
        // Informasi Operasi
        'mata_od',
        'mata_os',
        'operator',
        'jam_operasi',
        'lama_operasi',
        'diagnosis',
        'asisten',
        'jenis_operasi',
        'anesthesia',
        'anesthesiologist',
        
        // Tanda Tangan
        'ttd_perawat',
        'nama_perawat',
        'ttd_operator',
        'nama_operator',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_operasi' => 'date',
        'mata_od' => 'boolean',
        'mata_os' => 'boolean',
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
     * Accessor untuk mata operasi
     */
    public function getMataOperasiAttribute()
    {
        $mata = [];
        if ($this->mata_od) $mata[] = 'OD';
        if ($this->mata_os) $mata[] = 'OS';
        return implode(', ', $mata);
    }
}