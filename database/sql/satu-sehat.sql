-- ── Pasien: tambah kolom SatuSehat ──────────────────────────────────────────
ALTER TABLE pasien
  ADD COLUMN id_satu_sehat          VARCHAR(50)  DEFAULT NULL,
  ADD COLUMN satusehat_sync_status  VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN satusehat_synced_at    TIMESTAMP    DEFAULT NULL;

-- ── Registrasi: tambah kolom SatuSehat Encounter ─────────────────────────────
ALTER TABLE registrasi
  ADD COLUMN satusehat_encounter_id         VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN satusehat_encounter_status     VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN satusehat_encounter_synced_at  TIMESTAMP    DEFAULT NULL,
  ADD COLUMN satusehat_location_id          VARCHAR(64)  DEFAULT NULL;

-- ── Pengguna: tambah IHS Practitioner ID ─────────────────────────────────────
ALTER TABLE pengguna
  ADD COLUMN satusehat_ihs_id VARCHAR(64) DEFAULT NULL;

-- ── Pengguna: tambah NIK dan status sync Practitioner ────────────────────────
ALTER TABLE pengguna
  ADD COLUMN IF NOT EXISTS nik                    VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_sync_status  VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_synced_at    TIMESTAMP    DEFAULT NULL;

-- ── Cache wilayah SatuSehat (BPS codes) ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS satusehat_wilayah (
    id          BIGSERIAL PRIMARY KEY,
    level       VARCHAR(20)  NOT NULL,
    code        VARCHAR(20)  NOT NULL UNIQUE,
    name        VARCHAR(255) NOT NULL,
    parent_code VARCHAR(20)  DEFAULT NULL,
    raw_data    JSONB        DEFAULT NULL,
    fetched_at  TIMESTAMP    DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT NOW(),
    updated_at  TIMESTAMP    DEFAULT NOW()
);
CREATE INDEX IF NOT EXISTS idx_ss_wilayah_level  ON satusehat_wilayah (level);
CREATE INDEX IF NOT EXISTS idx_ss_wilayah_parent ON satusehat_wilayah (parent_code);

-- ── Pasien: tambah kode wilayah SatuSehat (BPS) ───────────────────────────────
ALTER TABLE pasien
  ADD COLUMN IF NOT EXISTS ss_province_code    VARCHAR(20) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS ss_city_code        VARCHAR(20) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS ss_district_code    VARCHAR(20) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS ss_subdistrict_code VARCHAR(20) DEFAULT NULL;

-- ── Master wilayah lokal: tambah kode BPS SatuSehat ──────────────────────────
ALTER TABLE provinsi  ADD COLUMN IF NOT EXISTS satusehat_code VARCHAR(20) DEFAULT NULL;
ALTER TABLE kab_kota  ADD COLUMN IF NOT EXISTS satusehat_code VARCHAR(20) DEFAULT NULL;
ALTER TABLE kecamatan ADD COLUMN IF NOT EXISTS satusehat_code VARCHAR(20) DEFAULT NULL;
ALTER TABLE kelurahan ADD COLUMN IF NOT EXISTS satusehat_code VARCHAR(20) DEFAULT NULL;

-- ── Pasien: hapus kolom ss_*_code (diganti relasi FK ke master wilayah) ─────────
-- Kolom ini sudah tidak dipakai; kode BPS diambil dari provinsi/kab_kota/kecamatan/kelurahan
-- via satusehat_code di masing-masing tabel master.
ALTER TABLE pasien
  DROP COLUMN IF EXISTS ss_province_code,
  DROP COLUMN IF EXISTS ss_city_code,
  DROP COLUMN IF EXISTS ss_district_code,
  DROP COLUMN IF EXISTS ss_subdistrict_code;

-- ── Log semua request/response ke SatuSehat API ───────────────────────────────
CREATE TABLE IF NOT EXISTS satusehat_api_logs (
    id            BIGSERIAL PRIMARY KEY,
    method        VARCHAR(10)   NOT NULL,
    url           TEXT          NOT NULL,
    request_body  TEXT          DEFAULT NULL,
    response_body TEXT          DEFAULT NULL,
    http_code     SMALLINT      DEFAULT NULL,
    context       VARCHAR(100)  DEFAULT NULL,
    duration_ms   INTEGER       DEFAULT NULL,
    is_success    BOOLEAN       DEFAULT FALSE,
    created_at    TIMESTAMP     DEFAULT NOW()
);
CREATE INDEX IF NOT EXISTS idx_ss_api_logs_created ON satusehat_api_logs (created_at DESC);
CREATE INDEX IF NOT EXISTS idx_ss_api_logs_context ON satusehat_api_logs (context);
CREATE INDEX IF NOT EXISTS idx_ss_api_logs_method  ON satusehat_api_logs (method);

