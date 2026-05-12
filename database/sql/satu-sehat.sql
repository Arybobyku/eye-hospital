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
