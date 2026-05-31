<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPenyimpananBarangBerharga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_penyimpanan_barang_berharga';

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
        
        // Data Formulir
        'nama_petugas',
        'pasien_tidak_sadar',
        
        // Data Barang (JSON)
        'barang_rows',
        
        // Tanda Tangan
        'ttd_petugas',
        'nama_petugas_ttd',
        'ttd_petugas_timestamp',
        
        'ttd_saksi1',
        'nama_saksi1_ttd',
        'ttd_saksi1_timestamp',
        
        'ttd_keluarga',
        'nama_keluarga_ttd',
        'ttd_keluarga_timestamp',
        
        'ttd_kepala_ruangan',
        'nama_kepala_ruangan_ttd',
        'ttd_kepala_ruangan_timestamp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_lahir' => 'date',
        'barang_rows' => 'array',

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
                $model->no_surat = "RM 7.2/FPBBMP/{$tahun}";
            }
        });
    }

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}