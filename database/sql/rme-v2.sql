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

-- ============================================================
-- dokumen_catatan_keperawatan_operasi
-- RM 4.6/CKIDPO/22
-- ============================================================
CREATE TABLE IF NOT EXISTS dokumen_catatan_keperawatan_operasi (
    id         BIGSERIAL    PRIMARY KEY,
    uuid       UUID         UNIQUE NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien VARCHAR(36)  DEFAULT NULL,

    -- Identitas
    no_rm          VARCHAR(50)  DEFAULT NULL,
    no_surat       VARCHAR(50)  DEFAULT NULL,
    jenis_kelamin  VARCHAR(50)   DEFAULT NULL,
    nama           VARCHAR(200) DEFAULT NULL,
    nik            VARCHAR(20)  DEFAULT NULL,
    tanggal_lahir  DATE         DEFAULT NULL,

    -- Waktu
    jam_mulai              VARCHAR(10) DEFAULT NULL,
    jam_selesai            VARCHAR(10) DEFAULT NULL,
    jam_anestesi_mulai     VARCHAR(10) DEFAULT NULL,
    jam_anestesi_selesai   VARCHAR(10) DEFAULT NULL,
    jam_pembedahan_mulai   VARCHAR(10) DEFAULT NULL,
    jam_pembedahan_selesai VARCHAR(10) DEFAULT NULL,

    -- 1. Tipe
    tipe_elektif     BOOLEAN DEFAULT FALSE,
    tipe_darurat     BOOLEAN DEFAULT FALSE,
    tipe_rawat_jalan BOOLEAN DEFAULT FALSE,

    -- 2. Biusan
    biusan_umum     BOOLEAN DEFAULT FALSE,
    biusan_lokal    BOOLEAN DEFAULT FALSE,
    biusan_regional BOOLEAN DEFAULT FALSE,

    -- 3. Kesadaran
    kesadaran_terjaga            BOOLEAN DEFAULT FALSE,
    kesadaran_mudah_dibangunkan  BOOLEAN DEFAULT FALSE,
    kesadaran_lainnya            VARCHAR(100) DEFAULT NULL,

    -- 4. Emosi
    emosi_rileks          BOOLEAN DEFAULT FALSE,
    emosi_gelisah         BOOLEAN DEFAULT FALSE,
    emosi_tidak_ada_respon BOOLEAN DEFAULT FALSE,

    -- 5. Canul
    canul_tangan  BOOLEAN DEFAULT FALSE,
    canul_kaki    BOOLEAN DEFAULT FALSE,
    canul_cvp     BOOLEAN DEFAULT FALSE,
    canul_lainnya VARCHAR(100) DEFAULT NULL,

    -- 6. Jenis operasi
    jenis_op_bersih               BOOLEAN DEFAULT FALSE,
    jenis_op_terkontaminasi       BOOLEAN DEFAULT FALSE,
    jenis_op_bersih_terkontaminasi BOOLEAN DEFAULT FALSE,
    jenis_op_kotor_infeksi        BOOLEAN DEFAULT FALSE,

    -- 7. Posisi
    posisi_supine       BOOLEAN DEFAULT FALSE,
    posisi_prone        BOOLEAN DEFAULT FALSE,
    posisi_lithotomi    BOOLEAN DEFAULT FALSE,
    posisi_kidney       BOOLEAN DEFAULT FALSE,
    posisi_lateral      BOOLEAN DEFAULT FALSE,
    posisi_lainnya      VARCHAR(100) DEFAULT NULL,
    posisi_diawasi_oleh VARCHAR(200) DEFAULT NULL,

    -- 8. Selengantangan
    selengantangan_adduksi BOOLEAN DEFAULT FALSE,
    selengantangan_abduksi BOOLEAN DEFAULT FALSE,
    selengantangan_lainnya VARCHAR(100) DEFAULT NULL,

    -- 9. Urine
    urine_ya           BOOLEAN DEFAULT FALSE,
    urine_tidak        BOOLEAN DEFAULT FALSE,
    urine_ok           BOOLEAN DEFAULT FALSE,
    urine_ruangan      BOOLEAN DEFAULT FALSE,
    urine_dipasang_oleh VARCHAR(200) DEFAULT NULL,
    urine_jenis        VARCHAR(100) DEFAULT NULL,

    -- 10. Desinfeksi
    desinfeksi_iodium       BOOLEAN DEFAULT FALSE,
    desinfeksi_alkohol      BOOLEAN DEFAULT FALSE,
    desinfeksi_povidone     BOOLEAN DEFAULT FALSE,
    desinfeksi_chlorhexidine BOOLEAN DEFAULT FALSE,

    -- 11. Insisi
    insisi_pfannenstiel BOOLEAN DEFAULT FALSE,
    insisi_lainnya      VARCHAR(100) DEFAULT NULL,

    -- 12. Alat
    alat_hand_rest        BOOLEAN DEFAULT FALSE,
    alat_lithotomi_support BOOLEAN DEFAULT FALSE,
    alat_lateral_support  BOOLEAN DEFAULT FALSE,
    alat_chest_support    BOOLEAN DEFAULT FALSE,
    alat_heat_frame       BOOLEAN DEFAULT FALSE,
    alat_lainnya          VARCHAR(100) DEFAULT NULL,

    -- 13. Diatermi
    diatermi_ya                  BOOLEAN DEFAULT FALSE,
    diatermi_tidak               BOOLEAN DEFAULT FALSE,
    diatermi_monopolar           BOOLEAN DEFAULT FALSE,
    diatermi_bipolar             BOOLEAN DEFAULT FALSE,
    diatermi_netral_bokong       BOOLEAN DEFAULT FALSE,
    diatermi_netral_tungkai_atas  BOOLEAN DEFAULT FALSE,
    diatermi_netral_tungkai_bawah BOOLEAN DEFAULT FALSE,
    diatermi_netral_punggung     BOOLEAN DEFAULT FALSE,
    diatermi_netral_bahu         BOOLEAN DEFAULT FALSE,
    diatermi_dipasang_oleh       VARCHAR(200) DEFAULT NULL,
    diatermi_kulit_sbl_utuh      BOOLEAN DEFAULT FALSE,
    diatermi_kulit_sbl_bulosa    BOOLEAN DEFAULT FALSE,
    diatermi_kulit_sbl_eritema   BOOLEAN DEFAULT FALSE,
    diatermi_kulit_sbl_luka_bakar BOOLEAN DEFAULT FALSE,
    diatermi_kulit_ssd_utuh      BOOLEAN DEFAULT FALSE,
    diatermi_kulit_ssd_bulosa    BOOLEAN DEFAULT FALSE,
    diatermi_kulit_ssd_eritema   BOOLEAN DEFAULT FALSE,
    diatermi_kulit_ssd_luka_bakar BOOLEAN DEFAULT FALSE,

    -- 14. Warm blanket
    warm_blanket_ya        BOOLEAN DEFAULT FALSE,
    warm_blanket_tidak     BOOLEAN DEFAULT FALSE,
    warm_blanket_jenis     VARCHAR(100) DEFAULT NULL,
    warm_blanket_jam_mulai  VARCHAR(10) DEFAULT NULL,
    warm_blanket_jam_selesai VARCHAR(10) DEFAULT NULL,

    -- 15. Tourniquet
    tourniquet_ya              BOOLEAN DEFAULT FALSE,
    tourniquet_tidak           BOOLEAN DEFAULT FALSE,
    tourniquet_lokasi          VARCHAR(100) DEFAULT NULL,
    tourniquet_lengan          BOOLEAN DEFAULT FALSE,
    tourniquet_lengan_jam_mulai  VARCHAR(10) DEFAULT NULL,
    tourniquet_lengan_jam_selesai VARCHAR(10) DEFAULT NULL,
    tourniquet_lengan_td       VARCHAR(20) DEFAULT NULL,
    tourniquet_dipasang_oleh   VARCHAR(200) DEFAULT NULL,
    tourniquet_kaki            BOOLEAN DEFAULT FALSE,
    tourniquet_kaki_jam_mulai  VARCHAR(10) DEFAULT NULL,
    tourniquet_kaki_jam_selesai VARCHAR(10) DEFAULT NULL,
    tourniquet_kaki_td         VARCHAR(20) DEFAULT NULL,

    -- 16. Implant
    implant_ya    BOOLEAN DEFAULT FALSE,
    implant_tidak BOOLEAN DEFAULT FALSE,
    implant_jenis  VARCHAR(200) DEFAULT NULL,
    implant_lokasi VARCHAR(200) DEFAULT NULL,

    -- 17. Drain
    drain_ya    BOOLEAN DEFAULT FALSE,
    drain_tidak BOOLEAN DEFAULT FALSE,
    drain_jenis  VARCHAR(200) DEFAULT NULL,
    drain_lokasi VARCHAR(200) DEFAULT NULL,

    -- 18. Irigasi
    irigasi_ya        BOOLEAN DEFAULT FALSE,
    irigasi_tidak     BOOLEAN DEFAULT FALSE,
    irigasi_nacl      BOOLEAN DEFAULT FALSE,
    irigasi_h2o2      BOOLEAN DEFAULT FALSE,
    irigasi_antibiotik BOOLEAN DEFAULT FALSE,
    irigasi_lainnya   VARCHAR(100) DEFAULT NULL,

    -- 19. Tampon
    tampon_ya    BOOLEAN DEFAULT FALSE,
    tampon_tidak BOOLEAN DEFAULT FALSE,
    tampon_lokasi VARCHAR(200) DEFAULT NULL,
    tampon_jumlah VARCHAR(50) DEFAULT NULL,

    -- 20. Spesimen
    spesimen_histology       BOOLEAN DEFAULT FALSE,
    spesimen_histology_jenis VARCHAR(200) DEFAULT NULL,
    spesimen_kultur          BOOLEAN DEFAULT FALSE,
    spesimen_kultur_jenis    VARCHAR(200) DEFAULT NULL,
    spesimen_cytologi        BOOLEAN DEFAULT FALSE,
    spesimen_cytologi_jenis  VARCHAR(200) DEFAULT NULL,
    spesimen_frozen          BOOLEAN DEFAULT FALSE,
    spesimen_frozen_jenis    VARCHAR(200) DEFAULT NULL,

    -- 21. Cairan infus
    cairan_infus TEXT DEFAULT NULL,

    -- 22-24
    kassa_sebelum    VARCHAR(20) DEFAULT NULL,
    kassa_penambahan VARCHAR(20) DEFAULT NULL,
    kassa_setelah    VARCHAR(20) DEFAULT NULL,
    jarum_sebelum    VARCHAR(20) DEFAULT NULL,
    jarum_penambahan VARCHAR(20) DEFAULT NULL,
    jarum_setelah    VARCHAR(20) DEFAULT NULL,
    bisturi_sebelum    VARCHAR(20) DEFAULT NULL,
    bisturi_penambahan VARCHAR(20) DEFAULT NULL,
    bisturi_setelah    VARCHAR(20) DEFAULT NULL,

    -- Section B
    kasa_besar_persediaan  VARCHAR(20)  DEFAULT NULL,
    kasa_besar_terpakai    VARCHAR(20)  DEFAULT NULL,
    kasa_besar_sisa        VARCHAR(20)  DEFAULT NULL,
    kasa_besar_keterangan  VARCHAR(200) DEFAULT NULL,
    kasa_persediaan        VARCHAR(20)  DEFAULT NULL,
    kasa_terpakai          VARCHAR(20)  DEFAULT NULL,
    kasa_sisa              VARCHAR(20)  DEFAULT NULL,
    kasa_keterangan        VARCHAR(200) DEFAULT NULL,
    kasa_kacang_persediaan VARCHAR(20)  DEFAULT NULL,
    kasa_kacang_terpakai   VARCHAR(20)  DEFAULT NULL,
    kasa_kacang_sisa       VARCHAR(20)  DEFAULT NULL,
    kasa_kacang_keterangan VARCHAR(200) DEFAULT NULL,
    kasa_tampon_persediaan VARCHAR(20)  DEFAULT NULL,
    kasa_tampon_terpakai   VARCHAR(20)  DEFAULT NULL,
    kasa_tampon_sisa       VARCHAR(20)  DEFAULT NULL,
    kasa_tampon_keterangan VARCHAR(200) DEFAULT NULL,
    instrumen_persediaan   VARCHAR(20)  DEFAULT NULL,
    instrumen_terpakai     VARCHAR(20)  DEFAULT NULL,
    instrumen_sisa         VARCHAR(20)  DEFAULT NULL,
    instrumen_keterangan   VARCHAR(200) DEFAULT NULL,
    jarum_atraumatik_persediaan VARCHAR(20)  DEFAULT NULL,
    jarum_atraumatik_terpakai   VARCHAR(20)  DEFAULT NULL,
    jarum_atraumatik_sisa       VARCHAR(20)  DEFAULT NULL,
    jarum_atraumatik_keterangan VARCHAR(200) DEFAULT NULL,
    jarum_lepas_persediaan VARCHAR(20)  DEFAULT NULL,
    jarum_lepas_terpakai   VARCHAR(20)  DEFAULT NULL,
    jarum_lepas_sisa       VARCHAR(20)  DEFAULT NULL,
    jarum_lepas_keterangan VARCHAR(200) DEFAULT NULL,
    selang_persediaan      VARCHAR(20)  DEFAULT NULL,
    selang_terpakai        VARCHAR(20)  DEFAULT NULL,
    selang_sisa            VARCHAR(20)  DEFAULT NULL,
    selang_keterangan      VARCHAR(200) DEFAULT NULL,

    -- TTD
    ttd_dokter_operator    TEXT DEFAULT NULL,
    nama_dokter_operator   VARCHAR(200) DEFAULT NULL,
    ttd_perawat_instrumen  TEXT DEFAULT NULL,
    nama_perawat_instrumen VARCHAR(200) DEFAULT NULL,
    ttd_perawat_sirkuler   TEXT DEFAULT NULL,
    nama_perawat_sirkuler  VARCHAR(200) DEFAULT NULL,

    -- Audit
    created_by VARCHAR(100) DEFAULT NULL,
    updated_by VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP    DEFAULT NOW(),
    updated_at TIMESTAMP    DEFAULT NOW(),
    deleted_at TIMESTAMP    DEFAULT NULL
);

