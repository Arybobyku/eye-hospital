<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormEdukasiPasienDanKeluargaRawatJalan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_edukasi_pasien_dan_keluarga_rawat_jalan';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'no_rm',
        'nama',
        'nik', 
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // ===== Pengkajian Hambatan =====
        'hambatan_bahasa',
        'hambatan_emosi',
        'hambatan_penglihatan',
        'hambatan_bicara_buruk',
        'hambatan_cemas',
        'hambatan_tidak_partisipasi',
        'hambatan_kognitif',
        'hambatan_motivasi',
        'hambatan_fisiologi',
        'hambatan_pendengaran',
        'hambatan_hilang_memori',
        'hambatan_tidak_ada',
        
        // ===== Edukasi =====
        'edukasi_tata_tertib',
        'edukasi_hak_kewajiban',
        
        // ===== Pengkajian Bicara =====
        'bicara_normal',
        'bicara_gangguan',
        
        // ===== Bahasa Sehari-hari =====
        'bahasa_indonesia',
        'bahasa_daerah',
        'bahasa_daerah_jelaskan',
        'bahasa_inggris',
        'bahasa_lainnya',
        'bahasa_lainnya_jelaskan',
        
        // ===== Bahasa Isyarat =====
        'bahasa_isyarat_ya',
        'bahasa_isyarat_tidak',
        
        // ===== Tingkat Pendidikan =====
        'pendidikan_tk',
        'pendidikan_sd',
        'pendidikan_smp',
        'pendidikan_sma',
        'pendidikan_diploma',
        'pendidikan_sarjana',
        'pendidikan_lainnya',
        'pendidikan_lainnya_jelaskan',
        
        // ===== Agama =====
        'agama_islam',
        'agama_protestan',
        'agama_katolik',
        'agama_hindu',
        'agama_budha',
        'agama_lainnya',
        
        // ===== Tingkat Pengetahuan =====
        'pengetahuan_paham',
        'pengetahuan_kurang_paham',
        'pengetahuan_tidak_paham',
        
        // ===== Nilai Budaya =====
        'budaya_modern',
        'budaya_moderat',
        'budaya_konvensional',
        
        // ===== Merokok =====
        'merokok_ya',
        'merokok_tidak',
        
        // ===== Konsumsi Alkohol =====
        'alkohol_ya',
        'alkohol_tidak',
        
        // ===== Ketersediaan Menerima Informasi =====
        'menerima_informasi_ya',
        'menerima_informasi_tidak',
        'menerima_informasi_alasan',
        
        // ===== Rencana Pendidikan Kesehatan =====
        'rencana_proses_penyakit',
        'rencana_pengobatan',
        'rencana_nutrisi',
        'rencana_edukasi_kolaboratif',
        'rencana_lain_lain',
        'rencana_lain_lain_jelaskan',
        
        // ===== Kebutuhan Privasi =====
        'privasi_ya',
        'privasi_tidak',
        
        // ===== Tabel Edukasi Row 1 =====
        'row1_tanggal',
        'row1_poliklinik',
        'row1_penjelasan_edukasi',
        'row1_ttd_petugas',
        'row1_sasaran_edukasi',
        'row1_eval_sudah_dimengerti',
        'row1_eval_re_demonstrasi',
        'row1_eval_re_edukasi',
        
        // ===== Tabel Edukasi Row 2 =====
        'row2_tanggal',
        'row2_poliklinik',
        'row2_penjelasan_edukasi',
        'row2_ttd_petugas',
        'row2_sasaran_edukasi',
        'row2_eval_sudah_dimengerti',
        'row2_eval_re_demonstrasi',
        'row2_eval_re_edukasi',
        
        // ===== Tabel Edukasi Row 3 =====
        'row3_tanggal',
        'row3_poliklinik',
        'row3_penjelasan_edukasi',
        'row3_ttd_petugas',
        'row3_sasaran_edukasi',
        'row3_eval_sudah_dimengerti',
        'row3_eval_re_demonstrasi',
        'row3_eval_re_edukasi',
        
        // ===== Tanda Tangan Pengkaji =====
        'ttd_pengkaji',
        'nama_pengkaji',
        'tanggal_pengkaji',
        'waktu_pengkaji',
        
        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'row1_tanggal' => 'date',
        'row2_tanggal' => 'date',
        'row3_tanggal' => 'date',
        'tanggal_pengkaji' => 'date',
        'waktu_pengkaji' => 'datetime',
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
    
    /**
     * Relasi ke tabel Pasien (jika ada)
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}