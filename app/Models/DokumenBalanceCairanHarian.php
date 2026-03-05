<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenBalanceCairanHarian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_balance_cairan_harian';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'balance_rows',
        'catatan',
        'ttd_perawat',
        'nama_perawat_verifikasi',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'balance_rows' => 'array',
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
                $model->no_surat = "M 3.1/BCH/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    // Accessor untuk mendapatkan total intake
    public function getTotalIntakeAttribute()
    {
        $total = 0;
        if (is_array($this->balance_rows)) {
            foreach ($this->balance_rows as $row) {
                $total += (isset($row['intake_total']) ? (int)$row['intake_total'] : 0);
            }
        }
        return $total;
    }

    // Accessor untuk mendapatkan total output
    public function getTotalOutputAttribute()
    {
        $total = 0;
        if (is_array($this->balance_rows)) {
            foreach ($this->balance_rows as $row) {
                $total += (isset($row['output_total']) ? (int)$row['output_total'] : 0);
            }
        }
        return $total;
    }

    // Accessor untuk mendapatkan balance
    public function getBalanceAttribute()
    {
        return $this->total_intake - $this->total_output;
    }
}