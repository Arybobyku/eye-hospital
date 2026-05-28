<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPermintaanPelayananKerohanian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_permintaan_pelayanan_kerohanian';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal',
        
        // Data Default (wajib ada)
        'no_rm',
        'no_surat',
        
        // Identitas Pasien
        'nama',
        'tanggal_lahir_pasien',
        'jenis_kelamin_pasien',
        'alamat_pasien',
        
        // Identitas Wali
        'nama_wali',
        'tanggal_lahir_wali',
        'jenis_kelamin_wali',
        'alamat_wali',
        
        // Permintaan Agama
        'agama_kepercayaan',
        'bentuk_pelayanan',
        'tanggal_pelayanan',
        'jam_pelayanan',
        'koordinasi_team',
        
        // Pelayanan Yang Diberikan
        'pelayanan_doa_bersama',
        'keterangan_pelayanan',
        
        // Tanda Tangan
        'ttd_rohaniawan',
        'nama_rohaniawan_ttd',
        'ttd_rohaniawan_timestamp',
        
        'ttd_kepala_ruangan',
        'nama_kepala_ruangan_ttd',
        'ttd_kepala_ruangan_timestamp',
        
        'ttd_keluarga',
        'nama_keluarga_ttd',
        'ttd_keluarga_timestamp',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_lahir_pasien' => 'date',
        'tanggal_lahir_wali' => 'date',
        'tanggal_pelayanan' => 'date',
        'pelayanan_doa_bersama' => 'boolean',
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
                $model->no_surat = "RM 7.1/FPPKK/{$tahun}";
            }
        });
    }

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}