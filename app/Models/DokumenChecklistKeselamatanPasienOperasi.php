<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenChecklistKeselamatanPasienOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_checklist_keselamatan_pasien_operasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_ttd',

        // Sign In
        'signin_waktu',
        'signin_q1',
        'signin_q2',
        'signin_q3',
        'signin_q4',
        'signin_q5',
        'signin_q6',
        'signin_q7',
        'signin_ttd_dr_anestesi',
        'signin_nama_dr_anestesi',
        'signin_ttd_perawat_anestesi',
        'signin_nama_perawat_anestesi',
        'signin_ttd_perawat',
        'signin_nama_perawat',
        'signout_tanggal',

        // Time Out
        'timeout_waktu',
        'timeout_q1',
        'timeout_q2',
        'timeout_q3',
        'timeout_q4_tindakan_beresiko',
        'timeout_q4_lama_tindakan',
        'timeout_q4_antisipasi_perdarahan',
        'timeout_q5',
        'timeout_q6_kesterilan',
        'timeout_q6_implan',
        'timeout_q6_masalah_alat',
        'timeout_q6_radiologi',
        'timeout_ttd_dr_anestesi',
        'timeout_nama_dr_anestesi',
        'timeout_ttd_perawat_anestesi',
        'timeout_nama_perawat_anestesi',
        'timeout_ttd_perawat_sirkuler',
        'timeout_nama_perawat_sirkuler',

        // Sign Out
        'signout_waktu',
        'signout_q1',
        'signout_q2',
        'signout_q3',
        'signout_q4',
        'signout_q5',
        'signout_ttd_dr_bedah',
        'signout_nama_dr_bedah',
        'signout_ttd_dr_anestesi',
        'signout_nama_dr_anestesi',
        'signout_ttd_perawat_anestesi',
        'signout_nama_perawat_anestesi',
        'signout_ttd_perawat_instrument',
        'signout_nama_perawat_instrument',
        'signout_ttd_perawat_sirkuler',
        'signout_nama_perawat_sirkuler',

        // Meta
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $model->no_surat = 'RM/4.9/CLKPO/22';
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
