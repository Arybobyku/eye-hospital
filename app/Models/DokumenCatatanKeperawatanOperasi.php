<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DokumenCatatanKeperawatanOperasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumen_catatan_keperawatan_operasi';

    protected $fillable = [
        'uuid', 'uuid_pasien',
        'no_rm', 'no_surat', 'jenis_kelamin', 'nama', 'nik', 'tanggal_lahir',

        // Waktu
        'jam_mulai', 'jam_selesai',
        'jam_anestesi_mulai', 'jam_anestesi_selesai',
        'jam_pembedahan_mulai', 'jam_pembedahan_selesai',

        // 1–6
        'tipe_elektif', 'tipe_darurat', 'tipe_rawat_jalan',
        'biusan_umum', 'biusan_lokal', 'biusan_regional',
        'kesadaran_terjaga', 'kesadaran_mudah_dibangunkan', 'kesadaran_lainnya',
        'emosi_rileks', 'emosi_gelisah', 'emosi_tidak_ada_respon',
        'canul_tangan', 'canul_kaki', 'canul_cvp', 'canul_lainnya',
        'jenis_op_bersih', 'jenis_op_terkontaminasi', 'jenis_op_bersih_terkontaminasi', 'jenis_op_kotor_infeksi',

        // 7–12
        'posisi_supine', 'posisi_prone', 'posisi_lithotomi', 'posisi_kidney', 'posisi_lateral', 'posisi_lainnya', 'posisi_diawasi_oleh',
        'selengantangan_adduksi', 'selengantangan_abduksi', 'selengantangan_lainnya',
        'urine_ya', 'urine_tidak', 'urine_ok', 'urine_ruangan', 'urine_dipasang_oleh', 'urine_jenis',
        'desinfeksi_iodium', 'desinfeksi_alkohol', 'desinfeksi_povidone', 'desinfeksi_chlorhexidine',
        'insisi_pfannenstiel', 'insisi_lainnya',
        'alat_hand_rest', 'alat_lithotomi_support', 'alat_lateral_support', 'alat_chest_support', 'alat_heat_frame', 'alat_lainnya',

        // 13
        'diatermi_ya', 'diatermi_tidak', 'diatermi_monopolar', 'diatermi_bipolar',
        'diatermi_netral_bokong', 'diatermi_netral_tungkai_atas', 'diatermi_netral_tungkai_bawah',
        'diatermi_netral_punggung', 'diatermi_netral_bahu', 'diatermi_dipasang_oleh',
        'diatermi_kulit_sbl_utuh', 'diatermi_kulit_sbl_bulosa', 'diatermi_kulit_sbl_eritema', 'diatermi_kulit_sbl_luka_bakar',
        'diatermi_kulit_ssd_utuh', 'diatermi_kulit_ssd_bulosa', 'diatermi_kulit_ssd_eritema', 'diatermi_kulit_ssd_luka_bakar',

        // 14–20
        'warm_blanket_ya', 'warm_blanket_tidak', 'warm_blanket_jenis', 'warm_blanket_jam_mulai', 'warm_blanket_jam_selesai',
        'tourniquet_ya', 'tourniquet_tidak', 'tourniquet_lokasi',
        'tourniquet_lengan', 'tourniquet_lengan_jam_mulai', 'tourniquet_lengan_jam_selesai', 'tourniquet_lengan_td',
        'tourniquet_dipasang_oleh',
        'tourniquet_kaki', 'tourniquet_kaki_jam_mulai', 'tourniquet_kaki_jam_selesai', 'tourniquet_kaki_td',
        'implant_ya', 'implant_tidak', 'implant_jenis', 'implant_lokasi',
        'drain_ya', 'drain_tidak', 'drain_jenis', 'drain_lokasi',
        'irigasi_ya', 'irigasi_tidak', 'irigasi_nacl', 'irigasi_h2o2', 'irigasi_antibiotik', 'irigasi_lainnya',
        'tampon_ya', 'tampon_tidak', 'tampon_lokasi', 'tampon_jumlah',
        'spesimen_histology', 'spesimen_histology_jenis',
        'spesimen_kultur', 'spesimen_kultur_jenis',
        'spesimen_cytologi', 'spesimen_cytologi_jenis',
        'spesimen_frozen', 'spesimen_frozen_jenis',
        'cairan_infus',

        // 22–24
        'kassa_sebelum', 'kassa_penambahan', 'kassa_setelah',
        'jarum_sebelum', 'jarum_penambahan', 'jarum_setelah',
        'bisturi_sebelum', 'bisturi_penambahan', 'bisturi_setelah',

        // Section B
        'kasa_besar_persediaan', 'kasa_besar_terpakai', 'kasa_besar_sisa', 'kasa_besar_keterangan',
        'kasa_persediaan', 'kasa_terpakai', 'kasa_sisa', 'kasa_keterangan',
        'kasa_kacang_persediaan', 'kasa_kacang_terpakai', 'kasa_kacang_sisa', 'kasa_kacang_keterangan',
        'kasa_tampon_persediaan', 'kasa_tampon_terpakai', 'kasa_tampon_sisa', 'kasa_tampon_keterangan',
        'instrumen_persediaan', 'instrumen_terpakai', 'instrumen_sisa', 'instrumen_keterangan',
        'jarum_atraumatik_persediaan', 'jarum_atraumatik_terpakai', 'jarum_atraumatik_sisa', 'jarum_atraumatik_keterangan',
        'jarum_lepas_persediaan', 'jarum_lepas_terpakai', 'jarum_lepas_sisa', 'jarum_lepas_keterangan',
        'selang_persediaan', 'selang_terpakai', 'selang_sisa', 'selang_keterangan',

        // TTD (Section B)
        'ttd_dokter_operator', 'nama_dokter_operator',
        'ttd_perawat_instrumen', 'nama_perawat_instrumen',
        'ttd_perawat_sirkuler', 'nama_perawat_sirkuler',

        // C. Diagnosa Intra Operasi
        'c_gn_neuro_muskular', 'c_gn_penumpukan_sekret',
        'c_gn_int_jalan_nafas', 'c_gn_int_hiperekstensi', 'c_gn_int_observasi_rr',
        'c_gn_int_pantau_ttv', 'c_gn_int_suction', 'c_gn_int_o2', 'c_gn_int_obat',
        'c_gn_eval_ttv_normal', 'c_gn_eval_nafas_spontan', 'c_gn_eval_sianosis',
        'c_gn_eval_o2_value', 'c_gn_eval_observasi_ruangan', 'c_gn_paraf', 'c_gn_nama',
        'c_rc_pembatasan_intake', 'c_rc_hilang_cairan', 'c_rc_pengeluaran_integritas',
        'c_rc_int_ukur_io', 'c_rc_int_pantau_ttv', 'c_rc_int_mual_muntah',
        'c_rc_int_periksa_pembalut', 'c_rc_int_pantau_suhu',
        'c_rc_eval_ttv_normal', 'c_rc_eval_input', 'c_rc_eval_output',
        'c_rc_eval_mukosa_lembab', 'c_rc_eval_turgor_elastis', 'c_rc_paraf', 'c_rc_nama',
        'c_rd_pemajanan_peralatan', 'c_rd_hipoksia_jaringan',
        'c_rd_int_lepas_gigi', 'c_rd_int_periksa_identitas', 'c_rd_int_brankar',
        'c_rd_int_sabuk', 'c_rd_int_peralatan_posisi', 'c_rd_int_keamanan_elektrikal',
        'c_rd_int_plate_diatermi', 'c_rd_int_pantau_io', 'c_rd_int_catat_kassa',
        'c_rd_eval_posisi', 'c_rd_eval_alat_elektro', 'c_rd_eval_kassa', 'c_rd_paraf', 'c_rd_nama',
        'c_ri_trauma_post', 'c_ri_pemajanan_lingkungan', 'c_ri_pemajanan_peralatan',
        'c_ri_int_cuci_tangan', 'c_ri_int_desinfeksi', 'c_ri_int_kadaluarsa',
        'c_ri_int_sterilitas', 'c_ri_int_tutup_luka',
        'c_ri_eval_lingkungan_steril', 'c_ri_paraf', 'c_ri_nama',

        // D. Pengkajian Pasca Operasi
        'd_ruang_pemulihan_ya', 'd_ruang_pemulihan_tidak', 'd_masuk_jam', 'd_keluar_jam',
        'd_kembali_ruangan', 'd_kembali_icu', 'd_kembali_lainnya',
        'd_keadaan_baik', 'd_keadaan_sedang', 'd_keadaan_buruk',
        'd_kesadaran_cm', 'd_kesadaran_apatis', 'd_kesadaran_somnolen', 'd_kesadaran_sopor', 'd_kesadaran_koma',
        'd_kulit_datang_kering', 'd_kulit_datang_merah_muda', 'd_kulit_datang_hangat',
        'd_kulit_keluar_kering', 'd_kulit_keluar_merah_muda', 'd_kulit_keluar_hangat',
        'd_sirkulasi_merah_muda', 'd_sirkulasi_kebiruan',
        'd_posisi_lateral', 'd_posisi_datar', 'd_posisi_head_up', 'd_posisi_semi_fowler',
        'd_perdarahan_ya', 'd_perdarahan_cc', 'd_perdarahan_tidak', 'd_perdarahan_lokasi',
        'd_muntah_ya', 'd_muntah_tidak', 'd_mukosa_lembab', 'd_mukosa_kering',
        'd_jaringan_pa_ya', 'd_jaringan_pa_tidak', 'd_jaringan_pa_k_bedah',
        'd_jaringan_pa_ruangan', 'd_jaringan_pa_jumlah',
        'd_nyeri_ya', 'd_nyeri_tidak', 'd_jatuh_ringan', 'd_jatuh_sedang', 'd_jatuh_tinggi',
        'd_nadi_teratur_masuk', 'd_nadi_teratur_keluar',
        'd_nadi_tidak_teratur_masuk', 'd_nadi_tidak_teratur_keluar',
        'd_nadi_lemah_masuk', 'd_nadi_lemah_keluar',
        'd_nadi_takikardia_masuk', 'd_nadi_takikardia_keluar',
        'd_nadi_normal_masuk', 'd_nadi_normal_keluar',
        'd_nafas_teratur_masuk', 'd_nafas_teratur_keluar',
        'd_nafas_tidak_teratur_masuk', 'd_nafas_tidak_teratur_keluar',
        'd_nafas_dangkal_masuk', 'd_nafas_dangkal_keluar',
        'd_nafas_dalam_masuk', 'd_nafas_dalam_keluar',
        'd_nafas_sukar_masuk', 'd_nafas_sukar_keluar',

        // E. Diagnosa Pasca Operasi
        'e_na_gangguan_kulit', 'e_na_selang_drain',
        'e_na_int_kaji_lokasi', 'e_na_int_kaji_ttv', 'e_na_int_atur_posisi', 'e_na_int_relaksasi',
        'e_na_eval_ttv_normal', 'e_na_eval_nyeri_terkontrol', 'e_na_eval_nyeri_berkurang', 'e_na_eval_observasi_ruangan',
        'e_ri_trauma_post', 'e_ri_pemajanan_lingkungan', 'e_ri_pemajanan_peralatan',
        'e_ri_int_cuci_tangan', 'e_ri_int_desinfeksi', 'e_ri_int_kadaluarsa',
        'e_ri_int_sterilitas', 'e_ri_int_tutup_luka',
        'e_ri_eval_lingkungan_steril', 'e_ri_paraf', 'e_ri_nama',
        'e_rs_suhu_rendah', 'e_rs_penggunaan_obat', 'e_rs_dehidrasi',
        'e_rs_int_catat_suhu', 'e_rs_int_kaji_suhu', 'e_rs_int_kolaborasi_obat',
        'e_rs_eval_dingin_berkurang', 'e_rs_eval_tidak_menggigil', 'e_rs_eval_suhu',

        // F. TTD Pasca Operasi
        'f_ttd_perawat_instrumen', 'f_nama_perawat_instrumen',
        'f_ttd_perawat_sirkuler', 'f_nama_perawat_sirkuler',
        'f_ttd_perawat_anestesi', 'f_nama_perawat_anestesi',

        'created_by', 'updated_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'cairan_infus'  => 'array',

        // Booleans
        'tipe_elektif' => 'boolean', 'tipe_darurat' => 'boolean', 'tipe_rawat_jalan' => 'boolean',
        'biusan_umum' => 'boolean', 'biusan_lokal' => 'boolean', 'biusan_regional' => 'boolean',
        'kesadaran_terjaga' => 'boolean', 'kesadaran_mudah_dibangunkan' => 'boolean',
        'emosi_rileks' => 'boolean', 'emosi_gelisah' => 'boolean', 'emosi_tidak_ada_respon' => 'boolean',
        'canul_tangan' => 'boolean', 'canul_kaki' => 'boolean', 'canul_cvp' => 'boolean',
        'jenis_op_bersih' => 'boolean', 'jenis_op_terkontaminasi' => 'boolean',
        'jenis_op_bersih_terkontaminasi' => 'boolean', 'jenis_op_kotor_infeksi' => 'boolean',
        'posisi_supine' => 'boolean', 'posisi_prone' => 'boolean', 'posisi_lithotomi' => 'boolean',
        'posisi_kidney' => 'boolean', 'posisi_lateral' => 'boolean',
        'selengantangan_adduksi' => 'boolean', 'selengantangan_abduksi' => 'boolean',
        'urine_ya' => 'boolean', 'urine_tidak' => 'boolean', 'urine_ok' => 'boolean', 'urine_ruangan' => 'boolean',
        'desinfeksi_iodium' => 'boolean', 'desinfeksi_alkohol' => 'boolean',
        'desinfeksi_povidone' => 'boolean', 'desinfeksi_chlorhexidine' => 'boolean',
        'insisi_pfannenstiel' => 'boolean',
        'alat_hand_rest' => 'boolean', 'alat_lithotomi_support' => 'boolean', 'alat_lateral_support' => 'boolean',
        'alat_chest_support' => 'boolean', 'alat_heat_frame' => 'boolean',
        'diatermi_ya' => 'boolean', 'diatermi_tidak' => 'boolean',
        'diatermi_monopolar' => 'boolean', 'diatermi_bipolar' => 'boolean',
        'diatermi_netral_bokong' => 'boolean', 'diatermi_netral_tungkai_atas' => 'boolean',
        'diatermi_netral_tungkai_bawah' => 'boolean', 'diatermi_netral_punggung' => 'boolean',
        'diatermi_netral_bahu' => 'boolean',
        'diatermi_kulit_sbl_utuh' => 'boolean', 'diatermi_kulit_sbl_bulosa' => 'boolean',
        'diatermi_kulit_sbl_eritema' => 'boolean', 'diatermi_kulit_sbl_luka_bakar' => 'boolean',
        'diatermi_kulit_ssd_utuh' => 'boolean', 'diatermi_kulit_ssd_bulosa' => 'boolean',
        'diatermi_kulit_ssd_eritema' => 'boolean', 'diatermi_kulit_ssd_luka_bakar' => 'boolean',
        'warm_blanket_ya' => 'boolean', 'warm_blanket_tidak' => 'boolean',
        'tourniquet_ya' => 'boolean', 'tourniquet_tidak' => 'boolean',
        'tourniquet_lengan' => 'boolean', 'tourniquet_kaki' => 'boolean',
        'implant_ya' => 'boolean', 'implant_tidak' => 'boolean',
        'drain_ya' => 'boolean', 'drain_tidak' => 'boolean',
        'irigasi_ya' => 'boolean', 'irigasi_tidak' => 'boolean',
        'irigasi_nacl' => 'boolean', 'irigasi_h2o2' => 'boolean', 'irigasi_antibiotik' => 'boolean',
        'tampon_ya' => 'boolean', 'tampon_tidak' => 'boolean',
        'spesimen_histology' => 'boolean', 'spesimen_kultur' => 'boolean',
        'spesimen_cytologi' => 'boolean', 'spesimen_frozen' => 'boolean',
        // C
        'c_gn_neuro_muskular' => 'boolean', 'c_gn_penumpukan_sekret' => 'boolean',
        'c_gn_int_jalan_nafas' => 'boolean', 'c_gn_int_hiperekstensi' => 'boolean',
        'c_gn_int_observasi_rr' => 'boolean', 'c_gn_int_pantau_ttv' => 'boolean',
        'c_gn_int_suction' => 'boolean', 'c_gn_int_o2' => 'boolean', 'c_gn_int_obat' => 'boolean',
        'c_gn_eval_ttv_normal' => 'boolean', 'c_gn_eval_nafas_spontan' => 'boolean',
        'c_gn_eval_sianosis' => 'boolean', 'c_gn_eval_observasi_ruangan' => 'boolean',
        'c_rc_pembatasan_intake' => 'boolean', 'c_rc_hilang_cairan' => 'boolean',
        'c_rc_pengeluaran_integritas' => 'boolean', 'c_rc_int_ukur_io' => 'boolean',
        'c_rc_int_pantau_ttv' => 'boolean', 'c_rc_int_mual_muntah' => 'boolean',
        'c_rc_int_periksa_pembalut' => 'boolean', 'c_rc_int_pantau_suhu' => 'boolean',
        'c_rc_eval_ttv_normal' => 'boolean', 'c_rc_eval_mukosa_lembab' => 'boolean',
        'c_rc_eval_turgor_elastis' => 'boolean',
        'c_rd_pemajanan_peralatan' => 'boolean', 'c_rd_hipoksia_jaringan' => 'boolean',
        'c_rd_int_lepas_gigi' => 'boolean', 'c_rd_int_periksa_identitas' => 'boolean',
        'c_rd_int_brankar' => 'boolean', 'c_rd_int_sabuk' => 'boolean',
        'c_rd_int_peralatan_posisi' => 'boolean', 'c_rd_int_keamanan_elektrikal' => 'boolean',
        'c_rd_int_plate_diatermi' => 'boolean', 'c_rd_int_pantau_io' => 'boolean',
        'c_rd_int_catat_kassa' => 'boolean', 'c_rd_eval_posisi' => 'boolean',
        'c_rd_eval_alat_elektro' => 'boolean', 'c_rd_eval_kassa' => 'boolean',
        'c_ri_trauma_post' => 'boolean', 'c_ri_pemajanan_lingkungan' => 'boolean',
        'c_ri_pemajanan_peralatan' => 'boolean', 'c_ri_int_cuci_tangan' => 'boolean',
        'c_ri_int_desinfeksi' => 'boolean', 'c_ri_int_kadaluarsa' => 'boolean',
        'c_ri_int_sterilitas' => 'boolean', 'c_ri_int_tutup_luka' => 'boolean',
        'c_ri_eval_lingkungan_steril' => 'boolean',
        // D
        'd_ruang_pemulihan_ya' => 'boolean', 'd_ruang_pemulihan_tidak' => 'boolean',
        'd_kembali_ruangan' => 'boolean', 'd_kembali_icu' => 'boolean',
        'd_keadaan_baik' => 'boolean', 'd_keadaan_sedang' => 'boolean', 'd_keadaan_buruk' => 'boolean',
        'd_kesadaran_cm' => 'boolean', 'd_kesadaran_apatis' => 'boolean',
        'd_kesadaran_somnolen' => 'boolean', 'd_kesadaran_sopor' => 'boolean', 'd_kesadaran_koma' => 'boolean',
        'd_kulit_datang_kering' => 'boolean', 'd_kulit_datang_merah_muda' => 'boolean', 'd_kulit_datang_hangat' => 'boolean',
        'd_kulit_keluar_kering' => 'boolean', 'd_kulit_keluar_merah_muda' => 'boolean', 'd_kulit_keluar_hangat' => 'boolean',
        'd_sirkulasi_merah_muda' => 'boolean', 'd_sirkulasi_kebiruan' => 'boolean',
        'd_posisi_lateral' => 'boolean', 'd_posisi_datar' => 'boolean',
        'd_posisi_head_up' => 'boolean', 'd_posisi_semi_fowler' => 'boolean',
        'd_perdarahan_ya' => 'boolean', 'd_perdarahan_tidak' => 'boolean',
        'd_muntah_ya' => 'boolean', 'd_muntah_tidak' => 'boolean',
        'd_mukosa_lembab' => 'boolean', 'd_mukosa_kering' => 'boolean',
        'd_jaringan_pa_ya' => 'boolean', 'd_jaringan_pa_tidak' => 'boolean',
        'd_jaringan_pa_k_bedah' => 'boolean', 'd_jaringan_pa_ruangan' => 'boolean',
        'd_nyeri_ya' => 'boolean', 'd_nyeri_tidak' => 'boolean',
        'd_jatuh_ringan' => 'boolean', 'd_jatuh_sedang' => 'boolean', 'd_jatuh_tinggi' => 'boolean',
        'd_nadi_teratur_masuk' => 'boolean', 'd_nadi_teratur_keluar' => 'boolean',
        'd_nadi_tidak_teratur_masuk' => 'boolean', 'd_nadi_tidak_teratur_keluar' => 'boolean',
        'd_nadi_lemah_masuk' => 'boolean', 'd_nadi_lemah_keluar' => 'boolean',
        'd_nadi_takikardia_masuk' => 'boolean', 'd_nadi_takikardia_keluar' => 'boolean',
        'd_nadi_normal_masuk' => 'boolean', 'd_nadi_normal_keluar' => 'boolean',
        'd_nafas_teratur_masuk' => 'boolean', 'd_nafas_teratur_keluar' => 'boolean',
        'd_nafas_tidak_teratur_masuk' => 'boolean', 'd_nafas_tidak_teratur_keluar' => 'boolean',
        'd_nafas_dangkal_masuk' => 'boolean', 'd_nafas_dangkal_keluar' => 'boolean',
        'd_nafas_dalam_masuk' => 'boolean', 'd_nafas_dalam_keluar' => 'boolean',
        'd_nafas_sukar_masuk' => 'boolean', 'd_nafas_sukar_keluar' => 'boolean',
        // E
        'e_na_gangguan_kulit' => 'boolean', 'e_na_selang_drain' => 'boolean',
        'e_na_int_kaji_lokasi' => 'boolean', 'e_na_int_kaji_ttv' => 'boolean',
        'e_na_int_atur_posisi' => 'boolean', 'e_na_int_relaksasi' => 'boolean',
        'e_na_eval_ttv_normal' => 'boolean', 'e_na_eval_nyeri_terkontrol' => 'boolean',
        'e_na_eval_nyeri_berkurang' => 'boolean', 'e_na_eval_observasi_ruangan' => 'boolean',
        'e_ri_trauma_post' => 'boolean', 'e_ri_pemajanan_lingkungan' => 'boolean',
        'e_ri_pemajanan_peralatan' => 'boolean', 'e_ri_int_cuci_tangan' => 'boolean',
        'e_ri_int_desinfeksi' => 'boolean', 'e_ri_int_kadaluarsa' => 'boolean',
        'e_ri_int_sterilitas' => 'boolean', 'e_ri_int_tutup_luka' => 'boolean',
        'e_ri_eval_lingkungan_steril' => 'boolean',
        'e_rs_suhu_rendah' => 'boolean', 'e_rs_penggunaan_obat' => 'boolean', 'e_rs_dehidrasi' => 'boolean',
        'e_rs_int_catat_suhu' => 'boolean', 'e_rs_int_kaji_suhu' => 'boolean',
        'e_rs_int_kolaborasi_obat' => 'boolean',
        'e_rs_eval_dingin_berkurang' => 'boolean', 'e_rs_eval_tidak_menggigil' => 'boolean',
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
                $model->no_surat = "RM 4.6/CKIDPO/{$tahun}";
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'uuid_pasien', 'uuid');
    }
}
