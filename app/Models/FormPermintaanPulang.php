<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormPermintaanPulang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_permintaan_pulang';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        'no_rm',
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan',
        'alamat',
        'alasan',
        'tanggal',
        'ttd_keluarga',
        'nama_keluarga_ttd',
        'ttd_dpjp',
        'nama_dpjp_ttd',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'id',
    ];

    // Tambahkan appends untuk accessor yang digunakan di print
    protected $appends = [
        'formatted_tanggal_lahir',
        'formatted_tanggal',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
            if (auth()->check()) {
                $model->created_by = auth()->user()->name ?? auth()->user()->username;
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->user()->name ?? auth()->user()->username;
            }
        });
    }

    // Relationship dengan tabel pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    // Accessor untuk format tanggal lahir Indonesia
    public function getFormattedTanggalLahirAttribute()
    {
        if (!$this->tanggal_lahir) return null;
        
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $date = is_string($this->tanggal_lahir) ? \Carbon\Carbon::parse($this->tanggal_lahir) : $this->tanggal_lahir;
        return $date->format('d') . ' ' . $months[(int)$date->format('m')] . ' ' . $date->format('Y');
    }

    // Accessor untuk format tanggal formulir
    public function getFormattedTanggalAttribute()
    {
        if (!$this->tanggal) return null;
        
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $date = is_string($this->tanggal) ? \Carbon\Carbon::parse($this->tanggal) : $this->tanggal;
        return $date->format('d') . ' ' . $months[(int)$date->format('m')] . ' ' . $date->format('Y');
    }

    // Scope untuk filter berdasarkan pasien
    public function scopeByPasien($query, $uuidPasien)
    {
        return $query->where('uuid_pasien', $uuidPasien);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    // Scope untuk filter berdasarkan jenis kelamin
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('no_rm', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%");
        });
    }
}