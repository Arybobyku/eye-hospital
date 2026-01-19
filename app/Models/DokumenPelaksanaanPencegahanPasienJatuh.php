<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenPelaksanaanPencegahanPasienJatuh extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_pelaksanaan_pencegahan_pasien_jatuh';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Data Pasien
        'no_rm',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Data Pelaksanaan
        'tanggal_pelaksanaan',
        'keterangan',
        
        // Tindakan Berisiko Jatuh
        'catatan_berisiko_jatuh',
        
        // Risiko Jatuh Rendah (Intervensi Standar)
        'rendah_benda_pribadi',
        'rendah_roda_terkunci',
        'rendah_posisi_rendah',
        'rendah_pagar_pengaman',
        'rendah_monitor_berkala',
        'rendah_edukasi',
        'rendah_pintu_lampu',
        'rendah_alat_bantu',
        'rendah_alas_kaki',
        
        // Risiko Jatuh Tinggi (Intervensi Tinggi)
        'tinggi_semua_standar',
        'tinggi_gelang_kuning',
        'tinggi_tanda_pintu',
        'tinggi_dekat_nurse',
        'tinggi_kunjungi_1jam',
        'tinggi_edukasi_obat',
        'tinggi_dampingi_kamar_mandi',
        'tinggi_tempat_duduk',
        'tinggi_bel_toilet',
        'tinggi_komunikasi_shift',
        
        // Tanda Tangan
        'ttd_petugas',
        'nama_petugas_ttd',
        
        // Audit trail
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pelaksanaan' => 'date',
        
        // Risiko Rendah
        'rendah_benda_pribadi' => 'boolean',
        'rendah_roda_terkunci' => 'boolean',
        'rendah_posisi_rendah' => 'boolean',
        'rendah_pagar_pengaman' => 'boolean',
        'rendah_monitor_berkala' => 'boolean',
        'rendah_edukasi' => 'boolean',
        'rendah_pintu_lampu' => 'boolean',
        'rendah_alat_bantu' => 'boolean',
        'rendah_alas_kaki' => 'boolean',
        
        // Risiko Tinggi
        'tinggi_semua_standar' => 'boolean',
        'tinggi_gelang_kuning' => 'boolean',
        'tinggi_tanda_pintu' => 'boolean',
        'tinggi_dekat_nurse' => 'boolean',
        'tinggi_kunjungi_1jam' => 'boolean',
        'tinggi_edukasi_obat' => 'boolean',
        'tinggi_dampingi_kamar_mandi' => 'boolean',
        'tinggi_tempat_duduk' => 'boolean',
        'tinggi_bel_toilet' => 'boolean',
        'tinggi_komunikasi_shift' => 'boolean',
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