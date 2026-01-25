<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Informasi Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // Pengkajian Hambatan
        'hambatan_bahasa',
        'hambatan_emosi',
        'hambatan_masalah_penglihatan',
        'hambatan_bicara_buruk',
        'hambatan_cemas',
        'hambatan_tidak_ada_partisipasi',
        'hambatan_kognitif',
        'hambatan_motivasi',
        'hambatan_fisiologi_tidak_mampu',
        'hambatan_pendengaran',
        'hambatan_hilang_memori',
        'hambatan_tidak_ditemukan',
        
        // Metode Cara Belajar
        'metode_audio',
        'metode_demonstrasi',
        'metode_lisan',
        'metode_tulisan',
        'metode_visual',
        
        // Edukasi
        'edukasi_tata_tertib_rs',
        'edukasi_hak_kewajiban',
        
        // Pengkajian Bicara
        'bicara_normal',
        'bicara_gangguan',
        
        // Bahasa Sehari-hari
        'bahasa_indonesia',
        'bahasa_daerah',
        'bahasa_daerah_text',
        'bahasa_inggris',
        'bahasa_lainnya',
        'bahasa_lainnya_text',
        
        // Bahasa Isyarat
        'bahasa_isyarat_ya',
        'bahasa_isyarat_tidak',
        
        // Tingkat Pendidikan
        'pendidikan_tk',
        'pendidikan_sd',
        'pendidikan_smp',
        'pendidikan_sma',
        'pendidikan_diploma',
        'pendidikan_sarjana',
        'pendidikan_lainnya',
        'pendidikan_lainnya_text',
        
        // Agama
        'agama_islam',
        'agama_protestan',
        'agama_katolik',
        'agama_hindu',
        'agama_budha',
        'agama_lainnya',
        
        // Tingkat Pengetahuan
        'pengetahuan_paham',
        'pengetahuan_kurang_paham',
        'pengetahuan_tidak_paham',
        
        // Nilai-nilai Budaya
        'budaya_modern',
        'budaya_moderat',
        'budaya_konvensional',
        
        // Merokok & Alkohol
        'merokok_ya',
        'merokok_tidak',
        'alkohol_ya',
        'alkohol_tidak',
        
        // Ketersediaan Menerima Informasi
        'menerima_info_ya',
        'menerima_info_tidak',
        'menerima_info_alasan',
        
        // Rencana Pendidikan Kesehatan
        'rencana_proses_penyakit',
        'rencana_pengobatan_tindakan',
        'rencana_nutrisi',
        'rencana_edukasi_kolaboratif',
        'rencana_lain_lain',
        'rencana_lain_lain_text',
        
        // Penerima Pendidikan
        'penerima_pasien',
        'penerima_keluarga',
        'penerima_lainnya',
        
        // Frekuensi Edukasi
        'frekuensi_edukasi_pertama',
        'frekuensi_reedukasi',
        
        // Evaluasi Respon
        'evaluasi_tidak_mengerti',
        'evaluasi_menyatakan_paham',
        'evaluasi_mampu_menjelaskan',
        'evaluasi_mampu_demonstrasi',
        
        // Kebutuhan Privasi
        'privasi_ya',
        'privasi_tidak',
        
        // Tanda Tangan Pengkaji
        'ttd_pengkaji',
        'nama_pengkaji',
        'tanggal_pengkaji',
        'waktu_pengkaji',
        
        // Dokter DPJP
        'ttd_dokter_dpjp',
        'nama_dokter_dpjp',
        
        // SECTION DOKTER
        'edukasi_dokter1', 'edukasi_dokter2', 'edukasi_dokter3', 'edukasi_dokter4', 'edukasi_dokter5', 
        'edukasi_dokter6', 'edukasi_dokter7', 'edukasi_dokter8', 'edukasi_dokter9',
        
        'promotif_dokter_1', 'promotif_dokter_2', 'promotif_dokter_3', 'promotif_dokter_4', 'promotif_dokter_5',
        'promotif_dokter_6', 'promotif_dokter_7', 'promotif_dokter_8', 'promotif_dokter_9',
        
        'metode_dokter_1', 'metode_dokter_2', 'metode_dokter_3', 'metode_dokter_4', 'metode_dokter_5',
        'metode_dokter_6', 'metode_dokter_7', 'metode_dokter_8', 'metode_dokter_9',
        
        'profesional_dokter_1', 'profesional_dokter_2', 'profesional_dokter_3', 'profesional_dokter_4', 'profesional_dokter_5',
        'profesional_dokter_6', 'profesional_dokter_7', 'profesional_dokter_8', 'profesional_dokter_9',
        
        'evaluasi_dokter_1', 'evaluasi_dokter_2', 'evaluasi_dokter_3', 'evaluasi_dokter_4', 'evaluasi_dokter_5',
        'evaluasi_dokter_6', 'evaluasi_dokter_7', 'evaluasi_dokter_8', 'evaluasi_dokter_9',
        
        'tanggal_dokter', 'waktu_dokter',
        'ttd_pemberi_dokter', 'ttd_penerima_dokter',
        
        // SECTION PERAWAT
        'edukasi_perawat1', 'edukasi_perawat2', 'edukasi_perawat3', 'edukasi_perawat4',
        'edukasi_perawat5', 'edukasi_perawat6',
        
        'promotif_perawat_1', 'promotif_perawat_2', 'promotif_perawat_3', 'promotif_perawat_4',
        'promotif_perawat_5', 'promotif_perawat_6', 'promotif_perawat_7',
        
        'metode_perawat_1', 'metode_perawat_2', 'metode_perawat_3', 'metode_perawat_4',
        'metode_perawat_5', 'metode_perawat_6', 'metode_perawat_7',
        
        'profesional_perawat_1', 'profesional_perawat_2', 'profesional_perawat_3', 'profesional_perawat_4',
        'profesional_perawat_5', 'profesional_perawat_6', 'profesional_perawat_7',
        
        'evaluasi_perawat_1', 'evaluasi_perawat_2', 'evaluasi_perawat_3', 'evaluasi_perawat_4',
        'evaluasi_perawat_5', 'evaluasi_perawat_6', 'evaluasi_perawat_7',
        
        'tanggal_perawat', 'waktu_perawat',
        'ttd_pemberi_perawat', 'ttd_penerima_perawat',
        
        // SECTION TAMBAHAN
        'edukasi_tambahan1', 'edukasi_tambahan2', 'edukasi_tambahan3', 'edukasi_tambahan4', 'edukasi_tambahan5',
        'edukasi_tambahan6', 'edukasi_tambahan7', 'edukasi_tambahan8', 'edukasi_tambahan9', 'edukasi_tambahan10',
        
        'promotif_tambahan1_1', 'promotif_tambahan1_2', 'promotif_tambahan1_3', 'promotif_tambahan1_4', 'promotif_tambahan1_5',
        'promotif_tambahan1_6', 'promotif_tambahan1_7', 'promotif_tambahan1_8', 'promotif_tambahan1_9',
        'promotif_tambahan1_10', 
        
        'metode_tambahan1_1', 'metode_tambahan1_2', 'metode_tambahan1_3', 'metode_tambahan1_4', 'metode_tambahan1_5',
        'metode_tambahan1_6', 'metode_tambahan1_7', 'metode_tambahan1_8', 'metode_tambahan1_9',
        'metode_tambahan1_10', 
        
        'profesional_tambahan1_1', 'profesional_tambahan1_2', 'profesional_tambahan1_3', 'profesional_tambahan1_4', 'profesional_tambahan1_5',
        'profesional_tambahan1_6', 'profesional_tambahan1_7', 'profesional_tambahan1_8', 'profesional_tambahan1_9',
        'profesional_tambahan1_10', 
        
        'evaluasi_tambahan1_1','evaluasi_tambahan1_2', 'evaluasi_tambahan1_3', 'evaluasi_tambahan1_4', 'evaluasi_tambahan1_5',
        'evaluasi_tambahan1_6', 'evaluasi_tambahan1_7', 'evaluasi_tambahan1_8', 'evaluasi_tambahan1_9',
        'evaluasi_tambahan1_10',

        'nama_pemberi_dokter',
        'nama_penerima_dokter',
        'nama_pemberi_perawat',
        'nama_penerima_perawat',
        'nama_pemberi_analis',
        'nama_penerima_analis',
        'nama_pemberi_gizi',
        'nama_penerima_gizi',
        'nama_pemberi_farmasi',
        'nama_penerima_farmasi',
        'nama_pemberi_fisio',
        'nama_penerima_fisio',
        
        // SECTION ANALIS/LAB
        'edukasi_analis',
        'promotif_analis', 'metode_analis', 'profesional_analis', 'evaluasi_analis',
        'tanggal_analis', 'waktu_analis',
        'ttd_pemberi_analis', 'ttd_penerima_analis',
        
        // SECTION AHLI GIZI
        'edukasi_gizi1', 'edukasi_gizi2',
        'promotif_gizi_1', 'promotif_gizi_2',
        'metode_gizi_1', 'metode_gizi_2',
        'profesional_gizi_1', 'profesional_gizi_2',
        'evaluasi_gizi_1', 'evaluasi_gizi_2',
        'tanggal_gizi', 'waktu_gizi',
        'ttd_pemberi_gizi', 'ttd_penerima_gizi',
        
        // SECTION FARMASI
        'edukasi_farmasi1', 'edukasi_farmasi2', 'edukasi_farmasi3', 'edukasi_terapi',
        'promotif_farmasi_1', 'promotif_farmasi_2', 'promotif_farmasi_3', 'promotif_farmasi_4',
        'metode_farmasi_1', 'metode_farmasi_2', 'metode_farmasi_3', 'metode_farmasi_4',
        'profesional_farmasi_1', 'profesional_farmasi_2', 'profesional_farmasi_3', 'profesional_farmasi_4',
        'evaluasi_farmasi_1', 'evaluasi_farmasi_2', 'evaluasi_farmasi_3', 'evaluasi_farmasi_4',
        'tanggal_farmasi', 'waktu_farmasi',
        'ttd_pemberi_farmasi', 'ttd_penerima_farmasi',
        
        // SECTION FISIOTERAPIS
        'edukasi_fisio1', 'edukasi_fisio2',
        'promotif_fisio_1', 'promotif_fisio_2',
        'metode_fisio_1', 'metode_fisio_2',
        'profesional_fisio_1', 'profesional_fisio_2',
        'evaluasi_fisio_1', 'evaluasi_fisio_2',
        'tanggal_fisio', 'waktu_fisio',
        'ttd_pemberi_fisio', 'ttd_penerima_fisio',
        
        'ttd_pengkaji',
        'nama_pengkaji',
        'tanggal_pengkaji',
        'waktu_pengkaji',
        
        'ttd_dokter_dpjp',
        'ttd_dokter',
        
        // Audit
        'created_by',
        'updated_by',
    ];

