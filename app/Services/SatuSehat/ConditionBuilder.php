<?php

namespace App\Services\SatuSehat;

/**
 * ConditionBuilder — single source of truth untuk FHIR Condition payload.
 *
 * Dipanggil oleh:
 *   - SyncEncounterToSatuSehat::handleDokter()   — saat encounter_dokter, sebelum PUT Encounter
 *
 * Satu registrasi bisa punya lebih dari satu Condition (satu per kode ICD-10).
 * Setiap Condition di-POST ke endpoint /Condition, lalu ID-nya dikumpulkan
 * untuk dimasukkan dalam array Encounter.diagnosis saat PUT Encounter → finished.
 */
class ConditionBuilder
{
    // ── FHIR code system URLs ─────────────────────────────────────────────────
    private const CLINICAL_STATUS_SYSTEM = 'http://terminology.hl7.org/CodeSystem/condition-clinical';
    private const CATEGORY_SYSTEM        = 'http://terminology.hl7.org/CodeSystem/condition-category';
    private const ICD10_SYSTEM           = 'http://hl7.org/fhir/sid/icd-10';
    private const DIAGNOSIS_ROLE_SYSTEM  = 'http://terminology.hl7.org/CodeSystem/diagnosis-role';

    /**
     * Build FHIR Condition resource payload.
     *
     * @param  object $reg     Baris registrasi (harus memiliki patient_ihs_id, satusehat_encounter_id)
     * @param  string $kode    Kode ICD-10 dari pemeriksaan_dokter_icdten.kode_icdten
     * @param  string $nama    Nama diagnosis dari pemeriksaan_dokter_icdten.nama_icdten
     * @return array           FHIR Condition payload siap di-POST ke /Condition
     */
    public static function build(object $reg, string $kode, string $nama): array
    {
        return [
            'resourceType'   => 'Condition',
            'clinicalStatus' => [
                'coding' => [[
                    'system'  => self::CLINICAL_STATUS_SYSTEM,
                    'code'    => 'active',
                    'display' => 'Active',
                ]],
            ],
            'category' => [[
                'coding' => [[
                    'system'  => self::CATEGORY_SYSTEM,
                    'code'    => 'encounter-diagnosis',
                    'display' => 'Encounter Diagnosis',
                ]],
            ]],
            'code' => [
                'coding' => [[
                    'system'  => self::ICD10_SYSTEM,
                    'code'    => str_replace(' ', '', $kode),   // hapus spasi: "H 33.0" → "H33.0"
                    'display' => $nama,
                ]],
            ],
            'subject' => [
                'reference' => 'Patient/' . ($reg->patient_ihs_id ?? ''),
                'display'   => $reg->nama_pasien ?? '',
            ],
            'encounter' => [
                'reference' => 'Encounter/' . ($reg->satusehat_encounter_id ?? ''),
            ],
        ];
    }

    /**
     * Build satu entry Encounter.diagnosis dari Condition ID yang sudah di-POST.
     *
     * @param  string $conditionId  FHIR Condition.id dari response SatuSehat
     * @param  string $nama         Display name (nama_icdten)
     * @return array                Satu elemen untuk array Encounter.diagnosis
     */
    public static function buildDiagnosisRef(string $conditionId, string $nama): array
    {
        return [
            'condition' => [
                'reference' => 'Condition/' . $conditionId,
                'display'   => $nama,
            ],
            'use' => [
                'coding' => [[
                    'system'  => self::DIAGNOSIS_ROLE_SYSTEM,
                    'code'    => 'DD',
                    'display' => 'Discharge diagnosis',
                ]],
            ],
        ];
    }
}