-- ── Master Location SatuSehat (lokal cache dari FHIR API) ─────────────────────
CREATE TABLE IF NOT EXISTS satusehat_locations (
    id                    BIGSERIAL     PRIMARY KEY,
    satusehat_id          VARCHAR(64)   NOT NULL,          -- FHIR Location.id
    kode                  VARCHAR(100)  DEFAULT NULL,       -- identifier[0].value
    nama                  VARCHAR(500)  NOT NULL DEFAULT '', -- name
    alias                 VARCHAR(500)  DEFAULT NULL,
    status                VARCHAR(20)   DEFAULT 'active',   -- active | inactive | suspended
    operational_status    VARCHAR(10)   DEFAULT NULL,       -- O/C/H/K/I/U
    deskripsi             TEXT          DEFAULT NULL,
    mode                  VARCHAR(20)   DEFAULT 'instance',
    tipe_layanan          VARCHAR(50)   DEFAULT NULL,       -- type[0].coding[0].code
    tipe_layanan_display  VARCHAR(255)  DEFAULT NULL,
    tipe_fisik            VARCHAR(20)   DEFAULT NULL,       -- physicalType.coding[0].code
    tipe_fisik_display    VARCHAR(100)  DEFAULT NULL,
    service_class         VARCHAR(20)   DEFAULT NULL,
    telepon               VARCHAR(100)  DEFAULT NULL,
    email                 VARCHAR(255)  DEFAULT NULL,
    website               VARCHAR(500)  DEFAULT NULL,
    alamat                TEXT          DEFAULT NULL,
    kota                  VARCHAR(255)  DEFAULT NULL,
    kode_pos              VARCHAR(20)   DEFAULT NULL,
    kode_provinsi         VARCHAR(20)   DEFAULT NULL,
    kode_kota             VARCHAR(20)   DEFAULT NULL,
    kode_kecamatan        VARCHAR(20)   DEFAULT NULL,
    kode_kelurahan        VARCHAR(20)   DEFAULT NULL,
    rt                    VARCHAR(10)   DEFAULT NULL,
    rw                    VARCHAR(10)   DEFAULT NULL,
    latitude              DECIMAL(12,8) DEFAULT NULL,
    longitude             DECIMAL(12,8) DEFAULT NULL,
    managing_organization VARCHAR(64)   DEFAULT NULL,       -- Organization FHIR ID
    part_of               VARCHAR(64)   DEFAULT NULL,       -- Parent Location FHIR ID
    hours_all_day         BOOLEAN       DEFAULT FALSE,
    hours_days            VARCHAR(100)  DEFAULT NULL,       -- mon,tue,wed,...
    hours_opening         VARCHAR(20)   DEFAULT NULL,
    hours_closing         VARCHAR(20)   DEFAULT NULL,
    availability_exceptions TEXT        DEFAULT NULL,
    raw_data              JSONB         DEFAULT NULL,
    synced_at             TIMESTAMP     DEFAULT NULL,
    created_at            TIMESTAMP     DEFAULT NOW(),
    updated_at            TIMESTAMP     DEFAULT NOW()
);
CREATE UNIQUE INDEX IF NOT EXISTS idx_ss_loc_satusehat_id ON satusehat_locations (satusehat_id);
CREATE INDEX        IF NOT EXISTS idx_ss_loc_status       ON satusehat_locations (status);
CREATE INDEX        IF NOT EXISTS idx_ss_loc_managing     ON satusehat_locations (managing_organization);
CREATE INDEX        IF NOT EXISTS idx_ss_loc_part_of      ON satusehat_locations (part_of);

