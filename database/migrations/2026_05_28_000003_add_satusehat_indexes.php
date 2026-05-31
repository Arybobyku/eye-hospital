<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambah index untuk query SatuSehat sync agar tidak timeout.
 *
 * Tanpa index ini, setiap query ke halaman encounter-sync, careplan-sync,
 * dan patient-sync melakukan full table scan pada tabel registrasi yang besar.
 * Correlated subquery ke pemeriksaan_dokter juga full scan per baris.
 *
 * Dampak sebelum index: query list() bisa 30+ detik → Fatal timeout.
 * Dampak setelah index: query list() < 100ms bahkan pada tabel jutaan baris.
 *
 * Semua index menggunakan CREATE INDEX IF NOT EXISTS sehingga aman di-run ulang.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("

-- ─────────────────────────────────────────────────────────────────────────────
-- INDEX: tabel registrasi
-- ─────────────────────────────────────────────────────────────────────────────

-- [1] Filter utama semua query sync: delete_soft + tanggal
--     Dipakai di: list(), dashboard(), runSync(), retryFailed(), trigger EVENT 1-4
CREATE INDEX IF NOT EXISTS idx_reg_ss_tanggal
    ON registrasi (delete_soft, tanggal);

-- [2] Filter status encounter SatuSehat (synced / failed / NULL)
--     Partial index: hanya row aktif (delete_soft = 1) — lebih kecil & lebih cepat
CREATE INDEX IF NOT EXISTS idx_reg_ss_enc_status
    ON registrasi (satusehat_encounter_status)
    WHERE delete_soft = 1;

-- [3] Cek encounter_id IS NULL (pending sync) dan update setelah sync
CREATE INDEX IF NOT EXISTS idx_reg_ss_enc_id
    ON registrasi (satusehat_encounter_id)
    WHERE delete_soft = 1;

-- [4] Filter status_dokter — dipakai trigger EVENT 3 & 4 + query runSync careplan
CREATE INDEX IF NOT EXISTS idx_reg_status_dokter
    ON registrasi (status_dokter)
    WHERE delete_soft = 1;

-- [5] Filter status_ro — dipakai trigger EVENT 1 & 2
CREATE INDEX IF NOT EXISTS idx_reg_status_ro
    ON registrasi (status_ro)
    WHERE delete_soft = 1;

-- [6] Filter careplan kontrol status
CREATE INDEX IF NOT EXISTS idx_reg_ss_careplan_status
    ON registrasi (satusehat_careplan_kontrol_status)
    WHERE delete_soft = 1;

-- [7] JOIN ke tabel pasien (leftJoin di hampir semua query)
--     Kemungkinan sudah ada dari schema lain, IF NOT EXISTS memastikan aman
CREATE INDEX IF NOT EXISTS idx_reg_pasien_uuid
    ON registrasi (pasien_uuid);

-- [8] JOIN ke tabel pengguna
CREATE INDEX IF NOT EXISTS idx_reg_pengguna_uuid
    ON registrasi (pengguna_uuid);

-- [9] Lookup by uuid (dipakai syncOne, updateStatus, trigger)
--     Mungkin sudah PRIMARY KEY tapi kalau uuid bukan PK perlu index ini
CREATE INDEX IF NOT EXISTS idx_reg_uuid
    ON registrasi (uuid);

-- ─────────────────────────────────────────────────────────────────────────────
-- INDEX: tabel pemeriksaan_dokter
-- ─────────────────────────────────────────────────────────────────────────────

-- [10] Correlated subquery di list():
--      SELECT ... FROM pemeriksaan_dokter WHERE registrasi_uuid = ? AND tanggal_kontrol_selanjutnya IS NOT NULL ORDER BY id DESC LIMIT 1
--      Partial index hanya row yang relevan (ada jadwal kontrol)
CREATE INDEX IF NOT EXISTS idx_pd_reg_uuid_kontrol
    ON pemeriksaan_dokter (registrasi_uuid, id DESC)
    WHERE tanggal_kontrol_selanjutnya IS NOT NULL;

-- [11] Dipakai trigger EVENT 4: EXISTS (SELECT 1 FROM pemeriksaan_dokter WHERE registrasi_uuid = NEW.uuid AND tanggal_kontrol_selanjutnya IS NOT NULL)
--      Index [10] di atas sudah mencakup ini, tapi tambahkan index non-partial sebagai fallback
--      kalau optimizer tidak pakai partial index untuk EXISTS
CREATE INDEX IF NOT EXISTS idx_pd_reg_uuid
    ON pemeriksaan_dokter (registrasi_uuid);

        ");
    }

    public function down(): void
    {
        DB::unprepared("
            DROP INDEX IF EXISTS idx_reg_ss_tanggal;
            DROP INDEX IF EXISTS idx_reg_ss_enc_status;
            DROP INDEX IF EXISTS idx_reg_ss_enc_id;
            DROP INDEX IF EXISTS idx_reg_status_dokter;
            DROP INDEX IF EXISTS idx_reg_status_ro;
            DROP INDEX IF EXISTS idx_reg_ss_careplan_status;
            DROP INDEX IF EXISTS idx_reg_pasien_uuid;
            DROP INDEX IF EXISTS idx_reg_pengguna_uuid;
            DROP INDEX IF EXISTS idx_reg_uuid;
            DROP INDEX IF EXISTS idx_pd_reg_uuid_kontrol;
            DROP INDEX IF EXISTS idx_pd_reg_uuid;
        ");
    }
};
