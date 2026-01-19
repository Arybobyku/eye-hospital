<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenLaporanPembedahan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_laporan_pembedahan';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Data Operasi
        'ruang_operasi',
        'kamar',
        'tanggal',
        'akut_terencana',
        
        // Tim Bedah
        'pembedahan',
        'ahli_anestesi',
        'asisten_1',
        'asisten_2',
        'perawat_instrument',
        
        // Jenis Anestesi
        'anestesi_umum',
        'anestesi_bsp',
        'anestesi_spinal',
        'anestesi_csp',
        'anestesi_epidural',
        'anestesi_lokal',
        
        // Diagnosa dan Operasi
        'diagnosa_pra_bedah',
        'indikasi_operasi',
        'diagnosa_pasca_bedah',
        'jenis_operasi',
        
        // Detail Operasi
        'desinfeksi_kulit',
        'posisi_penderita',
        'macam_sayatan',
        
        // Waktu Operasi
        'jam_operasi_mulai',
        'jam_operasi_selesai',
        'lama_operasi',
        
        // Bahan Laboratorium
        'jenis_bahan_lab',
        'pemeriksaan_lab',
        
        // Teknik Operasi
        'teknik_operasi_temuan',
        
        // AMHP Khusus
        'amhp_khusus',
        'jenis_jumlah_amhp',
        
        // Komplikasi
        'komplikasi_intra_operasi',
        'penjabaran_komplikasi',
        'perdarahan',
        
        // Instruksi
        'instruksi_anestesi',
        'instruksi_kontrol',
        'instruksi_puasa',
        'instruksi_drain',
        'instruksi_infus',
        'instruksi_obat',
        'instruksi_ganti_balut',
        'instruksi_lainnya',
        
        // Tanda Tangan
        'ttd_operator',
        'nama_operator_ttd',
        'tanggal_ttd_operator',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'tanggal_ttd_operator' => 'date',
        
        'lama_operasi' => 'integer',
        'perdarahan' => 'decimal:2',
        
        // Jenis Anestesi (Boolean)
        'anestesi_umum' => 'boolean',
        'anestesi_bsp' => 'boolean',
        'anestesi_spinal' => 'boolean',
        'anestesi_csp' => 'boolean',
        'anestesi_epidural' => 'boolean',
        'anestesi_lokal' => 'boolean',
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