<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenFormTransferPasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_form_transfer_pasien';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Data Transfer
        'tanggal_masuk',
        'tanggal_pindah',
        'asal_ruangan',
        'ruangan_selanjutnya',
        'dokter_yang_merawat',
        'dpjp',
        
        // Diagnosa
        'diagnosa_utama',
        'perlu_perhatian',
        'alergi',
        'mrsa',
        'diagnosa_sekunder_1',
        'diagnosa_sekunder_2',
        'diagnosa_sekunder_3',
        'diagnosa_sekunder_4',
        'diagnosa_sekunder_5',
        
        // Alasan Perpindahan
        'kondisi_pasien',
        'alasan_fasilitas',
        'alasan_tenaga',
        'alasan_lainnya',
        
        // Metode Perpindahan
        'metode_kursi_roda',
        'metode_tempat_tidur',
        'metode_brankar',
        
        // Persetujuan
        'pasien_keluarga_setuju',
        'nama_pemberi_persetujuan',
        'hubungan_pemberi_persetujuan',
        
        // Peralatan
        'peralatan_portable',
        'peralatan_alat_penghisap',
        'peralatan_bagging',
        'peralatan_ngt',
        'peralatan_ventilator',
        'peralatan_kateter_urin',
        'peralatan_pompa_infus',
        
        // Keadaan Pasien
        'keadaan_umum',
        'kesadaran',
        'status_nyeri',
        'td',
        'nadi',
        'suhu',
        'pernafasan',
        
        // Pendamping
        'nama_pendamping',
        
        // Disabilitas
        'disabilitas_amputasi',
        'disabilitas_kontraktur',
        'disabilitas_paralisis',
        'disabilitas_ulkus_dikubitus',
        'disabilitas_gangguan_mental',
        'disabilitas_bicara',
        'disabilitas_pendengaran',
        'disabilitas_penglihatan',
        'disabilitas_sensasi',
        
        // Inkontinensia
        'inkontinensia_urin',
        'inkontinensia_saliva',
        'inkontinensia_alvi',
        
        // Potensi Rehabilitasi
        'potensial_rehabilitasi',
        
        // Pemeriksaan Fisik
        'status_generalis',
        'status_lokalis',
        'pemeriksaan_penunjang',
        
        // Status Kemandirian
        'kemandirian_berguling',
        'kemandirian_duduk',
        'kemandirian_hygiene_wajah',
        'kemandirian_hygiene_tubuh',
        'kemandirian_hygiene_ekstremitas',
        'kemandirian_hygiene_mulut',
        'kemandirian_pakaian_atas',
        'kemandirian_pakaian_tubuh',
        'kemandirian_pakaian_bawah',
        'kemandirian_makan',
        'kemandirian_jalan',
        'kemandirian_kursi_roda',
        
        // Intervensi & Rencana
        'intervensi_tindakan',
        'diet',
        'rencana_perawatan',
        
        // Terapi Obat (JSON)
        'terapi_obat',
        
        // Tanda Tangan
        'ttd_dokter_pengirim',
        'nama_dokter_pengirim',
        'jam_dokter_pengirim',
        'tanggal_dokter_pengirim',
        
        'ttd_dokter_penerima',
        'nama_dokter_penerima',
        'jam_dokter_penerima',
        'tanggal_dokter_penerima',
        
        'ttd_perawat_pengantar',
        'nama_perawat_pengantar',
        
        'ttd_perawat_penerima',
        'nama_perawat_penerima',
        
        'ttd_keluarga',
        'nama_keluarga_ttd',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_pindah' => 'date',
        'tanggal_dokter_pengirim' => 'date',
        'tanggal_dokter_penerima' => 'date',
        
        'mrsa' => 'boolean',
        'pasien_keluarga_setuju' => 'boolean',
        
        'metode_kursi_roda' => 'boolean',
        'metode_tempat_tidur' => 'boolean',
        'metode_brankar' => 'boolean',
        
        'peralatan_portable' => 'boolean',
        'peralatan_alat_penghisap' => 'boolean',
        'peralatan_bagging' => 'boolean',
        'peralatan_ngt' => 'boolean',
        'peralatan_ventilator' => 'boolean',
        'peralatan_kateter_urin' => 'boolean',
        'peralatan_pompa_infus' => 'boolean',
        
        'disabilitas_amputasi' => 'boolean',
        'disabilitas_kontraktur' => 'boolean',
        'disabilitas_paralisis' => 'boolean',
        'disabilitas_ulkus_dikubitus' => 'boolean',
        'disabilitas_gangguan_mental' => 'boolean',
        'disabilitas_bicara' => 'boolean',
        'disabilitas_pendengaran' => 'boolean',
        'disabilitas_penglihatan' => 'boolean',
        'disabilitas_sensasi' => 'boolean',
        
        'inkontinensia_urin' => 'boolean',
        'inkontinensia_saliva' => 'boolean',
        'inkontinensia_alvi' => 'boolean',
        
        'nadi' => 'integer',
        'suhu' => 'decimal:1',
        'pernafasan' => 'integer',
        
        'terapi_obat' => 'array',
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