protected $casts = [
    // No date/datetime casts to prevent Carbon errors.
    // Handled manually in saving event.

    // Cast boolean/checkbox fields to integer (true -> 1, false -> 0) for SMALLINT columns
    'hambatan_bahasa' => 'integer', 'hambatan_emosi' => 'integer', 'hambatan_masalah_penglihatan' => 'integer',
    'hambatan_bicara_buruk' => 'integer', 'hambatan_cemas' => 'integer', 'hambatan_tidak_ada_partisipasi' => 'integer',
    'hambatan_kognitif' => 'integer', 'hambatan_motivasi' => 'integer', 'hambatan_fisiologi_tidak_mampu' => 'integer',
    'hambatan_pendengaran' => 'integer', 'hambatan_hilang_memori' => 'integer', 'hambatan_tidak_ditemukan' => 'integer',

    'metode_audio' => 'integer', 'metode_demonstrasi' => 'integer', 'metode_lisan' => 'integer',
    'metode_tulisan' => 'integer', 'metode_visual' => 'integer',

    'edukasi_tata_tertib_rs' => 'integer', 'edukasi_hak_kewajiban' => 'integer',
    'bicara_normal' => 'integer', 'bicara_gangguan' => 'integer',

    'bahasa_indonesia' => 'integer', 'bahasa_daerah' => 'integer', 'bahasa_inggris' => 'integer', 'bahasa_lainnya' => 'integer',
    'bahasa_isyarat_ya' => 'integer', 'bahasa_isyarat_tidak' => 'integer',

    'pendidikan_tk' => 'integer', 'pendidikan_sd' => 'integer', 'pendidikan_smp' => 'integer', 'pendidikan_sma' => 'integer',
    'pendidikan_diploma' => 'integer', 'pendidikan_sarjana' => 'integer', 'pendidikan_lainnya' => 'integer',

    'agama_islam' => 'integer', 'agama_protestan' => 'integer', 'agama_katolik' => 'integer',
    'agama_hindu' => 'integer', 'agama_budha' => 'integer', 'agama_lainnya' => 'integer',

    'pengetahuan_paham' => 'integer', 'pengetahuan_kurang_paham' => 'integer', 'pengetahuan_tidak_paham' => 'integer',

    'budaya_modern' => 'integer', 'budaya_moderat' => 'integer', 'budaya_konvensional' => 'integer',

    'merokok_ya' => 'integer', 'merokok_tidak' => 'integer',
    'alkohol_ya' => 'integer', 'alkohol_tidak' => 'integer',
    'menerima_info_ya' => 'integer', 'menerima_info_tidak' => 'integer',

    'rencana_proses_penyakit' => 'integer', 'rencana_pengobatan_tindakan' => 'integer',
    'rencana_nutrisi' => 'integer', 'rencana_edukasi_kolaboratif' => 'integer', 'rencana_lain_lain' => 'integer',

    'penerima_pasien' => 'integer', 'penerima_keluarga' => 'integer', 'penerima_lainnya' => 'integer',
    'frekuensi_edukasi_pertama' => 'integer', 'frekuensi_reedukasi' => 'integer',

    'evaluasi_tidak_mengerti' => 'integer', 'evaluasi_menyatakan_paham' => 'integer',
    'evaluasi_mampu_menjelaskan' => 'integer', 'evaluasi_mampu_demonstrasi' => 'integer',

    'privasi_ya' => 'integer', 'privasi_tidak' => 'integer',

    // SECTION DOKTER - edukasi tetap integer (checkbox), yang lain string (dropdown)
    'edukasi_dokter1' => 'integer', 'promotif_dokter_1' => 'string', 'metode_dokter_1' => 'string', 'profesional_dokter_1' => 'string', 'evaluasi_dokter_1' => 'string',
    'edukasi_dokter2' => 'integer', 'promotif_dokter_2' => 'string', 'metode_dokter_2' => 'string', 'profesional_dokter_2' => 'string', 'evaluasi_dokter_2' => 'string',
    'edukasi_dokter3' => 'integer', 'promotif_dokter_3' => 'string', 'metode_dokter_3' => 'string', 'profesional_dokter_3' => 'string', 'evaluasi_dokter_3' => 'string',
    'edukasi_dokter4' => 'integer', 'promotif_dokter_4' => 'string', 'metode_dokter_4' => 'string', 'profesional_dokter_4' => 'string', 'evaluasi_dokter_4' => 'string',
    'edukasi_dokter5' => 'integer', 'promotif_dokter_5' => 'string', 'metode_dokter_5' => 'string', 'profesional_dokter_5' => 'string', 'evaluasi_dokter_5' => 'string',
    'edukasi_dokter6' => 'integer', 'promotif_dokter_6' => 'string', 'metode_dokter_6' => 'string', 'profesional_dokter_6' => 'string', 'evaluasi_dokter_6' => 'string',
    'edukasi_dokter7' => 'integer', 'promotif_dokter_7' => 'string', 'metode_dokter_7' => 'string', 'profesional_dokter_7' => 'string', 'evaluasi_dokter_7' => 'string',
    'edukasi_dokter8' => 'integer', 'promotif_dokter_8' => 'string', 'metode_dokter_8' => 'string', 'profesional_dokter_8' => 'string', 'evaluasi_dokter_8' => 'string',
    'edukasi_dokter9' => 'integer', 'promotif_dokter_9' => 'string', 'metode_dokter_9' => 'string', 'profesional_dokter_9' => 'string', 'evaluasi_dokter_9' => 'string',

    // SECTION PERAWAT
    'edukasi_perawat1' => 'integer', 'promotif_perawat_1' => 'string', 'metode_perawat_1' => 'string', 'profesional_perawat_1' => 'string', 'evaluasi_perawat_1' => 'string',
    'edukasi_perawat2' => 'integer', 'promotif_perawat_2' => 'string', 'metode_perawat_2' => 'string', 'profesional_perawat_2' => 'string', 'evaluasi_perawat_2' => 'string',
    'edukasi_perawat3' => 'integer', 'promotif_perawat_3' => 'string', 'metode_perawat_3' => 'string', 'profesional_perawat_3' => 'string', 'evaluasi_perawat_3' => 'string',
    'edukasi_perawat4' => 'integer', 'promotif_perawat_4' => 'string', 'metode_perawat_4' => 'string', 'profesional_perawat_4' => 'string', 'evaluasi_perawat_4' => 'string',
    'edukasi_perawat5' => 'integer', 'promotif_perawat_5' => 'string', 'metode_perawat_5' => 'string', 'profesional_perawat_5' => 'string', 'evaluasi_perawat_5' => 'string',
    'edukasi_perawat6' => 'integer', 'promotif_perawat_6' => 'string', 'metode_perawat_6' => 'string', 'profesional_perawat_6' => 'string', 'evaluasi_perawat_6' => 'string',
    // 'edukasi_perawat7' => 'integer', 'promotif_perawat_7' => 'string', 'metode_perawat_7' => 'string', 'profesional_perawat_7' => 'string', 'evaluasi_perawat_7' => 'string',


    // SECTION TAMBAHAN
    'edukasi_tambahan1' => 'integer', 'promotif_tambahan1_1' => 'string', 'metode_tambahan1_1' => 'string', 'profesional_tambahan1_1' => 'string', 'evaluasi_tambahan1_1' => 'string',
    'edukasi_tambahan2' => 'integer', 'promotif_tambahan1_2' => 'string', 'metode_tambahan1_2' => 'string', 'profesional_tambahan1_2' => 'string', 'evaluasi_tambahan1_2' => 'string',
    'edukasi_tambahan3' => 'integer', 'promotif_tambahan1_3' => 'string', 'metode_tambahan1_3' => 'string', 'profesional_tambahan1_3' => 'string', 'evaluasi_tambahan1_3' => 'string',
    'edukasi_tambahan4' => 'integer', 'promotif_tambahan1_4' => 'string', 'metode_tambahan1_4' => 'string', 'profesional_tambahan1_4' => 'string', 'evaluasi_tambahan1_4' => 'string',
    'edukasi_tambahan5' => 'integer', 'promotif_tambahan1_5' => 'string', 'metode_tambahan1_5' => 'string', 'profesional_tambahan1_5' => 'string', 'evaluasi_tambahan1_5' => 'string',
    'edukasi_tambahan6' => 'integer', 'promotif_tambahan1_6' => 'string', 'metode_tambahan1_6' => 'string', 'profesional_tambahan1_6' => 'string', 'evaluasi_tambahan1_6' => 'string',
    'edukasi_tambahan7' => 'integer', 'promotif_tambahan1_7' => 'string', 'metode_tambahan1_7' => 'string', 'profesional_tambahan1_7' => 'string', 'evaluasi_tambahan1_7' => 'string',
    'edukasi_tambahan8' => 'integer', 'promotif_tambahan1_8' => 'string', 'metode_tambahan1_8' => 'string', 'profesional_tambahan1_8' => 'string', 'evaluasi_tambahan1_8' => 'string',
    'edukasi_tambahan9' => 'integer', 'promotif_tambahan1_9' => 'string', 'metode_tambahan1_9' => 'string', 'profesional_tambahan1_9' => 'string', 'evaluasi_tambahan1_9' => 'string',
    'edukasi_tambahan10' => 'integer', 'promotif_tambahan1_10' => 'string', 'metode_tambahan1_10' => 'string', 'profesional_tambahan1_10' => 'string', 'evaluasi_tambahan1_10' => 'string',
    // SECTION ANALIS/LAB
    'edukasi_analis' => 'integer', 'promotif_analis' => 'string', 'metode_analis' => 'string', 'profesional_analis' => 'string', 'evaluasi_analis' => 'string',

    // SECTION AHLI GIZI
    'edukasi_gizi1' => 'integer', 'promotif_gizi_1' => 'string', 'metode_gizi_1' => 'string', 'profesional_gizi_1' => 'string', 'evaluasi_gizi_1' => 'string',
    'edukasi_gizi2' => 'integer', 'promotif_gizi_2' => 'string', 'metode_gizi_2' => 'string', 'profesional_gizi_2' => 'string', 'evaluasi_gizi_2' => 'string',

    // SECTION FARMASI
    'edukasi_farmasi1' => 'integer', 'promotif_farmasi_1' => 'string', 'metode_farmasi_1' => 'string', 'profesional_farmasi_1' => 'string', 'evaluasi_farmasi_1' => 'string',
    'edukasi_farmasi2' => 'integer', 'promotif_farmasi_2' => 'string', 'metode_farmasi_2' => 'string', 'profesional_farmasi_2' => 'string', 'evaluasi_farmasi_2' => 'string',
    'edukasi_farmasi3' => 'integer', 'promotif_farmasi_3' => 'string', 'metode_farmasi_3' => 'string', 'profesional_farmasi_3' => 'string', 'evaluasi_farmasi_3' => 'string',
    'edukasi_terapi' => 'integer', 'promotif_farmasi_4' => 'string', 'metode_farmasi_4' => 'string', 'profesional_farmasi_4' => 'string', 'evaluasi_farmasi_4' => 'string',

    // SECTION FISIOTERAPIS
    'edukasi_fisio1' => 'integer', 'promotif_fisio_1' => 'string', 'metode_fisio_1' => 'string', 'profesional_fisio_1' => 'string', 'evaluasi_fisio_1' => 'string',
    'edukasi_fisio2' => 'integer', 'promotif_fisio_2' => 'string', 'metode_fisio_2' => 'string', 'profesional_fisio_2' => 'string', 'evaluasi_fisio_2' => 'string',
];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });

        static::saving(function ($model) {
            // Handle Jenis Kelamin Length Limit
            if (!empty($model->jenis_kelamin) && strlen($model->jenis_kelamin) > 1) {
                $model->jenis_kelamin = strtoupper(substr($model->jenis_kelamin, 0, 1));
            }

            // Handle Waktu Fields (Extract HH:mm from Timestamp or Truncate)
            foreach ($model->getAttributes() as $key => $value) {
                if (Str::startsWith($key, 'waktu')) {
                   if (is_string($value)) {
                       // If it has space, it might be "YYYY-MM-DD HH:mm:ss", take the time part
                       if (strpos($value, ' ') !== false) {
                           $parts = explode(' ', $value);
                           if (count($parts) > 1) {
                               // Take the second part (time) and ensure it's 5 chars
                               $model->{$key} = substr($parts[1], 0, 5); 
                           }
                       } elseif (strlen($value) > 5) {
                           // If just long string "20:00:00", take first 5
                            $model->{$key} = substr($value, 0, 5);
                       }
                   }
                   
                   // Final check: if the result is strange (like "2026-") because of bad parsing, kill it.
                   // A valid time usually has ":" at index 2 (HH:mm)
                   $currentVal = $model->{$key};
                   if (!empty($currentVal) && is_string($currentVal)) {
                        if (strlen($currentVal) < 5 || substr($currentVal, 2, 1) !== ':') {
                             $model->{$key} = null;
                        }
                   }

                   if (empty($value)) {
                        $model->{$key} = null;
                   }
                }
                
                // Handle Tanggal Fields (Set to NULL if invalid/incomplete like "2026-")
                if (Str::startsWith($key, 'tanggal')) {
                    if (empty($value) || (is_string($value) && strlen($value) < 10)) {
                        $model->{$key} = null;
                    }
                }
            }

            $casts = $model->getCasts();
            foreach ($model->getAttributes() as $key => $value) {
                // Check if the field is supposed to be an integer (based on our casts)
                if (isset($casts[$key]) && $casts[$key] === 'integer') {
                    if (is_bool($value)) {
                        $model->{$key} = $value ? 1 : 0;
                    } elseif (is_string($value)) {
                        // If it's a numeric string ("0", "1"), cast it
                        if (is_numeric($value)) {
                            $model->{$key} = (int) $value;
                        } else {
                            // If it's a non-numeric string (e.g. checkbox with value="Text"), 
                            // assume it means 'checked' -> 1.
                            // If it's empty string, assume 0.
                            $model->{$key} = empty($value) ? 0 : 1;
                        }
                    }
                }
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