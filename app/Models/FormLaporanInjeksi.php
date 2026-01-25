<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormLaporanInjeksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_laporan_injeksi';

    protected $fillable = [
        // Primary Key & Identifier
        'uuid',
        'uuid_pasien',
        
        // Data Default Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // Tanggal Operasi
        'tanggal_operasi',
        
        // Informasi Operasi
        'mata_od',
        'mata_os',
        'operator',
        'jam_operasi',
        'lama_operasi',
        'diagnosis',
        'asisten',
        'jenis_operasi',
        'anesthesia',
        'anesthesiologist',
        
        // Prosedur Operasi - Radio Options
        'jenis_anestesi',
        'alat_ukur',
        'jarak_ukur',
        'kuadran',
        'jenis_injeksi',
        'jumlah_injeksi',
        
        // Tanda Tangan
        'ttd_dokter',
        'nama_dokter',
        
        // Audit Trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_operasi' => 'date',
        'jam_operasi' => 'datetime:H:i',
        'mata_od' => 'boolean',
        'mata_os' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'tanggal_operasi',
        'created_at',
        'updated_at',
        'deleted_at',
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
     * Accessor untuk format tanggal operasi Indonesia
     */
    public function getTanggalOperasiFormatAttribute()
    {
        return $this->tanggal_operasi ? $this->tanggal_operasi->format('d-m-Y') : null;
    }

    /**
     * Accessor untuk jam operasi format 24 jam
     */
    public function getJamOperasiFormatAttribute()
    {
        return $this->jam_operasi ? date('H:i', strtotime($this->jam_operasi)) : null;
    }

    /**
     * Scope untuk filter berdasarkan pasien
     */
    public function scopeByPasien($query, $uuidPasien)
    {
        return $query->where('uuid_pasien', $uuidPasien);
    }

    /**
     * Scope untuk filter berdasarkan tanggal operasi
     */
    public function scopeByTanggalOperasi($query, $tanggal)
    {
        return $query->whereDate('tanggal_operasi', $tanggal);
    }

    /**
     * Scope untuk filter berdasarkan operator
     */
    public function scopeByOperator($query, $operator)
    {
        return $query->where('operator', 'like', '%' . $operator . '%');
    }

    /**
     * Get mata yang dioperasi (OD/OS/Both)
     */
    public function getMataOperasiAttribute()
    {
        if ($this->mata_od && $this->mata_os) {
            return 'OD & OS (Kedua Mata)';
        } elseif ($this->mata_od) {
            return 'OD (Mata Kanan)';
        } elseif ($this->mata_os) {
            return 'OS (Mata Kiri)';
        }
        return '-';
    }

    /**
     * Get jenis anestesi label
     */
    public function getJenisAnestesiLabelAttribute()
    {
        $labels = [
            'topical' => 'Topical',
            'local' => 'Local',
            'umum' => 'Umum'
        ];
        return $labels[$this->jenis_anestesi] ?? '-';
    }

    /**
     * Get alat ukur label
     */
    public function getAlatUkurLabelAttribute()
    {
        $labels = [
            'caliper' => 'Caliper',
            'trocar' => 'Trocar'
        ];
        return $labels[$this->alat_ukur] ?? '-';
    }

    /**
     * Get jenis injeksi label
     */
    public function getJenisInjeksiLabelAttribute()
    {
        $labels = [
            'avastin' => 'Avastin',
            'intravitreal' => 'Intravitreal'
        ];
        return $labels[$this->jenis_injeksi] ?? '-';
    }
}