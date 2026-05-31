<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\Facades\DB;

/**
 * CarePlanBuilder — Single source of truth untuk FHIR CarePlan payload.
 *
 * Dipanggil oleh:
 *   - CarePlanSyncCtrl::syncOne()          → sync manual dari UI
 *   - SyncCarePlanToSatuSehat::handle()    → job otomatis dari daemon/observer
 *
 * Data sumber:
 *   - registrasi      → subject (pasien), encounter, author (dokter), tanggal
 *   - pemeriksaan_dokter → description (anamnese/diagnosa), tanggal_kontrol_selanjutnya
 *   - layanan_pasien  → activity (tindakan yang dilakukan)
 *   - pengguna        → author practitioner IHS ID & nama
 */
class CarePlanBuilder
{
    /** SNOMED code untuk Outpatient care plan */
    private const CATEGORY_SYSTEM  = 'http://snomed.info/sct';
    private const CATEGORY_CODE    = '736271009';
    private const CATEGORY_DISPLAY = 'Outpatient care plan';

    /**
     * Build FHIR CarePlan payload.
     *
     * @param  object  $reg   Baris registrasi dari DB (dengan join pasien & pengguna)
     *                        Wajib memiliki:
     *                          - $reg->uuid
     *                          - $reg->nomor
     *                          - $reg->nama_pasien
     *                          - $reg->tanggal
     *                          - $reg->waktu              (opsional)
     *                          - $reg->patient_ihs_id
     *                          - $reg->satusehat_encounter_id
     *                          - $reg->practitioner_ihs_id  (dari pengguna.satusehat_ihs_id)
     *                          - $reg->nama_pengguna        (dari pengguna.nama)
     *                          - $reg->nama_dokter          (fallback dari registrasi.nama_dokter)
     * @param  string  $orgId  FHIR Organization ID fasyankes (tidak dipakai di payload CarePlan,
     *                         dipertahankan untuk konsistensi signature antar builder)
     * @return array           FHIR CarePlan resource array
     */
    public static function build(object $reg, string $orgId): array
    {
        // ── 1. Ambil data pemeriksaan dokter untuk registrasi ini ────────────
        $pemeriksaan = DB::table('pemeriksaan_dokter')
            ->where('registrasi_uuid', $reg->uuid)
            ->orderByDesc('id')
            ->first(['anamnese', 'pemeriksaan_diagnosa', 'tanggal_kontrol_selanjutnya']);

        // ── 2. Description: anamnese → diagnosa → default ───────────────────
        $description = trim($pemeriksaan->anamnese ?? '')
            ?: trim($pemeriksaan->pemeriksaan_diagnosa ?? '')
            ?: 'Penanganan dan pemeriksaan pasien rawat jalan';

        // ── 3. Timestamp created = waktu registrasi (ISO 8601 +07:00) ───────
        $tanggal = $reg->tanggal ?? now()->toDateString();
        $waktu   = $reg->waktu   ?? '08:00:00';
        $created = date('Y-m-d\TH:i:s+07:00', strtotime("{$tanggal} {$waktu}"));

        // ── 4. Timestamp sekarang untuk period.start (WIB) ──────────────────
        $now = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i:sP');

        // ── 5. Cari IHS ID dokter via registrasi.nama_dokter → pengguna.nama ───────
        //   registrasi.pengguna_uuid adalah user CS yang mendaftar pasien, bukan dokter.
        //   Dokter dicari berdasarkan kecocokan nama di tabel pengguna.
        $namaDokterRaw = trim($reg->nama_dokter ?? '');
        $dokterIhsId   = null;

        if ($namaDokterRaw !== '' && $namaDokterRaw !== '-') {
            $dokterRow = DB::table('pengguna')
                ->whereRaw('LOWER(TRIM(nama)) = LOWER(?)', [$namaDokterRaw])
                ->whereNotNull('satusehat_ihs_id')
                ->where('satusehat_ihs_id', '!=', '')
                ->first(['satusehat_ihs_id', 'nama']);

            if ($dokterRow) {
                $dokterIhsId = $dokterRow->satusehat_ihs_id;
            }
        }

        // Fallback: jika nama_dokter tidak cocok, pakai IHS dari join pengguna_uuid
        if (!$dokterIhsId) {
            $dokterIhsId = $reg->practitioner_ihs_id ?? null;
        }

        // ── 6. Nama dokter untuk display ─────────────────────────────────────
        $namaDokter = $namaDokterRaw ?: trim($reg->nama_pengguna ?? '');

        // ── 7. Payload ───────────────────────────────────────────────────────
        $payload = [
            'resourceType' => 'CarePlan',
            'status'       => 'active',
            'intent'       => 'plan',
            'category'     => [[
                'coding' => [[
                    'system'  => self::CATEGORY_SYSTEM,
                    'code'    => self::CATEGORY_CODE,
                    'display' => self::CATEGORY_DISPLAY,
                ]],
            ]],
            'title'       => 'Rencana Rawat Pasien',
            'description' => $description,
            'subject'     => [
                'reference' => 'Patient/' . ($reg->patient_ihs_id ?? ''),
                'display'   => $reg->nama_pasien ?? '',
            ],
            'encounter'   => [
                'reference' => 'Encounter/' . ($reg->satusehat_encounter_id ?? ''),
            ],
            'created' => $created,
        ];

        // ── 8. Period — start = sekarang, end = tanggal kontrol selanjutnya ──
        if (!empty($pemeriksaan->tanggal_kontrol_selanjutnya)) {
            $payload['period'] = [
                'start' => $now,
                'end'   => date('Y-m-d\T00:00:00+07:00',
                                strtotime($pemeriksaan->tanggal_kontrol_selanjutnya)),
            ];
        }

        // ── 9. Author — Practitioner dari nama_dokter → pengguna.satusehat_ihs_id ──
        if (!empty($dokterIhsId)) {
            $payload['author'] = [
                'reference' => 'Practitioner/' . $dokterIhsId,
                'display'   => $namaDokter,
            ];
        }

        return $payload;
    }
}
