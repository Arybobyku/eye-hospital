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

-- ── dokumen_laporan_operasi ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS dokumen_laporan_operasi (
    id            BIGSERIAL    PRIMARY KEY,
    uuid          UUID         NOT NULL UNIQUE,
    uuid_pasien   UUID         DEFAULT NULL,

    -- Identitas Pasien
    no_rm         VARCHAR(50)  DEFAULT NULL,
    no_surat      VARCHAR(50)  DEFAULT NULL,
    jenis_kelamin VARCHAR(50)   DEFAULT NULL,
    nama          VARCHAR(200) DEFAULT NULL,
    nik           VARCHAR(20)  DEFAULT NULL,
    tanggal_lahir DATE         DEFAULT NULL,

    -- Tim Operasi
    ahli_bedah       VARCHAR(200) DEFAULT NULL,
    asisten_dokter   VARCHAR(200) DEFAULT NULL,
    ahli_anestesi    VARCHAR(200) DEFAULT NULL,
    instrumen        VARCHAR(200) DEFAULT NULL,

    -- Diagnosa & Waktu
    diagnosa_prabedah      TEXT        DEFAULT NULL,
    diagnosa_pasca_bedah   TEXT        DEFAULT NULL,
    pembedahan_mulai_pukul VARCHAR(10) DEFAULT NULL,
    pembedahan_selesai_pukul VARCHAR(10) DEFAULT NULL,
    lama_tindakan          VARCHAR(50) DEFAULT NULL,
    tanggal                DATE        DEFAULT NULL,

    -- Jenis Pembedahan
    jenis_pembedahan TEXT        DEFAULT NULL,
    macam_pembedahan TEXT        DEFAULT NULL,

    -- Checkboxes Jenis
    jenis_besar  BOOLEAN DEFAULT FALSE,
    jenis_sedang BOOLEAN DEFAULT FALSE,
    jenis_kecil  BOOLEAN DEFAULT FALSE,

    -- Checkboxes Tipe
    tipe_elektif   BOOLEAN DEFAULT FALSE,
    tipe_emergency BOOLEAN DEFAULT FALSE,
    tipe_khusus    BOOLEAN DEFAULT FALSE,

    -- Transfusi
    transfusi_tidak       BOOLEAN      DEFAULT FALSE,
    transfusi_ya          BOOLEAN      DEFAULT FALSE,
    transfusi_jenis_jumlah VARCHAR(255) DEFAULT NULL,

    -- Implan
    implan_tidak       BOOLEAN      DEFAULT FALSE,
    implan_ya          BOOLEAN      DEFAULT FALSE,
    implan_jenis_jumlah VARCHAR(255) DEFAULT NULL,

    -- Uraian Pembedahan
    uraian_pembedahan TEXT DEFAULT NULL,

    -- Pasca Operasi
    komplikasi_intra_operasi TEXT        DEFAULT NULL,
    konsultasi_intra_operasi TEXT        DEFAULT NULL,
    jumlah_perdarahan        VARCHAR(100) DEFAULT NULL,

    -- Jaringan ke Patologi
    jaringan_patologi_ya    BOOLEAN DEFAULT FALSE,
    jaringan_patologi_tidak BOOLEAN DEFAULT FALSE,

    -- Tanda Tangan
    ttd_dokter           TEXT         DEFAULT NULL,
    nama_dokter          VARCHAR(200) DEFAULT NULL,
    dokter_ttd_timestamp VARCHAR(50)  DEFAULT NULL,

    -- Audit
    created_by VARCHAR(100) DEFAULT NULL,
    updated_by VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP    DEFAULT NOW(),
    updated_at TIMESTAMP    DEFAULT NOW(),
    deleted_at TIMESTAMP    DEFAULT NULL
);

CREATE INDEX IF NOT EXISTS idx_lo_uuid_pasien ON dokumen_laporan_operasi (uuid_pasien);
CREATE INDEX IF NOT EXISTS idx_lo_no_rm       ON dokumen_laporan_operasi (no_rm);
CREATE INDEX IF NOT EXISTS idx_lo_deleted_at  ON dokumen_laporan_operasi (deleted_at);

