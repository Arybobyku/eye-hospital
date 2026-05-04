<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenCeklistKesiapanBedah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_ceklist_kesiapan_bedah';

    protected $fillable = [
        // ===== Identitas =====
        'uuid_pasien',
        'tanggal_tindakan',

        // ===== Data Default =====
        'no_rm',
        'no_surat',
        'jenis_kelamin',
        'nama',
        'nik',

        // ===== Data Pasien =====
        'nama_pasien',
        'no_rm_pasien',
        'tanggal_lahir',

        // ===== Form Fields =====
        'nama_ruang',
        'nama_kamar',
        'diagnosa',
        'tindakan',
        'teknik_anastesi',

        // ===== Checklist =====
        'check_phaco',
        'check_phaco_ket',
        'check_anestesi',
        'check_light_source',
        'check_ext_kabel',
        'check_meja_operasi',
        'check_mikroskop',
        'check_lampu_ok',
        'check_ac_ok',
        'check_gas_medis',

        'check_cassette',
        'check_patient_plate',
        'check_instrumen',
        'check_handle_mikro',
        'check_kom_kidney',

        'check_jas_steril',
        'check_duk',
        'check_linen',
        'check_kasa',
        'check_akhp',

        // ===== Tanda Tangan =====
        'ttd_perawat',
        'nama_lengkap_perawat',
        'ttd_kepala',
        'nama_lengkap_kepala_ruangan',
        'ttd_perawat_timestamp',
        'ttd_kepala_timestamp',

        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_tindakan' => 'date',
        'tanggal_lahir' => 'date',
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
                $model->no_surat = "RM 2.0/CKB/{$tahun}";
            }
        });
    }
}
