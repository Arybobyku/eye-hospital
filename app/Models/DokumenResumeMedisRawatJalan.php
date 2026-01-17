<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenResumeMedisRawatJalan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_resume_medis_rawat_jalan';

    protected $fillable = [
        'uuid_pasien', 'no_rm', 'nama', 'tanggal_lahir', 
        'jenis_kelamin', 'nik',
        
        'dokter',
        'poli',
        'penanggung',
        'tanggal_berobat',
        'anamnese',
        'pemeriksaan_fisik',
        'alergi_obat',
        'penunjang_medis',
        'diagnosa',
        'tindakan',
        'terapi',
        'riwayat',
        'edukasi',
        'tanggal_kontrol',
        'tempat_kontrol',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_tindakan' => 'date',
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