-- ── dokumen_laporan_insiden ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS dokumen_laporan_insiden (
    id            BIGSERIAL    PRIMARY KEY,
    uuid          UUID         NOT NULL UNIQUE,
    uuid_pasien   UUID         DEFAULT NULL,

    -- Identitas Pasien
    no_rm         VARCHAR(50)  DEFAULT NULL,
    no_surat      VARCHAR(50)  DEFAULT NULL,
    jenis_kelamin VARCHAR(50)   DEFAULT NULL,
    nama          VARCHAR(200) DEFAULT NULL,
    nik           VARCHAR(20)  DEFAULT NULL,
    tanggal_lahir DATE         DEFAULT NULL,

    -- Header
    ruangan       VARCHAR(100) DEFAULT NULL,

    -- I. Umur
    umur_0_1_bulan       BOOLEAN DEFAULT FALSE,
    umur_1_bulan_1_tahun BOOLEAN DEFAULT FALSE,
    umur_1_5_tahun       BOOLEAN DEFAULT FALSE,
    umur_5_15_tahun      BOOLEAN DEFAULT FALSE,
    umur_15_30_tahun     BOOLEAN DEFAULT FALSE,
    umur_30_65_tahun     BOOLEAN DEFAULT FALSE,
    umur_65_plus         BOOLEAN DEFAULT FALSE,

    -- Penanggung Biaya
    biaya_pribadi         BOOLEAN DEFAULT FALSE,
    biaya_asuransi_swasta BOOLEAN DEFAULT FALSE,
    biaya_perusahaan      BOOLEAN DEFAULT FALSE,
    biaya_bpjs            BOOLEAN DEFAULT FALSE,

    -- Masuk RS
    tanggal_masuk_rs  DATE        DEFAULT NULL,
    jam_masuk_rs      VARCHAR(10) DEFAULT NULL,

    -- II. Rincian Kejadian
    insiden_tanggal   DATE        DEFAULT NULL,
    insiden_jam       VARCHAR(10) DEFAULT NULL,
    insiden_deskripsi TEXT        DEFAULT NULL,
    kronologis_insiden TEXT       DEFAULT NULL,

    -- 4. Jenis Insiden
    jenis_knc BOOLEAN DEFAULT FALSE,
    jenis_ktc BOOLEAN DEFAULT FALSE,
    jenis_ktd BOOLEAN DEFAULT FALSE,

    -- 5. Pelapor
    pelapor_karyawan           BOOLEAN      DEFAULT FALSE,
    pelapor_pasien             BOOLEAN      DEFAULT FALSE,
    pelapor_keluarga           BOOLEAN      DEFAULT FALSE,
    pelapor_pengunjung         BOOLEAN      DEFAULT FALSE,
    pelapor_lainnya            BOOLEAN      DEFAULT FALSE,
    pelapor_lainnya_sebutkan   VARCHAR(255) DEFAULT NULL,

    -- 6. Terjadi pada
    terjadi_pada_pasien              BOOLEAN      DEFAULT FALSE,
    terjadi_pada_lainnya             BOOLEAN      DEFAULT FALSE,
    terjadi_pada_lainnya_sebutkan    VARCHAR(255) DEFAULT NULL,

    -- 7. Menyangkut pasien
    pasien_rawat_inap       BOOLEAN      DEFAULT FALSE,
    pasien_rawat_jalan      BOOLEAN      DEFAULT FALSE,
    pasien_igd              BOOLEAN      DEFAULT FALSE,
    pasien_lainnya          BOOLEAN      DEFAULT FALSE,
    pasien_lainnya_sebutkan VARCHAR(255) DEFAULT NULL,

    -- 8. Tempat
    lokasi_kejadian VARCHAR(255) DEFAULT NULL,

    -- 9. Spesialisasi
    spesialisasi_penyakit_mata       BOOLEAN      DEFAULT FALSE,
    spesialisasi_lainnya             BOOLEAN      DEFAULT FALSE,
    spesialisasi_lainnya_sebutkan    VARCHAR(255) DEFAULT NULL,

    -- 10. Unit Kerja
    unit_kerja_penyebab VARCHAR(255) DEFAULT NULL,

    -- 11. Akibat
    akibat_kematian      BOOLEAN DEFAULT FALSE,
    akibat_cedera_berat  BOOLEAN DEFAULT FALSE,
    akibat_cedera_sedang BOOLEAN DEFAULT FALSE,
    akibat_cedera_ringan BOOLEAN DEFAULT FALSE,
    akibat_tidak_cedera  BOOLEAN DEFAULT FALSE,

    -- 12–13. Tindakan
    tindakan_hasil                      TEXT         DEFAULT NULL,
    tindakan_tim                        BOOLEAN      DEFAULT FALSE,
    tindakan_tim_terdiri                VARCHAR(255) DEFAULT NULL,
    tindakan_dokter                     BOOLEAN      DEFAULT FALSE,
    tindakan_perawat                    BOOLEAN      DEFAULT FALSE,
    tindakan_petugas_lainnya            BOOLEAN      DEFAULT FALSE,
    tindakan_petugas_lainnya_sebutkan   VARCHAR(255) DEFAULT NULL,

    -- 14. Kejadian sama
    kejadian_sama_ya         BOOLEAN DEFAULT FALSE,
    kejadian_sama_tidak      BOOLEAN DEFAULT FALSE,
    kejadian_sama_keterangan TEXT    DEFAULT NULL,

    -- Pembuat / Penerima
    pembuat_laporan         VARCHAR(200) DEFAULT NULL,
    pembuat_laporan_paraf   VARCHAR(200) DEFAULT NULL,
    tgl_terima              DATE         DEFAULT NULL,
    penerima_laporan        VARCHAR(200) DEFAULT NULL,
    penerima_laporan_paraf  TEXT DEFAULT NULL,
    tgl_lapor               DATE         DEFAULT NULL,

    -- Grading
    grading_biru   BOOLEAN DEFAULT FALSE,
    grading_hijau  BOOLEAN DEFAULT FALSE,
    grading_kuning BOOLEAN DEFAULT FALSE,
    grading_merah  BOOLEAN DEFAULT FALSE,

    -- Audit
    created_by VARCHAR(100) DEFAULT NULL,
    updated_by VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP    DEFAULT NOW(),
    updated_at TIMESTAMP    DEFAULT NOW(),
    deleted_at TIMESTAMP    DEFAULT NULL
);

CREATE INDEX IF NOT EXISTS idx_li_uuid_pasien ON dokumen_laporan_insiden (uuid_pasien);
CREATE INDEX IF NOT EXISTS idx_li_no_rm       ON dokumen_laporan_insiden (no_rm);
CREATE INDEX IF NOT EXISTS idx_li_deleted_at  ON dokumen_laporan_insiden (deleted_at);
