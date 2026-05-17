<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenCatatanKeperawatanOperasiTable extends Migration
{
    public function up()
    {
        Schema::create('dokumen_catatan_keperawatan_operasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('uuid_pasien', 36)->nullable()->index();

            // Identitas Pasien
            $table->string('no_rm', 50)->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->string('jenis_kelamin', 5)->nullable();
            $table->string('nama', 200)->nullable();
            $table->string('nik', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Waktu
            $table->string('jam_mulai', 10)->nullable();
            $table->string('jam_selesai', 10)->nullable();
            $table->string('jam_anestesi_mulai', 10)->nullable();
            $table->string('jam_anestesi_selesai', 10)->nullable();
            $table->string('jam_pembedahan_mulai', 10)->nullable();
            $table->string('jam_pembedahan_selesai', 10)->nullable();

            // 1. Tipe operasi
            $table->boolean('tipe_elektif')->default(false);
            $table->boolean('tipe_darurat')->default(false);
            $table->boolean('tipe_rawat_jalan')->default(false);

            // 2. Jenis pembiusan
            $table->boolean('biusan_umum')->default(false);
            $table->boolean('biusan_lokal')->default(false);
            $table->boolean('biusan_regional')->default(false);

            // 3. Kesadaran
            $table->boolean('kesadaran_terjaga')->default(false);
            $table->boolean('kesadaran_mudah_dibangunkan')->default(false);
            $table->string('kesadaran_lainnya', 100)->nullable();

            // 4. Status emosi
            $table->boolean('emosi_rileks')->default(false);
            $table->boolean('emosi_gelisah')->default(false);
            $table->boolean('emosi_tidak_ada_respon')->default(false);

            // 5. Posisi canul intravena
            $table->boolean('canul_tangan')->default(false);
            $table->boolean('canul_kaki')->default(false);
            $table->boolean('canul_cvp')->default(false);
            $table->string('canul_lainnya', 100)->nullable();

            // 6. Jenis operasi
            $table->boolean('jenis_op_bersih')->default(false);
            $table->boolean('jenis_op_terkontaminasi')->default(false);
            $table->boolean('jenis_op_bersih_terkontaminasi')->default(false);
            $table->boolean('jenis_op_kotor_infeksi')->default(false);

            // 7. Posisi operasi
            $table->boolean('posisi_supine')->default(false);
            $table->boolean('posisi_prone')->default(false);
            $table->boolean('posisi_lithotomi')->default(false);
            $table->boolean('posisi_kidney')->default(false);
            $table->boolean('posisi_lateral')->default(false);
            $table->string('posisi_lainnya', 100)->nullable();
            $table->string('posisi_diawasi_oleh', 200)->nullable();

            // 8. Posisi selengantangan
            $table->boolean('selengantangan_adduksi')->default(false);
            $table->boolean('selengantangan_abduksi')->default(false);
            $table->string('selengantangan_lainnya', 100)->nullable();

            // 9. Urine Catheter
            $table->boolean('urine_ya')->default(false);
            $table->boolean('urine_tidak')->default(false);
            $table->boolean('urine_ok')->default(false);
            $table->boolean('urine_ruangan')->default(false);
            $table->string('urine_dipasang_oleh', 200)->nullable();
            $table->string('urine_jenis', 100)->nullable();

            // 10. Desinfeksi kulit
            $table->boolean('desinfeksi_iodium')->default(false);
            $table->boolean('desinfeksi_alkohol')->default(false);
            $table->boolean('desinfeksi_povidone')->default(false);
            $table->boolean('desinfeksi_chlorhexidine')->default(false);

            // 11. Insisi kulit
            $table->boolean('insisi_pfannenstiel')->default(false);
            $table->string('insisi_lainnya', 100)->nullable();

            // 12. Alat bantu
            $table->boolean('alat_hand_rest')->default(false);
            $table->boolean('alat_lithotomi_support')->default(false);
            $table->boolean('alat_lateral_support')->default(false);
            $table->boolean('alat_chest_support')->default(false);
            $table->boolean('alat_heat_frame')->default(false);
            $table->string('alat_lainnya', 100)->nullable();

            // 13. Diatermi
            $table->boolean('diatermi_ya')->default(false);
            $table->boolean('diatermi_tidak')->default(false);
            $table->boolean('diatermi_monopolar')->default(false);
            $table->boolean('diatermi_bipolar')->default(false);
            $table->boolean('diatermi_netral_bokong')->default(false);
            $table->boolean('diatermi_netral_tungkai_atas')->default(false);
            $table->boolean('diatermi_netral_tungkai_bawah')->default(false);
            $table->boolean('diatermi_netral_punggung')->default(false);
            $table->boolean('diatermi_netral_bahu')->default(false);
            $table->string('diatermi_dipasang_oleh', 200)->nullable();
            $table->boolean('diatermi_kulit_sbl_utuh')->default(false);
            $table->boolean('diatermi_kulit_sbl_bulosa')->default(false);
            $table->boolean('diatermi_kulit_sbl_eritema')->default(false);
            $table->boolean('diatermi_kulit_sbl_luka_bakar')->default(false);
            $table->boolean('diatermi_kulit_ssd_utuh')->default(false);
            $table->boolean('diatermi_kulit_ssd_bulosa')->default(false);
            $table->boolean('diatermi_kulit_ssd_eritema')->default(false);
            $table->boolean('diatermi_kulit_ssd_luka_bakar')->default(false);

            // 14. Warm blanket
            $table->boolean('warm_blanket_ya')->default(false);
            $table->boolean('warm_blanket_tidak')->default(false);
            $table->string('warm_blanket_jenis', 100)->nullable();
            $table->string('warm_blanket_jam_mulai', 10)->nullable();
            $table->string('warm_blanket_jam_selesai', 10)->nullable();

            // 15. Tourniquet
            $table->boolean('tourniquet_ya')->default(false);
            $table->boolean('tourniquet_tidak')->default(false);
            $table->string('tourniquet_lokasi', 100)->nullable();
            $table->boolean('tourniquet_lengan')->default(false);
            $table->string('tourniquet_lengan_jam_mulai', 10)->nullable();
            $table->string('tourniquet_lengan_jam_selesai', 10)->nullable();
            $table->string('tourniquet_lengan_td', 20)->nullable();
            $table->string('tourniquet_dipasang_oleh', 200)->nullable();
            $table->boolean('tourniquet_kaki')->default(false);
            $table->string('tourniquet_kaki_jam_mulai', 10)->nullable();
            $table->string('tourniquet_kaki_jam_selesai', 10)->nullable();
            $table->string('tourniquet_kaki_td', 20)->nullable();

            // 16. Implant
            $table->boolean('implant_ya')->default(false);
            $table->boolean('implant_tidak')->default(false);
            $table->string('implant_jenis', 200)->nullable();
            $table->string('implant_lokasi', 200)->nullable();

            // 17. Drain
            $table->boolean('drain_ya')->default(false);
            $table->boolean('drain_tidak')->default(false);
            $table->string('drain_jenis', 200)->nullable();
            $table->string('drain_lokasi', 200)->nullable();

            // 18. Irigasi Luka
            $table->boolean('irigasi_ya')->default(false);
            $table->boolean('irigasi_tidak')->default(false);
            $table->boolean('irigasi_nacl')->default(false);
            $table->boolean('irigasi_h2o2')->default(false);
            $table->boolean('irigasi_antibiotik')->default(false);
            $table->string('irigasi_lainnya', 100)->nullable();

            // 19. Tampon
            $table->boolean('tampon_ya')->default(false);
            $table->boolean('tampon_tidak')->default(false);
            $table->string('tampon_lokasi', 200)->nullable();
            $table->string('tampon_jumlah', 50)->nullable();

            // 20. Spesimen
            $table->boolean('spesimen_histology')->default(false);
            $table->string('spesimen_histology_jenis', 200)->nullable();
            $table->boolean('spesimen_kultur')->default(false);
            $table->string('spesimen_kultur_jenis', 200)->nullable();
            $table->boolean('spesimen_cytologi')->default(false);
            $table->string('spesimen_cytologi_jenis', 200)->nullable();
            $table->boolean('spesimen_frozen')->default(false);
            $table->string('spesimen_frozen_jenis', 200)->nullable();

            // 21. Cairan infus (JSON rows)
            $table->text('cairan_infus')->nullable(); // JSON: [{cairan,input,output,total}]

            // 22-24. Kassa, Jarum, Bisturi
            $table->string('kassa_sebelum', 20)->nullable();
            $table->string('kassa_penambahan', 20)->nullable();
            $table->string('kassa_setelah', 20)->nullable();
            $table->string('jarum_sebelum', 20)->nullable();
            $table->string('jarum_penambahan', 20)->nullable();
            $table->string('jarum_setelah', 20)->nullable();
            $table->string('bisturi_sebelum', 20)->nullable();
            $table->string('bisturi_penambahan', 20)->nullable();
            $table->string('bisturi_setelah', 20)->nullable();

            // B. Kasa & Alat Instrumen
            $table->string('kasa_besar_persediaan', 20)->nullable();
            $table->string('kasa_besar_terpakai', 20)->nullable();
            $table->string('kasa_besar_sisa', 20)->nullable();
            $table->string('kasa_besar_keterangan', 200)->nullable();
            $table->string('kasa_persediaan', 20)->nullable();
            $table->string('kasa_terpakai', 20)->nullable();
            $table->string('kasa_sisa', 20)->nullable();
            $table->string('kasa_keterangan', 200)->nullable();
            $table->string('kasa_kacang_persediaan', 20)->nullable();
            $table->string('kasa_kacang_terpakai', 20)->nullable();
            $table->string('kasa_kacang_sisa', 20)->nullable();
            $table->string('kasa_kacang_keterangan', 200)->nullable();
            $table->string('kasa_tampon_persediaan', 20)->nullable();
            $table->string('kasa_tampon_terpakai', 20)->nullable();
            $table->string('kasa_tampon_sisa', 20)->nullable();
            $table->string('kasa_tampon_keterangan', 200)->nullable();
            $table->string('instrumen_persediaan', 20)->nullable();
            $table->string('instrumen_terpakai', 20)->nullable();
            $table->string('instrumen_sisa', 20)->nullable();
            $table->string('instrumen_keterangan', 200)->nullable();
            $table->string('jarum_atraumatik_persediaan', 20)->nullable();
            $table->string('jarum_atraumatik_terpakai', 20)->nullable();
            $table->string('jarum_atraumatik_sisa', 20)->nullable();
            $table->string('jarum_atraumatik_keterangan', 200)->nullable();
            $table->string('jarum_lepas_persediaan', 20)->nullable();
            $table->string('jarum_lepas_terpakai', 20)->nullable();
            $table->string('jarum_lepas_sisa', 20)->nullable();
            $table->string('jarum_lepas_keterangan', 200)->nullable();
            $table->string('selang_persediaan', 20)->nullable();
            $table->string('selang_terpakai', 20)->nullable();
            $table->string('selang_sisa', 20)->nullable();
            $table->string('selang_keterangan', 200)->nullable();

            // TTD
            $table->longText('ttd_dokter_operator')->nullable();
            $table->string('nama_dokter_operator', 200)->nullable();
            $table->longText('ttd_perawat_instrumen')->nullable();
            $table->string('nama_perawat_instrumen', 200)->nullable();
            $table->longText('ttd_perawat_sirkuler')->nullable();
            $table->string('nama_perawat_sirkuler', 200)->nullable();

            // Audit
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_catatan_keperawatan_operasi');
    }
}
