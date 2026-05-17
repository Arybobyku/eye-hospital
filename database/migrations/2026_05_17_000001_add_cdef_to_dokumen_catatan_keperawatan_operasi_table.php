<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCdefToDokumenCatatanKeperawatanOperasiTable extends Migration
{
    public function up()
    {
        Schema::table('dokumen_catatan_keperawatan_operasi', function (Blueprint $table) {

            // ═══════════════════════════════════════════════════
            // C. DIAGNOSA INTRA OPERASI
            // ═══════════════════════════════════════════════════

            // C1. Gangguan pola nafas
            $table->boolean('c_gn_neuro_muskular')->default(false)->after('bisturi_setelah');
            $table->boolean('c_gn_penumpukan_sekret')->default(false);
            // Intervensi
            $table->boolean('c_gn_int_jalan_nafas')->default(false);
            $table->boolean('c_gn_int_hiperekstensi')->default(false);
            $table->boolean('c_gn_int_observasi_rr')->default(false);
            $table->boolean('c_gn_int_pantau_ttv')->default(false);
            $table->boolean('c_gn_int_suction')->default(false);
            $table->boolean('c_gn_int_o2')->default(false);
            $table->boolean('c_gn_int_obat')->default(false);
            // Evaluasi
            $table->boolean('c_gn_eval_ttv_normal')->default(false);
            $table->boolean('c_gn_eval_nafas_spontan')->default(false);
            $table->boolean('c_gn_eval_sianosis')->default(false);
            $table->string('c_gn_eval_o2_value', 20)->nullable();
            $table->boolean('c_gn_eval_observasi_ruangan')->default(false);
            $table->longText('c_gn_paraf')->nullable();
            $table->string('c_gn_nama', 200)->nullable();

            // C2. Resiko tinggi kekurangan cairan
            $table->boolean('c_rc_pembatasan_intake')->default(false);
            $table->boolean('c_rc_hilang_cairan')->default(false);
            $table->boolean('c_rc_pengeluaran_integritas')->default(false);
            // Intervensi
            $table->boolean('c_rc_int_ukur_io')->default(false);
            $table->boolean('c_rc_int_pantau_ttv')->default(false);
            $table->boolean('c_rc_int_mual_muntah')->default(false);
            $table->boolean('c_rc_int_periksa_pembalut')->default(false);
            $table->boolean('c_rc_int_pantau_suhu')->default(false);
            // Evaluasi
            $table->boolean('c_rc_eval_ttv_normal')->default(false);
            $table->string('c_rc_eval_input', 20)->nullable();
            $table->string('c_rc_eval_output', 20)->nullable();
            $table->boolean('c_rc_eval_mukosa_lembab')->default(false);
            $table->boolean('c_rc_eval_turgor_elastis')->default(false);
            $table->longText('c_rc_paraf')->nullable();
            $table->string('c_rc_nama', 200)->nullable();

            // C3. Resiko tinggi cedera
            $table->boolean('c_rd_pemajanan_peralatan')->default(false);
            $table->boolean('c_rd_hipoksia_jaringan')->default(false);
            // Intervensi
            $table->boolean('c_rd_int_lepas_gigi')->default(false);
            $table->boolean('c_rd_int_periksa_identitas')->default(false);
            $table->boolean('c_rd_int_brankar')->default(false);
            $table->boolean('c_rd_int_sabuk')->default(false);
            $table->boolean('c_rd_int_peralatan_posisi')->default(false);
            $table->boolean('c_rd_int_keamanan_elektrikal')->default(false);
            $table->boolean('c_rd_int_plate_diatermi')->default(false);
            $table->boolean('c_rd_int_pantau_io')->default(false);
            $table->boolean('c_rd_int_catat_kassa')->default(false);
            // Evaluasi
            $table->boolean('c_rd_eval_posisi')->default(false);
            $table->boolean('c_rd_eval_alat_elektro')->default(false);
            $table->boolean('c_rd_eval_kassa')->default(false);
            $table->longText('c_rd_paraf')->nullable();
            $table->string('c_rd_nama', 200)->nullable();

            // C4. Resiko infeksi (intra)
            $table->boolean('c_ri_trauma_post')->default(false);
            $table->boolean('c_ri_pemajanan_lingkungan')->default(false);
            $table->boolean('c_ri_pemajanan_peralatan')->default(false);
            // Intervensi
            $table->boolean('c_ri_int_cuci_tangan')->default(false);
            $table->boolean('c_ri_int_desinfeksi')->default(false);
            $table->boolean('c_ri_int_kadaluarsa')->default(false);
            $table->boolean('c_ri_int_sterilitas')->default(false);
            $table->boolean('c_ri_int_tutup_luka')->default(false);
            // Evaluasi
            $table->boolean('c_ri_eval_lingkungan_steril')->default(false);
            $table->longText('c_ri_paraf')->nullable();
            $table->string('c_ri_nama', 200)->nullable();

            // ═══════════════════════════════════════════════════
            // D. PENGKAJIAN PASCA OPERASI
            // ═══════════════════════════════════════════════════
            $table->boolean('d_ruang_pemulihan_ya')->default(false);
            $table->boolean('d_ruang_pemulihan_tidak')->default(false);
            $table->string('d_masuk_jam', 10)->nullable();
            $table->string('d_keluar_jam', 10)->nullable();
            $table->boolean('d_kembali_ruangan')->default(false);
            $table->boolean('d_kembali_icu')->default(false);
            $table->string('d_kembali_lainnya', 100)->nullable();

            // 1. Keadaan umum
            $table->boolean('d_keadaan_baik')->default(false);
            $table->boolean('d_keadaan_sedang')->default(false);
            $table->boolean('d_keadaan_buruk')->default(false);
            // 2. Kesadaran
            $table->boolean('d_kesadaran_cm')->default(false);
            $table->boolean('d_kesadaran_apatis')->default(false);
            $table->boolean('d_kesadaran_somnolen')->default(false);
            $table->boolean('d_kesadaran_sopor')->default(false);
            $table->boolean('d_kesadaran_koma')->default(false);
            // 3. Kulit datang
            $table->boolean('d_kulit_datang_kering')->default(false);
            $table->boolean('d_kulit_datang_merah_muda')->default(false);
            $table->boolean('d_kulit_datang_hangat')->default(false);
            // 4. Kulit keluar
            $table->boolean('d_kulit_keluar_kering')->default(false);
            $table->boolean('d_kulit_keluar_merah_muda')->default(false);
            $table->boolean('d_kulit_keluar_hangat')->default(false);
            // 5. Sirkulasi
            $table->boolean('d_sirkulasi_merah_muda')->default(false);
            $table->boolean('d_sirkulasi_kebiruan')->default(false);
            // 6. Posisi
            $table->boolean('d_posisi_lateral')->default(false);
            $table->boolean('d_posisi_datar')->default(false);
            $table->boolean('d_posisi_head_up')->default(false);
            $table->boolean('d_posisi_semi_fowler')->default(false);
            // 7. Perdarahan
            $table->boolean('d_perdarahan_ya')->default(false);
            $table->string('d_perdarahan_cc', 20)->nullable();
            $table->boolean('d_perdarahan_tidak')->default(false);
            $table->string('d_perdarahan_lokasi', 200)->nullable();
            // 8. Muntah
            $table->boolean('d_muntah_ya')->default(false);
            $table->boolean('d_muntah_tidak')->default(false);
            // 9. Mukosa mulut
            $table->boolean('d_mukosa_lembab')->default(false);
            $table->boolean('d_mukosa_kering')->default(false);
            // 10. Jaringan PA
            $table->boolean('d_jaringan_pa_ya')->default(false);
            $table->boolean('d_jaringan_pa_tidak')->default(false);
            $table->boolean('d_jaringan_pa_k_bedah')->default(false);
            $table->boolean('d_jaringan_pa_ruangan')->default(false);
            $table->string('d_jaringan_pa_jumlah', 50)->nullable();
            // 11. Skrining nyeri
            $table->boolean('d_nyeri_ya')->default(false);
            $table->boolean('d_nyeri_tidak')->default(false);
            // 12. Resiko jatuh
            $table->boolean('d_jatuh_ringan')->default(false);
            $table->boolean('d_jatuh_sedang')->default(false);
            $table->boolean('d_jatuh_tinggi')->default(false);

            // Tabel Nadi (Teratur/TidakTeratur/Lemah/Takikardia/Normal) × Masuk/Keluar
            $table->boolean('d_nadi_teratur_masuk')->default(false);
            $table->boolean('d_nadi_teratur_keluar')->default(false);
            $table->boolean('d_nadi_tidak_teratur_masuk')->default(false);
            $table->boolean('d_nadi_tidak_teratur_keluar')->default(false);
            $table->boolean('d_nadi_lemah_masuk')->default(false);
            $table->boolean('d_nadi_lemah_keluar')->default(false);
            $table->boolean('d_nadi_takikardia_masuk')->default(false);
            $table->boolean('d_nadi_takikardia_keluar')->default(false);
            $table->boolean('d_nadi_normal_masuk')->default(false);
            $table->boolean('d_nadi_normal_keluar')->default(false);
            // Tabel Pernafasan
            $table->boolean('d_nafas_teratur_masuk')->default(false);
            $table->boolean('d_nafas_teratur_keluar')->default(false);
            $table->boolean('d_nafas_tidak_teratur_masuk')->default(false);
            $table->boolean('d_nafas_tidak_teratur_keluar')->default(false);
            $table->boolean('d_nafas_dangkal_masuk')->default(false);
            $table->boolean('d_nafas_dangkal_keluar')->default(false);
            $table->boolean('d_nafas_dalam_masuk')->default(false);
            $table->boolean('d_nafas_dalam_keluar')->default(false);
            $table->boolean('d_nafas_sukar_masuk')->default(false);
            $table->boolean('d_nafas_sukar_keluar')->default(false);

            // ═══════════════════════════════════════════════════
            // E. DIAGNOSA PASCA OPERASI
            // ═══════════════════════════════════════════════════

            // E1. Nyeri akut
            $table->boolean('e_na_gangguan_kulit')->default(false);
            $table->boolean('e_na_selang_drain')->default(false);
            // Intervensi
            $table->boolean('e_na_int_kaji_lokasi')->default(false);
            $table->boolean('e_na_int_kaji_ttv')->default(false);
            $table->boolean('e_na_int_atur_posisi')->default(false);
            $table->boolean('e_na_int_relaksasi')->default(false);
            // Evaluasi
            $table->boolean('e_na_eval_ttv_normal')->default(false);
            $table->boolean('e_na_eval_nyeri_terkontrol')->default(false);
            $table->boolean('e_na_eval_nyeri_berkurang')->default(false);
            $table->boolean('e_na_eval_observasi_ruangan')->default(false);

            // E2. Resiko infeksi (pasca)
            $table->boolean('e_ri_trauma_post')->default(false);
            $table->boolean('e_ri_pemajanan_lingkungan')->default(false);
            $table->boolean('e_ri_pemajanan_peralatan')->default(false);
            // Intervensi
            $table->boolean('e_ri_int_cuci_tangan')->default(false);
            $table->boolean('e_ri_int_desinfeksi')->default(false);
            $table->boolean('e_ri_int_kadaluarsa')->default(false);
            $table->boolean('e_ri_int_sterilitas')->default(false);
            $table->boolean('e_ri_int_tutup_luka')->default(false);
            // Evaluasi
            $table->boolean('e_ri_eval_lingkungan_steril')->default(false);
            $table->longText('e_ri_paraf')->nullable();
            $table->string('e_ri_nama', 200)->nullable();

            // E3. Resiko suhu tubuh
            $table->boolean('e_rs_suhu_rendah')->default(false);
            $table->boolean('e_rs_penggunaan_obat')->default(false);
            $table->boolean('e_rs_dehidrasi')->default(false);
            // Intervensi
            $table->boolean('e_rs_int_catat_suhu')->default(false);
            $table->boolean('e_rs_int_kaji_suhu')->default(false);
            $table->boolean('e_rs_int_kolaborasi_obat')->default(false);
            // Evaluasi
            $table->boolean('e_rs_eval_dingin_berkurang')->default(false);
            $table->boolean('e_rs_eval_tidak_menggigil')->default(false);
            $table->string('e_rs_eval_suhu', 20)->nullable();

            // ═══════════════════════════════════════════════════
            // F. TTD PASCA OPERASI
            // ═══════════════════════════════════════════════════
            $table->longText('f_ttd_perawat_instrumen')->nullable();
            $table->string('f_nama_perawat_instrumen', 200)->nullable();
            $table->longText('f_ttd_perawat_sirkuler')->nullable();
            $table->string('f_nama_perawat_sirkuler', 200)->nullable();
            $table->longText('f_ttd_perawat_anestesi')->nullable();
            $table->string('f_nama_perawat_anestesi', 200)->nullable();
        });
    }

    public function down()
    {
        Schema::table('dokumen_catatan_keperawatan_operasi', function (Blueprint $table) {
            $table->dropColumn([
                // C1
                'c_gn_neuro_muskular','c_gn_penumpukan_sekret',
                'c_gn_int_jalan_nafas','c_gn_int_hiperekstensi','c_gn_int_observasi_rr',
                'c_gn_int_pantau_ttv','c_gn_int_suction','c_gn_int_o2','c_gn_int_obat',
                'c_gn_eval_ttv_normal','c_gn_eval_nafas_spontan','c_gn_eval_sianosis',
                'c_gn_eval_o2_value','c_gn_eval_observasi_ruangan','c_gn_paraf','c_gn_nama',
                // C2
                'c_rc_pembatasan_intake','c_rc_hilang_cairan','c_rc_pengeluaran_integritas',
                'c_rc_int_ukur_io','c_rc_int_pantau_ttv','c_rc_int_mual_muntah',
                'c_rc_int_periksa_pembalut','c_rc_int_pantau_suhu',
                'c_rc_eval_ttv_normal','c_rc_eval_input','c_rc_eval_output',
                'c_rc_eval_mukosa_lembab','c_rc_eval_turgor_elastis','c_rc_paraf','c_rc_nama',
                // C3
                'c_rd_pemajanan_peralatan','c_rd_hipoksia_jaringan',
                'c_rd_int_lepas_gigi','c_rd_int_periksa_identitas','c_rd_int_brankar',
                'c_rd_int_sabuk','c_rd_int_peralatan_posisi','c_rd_int_keamanan_elektrikal',
                'c_rd_int_plate_diatermi','c_rd_int_pantau_io','c_rd_int_catat_kassa',
                'c_rd_eval_posisi','c_rd_eval_alat_elektro','c_rd_eval_kassa','c_rd_paraf','c_rd_nama',
                // C4
                'c_ri_trauma_post','c_ri_pemajanan_lingkungan','c_ri_pemajanan_peralatan',
                'c_ri_int_cuci_tangan','c_ri_int_desinfeksi','c_ri_int_kadaluarsa',
                'c_ri_int_sterilitas','c_ri_int_tutup_luka','c_ri_eval_lingkungan_steril',
                'c_ri_paraf','c_ri_nama',
                // D
                'd_ruang_pemulihan_ya','d_ruang_pemulihan_tidak','d_masuk_jam','d_keluar_jam',
                'd_kembali_ruangan','d_kembali_icu','d_kembali_lainnya',
                'd_keadaan_baik','d_keadaan_sedang','d_keadaan_buruk',
                'd_kesadaran_cm','d_kesadaran_apatis','d_kesadaran_somnolen','d_kesadaran_sopor','d_kesadaran_koma',
                'd_kulit_datang_kering','d_kulit_datang_merah_muda','d_kulit_datang_hangat',
                'd_kulit_keluar_kering','d_kulit_keluar_merah_muda','d_kulit_keluar_hangat',
                'd_sirkulasi_merah_muda','d_sirkulasi_kebiruan',
                'd_posisi_lateral','d_posisi_datar','d_posisi_head_up','d_posisi_semi_fowler',
                'd_perdarahan_ya','d_perdarahan_cc','d_perdarahan_tidak','d_perdarahan_lokasi',
                'd_muntah_ya','d_muntah_tidak','d_mukosa_lembab','d_mukosa_kering',
                'd_jaringan_pa_ya','d_jaringan_pa_tidak','d_jaringan_pa_k_bedah',
                'd_jaringan_pa_ruangan','d_jaringan_pa_jumlah',
                'd_nyeri_ya','d_nyeri_tidak','d_jatuh_ringan','d_jatuh_sedang','d_jatuh_tinggi',
                'd_nadi_teratur_masuk','d_nadi_teratur_keluar','d_nadi_tidak_teratur_masuk',
                'd_nadi_tidak_teratur_keluar','d_nadi_lemah_masuk','d_nadi_lemah_keluar',
                'd_nadi_takikardia_masuk','d_nadi_takikardia_keluar','d_nadi_normal_masuk','d_nadi_normal_keluar',
                'd_nafas_teratur_masuk','d_nafas_teratur_keluar','d_nafas_tidak_teratur_masuk',
                'd_nafas_tidak_teratur_keluar','d_nafas_dangkal_masuk','d_nafas_dangkal_keluar',
                'd_nafas_dalam_masuk','d_nafas_dalam_keluar','d_nafas_sukar_masuk','d_nafas_sukar_keluar',
                // E
                'e_na_gangguan_kulit','e_na_selang_drain',
                'e_na_int_kaji_lokasi','e_na_int_kaji_ttv','e_na_int_atur_posisi','e_na_int_relaksasi',
                'e_na_eval_ttv_normal','e_na_eval_nyeri_terkontrol','e_na_eval_nyeri_berkurang','e_na_eval_observasi_ruangan',
                'e_ri_trauma_post','e_ri_pemajanan_lingkungan','e_ri_pemajanan_peralatan',
                'e_ri_int_cuci_tangan','e_ri_int_desinfeksi','e_ri_int_kadaluarsa','e_ri_int_sterilitas','e_ri_int_tutup_luka',
                'e_ri_eval_lingkungan_steril','e_ri_paraf','e_ri_nama',
                'e_rs_suhu_rendah','e_rs_penggunaan_obat','e_rs_dehidrasi',
                'e_rs_int_catat_suhu','e_rs_int_kaji_suhu','e_rs_int_kolaborasi_obat',
                'e_rs_eval_dingin_berkurang','e_rs_eval_tidak_menggigil','e_rs_eval_suhu',
                // F
                'f_ttd_perawat_instrumen','f_nama_perawat_instrumen',
                'f_ttd_perawat_sirkuler','f_nama_perawat_sirkuler',
                'f_ttd_perawat_anestesi','f_nama_perawat_anestesi',
            ]);
        });
    }
}
