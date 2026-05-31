<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\Facades\DB;

/**
 * ObservationBuilder — Single source of truth untuk FHIR Observation payload dari CPPT.
 *
 * Dipanggil oleh:
 *   - SyncObservationToSatuSehat::handle()   → job otomatis via pg_notify
 *   - ObservationSyncCtrl::syncOne()          → sync manual dari UI (opsional)
 *
 * Data sumber:
 *   - cppt.asesmen           → valueString (temuan klinis utama)
 *   - cppt.subjek + objek    → digunakan sebagai konteks tambahan bila perlu
 *   - cppt.pengguna_uuid     → performer (Practitioner IHS)
 *   - registrasi.pasien_uuid → subject (Patient IHS)
 *   - registrasi             → encounter reference & effectiveDateTime
 *
 * FHIR: Observation resource type "Physical findings of Eye Narrative" (LOINC 10197-2)
 */
class ObservationBuilder
{
    private const LOINC_SYSTEM  = 'http://loinc.org';
    private const LOINC_CODE    = '10197-2';
    private const LOINC_DISPLAY = 'Physical findings of Eye Narrative';

    private const CAT_SYSTEM  = 'http://terminology.hl7.org/CodeSystem/observation-category';
    private const CAT_CODE    = 'exam';
    private const CAT_DISPLAY = 'Exam';

    /**
     * Build FHIR Observation payload dari CPPT row + registrasi row.
     *
     * @param  object  $cppt   Row cppt (dengan join pengguna untuk IHS ID)
     *                         Wajib memiliki:
     *                           - $cppt->uuid
     *                           - $cppt->asesmen
     *                           - $cppt->registrasi_uuid
     *                           - $cppt->nama_pasien
     *                           - $cppt->practitioner_ihs_id  (dari pengguna.satusehat_ihs_id)
     *                           - $cppt->nama_pengguna        (dari pengguna.nama)
     *                           - $cppt->nama_dokter          (fallback)
     * @param  object  $reg    Row registrasi
     *                         Wajib memiliki:
     *                           - $reg->patient_ihs_id          (dari pasien.id_satu_sehat)
     *                           - $reg->satusehat_encounter_id
     *                           - $reg->tanggal
     *                           - $reg->waktu
     * @return array  FHIR Observation resource array
     */
    public static function build(object $cppt, object $reg): array
    {
        // ── 1. effectiveDateTime & issued ───────────────────────────────────
        $tanggal  = $reg->tanggal ?? now()->toDateString();
        $waktu    = $reg->waktu   ?? '08:00:00';
        $effectiveDt = date('Y-m-d\TH:i:s+07:00', strtotime("{$tanggal} {$waktu}"));

        // ── 2. Cari IHS dokter via cppt.pengguna_uuid → pengguna ─────────────
        $practitionerIhsId = $cppt->practitioner_ihs_id ?? null;
        $namaPractitioner  = trim($cppt->nama_pengguna ?? $cppt->nama_dokter ?? '');

        // Fallback: cari via nama_dokter → pengguna.nama
        if (empty($practitionerIhsId) && !empty($cppt->nama_dokter)) {
            $dokterRow = DB::table('pengguna')
                ->whereRaw('LOWER(TRIM(nama)) = LOWER(?)', [trim($cppt->nama_dokter)])
                ->whereNotNull('satusehat_ihs_id')
                ->where('satusehat_ihs_id', '!=', '')
                ->first(['satusehat_ihs_id', 'nama']);
            if ($dokterRow) {
                $practitionerIhsId = $dokterRow->satusehat_ihs_id;
                $namaPractitioner  = $dokterRow->nama;
            }
        }

        // ── 3. valueString: asesmen utama ───────────────────────────────────
        $valueString = trim($cppt->asesmen ?? '');

        // ── 4. Payload ───────────────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Observation',
            'status'       => 'final',
            'category'     => [[
                'coding' => [[
                    'system'  => self::CAT_SYSTEM,
                    'code'    => self::CAT_CODE,
                    'display' => self::CAT_DISPLAY,
                ]],
            ]],
            'code' => [
                'coding' => [[
                    'system'  => self::LOINC_SYSTEM,
                    'code'    => self::LOINC_CODE,
                    'display' => self::LOINC_DISPLAY,
                ]],
            ],
            'subject' => [
                'reference' => 'Patient/' . ($reg->patient_ihs_id ?? ''),
                'display'   => $cppt->nama_pasien ?? '',
            ],
            'encounter' => [
                'reference' => 'Encounter/' . ($reg->satusehat_encounter_id ?? ''),
            ],
            'effectiveDateTime' => $effectiveDt,
            'issued'            => $effectiveDt,
            'valueString'       => $valueString,
        ];

        // ── 5. performer (Practitioner) ─────────────────────────────────────
        if (!empty($practitionerIhsId)) {
            $payload['performer'] = [[
                'reference' => 'Practitioner/' . $practitionerIhsId,
                'display'   => $namaPractitioner,
            ]];
        }

        return $payload;
    }
}