-- ── Master Organization SatuSehat (lokal cache dari FHIR API) ─────────────────
CREATE TABLE IF NOT EXISTS satusehat_organizations (
    id                   BIGSERIAL     PRIMARY KEY,
    satusehat_id         VARCHAR(64)   NOT NULL,           -- FHIR Organization.id
    kode                 VARCHAR(100)  DEFAULT NULL,        -- identifier[0].value
    identifier_system    VARCHAR(500)  DEFAULT NULL,        -- identifier[0].system
    identifier_value     VARCHAR(255)  DEFAULT NULL,        -- identifier[0].value (alias kode)
    nama                 VARCHAR(500)  NOT NULL DEFAULT '', -- name
    alias                VARCHAR(500)  DEFAULT NULL,
    aktif                BOOLEAN       DEFAULT TRUE,        -- active
    tipe                 VARCHAR(50)   DEFAULT NULL,        -- type[0].coding[0].code
    tipe_display         VARCHAR(255)  DEFAULT NULL,
    telepon              VARCHAR(100)  DEFAULT NULL,
    email                VARCHAR(255)  DEFAULT NULL,
    website              VARCHAR(500)  DEFAULT NULL,
    alamat               TEXT          DEFAULT NULL,
    kota                 VARCHAR(255)  DEFAULT NULL,
    kode_pos             VARCHAR(20)   DEFAULT NULL,
    kode_provinsi        VARCHAR(20)   DEFAULT NULL,
    kode_kota            VARCHAR(20)   DEFAULT NULL,
    kode_kecamatan       VARCHAR(20)   DEFAULT NULL,
    kode_kelurahan       VARCHAR(20)   DEFAULT NULL,
    part_of              VARCHAR(64)   DEFAULT NULL,        -- parent Organization FHIR ID
    raw_data             JSONB         DEFAULT NULL,
    synced_at            TIMESTAMP     DEFAULT NULL,
    created_at           TIMESTAMP     DEFAULT NOW(),
    updated_at           TIMESTAMP     DEFAULT NOW()
);
CREATE UNIQUE INDEX IF NOT EXISTS idx_ss_org_satusehat_id ON satusehat_organizations (satusehat_id);
CREATE INDEX        IF NOT EXISTS idx_ss_org_aktif        ON satusehat_organizations (aktif);
CREATE INDEX        IF NOT EXISTS idx_ss_org_part_of      ON satusehat_organizations (part_of);

-- ═══════════════════════════════════════════════════════════════════════════════
-- PostgreSQL LISTEN/NOTIFY — auto-sync pasien ke SatuSehat
-- ═══════════════════════════════════════════════════════════════════════════════
--
-- Cara kerja:
--   1. Setiap INSERT ke tabel `pasien`, trigger memanggil pg_notify()
--   2. Artisan daemon `php artisan satusehat:listen-pasien` mendengarkan channel
--   3. Daemon menerima notifikasi → dispatch SyncPasienToSatuSehat job
--
-- Channel yang digunakan: 'satusehat_pasien_insert'
-- Payload: JSON minimal (uuid, no_identitas, id_satu_sehat, delete_soft)
--
-- Catatan: pg_notify payload maksimal 8000 byte. Kita hanya kirim field
-- yang diperlukan untuk validasi awal — data lengkap diambil ulang di job.
-- ─────────────────────────────────────────────────────────────────────────────

-- Fungsi trigger untuk INSERT pasien baru
CREATE OR REPLACE FUNCTION fn_notify_pasien_inserted()
RETURNS trigger AS $$
BEGIN
    -- Kirim notifikasi hanya jika:
    --   - pasien aktif (delete_soft = 1)
    --   - NIK terisi (no_identitas not null / not empty)
    --   - Belum punya IHS ID (id_satu_sehat masih null)
    IF NEW.delete_soft = 1
       AND NEW.no_identitas IS NOT NULL
       AND NEW.no_identitas <> ''
       AND NEW.id_satu_sehat IS NULL
    THEN
        PERFORM pg_notify(
            'satusehat_pasien_insert',
            json_build_object(
                'uuid',           NEW.uuid,
                'no_identitas',   NEW.no_identitas,
                'id_satu_sehat',  NEW.id_satu_sehat,
                'delete_soft',    NEW.delete_soft
            )::text
        );
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Pasang trigger AFTER INSERT on pasien
-- DROP dulu jika sudah ada (idempotent saat re-run)
DROP TRIGGER IF EXISTS trg_pasien_inserted ON pasien;
CREATE TRIGGER trg_pasien_inserted
    AFTER INSERT ON pasien
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_pasien_inserted();

-- ═══════════════════════════════════════════════════════════════════════════════
-- PostgreSQL LISTEN/NOTIFY — auto-sync registrasi (Encounter) ke SatuSehat
-- ═══════════════════════════════════════════════════════════════════════════════
--
-- Cara kerja:
--   1. Setiap INSERT atau UPDATE ke tabel `registrasi`, trigger memanggil pg_notify()
--   2. Artisan daemon `php artisan satusehat:listen-registrasi` mendengarkan channel
--   3. Daemon menerima notifikasi → dispatch SyncEncounterToSatuSehat job
--
-- Channel yang digunakan: 'satusehat_registrasi_upsert'
-- Payload: JSON minimal (uuid, nomor, satusehat_encounter_id, satusehat_encounter_status, event)
--
-- Kondisi trigger notifikasi:
--   INSERT : delete_soft = 1 (registrasi aktif)
--   UPDATE : delete_soft = 1 DAN (encounter_id NULL ATAU status bukan 'synced')
--            → mencakup retry setelah pasien di-sync, location diisi, dsb.
-- ─────────────────────────────────────────────────────────────────────────────

