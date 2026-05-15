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
