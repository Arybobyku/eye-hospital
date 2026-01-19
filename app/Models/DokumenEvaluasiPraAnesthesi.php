<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenEvaluasiPraAnesthesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_evaluasi_pra_anesthesi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Data Evaluasi
        'ruangan',
        'tanggal',
        'jam',
        
        // Diisi Oleh Pasien
        'umur',
        'jenis_kelamin_pasien',
        'menikah',
        'pekerjaan',
        
        // Kebiasaan
        'kebiasaan_merokok',
        'kebiasaan_merokok_jumlah',
        'kebiasaan_kopi',
        'kebiasaan_kopi_jumlah',
        'kebiasaan_alkohol',
        'kebiasaan_alkohol_jumlah',
        'kebiasaan_olahraga',
        'kebiasaan_olahraga_jumlah',
        
        // Pengobatan
        'obat_resep',
        'obat_bebas',
        'aspirin_rutin',
        'aspirin_dosis',
        'obat_anti_sakit',
        'obat_anti_sakit_dosis',
        'injeksi_steroid',
        'injeksi_steroid_detail',
        'alergi_obat',
        'alergi_obat_detail',
        'alergi_lateks',
        'alergi_plaster',
        'alergi_makanan',
        
        // Riwayat Keluarga
        'riwayat_keluarga_perdarahan',
        'riwayat_keluarga_jantung',
        'riwayat_keluarga_pembekuan',
        'riwayat_keluarga_hipertensi',
        'riwayat_keluarga_pembiusan',
        'riwayat_keluarga_tb',
        'riwayat_keluarga_operasi_jantung',
        'riwayat_keluarga_penyakit_berat',
        'riwayat_keluarga_diabetes',
        'riwayat_keluarga_penjelasan',
        
        // Komunikasi
        'bahasa',
        'bahasa_lainnya',
        'gangguan_penglihatan',
        'gangguan_pendengaran',
        'gangguan_bicara',
        
        // Riwayat Penyakit Pasien
        'riwayat_pasien_perdarahan',
        'riwayat_pasien_jantung',
        'riwayat_pasien_pembekuan',
        'riwayat_pasien_hepatitis',
        'riwayat_pasien_maag',
        'riwayat_pasien_sumbatan_nafas',
        'riwayat_pasien_anemia',
        'riwayat_pasien_penyakit_berat',
        'riwayat_pasien_sesak',
        'riwayat_pasien_asma',
        'riwayat_pasien_diabetes',
        'riwayat_pasien_pingsan',
        'riwayat_pasien_penjelasan',
        
        // Transfusi & HIV
        'transfusi_darah',
        'transfusi_darah_tahun',
        'pemeriksaan_hiv',
        'pemeriksaan_hiv_tahun',
        'hasil_hiv',
        
        // Alat Bantu
        'lensa_kontak',
        'kacamata',
        'alat_bantu_dengar',
        'gigi_palsu',
        
        // Riwayat Operasi
        'riwayat_operasi',
        'anestesi_lokal_komplikasi',
        'anestesi_regional_komplikasi',
        'anestesi_umum_komplikasi',
        'tanggal_periksa_terakhir',
        'tempat_periksa_terakhir',
        'gangguan_periksa_terakhir',
        
        // Khusus Perempuan
        'jumlah_kehamilan',
        'jumlah_anak',
        'menstruasi_terakhir',
        'menyusui',
        
        // Kajian Sistem
        'kajian_hilang_gigi',
        'kajian_sakit_dada',
        'kajian_mobilisasi_leher',
        'kajian_denyut_jantung',
        'kajian_leher_pendek',
        'kajian_muntah',
        'kajian_batuk',
        'kajian_susah_kencing',
        'kajian_sesak_nafas',
        'kajian_kejang',
        'kajian_infeksi_nafas',
        'kajian_hamil',
        'kajian_menstruasi_abnormal',
        'kajian_pingsan',
        'kajian_stroke',
        'kajian_obesitas',
        'kajian_keterangan',
        
        // Keadaan Umum
        'kesadaran',
        'visus',
        'faring',
        'keadaan_gigi_palsu',
        
        // Pemeriksaan Fisik
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah',
        'nadi',
        'suhu',
        'pemeriksaan_paru',
        'pemeriksaan_jantung',
        'pemeriksaan_abdomen',
        'pemeriksaan_ekstremitas',
        'pemeriksaan_neurologi',
        'pemeriksaan_fisik_keterangan',
        
        // Laboratorium
        'lab_hb_ht',
        'lab_rontgen',
        'lab_pt_aptt',
        'lab_ekg',
        'lab_tes_kehamilan',
        'lab_na_cl',
        'lab_kalium',
        'lab_co2',
        'lab_ureum',
        'lab_kreatinin',
        'lab_lainnya',
        'lab_keterangan',
        
        // Diagnosis
        'diagnosis',
        'klasifikasi_asa',
        
        // Rekomendasi Anestesi
        'anestesi_umum_intravena',
        'anestesi_umum_sungkup',
        'anestesi_umum_lma',
        'anestesi_umum_pipa',
        'regional_spinal',
        'regional_epidural',
        'regional_kombinasi',
        'regional_peripheral',
        'anestesi_umum_regional',
        
        // Jadwal
        'puasa_jam',
        'puasa_tanggal',
        'rencana_tiba_jam',
        'rencana_tiba_tanggal',
        'rencana_operasi_jam',
        'rencana_operasi_tanggal',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter_ttd',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'tanggal_periksa_terakhir' => 'date',
        'menstruasi_terakhir' => 'date',
        'puasa_tanggal' => 'date',
        'rencana_tiba_tanggal' => 'date',
        'rencana_operasi_tanggal' => 'date',
        
        'umur' => 'integer',
        'jumlah_kehamilan' => 'integer',
        'jumlah_anak' => 'integer',
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'nadi' => 'integer',
        'suhu' => 'decimal:1',
        
        // Boolean fields
        'anestesi_umum_intravena' => 'boolean',
        'anestesi_umum_sungkup' => 'boolean',
        'anestesi_umum_lma' => 'boolean',
        'anestesi_umum_pipa' => 'boolean',
        'regional_spinal' => 'boolean',
        'regional_epidural' => 'boolean',
        'regional_kombinasi' => 'boolean',
        'regional_peripheral' => 'boolean',
        'anestesi_umum_regional' => 'boolean',
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

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}