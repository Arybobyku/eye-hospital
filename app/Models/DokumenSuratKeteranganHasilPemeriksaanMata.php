<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratKeteranganHasilPemeriksaanMata extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_keterangan_hasil_pemeriksaan_mata';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_surat',

        // Data Pasien
        'tempat_lahir',
        'alamat',

        // Visual Acuity
        'va_od',
        'koreksi_od',
        'va_os',
        'koreksi_os',

        // Tekanan Bola Mata
        'tio_od',
        'tio_os',

        // Penglihatan Warna
        'penglihatan_warna',

        // Hasil
        'kesimpulan',
        'saran',

        // Pasfoto
        'pasfoto',

        // Surat
        'tanggal_surat',

        // TTD Dokter
        'ttd_dokter',
        'nama_dokter',
        'ttd_dokter_timestamp',

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
            if (empty($model->no_surat)) {
                $tahun = config('app.tahun_akreditasi', '22');
                $model->no_surat = "RM 9.2/SKHPM/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
