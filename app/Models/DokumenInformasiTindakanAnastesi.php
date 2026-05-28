<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenInformasiTindakanAnastesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_informasi_tindakan_anastesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_surat',

        // Signature section fields
        'nama_pasien_atau_wali',
        'umur_jenis_kelamin',
        'no_telp',
        'hubungan',
        'diagnosa',
        'rencana_tindakan',
        'jenis_anestesia',

        'baca_au',
        'baca_spinal',
        'baca_blok',
        'baca_sedasi',
        'baca_topikal',

        'tanggal_surat',
        'jam_surat',

        // TTD Dokter
        'ttd_dokter',
        'nama_dokter',
        'ttd_dokter_timestamp',

        // TTD Pihak yang Dijelaskan
        'ttd_pihak',
        'nama_pihak',
        'ttd_pihak_timestamp',

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
                $model->no_surat = "RM 8.2/ITADS/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
