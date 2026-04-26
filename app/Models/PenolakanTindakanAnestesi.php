<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PenolakanTindakanAnestesi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penolakan_tindakan_anestesi';

    protected $fillable = [
        // ===== Identitas =====
        'uuid',
        'uuid_pasien',
        
        // ===== Data Pasien =====
        'jenis_form',
        'no_rm',
        'no_surat',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        
        // ===== Pemberian Informasi Tindakan Pembiusan =====
        'dokter_pelaksana',
        'perawat_asisten',
        'penerima_informasi',
        
        // ===== Diagnosis (WD & DD) =====
        'status_fisik_asa',
        
        // ===== Dasar Diagnosis =====
        'klinis',
        'radiologi',
        'ekg',
        'laboratorium',
        
        // ===== Tindakan Kedokteran - Anestesi Umum =====
        'umum_intubasi',
        'umum_lma',
        'umum_fm',
        'umum_tiva',
        
        // ===== Tindakan Kedokteran - Anestesi Regional =====
        'regional_spinal1',
        'regional_spinal2',
        'regional_blok_perifer',
        
        'indikasi_tindakan',
        'tata_cara_tindakan',
        
        // ===== Risiko =====
        'shock',
        'henti_jantung',
        'meninggal_dunia',
        
        // ===== Komplikasi Anestesi Umum =====
        'anestesi_umum_pernafasan',
        'anestesi_umum_jantung',
        'anestesi_umum_saraf',
        'anestesi_umum_intubasi',
        'anestesi_umum_suhu',
        'anestesi_umum_obat',
        'anestesi_umum_posisi',
        'posisi_cedera_mata',
        'posisi_cedera_saraf',
        'posisi_cedera_kulit',
        
        // ===== Komplikasi Anestesi Regional =====
        'anestesi_regional_komplikasi_segera',
        'komplikasi_penurunan_tekanan',
        'komplikasi_anestesi_spinal',
        'komplikasi_reaksi_toksik',
        'komplikasi_reaksi_alergi',
        'anestesi_regional_komplikasi_lanjutan',
        'anestesi_regional_nyeri_kepala',
        'anestesi_regional_nyeri_punggung',
        'anestesi_regional_infeksi',
        'anestesi_regional_tidak_bisa_berkemih',
        'anestesi_regional_cedera_saraf',
        'anestesi_regional_pendarahan',
        
        'prognosis',
        'alternatif_tindakan',
        'lain_lain',
        
        // ===== Data Pernyataan Penolakan =====
        'pernyataan_nama',
        'pernyataan_tanggal_lahir',
        'pernyataan_jenis_kelamin',
        'pernyataan_alamat',
        'pernyataan_hubungan',
        'pernyataan_nama_pasien',
        'pernyataan_tanggal_lahir_pasien',
        'pernyataan_jenis_kelamin_pasien',
        'pernyataan_alamat_pasien',
        'pernyataan_tanggal',
        'pernyataan_waktu',
        
        // ===== Tanggal & Waktu =====
        'tanggal',
        'waktu',
        
        // ===== Tanda Tangan Pemberian Informasi =====
        'ttd_dokter',
        'nama_dokter_ttd',
        'tanggal_dokter',
        'waktu_dokter',
        'ttd_pasien',
        'nama_pasien_ttd',
        'tanggal_pasien',
        'waktu_pasien',
        
        // ===== Tanda Tangan Persetujuan Tindakan Kedokteran =====
        'ttd_pasien_pernyataan',
        'nama_pasien_pernyataan',
        'ttd_dokter_persetujuan',
        'nama_dokter_persetujuan',
        
        // ===== Saksi =====
        'ttd_keluarga',
        'nama_keluarga_ttd',
        'ttd_perawat',
        'nama_perawat_ttd',
        
        'tandai_diagnosis',
        'tandai_dasar_diagnosis',
        'tandai_tindakan_kedokteran',
        'tandai_indikasi_tindakan',
        'tandai_tata_cara_tindakan',
        'tandai_risiko',
        'tandai_komplikasi',
        'tandai_prognosis',
        'tandai_alternatif_tindakan',
        'tandai_lain_lain',
        
        // ===== Audit =====
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'date',
        'waktu' => 'datetime',
        'pernyataan_tanggal_lahir' => 'date',
        'pernyataan_tanggal_lahir_pasien' => 'date',
        'pernyataan_tanggal' => 'date',
        'pernyataan_waktu' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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
            $model->no_surat = $model->jenis_form === 'penolakan' 
                ? "RM 4.2/PTA/{$tahun}" 
                : "RM 4.3/PTA/{$tahun}";
        }
        });
    
        static::updating(function ($model) {
        if ($model->isDirty('jenis_form')) {
            $tahun = config('app.tahun_akreditasi', '22');
            $model->no_surat = $model->jenis_form === 'penolakan'
                ? "RM 4.2/PTA/{$tahun}"
                : "RM 4.3/PTA/{$tahun}";
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
     * Scope untuk mencari berdasarkan UUID
     */
    public function scopeFindByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * Scope untuk mencari berdasarkan UUID Pasien
     */
    public function scopeByPasien($query, $uuidPasien)
    {
        return $query->where('uuid_pasien', $uuidPasien);
    }

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk format waktu
     */
    public function getWaktuFormattedAttribute()
    {
        return $this->waktu ? $this->waktu->format('H:i') : null;
    }
}