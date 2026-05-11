ALTER TABLE pasien
  ADD COLUMN id_satu_sehat          VARCHAR(50)  DEFAULT NULL,
  ADD COLUMN satusehat_sync_status  VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN satusehat_synced_at    TIMESTAMP    DEFAULT NULL;
