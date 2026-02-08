<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormPengkajianKeperawatanMataRawatJalan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_pengkajian_keperawatan_mata_rawat_jalan';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // ===== Tanggal & Waktu Pengkajian =====
        'tanggal',
        'waktu',
        'perawat_pengkaji',
        
        // ===== Status Fungsional =====
        'jalan_tanpa_bantuan',
        'kursi_roda',
        'tempat_tidur_dorong',
        'jalan_dengan_bantuan',
        
        // ===== Kasus Urgent =====
        'urgent_mata_merah',
        'urgent_trauma_kesakitan',
        'urgent_mata_kabur_mendadak',
        'urgent_balita_manula',
        'urgent_lain_lain',
        'urgent_lain_lain_text',
        
        // ===== Keluhan & Riwayat =====
        'keluhan_utama',
        'riwayat_penyakit',
        
        // ===== Pemeriksaan Fisik =====
        'td',
        'bb',
        'tb',
        'nadi',
        'rr',
        'suhu',
        
        // ===== Riwayat Kesehatan - Penyakit =====
        'penyakit_diabetes',
        'penyakit_hipertensi',
        'penyakit_jantung',
        'penyakit_hepatitis',
        'penyakit_asma',
        'penyakit_lainnya',
        'penyakit_lainnya_text',
        
        // ===== Riwayat Operasi =====
        'pernah_operasi',
        'jenis_operasi',
        
        // ===== Riwayat Alergi =====
        'riwayat_alergi',
        'alergi_makanan',
        'alergi_makanan_text',
        
        // ===== Obat yang Digunakan =====
        'obat_pencair_darah',
        'obat_asma',
        'obat_alergi_steroid',
        'obat_prostat',
        'obat_lain',
        'obat_lain_text',
        
        // ===== Penilaian Risiko Jatuh =====
        'resiko_jatuh',
        
        // ===== Skrining Nyeri =====
        'tidak_ada_nyeri',
        'nyeri_akut',
        'nyeri_kronis',
        'skala_nyeri',
        'pain_scale_value',
        'lokasi_nyeri',
        'karakteristik_nyeri',
        'durasi_nyeri',
        'nyeri_hilang_minum_obat',
        'nyeri_hilang_istirahat',
        'nyeri_hilang_berubah_posisi',
        'nyeri_hilang_lainnya',
        'nyeri_hilang_lainnya_text',
        
        // ===== Diagnosa Keperawatan =====
        'diagnosa_gangguan_sensori',
        'diagnosa_resiko_jatuh',
        'diagnosa_resiko_infeksi',
        'diagnosa_nyeri',
        'diagnosa_kurang_pengetahuan',
        'diagnosa_cemas',
        'diagnosa_tertunda_pemulihan',
        'diagnosa_ketidakefektifan_proteksi',
        
        // ===== Intervensi Keperawatan =====
        'intervensi_pengkajian_awal',
        'intervensi_edukasi_jatuh',
        'intervensi_cuci_tangan',
        'intervensi_edukasi_infeksi',
        'intervensi_penilaian_nyeri',
        'intervensi_tetes_mata',
        'intervensi_bersihkan_luka',
        'intervensi_jelaskan_prosedur',
        'intervensi_info_preoperasi',
        'intervensi_patching',
        
        // ===== Tanda Tangan =====
        'tanggal_ttd',
        'waktu_ttd',
        'ttd_perawat',
        'nama_perawat_ttd',
        
        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_ttd' => 'date',
        
        // Cast boolean untuk checkbox fields
        'jalan_tanpa_bantuan' => 'boolean',
        'kursi_roda' => 'boolean',
        'tempat_tidur_dorong' => 'boolean',
        'jalan_dengan_bantuan' => 'boolean',
        
        'urgent_mata_merah' => 'boolean',
        'urgent_trauma_kesakitan' => 'boolean',
        'urgent_mata_kabur_mendadak' => 'boolean',
        'urgent_balita_manula' => 'boolean',
        'urgent_lain_lain' => 'boolean',
        
        'penyakit_diabetes' => 'boolean',
        'penyakit_hipertensi' => 'boolean',
        'penyakit_jantung' => 'boolean',
        'penyakit_hepatitis' => 'boolean',
        'penyakit_asma' => 'boolean',
        'penyakit_lainnya' => 'boolean',
        
        'pernah_operasi' => 'boolean',
        'riwayat_alergi' => 'boolean',
        'alergi_makanan' => 'boolean',
        
        'obat_pencair_darah' => 'boolean',
        'obat_asma' => 'boolean',
        'obat_alergi_steroid' => 'boolean',
        'obat_prostat' => 'boolean',
        'obat_lain' => 'boolean',
        
        'resiko_jatuh' => 'boolean',
        
        'tidak_ada_nyeri' => 'boolean',
        'nyeri_akut' => 'boolean',
        'nyeri_kronis' => 'boolean',
        'nyeri_hilang_minum_obat' => 'boolean',
        'nyeri_hilang_istirahat' => 'boolean',
        'nyeri_hilang_berubah_posisi' => 'boolean',
        'nyeri_hilang_lainnya' => 'boolean',
        
        'diagnosa_gangguan_sensori' => 'boolean',
        'diagnosa_resiko_jatuh' => 'boolean',
        'diagnosa_resiko_infeksi' => 'boolean',
        'diagnosa_nyeri' => 'boolean',
        'diagnosa_kurang_pengetahuan' => 'boolean',
        'diagnosa_cemas' => 'boolean',
        'diagnosa_tertunda_pemulihan' => 'boolean',
        'diagnosa_ketidakefektifan_proteksi' => 'boolean',
        
        'intervensi_pengkajian_awal' => 'boolean',
        'intervensi_edukasi_jatuh' => 'boolean',
        'intervensi_cuci_tangan' => 'boolean',
        'intervensi_edukasi_infeksi' => 'boolean',
        'intervensi_penilaian_nyeri' => 'boolean',
        'intervensi_tetes_mata' => 'boolean',
        'intervensi_bersihkan_luka' => 'boolean',
        'intervensi_jelaskan_prosedur' => 'boolean',
        'intervensi_info_preoperasi' => 'boolean',
        'intervensi_patching' => 'boolean',
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
     * Relasi ke tabel Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
    
    /**
     * Scope untuk filter data aktif (tidak dihapus)
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
    
    /**
     * Scope untuk filter berdasarkan pasien
     */
    public function scopeByPasien($query, $uuidPasien)
    {
        return $query->where('uuid_pasien', $uuidPasien);
    }
}