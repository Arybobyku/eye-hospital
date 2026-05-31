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

-- ── Registrasi: tambah kolom SatuSehat Location RO & Poli ───────────────────
-- satusehat_location_id      = Front Office (diisi saat pendaftaran)
-- satusehat_location_ro_id   = Ruang Refraksi Optisi (diisi saat pasien masuk RO)
-- satusehat_location_poli_id = Ruang Poli Dokter (diisi saat pasien dipanggil masuk poli)
-- Semua berisi satusehat_id dari tabel satusehat_locations (FHIR Location.id)
ALTER TABLE registrasi
  ADD COLUMN IF NOT EXISTS satusehat_location_ro_id    VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_location_poli_id  VARCHAR(64)  DEFAULT NULL;

-- ── Registrasi: tambah kolom SatuSehat CarePlan ───────────────────────────────
ALTER TABLE registrasi
  ADD COLUMN IF NOT EXISTS satusehat_careplan_id         VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_status     VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_synced_at  TIMESTAMP    DEFAULT NULL;

-- ── Registrasi: tambah kolom CarePlan Kontrol (jadwal kontrol selanjutnya) ─────
-- Terpisah dari careplan utama — hanya dipicu saat tanggal_kontrol_selanjutnya IS NOT NULL.
ALTER TABLE registrasi
  ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_id         VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_status     VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_kontrol_synced_at  TIMESTAMP    DEFAULT NULL;

COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_id
    IS 'FHIR CarePlan.id untuk jadwal kontrol (tanggal_kontrol_selanjutnya)';
COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_status
    IS 'Status sync CarePlan kontrol: null | waiting_encounter | waiting_patient | synced | failed';
COMMENT ON COLUMN registrasi.satusehat_careplan_kontrol_synced_at
    IS 'Waktu terakhir berhasil sync CarePlan kontrol ke SatuSehat';

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
--   1. UPDATE ke tabel `registrasi` memicu trigger → pg_notify() dengan event spesifik
--   2. Artisan daemon `php artisan satusehat:listen-registrasi` mendengarkan channel
--   3. Daemon menerima notifikasi → dispatch SyncEncounterToSatuSehat job dengan event
--
-- Channel: 'satusehat_registrasi_upsert'
-- Payload: JSON { uuid, nomor, event, satusehat_encounter_id? }
--
-- Empat event yang dipancarkan:
--
--   encounter_post    — CS mendaftarkan pasien (UPDATE, encounter_id NULL, status_ro = 'Belum Diperiksa')
--                       → Job POST Encounter baru ke SatuSehat
--
--   encounter_ro      — Pemeriksaan RO selesai (UPDATE, encounter_id NOT NULL,
--                       status_ro berubah ke 'Sudah Diperiksa RO')
--                       → Job PUT Encounter status: in-progress, location: Refraksi Optisi
--
--   encounter_dokter  — Pemeriksaan dokter selesai (UPDATE, encounter_id NOT NULL,
--                       status_dokter berubah DARI 'Belum Diperiksa' KE 'Sudah Diperiksa')
--                       → Job PUT Encounter status: finished, location: Poli Dokter
--
--   careplan_kontrol  — Dipicu bersamaan dengan encounter_dokter, hanya jika ada jadwal kontrol:
--                       pemeriksaan_dokter.tanggal_kontrol_selanjutnya IS NOT NULL
--                       AND satusehat_careplan_kontrol_id IS NULL (belum pernah sync)
--                       → Job POST CarePlan ke SatuSehat
--
-- ─────────────────────────────────────────────────────────────────────────────

CREATE OR REPLACE FUNCTION fn_notify_registrasi_upsert()
RETURNS trigger AS $$
BEGIN

    -- ── EVENT 1: encounter_post ────────────────────────────────────────────────
    -- POST Encounter baru saat CS mendaftarkan pasien.
    -- Berlaku untuk INSERT maupun UPDATE:
    --   INSERT → registrasi baru langsung dengan status_ro = 'Belum Diperiksa'
    --   UPDATE → update data registrasi sebelum RO memeriksa
    -- Kondisi: aktif, belum punya Encounter ID, masih di tahap RO awal.
    -- PENTING: gunakan TG_OP IN (...) bukan "TG_OP = 'A' OR TG_OP = 'B' AND ..."
    --          karena AND > OR — kondisi lain akan diabaikan untuk case UPDATE.
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
    -- PUT Encounter → in-progress saat pemeriksaan Refraksi Optisi selesai.
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
    -- PUT Encounter → finished saat dokter selesai memeriksa pasien.
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

    -- ── EVENT 4: careplan_kontrol ──────────────────────────────────────────────
    -- POST CarePlan jadwal kontrol selanjutnya ke SatuSehat.
    -- Dipicu bersamaan dengan encounter_dokter, tetapi hanya jika:
    --   1. Ada record di pemeriksaan_dokter dengan tanggal_kontrol_selanjutnya IS NOT NULL
    --   2. CarePlan kontrol belum pernah di-sync (satusehat_careplan_kontrol_id IS NULL)
    -- Dua event (encounter_dokter + careplan_kontrol) dapat terpancar dari UPDATE yang sama.
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
$$ LANGUAGE plpgsql;

