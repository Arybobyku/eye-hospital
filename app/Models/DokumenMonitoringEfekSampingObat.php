<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenMonitoringEfekSampingObat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_monitoring_efek_samping_obat';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'keluhan_utama',
        'sejarah_penyakit_sekarang',
        'sejarah_medis_rows',
        'alergi_status',
        'alergi_tipe',
        'merokok',
        'alkohol',
        'obat_resep',
        'obat_bebas',
        'penilaian_ketidakpatuhan',
        'penilaian_pengetahuan_kurang',
        'penilaian_cara_salah',
        'penilaian_komunikasi_kurang',
        'penilaian_efek_samping',
        'penilaian_masalah_lain',
        'profesi_ttd',
        'ttd_petugas',
        'nama_petugas',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'sejarah_medis_rows' => 'array',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'penilaian_ketidakpatuhan' => 'boolean',
        'penilaian_pengetahuan_kurang' => 'boolean',
        'penilaian_cara_salah' => 'boolean',
        'penilaian_komunikasi_kurang' => 'boolean',
        'penilaian_efek_samping' => 'boolean',
        'penilaian_masalah_lain' => 'boolean',
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
                $model->no_surat = "RM 3.8/MESO/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    public function getTotalRiwayatMedisAttribute()
    {
        return is_array($this->sejarah_medis_rows) ? count($this->sejarah_medis_rows) : 0;
    }
}