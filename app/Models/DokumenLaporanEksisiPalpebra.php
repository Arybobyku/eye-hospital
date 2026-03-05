<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanEksisiPalpebra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_eksisi_palpebra';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Default (wajib ada)
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Data Pasien
        'nama_pasien',
        'no_rm_pasien',
        'jenis_kelamin_display',
        'tanggal_lahir_display',
        
        // Data Bedah (7 fields)
        'diagnosa_pre_bedah',
        'tindakan',
        'diagnosa_post_bedah',
        'unit_pembedahan',
        'terapi_pasca_bedah',
        
        // Tanda Tangan
        'ttd_perawat',
        'nama_perawat',
        'ttd_dokter',
        'nama_dokter',
        
        'created_by',
        'updated_by',
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
                $model->no_surat = "RM 9.3/LEP/{$tahun}";
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