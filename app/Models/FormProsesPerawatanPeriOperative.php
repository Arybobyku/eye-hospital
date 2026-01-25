<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormProsesPerawatanPeriOperative extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_proses_perawatan_peri_operative';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nama',
        'nik', 
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // Tanggal & Waktu Form
        'tanggal',
        'waktu',
        
        // A. CATATAN PERAWATAN SEBELUM OPERASI (Perawat Ruangan)
        'ruangan',
        'jenis_pasien',
        'diagnosis',
        'tindakan_operasi',
        'dokter_operator',
        'dokter_anestesi',
        
        // 1. Vital Signs
        'vital_temp',
        'vital_nadi',
        'vital_pernapasan',
        'vital_tekanan_darah',
        'vital_tinggi',
        'vital_berat',
        
        // 2. Riwayat Penyakit
        'riwayat_hipertensi',
        'riwayat_diabetes',
        'riwayat_hepatitis',
        'riwayat_lainnya',
        'riwayat_lainnya_text',
        
        // 3. Alergi
        'alergi_tidak_tahu',
        'alergi_ya',
        'alergi_ya_text',
        
        // 4. Hasil KGD
        'hasil_kgd',
        'waktu_pengambilan_kgd',
        
        // B. CATATAN PERAWATAN SEBELUM OPERASI (Checklist)
        // Checklist 1 - Identitas Pasien
        'checklist_1_identitas_ruang',
        'checklist_1_identitas_ok1',
        'checklist_1_identitas_ok2',
        'checklist_1_keterangan',
        
        // Checklist 2 - Gelang Nama
        'checklist_2_gelang_ruang',
        'checklist_2_gelang_ok1',
        'checklist_2_gelang_ok2',
        'checklist_2_keterangan',
        
        // Checklist 3 - Persetujuan Operasi
        'checklist_3_persetujuan_ruang',
        'checklist_3_persetujuan_ok1',
        'checklist_3_persetujuan_ok2',
        'checklist_3_keterangan',
        
        // Checklist 4 - Premedikasi
        'checklist_4_premedikasi_ruang',
        'checklist_4_premedikasi_ok1',
        'checklist_4_premedikasi_ok2',
        'checklist_4_keterangan',
        
        // Checklist 5 - Makan Minum
        'checklist_5_makan_minum_ruang',
        'checklist_5_makan_minum_ok1',
        'checklist_5_makan_minum_ok2',
        'checklist_5_keterangan',
        
        // Checklist 6 - Prothesa
        'checklist_6_prothesa_ruang',
        'checklist_6_prothesa_ok1',
        'checklist_6_prothesa_ok2',
        'checklist_6_keterangan',
        
        // Checklist 7 - Perhiasan
        'checklist_7_perhiasan_ruang',
        'checklist_7_perhiasan_ok1',
        'checklist_7_perhiasan_ok2',
        'checklist_7_keterangan',
        
        // Checklist 8 - Status Pasien
        'checklist_8_status_ruang',
        'checklist_8_status_ok1',
        'checklist_8_status_ok2',
        'checklist_8_keterangan',
        
        // Checklist 9 - X-ray
        'checklist_9_xray_ruang',
        'checklist_9_xray_ok1',
        'checklist_9_xray_ok2',
        'checklist_9_keterangan',
        
        // Checklist 10 - Pencukuran
        'checklist_10_pencukuran_ruang',
        'checklist_10_pencukuran_ok1',
        'checklist_10_pencukuran_ok2',
        'checklist_10_keterangan',
        
        // Checklist 11 - Darah
        'checklist_11_darah_ruang',
        'checklist_11_darah_ok1',
        'checklist_11_darah_ok2',
        'checklist_11_keterangan',
        
        // Checklist 12 - Site Marker
        'checklist_12_site_marker_ruang',
        'checklist_12_site_marker_ok1',
        'checklist_12_site_marker_ok2',
        'checklist_12_keterangan',
        
        // Tanda Tangan Perawat Ruangan
        'ttd_perawat_ruangan',
        'ttd_perawat_ruangan_waktu',
        'ttd_perawat_ruangan_tanggal',
        'nama_perawat_ruangan',
        
        // Tanda Tangan Perawat Kamar Bedah
        'ttd_perawat_kamar_bedah',
        'ttd_perawat_kamar_bedah_waktu',
        'ttd_perawat_kamar_bedah_tanggal',
        'nama_perawat_kamar_bedah',
        
        // Audit
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'ttd_perawat_ruangan_tanggal' => 'date',
        'ttd_perawat_kamar_bedah_tanggal' => 'date',
        
        // Cast boolean fields
        'riwayat_hipertensi' => 'boolean',
        'riwayat_diabetes' => 'boolean',
        'riwayat_hepatitis' => 'boolean',
        'riwayat_lainnya' => 'boolean',
        'alergi_tidak_tahu' => 'boolean',
        'alergi_ya' => 'boolean',
        
        // Checklist 1
        'checklist_1_identitas_ruang' => 'boolean',
        'checklist_1_identitas_ok1' => 'boolean',
        'checklist_1_identitas_ok2' => 'boolean',
        
        // Checklist 2
        'checklist_2_gelang_ruang' => 'boolean',
        'checklist_2_gelang_ok1' => 'boolean',
        'checklist_2_gelang_ok2' => 'boolean',
        
        // Checklist 3
        'checklist_3_persetujuan_ruang' => 'boolean',
        'checklist_3_persetujuan_ok1' => 'boolean',
        'checklist_3_persetujuan_ok2' => 'boolean',
        
        // Checklist 4
        'checklist_4_premedikasi_ruang' => 'boolean',
        'checklist_4_premedikasi_ok1' => 'boolean',
        'checklist_4_premedikasi_ok2' => 'boolean',
        
        // Checklist 5
        'checklist_5_makan_minum_ruang' => 'boolean',
        'checklist_5_makan_minum_ok1' => 'boolean',
        'checklist_5_makan_minum_ok2' => 'boolean',
        
        // Checklist 6
        'checklist_6_prothesa_ruang' => 'boolean',
        'checklist_6_prothesa_ok1' => 'boolean',
        'checklist_6_prothesa_ok2' => 'boolean',
        
        // Checklist 7
        'checklist_7_perhiasan_ruang' => 'boolean',
        'checklist_7_perhiasan_ok1' => 'boolean',
        'checklist_7_perhiasan_ok2' => 'boolean',
        
        // Checklist 8
        'checklist_8_status_ruang' => 'boolean',
        'checklist_8_status_ok1' => 'boolean',
        'checklist_8_status_ok2' => 'boolean',
        
        // Checklist 9
        'checklist_9_xray_ruang' => 'boolean',
        'checklist_9_xray_ok1' => 'boolean',
        'checklist_9_xray_ok2' => 'boolean',
        
        // Checklist 10
        'checklist_10_pencukuran_ruang' => 'boolean',
        'checklist_10_pencukuran_ok1' => 'boolean',
        'checklist_10_pencukuran_ok2' => 'boolean',
        
        // Checklist 11
        'checklist_11_darah_ruang' => 'boolean',
        'checklist_11_darah_ok1' => 'boolean',
        'checklist_11_darah_ok2' => 'boolean',
        
        // Checklist 12
        'checklist_12_site_marker_ruang' => 'boolean',
        'checklist_12_site_marker_ok1' => 'boolean',
        'checklist_12_site_marker_ok2' => 'boolean',
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