-- Pasang trigger AFTER INSERT OR UPDATE on registrasi
-- INSERT  → menangkap registrasi baru (encounter_post)
-- UPDATE  → menangkap perubahan status (encounter_post, encounter_ro, encounter_dokter, careplan_kontrol)
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

-- ═══════════════════════════════════════════════════════════════════════════════
-- PostgreSQL LISTEN/NOTIFY — auto-sync CarePlan ke SatuSehat
-- ═══════════════════════════════════════════════════════════════════════════════
--
-- Cara kerja:
--   1. Saat registrasi di-UPDATE dan status_dokter berubah menjadi 'Sudah Diperiksa',
--      trigger memanggil pg_notify()
--   2. Artisan daemon `php artisan satusehat:listen-careplan` mendengarkan channel
--   3. Daemon menerima notifikasi → dispatch SyncCarePlanToSatuSehat job
--
-- Channel yang digunakan: 'satusehat_careplan_notify'
-- Syarat notifikasi:
--   - UPDATE pada registrasi
--   - NEW.status_dokter = 'Sudah Diperiksa'
--   - status_dokter berubah DARI nilai lain (bukan update berulang)
--   - satusehat_careplan_id masih NULL (belum pernah sync)
-- ─────────────────────────────────────────────────────────────────────────────

CREATE OR REPLACE FUNCTION fn_notify_careplan_ready()
RETURNS trigger AS $$
BEGIN
    -- Kirim notifikasi hanya saat status_dokter berubah ke 'Sudah Diperiksa'
    -- dan CarePlan belum pernah di-sync
    IF NEW.status_dokter = 'Sudah Diperiksa'
       AND (OLD.status_dokter IS DISTINCT FROM 'Sudah Diperiksa')
       AND NEW.satusehat_careplan_id IS NULL
       AND NEW.delete_soft = 1
    THEN
        PERFORM pg_notify(
            'satusehat_careplan_notify',
            json_build_object(
                'uuid',                    NEW.uuid,
                'nomor',                   NEW.nomor,
                'pasien_uuid',             NEW.pasien_uuid,
                'pengguna_uuid',           NEW.pengguna_uuid,
                'satusehat_encounter_id',  NEW.satusehat_encounter_id,
                'satusehat_careplan_id',   NEW.satusehat_careplan_id,
                'status_dokter',           NEW.status_dokter
            )::text
        );
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_registrasi_careplan ON registrasi;
CREATE TRIGGER trg_registrasi_careplan
    AFTER UPDATE ON registrasi
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_careplan_ready();

-- ────────────────────────────────────────────────────────────────────────────────
-- FHIR Encounter FHIR Status & Status History
-- ────────────────────────────────────────────────────────────────────────────────

-- ── Tambah kolom FHIR status ke registrasi ───────────────────────────────────
-- Kolom ini menyimpan status FHIR Encounter (beda dengan satusehat_encounter_status
-- yang menyimpan status proses sync: synced/failed/pending).
-- Nilai valid: arrived | in-progress | finished | cancelled
ALTER TABLE registrasi
  ADD COLUMN IF NOT EXISTS satusehat_encounter_fhir_status VARCHAR(20) DEFAULT 'arrived';

COMMENT ON COLUMN registrasi.satusehat_encounter_fhir_status
  IS 'FHIR Encounter.status: arrived | in-progress | finished | cancelled';

-- ── Tabel riwayat status FHIR Encounter ──────────────────────────────────────
-- Menyimpan setiap perubahan status sehingga bisa dibangun array statusHistory[]
-- yang dikirim ke SatuSehat saat PUT Encounter.
CREATE TABLE IF NOT EXISTS satusehat_encounter_status_history (
    id                       BIGSERIAL PRIMARY KEY,
    registrasi_uuid          VARCHAR(36)  NOT NULL,
    satusehat_encounter_id   VARCHAR(64),
    status                   VARCHAR(20)  NOT NULL,
    period_start             TIMESTAMPTZ  NOT NULL,
    period_end               TIMESTAMPTZ,
    catatan                  TEXT,
    updated_by               VARCHAR(150),
    created_at               TIMESTAMPTZ  DEFAULT NOW()
);

