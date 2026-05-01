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
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'ruang_operasi',
        'kamar',
        'tanggal_operasi',
        'jenis_operasi',
        'pembedahan',
        'ahli_anestesi',
        'asisten_1',
        'asisten_2',
        'perawat_instrument',
        'anestesi_umum',
        'anestesi_spiral',
        'anestesi_epidural',
        'anestesi_bsp',
        'anestesi_csp',
        'anestesi_lokal',
        'diagnosa_pra_bedah',
        'indikasi_operasi',
        'diagnosa_pasca_bedah',
        'jenis_operasi_detail',
        'desinfeksi_kulit',
        'jam_mulai',
        'jam_selesai',
        'lama_operasi',
        'macam_sayatan',
        'posisi_penderita',
        'macam_sayatan_teks',      // Teks deskripsi sayatan
        'macam_sayatan_gambar',    // Base64 gambar sayatan
        'posisi_penderita_teks',   // Teks deskripsi posisi
        'posisi_penderita_gambar',
        'teknik_operasi',
        'teknik_operasi_files',
        'jenis_bahan_lab',
        'pemeriksaan_lab',
        'penggunaan_amhp',
        'jenis_amhp',
        'komplikasi',
        'penjabaran_komplikasi',
        'perdarahan',
        'instruksi_anestesi',
        'instruksi_kontrol',
        'instruksi_puasa',
        'instruksi_drain',
        'instruksi_infus',
        'instruksi_obat',
        'instruksi_ganti_balut',
        'instruksi_lainnya',
        'tanggal_ttd',
        'nama_operator',
        'operator_bedah_ttd',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_operasi' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'tanggal_ttd' => 'date',
        'anestesi_umum' => 'boolean',
        'anestesi_spiral' => 'boolean',
        'anestesi_epidural' => 'boolean',
        'anestesi_bsp' => 'boolean',
        'anestesi_csp' => 'boolean',
        'anestesi_lokal' => 'boolean',
        'lama_operasi' => 'integer',
        'perdarahan' => 'integer',
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

    // Accessor untuk menampilkan jenis anestesi yang dipilih
    public function getJenisAnestesiAttribute()
    {
        $jenis = [];
        if ($this->anestesi_umum) $jenis[] = 'Umum';
        if ($this->anestesi_spiral) $jenis[] = 'Spiral';
        if ($this->anestesi_epidural) $jenis[] = 'Epidural';
        if ($this->anestesi_bsp) $jenis[] = 'BSP';
        if ($this->anestesi_csp) $jenis[] = 'CSP';
        if ($this->anestesi_lokal) $jenis[] = 'Lokal';

        return implode(', ', $jenis);
    }

    // ✨ Accessor untuk gambar sayatan (backward compatible)
    public function getMacamSayatanGambarAttribute($value)
    {
        // Jika ada di field baru, gunakan itu
        // Jika tidak, fallback ke field lama
        return $value ?? $this->attributes['macam_sayatan'] ?? null;
    }

    // ✨ Accessor untuk posisi penderita (backward compatible)
    public function getPosisiPenderitaGambarAttribute($value)
    {
        return $value ?? $this->attributes['posisi_penderita'] ?? null;
    }

    // ✨ Accessor untuk generate full URL file
    public function getTeknikOperasiFilesUrlAttribute()
    {
        $files = $this->teknik_operasi_files;

        if (!$files || !is_array($files)) {
            return [];
        }

        return array_map(function ($file) {
            if (isset($file['path'])) {
                $file['url'] = asset('storage/' . $file['path']);
            }
            return $file;
        }, $files);
    }


}
