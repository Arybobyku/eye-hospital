<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenChecklistKeselamatanPasienOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_checklist_keselamatan_pasien_operasi';

    protected $fillable = [
        'uuid',
        'uuid_pasien',
        
        // Identitas Pasien
        'no_rm',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        
        // SIGN IN - Sebelum Induksi Anestesi
        'signin_waktu',
        'signin_q1',
        'signin_q2',
        'signin_q3',
        'signin_q4',
        'signin_q5',
        'signin_q6',
        'signin_q7',
        'signin_ttd_dr_anestesi',
        'signin_nama_dr_anestesi',
        'signin_ttd_perawat_anestesi',
        'signin_nama_perawat_anestesi',
        'signin_ttd_perawat',
        'signin_nama_perawat',
        
        // TIME OUT - Sebelum Insisi
        'timeout_waktu',
        'timeout_q1',
        'timeout_q2',
        'timeout_q3',
        'timeout_q4_tindakan_beresiko',
        'timeout_q4_lama_tindakan',
        'timeout_q4_antisipasi_perdarahan',
        'timeout_q5',
        'timeout_q6_kesterilan',
        'timeout_q6_implan',
        'timeout_q6_masalah_alat',
        'timeout_q6_radiologi',
        'timeout_ttd_dr_anestesi',
        'timeout_nama_dr_anestesi',
        'timeout_ttd_perawat_anestesi',
        'timeout_nama_perawat_anestesi',
        'timeout_ttd_perawat_sirkuler',
        'timeout_nama_perawat_sirkuler',
        
        // SIGN OUT - Sebelum Pasien Meninggalkan Kamar Operasi
        'signout_waktu',
        'signout_q1',
        'signout_q2',
        'signout_q3',
        'signout_q4',
        'signout_q5',
        'signout_ttd_dr_bedah',
        'signout_nama_dr_bedah',
        'signout_ttd_dr_anestesi',
        'signout_nama_dr_anestesi',
        'signout_ttd_perawat_anestesi',
        'signout_nama_perawat_anestesi',
        'signout_ttd_perawat_instrument',
        'signout_nama_perawat_instrument',
        'signout_ttd_perawat_sirkuler',
        'signout_nama_perawat_sirkuler',
        
        'tanggal_ttd',
        
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_ttd' => 'date',
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
     * Relasi ke Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalTtdFormattedAttribute()
    {
        return $this->tanggal_ttd ? $this->tanggal_ttd->format('d/m/Y') : null;
    }

    /**
     * Accessor untuk durasi total operasi (dari sign in ke sign out)
     */
    public function getDurasiOperasiAttribute()
    {
        if (!$this->signin_waktu || !$this->signout_waktu) {
            return null;
        }

        try {
            $signin = \Carbon\Carbon::parse($this->signin_waktu);
            $signout = \Carbon\Carbon::parse($this->signout_waktu);
            
            $diffInMinutes = $signin->diffInMinutes($signout);
            
            $jam = floor($diffInMinutes / 60);
            $menit = $diffInMinutes % 60;
            
            if ($jam == 0 && $menit == 0) {
                return '-';
            }
            
            $result = [];
            if ($jam > 0) {
                $result[] = $jam . ' jam';
            }
            if ($menit > 0) {
                $result[] = $menit . ' menit';
            }
            
            return implode(' ', $result);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Accessor untuk status kelengkapan Sign In
     */
    public function getSigninCompletedAttribute()
    {
        $questions = [
            $this->signin_q1,
            $this->signin_q2,
            $this->signin_q3,
            $this->signin_q4,
            $this->signin_q5,
            $this->signin_q6,
            $this->signin_q7,
        ];

        $signatures = [
            $this->signin_ttd_dr_anestesi,
            $this->signin_ttd_perawat_anestesi,
            $this->signin_ttd_perawat,
        ];

        $questionsAnswered = count(array_filter($questions, fn($q) => !empty($q)));
        $signaturesSigned = count(array_filter($signatures, fn($s) => !empty($s)));

        return $questionsAnswered === 7 && $signaturesSigned === 3;
    }

    /**
     * Accessor untuk status kelengkapan Time Out
     */
    public function getTimeoutCompletedAttribute()
    {
        $questions = [
            $this->timeout_q1,
            $this->timeout_q2,
            $this->timeout_q3,
            $this->timeout_q4_antisipasi_perdarahan,
            $this->timeout_q5,
            $this->timeout_q6_kesterilan,
            $this->timeout_q6_implan,
            $this->timeout_q6_masalah_alat,
            $this->timeout_q6_radiologi,
        ];

        $signatures = [
            $this->timeout_ttd_dr_anestesi,
            $this->timeout_ttd_perawat_anestesi,
            $this->timeout_ttd_perawat_sirkuler,
        ];

        $questionsAnswered = count(array_filter($questions, fn($q) => !empty($q)));
        $signaturesSigned = count(array_filter($signatures, fn($s) => !empty($s)));

        return $questionsAnswered === 9 && $signaturesSigned === 3;
    }

    /**
     * Accessor untuk status kelengkapan Sign Out
     */
    public function getSignoutCompletedAttribute()
    {
        $questions = [
            $this->signout_q1,
            $this->signout_q2,
            $this->signout_q3,
            $this->signout_q4,
            $this->signout_q5,
        ];

        $signatures = [
            $this->signout_ttd_dr_bedah,
            $this->signout_ttd_dr_anestesi,
            $this->signout_ttd_perawat_anestesi,
            $this->signout_ttd_perawat_instrument,
            $this->signout_ttd_perawat_sirkuler,
        ];

        $questionsAnswered = count(array_filter($questions, fn($q) => !empty($q)));
        $signaturesSigned = count(array_filter($signatures, fn($s) => !empty($s)));

        return $questionsAnswered === 5 && $signaturesSigned === 5;
    }

    /**
     * Accessor untuk status kelengkapan keseluruhan checklist
     */
    public function getChecklistCompletedAttribute()
    {
        return $this->signin_completed && $this->timeout_completed && $this->signout_completed;
    }

    /**
     * Accessor untuk persentase kelengkapan checklist
     */
    public function getCompletionPercentageAttribute()
    {
        $totalQuestions = 7 + 9 + 5; // Total 21 pertanyaan
        $totalSignatures = 3 + 3 + 5; // Total 11 tanda tangan
        $totalItems = $totalQuestions + $totalSignatures; // 32 items

        $completedQuestions = 0;
        $completedSignatures = 0;

        // Sign In Questions
        $signinQuestions = [
            $this->signin_q1, $this->signin_q2, $this->signin_q3, $this->signin_q4,
            $this->signin_q5, $this->signin_q6, $this->signin_q7,
        ];
        $completedQuestions += count(array_filter($signinQuestions, fn($q) => !empty($q)));

        // Time Out Questions
        $timeoutQuestions = [
            $this->timeout_q1, $this->timeout_q2, $this->timeout_q3,
            $this->timeout_q4_antisipasi_perdarahan, $this->timeout_q5,
            $this->timeout_q6_kesterilan, $this->timeout_q6_implan,
            $this->timeout_q6_masalah_alat, $this->timeout_q6_radiologi,
        ];
        $completedQuestions += count(array_filter($timeoutQuestions, fn($q) => !empty($q)));

        // Sign Out Questions
        $signoutQuestions = [
            $this->signout_q1, $this->signout_q2, $this->signout_q3,
            $this->signout_q4, $this->signout_q5,
        ];
        $completedQuestions += count(array_filter($signoutQuestions, fn($q) => !empty($q)));

        // All Signatures
        $allSignatures = [
            $this->signin_ttd_dr_anestesi, $this->signin_ttd_perawat_anestesi, $this->signin_ttd_perawat,
            $this->timeout_ttd_dr_anestesi, $this->timeout_ttd_perawat_anestesi, $this->timeout_ttd_perawat_sirkuler,
            $this->signout_ttd_dr_bedah, $this->signout_ttd_dr_anestesi, $this->signout_ttd_perawat_anestesi,
            $this->signout_ttd_perawat_instrument, $this->signout_ttd_perawat_sirkuler,
        ];
        $completedSignatures = count(array_filter($allSignatures, fn($s) => !empty($s)));

        $completedItems = $completedQuestions + $completedSignatures;

        return round(($completedItems / $totalItems) * 100, 2);
    }

    /**
     * Accessor untuk mendapatkan masalah/risiko yang teridentifikasi
     */
    public function getRisikoTeridentifikasiAttribute()
    {
        $risiko = [];

        // Sign In - Alergi
        if ($this->signin_q5 === 'ya') {
            $risiko[] = 'Pasien memiliki riwayat alergi';
        }

        // Sign In - Gangguan pernafasan
        if ($this->signin_q6 === 'ya_tersedia') {
            $risiko[] = 'Pasien memiliki gangguan pernafasan';
        }

        // Sign In - Risiko perdarahan
        if ($this->signin_q7 === 'ya_direncanakan') {
            $risiko[] = 'Risiko perdarahan tinggi (>500ml)';
        }

        // Sign In - Mesin anestesi tidak lengkap
        if ($this->signin_q3 === 'tidak') {
            $risiko[] = 'Mesin anestesi dan obat-obatan tidak lengkap';
        }

        // Time Out - Tindakan beresiko
        if (!empty($this->timeout_q4_tindakan_beresiko)) {
            $risiko[] = 'Tindakan beresiko: ' . $this->timeout_q4_tindakan_beresiko;
        }

        // Time Out - Ada hal khusus untuk pasien
        if ($this->timeout_q5 === 'ya') {
            $risiko[] = 'Ada hal khusus untuk pasien (menurut Dokter Anestesi)';
        }

        // Time Out - Masalah peralatan
        if ($this->timeout_q6_masalah_alat === 'ya') {
            $risiko[] = 'Ada masalah dengan peralatan';
        }

        // Sign Out - Alat tidak lengkap
        if ($this->signout_q2 === 'tidak') {
            $risiko[] = 'Kelengkapan alat, kasa, dan jarum tidak lengkap';
        }

        // Sign Out - Masalah peralatan
        if ($this->signout_q4 === 'ya') {
            $risiko[] = 'Ada masalah peralatan yang perlu disampaikan';
        }

        // Sign Out - Ada catatan khusus recovery
        if ($this->signout_q5 === 'ya') {
            $risiko[] = 'Ada catatan khusus untuk proses recovery dan perawatan';
        }

        return $risiko;
    }

    /**
     * Scope untuk filter berdasarkan dr. Bedah
     */
    public function scopeByDokterBedah($query, $dokter)
    {
        return $query->where('signout_nama_dr_bedah', 'like', "%{$dokter}%");
    }

    /**
     * Scope untuk filter berdasarkan dr. Anestesi (any phase)
     */
    public function scopeByDokterAnestesi($query, $dokter)
    {
        return $query->where(function($q) use ($dokter) {
            $q->where('signin_nama_dr_anestesi', 'like', "%{$dokter}%")
              ->orWhere('timeout_nama_dr_anestesi', 'like', "%{$dokter}%")
              ->orWhere('signout_nama_dr_anestesi', 'like', "%{$dokter}%");
        });
    }

    /**
     * Scope untuk checklist yang sudah lengkap
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('signin_waktu')
                     ->whereNotNull('timeout_waktu')
                     ->whereNotNull('signout_waktu')
                     ->whereNotNull('signin_ttd_dr_anestesi')
                     ->whereNotNull('timeout_ttd_dr_anestesi')
                     ->whereNotNull('signout_ttd_dr_bedah');
    }

    /**
     * Scope untuk checklist yang belum lengkap
     */
    public function scopeIncomplete($query)
    {
        return $query->where(function($q) {
            $q->whereNull('signin_waktu')
              ->orWhereNull('timeout_waktu')
              ->orWhereNull('signout_waktu')
              ->orWhereNull('signin_ttd_dr_anestesi')
              ->orWhereNull('timeout_ttd_dr_anestesi')
              ->orWhereNull('signout_ttd_dr_bedah');
        });
    }

    /**
     * Scope untuk checklist dengan risiko tinggi
     */
    public function scopeHighRisk($query)
    {
        return $query->where(function($q) {
            $q->where('signin_q5', 'ya') // Alergi
              ->orWhere('signin_q6', 'ya_tersedia') // Gangguan pernafasan
              ->orWhere('signin_q7', 'ya_direncanakan') // Risiko perdarahan tinggi
              ->orWhereNotNull('timeout_q4_tindakan_beresiko'); // Tindakan beresiko
        });
    }

    /**
     * Scope untuk checklist dengan masalah peralatan
     */
    public function scopeWithEquipmentIssue($query)
    {
        return $query->where(function($q) {
            $q->where('signin_q3', 'tidak') // Mesin anestesi tidak lengkap
              ->orWhere('timeout_q6_masalah_alat', 'ya') // Masalah alat di Time Out
              ->orWhere('signout_q2', 'tidak') // Alat tidak lengkap di Sign Out
              ->orWhere('signout_q4', 'ya'); // Masalah peralatan di Sign Out
        });
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    /**
     * Scope untuk filter berdasarkan range tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}