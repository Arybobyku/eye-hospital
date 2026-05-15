<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_status_oftalmologis', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('uuid_pasien', 64)->nullable()->index();

            // ── Identitas Pasien (wajib) ───────────────────────────────────
            $table->string('no_rm', 50)->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->string('jenis_kelamin', 1)->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('nik', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();

            // ── Kunjungan ──────────────────────────────────────────────────
            $table->date('tanggal_kunjungan')->nullable();
            $table->string('jam_kunjungan', 10)->nullable();

            // ── OCULAR DEXTRA (OD) ─────────────────────────────────────────
            $table->string('od_pd', 20)->nullable();
            $table->string('od_autoref_s', 20)->nullable();
            $table->string('od_autoref_c', 20)->nullable();
            $table->string('od_autoref_x', 20)->nullable();
            $table->string('od_kk1', 20)->nullable();
            $table->string('od_kk1_axis', 20)->nullable();
            $table->string('od_kk2', 20)->nullable();
            $table->string('od_kk2_axis', 20)->nullable();
            $table->string('od_tonometri', 20)->nullable();
            $table->string('od_visus', 30)->nullable();
            $table->string('od_bcva', 30)->nullable();
            $table->string('od_add', 20)->nullable();
            $table->string('od_kacamata_sph', 20)->nullable();
            $table->string('od_kacamata_cyl', 20)->nullable();
            $table->string('od_kacamata_x', 20)->nullable();
            $table->string('od_kacamata_addisi', 20)->nullable();

            // ── OCULAR SINISTRA (OS) ───────────────────────────────────────
            $table->string('os_pd', 20)->nullable();
            $table->string('os_autoref_s', 20)->nullable();
            $table->string('os_autoref_c', 20)->nullable();
            $table->string('os_autoref_x', 20)->nullable();
            $table->string('os_kk1', 20)->nullable();
            $table->string('os_kk1_axis', 20)->nullable();
            $table->string('os_kk2', 20)->nullable();
            $table->string('os_kk2_axis', 20)->nullable();
            $table->string('os_tonometri', 20)->nullable();
            $table->string('os_visus', 30)->nullable();
            $table->string('os_bcva', 30)->nullable();
            $table->string('os_add', 20)->nullable();
            $table->string('os_kacamata_sph', 20)->nullable();
            $table->string('os_kacamata_cyl', 20)->nullable();
            $table->string('os_kacamata_x', 20)->nullable();
            $table->string('os_kacamata_addisi', 20)->nullable();

            // ── Posisi & Pergerakan Bola Mata ─────────────────────────────
            $table->boolean('posisi_normal')->default(false);
            $table->longText('diagram_mata')->nullable();

            // ── Status Segmen Anterior & Posterior ───────────────────────
            // PALPEBRA
            $table->boolean('status_palpebra_od_normal')->default(false);
            $table->boolean('status_palpebra_os_normal')->default(false);
            $table->string('status_palpebra_ket', 255)->nullable();
            // CONJUNCTIVA
            $table->boolean('status_conjunctiva_od_normal')->default(false);
            $table->boolean('status_conjunctiva_os_normal')->default(false);
            $table->string('status_conjunctiva_ket', 255)->nullable();
            // CORNEA
            $table->boolean('status_cornea_od_normal')->default(false);
            $table->boolean('status_cornea_os_normal')->default(false);
            $table->string('status_cornea_ket', 255)->nullable();
            // BILIK MATA DEPAN
            $table->boolean('status_bmd_od_normal')->default(false);
            $table->boolean('status_bmd_os_normal')->default(false);
            $table->string('status_bmd_ket', 255)->nullable();
            // PUPIL DAN IRIS
            $table->boolean('status_pupil_iris_od_normal')->default(false);
            $table->boolean('status_pupil_iris_os_normal')->default(false);
            $table->string('status_pupil_iris_ket', 255)->nullable();
            // LENSA
            $table->boolean('status_lensa_od_normal')->default(false);
            $table->boolean('status_lensa_os_normal')->default(false);
            $table->string('status_lensa_ket', 255)->nullable();
            // VITREOUS
            $table->boolean('status_vitreous_od_normal')->default(false);
            $table->boolean('status_vitreous_os_normal')->default(false);
            $table->string('status_vitreous_ket', 255)->nullable();
            // FUNDUSCOPY
            $table->boolean('status_funduscopy_od_normal')->default(false);
            $table->boolean('status_funduscopy_os_normal')->default(false);
            $table->string('status_funduscopy_ket', 255)->nullable();

            // ── Klinis ────────────────────────────────────────────────────
            $table->text('pemeriksaan_penunjang')->nullable();
            $table->text('diagnose_kerja')->nullable();
            $table->string('diagnose_kerja_icd', 20)->nullable();
            $table->text('diagnose_banding')->nullable();
            $table->string('diagnose_banding_icd', 20)->nullable();
            $table->text('tata_laksana')->nullable();
            $table->text('perencanaan')->nullable();
            $table->string('prognosa', 255)->nullable();

            // ── Tanda Tangan ──────────────────────────────────────────────
            $table->longText('ttd_dokter')->nullable();
            $table->string('nama_dokter', 255)->nullable();
            $table->string('dokter_ttd_timestamp', 50)->nullable();

            // ── Audit ─────────────────────────────────────────────────────
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_status_oftalmologis');
    }
};
