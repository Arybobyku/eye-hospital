<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenProtokolTindakanTerapi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_protokol_tindakan_terapi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',

        // Identitas Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',

        // Info Asuransi / Perusahaan
        'perusahaan',
        'no_kartu',
        'no_surat',

        // Info Kunjungan
        'tanggal_jam_masuk',
        'ruang_kelas',

        // Klinis
        'keluhan_pasien',
        'pengobatan_diberikan',
        'tindakan_medis',
        'biaya_diperlukan',
        'alasan_tindakan',
        'diagnosa_sementara',

        // Tanggal Surat
        'tanggal_surat',

        // Tanda Tangan Dokter Yang Merawat
        'ttd_dokter',
        'nama_dokter_merawat',
        'ttd_dokter_timestamp',

        // Tanda Tangan Penyetuju
        'ttd_penyetuju',
        'nama_penyetuju',
        'ttd_penyetuju_timestamp',
        'status_persetujuan',

        // Audit
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_surat'  => 'date',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'deleted_at'     => 'datetime',
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
                $model->no_surat = "RM 9.6/PTT/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    public function scopeFindByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeByPasien($query, $uuidPasien)
    {
        return $query->where('uuid_pasien', $uuidPasien);
    }
}
