<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPenilaianRisikoJatuhPasienGeriatri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_penilaian_risiko_jatuh_pasien_geriatri';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',

        // Penilaian dinamis (JSONB) — menggantikan kolom flat item_1..item_11
        'penilaian_rows',

        // Intervensi A (Standar/Risiko Rendah)
        'int_a1',
        'int_a2',
        'int_a3',
        'int_a4',

        // Intervensi B (Risiko Tinggi)
        'int_b1',
        'int_b2',
        'int_b3',
        'int_b4',
        'int_b5',
        'int_b6',
        'int_b7',
        'int_b8',
        'int_b9',
        'int_b10',
        'int_b11',

        'nama_petugas',
        'ttd_petugas',
        'ttd_petugas_timestamp',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'penilaian_rows' => 'array',
        'int_a1'  => 'integer',
        'int_a2'  => 'integer',
        'int_a3'  => 'integer',
        'int_a4'  => 'integer',
        'int_b1'  => 'integer',
        'int_b2'  => 'integer',
        'int_b3'  => 'integer',
        'int_b4'  => 'integer',
        'int_b5'  => 'integer',
        'int_b6'  => 'integer',
        'int_b7'  => 'integer',
        'int_b8'  => 'integer',
        'int_b9'  => 'integer',
        'int_b10' => 'integer',
        'int_b11' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $model->no_surat = 'RM 6.5/FPRJPG/22';
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
