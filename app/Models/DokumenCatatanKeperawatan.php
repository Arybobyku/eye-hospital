<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenCatatanKeperawatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_catatan_keperawatan';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'tanggal',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'catatan_rows',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'catatan_rows' => 'array',
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
                $model->no_surat = "RM 3.0/CP/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    public function getTotalCatatanAttribute()
    {
        return is_array($this->catatan_rows) ? count($this->catatan_rows) : 0;
    }

    public function getCatatanTerakhirAttribute()
    {
        if (!is_array($this->catatan_rows) || empty($this->catatan_rows)) {
            return null;
        }

        $sorted = collect($this->catatan_rows)
            ->sortByDesc(function ($row) {
                return $row['tanggal'] . ' ' . ($row['jam'] ?? '00:00:00');
            })
            ->first();

        return $sorted;
    }
}