-- Fungsi trigger untuk INSERT / UPDATE registrasi
CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS $$
DECLARE
    v_event TEXT;
BEGIN
    -- Tentukan jenis event
    IF TG_OP = 'INSERT' THEN
        v_event := 'insert';
    ELSE
        v_event := 'update';
    END IF;

    -- INSERT: kirim notifikasi jika registrasi aktif
    IF TG_OP = 'INSERT' AND NEW.delete_soft = 1 THEN
        PERFORM pg_notify(
            'satusehat_registrasi_upsert',
            json_build_object(
                'uuid',                       NEW.uuid,
                'nomor',                      NEW.nomor,
                'satusehat_encounter_id',     NEW.satusehat_encounter_id,
                'satusehat_encounter_status', NEW.satusehat_encounter_status,
                'event',                      v_event
            )::text
        );
    END IF;

    -- UPDATE: kirim notifikasi jika aktif DAN belum/gagal sync
    IF TG_OP = 'UPDATE'
       AND NEW.delete_soft = 1
       AND (
           NEW.satusehat_encounter_id IS NULL
           OR NEW.satusehat_encounter_status IN ('failed', 'waiting_patient', 'no_location')
       )
    THEN
        -- Hanya kirim jika ada perubahan field yang relevan untuk sync
        IF NEW.satusehat_location_id     IS DISTINCT FROM OLD.satusehat_location_id
           OR NEW.satusehat_encounter_status IS DISTINCT FROM OLD.satusehat_encounter_status
           OR NEW.pasien_uuid            IS DISTINCT FROM OLD.pasien_uuid
           OR NEW.pengguna_uuid          IS DISTINCT FROM OLD.pengguna_uuid
           OR NEW.tanggal                IS DISTINCT FROM OLD.tanggal
           OR NEW.waktu                  IS DISTINCT FROM OLD.waktu
           OR (OLD.satusehat_encounter_id IS NOT NULL AND NEW.satusehat_encounter_id IS NULL)
        THEN
            PERFORM pg_notify(
                'satusehat_registrasi_upsert',
                json_build_object(
                    'uuid',                       NEW.uuid,
                    'nomor',                      NEW.nomor,
                    'satusehat_encounter_id',     NEW.satusehat_encounter_id,
                    'satusehat_encounter_status', NEW.satusehat_encounter_status,
                    'event',                      v_event
                )::text
            );
        END IF;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Pasang trigger AFTER INSERT OR UPDATE on registrasi
-- DROP dulu jika sudah ada (idempotent saat re-run)
DROP TRIGGER IF EXISTS trg_registrasi_upsert ON registrasi;
CREATE TRIGGER trg_registrasi_upsert
    AFTER INSERT OR UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_registrasi_upsert();

-- ─────────────────────────────────────────────────────────────────────────────

-- (Opsional) Trigger untuk UPDATE — aktifkan jika ingin re-sync saat NIK berubah
-- CREATE OR REPLACE FUNCTION fn_notify_pasien_updated()
-- RETURNS trigger AS $$
-- BEGIN
--     -- Kirim notifikasi hanya jika NIK berubah dan IHS ID belum ada
--     IF NEW.no_identitas IS DISTINCT FROM OLD.no_identitas
--        AND NEW.id_satu_sehat IS NULL
--        AND NEW.no_identitas IS NOT NULL
--        AND NEW.no_identitas <> ''
--        AND NEW.delete_soft = 1
--     THEN
--         PERFORM pg_notify(
--             'satusehat_pasien_insert',
--             json_build_object(
--                 'uuid',          NEW.uuid,
--                 'no_identitas',  NEW.no_identitas,
--                 'id_satu_sehat', NEW.id_satu_sehat,
--                 'delete_soft',   NEW.delete_soft,
--                 'event',         'update_nik'
--             )::text
--         );
--     END IF;
--     RETURN NEW;
-- END;
-- $$ LANGUAGE plpgsql;
--
-- DROP TRIGGER IF EXISTS trg_pasien_updated ON pasien;
-- CREATE TRIGGER trg_pasien_updated
--     AFTER UPDATE ON pasien
--     FOR EACH ROW
--     EXECUTE FUNCTION fn_notify_pasien_updated();
