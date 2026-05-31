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



-- Table: public.dokumen_catatan_perkembangan_terintegrasi

-- DROP TABLE IF EXISTS public.dokumen_catatan_perkembangan_terintegrasi;

CREATE TABLE IF NOT EXISTS public.dokumen_catatan_perkembangan_terintegrasi
(
    id bigint NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1 ),
    uuid character varying(255) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(255) COLLATE pg_catalog."default",
    no_rm character varying(100) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    nik character varying(100) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    tanggal date,
    cppt_rows jsonb,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    deleted_at timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT dokumen_catatan_perkembangan_terintegrasi_pkey PRIMARY KEY (id, uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_catatan_perkembangan_terintegrasi
    OWNER to postgres;
-- Index: dokumen_catatan_perkembangan_terintegrasi_uuid_unique

-- DROP INDEX IF EXISTS public.dokumen_catatan_perkembangan_terintegrasi_uuid_unique;

CREATE UNIQUE INDEX IF NOT EXISTS dokumen_catatan_perkembangan_terintegrasi_uuid_unique
    ON public.dokumen_catatan_perkembangan_terintegrasi USING btree
    (uuid COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;


-- Table: public.dokumen_checklist_keselamatan_pasien_operasi

-- DROP TABLE IF EXISTS public.dokumen_checklist_keselamatan_pasien_operasi;

CREATE TABLE IF NOT EXISTS public.dokumen_checklist_keselamatan_pasien_operasi
(
    id bigint NOT NULL DEFAULT nextval('dokumen_checklist_keselamatan_pasien_operasi_id_seq'::regclass),
    uuid uuid NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien uuid NOT NULL,
    no_rm character varying(50) COLLATE pg_catalog."default" NOT NULL,
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(50) COLLATE pg_catalog."default",
    signin_waktu time without time zone,
    signin_q1 character varying(50) COLLATE pg_catalog."default",
    signin_q2 character varying(50) COLLATE pg_catalog."default",
    signin_q3 character varying(50) COLLATE pg_catalog."default",
    signin_q4 character varying(50) COLLATE pg_catalog."default",
    signin_q5 character varying(50) COLLATE pg_catalog."default",
    signin_q6 character varying(50) COLLATE pg_catalog."default",
    signin_q7 character varying(50) COLLATE pg_catalog."default",
    signin_ttd_dr_anestesi text COLLATE pg_catalog."default",
    signin_nama_dr_anestesi character varying(255) COLLATE pg_catalog."default",
    signin_ttd_perawat_anestesi text COLLATE pg_catalog."default",
    signin_nama_perawat_anestesi character varying(255) COLLATE pg_catalog."default",
    signin_ttd_perawat text COLLATE pg_catalog."default",
    signin_nama_perawat character varying(255) COLLATE pg_catalog."default",
    timeout_waktu time without time zone,
    timeout_q1 character varying(50) COLLATE pg_catalog."default",
    timeout_q2 character varying(50) COLLATE pg_catalog."default",
    timeout_q3 character varying(50) COLLATE pg_catalog."default",
    timeout_q4_tindakan_beresiko text COLLATE pg_catalog."default",
    timeout_q4_lama_tindakan character varying(100) COLLATE pg_catalog."default",
    timeout_q4_antisipasi_perdarahan character varying(50) COLLATE pg_catalog."default",
    timeout_q5 character varying(50) COLLATE pg_catalog."default",
    timeout_q6_kesterilan character varying(50) COLLATE pg_catalog."default",
    timeout_q6_implan character varying(50) COLLATE pg_catalog."default",
    timeout_q6_masalah_alat character varying(50) COLLATE pg_catalog."default",
    timeout_q6_radiologi character varying(50) COLLATE pg_catalog."default",
    timeout_ttd_dr_anestesi text COLLATE pg_catalog."default",
    timeout_nama_dr_anestesi character varying(255) COLLATE pg_catalog."default",
    timeout_ttd_perawat_anestesi text COLLATE pg_catalog."default",
    timeout_nama_perawat_anestesi character varying(255) COLLATE pg_catalog."default",
    timeout_ttd_perawat_sirkuler text COLLATE pg_catalog."default",
    timeout_nama_perawat_sirkuler character varying(255) COLLATE pg_catalog."default",
    signout_waktu time without time zone,
    signout_q1 character varying(50) COLLATE pg_catalog."default",
    signout_q2 character varying(50) COLLATE pg_catalog."default",
    signout_q3 character varying(50) COLLATE pg_catalog."default",
    signout_q4 character varying(50) COLLATE pg_catalog."default",
    signout_q5 character varying(50) COLLATE pg_catalog."default",
    signout_ttd_dr_bedah text COLLATE pg_catalog."default",
    signout_nama_dr_bedah character varying(255) COLLATE pg_catalog."default",
    signout_ttd_dr_anestesi text COLLATE pg_catalog."default",
    signout_nama_dr_anestesi character varying(255) COLLATE pg_catalog."default",
    signout_ttd_perawat_anestesi text COLLATE pg_catalog."default",
    signout_nama_perawat_anestesi character varying(255) COLLATE pg_catalog."default",
    signout_ttd_perawat_instrument text COLLATE pg_catalog."default",
    signout_nama_perawat_instrument character varying(255) COLLATE pg_catalog."default",
    signout_ttd_perawat_sirkuler text COLLATE pg_catalog."default",
    signout_nama_perawat_sirkuler character varying(255) COLLATE pg_catalog."default",
    tanggal_ttd date,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp without time zone,
    no_surat character varying(50) COLLATE pg_catalog."default" DEFAULT 'RM/4.9/CLKPO/22'::character varying,
    ttd_operator text COLLATE pg_catalog."default",
    ttd_operator_timestamp character varying(50) COLLATE pg_catalog."default",
    ttd_ahli_anastesi text COLLATE pg_catalog."default",
    ttd_ahli_anastesi_timestamp character varying(50) COLLATE pg_catalog."default",
    ttd_asisten_operasi text COLLATE pg_catalog."default",
    ttd_asisten_operasi_timestamp character varying(50) COLLATE pg_catalog."default",
    ttd_scrub_nurses text COLLATE pg_catalog."default",
    ttd_scrub_nurses_timestamp character varying(50) COLLATE pg_catalog."default",
    signout_tanggal date,
    CONSTRAINT dokumen_checklist_keselamatan_pasien_operasi_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_checklist_keselamatan_pasien_operasi_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_checklist_keselamatan_pasien_operasi
    OWNER to postgres;

COMMENT ON TABLE public.dokumen_checklist_keselamatan_pasien_operasi
    IS 'Checklist Keselamatan Pasien Operasi (WHO Surgical Safety Checklist) - RM/4.9/CLKPO/22';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signin_waktu
    IS 'Waktu Sign In (Sebelum Induksi Anestesi)';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signin_q1
    IS 'Identitas pasien benar, rencana tindakan jelas, ada informed consent';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signin_q5
    IS 'Pasien memiliki riwayat alergi';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signin_q7
    IS 'Risiko perdarahan >500ml (7ml/kg untuk anak)';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.timeout_waktu
    IS 'Waktu Time Out (Sebelum Insisi)';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.timeout_q4_tindakan_beresiko
    IS 'Tindakan beresiko atau tidak rutin yang akan dilakukan';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.timeout_q4_lama_tindakan
    IS 'Estimasi lama tindakan operasi';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signout_waktu
    IS 'Waktu Sign Out (Sebelum Pasien Meninggalkan Kamar Operasi)';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signout_q2
    IS 'Kelengkapan alat, jumlah kasa dan jarum';

COMMENT ON COLUMN public.dokumen_checklist_keselamatan_pasien_operasi.signout_q3
    IS 'Pelabelan specimen (baca label dan nama pasien dengan keras)';
-- Index: idx_checklist_alergi

-- DROP INDEX IF EXISTS public.idx_checklist_alergi;

CREATE INDEX IF NOT EXISTS idx_checklist_alergi
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (signin_q5 COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default
    WHERE signin_q5::text = 'ya'::text;
-- Index: idx_checklist_keselamatan_created_at

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_created_at;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_created_at
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (created_at ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_keselamatan_deleted_at

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_deleted_at;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_deleted_at
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (deleted_at ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_keselamatan_dr_bedah

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_dr_bedah;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_dr_bedah
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (signout_nama_dr_bedah COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_keselamatan_no_rm

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_no_rm;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_no_rm
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (no_rm COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_keselamatan_tanggal

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_tanggal;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_tanggal
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (tanggal_ttd ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_keselamatan_uuid_pasien

-- DROP INDEX IF EXISTS public.idx_checklist_keselamatan_uuid_pasien;

CREATE INDEX IF NOT EXISTS idx_checklist_keselamatan_uuid_pasien
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (uuid_pasien ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_checklist_perdarahan

-- DROP INDEX IF EXISTS public.idx_checklist_perdarahan;

CREATE INDEX IF NOT EXISTS idx_checklist_perdarahan
    ON public.dokumen_checklist_keselamatan_pasien_operasi USING btree
    (signin_q7 COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default
    WHERE signin_q7::text = 'ya_direncanakan'::text;


-- Table: public.dokumen_cppt_rawat_jalan

-- DROP TABLE IF EXISTS public.dokumen_cppt_rawat_jalan;

CREATE TABLE IF NOT EXISTS public.dokumen_cppt_rawat_jalan
(
    id bigint NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1 ),
    uuid character varying(255) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(255) COLLATE pg_catalog."default",
    no_rm character varying(100) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    nik character varying(100) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    tanggal date,
    cppt_rows jsonb,
    catatan_khusus text COLLATE pg_catalog."default",
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    deleted_at timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT dokumen_cppt_rawat_jalan_pkey PRIMARY KEY (id, uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_cppt_rawat_jalan
    OWNER to postgres;
-- Index: dokumen_cppt_rawat_jalan_uuid_unique

-- DROP INDEX IF EXISTS public.dokumen_cppt_rawat_jalan_uuid_unique;

CREATE UNIQUE INDEX IF NOT EXISTS dokumen_cppt_rawat_jalan_uuid_unique
    ON public.dokumen_cppt_rawat_jalan USING btree
    (uuid COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;


-- Table: public.dokumen_evaluasi_pra_anestesi

-- DROP TABLE IF EXISTS public.dokumen_evaluasi_pra_anestesi;

CREATE TABLE IF NOT EXISTS public.dokumen_evaluasi_pra_anestesi
(
    id bigint NOT NULL DEFAULT nextval('dokumen_evaluasi_pra_anestesi_id_seq'::regclass),
    uuid character varying(36) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(36) COLLATE pg_catalog."default",
    no_rm character varying(50) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir character varying(20) COLLATE pg_catalog."default",
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    tanggal_ttd date,
    diagnosa_medis character varying(255) COLLATE pg_catalog."default",
    tanggal date,
    jam character varying(10) COLLATE pg_catalog."default",
    ruangan character varying(100) COLLATE pg_catalog."default",
    umur character varying(20) COLLATE pg_catalog."default",
    jk character varying(5) COLLATE pg_catalog."default",
    menikah character varying(5) COLLATE pg_catalog."default",
    pekerjaan character varying(100) COLLATE pg_catalog."default",
    merokok character varying(5) COLLATE pg_catalog."default",
    merokok_sebanyak character varying(100) COLLATE pg_catalog."default",
    kopi_teh_soda character varying(5) COLLATE pg_catalog."default",
    kopi_teh_soda_sebanyak character varying(100) COLLATE pg_catalog."default",
    alkohol character varying(5) COLLATE pg_catalog."default",
    alkohol_sebanyak character varying(100) COLLATE pg_catalog."default",
    olahraga_rutin character varying(5) COLLATE pg_catalog."default",
    olahraga_rutin_sebanyak character varying(100) COLLATE pg_catalog."default",
    obat_resep text COLLATE pg_catalog."default",
    obat_bebas text COLLATE pg_catalog."default",
    aspirin_rutin character varying(5) COLLATE pg_catalog."default",
    aspirin_dosis character varying(255) COLLATE pg_catalog."default",
    obat_anti_sakit character varying(5) COLLATE pg_catalog."default",
    obat_anti_sakit_dosis character varying(255) COLLATE pg_catalog."default",
    injeksi_steroid character varying(5) COLLATE pg_catalog."default",
    injeksi_steroid_info character varying(255) COLLATE pg_catalog."default",
    alergi_obat character varying(5) COLLATE pg_catalog."default",
    alergi_obat_daftar text COLLATE pg_catalog."default",
    alergi_lateks character varying(5) COLLATE pg_catalog."default",
    alergi_plaster character varying(5) COLLATE pg_catalog."default",
    alergi_makanan character varying(5) COLLATE pg_catalog."default",
    kel_perdarahan character varying(5) COLLATE pg_catalog."default",
    kel_serangan_jantung character varying(5) COLLATE pg_catalog."default",
    kel_pembekuan character varying(5) COLLATE pg_catalog."default",
    kel_hipertensi character varying(5) COLLATE pg_catalog."default",
    kel_pembuluh_darah character varying(5) COLLATE pg_catalog."default",
    kel_tuberkulosis character varying(5) COLLATE pg_catalog."default",
    kel_operasi_jantung character varying(5) COLLATE pg_catalog."default",
    kel_penyakit_berat_lainnya character varying(5) COLLATE pg_catalog."default",
    kel_diabetes character varying(5) COLLATE pg_catalog."default",
    kel_jelaskan text COLLATE pg_catalog."default",
    bahasa_indonesia character varying(5) COLLATE pg_catalog."default",
    bahasa_lainnya_cb character varying(5) COLLATE pg_catalog."default",
    bahasa_lainnya character varying(100) COLLATE pg_catalog."default",
    gangguan_penglihatan character varying(5) COLLATE pg_catalog."default",
    gangguan_pendengaran character varying(5) COLLATE pg_catalog."default",
    gangguan_bicara character varying(5) COLLATE pg_catalog."default",
    rp_perdarahan character varying(5) COLLATE pg_catalog."default",
    rp_serangan_jantung character varying(5) COLLATE pg_catalog."default",
    rp_pembekuan character varying(5) COLLATE pg_catalog."default",
    rp_hepatitis character varying(5) COLLATE pg_catalog."default",
    rp_sakit_maag character varying(5) COLLATE pg_catalog."default",
    rp_sleep_apnea character varying(5) COLLATE pg_catalog."default",
    rp_stroke character varying(5) COLLATE pg_catalog."default",
    rp_penyakit_berat_lainnya character varying(5) COLLATE pg_catalog."default",
    rp_sesak_napas character varying(5) COLLATE pg_catalog."default",
    rp_asma character varying(5) COLLATE pg_catalog."default",
    rp_diabetes character varying(5) COLLATE pg_catalog."default",
    rp_pingsan character varying(5) COLLATE pg_catalog."default",
    rp_jelaskan text COLLATE pg_catalog."default",
    transfusi_darah character varying(5) COLLATE pg_catalog."default",
    transfusi_darah_tahun character varying(20) COLLATE pg_catalog."default",
    hiv_diperiksa character varying(5) COLLATE pg_catalog."default",
    hiv_tahun character varying(20) COLLATE pg_catalog."default",
    hiv_hasil character varying(20) COLLATE pg_catalog."default",
    kemoterapi_radioterapi character varying(100) COLLATE pg_catalog."default",
    lensa_kontak character varying(5) COLLATE pg_catalog."default",
    kacamata character varying(5) COLLATE pg_catalog."default",
    alat_bantu_dengar character varying(5) COLLATE pg_catalog."default",
    gigi_palsu_alat character varying(5) COLLATE pg_catalog."default",
    riwayat_operasi text COLLATE pg_catalog."default",
    anestesi_lokal_komplikasi text COLLATE pg_catalog."default",
    anestesi_regional_komplikasi text COLLATE pg_catalog."default",
    anestesi_umum_komplikasi text COLLATE pg_catalog."default",
    tgl_terakhir_periksa character varying(100) COLLATE pg_catalog."default",
    tempat_periksa character varying(100) COLLATE pg_catalog."default",
    penyakit_gangguan character varying(255) COLLATE pg_catalog."default",
    jumlah_kehamilan character varying(20) COLLATE pg_catalog."default",
    jumlah_anak character varying(20) COLLATE pg_catalog."default",
    menstruasi_terakhir character varying(50) COLLATE pg_catalog."default",
    menyusui character varying(5) COLLATE pg_catalog."default",
    dok_hilangnya_gigi character varying(5) COLLATE pg_catalog."default",
    dok_sakit_dada character varying(5) COLLATE pg_catalog."default",
    dok_mobilisasi_lider character varying(5) COLLATE pg_catalog."default",
    dok_denyut_jantung character varying(5) COLLATE pg_catalog."default",
    dok_lebar_perotok character varying(5) COLLATE pg_catalog."default",
    dok_muntah character varying(5) COLLATE pg_catalog."default",
    dok_sakit_tenggorokan character varying(5) COLLATE pg_catalog."default",
    dok_perut_pusing character varying(5) COLLATE pg_catalog."default",
    dok_sesak_nafas character varying(5) COLLATE pg_catalog."default",
    dok_kejang character varying(5) COLLATE pg_catalog."default",
    dok_baru_infeksi character varying(5) COLLATE pg_catalog."default",
    dok_sedang_hamil character varying(5) COLLATE pg_catalog."default",
    dok_saluran_nafas_atas character varying(5) COLLATE pg_catalog."default",
    dok_pingsan character varying(5) COLLATE pg_catalog."default",
    dok_menstruasi_tidak_normal character varying(5) COLLATE pg_catalog."default",
    dok_obesitas character varying(5) COLLATE pg_catalog."default",
    dok_stroke character varying(5) COLLATE pg_catalog."default",
    dok_keterangan text COLLATE pg_catalog."default",
    dok_periode_tidak_stabil text COLLATE pg_catalog."default",
    kesadaran character varying(100) COLLATE pg_catalog."default",
    visue character varying(100) COLLATE pg_catalog."default",
    faring character varying(100) COLLATE pg_catalog."default",
    gigi_palsu character varying(100) COLLATE pg_catalog."default",
    tinggi character varying(20) COLLATE pg_catalog."default",
    berat character varying(20) COLLATE pg_catalog."default",
    td character varying(20) COLLATE pg_catalog."default",
    nadi character varying(20) COLLATE pg_catalog."default",
    suhu character varying(20) COLLATE pg_catalog."default",
    paru_paru text COLLATE pg_catalog."default",
    jantung text COLLATE pg_catalog."default",
    abdomen text COLLATE pg_catalog."default",
    ekstrimitas text COLLATE pg_catalog."default",
    neurologi text COLLATE pg_catalog."default",
    fisik_keterangan text COLLATE pg_catalog."default",
    lab_hb_ht character varying(100) COLLATE pg_catalog."default",
    lab_rontgen_dada character varying(100) COLLATE pg_catalog."default",
    lab_pt_aptt character varying(100) COLLATE pg_catalog."default",
    lab_ekg character varying(100) COLLATE pg_catalog."default",
    lab_tes_kehamilan character varying(100) COLLATE pg_catalog."default",
    lab_co2 character varying(100) COLLATE pg_catalog."default",
    lab_kalium character varying(100) COLLATE pg_catalog."default",
    lab_kreatinin character varying(100) COLLATE pg_catalog."default",
    lab_uream character varying(100) COLLATE pg_catalog."default",
    lab_glukosa character varying(100) COLLATE pg_catalog."default",
    lab_lain_lain character varying(255) COLLATE pg_catalog."default",
    lab_keterangan character varying(255) COLLATE pg_catalog."default",
    asa_klasifikasi character varying(10) COLLATE pg_catalog."default",
    rek_anestesi_umum character varying(5) COLLATE pg_catalog."default",
    rek_au_intevena character varying(5) COLLATE pg_catalog."default",
    rek_au_sungkup_muka character varying(5) COLLATE pg_catalog."default",
    rek_au_lma character varying(5) COLLATE pg_catalog."default",
    rek_au_ett character varying(5) COLLATE pg_catalog."default",
    rek_regional character varying(5) COLLATE pg_catalog."default",
    rek_reg_spinal character varying(5) COLLATE pg_catalog."default",
    rek_reg_epidural character varying(5) COLLATE pg_catalog."default",
    rek_reg_cse character varying(5) COLLATE pg_catalog."default",
    rek_reg_pnb character varying(5) COLLATE pg_catalog."default",
    rek_umum_plus_regional character varying(5) COLLATE pg_catalog."default",
    puasa_mulai_jam character varying(10) COLLATE pg_catalog."default",
    puasa_mulai_tanggal character varying(20) COLLATE pg_catalog."default",
    rencana_elasi_jam character varying(10) COLLATE pg_catalog."default",
    rencana_elasi_tanggal character varying(20) COLLATE pg_catalog."default",
    rencana_operasi_jam character varying(10) COLLATE pg_catalog."default",
    rencana_operasi_tanggal character varying(20) COLLATE pg_catalog."default",
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_timestamp character varying(100) COLLATE pg_catalog."default",
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_evaluasi_pra_anestesi_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_evaluasi_pra_anestesi_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_evaluasi_pra_anestesi
    OWNER to postgres;


-- Table: public.dokumen_formulir_konsul_dan_jawaban_konsul

-- DROP TABLE IF EXISTS public.dokumen_formulir_konsul_dan_jawaban_konsul;

CREATE TABLE IF NOT EXISTS public.dokumen_formulir_konsul_dan_jawaban_konsul
(
    id bigint NOT NULL DEFAULT nextval('dokumen_formulir_konsul_dan_jawaban_konsul_id_seq'::regclass),
    uuid uuid NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien uuid NOT NULL,
    no_rm character varying(50) COLLATE pg_catalog."default",
    nik character varying(20) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default" DEFAULT 'RM 10.2/FKDJK/22'::character varying,
    dokter_tujuan_konsul character varying(255) COLLATE pg_catalog."default",
    jenis_konsul character varying(5) COLLATE pg_catalog."default",
    diagnosa text COLLATE pg_catalog."default",
    persangkaan_diagnosis text COLLATE pg_catalog."default",
    temuan_klinis text COLLATE pg_catalog."default",
    pengobatan_tindakan_sebelumnya text COLLATE pg_catalog."default",
    tanggal_konsul date,
    jam_konsul character varying(10) COLLATE pg_catalog."default",
    ttd_dokter_pengirim text COLLATE pg_catalog."default",
    nama_dokter_pengirim character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_pengirim_timestamp character varying(50) COLLATE pg_catalog."default",
    dokter_tujuan_jawaban character varying(255) COLLATE pg_catalog."default",
    tanggal_permintaan_konsul_ref date,
    hasil_konsul text COLLATE pg_catalog."default",
    anjuran_pemeriksaan_tindakan text COLLATE pg_catalog."default",
    anjuran_konsul_lanjut_dokter character varying(255) COLLATE pg_catalog."default",
    anjuran_konsul_lanjut_bagian character varying(255) COLLATE pg_catalog."default",
    terapi_anjuran text COLLATE pg_catalog."default",
    tanggal_jawaban date,
    jam_jawaban character varying(10) COLLATE pg_catalog."default",
    ttd_dokter_konsultan text COLLATE pg_catalog."default",
    nama_dokter_konsultan character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_konsultan_timestamp character varying(50) COLLATE pg_catalog."default",
    created_by character varying(100) COLLATE pg_catalog."default",
    updated_by character varying(100) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_formulir_konsul_dan_jawaban_konsul_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_formulir_konsul_dan_jawaban_konsul_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_formulir_konsul_dan_jawaban_konsul
    OWNER to postgres;

-- Table: public.dokumen_informasi_tindakan_anastesi

-- DROP TABLE IF EXISTS public.dokumen_informasi_tindakan_anastesi;

CREATE TABLE IF NOT EXISTS public.dokumen_informasi_tindakan_anastesi
(
    id bigint NOT NULL DEFAULT nextval('dokumen_informasi_tindakan_anastesi_id_seq'::regclass),
    uuid character varying(36) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(36) COLLATE pg_catalog."default",
    no_rm character varying(50) COLLATE pg_catalog."default",
    nik character varying(20) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    nama_pasien_atau_wali character varying(255) COLLATE pg_catalog."default",
    umur_jenis_kelamin character varying(100) COLLATE pg_catalog."default",
    no_telp character varying(50) COLLATE pg_catalog."default",
    hubungan character varying(50) COLLATE pg_catalog."default",
    diagnosa text COLLATE pg_catalog."default",
    rencana_tindakan text COLLATE pg_catalog."default",
    jenis_anestesia character varying(255) COLLATE pg_catalog."default",
    baca_au boolean DEFAULT false,
    baca_spinal boolean DEFAULT false,
    baca_blok boolean DEFAULT false,
    baca_sedasi boolean DEFAULT false,
    baca_topikal boolean DEFAULT false,
    tanggal_surat date,
    jam_surat character varying(10) COLLATE pg_catalog."default",
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_timestamp timestamp without time zone,
    ttd_pihak text COLLATE pg_catalog."default",
    nama_pihak character varying(255) COLLATE pg_catalog."default",
    ttd_pihak_timestamp timestamp without time zone,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_informasi_tindakan_anastesi_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_informasi_tindakan_anastesi_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_informasi_tindakan_anastesi
    OWNER to postgres;

-- Table: public.dokumen_pemberian_edukasi_pasien_terintegrasi

-- DROP TABLE IF EXISTS public.dokumen_pemberian_edukasi_pasien_terintegrasi;

CREATE TABLE IF NOT EXISTS public.dokumen_pemberian_edukasi_pasien_terintegrasi
(
    id bigint NOT NULL DEFAULT nextval('dokumen_pemberian_edukasi_pasien_terintegrasi_id_seq'::regclass),
    uuid character varying(36) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(36) COLLATE pg_catalog."default",
    no_rm character varying(50) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    tanggal_kunjungan date,
    jam_kunjungan character varying(10) COLLATE pg_catalog."default",
    edukasi_sections jsonb,
    tanggal date,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    deleted_at timestamp without time zone,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    CONSTRAINT dokumen_pemberian_edukasi_pasien_terintegrasi_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_pemberian_edukasi_pasien_terintegrasi_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_pemberian_edukasi_pasien_terintegrasi
    OWNER to postgres;


-- Table: public.dokumen_pengkajian_awal_medis_mata

-- DROP TABLE IF EXISTS public.dokumen_pengkajian_awal_medis_mata;

CREATE TABLE IF NOT EXISTS public.dokumen_pengkajian_awal_medis_mata
(
    id bigint NOT NULL DEFAULT nextval('dokumen_pengkajian_awal_medis_mata_id_seq'::regclass),
    uuid text COLLATE pg_catalog."default",
    uuid_pasien text COLLATE pg_catalog."default",
    no_rm text COLLATE pg_catalog."default",
    no_surat text COLLATE pg_catalog."default" DEFAULT 'RM 7.7/PAMM/22'::text,
    nik text COLLATE pg_catalog."default",
    nama text COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin text COLLATE pg_catalog."default",
    tanggal text COLLATE pg_catalog."default",
    jam text COLLATE pg_catalog."default",
    alergi text COLLATE pg_catalog."default",
    sumber_pasien smallint DEFAULT 0,
    sumber_keluarga smallint DEFAULT 0,
    sumber_teman smallint DEFAULT 0,
    sumber_lainnya smallint DEFAULT 0,
    sumber_lainnya_text text COLLATE pg_catalog."default",
    skala_nyeri text COLLATE pg_catalog."default",
    skala_nyeri_text text COLLATE pg_catalog."default",
    nyeri_ada text COLLATE pg_catalog."default",
    nyeri_lokasi text COLLATE pg_catalog."default",
    nyeri_karakteristik text COLLATE pg_catalog."default",
    nyeri_durasi text COLLATE pg_catalog."default",
    nyeri_frekuensi text COLLATE pg_catalog."default",
    keluhan_utama text COLLATE pg_catalog."default",
    riwayat_penyakit_sekarang text COLLATE pg_catalog."default",
    riwayat_penyakit_dahulu text COLLATE pg_catalog."default",
    riwayat_pengobatan text COLLATE pg_catalog."default",
    rpk_hipertensi smallint DEFAULT 0,
    rpk_diabetes smallint DEFAULT 0,
    rpk_jantung smallint DEFAULT 0,
    rpk_stroke smallint DEFAULT 0,
    rpk_dialysis smallint DEFAULT 0,
    rpk_asthma smallint DEFAULT 0,
    rpk_kejang smallint DEFAULT 0,
    rpk_liver smallint DEFAULT 0,
    rpk_cancer smallint DEFAULT 0,
    rpk_tbc smallint DEFAULT 0,
    rpk_glaukoma smallint DEFAULT 0,
    rpk_std smallint DEFAULT 0,
    rpk_perdarahan smallint DEFAULT 0,
    rpk_lain_lain smallint DEFAULT 0,
    rpk_lain_lain_text text COLLATE pg_catalog."default",
    riwayat_operasi text COLLATE pg_catalog."default",
    riwayat_operasi_keterangan text COLLATE pg_catalog."default",
    riwayat_transfusi text COLLATE pg_catalog."default",
    reaksi_transfusi text COLLATE pg_catalog."default",
    reaksi_transfusi_text text COLLATE pg_catalog."default",
    riwayat_sosial text COLLATE pg_catalog."default",
    keadaan_umum text COLLATE pg_catalog."default",
    gizi text COLLATE pg_catalog."default",
    gcs_e text COLLATE pg_catalog."default",
    gcs_m text COLLATE pg_catalog."default",
    gcs_v text COLLATE pg_catalog."default",
    bb numeric(5,2),
    tindakan_resusitasi text COLLATE pg_catalog."default",
    tensi text COLLATE pg_catalog."default",
    suhu_ttv numeric(5,2),
    nadi_ttv text COLLATE pg_catalog."default",
    respirasi text COLLATE pg_catalog."default",
    saturasi_o2 numeric(5,2),
    oksigen_jenis text COLLATE pg_catalog."default",
    oksigen_lainnya_text text COLLATE pg_catalog."default",
    pf_ku_baik smallint DEFAULT 0,
    pf_ku_sedang smallint DEFAULT 0,
    pf_ku_lemah smallint DEFAULT 0,
    pf_ku_buruk smallint DEFAULT 0,
    pf_kes_cm smallint DEFAULT 0,
    pf_kes_somnolen smallint DEFAULT 0,
    pf_kes_koma smallint DEFAULT 0,
    pf_gcs_e text COLLATE pg_catalog."default",
    pf_gcs_v text COLLATE pg_catalog."default",
    pf_gcs_m text COLLATE pg_catalog."default",
    tekanan_darah text COLLATE pg_catalog."default",
    nadi_pf text COLLATE pg_catalog."default",
    nadi_regularitas text COLLATE pg_catalog."default",
    rr text COLLATE pg_catalog."default",
    spo2 numeric(5,2),
    temp numeric(5,2),
    reflex_cahaya text COLLATE pg_catalog."default",
    akral text COLLATE pg_catalog."default",
    kepala text COLLATE pg_catalog."default",
    leher text COLLATE pg_catalog."default",
    jantung_inspeksi text COLLATE pg_catalog."default",
    jantung_palpasi text COLLATE pg_catalog."default",
    jantung_perkusi text COLLATE pg_catalog."default",
    jantung_auskultasi text COLLATE pg_catalog."default",
    mata_visus_od text COLLATE pg_catalog."default",
    mata_visus_os text COLLATE pg_catalog."default",
    mata_pgbm_od text COLLATE pg_catalog."default",
    mata_pgbm_os text COLLATE pg_catalog."default",
    mata_palpebra_sup_od text COLLATE pg_catalog."default",
    mata_palpebra_sup_os text COLLATE pg_catalog."default",
    mata_palpebra_inf_od text COLLATE pg_catalog."default",
    mata_palpebra_inf_os text COLLATE pg_catalog."default",
    mata_kornea_od text COLLATE pg_catalog."default",
    mata_kornea_os text COLLATE pg_catalog."default",
    mata_iris_od text COLLATE pg_catalog."default",
    mata_iris_os text COLLATE pg_catalog."default",
    mata_konjungtiva_od text COLLATE pg_catalog."default",
    mata_konjungtiva_os text COLLATE pg_catalog."default",
    mata_sekret_od text COLLATE pg_catalog."default",
    mata_sekret_os text COLLATE pg_catalog."default",
    mata_tio_od text COLLATE pg_catalog."default",
    mata_tio_os text COLLATE pg_catalog."default",
    mata_pupil_reflek_od text COLLATE pg_catalog."default",
    mata_pupil_reflek_os text COLLATE pg_catalog."default",
    mata_pupil_ukuran_od text COLLATE pg_catalog."default",
    mata_pupil_ukuran_os text COLLATE pg_catalog."default",
    mata_pupil_isokor_od text COLLATE pg_catalog."default",
    mata_pupil_isokor_os text COLLATE pg_catalog."default",
    status_lokalis text COLLATE pg_catalog."default",
    pemeriksaan_penunjang text COLLATE pg_catalog."default",
    diagnosa_kerja text COLLATE pg_catalog."default",
    diagnosa_diferensial text COLLATE pg_catalog."default",
    terapi text COLLATE pg_catalog."default",
    rencana_kerja text COLLATE pg_catalog."default",
    hasil_pembedahan text COLLATE pg_catalog."default",
    cb_boleh_pulang smallint DEFAULT 0,
    disposisi_pulang_jam text COLLATE pg_catalog."default",
    disposisi_pulang_tanggal text COLLATE pg_catalog."default",
    cb_kontrol_poliklinik smallint DEFAULT 0,
    kontrol_poliklinik text COLLATE pg_catalog."default",
    kontrol_tujuan text COLLATE pg_catalog."default",
    kontrol_tanggal text COLLATE pg_catalog."default",
    cb_dirawat_ruangan smallint DEFAULT 0,
    cb_dirawat_kelas smallint DEFAULT 0,
    dirawat_ruangan text COLLATE pg_catalog."default",
    dirawat_kelas text COLLATE pg_catalog."default",
    rekomendasi text COLLATE pg_catalog."default",
    catatan_penting text COLLATE pg_catalog."default",
    kota_ttd text COLLATE pg_catalog."default",
    tanggal_ttd text COLLATE pg_catalog."default",
    jam_ttd text COLLATE pg_catalog."default",
    ttd_dpjp text COLLATE pg_catalog."default",
    nama_dpjp text COLLATE pg_catalog."default",
    ttd_dpjp_timestamp text COLLATE pg_catalog."default",
    created_by text COLLATE pg_catalog."default",
    updated_by text COLLATE pg_catalog."default",
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_pengkajian_awal_medis_mata_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_pengkajian_awal_medis_mata_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_pengkajian_awal_medis_mata
    OWNER to postgres;

-- Table: public.dokumen_persiapan_peralatan_anestesi

-- DROP TABLE IF EXISTS public.dokumen_persiapan_peralatan_anestesi;

CREATE TABLE IF NOT EXISTS public.dokumen_persiapan_peralatan_anestesi
(
    id integer NOT NULL DEFAULT nextval('dokumen_persiapan_peralatan_anestesi_id_seq'::regclass),
    uuid character varying(50) COLLATE pg_catalog."default" NOT NULL,
    uuid_pasien character varying(50) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    no_rm character varying(25) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    no_surat character varying(50) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    nik character varying(50) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    nama character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    tanggal_lahir date DEFAULT '1000-01-10'::date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    ruangan character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    tanggal_tindakan date DEFAULT '1000-01-10'::date,
    jam_tindakan character varying(10) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    jenis_operasi character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    teknik_anestesia character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    check_mesin_anestesia boolean NOT NULL DEFAULT false,
    check_layar_pemantauan boolean NOT NULL DEFAULT false,
    check_defibrilator boolean NOT NULL DEFAULT false,
    check_selang_oksigen boolean NOT NULL DEFAULT false,
    check_flow_o2 boolean NOT NULL DEFAULT false,
    check_compressed_air boolean NOT NULL DEFAULT false,
    check_flow_air boolean NOT NULL DEFAULT false,
    check_n2o boolean NOT NULL DEFAULT false,
    check_flow_n2o boolean NOT NULL DEFAULT false,
    check_power_on boolean NOT NULL DEFAULT false,
    check_self_calibration boolean NOT NULL DEFAULT false,
    check_tidak_bocor boolean NOT NULL DEFAULT false,
    check_zat_volatil boolean NOT NULL DEFAULT false,
    check_absorber_co2 boolean NOT NULL DEFAULT false,
    check_sungkup_muka boolean NOT NULL DEFAULT false,
    check_oropharyngeal boolean NOT NULL DEFAULT false,
    check_laringoskop_baterai boolean NOT NULL DEFAULT false,
    check_bilah_laringoskop boolean NOT NULL DEFAULT false,
    check_gagang_bilah boolean NOT NULL DEFAULT false,
    check_ett_lma boolean NOT NULL DEFAULT false,
    check_stilet boolean NOT NULL DEFAULT false,
    check_semprit_cuff boolean NOT NULL DEFAULT false,
    check_forceps_magill boolean NOT NULL DEFAULT false,
    check_kabel_ekg boolean NOT NULL DEFAULT false,
    check_elektroda_ekg boolean NOT NULL DEFAULT false,
    check_nibp boolean NOT NULL DEFAULT false,
    check_spo2 boolean NOT NULL DEFAULT false,
    check_kapnografi boolean NOT NULL DEFAULT false,
    check_pemantau_suhu boolean NOT NULL DEFAULT false,
    check_stetoskop boolean NOT NULL DEFAULT false,
    check_suction boolean NOT NULL DEFAULT false,
    check_selang_suction boolean NOT NULL DEFAULT false,
    check_plester boolean NOT NULL DEFAULT false,
    check_blanket_roll boolean NOT NULL DEFAULT false,
    check_blanket_alas boolean NOT NULL DEFAULT false,
    check_xylocaine boolean NOT NULL DEFAULT false,
    check_epinefrin boolean NOT NULL DEFAULT false,
    check_atropin boolean NOT NULL DEFAULT false,
    check_sedatif boolean NOT NULL DEFAULT false,
    check_opiat boolean NOT NULL DEFAULT false,
    check_pelumpuh_otot boolean NOT NULL DEFAULT false,
    check_antibiotika boolean NOT NULL DEFAULT false,
    lain_lain_obat text COLLATE pg_catalog."default" DEFAULT '-'::text,
    ttd_perawat_anestesi text COLLATE pg_catalog."default" DEFAULT '-'::text,
    nama_perawat_anestesi character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    ttd_perawat_timestamp character varying(100) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    ttd_dr_anestesi text COLLATE pg_catalog."default" DEFAULT '-'::text,
    nama_dr_anestesi character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    ttd_dr_timestamp character varying(100) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    created_by character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    updated_by character varying(255) COLLATE pg_catalog."default" DEFAULT '-'::character varying,
    created_at timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_persiapan_peralatan_anestesi_pk PRIMARY KEY (id, uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_persiapan_peralatan_anestesi
    OWNER to postgres;

-- Table: public.dokumen_protokol_tindakan_terapi

-- DROP TABLE IF EXISTS public.dokumen_protokol_tindakan_terapi;

CREATE TABLE IF NOT EXISTS public.dokumen_protokol_tindakan_terapi
(
    id bigint NOT NULL DEFAULT nextval('dokumen_protokol_tindakan_terapi_id_seq'::regclass),
    uuid uuid NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien uuid NOT NULL,
    no_rm character varying(50) COLLATE pg_catalog."default",
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    perusahaan character varying(255) COLLATE pg_catalog."default",
    no_kartu character varying(100) COLLATE pg_catalog."default",
    tanggal_jam_masuk timestamp without time zone,
    ruang_kelas character varying(100) COLLATE pg_catalog."default",
    keluhan_pasien text COLLATE pg_catalog."default",
    pengobatan_diberikan text COLLATE pg_catalog."default",
    tindakan_medis text COLLATE pg_catalog."default",
    biaya_diperlukan character varying(255) COLLATE pg_catalog."default",
    alasan_tindakan text COLLATE pg_catalog."default",
    diagnosa_sementara text COLLATE pg_catalog."default",
    tanggal_surat date,
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter_merawat character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_timestamp character varying(100) COLLATE pg_catalog."default",
    ttd_penyetuju text COLLATE pg_catalog."default",
    nama_penyetuju character varying(255) COLLATE pg_catalog."default",
    ttd_penyetuju_timestamp character varying(100) COLLATE pg_catalog."default",
    status_persetujuan character varying(50) COLLATE pg_catalog."default",
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp without time zone,
    no_surat character varying(100) COLLATE pg_catalog."default" DEFAULT 'RM 9.6/PTT/22'::character varying,
    CONSTRAINT dokumen_protokol_tindakan_terapi_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_protokol_tindakan_terapi_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_protokol_tindakan_terapi
    OWNER to postgres;

COMMENT ON TABLE public.dokumen_protokol_tindakan_terapi
    IS 'Protokol Tindakan Terapi - RM 9.6/PTT/22';
-- Index: idx_ptt_no_rm

-- DROP INDEX IF EXISTS public.idx_ptt_no_rm;

CREATE INDEX IF NOT EXISTS idx_ptt_no_rm
    ON public.dokumen_protokol_tindakan_terapi USING btree
    (no_rm COLLATE pg_catalog."default" ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_ptt_tanggal

-- DROP INDEX IF EXISTS public.idx_ptt_tanggal;

CREATE INDEX IF NOT EXISTS idx_ptt_tanggal
    ON public.dokumen_protokol_tindakan_terapi USING btree
    (tanggal_surat ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: idx_ptt_uuid_pasien

-- DROP INDEX IF EXISTS public.idx_ptt_uuid_pasien;

CREATE INDEX IF NOT EXISTS idx_ptt_uuid_pasien
    ON public.dokumen_protokol_tindakan_terapi USING btree
    (uuid_pasien ASC NULLS LAST)
    TABLESPACE pg_default;

-- Table: public.dokumen_surat_keterangan_mata

-- DROP TABLE IF EXISTS public.dokumen_surat_keterangan_mata;

CREATE TABLE IF NOT EXISTS public.dokumen_surat_keterangan_mata
(
    id bigint NOT NULL DEFAULT nextval('dokumen_surat_keterangan_mata_id_seq'::regclass),
    uuid uuid NOT NULL,
    uuid_pasien uuid,
    no_rm character varying(50) COLLATE pg_catalog."default",
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    autorefkeratometry_od character varying(255) COLLATE pg_catalog."default",
    autorefkeratometry_os character varying(255) COLLATE pg_catalog."default",
    visus_od character varying(100) COLLATE pg_catalog."default",
    visus_os character varying(100) COLLATE pg_catalog."default",
    tonometry_od character varying(50) COLLATE pg_catalog."default",
    tonometry_os character varying(50) COLLATE pg_catalog."default",
    diagnosa text COLLATE pg_catalog."default",
    tanggal_surat date,
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter character varying(255) COLLATE pg_catalog."default",
    email_dokter character varying(255) COLLATE pg_catalog."default",
    hp_dokter character varying(50) COLLATE pg_catalog."default",
    ttd_dokter_timestamp timestamp without time zone,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    deleted_at timestamp without time zone,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    CONSTRAINT dokumen_surat_keterangan_mata_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_surat_keterangan_mata_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_surat_keterangan_mata
    OWNER to postgres;

-- Table: public.dokumen_surat_keterangan_hasil_pemeriksaan_mata

-- DROP TABLE IF EXISTS public.dokumen_surat_keterangan_hasil_pemeriksaan_mata;

CREATE TABLE IF NOT EXISTS public.dokumen_surat_keterangan_hasil_pemeriksaan_mata
(
    id bigint NOT NULL DEFAULT nextval('dokumen_surat_keterangan_hasil_pemeriksaan_mata_id_seq'::regclass),
    uuid uuid NOT NULL,
    uuid_pasien uuid,
    no_rm character varying(50) COLLATE pg_catalog."default",
    nik character varying(50) COLLATE pg_catalog."default",
    nama character varying(255) COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin character varying(20) COLLATE pg_catalog."default",
    no_surat character varying(100) COLLATE pg_catalog."default",
    tempat_lahir character varying(255) COLLATE pg_catalog."default",
    alamat text COLLATE pg_catalog."default",
    va_od character varying(100) COLLATE pg_catalog."default",
    koreksi_od character varying(255) COLLATE pg_catalog."default",
    va_os character varying(100) COLLATE pg_catalog."default",
    koreksi_os character varying(255) COLLATE pg_catalog."default",
    tio_od character varying(50) COLLATE pg_catalog."default",
    tio_os character varying(50) COLLATE pg_catalog."default",
    penglihatan_warna character varying(255) COLLATE pg_catalog."default",
    kesimpulan text COLLATE pg_catalog."default",
    saran text COLLATE pg_catalog."default",
    pasfoto character varying(500) COLLATE pg_catalog."default",
    tanggal_surat date,
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter character varying(255) COLLATE pg_catalog."default",
    ttd_dokter_timestamp timestamp without time zone,
    created_by character varying(255) COLLATE pg_catalog."default",
    updated_by character varying(255) COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    deleted_at timestamp without time zone,
    CONSTRAINT dokumen_surat_keterangan_hasil_pemeriksaan_mata_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_surat_keterangan_hasil_pemeriksaan_mata_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_surat_keterangan_hasil_pemeriksaan_mata
    OWNER to postgres;

-- Table: public.dokumen_penilaian_risiko_jatuh_pasien_geriatri

-- DROP TABLE IF EXISTS public.dokumen_penilaian_risiko_jatuh_pasien_geriatri;

CREATE TABLE IF NOT EXISTS public.dokumen_penilaian_risiko_jatuh_pasien_geriatri
(
    id bigint NOT NULL DEFAULT nextval('dokumen_penilaian_risiko_jatuh_pasien_geriatri_id_seq'::regclass),
    uuid text COLLATE pg_catalog."default" NOT NULL DEFAULT (gen_random_uuid())::text,
    uuid_pasien text COLLATE pg_catalog."default",
    no_rm text COLLATE pg_catalog."default",
    no_surat text COLLATE pg_catalog."default" DEFAULT 'RM 6.5/FPRJPG/22'::text,
    nik text COLLATE pg_catalog."default",
    nama text COLLATE pg_catalog."default",
    tanggal_lahir date,
    jenis_kelamin text COLLATE pg_catalog."default",
    tanggal date,
    jam text COLLATE pg_catalog."default",
    item_1 smallint DEFAULT 0,
    item_2 smallint DEFAULT 0,
    item_3 smallint DEFAULT 0,
    item_4 smallint DEFAULT 0,
    item_5 smallint DEFAULT 0,
    item_6 smallint DEFAULT 0,
    item_7 smallint DEFAULT 0,
    item_8 smallint DEFAULT 0,
    item_9 smallint DEFAULT 0,
    item_10 smallint DEFAULT 0,
    item_11 smallint DEFAULT 0,
    total_skor integer DEFAULT 0,
    risiko_level text COLLATE pg_catalog."default",
    nama_penilai text COLLATE pg_catalog."default",
    int_a1 smallint,
    int_a2 smallint,
    int_a3 smallint,
    int_a4 smallint,
    int_b1 smallint,
    int_b2 smallint,
    int_b3 smallint,
    int_b4 smallint,
    int_b5 smallint,
    int_b6 smallint,
    int_b7 smallint,
    int_b8 smallint,
    int_b9 smallint,
    int_b10 smallint,
    int_b11 smallint,
    nama_petugas text COLLATE pg_catalog."default",
    created_by text COLLATE pg_catalog."default",
    updated_by text COLLATE pg_catalog."default",
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp without time zone,
    penilaian_rows jsonb DEFAULT '[]'::jsonb,
    ttd_dokter text COLLATE pg_catalog."default",
    nama_dokter text COLLATE pg_catalog."default",
    ttd_dokter_timestamp text COLLATE pg_catalog."default",
    ttd_petugas text COLLATE pg_catalog."default",
    ttd_petugas_timestamp text COLLATE pg_catalog."default",
    CONSTRAINT dokumen_penilaian_risiko_jatuh_pasien_geriatri_pkey PRIMARY KEY (id),
    CONSTRAINT dokumen_penilaian_risiko_jatuh_pasien_geriatri_uuid_key UNIQUE (uuid)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.dokumen_penilaian_risiko_jatuh_pasien_geriatri
    OWNER to postgres;

    

CREATE TABLE IF NOT EXISTS dokumen_permintaan_pelayanan_kerohanian (
    id BIGSERIAL PRIMARY KEY,
    uuid UUID NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien VARCHAR(36) NOT NULL,

    jenis_kelamin VARCHAR(20),
    nik VARCHAR(50),
    no_rm VARCHAR(50),

    no_surat VARCHAR(100) DEFAULT 'RM 7.1/FPPKK/22',

    nama VARCHAR(255),

    tanggal_lahir_pasien DATE,
    jenis_kelamin_pasien VARCHAR(10),
    alamat_pasien TEXT,

    nama_wali VARCHAR(255),
    tanggal_lahir_wali DATE,
    jenis_kelamin_wali VARCHAR(10),
    alamat_wali TEXT,

    agama_kepercayaan VARCHAR(100),
    bentuk_pelayanan TEXT,

    tanggal_pelayanan DATE,
    jam_pelayanan TIME,

    koordinasi_team TEXT,
    pelayanan_doa_bersama BOOLEAN DEFAULT FALSE,
    keterangan_pelayanan TEXT,

    tanggal DATE,

    ttd_rohaniawan TEXT,
    nama_rohaniawan_ttd VARCHAR(255),
    ttd_rohaniawan_timestamp VARCHAR(50),

    ttd_kepala_ruangan TEXT,
    nama_kepala_ruangan_ttd VARCHAR(255),
    ttd_kepala_ruangan_timestamp VARCHAR(50),

    ttd_keluarga TEXT,
    nama_keluarga_ttd VARCHAR(255),
    ttd_keluarga_timestamp VARCHAR(50),

    created_by VARCHAR(255),
    updated_by VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,

    CONSTRAINT dokumen_permintaan_pelayanan_kerohanian_uuid_key UNIQUE (uuid)
);

CREATE TABLE IF NOT EXISTS dokumen_penyimpanan_barang_berharga (
    id BIGSERIAL PRIMARY KEY,
    uuid UUID NOT NULL DEFAULT gen_random_uuid(),
    uuid_pasien VARCHAR(36) NOT NULL,

    no_rm VARCHAR(50) NOT NULL,
    no_surat VARCHAR(100) DEFAULT 'RM 7.2/FPBBMP/22',

    nik VARCHAR(50),
    nama VARCHAR(255),

    tanggal_lahir DATE,
    jenis_kelamin VARCHAR(10),

    nama_petugas VARCHAR(255),
    tanggal DATE,

    pasien_tidak_sadar BOOLEAN DEFAULT FALSE,

    barang_rows JSONB,

    ttd_petugas TEXT,
    nama_petugas_ttd VARCHAR(255),
    ttd_petugas_timestamp VARCHAR(50),

    ttd_saksi1 TEXT,
    nama_saksi1_ttd VARCHAR(255),
    ttd_saksi1_timestamp VARCHAR(50),

    ttd_keluarga TEXT,
    nama_keluarga_ttd VARCHAR(255),
    ttd_keluarga_timestamp VARCHAR(50),

    ttd_kepala_ruangan TEXT,
    nama_kepala_ruangan_ttd VARCHAR(255),
    ttd_kepala_ruangan_timestamp VARCHAR(50),

    created_by VARCHAR(255),
    updated_by VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP,

    CONSTRAINT dokumen_penyimpanan_barang_berharga_uuid_key UNIQUE (uuid)
);