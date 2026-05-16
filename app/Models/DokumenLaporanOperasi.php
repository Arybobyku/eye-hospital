<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_operasi';

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

        // Tim Operasi
        'ahli_bedah',
        'asisten_dokter',
        'ahli_anestesi',
        'instrumen',

        // Diagnosa & Waktu
        'diagnosa_prabedah',
        'diagnosa_pasca_bedah',
        'pembedahan_mulai_pukul',
        'pembedahan_selesai_pukul',
        'lama_tindakan',
        'tanggal',

        // Jenis Pembedahan
        'jenis_pembedahan',
        'macam_pembedahan',

        // Checkboxes
        'jenis_besar', 'jenis_sedang', 'jenis_kecil',
        'tipe_elektif', 'tipe_emergency', 'tipe_khusus',

        // Transfusi
        'transfusi_tidak', 'transfusi_ya', 'transfusi_jenis_jumlah',

        // Implan
        'implan_tidak', 'implan_ya', 'implan_jenis_jumlah',

        // Uraian
        'uraian_pembedahan',

        // Page 2
        'komplikasi_intra_operasi',
        'konsultasi_intra_operasi',
        'jumlah_perdarahan',
        'jaringan_patologi_ya',
        'jaringan_patologi_tidak',

        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',
        'dokter_ttd_timestamp',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'        => 'date',
        'tanggal'              => 'date',
        'jenis_besar'          => 'boolean',
        'jenis_sedang'         => 'boolean',
        'jenis_kecil'          => 'boolean',
        'tipe_elektif'         => 'boolean',
        'tipe_emergency'       => 'boolean',
        'tipe_khusus'          => 'boolean',
        'transfusi_tidak'      => 'boolean',
        'transfusi_ya'         => 'boolean',
        'implan_tidak'         => 'boolean',
        'implan_ya'            => 'boolean',
        'jaringan_patologi_ya' => 'boolean',
        'jaringan_patologi_tidak' => 'boolean',
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
                $model->no_surat = "RM 5.0/LO/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
