<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratPengantarRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_pengantar_rawat_inap';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Asal Ruangan
        'asal_ruangan',
        'nama_poliklinik',
        
        // Rencana Perawatan
        'rencana_perawatan_di',
        
        // Keterangan Medis
        'karena_menderita',
        'saran_terapi',
        'rencana_tindakan',
        
        // Tanggal Surat
        'tanggal_surat',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter_ttd',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_surat' => 'date',
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