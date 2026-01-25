<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratPernyataanBatalOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_pernyataan_batal_operasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_surat',
        
        // Data Default (wajib ada)
        'no_rm',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Yang Bertandatangan
        'pernyataan_nama',
        'pernyataan_jenis_kelamin',
        'pernyataan_tempat_tanggal_lahir',
        
        // Detail Operasi
        'tanggal_operasi',
        'jenis_operasi',
        'alasan_batal_operasi',
        
        // Saran dan Jawaban
        'saran_dokter',
        'jawaban_pasien',
        
        // Tanda Tangan
        'ttd_pernyataan',
        'nama_pembuat_pernyataan',
        'ttd_saksi',
        'nama_saksi',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_operasi' => 'date',
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