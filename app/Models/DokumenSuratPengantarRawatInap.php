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
        'tanggal',
        
        // Data Default (wajib ada)
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'tanggal_lahir',
        'nik',
        
        // Data Surat
        'asal_ruangan',
        'nama_poliklinik',
        'rencana_perawatan',
        'karena_menderita',
        'saran_terapi',
        'rencana_tindakan',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter_ttd',
        'ttd_dokter_timestamp',
        
        'created_by',
        'created_at',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_lahir' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $tahun = config('app.tahun_akreditasi', '22');
                $model->no_surat = "RM 2.5/SPUDI/{$tahun}";
            }
        });
    }

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}