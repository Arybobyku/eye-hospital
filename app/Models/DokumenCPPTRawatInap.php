<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenCPPTRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_cppt_rawat_inap';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal',
        'cppt_rows',
        'catatan_khusus',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'cppt_rows' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke tabel pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    /**
     * Accessor untuk mendapatkan total catatan
     */
    public function getTotalCatatanAttribute()
    {
        return is_array($this->cppt_rows) ? count($this->cppt_rows) : 0;
    }

    /**
     * Accessor untuk mendapatkan catatan terakhir
     */
    public function getCatatanTerakhirAttribute()
    {
        if (!is_array($this->cppt_rows) || empty($this->cppt_rows)) {
            return null;
        }

        $sorted = collect($this->cppt_rows)
            ->sortByDesc(function ($row) {
                return $row['tanggal'] . ' ' . ($row['jam'] ?? '00:00:00');
            })
            ->first();

        return $sorted;
    }
}