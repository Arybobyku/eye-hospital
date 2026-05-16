<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanInsiden extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_insiden';

    protected $fillable = [
        'uuid', 'uuid_pasien',
        'no_rm', 'no_surat', 'jenis_kelamin', 'nama', 'nik', 'tanggal_lahir',
        'ruangan',

        // Umur
        'umur_0_1_bulan', 'umur_1_bulan_1_tahun', 'umur_1_5_tahun',
        'umur_5_15_tahun', 'umur_15_30_tahun', 'umur_30_65_tahun', 'umur_65_plus',

        // Biaya
        'biaya_pribadi', 'biaya_asuransi_swasta', 'biaya_perusahaan', 'biaya_bpjs',

        // Masuk RS
        'tanggal_masuk_rs', 'jam_masuk_rs',

        // Rincian Kejadian
        'insiden_tanggal', 'insiden_jam', 'insiden_deskripsi', 'kronologis_insiden',

        // Jenis Insiden
        'jenis_knc', 'jenis_ktc', 'jenis_ktd',

        // Pelapor
        'pelapor_karyawan', 'pelapor_pasien', 'pelapor_keluarga',
        'pelapor_pengunjung', 'pelapor_lainnya', 'pelapor_lainnya_sebutkan',

        // Terjadi pada
        'terjadi_pada_pasien', 'terjadi_pada_lainnya', 'terjadi_pada_lainnya_sebutkan',

        // Menyangkut pasien
        'pasien_rawat_inap', 'pasien_rawat_jalan', 'pasien_igd',
        'pasien_lainnya', 'pasien_lainnya_sebutkan',

        // Tempat
        'lokasi_kejadian',

        // Spesialisasi
        'spesialisasi_penyakit_mata', 'spesialisasi_lainnya', 'spesialisasi_lainnya_sebutkan',

        // Unit
        'unit_kerja_penyebab',

        // Akibat
        'akibat_kematian', 'akibat_cedera_berat', 'akibat_cedera_sedang',
        'akibat_cedera_ringan', 'akibat_tidak_cedera',

        // Tindakan
        'tindakan_hasil', 'tindakan_tim', 'tindakan_tim_terdiri',
        'tindakan_dokter', 'tindakan_perawat',
        'tindakan_petugas_lainnya', 'tindakan_petugas_lainnya_sebutkan',

        // Kejadian sama
        'kejadian_sama_ya', 'kejadian_sama_tidak', 'kejadian_sama_keterangan',

        // Pembuat/Penerima
        'pembuat_laporan', 'pembuat_laporan_paraf', 'tgl_terima',
        'penerima_laporan', 'penerima_laporan_paraf', 'tgl_lapor',

        // Grading
        'grading_biru', 'grading_hijau', 'grading_kuning', 'grading_merah',

        'created_by', 'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir'       => 'date',
        'tanggal_masuk_rs'    => 'date',
        'insiden_tanggal'     => 'date',
        'tgl_terima'          => 'date',
        'tgl_lapor'           => 'date',

        // Umur
        'umur_0_1_bulan'      => 'boolean',
        'umur_1_bulan_1_tahun'=> 'boolean',
        'umur_1_5_tahun'      => 'boolean',
        'umur_5_15_tahun'     => 'boolean',
        'umur_15_30_tahun'    => 'boolean',
        'umur_30_65_tahun'    => 'boolean',
        'umur_65_plus'        => 'boolean',

        // Biaya
        'biaya_pribadi'        => 'boolean',
        'biaya_asuransi_swasta'=> 'boolean',
        'biaya_perusahaan'     => 'boolean',
        'biaya_bpjs'           => 'boolean',

        // Jenis Insiden
        'jenis_knc' => 'boolean',
        'jenis_ktc' => 'boolean',
        'jenis_ktd' => 'boolean',

        // Pelapor
        'pelapor_karyawan'  => 'boolean',
        'pelapor_pasien'    => 'boolean',
        'pelapor_keluarga'  => 'boolean',
        'pelapor_pengunjung'=> 'boolean',
        'pelapor_lainnya'   => 'boolean',

        // Terjadi pada
        'terjadi_pada_pasien' => 'boolean',
        'terjadi_pada_lainnya'=> 'boolean',

        // Menyangkut pasien
        'pasien_rawat_inap' => 'boolean',
        'pasien_rawat_jalan'=> 'boolean',
        'pasien_igd'        => 'boolean',
        'pasien_lainnya'    => 'boolean',

        // Spesialisasi
        'spesialisasi_penyakit_mata' => 'boolean',
        'spesialisasi_lainnya'       => 'boolean',

        // Akibat
        'akibat_kematian'     => 'boolean',
        'akibat_cedera_berat' => 'boolean',
        'akibat_cedera_sedang'=> 'boolean',
        'akibat_cedera_ringan'=> 'boolean',
        'akibat_tidak_cedera' => 'boolean',

        // Tindakan
        'tindakan_tim'           => 'boolean',
        'tindakan_dokter'        => 'boolean',
        'tindakan_perawat'       => 'boolean',
        'tindakan_petugas_lainnya'=> 'boolean',

        // Kejadian sama
        'kejadian_sama_ya'   => 'boolean',
        'kejadian_sama_tidak'=> 'boolean',

        // Grading
        'grading_biru'   => 'boolean',
        'grading_hijau'  => 'boolean',
        'grading_kuning' => 'boolean',
        'grading_merah'  => 'boolean',
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
                $model->no_surat = "RM 7.9/LI/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
