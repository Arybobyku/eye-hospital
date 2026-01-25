<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VoucherRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'voucher_rawat_inap';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'no_rm',
        'nama',
        'tanggal_lahir',
        'lantai_kamar',
        'jenis_kelamin',
        'nik',
        
        // ===== Informasi Dokter =====
        'nama_dokter',
        'admission_date',
        'discharge_date',
        
        // ===== Tabel Kunjungan Row 1 =====
        'row1_hari',
        'row1_tanggal_jam',
        'row1_paraf_dokter',
        'row1_nama_dokter',
        'row1_paraf_perawat',
        'row1_nama_perawat',
        
        // ===== Tabel Kunjungan Row 2 =====
        'row2_hari',
        'row2_tanggal_jam',
        'row2_paraf_dokter',
        'row2_nama_dokter',
        'row2_paraf_perawat',
        'row2_nama_perawat',
        
        // ===== Tabel Kunjungan Row 3 =====
        'row3_hari',
        'row3_tanggal_jam',
        'row3_paraf_dokter',
        'row3_nama_dokter',
        'row3_paraf_perawat',
        'row3_nama_perawat',
        
        // ===== Tabel Kunjungan Row 4 =====
        'row4_hari',
        'row4_tanggal_jam',
        'row4_paraf_dokter',
        'row4_nama_dokter',
        'row4_paraf_perawat',
        'row4_nama_perawat',
        
        // ===== Tabel Kunjungan Row 5 =====
        'row5_hari',
        'row5_tanggal_jam',
        'row5_paraf_dokter',
        'row5_nama_dokter',
        'row5_paraf_perawat',
        'row5_nama_perawat',
        
        // ===== Tabel Kunjungan Row 6 =====
        'row6_hari',
        'row6_tanggal_jam',
        'row6_paraf_dokter',
        'row6_nama_dokter',
        'row6_paraf_perawat',
        'row6_nama_perawat',
        
        // ===== Voucher Honor Profesi =====
        'perawatan_visite',
        
        // ===== Jenis Tarif Operasi =====
        'tarif_pribadi',
        'tarif_rumah_sakit',
        'tarif_perusahaan',
        'tarif_staff',
        
        // ===== Operasi =====
        'operasi_besar',
        'operasi_sedang',
        'operasi_kecil',
        
        // ===== Lainnya =====
        'anasthesi',
        'dokter_konsultan',
        
        // ===== Partus =====
        'partus_normal',
        'partus_vacuum',
        
        // ===== Tanda Tangan =====
        'date_voucher',
        'time_voucher',
        'dibuat_oleh',
        'ttd_dibuat_oleh',
        'nama_dokter_voucher',
        'ttd_dokter',
        
        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'admission_date' => 'date',
        'discharge_date' => 'date',
        'row1_tanggal_jam' => 'datetime',
        'row2_tanggal_jam' => 'datetime',
        'row3_tanggal_jam' => 'datetime',
        'row4_tanggal_jam' => 'datetime',
        'row5_tanggal_jam' => 'datetime',
        'row6_tanggal_jam' => 'datetime',
        'date_voucher' => 'date',
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