<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenFormLaserBargage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_form_laser_bargage';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'tanggal',
        'waktu',
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'dokter_pelaksana',
        'perawat_asisten',
        'ruangan',
        'nomor_kamar',
        'diagnosa_pra_tindakan',
        'indikasi_tindakan',
        'lokasi_anatomis',
        'area_spesifik',
        'deskripsi_lesi',
        'jenis_laser',
        'jenis_laser_lainnya',
        'wavelength',
        'power_energy',
        'pulse_duration',
        'spot_size',
        'jumlah_pulsa',
        'durasi_tindakan',
        'jenis_anestesi',
        'obat_anestesi',
        'persiapan_pasien',
        'teknik_tindakan',
        'temuan_tindakan',
        'hasil_tindakan',
        'kondisi_pasien',
        'ada_komplikasi',
        'deskripsi_komplikasi',
        'catatan_tambahan',
        'instruksi_perawatan_luka',
        'instruksi_obat',
        'instruksi_aktivitas',
        'tanggal_kontrol',
        'instruksi_tanda_bahaya',
        'ttd_dokter',
        'nama_dokter_ttd',
        'ttd_perawat',
        'nama_perawat_ttd',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
        'tanggal_lahir' => 'date',
        'tanggal_kontrol' => 'date',
        'jumlah_pulsa' => 'integer',
        'durasi_tindakan' => 'integer',
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

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