CREATE INDEX IF NOT EXISTS idx_ckpo_uuid_pasien ON dokumen_catatan_keperawatan_operasi (uuid_pasien);
CREATE INDEX IF NOT EXISTS idx_ckpo_no_rm       ON dokumen_catatan_keperawatan_operasi (no_rm);
CREATE INDEX IF NOT EXISTS idx_ckpo_deleted_at  ON dokumen_catatan_keperawatan_operasi (deleted_at);

-- ============================================================
-- ALTER TABLE: Add C/D/E/F columns to dokumen_catatan_keperawatan_operasi
-- Migration: 2026_05_17_000001_add_cdef_to_dokumen_catatan_keperawatan_operasi_table
-- ============================================================

-- C1. Gangguan pola nafas
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS c_gn_neuro_muskular        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_penumpukan_sekret     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_jalan_nafas       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_hiperekstensi     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_observasi_rr      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_pantau_ttv        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_suction           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_o2                BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_int_obat              BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_eval_ttv_normal       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_eval_nafas_spontan    BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_eval_sianosis         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_eval_o2_value         VARCHAR(20),
    ADD COLUMN IF NOT EXISTS c_gn_eval_observasi_ruangan BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_gn_paraf                 TEXT,
    ADD COLUMN IF NOT EXISTS c_gn_nama                  VARCHAR(200);

