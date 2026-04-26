<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenResumeMedisRawatInap extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_resume_medis_rawat_inap';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Identitas Pasien
        'no_rm',
        'no_surat',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        
        // Informasi Rawat Inap
        'tanggal_masuk',
        'tanggal_keluar',
        'ruang_rawat',
        'penanggung_pembayaran',
        'dpjp',
        'rawat_tim',
        'tim_dokter_1',
        'tim_dokter_2',
        'tim_dokter_3',
        'tim_dokter_4',
        
        // Data Klinis
        'alasan_dirawat',
        'diagnosa_masuk',
        'diagnosa_keluar',
        'icd_utama',
        'diagnosa_sekunder_1',
        'diagnosa_sekunder_2',
        'diagnosa_sekunder_3',
        'diagnosa_sekunder_4',
        'penyebab_kematian',
        'pemeriksaan_fisik',
        'laboratorium',
        'radiologi',
        'penunjang_lain',
        'tindakan_operasi',
        'icd_tindakan',
        'pengobatan',
        
        // Kondisi Pulang
        'kondisi_sembuh',
        'kondisi_pindah_rs',
        'kondisi_pulang_sendiri',
        'kondisi_meninggal',
        'kondisi_lainnya',
        
        // Follow Up
        'kontrol_tanggal',
        'diet',
        'latihan',
        'kondisi_darurat',
        
        // Terapi Pulang (JSON)
        'terapi_pulang',
        
        // Tanda Tangan
        'dokter_ttd',
        'nama_dokter',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'kontrol_tanggal' => 'date',
        'tanggal_lahir' => 'date',
        
        // Kondisi Pulang sebagai boolean
        'kondisi_sembuh' => 'boolean',
        'kondisi_pindah_rs' => 'boolean',
        'kondisi_pulang_sendiri' => 'boolean',
        'kondisi_meninggal' => 'boolean',
        'kondisi_lainnya' => 'boolean',
        
        // Terapi Pulang sebagai JSON/Array
        'terapi_pulang' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->no_surat)) {
                $tahun = config('app.tahun_akreditasi', '22');
                $model->no_surat = "RM 3.5/RM/{$tahun}";
            }
        });
    }

    /**
     * Relasi ke Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalMasukFormattedAttribute()
    {
        return $this->tanggal_masuk ? $this->tanggal_masuk->format('d/m/Y') : null;
    }

    public function getTanggalKeluarFormattedAttribute()
    {
        return $this->tanggal_keluar ? $this->tanggal_keluar->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk mendapatkan lama rawat (hari)
     */
    public function getLamaRawatAttribute()
    {
        if ($this->tanggal_masuk && $this->tanggal_keluar) {
            return $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
        }
        return 0;
    }

    /**
     * Scope untuk filter berdasarkan ruang rawat
     */
    public function scopeByRuangRawat($query, $ruang)
    {
        return $query->where('ruang_rawat', $ruang);
    }

    /**
     * Scope untuk filter berdasarkan DPJP
     */
    public function scopeByDokter($query, $dpjp)
    {
        return $query->where('dpjp', 'like', "%{$dpjp}%");
    }

    /**
     * Scope untuk pasien yang meninggal
     */
    public function scopeMeninggal($query)
    {
        return $query->where('kondisi_meninggal', true);
    }

    /**
     * Scope untuk pasien yang pulang
     */
    public function scopePulang($query)
    {
        return $query->where('kondisi_sembuh', true)
                     ->orWhere('kondisi_pulang_sendiri', true)
                     ->orWhere('kondisi_pindah_rs', true);
    }
}