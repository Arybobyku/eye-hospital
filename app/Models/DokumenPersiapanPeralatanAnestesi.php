<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPersiapanPeralatanAnestesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_persiapan_peralatan_anestesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',

        // Form fields
        'ruangan',
        'tanggal_tindakan',
        'jam_tindakan',
        'jenis_operasi',
        'teknik_anestesia',

        // Listrik
        'check_mesin_anestesia',
        'check_layar_pemantauan',
        'check_defibrilator',

        // Gas Medis
        'check_selang_oksigen',
        'check_flow_o2',
        'check_compressed_air',
        'check_flow_air',
        'check_n2o',
        'check_flow_n2o',

        // Mesin Anestesia
        'check_power_on',
        'check_self_calibration',
        'check_tidak_bocor',
        'check_zat_volatil',
        'check_absorber_co2',

        // Manajemen Jalan Nafas
        'check_sungkup_muka',
        'check_oropharyngeal',
        'check_laringoskop_baterai',
        'check_bilah_laringoskop',
        'check_gagang_bilah',
        'check_ett_lma',
        'check_stilet',
        'check_semprit_cuff',
        'check_forceps_magill',

        // Pemantauan
        'check_kabel_ekg',
        'check_elektroda_ekg',
        'check_nibp',
        'check_spo2',
        'check_kapnografi',
        'check_pemantau_suhu',

        // Lain-lain
        'check_stetoskop',
        'check_suction',
        'check_selang_suction',
        'check_plester',
        'check_blanket_roll',
        'check_blanket_alas',
        'check_xylocaine',

        // Obat-obat
        'check_epinefrin',
        'check_atropin',
        'check_sedatif',
        'check_opiat',
        'check_pelumpuh_otot',
        'check_antibiotika',
        'lain_lain_obat',

        // TTD Perawat Anestesi
        'ttd_perawat_anestesi',
        'nama_perawat_anestesi',
        'ttd_perawat_timestamp',

        // TTD Dokter Anestesi
        'ttd_dr_anestesi',
        'nama_dr_anestesi',
        'ttd_dr_timestamp',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'   => 'date',
        'tanggal_tindakan' => 'date',
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
                $model->no_surat = "RM 5.1/PPA/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
