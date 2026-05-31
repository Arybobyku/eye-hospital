<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migrasi: ganti fn_notify_registrasi_upsert menjadi versi 3-event.
 *
 * Perubahan dari versi sebelumnya:
 *   - Hapus penanganan INSERT — hanya UPDATE yang diproses
 *   - 3 event spesifik menggantikan 1 event generik:
 *       encounter_post   → POST Encounter baru (belum punya ID, status_ro = 'Belum Diperiksa')
 *       encounter_ro     → PUT in-progress (status_ro berubah ke 'Sudah Diperiksa RO')
 *       encounter_dokter → PUT finished (status_dokter berubah ke 'Sudah Diperiksa')
 *   - Trigger diubah dari AFTER INSERT OR UPDATE menjadi AFTER UPDATE saja
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
-- ── Ganti fungsi trigger dengan versi 3-event ────────────────────────────────
CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS \$\$
BEGIN

    -- ── EVENT 1: encounter_post ────────────────────────────────────────────────
    -- POST Encounter baru saat CS mendaftarkan pasien.
    -- Kondisi: aktif, belum punya Encounter ID, masih di tahap RO awal,
    --          ada perubahan field yang relevan untuk sync.
    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NULL
       AND COALESCE(NEW.status_ro, '') = 'Belum Diperiksa'
       AND (
           NEW.satusehat_location_id        IS DISTINCT FROM OLD.satusehat_location_id
           OR NEW.satusehat_encounter_status IS DISTINCT FROM OLD.satusehat_encounter_status
           OR NEW.pasien_uuid               IS DISTINCT FROM OLD.pasien_uuid
           OR NEW.pengguna_uuid             IS DISTINCT FROM OLD.pengguna_uuid
           OR NEW.tanggal                   IS DISTINCT FROM OLD.tanggal
           OR NEW.waktu                     IS DISTINCT FROM OLD.waktu
       )
    THEN
        PERFORM pg_notify(
            'satusehat_registrasi_upsert',
            json_build_object(
                'uuid',                       NEW.uuid,
                'nomor',                      NEW.nomor,
                'event',                      'encounter_post',
                'satusehat_encounter_id',     NEW.satusehat_encounter_id,
                'satusehat_encounter_status', NEW.satusehat_encounter_status
            )::text
        );
    END IF;

    -- ── EVENT 2: encounter_ro ──────────────────────────────────────────────────
    -- PUT Encounter -> in-progress saat pemeriksaan Refraksi Optisi selesai.
    -- Kondisi: aktif, sudah punya Encounter ID, status_ro baru saja berubah ke 'Sudah Diperiksa RO'.
    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NOT NULL
       AND COALESCE(NEW.status_ro, '') = 'Sudah Diperiksa RO'
       AND (OLD.status_ro IS DISTINCT FROM 'Sudah Diperiksa RO')
    THEN
        PERFORM pg_notify(
            'satusehat_registrasi_upsert',
            json_build_object(
                'uuid',                   NEW.uuid,
                'nomor',                  NEW.nomor,
                'event',                  'encounter_ro',
                'satusehat_encounter_id', NEW.satusehat_encounter_id
            )::text
        );
    END IF;

    -- ── EVENT 3: encounter_dokter ──────────────────────────────────────────────
    -- PUT Encounter -> finished saat dokter selesai memeriksa pasien.
    -- Kondisi: aktif, sudah punya Encounter ID,
    --          status_dokter berubah DARI 'Belum Diperiksa' KE 'Sudah Diperiksa'.
    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NOT NULL
       AND COALESCE(NEW.status_dokter, '') = 'Sudah Diperiksa'
       AND COALESCE(OLD.status_dokter, '') = 'Belum Diperiksa'
    THEN
        PERFORM pg_notify(
            'satusehat_registrasi_upsert',
            json_build_object(
                'uuid',                   NEW.uuid,
                'nomor',                  NEW.nomor,
                'event',                  'encounter_dokter',
                'satusehat_encounter_id', NEW.satusehat_encounter_id
            )::text
        );
    END IF;

    RETURN NEW;
END;
\$\$ LANGUAGE plpgsql;

-- ── Ganti trigger — hanya AFTER UPDATE (INSERT tidak lagi diproses) ───────────
DROP TRIGGER IF EXISTS trg_registrasi_upsert ON registrasi;
CREATE TRIGGER trg_registrasi_upsert
    AFTER UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_registrasi_upsert();
        ");
    }

    public function down(): void
    {
        // Kembalikan ke versi sebelumnya (INSERT + UPDATE generik)
        DB::unprepared("
CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS \$\$
DECLARE
    v_event TEXT;
BEGIN
    IF TG_OP = 'INSERT' THEN v_event := 'insert'; ELSE v_event := 'update'; END IF;

    IF TG_OP = 'INSERT' AND NEW.delete_soft = 1 THEN
        PERFORM pg_notify('satusehat_registrasi_upsert',
            json_build_object('uuid', NEW.uuid, 'nomor', NEW.nomor,
                'satusehat_encounter_id', NEW.satusehat_encounter_id,
                'satusehat_encounter_status', NEW.satusehat_encounter_status,
                'event', v_event)::text);
    END IF;

    IF TG_OP = 'UPDATE' AND NEW.delete_soft = 1 AND (
        NEW.satusehat_encounter_id IS NULL OR
        NEW.satusehat_encounter_status IN ('failed','waiting_patient','no_location')
    ) THEN
        IF NEW.satusehat_location_id IS DISTINCT FROM OLD.satusehat_location_id
           OR NEW.satusehat_encounter_status IS DISTINCT FROM OLD.satusehat_encounter_status
           OR NEW.pasien_uuid IS DISTINCT FROM OLD.pasien_uuid
        THEN
            PERFORM pg_notify('satusehat_registrasi_upsert',
                json_build_object('uuid', NEW.uuid, 'nomor', NEW.nomor,
                    'satusehat_encounter_id', NEW.satusehat_encounter_id,
                    'satusehat_encounter_status', NEW.satusehat_encounter_status,
                    'event', v_event)::text);
        END IF;
    END IF;
    RETURN NEW;
END;
\$\$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_registrasi_upsert ON registrasi;
CREATE TRIGGER trg_registrasi_upsert
    AFTER INSERT OR UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_registrasi_upsert();
        ");
    }
};
