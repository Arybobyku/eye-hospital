<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\EncounterBuilder;
use App\Services\SatuSehat\CarePlanBuilder;
use App\Services\SatuSehat\ConditionBuilder;

/**
 * SyncEncounterToSatuSehat
 *
 * Menangani empat event dari PostgreSQL pg_notify:
 *
 *   encounter_post    — POST Encounter baru (CS mendaftar, status_ro = 'Belum Diperiksa')
 *   encounter_ro      — PUT Encounter → in-progress (status_ro = 'Sudah Diperiksa RO')
 *                       Location: Refraksi Optisi (dari satusehat_locations, prefix 'refraksi')
 *   encounter_dokter  — PUT Encounter → finished (status_dokter = 'Sudah Diperiksa')
 *                       Location: Poli dokter (dari satusehat_locations, prefix 'poli {ruang}')
 *                       Participant: Practitioner dari pengguna.satusehat_ihs_id
 *   careplan_kontrol  — POST CarePlan jadwal kontrol (tanggal_kontrol_selanjutnya IS NOT NULL)
 *                       Dipicu bersamaan dengan encounter_dokter
 */
class SyncEncounterToSatuSehat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int   $tries   = 1;
    public array $backoff = [30, 120, 300];
    public int   $timeout = 60;

    /**
     * @param string $registrasiUuid  UUID registrasi
     * @param string $event           encounter_post | encounter_ro | encounter_dokter
     */
    public function __construct(
        public string $registrasiUuid,
        public string $event = 'encounter_post'
    ) {}

    public function handle(): void
    {
        $uuid  = $this->registrasiUuid;
        $event = $this->event;

        Log::channel('satusehat')->info("[Encounter] Job mulai — event: {$event}", [
            'uuid'    => $uuid,
            'event'   => $event,
            'attempt' => $this->attempts(),
        ]);

        // ── 1. Ambil data registrasi ─────────────────────────────────────────────
        $reg = DB::table('registrasi')
            ->select([
                'registrasi.id',
                'registrasi.uuid',
                'registrasi.nomor',
                'registrasi.nama_pasien',
                'registrasi.pasien_uuid',
                'registrasi.pengguna_uuid',
                'registrasi.nama_dokter',
                'registrasi.ruang_poliklinik',
                'registrasi.satusehat_location_id',
                'registrasi.satusehat_location_ro_id',
                'registrasi.satusehat_location_poli_id',
                'registrasi.satusehat_encounter_id',
                'registrasi.satusehat_encounter_status',
                'registrasi.satusehat_encounter_fhir_status',
                'registrasi.tanggal',
                'registrasi.waktu',
                'registrasi.jenis',
                'pasien.id_satu_sehat as patient_ihs_id',
                'pengguna.satusehat_ihs_id as practitioner_ihs_id',
                'pengguna.nama as nama_pengguna',
            ])
            ->leftJoin('pasien',   'pasien.uuid',   '=', 'registrasi.pasien_uuid')
            ->leftJoin('pengguna', 'pengguna.uuid', '=', 'registrasi.pengguna_uuid')
            ->where('registrasi.uuid', $uuid)
            ->where('registrasi.delete_soft', 1)
            ->first();

        if (!$reg) {
            Log::channel('satusehat')->warning("[Encounter] SKIP — registrasi tidak ditemukan atau dihapus", ['uuid' => $uuid]);
            return;
        }

        // ── 2. Inisialisasi bridge & config ──────────────────────────────────────
        try {
            $bridge = new BridgeBase();
            $bridge->logContext = "encounter_{$event}";
            $orgId  = (new ConfigSatusehat())->getOrganizationId();
        } catch (\Throwable $e) {
            Log::channel('satusehat')->error("[Encounter] Gagal inisialisasi BridgeBase", [
                'uuid'  => $uuid,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }

        // ── 3. Branch berdasarkan event ──────────────────────────────────────────
        match ($event) {
            'encounter_post'   => $this->handlePost($reg, $orgId, $bridge, $uuid),
            'encounter_ro'     => $this->handleRo($reg, $orgId, $bridge, $uuid),
            'encounter_dokter' => $this->handleDokter($reg, $orgId, $bridge, $uuid),
            'careplan_kontrol' => $this->handleCarePlanKontrol($reg, $orgId, $bridge, $uuid),
            default => Log::channel('satusehat')->warning("[Encounter] Event tidak dikenal: {$event}", ['uuid' => $uuid]),
        };
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // EVENT 1 — encounter_post: POST Encounter baru
    // ═══════════════════════════════════════════════════════════════════════════

    private function handlePost(object $reg, string $orgId, BridgeBase $bridge, string $uuid): void
    {
        // Guard: sudah ter-sync
        if (!empty($reg->satusehat_encounter_id) && $reg->satusehat_encounter_status === 'synced') {
            Log::channel('satusehat')->info('[Encounter/post] SKIP — sudah synced', [
                'uuid' => $uuid, 'encounter_id' => $reg->satusehat_encounter_id,
            ]);
            return;
        }

        // Guard: pasien belum IHS
        if (empty($reg->patient_ihs_id)) {
            Log::channel('satusehat')->warning('[Encounter/post] SKIP — pasien belum punya IHS Number', [
                'uuid' => $uuid, 'pasien' => $reg->nama_pasien,
            ]);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_status' => 'waiting_patient',
            ]);
            return;
        }

        // Guard: belum ada location
        if (empty($reg->satusehat_location_id)) {
            Log::channel('satusehat')->warning('[Encounter/post] SKIP — satusehat_location_id kosong', [
                'uuid' => $uuid, 'poli' => $reg->ruang_poliklinik,
            ]);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_status' => 'no_location',
            ]);
            return;
        }

        try {
            $payload = EncounterBuilder::build($reg, $orgId);

            Log::channel('satusehat')->info('[Encounter/post] POST Encounter ke SatuSehat', [
                'uuid' => $uuid, 'nomor' => $reg->nomor,
            ]);

            $result      = $bridge->postJson('Encounter', $payload);
            $encounterId = $result['id'] ?? null;

            if ($encounterId) {
                DB::table('registrasi')->where('uuid', $uuid)->update([
                    'satusehat_encounter_id'          => $encounterId,
                    'satusehat_encounter_status'      => 'synced',
                    'satusehat_encounter_fhir_status' => 'arrived',
                    'satusehat_encounter_synced_at'   => now(),
                ]);

                // Seed history awal 'arrived' (idempotent)
                $alreadySeeded = DB::table('satusehat_encounter_status_history')
                    ->where('registrasi_uuid', $uuid)
                    ->exists();
                if (!$alreadySeeded) {
                    $waktuStr = $reg->waktu ?? '00:00';
                    DB::table('satusehat_encounter_status_history')->insert([
                        'registrasi_uuid'        => $uuid,
                        'satusehat_encounter_id' => $encounterId,
                        'status'                 => 'arrived',
                        'period_start'           => $reg->tanggal . ' ' . $waktuStr . ':00+07:00',
                        'period_end'             => null,
                        'catatan'                => 'Sync awal — registrasi CS',
                        'updated_by'             => 'job:encounter_post',
                        'created_at'             => now(),
                    ]);
                }

                Log::channel('satusehat')->info('[Encounter/post] ✓ BERHASIL', [
                    'uuid' => $uuid, 'encounter_id' => $encounterId,
                ]);
                return;
            }

            // Response API tanpa ID — kemungkinan duplikat
            $issue   = $result['issue'][0] ?? [];
            $errCode = $issue['details']['coding'][0]['code'] ?? ($issue['code'] ?? '');
            $errMsg  = $issue['diagnostics'] ?? json_encode($result);

            if (stripos($errMsg, 'duplicate') !== false || stripos($errCode, 'duplicate') !== false) {
                $existing = $bridge->getJson('Encounter?identifier=' . urlencode($reg->nomor ?? $uuid));
                $existId  = $existing['entry'][0]['resource']['id'] ?? null;
                if ($existId) {
                    DB::table('registrasi')->where('uuid', $uuid)->update([
                        'satusehat_encounter_id'       => $existId,
                        'satusehat_encounter_status'    => 'synced',
                        'satusehat_encounter_synced_at' => now(),
                    ]);
                    Log::channel('satusehat')->info('[Encounter/post] Duplikat — pakai ID yang ada', [
                        'uuid' => $uuid, 'encounter_id' => $existId,
                    ]);
                    return;
                }
            }

            DB::table('registrasi')->where('uuid', $uuid)->update(['satusehat_encounter_status' => 'failed']);
            throw new \RuntimeException("SatuSehat error: {$errMsg}");

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $uuid)->update(['satusehat_encounter_status' => 'failed']);
            Log::channel('satusehat')->error('[Encounter/post] Exception', ['uuid' => $uuid, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // EVENT 2 — encounter_ro: PUT → in-progress (Refraksi Optisi selesai)
    // ═══════════════════════════════════════════════════════════════════════════

    private function handleRo(object $reg, string $orgId, BridgeBase $bridge, string $uuid): void
    {
        if (empty($reg->satusehat_encounter_id)) {
            Log::channel('satusehat')->warning('[Encounter/ro] SKIP — satusehat_encounter_id kosong', ['uuid' => $uuid]);
            return;
        }

        // Guard: jangan proses ulang jika sudah in-progress atau lebih lanjut
        $currentStatus = $reg->satusehat_encounter_fhir_status ?? 'arrived';
        if (in_array($currentStatus, ['in-progress', 'finished', 'cancelled'])) {
            Log::channel('satusehat')->info("[Encounter/ro] SKIP — status sudah {$currentStatus}", ['uuid' => $uuid]);
            return;
        }

        // ── Cari Location Refraksi Optisi ────────────────────────────────────────
        // Prioritas: satusehat_location_ro_id di registrasi, lalu cari dari master
        $roLocId      = $reg->satusehat_location_ro_id ?? null;
        $roLocDisplay = 'Refraksi Optisi';

        if (!$roLocId) {
            $roLoc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereRaw("LOWER(nama) ILIKE '%refraksi%'")
                      ->orWhereRaw("LOWER(nama) ILIKE '%optisi%'");
                })
                ->first(['satusehat_id', 'nama']);

            if ($roLoc) {
                $roLocId      = $roLoc->satusehat_id;
                $roLocDisplay = $roLoc->nama;
            }
        } else {
            // Ambil display name dari master jika hanya pakai ID dari registrasi
            $roLoc = DB::table('satusehat_locations')
                ->where('satusehat_id', $roLocId)
                ->first(['nama']);
            if ($roLoc) {
                $roLocDisplay = $roLoc->nama;
            }
        }

        if (!$roLocId) {
            Log::channel('satusehat')->warning('[Encounter/ro] SKIP — tidak ada Location Refraksi Optisi di master', [
                'uuid' => $uuid,
                'hint' => 'Tambahkan Location dengan nama mengandung "Refraksi" atau "Optisi" di menu SatuSehat → Location',
            ]);
            return;
        }

        // ── Catat waktu sekarang sebagai period.start untuk status in-progress ────
        // Dipakai di DB insert DAN di buildPut() agar period.start konsisten (WIB explicit)
        $roNow = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i:sP');

        // ── Update DB status history (sebelum build payload) ────────────────────
        DB::transaction(function () use ($uuid, $reg, $roNow) {
            // Tutup periode 'arrived' yang masih terbuka
            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', 'arrived')
                ->whereNull('period_end')
                ->update(['period_end' => $roNow]);

            // Insert 'in-progress' (idempotent)
            $exists = DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', 'in-progress')
                ->exists();

            if (!$exists) {
                DB::table('satusehat_encounter_status_history')->insert([
                    'registrasi_uuid'        => $uuid,
                    'satusehat_encounter_id' => $reg->satusehat_encounter_id,
                    'status'                 => 'in-progress',
                    'period_start'           => $roNow,
                    'period_end'             => null,
                    'catatan'                => 'Pemeriksaan Refraksi Optisi selesai',
                    'updated_by'             => 'job:encounter_ro',
                    'created_at'             => now(),
                ]);
            }

            // Update FHIR status di registrasi
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_fhir_status' => 'in-progress',
            ]);
        });

        // Reload reg agar satusehat_encounter_fhir_status sudah 'in-progress'
        $reg->satusehat_encounter_fhir_status = 'in-progress';

        // ── Build & kirim PUT ────────────────────────────────────────────────────
        try {
            $payload = EncounterBuilder::buildPut(
                $reg, $orgId,
                'in-progress',
                $roLocId, $roLocDisplay,
                false,   // RO tidak menyertakan practitioner individual
                [],      // tidak ada diagnosis di tahap RO
                $roNow   // period.start = waktu RO dicatat (bukan waktu registrasi)
            );

            Log::channel('satusehat')->info('[Encounter/ro] PUT Encounter → in-progress', [
                'uuid'         => $uuid,
                'encounter_id' => $reg->satusehat_encounter_id,
                'location'     => $roLocDisplay,
            ]);

            $result = $bridge->putJson('Encounter/' . $reg->satusehat_encounter_id, $payload);

            if (isset($result['id']) || isset($result['resourceType'])) {
                Log::channel('satusehat')->info('[Encounter/ro] ✓ BERHASIL — status in-progress', [
                    'uuid' => $uuid, 'encounter_id' => $reg->satusehat_encounter_id,
                ]);
            } else {
                $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
                Log::channel('satusehat')->error('[Encounter/ro] ✗ Response error dari SatuSehat', [
                    'uuid' => $uuid, 'error' => $errMsg,
                ]);
                // Rollback status history
                $this->rollbackStatusUpdate($uuid, 'in-progress', 'arrived');
                throw new \RuntimeException("SatuSehat error (ro): {$errMsg}");
            }

        } catch (\Throwable $e) {
            $this->rollbackStatusUpdate($uuid, 'in-progress', 'arrived');
            Log::channel('satusehat')->error('[Encounter/ro] Exception', ['uuid' => $uuid, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // EVENT 3 — encounter_dokter: PUT → finished (dokter selesai memeriksa)
    // ═══════════════════════════════════════════════════════════════════════════

    private function handleDokter(object $reg, string $orgId, BridgeBase $bridge, string $uuid): void
    {
        if (empty($reg->satusehat_encounter_id)) {
            Log::channel('satusehat')->warning('[Encounter/dokter] SKIP — satusehat_encounter_id kosong', ['uuid' => $uuid]);
            return;
        }

        // Guard: jangan proses ulang jika sudah finished/cancelled
        $currentStatus = $reg->satusehat_encounter_fhir_status ?? 'arrived';
        if (in_array($currentStatus, ['finished', 'cancelled'])) {
            Log::channel('satusehat')->info("[Encounter/dokter] SKIP — sudah {$currentStatus}", ['uuid' => $uuid]);
            return;
        }

        // Guard: pastikan pasien punya IHS (dibutuhkan untuk payload)
        if (empty($reg->patient_ihs_id)) {
            Log::channel('satusehat')->warning('[Encounter/dokter] SKIP — pasien belum IHS', ['uuid' => $uuid]);
            return;
        }

        // ── Cari Location Poli Dokter ────────────────────────────────────────────
        // Prioritas: satusehat_location_poli_id di registrasi, lalu cari dari master by ruang_poliklinik
        $poliLocId      = $reg->satusehat_location_poli_id ?? null;
        $poliLocDisplay = 'Poli ' . ($reg->ruang_poliklinik ?? '');

        if (!$poliLocId && !empty($reg->ruang_poliklinik)) {
            $poliNum = trim((string) $reg->ruang_poliklinik);

            // Cari dari master: nama mengandung 'poli' DAN angka/nama ruangan
            $poliLoc = DB::table('satusehat_locations')
                ->where('status', 'active')
                ->whereRaw("LOWER(nama) ILIKE '%poli%'")
                ->whereRaw("nama ILIKE ?", ['%' . $poliNum . '%'])
                ->first(['satusehat_id', 'nama']);

            if ($poliLoc) {
                $poliLocId      = $poliLoc->satusehat_id;
                $poliLocDisplay = $poliLoc->nama;
            }
        } elseif ($poliLocId) {
            $poliLoc = DB::table('satusehat_locations')
                ->where('satusehat_id', $poliLocId)
                ->first(['nama']);
            if ($poliLoc) {
                $poliLocDisplay = $poliLoc->nama;
            }
        }

        if (!$poliLocId) {
            Log::channel('satusehat')->warning('[Encounter/dokter] SKIP — tidak ada Location Poli yang cocok di master', [
                'uuid'             => $uuid,
                'ruang_poliklinik' => $reg->ruang_poliklinik,
                'hint'             => 'Tambahkan Location dengan nama mengandung "Poli" + nomor ruangan di menu SatuSehat → Location',
            ]);
            return;
        }

        // ── Catat waktu sekarang sebagai period.start untuk status finished ────────
        // Dipakai di DB insert DAN di buildPut() agar period.start konsisten (WIB explicit)
        $dokterNow = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i:sP');

        // ── Update DB status history (sebelum build payload) ────────────────────
        DB::transaction(function () use ($uuid, $reg, $dokterNow) {
            // Tutup semua periode sebelumnya yang masih terbuka (arrived, in-progress)
            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->whereIn('status', ['arrived', 'in-progress'])
                ->whereNull('period_end')
                ->update(['period_end' => $dokterNow]);

            // Insert 'finished' (idempotent)
            $exists = DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', 'finished')
                ->exists();

            if (!$exists) {
                DB::table('satusehat_encounter_status_history')->insert([
                    'registrasi_uuid'        => $uuid,
                    'satusehat_encounter_id' => $reg->satusehat_encounter_id,
                    'status'                 => 'finished',
                    'period_start'           => $dokterNow,
                    'period_end'             => $dokterNow,   // finished = closed immediately
                    'catatan'                => 'Pemeriksaan dokter selesai',
                    'updated_by'             => 'job:encounter_dokter',
                    'created_at'             => now(),
                ]);
            }

            // Update FHIR status di registrasi
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_fhir_status' => 'finished',
            ]);
        });

        $reg->satusehat_encounter_fhir_status = 'finished';

        // ── POST Condition untuk setiap kode ICD-10 ─────────────────────────────
        $diagnosisRefs = $this->postConditions($reg, $bridge, $uuid);

        // ── Build & kirim PUT ────────────────────────────────────────────────────
        try {
            $payload = EncounterBuilder::buildPut(
                $reg, $orgId,
                'finished',
                $poliLocId, $poliLocDisplay,
                true,           // dokter: sertakan participant.individual
                $diagnosisRefs, // diagnosis refs dari Condition yang sudah di-POST
                $dokterNow      // period.start = waktu dokter selesai (bukan waktu registrasi)
            );

            Log::channel('satusehat')->info('[Encounter/dokter] PUT Encounter → finished', [
                'uuid'             => $uuid,
                'encounter_id'     => $reg->satusehat_encounter_id,
                'location'         => $poliLocDisplay,
                'practitioner_ihs' => $reg->practitioner_ihs_id ?? 'null',
                'diagnosis_count'  => count($diagnosisRefs),
            ]);

            $result = $bridge->putJson('Encounter/' . $reg->satusehat_encounter_id, $payload);

            if (isset($result['id']) || isset($result['resourceType'])) {
                Log::channel('satusehat')->info('[Encounter/dokter] ✓ BERHASIL — status finished', [
                    'uuid' => $uuid, 'encounter_id' => $reg->satusehat_encounter_id,
                ]);
            } else {
                $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
                Log::channel('satusehat')->error('[Encounter/dokter] ✗ Response error dari SatuSehat', [
                    'uuid' => $uuid, 'error' => $errMsg,
                ]);
                $this->rollbackStatusUpdate($uuid, 'finished', 'in-progress');
                throw new \RuntimeException("SatuSehat error (dokter): {$errMsg}");
            }

        } catch (\Throwable $e) {
            $this->rollbackStatusUpdate($uuid, 'finished', 'in-progress');
            Log::channel('satusehat')->error('[Encounter/dokter] Exception', ['uuid' => $uuid, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // HELPER — POST ICD-10 sebagai FHIR Condition resources ke SatuSehat
    // Dipanggil oleh handleDokter() sebelum PUT Encounter → finished.
    // Idempoten: skip jika Condition untuk kode ICD-10 tsb sudah pernah di-POST.
    // ═══════════════════════════════════════════════════════════════════════════

    private function postConditions(object $reg, BridgeBase $bridge, string $uuid): array
    {
        // Ambil semua baris ICD-10 untuk registrasi ini
        $icdRows = DB::table('pemeriksaan_dokter_icdten')
            ->where('registrasi_uuid', $uuid)
            ->whereNotNull('kode_icdten')
            ->where('kode_icdten', '!=', '')
            ->get(['id', 'kode_icdten', 'nama_icdten', 'satusehat_condition_id']);

        if ($icdRows->isEmpty()) {
            Log::channel('satusehat')->info('[Condition] SKIP — tidak ada ICD-10 di pemeriksaan_dokter_icdten', ['uuid' => $uuid]);
            return [];
        }

        $diagnosisRefs = [];

        foreach ($icdRows as $icd) {
            $kode = trim($icd->kode_icdten);
            $nama = trim($icd->nama_icdten ?? '');

            // Cek idempoten: kolom satusehat_condition_id sudah terisi?
            if (!empty($icd->satusehat_condition_id)) {
                $diagnosisRefs[] = ConditionBuilder::buildDiagnosisRef($icd->satusehat_condition_id, $nama);
                Log::channel('satusehat')->info('[Condition] SKIP (sudah ada) — pakai existing', [
                    'uuid'         => $uuid,
                    'kode'         => $kode,
                    'condition_id' => $icd->satusehat_condition_id,
                ]);
                continue;
            }

            // Belum ada — POST ke SatuSehat
            try {
                $condPayload = ConditionBuilder::build($reg, $kode, $nama);
                $result      = $bridge->postJson('Condition', $condPayload);

                $conditionId = $result['id'] ?? null;

                if (!$conditionId) {
                    $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
                    Log::channel('satusehat')->error('[Condition] ✗ Gagal POST — response tidak ada ID', [
                        'uuid'  => $uuid,
                        'kode'  => $kode,
                        'error' => $errMsg,
                    ]);
                    // Lanjut ke kode ICD berikutnya — jangan hentikan seluruh proses
                    continue;
                }

                // Simpan Condition ID langsung ke baris ICD-10 yang bersangkutan
                DB::table('pemeriksaan_dokter_icdten')
                    ->where('id', $icd->id)
                    ->update([
                        'satusehat_condition_id' => $conditionId,
                        'satusehat_encounter_id' => $reg->satusehat_encounter_id,
                    ]);

                $diagnosisRefs[] = ConditionBuilder::buildDiagnosisRef($conditionId, $nama);

                Log::channel('satusehat')->info('[Condition] ✓ POST berhasil', [
                    'uuid'         => $uuid,
                    'kode'         => $kode,
                    'condition_id' => $conditionId,
                ]);

            } catch (\Throwable $e) {
                Log::channel('satusehat')->error('[Condition] Exception saat POST', [
                    'uuid'  => $uuid,
                    'kode'  => $kode,
                    'error' => $e->getMessage(),
                ]);
                // Lanjut ke kode ICD berikutnya — jangan hentikan seluruh proses
            }
        }

        return $diagnosisRefs;
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // EVENT 4 — careplan_kontrol: POST CarePlan jadwal kontrol selanjutnya
    // ═══════════════════════════════════════════════════════════════════════════

    private function handleCarePlanKontrol(object $reg, string $orgId, BridgeBase $bridge, string $uuid): void
    {
        // Guard: sudah pernah di-sync
        if (!empty($reg->satusehat_careplan_kontrol_id)) {
            Log::channel('satusehat')->info('[CarePlan/kontrol] SKIP — sudah synced', [
                'uuid'        => $uuid,
                'careplan_id' => $reg->satusehat_careplan_kontrol_id,
            ]);
            return;
        }

        // Guard: pasien belum IHS
        if (empty($reg->patient_ihs_id)) {
            Log::channel('satusehat')->warning('[CarePlan/kontrol] SKIP — pasien belum punya IHS Number', [
                'uuid' => $uuid,
            ]);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_kontrol_status' => 'waiting_patient',
            ]);
            return;
        }

        // Guard: encounter belum di-sync
        if (empty($reg->satusehat_encounter_id)) {
            Log::channel('satusehat')->warning('[CarePlan/kontrol] SKIP — encounter belum ada ID SatuSehat', [
                'uuid' => $uuid,
            ]);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_kontrol_status' => 'waiting_encounter',
            ]);
            return;
        }

        // Cek pemeriksaan_dokter: harus ada tanggal_kontrol_selanjutnya
        $pemeriksaan = DB::table('pemeriksaan_dokter')
            ->where('registrasi_uuid', $uuid)
            ->whereNotNull('tanggal_kontrol_selanjutnya')
            ->orderByDesc('id')
            ->first(['tanggal_kontrol_selanjutnya', 'anamnese', 'pemeriksaan_diagnosa']);

        if (!$pemeriksaan) {
            Log::channel('satusehat')->info('[CarePlan/kontrol] SKIP — tidak ada tanggal kontrol selanjutnya', [
                'uuid' => $uuid,
            ]);
            return;
        }

        try {
            $payload = CarePlanBuilder::build($reg, $orgId);

            Log::channel('satusehat')->info('[CarePlan/kontrol] POST CarePlan ke SatuSehat', [
                'uuid'                     => $uuid,
                'nomor'                    => $reg->nomor,
                'encounter_id'             => $reg->satusehat_encounter_id,
                'tanggal_kontrol'          => $pemeriksaan->tanggal_kontrol_selanjutnya,
            ]);

            $result     = $bridge->postJson('CarePlan', $payload);
            $careplanId = $result['id'] ?? null;

            if ($careplanId) {
                DB::table('registrasi')->where('uuid', $uuid)->update([
                    'satusehat_careplan_kontrol_id'         => $careplanId,
                    'satusehat_careplan_kontrol_status'     => 'synced',
                    'satusehat_careplan_kontrol_synced_at'  => now(),
                ]);

                Log::channel('satusehat')->info('[CarePlan/kontrol] ✓ BERHASIL', [
                    'uuid'        => $uuid,
                    'careplan_id' => $careplanId,
                ]);
                return;
            }

            // Respons tanpa ID — anggap gagal
            $errMsg = $result['issue'][0]['diagnostics'] ?? json_encode($result);
            Log::channel('satusehat')->error('[CarePlan/kontrol] ✗ Response error', [
                'uuid'  => $uuid,
                'error' => $errMsg,
            ]);
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_kontrol_status' => 'failed',
            ]);
            throw new \RuntimeException("SatuSehat CarePlan error: {$errMsg}");

        } catch (\Throwable $e) {
            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_careplan_kontrol_status' => 'failed',
            ]);
            Log::channel('satusehat')->error('[CarePlan/kontrol] Exception', [
                'uuid'  => $uuid,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // Helpers
    // ═══════════════════════════════════════════════════════════════════════════

    /**
     * Rollback perubahan history saat PUT gagal.
     * Hapus baris status baru & buka kembali period_end status sebelumnya.
     */
    private function rollbackStatusUpdate(string $uuid, string $newStatus, string $prevStatus): void
    {
        try {
            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', $newStatus)
                ->delete();

            DB::table('satusehat_encounter_status_history')
                ->where('registrasi_uuid', $uuid)
                ->where('status', $prevStatus)
                ->update(['period_end' => null]);

            DB::table('registrasi')->where('uuid', $uuid)->update([
                'satusehat_encounter_fhir_status' => $prevStatus,
            ]);
        } catch (\Throwable) {
            // Rollback gagal — log sudah cukup, jangan lempar exception baru
        }
    }

    /**
     * Dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        Log::channel('satusehat')->critical('[Encounter] Job GAGAL setelah semua retry', [
            'uuid'  => $this->registrasiUuid,
            'event' => $this->event,
            'error' => $exception->getMessage(),
        ]);

        if ($this->event === 'encounter_post') {
            DB::table('registrasi')->where('uuid', $this->registrasiUuid)->update([
                'satusehat_encounter_status' => 'failed',
            ]);
        }
    }
}
