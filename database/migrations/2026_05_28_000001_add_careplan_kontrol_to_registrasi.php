<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambah kolom CarePlan Kontrol ke tabel registrasi.
 *
 * Kolom ini dipakai untuk menyimpan hasil sinkronisasi CarePlan jadwal kontrol
 * (follow-up appointment) ke SatuSehat, terpisah dari careplan utama.
 *
 * Dipicu oleh event `careplan_kontrol` dari trigger fn_notify_registrasi_upsert()
 * ketika pemeriksaan_dokter.tanggal_kontrol_selanjutnya IS NOT NULL.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            ALTER TABLE registrasi
                ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_id         VARCHAR(64)  DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_status     VARCHAR(20)  DEFAULT NULL,
                ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_synced_at  TIMESTAMP    DEFAULT NULL;

            COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_id
                IS 'FHIR CarePlan.id untuk jadwal kontrol (tanggal_kontrol_selanjutnya)';
            COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_status
                IS 'Status sync CarePlan kontrol: null | waiting_encounter | synced | failed';
            COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_synced_at
                IS 'Waktu terakhir berhasil sync CarePlan kontrol ke SatuSehat';
        ");
    }

    public function down(): void
    {
        DB::unprepared("
            ALTER TABLE registrasi
                DROP COLUMN IF EXISTS satusehat_careplan_kontrol_id,
                DROP COLUMN IF EXISTS satusehat_careplan_kontrol_status,
                DROP COLUMN IF EXISTS satusehat_careplan_kontrol_synced_at;
        ");
    }
};