COMMENT ON TABLE  satusehat_encounter_status_history                     IS 'Riwayat perubahan FHIR Encounter status per registrasi';
COMMENT ON COLUMN satusehat_encounter_status_history.registrasi_uuid     IS 'FK ke registrasi.uuid';
COMMENT ON COLUMN satusehat_encounter_status_history.status              IS 'arrived | in-progress | finished | cancelled';
COMMENT ON COLUMN satusehat_encounter_status_history.period_start        IS 'Waktu mulai status ini berlaku (FHIR period.start)';
COMMENT ON COLUMN satusehat_encounter_status_history.period_end          IS 'Waktu status berakhir — diisi saat status berikutnya dicatat (FHIR period.end)';

CREATE INDEX IF NOT EXISTS idx_ss_enc_hist_reg_uuid
    ON satusehat_encounter_status_history (registrasi_uuid);

CREATE INDEX IF NOT EXISTS idx_ss_enc_hist_enc_id
    ON satusehat_encounter_status_history (satusehat_encounter_id);

CREATE INDEX IF NOT EXISTS idx_ss_enc_hist_reg_status
    ON satusehat_encounter_status_history (registrasi_uuid, status);

-- ─────────────────────────────────────────────────────────────────────────────
-- INDEX: tabel registrasi — wajib untuk performa query SatuSehat sync
-- Tanpa index ini query list() & dashboard() akan full table scan → timeout 30 detik
-- ─────────────────────────────────────────────────────────────────────────────

-- Filter utama semua query: delete_soft + tanggal (WHERE + BETWEEN)
CREATE INDEX IF NOT EXISTS idx_reg_ss_tanggal
    ON registrasi (delete_soft, tanggal);

-- Filter status encounter (synced / failed / pending / NULL)
CREATE INDEX IF NOT EXISTS idx_reg_ss_enc_status
    ON registrasi (satusehat_encounter_status)
    WHERE delete_soft = 1;

-- Cek encounter_id IS NULL (pending sync) dan update pasca sync
CREATE INDEX IF NOT EXISTS idx_reg_ss_enc_id
    ON registrasi (satusehat_encounter_id)
    WHERE delete_soft = 1;

-- Filter status_dokter — trigger EVENT 3 & 4 + runSync careplan
CREATE INDEX IF NOT EXISTS idx_reg_status_dokter
    ON registrasi (status_dokter)
    WHERE delete_soft = 1;

-- Filter status_ro — trigger EVENT 1 & 2
CREATE INDEX IF NOT EXISTS idx_reg_status_ro
    ON registrasi (status_ro)
    WHERE delete_soft = 1;

-- Filter careplan kontrol status
CREATE INDEX IF NOT EXISTS idx_reg_ss_careplan_status
    ON registrasi (satusehat_careplan_kontrol_status)
    WHERE delete_soft = 1;

-- JOIN ke pasien dan pengguna (leftJoin di hampir semua query)
CREATE INDEX IF NOT EXISTS idx_reg_pasien_uuid
    ON registrasi (pasien_uuid);

CREATE INDEX IF NOT EXISTS idx_reg_pengguna_uuid
    ON registrasi (pengguna_uuid);

-- Lookup by uuid (syncOne, updateStatus, trigger function)
CREATE INDEX IF NOT EXISTS idx_reg_uuid
    ON registrasi (uuid);

-- ─────────────────────────────────────────────────────────────────────────────
-- INDEX: tabel pemeriksaan_dokter — wajib untuk correlated subquery di list()
-- Query: SELECT tanggal_kontrol_selanjutnya FROM pemeriksaan_dokter
--        WHERE registrasi_uuid = ? AND tanggal_kontrol_selanjutnya IS NOT NULL
--        ORDER BY id DESC LIMIT 1
-- Tanpa index ini = N kali full scan (1 per baris registrasi yang ditampilkan)
-- ─────────────────────────────────────────────────────────────────────────────

-- Partial index: hanya row yang punya jadwal kontrol (lebih kecil, lebih cepat)
CREATE INDEX IF NOT EXISTS idx_pd_reg_uuid_kontrol
    ON pemeriksaan_dokter (registrasi_uuid, id DESC)
    WHERE tanggal_kontrol_selanjutnya IS NOT NULL;

