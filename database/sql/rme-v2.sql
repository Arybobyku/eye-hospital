CREATE TABLE dokumen_asesmen_pra_operasi (
    id BIGSERIAL PRIMARY KEY,
    uuid_pasien UUID NOT NULL,
    no_surat TEXT DEFAULT NULL,
    nama VARCHAR(255) DEFAULT NULL,
    jenis_kelamin VARCHAR(1) DEFAULT NULL,
    no_rn VARCHAR(50) DEFAULT NULL,
    ruangan VARCHAR(100) DEFAULT NULL,
    tanggal DATE DEFAULT NULL,
    jam TIME DEFAULT NULL,
    diagnosis_pra_operatif TEXT DEFAULT NULL,
    timing_tindakan VARCHAR(20) DEFAULT NULL,
    indikasi_tindakan TEXT DEFAULT NULL,
    rencana_tindakan TEXT DEFAULT NULL,
    prosedur_tindakan TEXT DEFAULT NULL,
    alternatif_lain TEXT DEFAULT NULL,
    risiko_komplikasi TEXT DEFAULT NULL,
    pemantauan_khusus TEXT DEFAULT NULL,
    dokter_bedah_nama VARCHAR(255) DEFAULT NULL,
    ttd_dokter TEXT DEFAULT NULL,
    type TEXT DEFAULT 'dokumen_asesmen_pra_operasi',
    status VARCHAR(20) DEFAULT 'draft',
    created_by VARCHAR(255) DEFAULT NULL,
    updated_by VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL
);
-- ── STATUS OFTALMOLOGIS RAWAT JALAN ─────────────────────────────────────────
-- Form RM 1.4/SORJ — Status Oftalmologis Rawat Jalan
-- Dibuat: 2026-05-15
-- ─────────────────────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS dokumen_status_oftalmologis (
    id          BIGSERIAL PRIMARY KEY,
    uuid        VARCHAR(64)  NOT NULL UNIQUE,
    uuid_pasien VARCHAR(64)  DEFAULT NULL,

    -- ── Identitas Pasien (wajib) ──────────────────────────────────────────
    no_rm          VARCHAR(50)  DEFAULT NULL,
    no_surat       VARCHAR(50)  DEFAULT NULL,
    jenis_kelamin  VARCHAR(50)   DEFAULT NULL,
    nama           VARCHAR(255) DEFAULT NULL,
    nik            VARCHAR(20)  DEFAULT NULL,
    tanggal_lahir  DATE         DEFAULT NULL,

    -- ── Kunjungan ─────────────────────────────────────────────────────────
    tanggal_kunjungan DATE        DEFAULT NULL,
    jam_kunjungan     VARCHAR(10) DEFAULT NULL,

    -- ── OCULAR DEXTRA (OD) ───────────────────────────────────────────────
    od_pd             VARCHAR(20) DEFAULT NULL,
    od_autoref_s      VARCHAR(20) DEFAULT NULL,
    od_autoref_c      VARCHAR(20) DEFAULT NULL,
    od_autoref_x      VARCHAR(20) DEFAULT NULL,
    od_kk1            VARCHAR(20) DEFAULT NULL,
    od_kk1_axis       VARCHAR(20) DEFAULT NULL,
    od_kk2            VARCHAR(20) DEFAULT NULL,
    od_kk2_axis       VARCHAR(20) DEFAULT NULL,
    od_tonometri      VARCHAR(20) DEFAULT NULL,
    od_visus          VARCHAR(30) DEFAULT NULL,
    od_bcva           VARCHAR(30) DEFAULT NULL,
    od_add            VARCHAR(20) DEFAULT NULL,
    od_kacamata_sph   VARCHAR(20) DEFAULT NULL,
    od_kacamata_cyl   VARCHAR(20) DEFAULT NULL,
    od_kacamata_x     VARCHAR(20) DEFAULT NULL,
    od_kacamata_addisi VARCHAR(20) DEFAULT NULL,

    -- ── OCULAR SINISTRA (OS) ─────────────────────────────────────────────
    os_pd             VARCHAR(20) DEFAULT NULL,
    os_autoref_s      VARCHAR(20) DEFAULT NULL,
    os_autoref_c      VARCHAR(20) DEFAULT NULL,
    os_autoref_x      VARCHAR(20) DEFAULT NULL,
    os_kk1            VARCHAR(20) DEFAULT NULL,
    os_kk1_axis       VARCHAR(20) DEFAULT NULL,
    os_kk2            VARCHAR(20) DEFAULT NULL,
    os_kk2_axis       VARCHAR(20) DEFAULT NULL,
    os_tonometri      VARCHAR(20) DEFAULT NULL,
    os_visus          VARCHAR(30) DEFAULT NULL,
    os_bcva           VARCHAR(30) DEFAULT NULL,
    os_add            VARCHAR(20) DEFAULT NULL,
    os_kacamata_sph   VARCHAR(20) DEFAULT NULL,
    os_kacamata_cyl   VARCHAR(20) DEFAULT NULL,
    os_kacamata_x     VARCHAR(20) DEFAULT NULL,
    os_kacamata_addisi VARCHAR(20) DEFAULT NULL,

    -- ── Posisi & Pergerakan Bola Mata ─────────────────────────────────────
    posisi_normal  BOOLEAN DEFAULT FALSE,
    diagram_mata   TEXT    DEFAULT NULL,

    -- ── Status Segmen Anterior & Posterior ──────────────────────────────
    -- PALPEBRA
    status_palpebra_od_normal    BOOLEAN      DEFAULT FALSE,
    status_palpebra_os_normal    BOOLEAN      DEFAULT FALSE,
    status_palpebra_ket          VARCHAR(255) DEFAULT NULL,
    -- CONJUNCTIVA
    status_conjunctiva_od_normal BOOLEAN      DEFAULT FALSE,
    status_conjunctiva_os_normal BOOLEAN      DEFAULT FALSE,
    status_conjunctiva_ket       VARCHAR(255) DEFAULT NULL,
    -- CORNEA
    status_cornea_od_normal      BOOLEAN      DEFAULT FALSE,
    status_cornea_os_normal      BOOLEAN      DEFAULT FALSE,
    status_cornea_ket            VARCHAR(255) DEFAULT NULL,
    -- BILIK MATA DEPAN
    status_bmd_od_normal         BOOLEAN      DEFAULT FALSE,
    status_bmd_os_normal         BOOLEAN      DEFAULT FALSE,
    status_bmd_ket               VARCHAR(255) DEFAULT NULL,
    -- PUPIL DAN IRIS
    status_pupil_iris_od_normal  BOOLEAN      DEFAULT FALSE,
    status_pupil_iris_os_normal  BOOLEAN      DEFAULT FALSE,
    status_pupil_iris_ket        VARCHAR(255) DEFAULT NULL,
    -- LENSA
    status_lensa_od_normal       BOOLEAN      DEFAULT FALSE,
    status_lensa_os_normal       BOOLEAN      DEFAULT FALSE,
    status_lensa_ket             VARCHAR(255) DEFAULT NULL,
    -- VITREOUS
    status_vitreous_od_normal    BOOLEAN      DEFAULT FALSE,
    status_vitreous_os_normal    BOOLEAN      DEFAULT FALSE,
    status_vitreous_ket          VARCHAR(255) DEFAULT NULL,
    -- FUNDUSCOPY
    status_funduscopy_od_normal  BOOLEAN      DEFAULT FALSE,
    status_funduscopy_os_normal  BOOLEAN      DEFAULT FALSE,
    status_funduscopy_ket        VARCHAR(255) DEFAULT NULL,

    -- ── Klinis ────────────────────────────────────────────────────────────
    pemeriksaan_penunjang TEXT         DEFAULT NULL,
    diagnose_kerja        TEXT         DEFAULT NULL,
    diagnose_kerja_icd    VARCHAR(20)  DEFAULT NULL,
    diagnose_banding      TEXT         DEFAULT NULL,
    diagnose_banding_icd  VARCHAR(20)  DEFAULT NULL,
    tata_laksana          TEXT         DEFAULT NULL,
    perencanaan           TEXT         DEFAULT NULL,
    prognosa              VARCHAR(255) DEFAULT NULL,

    -- ── Tanda Tangan ─────────────────────────────────────────────────────
    ttd_dokter             TEXT        DEFAULT NULL,
    nama_dokter            VARCHAR(255) DEFAULT NULL,
    dokter_ttd_timestamp   VARCHAR(50)  DEFAULT NULL,

    -- ── Audit ─────────────────────────────────────────────────────────────
    created_by  VARCHAR(100) DEFAULT NULL,
    updated_by  VARCHAR(100) DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT NOW(),
    updated_at  TIMESTAMP    DEFAULT NOW(),
    deleted_at  TIMESTAMP    DEFAULT NULL
);

CREATE INDEX IF NOT EXISTS idx_sorj_uuid_pasien ON dokumen_status_oftalmologis (uuid_pasien);
CREATE INDEX IF NOT EXISTS idx_sorj_no_rm       ON dokumen_status_oftalmologis (no_rm);
CREATE INDEX IF NOT EXISTS idx_sorj_deleted_at  ON dokumen_status_oftalmologis (deleted_at);
