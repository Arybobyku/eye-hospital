<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormReaksiTransfusiDarah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_reaksi_transfusi_darah';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // ===== Dokter & Jenis Rawat =====
        'dokter_pengirim',
        'jenis_rawat',
        'tanggal',
        
        // ===== Informasi Transfusi =====
        'instalansi',
        'tanggal_transfusi',
        'diagnosa_klinis',
        'produk_darah',
        'waktu_permintaan',
        'no_kantong',
        'vol_transfusi',
        
        // ===== Clerical Check =====
        'clerical_pasien_id',
        'clerical_bag_darah',
        'clerical_rekord_transfusi',
        'temperatur_24jam',
        
        // ===== Vital Sign - Pre Reaksi Alergi =====
        'pre_waktu',
        'pre_temperatur',
        'pre_hr',
        'pre_bp',
        'pre_pulse',
        
        // ===== Vital Sign - Waktu Terjadi Reaksi =====
        'reaksi_waktu',
        'reaksi_temperatur',
        'reaksi_hr',
        'reaksi_bp',
        'reaksi_pulse',
        
        // ===== Obat Premedikasi =====
        'obat_antipiretik',
        'obat_antihistamin',
        'obat_steroid',
        'obat_diuretik',
        
        // ===== Tanda dan Gejala =====
        'gejala_demam',
        'gejala_pusing',
        'gejala_kejang',
        'gejala_sesak_nafas',
        'gejala_menggigil',
        'gejala_sakit_kepala',
        'gejala_nyeri_dada',
        'gejala_gatal',
        'gejala_mual',
        'gejala_lower_back_pain',
        'gejala_bentol',
        'gejala_muntah',
        'gejala_lain_lain',
        'gejala_urine_gelap',
        'gejala_pendarahan',
        
        // ===== Pemberian Darah =====
        'pemberian_darah',
        
        // ===== Dokter Pengirim Info =====
        'dokter_nama',
        'dokter_telp',
        'dokter_tanggal',
        'ttd_dokter',
        
        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_lahir' => 'date',
        'tanggal_transfusi' => 'date',
        'dokter_tanggal' => 'date',
        
        // Cast integer untuk checkbox fields
        'obat_antipiretik' => 'integer',
        'obat_antihistamin' => 'integer',
        'obat_steroid' => 'integer',
        'obat_diuretik' => 'integer',
        
        'gejala_demam' => 'integer',
        'gejala_pusing' => 'integer',
        'gejala_kejang' => 'integer',
        'gejala_sesak_nafas' => 'integer',
        'gejala_menggigil' => 'integer',
        'gejala_sakit_kepala' => 'integer',
        'gejala_nyeri_dada' => 'integer',
        'gejala_gatal' => 'integer',
        'gejala_mual' => 'integer',
        'gejala_lower_back_pain' => 'integer',
        'gejala_bentol' => 'integer',
        'gejala_muntah' => 'integer',
        'gejala_lain_lain' => 'integer',
        'gejala_urine_gelap' => 'integer',
        'gejala_pendarahan' => 'integer',
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
     * Accessor untuk pemberian_darah (convert JSON ke array)
     */
    public function getPemberianDarahAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    /**
     * Mutator untuk pemberian_darah (convert array ke JSON)
     */
    public function setPemberianDarahAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['pemberian_darah'] = json_encode($value);
        } else if (is_string($value)) {
            $this->attributes['pemberian_darah'] = $value;
        } else {
            $this->attributes['pemberian_darah'] = json_encode([]);
        }
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
    
    /**
     * Scope untuk filter berdasarkan jenis rawat
     */
    public function scopeByJenisRawat($query, $jenisRawat)
    {
        return $query->where('jenis_rawat', $jenisRawat);
    }
    
    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByTanggal($query, $startDate, $endDate = null)
    {
        if ($endDate) {
            return $query->whereBetween('tanggal', [$startDate, $endDate]);
        }
        return $query->whereDate('tanggal', $startDate);
    }
}