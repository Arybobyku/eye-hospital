<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenSuratKeteranganMata extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_surat_keterangan_mata';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nik',
        'nama',
        'no_surat',

        // Hasil Pemeriksaan
        'autorefkeratometry_od',
        'autorefkeratometry_os',
        'visus_od',
        'visus_os',
        'tonometry_od',
        'tonometry_os',
        'diagnosa',

        // Surat
        'tanggal_surat',

        // TTD Dokter
        'ttd_dokter',
        'nama_dokter',
        'email_dokter',
        'hp_dokter',
        'ttd_dokter_timestamp',

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
                $model->no_surat = "RM 8.6/SKHPM/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
