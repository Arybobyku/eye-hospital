<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenStatusOftalmologis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_status_oftalmologis';

    protected $fillable = [
        'uuid',
        'uuid_pasien',

        // Identitas Pasien
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',
        'tanggal_lahir',

        // Kunjungan
        'tanggal_kunjungan',
        'jam_kunjungan',

        // OD
        'od_pd', 'od_autoref_s', 'od_autoref_c', 'od_autoref_x',
        'od_kk1', 'od_kk1_axis', 'od_kk2', 'od_kk2_axis',
        'od_tonometri', 'od_visus', 'od_bcva', 'od_add',
        'od_kacamata_sph', 'od_kacamata_cyl', 'od_kacamata_x', 'od_kacamata_addisi',

        // OS
        'os_pd', 'os_autoref_s', 'os_autoref_c', 'os_autoref_x',
        'os_kk1', 'os_kk1_axis', 'os_kk2', 'os_kk2_axis',
        'os_tonometri', 'os_visus', 'os_bcva', 'os_add',
        'os_kacamata_sph', 'os_kacamata_cyl', 'os_kacamata_x', 'os_kacamata_addisi',

        // Posisi bola mata
        'posisi_normal',
        'diagram_mata',

        // Status table
        'status_palpebra_od_normal', 'status_palpebra_os_normal', 'status_palpebra_ket',
        'status_conjunctiva_od_normal', 'status_conjunctiva_os_normal', 'status_conjunctiva_ket',
        'status_cornea_od_normal', 'status_cornea_os_normal', 'status_cornea_ket',
        'status_bmd_od_normal', 'status_bmd_os_normal', 'status_bmd_ket',
        'status_pupil_iris_od_normal', 'status_pupil_iris_os_normal', 'status_pupil_iris_ket',
        'status_lensa_od_normal', 'status_lensa_os_normal', 'status_lensa_ket',
        'status_vitreous_od_normal', 'status_vitreous_os_normal', 'status_vitreous_ket',
        'status_funduscopy_od_normal', 'status_funduscopy_os_normal', 'status_funduscopy_ket',

        // Klinis
        'pemeriksaan_penunjang',
        'diagnose_kerja', 'diagnose_kerja_icd',
        'diagnose_banding', 'diagnose_banding_icd',
        'tata_laksana',
        'perencanaan',
        'prognosa',

        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',
        'dokter_ttd_timestamp',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'    => 'date',
        'tanggal_kunjungan'=> 'date',
        'posisi_normal'    => 'boolean',
        'status_palpebra_od_normal'    => 'boolean',
        'status_palpebra_os_normal'    => 'boolean',
        'status_conjunctiva_od_normal' => 'boolean',
        'status_conjunctiva_os_normal' => 'boolean',
        'status_cornea_od_normal'      => 'boolean',
        'status_cornea_os_normal'      => 'boolean',
        'status_bmd_od_normal'         => 'boolean',
        'status_bmd_os_normal'         => 'boolean',
        'status_pupil_iris_od_normal'  => 'boolean',
        'status_pupil_iris_os_normal'  => 'boolean',
        'status_lensa_od_normal'       => 'boolean',
        'status_lensa_os_normal'       => 'boolean',
        'status_vitreous_od_normal'    => 'boolean',
        'status_vitreous_os_normal'    => 'boolean',
        'status_funduscopy_od_normal'  => 'boolean',
        'status_funduscopy_os_normal'  => 'boolean',
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
                $model->no_surat = "RM 1.4/SORJ/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
