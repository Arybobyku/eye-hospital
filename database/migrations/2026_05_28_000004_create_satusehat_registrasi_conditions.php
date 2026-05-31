<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambah kolom SatuSehat Condition ke tabel pemeriksaan_dokter_icdten.
 *
 * Menyimpan FHIR Condition ID yang sudah di-POST ke SatuSehat
 * langsung di baris ICD-10 yang bersangkutan, sehingga tidak
 * perlu tabel terpisah.
 *
 * Kolom baru:
 *   - satusehat_condition_id  : FHIR Condition.id dari response SatuSehat
 *   - satusehat_encounter_id  : Encounter yang menjadi konteks Condition ini
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
ALTER TABLE pemeriksaan_dokter_icdten
  ADD COLUMN IF NOT EXISTS satusehat_condition_id  VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_encounter_id  VARCHAR(64)  DEFAULT NULL;

COMMENT ON COLUMN pemeriksaan_dokter_icdten.satusehat_condition_id  IS 'FHIR Condition.id yang dikembalikan API SatuSehat setelah POST /Condition';
COMMENT ON COLUMN pemeriksaan_dokter_icdten.satusehat_encounter_id  IS 'FHIR Encounter.id yang menjadi konteks Condition ini';

-- Index untuk cek idempoten: lookup baris ICD-10 yang sudah di-sync
CREATE INDEX IF NOT EXISTS idx_pdi_ss_condition
    ON pemeriksaan_dokter_icdten (registrasi_uuid, satusehat_condition_id)
    WHERE satusehat_condition_id IS NOT NULL;
        ");
    }

    public function down(): void
    {
        DB::unprepared("
DROP INDEX IF EXISTS idx_pdi_ss_condition;

ALTER TABLE pemeriksaan_dokter_icdten
  DROP COLUMN IF EXISTS satusehat_condition_id,
  DROP COLUMN IF EXISTS satusehat_encounter_id;
        ");
    }
};