-- C2. Resiko kekurangan cairan
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS c_rc_pembatasan_intake     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_hilang_cairan         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_pengeluaran_integritas BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_int_ukur_io           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_int_pantau_ttv        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_int_mual_muntah       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_int_periksa_pembalut  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_int_pantau_suhu       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_eval_ttv_normal       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_eval_input            VARCHAR(20),
    ADD COLUMN IF NOT EXISTS c_rc_eval_output           VARCHAR(20),
    ADD COLUMN IF NOT EXISTS c_rc_eval_mukosa_lembab    BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_eval_turgor_elastis   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rc_paraf                 TEXT,
    ADD COLUMN IF NOT EXISTS c_rc_nama                  VARCHAR(200);

-- C3. Resiko cedera
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS c_rd_pemajanan_peralatan   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_hipoksia_jaringan     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_lepas_gigi        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_periksa_identitas BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_brankar           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_sabuk             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_peralatan_posisi  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_keamanan_elektrikal BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_plate_diatermi    BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_pantau_io         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_int_catat_kassa       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_eval_posisi           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_eval_alat_elektro     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_eval_kassa            BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_rd_paraf                 TEXT,
    ADD COLUMN IF NOT EXISTS c_rd_nama                  VARCHAR(200);

-- C4. Resiko infeksi intra
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS c_ri_trauma_post           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_pemajanan_lingkungan  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_pemajanan_peralatan   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_int_cuci_tangan       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_int_desinfeksi        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_int_kadaluarsa        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_int_sterilitas        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_int_tutup_luka        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_eval_lingkungan_steril BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS c_ri_paraf                 TEXT,
    ADD COLUMN IF NOT EXISTS c_ri_nama                  VARCHAR(200);

