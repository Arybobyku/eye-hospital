<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratPernyataanPasienUmum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_pernyataan_pasien_umum';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal_surat',
        
        // Data Default (wajib ada)
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',
        
        // Yang Bertandatangan (Pembuat Pernyataan)
        'pembuat_nama',
        'pembuat_tempat_tanggal_lahir',
        'pembuat_alamat',
        'pembuat_pekerjaan',
        'pembuat_no_telp',
        'pembuat_hubungan_keluarga',
        
        // Bertindak untuk dan atas nama Pasien
        'pasien_nama',
        'pasien_tempat_tanggal_lahir',
        'pasien_alamat',
        'pasien_no_rm',
        
        // Tanda Tangan (Triple Signatures)
        'ttd_pembuat_pernyataan',
        'nama_pembuat_pernyataan',
        'ttd_saksi_pasien',
        'nama_saksi_pasien',
        'ttd_saksi_petugas',
        'nama_saksi_petugas',
        'pembuat_pernyataan_ttd_timestamp',
        'saksi_pasien_ttd_timestamp',
        'saksi_petugas_ttd_timestamp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
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
                $model->no_surat = "RM 9.10/SPPU/{$tahun}";
            }
        });
    }

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}