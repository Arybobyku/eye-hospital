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
        'no_surat',
        'nama',
        'tanggal_lahir',
        'lantai_kamar',
        'jenis_kelamin',
        'nik',
        
        // ===== Informasi Dokter =====
        'nama_dokter',
        'admission_date',
        'discharge_date',
        
        // ===== Tabel Kunjungan (JSON) =====
        'tabel_kunjungan',
        
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
        'date_voucher' => 'date',
        'tabel_kunjungan' => 'array', // ✅ Cast ke array otomatis
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

    /**
     * Accessor untuk memastikan tabel_kunjungan selalu array
     */
    public function getTabelKunjunganAttribute($value)
    {
        if (is_null($value) || $value === '') {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    /**
     * Mutator untuk memastikan tabel_kunjungan tersimpan sebagai JSON
     */
    public function setTabelKunjunganAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['tabel_kunjungan'] = json_encode($value);
        } elseif (is_string($value)) {
            // Validasi apakah string sudah valid JSON
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['tabel_kunjungan'] = $value;
            } else {
                $this->attributes['tabel_kunjungan'] = json_encode([]);
            }
        } else {
            $this->attributes['tabel_kunjungan'] = json_encode([]);
        }
    }
}