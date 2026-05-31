<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom FHIR Encounter status ke tabel registrasi
 * dan buat tabel history riwayat perubahan status encounter.
 *
 * Status FHIR Encounter (outpatient):
 *   arrived    → pasien tiba / mendaftar (default saat pertama POST)
 *   in-progress → pasien sedang diperiksa
 *   finished   → pemeriksaan/kunjungan selesai
 *   cancelled  → registrasi dibatalkan
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Kolom FHIR status di registrasi ──────────────────────────────
        Schema::table('registrasi', function (Blueprint $table) {
            // FHIR Encounter status (beda dengan sync status)
            $table->string('satusehat_encounter_fhir_status', 20)
                  ->nullable()
                  ->default('arrived')
                  ->after('satusehat_encounter_status')
                  ->comment('FHIR Encounter status: arrived | in-progress | finished | cancelled');
        });

        // ── 2. Tabel riwayat status encounter ────────────────────────────────
        Schema::create('satusehat_encounter_status_history', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('registrasi_uuid', 36)
                  ->comment('FK ke registrasi.uuid');

            $table->string('satusehat_encounter_id', 64)
                  ->nullable()
                  ->comment('FHIR Encounter ID dari SatuSehat');

            // Status FHIR
            $table->string('status', 20)
                  ->comment('arrived | in-progress | finished | cancelled');

            // Period sesuai FHIR Encounter.statusHistory[].period
            $table->timestampTz('period_start')
                  ->comment('Waktu mulai status ini berlaku');
            $table->timestampTz('period_end')
                  ->nullable()
                  ->comment('Waktu status berakhir — diisi saat status berikutnya dicatat');

            $table->text('catatan')->nullable()
                  ->comment('Catatan opsional perubahan status');

            $table->string('updated_by', 150)->nullable()
                  ->comment('Nama/email user yang mengubah status');

            $table->timestampTz('created_at')->useCurrent();

            // Index
            $table->index('registrasi_uuid', 'idx_ss_enc_hist_reg_uuid');
            $table->index('satusehat_encounter_id', 'idx_ss_enc_hist_enc_id');
            $table->index(['registrasi_uuid', 'status'], 'idx_ss_enc_hist_reg_status');
        });
    }

    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn('satusehat_encounter_fhir_status');
        });

        Schema::dropIfExists('satusehat_encounter_status_history');
    }
};