-- D. Pengkajian pasca operasi
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS d_ruang_pemulihan_ya       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_ruang_pemulihan_tidak    BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_masuk_jam                VARCHAR(10),
    ADD COLUMN IF NOT EXISTS d_keluar_jam               VARCHAR(10),
    ADD COLUMN IF NOT EXISTS d_kembali_ruangan          BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kembali_icu              BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kembali_lainnya          VARCHAR(100),
    ADD COLUMN IF NOT EXISTS d_keadaan_baik             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_keadaan_sedang           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_keadaan_buruk            BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kesadaran_cm             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kesadaran_apatis         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kesadaran_somnolen       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kesadaran_sopor          BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kesadaran_koma           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_datang_kering      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_datang_merah_muda  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_datang_hangat      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_keluar_kering      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_keluar_merah_muda  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_kulit_keluar_hangat      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_sirkulasi_merah_muda     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_sirkulasi_kebiruan       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_posisi_lateral           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_posisi_datar             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_posisi_head_up           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_posisi_semi_fowler       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_perdarahan_ya            BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_perdarahan_cc            VARCHAR(20),
    ADD COLUMN IF NOT EXISTS d_perdarahan_tidak         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_perdarahan_lokasi        VARCHAR(200),
    ADD COLUMN IF NOT EXISTS d_muntah_ya                BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_muntah_tidak             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_mukosa_lembab            BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_mukosa_kering            BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jaringan_pa_ya           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jaringan_pa_tidak        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jaringan_pa_k_bedah      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jaringan_pa_ruangan      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jaringan_pa_jumlah       VARCHAR(50),
    ADD COLUMN IF NOT EXISTS d_nyeri_ya                 BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nyeri_tidak              BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jatuh_ringan             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jatuh_sedang             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_jatuh_tinggi             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_teratur_masuk       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_teratur_keluar      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_tidak_teratur_masuk BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_tidak_teratur_keluar BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_lemah_masuk         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_lemah_keluar        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_takikardia_masuk    BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_takikardia_keluar   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_normal_masuk        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nadi_normal_keluar       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_teratur_masuk      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_teratur_keluar     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_tidak_teratur_masuk BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_tidak_teratur_keluar BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_dangkal_masuk      BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_dangkal_keluar     BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_dalam_masuk        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_dalam_keluar       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_sukar_masuk        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS d_nafas_sukar_keluar       BOOLEAN NOT NULL DEFAULT FALSE;

