<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilLaboratorium extends Model
{
    use HasFactory;
    
    protected $table = 'hasil_laboratorium';
    
    protected $fillable = [
        'uuid',
        'no_periksa',
        'pasien_uuid',
        'pasien_nama',
        'register',
        'mr',
        'tgl_periksa',
        'jam_periksa',
        'layanan_dari',
        'dokter_pengirim_uuid',
        'dokter_pengirim',
        'nama_file',
        'file_path',
        'keterangan',
        'tanggal_upload',
        'waktu_upload',
        'uploaded_by_uuid',
        'uploaded_by_nama',
        'is_verified',
        'verified_by_uuid',
        'verified_by_nama',
        'verified_at',
        'delete_soft'
    ];
    
    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'tgl_periksa' => 'string',
        'jam_periksa' => 'string',
        'tanggal_upload' => 'string',
        'waktu_upload' => 'string',
    ];
    
    // Relasi
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_uuid', 'uuid');
    }
    
    public function dokterPengirim()
    {
        return $this->belongsTo(Pengguna::class, 'dokter_pengirim_uuid', 'uuid');
    }
    
    public function uploader()
    {
        return $this->belongsTo(Pengguna::class, 'uploaded_by_uuid', 'uuid');
    }
    
    public function verifier()
    {
        return $this->belongsTo(Pengguna::class, 'verified_by_uuid', 'uuid');
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('delete_soft', 0); // ✅ DIPERBAIKI
    }
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
    
    // Accessors
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
    
    public function getTglPeriksaFormattedAttribute()
    {
        if ($this->tgl_periksa) {
            return \Carbon\Carbon::parse($this->tgl_periksa)->format('d-m-Y');
        }
        return null;
    }
    
    public function getUploadedAtFormattedAttribute()
    {
        if ($this->tanggal_upload && $this->waktu_upload) {
            return $this->tanggal_upload . ' ' . $this->waktu_upload;
        }
        return null;
    }
    
    public function getPeriksaAtFormattedAttribute()
    {
        if ($this->tgl_periksa && $this->jam_periksa) {
            return $this->tgl_periksa . ' ' . $this->jam_periksa;
        }
        return null;
    }
}