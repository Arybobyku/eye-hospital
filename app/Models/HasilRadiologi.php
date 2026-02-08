<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class HasilRadiologi extends Model
{
    use HasFactory;
    protected $table = 'hasil_radiologi';
    protected $fillable = [
        'uuid',
        'pasien_uuid',
        'no_radiologi',
        'pasien_uuid',
        'pasien_nama',
        'register',
        'tanggal',
        'pemeriksaan',
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
        'tanggal' => 'string',
        'tanggal_upload' => 'string',
        'waktu_upload' => 'string',
    ];
    /**
     * Relasi ke Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_uuid', 'uuid');
    }
    /**
     * Relasi ke Dokter Pengirim
     */
    public function dokterPengirim()
    {
        return $this->belongsTo(Pengguna::class, 'dokter_pengirim_uuid', 'uuid');
    }
    /**
     * Relasi ke Pengguna (uploader)
     */
    public function uploader()
    {
        return $this->belongsTo(Pengguna::class, 'uploaded_by_uuid', 'uuid');
    }
    /**
     * Relasi ke Pengguna (verifier)
     */
    public function verifier()
    {
        return $this->belongsTo(Pengguna::class, 'verified_by_uuid', 'uuid');
    }
    /**
     * Scope untuk data yang tidak dihapus (soft delete)
     */
    public function scopeActive($query)
    {
        return $query->where('delete_soft', 0);
    }
    /**
     * Scope untuk data yang sudah diverifikasi
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    /**
     * Scope untuk data yang belum diverifikasi
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
    /**
     * Accessor untuk mendapatkan URL file
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalFormattedAttribute()
    {
        if ($this->tanggal) {
            return \Carbon\Carbon::parse($this->tanggal)->format('d-m-Y');
        }
        return null;
    }
    /**
     * Accessor untuk format datetime upload
     */
    public function getUploadedAtFormattedAttribute()
    {
        if ($this->tanggal_upload && $this->waktu_upload) {
            return $this->tanggal_upload . ' ' . $this->waktu_upload;
        }
        return null;
    }
}  