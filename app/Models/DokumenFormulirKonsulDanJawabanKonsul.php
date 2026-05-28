<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenFormulirKonsulDanJawabanKonsul extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_formulir_konsul_dan_jawaban_konsul';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_surat',

        // FORMULIR KONSUL
        'dokter_tujuan_konsul',
        'jenis_konsul',
        'diagnosa',
        'persangkaan_diagnosis',
        'temuan_klinis',
        'pengobatan_tindakan_sebelumnya',
        'tanggal_konsul',
        'jam_konsul',
        'ttd_dokter_pengirim',
        'nama_dokter_pengirim',
        'ttd_dokter_pengirim_timestamp',

        // FORMULIR JAWABAN KONSUL
        'dokter_tujuan_jawaban',
        'tanggal_permintaan_konsul_ref',
        'hasil_konsul',
        'anjuran_pemeriksaan_tindakan',
        'anjuran_konsul_lanjut_dokter',
        'anjuran_konsul_lanjut_bagian',
        'terapi_anjuran',
        'tanggal_jawaban',
        'jam_jawaban',
        'ttd_dokter_konsultan',
        'nama_dokter_konsultan',
        'ttd_dokter_konsultan_timestamp',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'               => 'date',
        'tanggal_konsul'              => 'date',
        'tanggal_jawaban'             => 'date',
        'tanggal_permintaan_konsul_ref' => 'date',
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
                $model->no_surat = "RM 10.2/FKDJK/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
