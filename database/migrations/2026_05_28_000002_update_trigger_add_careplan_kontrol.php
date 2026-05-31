<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Update fn_notify_registrasi_upsert: tambah EVENT 4 careplan_kontrol.
 *
 * Event ini dipicu ketika:
 *   - status_dokter baru saja berubah ke 'Sudah Diperiksa'
 *   - Encounter sudah ada (satusehat_encounter_id IS NOT NULL)
 *   - CarePlan kontrol belum pernah di-sync (satusehat_careplan_kontrol_id IS NULL)
 *   - Ada jadwal kontrol di pemeriksaan_dokter (tanggal_kontrol_selanjutnya IS NOT NULL)
 *
 * Catatan: Event ini dapat aktif bersamaan dengan encounter_dokter dari UPDATE yang sama.
 * Job handler memvalidasi ulang kondisi sebelum memanggil API.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS \$\$
BEGIN

    -- ── EVENT 1: encounter_post ────────────────────────────────────────────────
    -- POST Encounter baru saat CS mendaftarkan pasien.
    -- Berlaku untuk INSERT (registrasi baru) maupun UPDATE (data diubah sebelum RO).
    -- Catatan: jangan pakai OLD.* di sini — saat INSERT, OLD adalah NULL.
    IF TG_OP IN ('INSERT', 'UPDATE')
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NULL
       AND COALESCE(NEW.status_ro, '') = 'Belum Diperiksa'
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

    -- ── EVENT 4: careplan_kontrol ──────────────────────────────────────────────
    -- POST CarePlan untuk jadwal kontrol (tanggal_kontrol_selanjutnya).
    -- Dipicu bersamaan dengan encounter_dokter, tetapi hanya jika ada jadwal kontrol.
    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NOT NULL
       AND NEW.satusehat_careplan_kontrol_id IS NULL
       AND COALESCE(NEW.status_dokter, '') = 'Sudah Diperiksa'
       AND COALESCE(OLD.status_dokter, '') = 'Belum Diperiksa'
       AND EXISTS (
           SELECT 1 FROM pemeriksaan_dokter
           WHERE registrasi_uuid = NEW.uuid
             AND tanggal_kontrol_selanjutnya IS NOT NULL
       )
    THEN
        PERFORM pg_notify(
            'satusehat_registrasi_upsert',
            json_build_object(
                'uuid',                   NEW.uuid,
                'nomor',                  NEW.nomor,
                'event',                  'careplan_kontrol',
                'satusehat_encounter_id', NEW.satusehat_encounter_id
            )::text
        );
    END IF;

    RETURN NEW;
END;
\$\$ LANGUAGE plpgsql;

-- Trigger AFTER INSERT OR UPDATE — INSERT untuk menangkap registrasi baru (encounter_post)
DROP TRIGGER IF EXISTS trg_registrasi_upsert ON registrasi;
CREATE TRIGGER trg_registrasi_upsert
    AFTER INSERT OR UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_registrasi_upsert();
        ");
    }

    public function down(): void
    {
        // Kembalikan ke versi 3-event (tanpa careplan_kontrol)
        DB::unprepared("
CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS \$\$
BEGIN

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
        PERFORM pg_notify('satusehat_registrasi_upsert',
            json_build_object('uuid', NEW.uuid, 'nomor', NEW.nomor,
                'event', 'encounter_post',
                'satusehat_encounter_id', NEW.satusehat_encounter_id,
                'satusehat_encounter_status', NEW.satusehat_encounter_status)::text);
    END IF;

    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NOT NULL
       AND COALESCE(NEW.status_ro, '') = 'Sudah Diperiksa RO'
       AND (OLD.status_ro IS DISTINCT FROM 'Sudah Diperiksa RO')
    THEN
        PERFORM pg_notify('satusehat_registrasi_upsert',
            json_build_object('uuid', NEW.uuid, 'nomor', NEW.nomor,
                'event', 'encounter_ro',
                'satusehat_encounter_id', NEW.satusehat_encounter_id)::text);
    END IF;

    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND NEW.satusehat_encounter_id IS NOT NULL
       AND COALESCE(NEW.status_dokter, '') = 'Sudah Diperiksa'
       AND COALESCE(OLD.status_dokter, '') = 'Belum Diperiksa'
    THEN
        PERFORM pg_notify('satusehat_registrasi_upsert',
            json_build_object('uuid', NEW.uuid, 'nomor', NEW.nomor,
                'event', 'encounter_dokter',
                'satusehat_encounter_id', NEW.satusehat_encounter_id)::text);
    END IF;

    RETURN NEW;
END;
\$\$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_registrasi_upsert ON registrasi;
CREATE TRIGGER trg_registrasi_upsert
    AFTER UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_registrasi_upsert();
        ");
    }
};
