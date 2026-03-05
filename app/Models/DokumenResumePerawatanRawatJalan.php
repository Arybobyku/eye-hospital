<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class DokumenResumePerawatanRawatJalan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_resume_perawatan_rawat_jalan';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'resume_rows',
        'catatan',
        'ttd_dokter',
        'nama_dokter_verifikasi',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'resume_rows' => 'array',
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
                $model->no_surat = "RM 1.6/RPPRJ/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    // Accessor untuk mendapatkan total kunjungan
    public function getTotalKunjunganAttribute()
    {
        return is_array($this->resume_rows) ? count($this->resume_rows) : 0;
    }

    // Accessor untuk mendapatkan kunjungan terakhir
    public function getKunjunganTerakhirAttribute()
    {
        if (!is_array($this->resume_rows) || empty($this->resume_rows)) {
            return null;
        }

        $sorted = collect($this->resume_rows)
            ->sortByDesc('tanggal_kunjungan')
            ->first();

        return $sorted;
    }
}