-- Non-partial fallback untuk EXISTS di trigger EVENT 4 dan lookup umum
CREATE INDEX IF NOT EXISTS idx_pd_reg_uuid
    ON pemeriksaan_dokter (registrasi_uuid);

-- ─────────────────────────────────────────────────────────────────────────────
-- ALTER TABLE pemeriksaan_dokter_icdten — tambah kolom SatuSehat Condition
-- FHIR Condition ID disimpan langsung di baris ICD-10 yang bersangkutan.
-- ─────────────────────────────────────────────────────────────────────────────

ALTER TABLE pemeriksaan_dokter_icdten
  ADD COLUMN IF NOT EXISTS satusehat_condition_id  VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_encounter_id  VARCHAR(64)  DEFAULT NULL;

COMMENT ON COLUMN pemeriksaan_dokter_icdten.satusehat_condition_id  IS 'FHIR Condition.id yang dikembalikan API SatuSehat setelah POST /Condition';
COMMENT ON COLUMN pemeriksaan_dokter_icdten.satusehat_encounter_id  IS 'FHIR Encounter.id yang menjadi konteks Condition ini';

-- Index untuk cek idempoten: lookup baris ICD-10 yang sudah di-sync
CREATE INDEX IF NOT EXISTS idx_pdi_ss_condition
    ON pemeriksaan_dokter_icdten (registrasi_uuid, satusehat_condition_id)
    WHERE satusehat_condition_id IS NOT NULL;


-- ─────────────────────────────────────────────────────────────────────────────
-- CPPT → pg_notify (auto-sync sebagai FHIR Observation)
-- Trigger dipancarkan saat INSERT atau UPDATE ke tabel `cppt`
-- Payload: JSON { uuid, registrasi_uuid, asesmen }
-- Guard awal: hanya notify jika asesmen IS NOT NULL
-- ─────────────────────────────────────────────────────────────────────────────

CREATE OR REPLACE FUNCTION fn_notify_cppt_upsert()
RETURNS TRIGGER AS $$
BEGIN
    -- Hanya proses jika asesmen IS NOT NULL dan tidak kosong
    IF NEW.asesmen IS NOT NULL AND TRIM(NEW.asesmen) <> '' THEN
        PERFORM pg_notify(
            'satusehat_cppt_upsert',
            json_build_object(
                'uuid',            NEW.uuid,
                'registrasi_uuid', NEW.registrasi_uuid,
                'asesmen',         LEFT(NEW.asesmen, 100)
            )::text
        );
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger untuk INSERT dan UPDATE
DROP TRIGGER IF EXISTS trg_cppt_ss_upsert ON cppt;
CREATE TRIGGER trg_cppt_ss_upsert
    AFTER INSERT OR UPDATE ON cppt
    FOR EACH ROW
    EXECUTE FUNCTION fn_notify_cppt_upsert();

-- Index tambahan untuk performa query di SyncObservationToSatuSehat
CREATE INDEX IF NOT EXISTS idx_cppt_uuid         ON cppt (uuid);
CREATE INDEX IF NOT EXISTS idx_cppt_pengguna_uuid ON cppt (pengguna_uuid);

-- ─────────────────────────────────────────────────────────────────────────────
-- CPPT: tambah kolom SatuSehat Observation
-- Dijalankan bersamaan dengan migration:
--   2026_05_29_000001_add_satusehat_observation_to_cppt_table.php
-- ─────────────────────────────────────────────────────────────────────────────

ALTER TABLE cppt
  ADD COLUMN IF NOT EXISTS satusehat_observation_id         VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_observation_status     VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_observation_synced_at  TIMESTAMP    DEFAULT NULL;

COMMENT ON COLUMN cppt.satusehat_observation_id
    IS 'FHIR Observation.id dari SatuSehat API';
COMMENT ON COLUMN cppt.satusehat_observation_status
    IS 'null | waiting_patient | waiting_encounter | waiting_assessment | synced | failed';
COMMENT ON COLUMN cppt.satusehat_observation_synced_at
    IS 'Waktu terakhir berhasil sync ke SatuSehat';

CREATE INDEX IF NOT EXISTS idx_cppt_ss_obs_status
    ON cppt (satusehat_observation_status)
    WHERE satusehat_observation_status IS NOT NULL;

CREATE INDEX IF NOT EXISTS idx_cppt_registrasi_uuid
    ON cppt (registrasi_uuid);
