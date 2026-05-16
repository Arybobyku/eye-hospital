<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenLaporanOperasiTable extends Migration
{
    public function up()
    {
        Schema::create('dokumen_laporan_operasi', function (Blueprint $table) {
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

            // Tim Operasi
            $table->string('ahli_bedah', 200)->nullable();
            $table->string('asisten_dokter', 200)->nullable();
            $table->string('ahli_anestesi', 200)->nullable();
            $table->string('instrumen', 200)->nullable();

            // Diagnosa & Waktu
            $table->text('diagnosa_prabedah')->nullable();
            $table->text('diagnosa_pasca_bedah')->nullable();
            $table->string('pembedahan_mulai_pukul', 10)->nullable();
            $table->string('pembedahan_selesai_pukul', 10)->nullable();
            $table->string('lama_tindakan', 50)->nullable();
            $table->date('tanggal')->nullable();

            // Jenis Pembedahan
            $table->text('jenis_pembedahan')->nullable();
            $table->text('macam_pembedahan')->nullable();

            // Checkboxes Jenis
            $table->boolean('jenis_besar')->default(false);
            $table->boolean('jenis_sedang')->default(false);
            $table->boolean('jenis_kecil')->default(false);

            // Checkboxes Tipe
            $table->boolean('tipe_elektif')->default(false);
            $table->boolean('tipe_emergency')->default(false);
            $table->boolean('tipe_khusus')->default(false);

            // Transfusi
            $table->boolean('transfusi_tidak')->default(false);
            $table->boolean('transfusi_ya')->default(false);
            $table->string('transfusi_jenis_jumlah', 255)->nullable();

            // Implan
            $table->boolean('implan_tidak')->default(false);
            $table->boolean('implan_ya')->default(false);
            $table->string('implan_jenis_jumlah', 255)->nullable();

            // Uraian Pembedahan
            $table->longText('uraian_pembedahan')->nullable();

            // Page 2
            $table->text('komplikasi_intra_operasi')->nullable();
            $table->text('konsultasi_intra_operasi')->nullable();
            $table->string('jumlah_perdarahan', 100)->nullable();

            // Jaringan ke Patologi
            $table->boolean('jaringan_patologi_ya')->default(false);
            $table->boolean('jaringan_patologi_tidak')->default(false);

            // Tanda Tangan
            $table->longText('ttd_dokter')->nullable();
            $table->string('nama_dokter', 200)->nullable();
            $table->string('dokter_ttd_timestamp', 50)->nullable();

            // Audit
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_laporan_operasi');
    }
}