-- E1. Nyeri akut
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS e_na_gangguan_kulit        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_selang_drain          BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_int_kaji_lokasi       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_int_kaji_ttv          BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_int_atur_posisi       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_int_relaksasi         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_eval_ttv_normal       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_eval_nyeri_terkontrol BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_eval_nyeri_berkurang  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_na_eval_observasi_ruangan BOOLEAN NOT NULL DEFAULT FALSE;

-- E2. Resiko infeksi pasca
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS e_ri_trauma_post           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_pemajanan_lingkungan  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_pemajanan_peralatan   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_int_cuci_tangan       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_int_desinfeksi        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_int_kadaluarsa        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_int_sterilitas        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_int_tutup_luka        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_eval_lingkungan_steril BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_ri_paraf                 TEXT,
    ADD COLUMN IF NOT EXISTS e_ri_nama                  VARCHAR(200);

-- E3. Resiko suhu
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS e_rs_suhu_rendah           BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_penggunaan_obat       BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_dehidrasi             BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_int_catat_suhu        BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_int_kaji_suhu         BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_int_kolaborasi_obat   BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_eval_dingin_berkurang BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_eval_tidak_menggigil  BOOLEAN NOT NULL DEFAULT FALSE,
    ADD COLUMN IF NOT EXISTS e_rs_eval_suhu             VARCHAR(20);

-- F. TTD pasca operasi
ALTER TABLE dokumen_catatan_keperawatan_operasi
    ADD COLUMN IF NOT EXISTS f_ttd_perawat_instrumen    TEXT,
    ADD COLUMN IF NOT EXISTS f_nama_perawat_instrumen   VARCHAR(200),
    ADD COLUMN IF NOT EXISTS f_ttd_perawat_sirkuler     TEXT,
    ADD COLUMN IF NOT EXISTS f_nama_perawat_sirkuler    VARCHAR(200),
    ADD COLUMN IF NOT EXISTS f_ttd_perawat_anestesi     TEXT,
    ADD COLUMN IF NOT EXISTS f_nama_perawat_anestesi    VARCHAR(200);
