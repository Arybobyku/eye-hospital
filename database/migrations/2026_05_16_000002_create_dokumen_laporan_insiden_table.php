<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenLaporanInsidenTable extends Migration
{
    public function up()
    {
        Schema::create('dokumen_laporan_insiden', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('uuid_pasien', 36)->nullable()->index();

            // Identitas Pasien (wajib)
            $table->string('no_rm', 50)->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->string('jenis_kelamin', 5)->nullable();
            $table->string('nama', 200)->nullable();
            $table->string('nik', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Header
            $table->string('ruangan', 100)->nullable();

            // I. Data Pasien - Umur (checkboxes)
            $table->boolean('umur_0_1_bulan')->default(false);
            $table->boolean('umur_1_bulan_1_tahun')->default(false);
            $table->boolean('umur_1_5_tahun')->default(false);
            $table->boolean('umur_5_15_tahun')->default(false);
            $table->boolean('umur_15_30_tahun')->default(false);
            $table->boolean('umur_30_65_tahun')->default(false);
            $table->boolean('umur_65_plus')->default(false);

            // Penanggung biaya
            $table->boolean('biaya_pribadi')->default(false);
            $table->boolean('biaya_asuransi_swasta')->default(false);
            $table->boolean('biaya_perusahaan')->default(false);
            $table->boolean('biaya_bpjs')->default(false);

            // Tanggal Masuk RS
            $table->date('tanggal_masuk_rs')->nullable();
            $table->string('jam_masuk_rs', 10)->nullable();

            // II. Rincian Kejadian
            $table->date('insiden_tanggal')->nullable();
            $table->string('insiden_jam', 10)->nullable();
            $table->text('insiden_deskripsi')->nullable();
            $table->text('kronologis_insiden')->nullable();

            // 4. Jenis Insiden
            $table->boolean('jenis_knc')->default(false);   // Kejadian Nyaris Cedera
            $table->boolean('jenis_ktc')->default(false);   // Kejadian Tidak Cedera
            $table->boolean('jenis_ktd')->default(false);   // Kejadian Tidak Diharapkan / KTD / Sentinel

            // 5. Orang Pertama Melaporkan
            $table->boolean('pelapor_karyawan')->default(false);
            $table->boolean('pelapor_pasien')->default(false);
            $table->boolean('pelapor_keluarga')->default(false);
            $table->boolean('pelapor_pengunjung')->default(false);
            $table->boolean('pelapor_lainnya')->default(false);
            $table->string('pelapor_lainnya_sebutkan', 255)->nullable();

            // 6. Insiden terjadi pada
            $table->boolean('terjadi_pada_pasien')->default(false);
            $table->boolean('terjadi_pada_lainnya')->default(false);
            $table->string('terjadi_pada_lainnya_sebutkan', 255)->nullable();

            // 7. Insiden menyangkut pasien
            $table->boolean('pasien_rawat_inap')->default(false);
            $table->boolean('pasien_rawat_jalan')->default(false);
            $table->boolean('pasien_igd')->default(false);
            $table->boolean('pasien_lainnya')->default(false);
            $table->string('pasien_lainnya_sebutkan', 255)->nullable();

            // 8. Tempat Insiden
            $table->string('lokasi_kejadian', 255)->nullable();

            // 9. Insiden terjadi pada pasien (spesialisasi)
            $table->boolean('spesialisasi_penyakit_mata')->default(false);
            $table->boolean('spesialisasi_lainnya')->default(false);
            $table->string('spesialisasi_lainnya_sebutkan', 255)->nullable();

            // 10. Unit / Departemen
            $table->string('unit_kerja_penyebab', 255)->nullable();

            // 11. Akibat Insiden
            $table->boolean('akibat_kematian')->default(false);
            $table->boolean('akibat_cedera_berat')->default(false);
            $table->boolean('akibat_cedera_sedang')->default(false);
            $table->boolean('akibat_cedera_ringan')->default(false);
            $table->boolean('akibat_tidak_cedera')->default(false);

            // 12. Tindakan segera
            $table->text('tindakan_hasil')->nullable();

            // 13. Tindakan dilakukan oleh
            $table->boolean('tindakan_tim')->default(false);
            $table->string('tindakan_tim_terdiri', 255)->nullable();
            $table->boolean('tindakan_dokter')->default(false);
            $table->boolean('tindakan_perawat')->default(false);
            $table->boolean('tindakan_petugas_lainnya')->default(false);
            $table->string('tindakan_petugas_lainnya_sebutkan', 255)->nullable();

            // 14. Kejadian yang sama pernah terjadi
            $table->boolean('kejadian_sama_ya')->default(false);
            $table->boolean('kejadian_sama_tidak')->default(false);
            $table->text('kejadian_sama_keterangan')->nullable();

            // Pembuat / Penerima Laporan
            $table->string('pembuat_laporan', 200)->nullable();
            $table->longText('pembuat_laporan_paraf')->nullable(); // base64 digital signature
            $table->date('tgl_terima')->nullable();
            $table->string('penerima_laporan', 200)->nullable();
            $table->longText('penerima_laporan_paraf')->nullable(); // base64 digital signature
            $table->date('tgl_lapor')->nullable();

            // Grading Risiko
            $table->boolean('grading_biru')->default(false);
            $table->boolean('grading_hijau')->default(false);
            $table->boolean('grading_kuning')->default(false);
            $table->boolean('grading_merah')->default(false);

            // Audit
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_laporan_insiden');
    }
}
