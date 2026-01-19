<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPenilaianPraAnestesiSedasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_penilaian_pra_anestesi_sedasi';

    protected $fillable = [
        'uuid', 'uuid_pasien', 'no_rm', 'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin',
        
        // Sosial
        'umur', 'jenis_kelamin_pasien', 'menikah', 'pekerjaan',
        
        // Kebiasaan
        'kebiasaan_merokok', 'kebiasaan_merokok_jumlah', 'kebiasaan_kopi', 'kebiasaan_kopi_jumlah',
        'kebiasaan_alkohol', 'kebiasaan_alkohol_jumlah', 'kebiasaan_olahraga', 'kebiasaan_olahraga_jumlah',
        
        // Pengobatan
        'obat_biasa_diminum', 'aspirin_plavix', 'aspirin_plavix_keterangan',
        'obat_anti_sakit', 'obat_anti_sakit_keterangan', 'alergi_obat', 'alergi_obat_keterangan',
        'alergi_makanan', 'alergi_makanan_keterangan', 'alergi_lainnya', 'alergi_lainnya_keterangan',
        
        // Riwayat Keluarga
        'riwayat_keluarga_perdarahan', 'riwayat_keluarga_diabetes', 'riwayat_keluarga_pembiusan',
        'riwayat_keluarga_asma', 'riwayat_keluarga_irama_jantung', 'riwayat_keluarga_lainnya',
        
        // Riwayat Pasien
        'riwayat_pasien_perdarahan', 'riwayat_pasien_mengorok', 'riwayat_pasien_nyeri_dada',
        'riwayat_pasien_hepatitis', 'riwayat_pasien_maag', 'riwayat_pasien_hipertensi',
        'riwayat_pasien_anemia', 'riwayat_pasien_diabetes', 'riwayat_pasien_serangan_jantung',
        'riwayat_pasien_pingsan', 'riwayat_pasien_asma', 'riwayat_pasien_lainnya',
        
        // Transfusi & HIV
        'transfusi_darah', 'transfusi_darah_tahun', 'pemeriksaan_hiv', 'pemeriksaan_hiv_tahun', 'hasil_hiv',
        
        // Alat Bantu
        'alat_bantu_dengar', 'kacamata', 'gigi_palsu', 'alat_bantu_lainnya',
        
        // Riwayat Operasi
        'riwayat_operasi', 'riwayat_operasi_tahun', 'riwayat_operasi_jenis',
        'anestesi_lokal_reaksi', 'anestesi_regional_reaksi', 'anestesi_umum_sedasi_reaksi',
        
        // Khusus Hamil
        'jumlah_kehamilan', 'jumlah_anak', 'menstruasi_terakhir', 'menyusui',
        
        // TTD Pasien
        'tanggal_pengisian', 'ttd_pasien', 'nama_pasien_ttd', 'ttd_perawat', 'nama_perawat_ttd',
        
        // Kajian Sistem
        'kajian_hilang_gigi', 'kajian_obesitas', 'kajian_mobilisasi_leher', 'kajian_sakit_dada',
        'kajian_leher_pendek', 'kajian_stroke', 'kajian_denyut_jantung', 'kajian_kejang',
        'kajian_sesak_napas', 'kajian_hamil',
        
        // Pemeriksaan Fisik
        'gcs', 'tekanan_darah', 'nadi', 'suhu', 'rr', 'tinggi_badan', 'berat_badan', 'bmi', 'vas',
        'buka_mulut', 'pemeriksaan_gigi_palsu', 'jarak_thyromental', 'mallampati', 'gerakan_leher',
        
        // Keadaan Umum
        'kepala', 'sklera', 'konjungtiva', 'leher', 'jantung', 'paru_paru', 'abdomen', 'ekstremitas',
        
        // Lab
        'lab_hb_ht_plt', 'lab_sgot_sgpt', 'lab_ppt_aptt', 'lab_glukosa', 'lab_ekg', 'lab_rontgen',
        
        // Diagnosis
        'diagnosis_1', 'diagnosis_2', 'asa_classification',
        
        // Perencanaan Anestesi
        'teknik_sedasi', 'teknik_ga',
        'regional_spinal', 'regional_epidural', 'regional_kaudal', 'regional_blok_perifer',
        'monitoring_ekg', 'monitoring_spo2', 'monitoring_nibp', 'monitoring_temp', 'monitoring_lainnya',
        'perawatan_rawat_inap', 'perawatan_rawat_jalan', 'perawatan_icu', 'perawatan_hdu',
        
        // Persiapan
        'puasa_jam', 'puasa_tanggal', 'rencana_operasi_jam', 'rencana_operasi_tanggal', 'catatan',
        
        // TTD Dokter
        'ttd_dokter', 'nama_dokter_ttd',
        
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pengisian' => 'date',
        'menstruasi_terakhir' => 'date',
        'puasa_tanggal' => 'date',
        'rencana_operasi_tanggal' => 'date',
        
        'umur' => 'integer',
        'jumlah_kehamilan' => 'integer',
        'jumlah_anak' => 'integer',
        'nadi' => 'integer',
        'rr' => 'integer',
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'bmi' => 'decimal:2',
        'suhu' => 'decimal:1',
        
        // Boolean
        'alat_bantu_dengar' => 'boolean',
        'kacamata' => 'boolean',
        'gigi_palsu' => 'boolean',
        'regional_spinal' => 'boolean',
        'regional_epidural' => 'boolean',
        'regional_kaudal' => 'boolean',
        'regional_blok_perifer' => 'boolean',
        'monitoring_ekg' => 'boolean',
        'monitoring_spo2' => 'boolean',
        'monitoring_nibp' => 'boolean',
        'monitoring_temp' => 'boolean',
        'perawatan_rawat_inap' => 'boolean',
        'perawatan_rawat_jalan' => 'boolean',
        'perawatan_icu' => 'boolean',
        'perawatan_hdu' => 'boolean',
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

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}