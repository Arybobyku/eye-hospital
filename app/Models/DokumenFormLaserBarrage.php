<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenFormLaserBarrage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_form_laser_barrage';

    protected $fillable = [
        'uuid', 'uuid_pasien',
        'no_rm','no_surat', 'jenis_kelamin', 'nama', 'nik',
        'nama_pasien', 'no_rm_pasien', 'jenis_kelamin_display',
        'tanggal_lahir', 'tanggal', 'diagnosa',
        'parameter_laser_barrage',
        'mata_kanan', 'mata_kiri',
        'ttd_dokter', 'dokter_ttd_timestamp', 'nama_dokter',
        'created_by', 'updated_by',
        'diagram_mata',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'mata_kanan' => 'boolean',
        'mata_kiri' => 'boolean',
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
                $model->no_surat = "RM 10.5/FTLB/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
