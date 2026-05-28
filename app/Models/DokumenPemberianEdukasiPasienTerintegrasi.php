<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPemberianEdukasiPasienTerintegrasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_pemberian_edukasi_pasien_terintegrasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'edukasi_sections',
        'tanggal',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'    => 'date',
        'tanggal_kunjungan'=> 'date',
        'edukasi_sections' => 'array',
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
                $model->no_surat = "RM 6.6/PEPT/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
