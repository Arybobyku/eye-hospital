<?php

namespace App\Services\SatuSehat;

use Illuminate\Support\Facades\DB;

/**
 * EncounterBuilder — satu-satunya tempat untuk build FHIR Encounter payload.
 *
 * Dipakai oleh:
 *   - App\Http\Controllers\SatuSehat\EncounterSyncCtrl  (syncOne via HTTP)
 *   - App\Console\Commands\SyncEncounterSatuSehat        (batch via Artisan)
 *
 * Perubahan format payload cukup dilakukan di sini.
 */
class EncounterBuilder
{
    // ── FHIR code system URLs ─────────────────────────────────────────────────
    private const FALLBACK_IDENT_PREFIX = 'http://sys-ids.kemkes.go.id/encounter/';
    private const CLASS_SYSTEM          = 'http://terminology.hl7.org/CodeSystem/v3-ActCode';
    private const SVCTYPE_SYSTEM        = 'http://snomed.info.sct';
    private const PARTICIP_SYSTEM       = 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType';
    private const SVC_CLASS_URL         = 'https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass';
    private const SVC_CLASS_OUTPT       = 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient';
    private const UPGRADE_CLASS_URL     = 'http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass';

    /**
     * Build FHIR Encounter resource payload dari satu baris registrasi.
     *
     * @param  object $reg    Baris registrasi — harus memiliki field:
     *                        nomor, nama_pasien, tanggal, waktu,
     *                        patient_ihs_id, practitioner_ihs_id,
     *                        satusehat_location_id, ruang_poliklinik
     * @param  string $orgId  Organization FHIR ID (dari ConfigSatusehat)
     * @return array          FHIR Encounter payload siap di-POST ke API
     */
    public static function build(object $reg, string $orgId): array
    {
        // ── Identifier system ─────────────────────────────────────────────
        // Ambil dari tabel lokal satusehat_organizations agar tidak hit API.
        // Format: identifier_system + '/' + identifier_value
        // Fallback ke URL standar kemkes jika tabel belum di-sync.
        $orgLocal    = DB::table('satusehat_organizations')
            ->where('satusehat_id', $orgId)
            ->first();
        $identSystem = ($orgLocal && $orgLocal->identifier_system && $orgLocal->identifier_value)
            ? rtrim($orgLocal->identifier_system, '/') . '/' . $orgLocal->identifier_value
            : self::FALLBACK_IDENT_PREFIX . $orgId;

        // ── Period ────────────────────────────────────────────────────────
        $waktu       = $reg->waktu ?? '00:00';
        $periodStart = $reg->tanggal . 'T' . $waktu . ':00+07:00';

        // ── Payload dasar ─────────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Encounter',
            'identifier'   => [[
                'system' => $identSystem,
                'value'  => $reg->nomor,
            ]],
            'status' => 'arrived',
            'class'  => [
                'system'  => self::CLASS_SYSTEM,
                'code'    => 'AMB',
                'display' => 'ambulatory',
            ],
            'serviceType' => [
                'coding' => [[
                    'system'  => self::SVCTYPE_SYSTEM,
                    'code'    => '419192003',
                    'display' => 'Internal medicine',
                ]],
            ],
            'subject' => [
                'reference' => 'Patient/' . $reg->patient_ihs_id,
                'display'   => $reg->nama_pasien ?? '',
            ],
            'period'        => ['start' => $periodStart],
            'statusHistory' => [['status' => 'arrived', 'period' => ['start' => $periodStart]]],
            'serviceProvider' => ['reference' => 'Organization/' . $orgId],
        ];

        // ── Participant (dokter / practitioner) ───────────────────────────
        $individual = [];
        if (!empty($reg->practitioner_ihs_id)) {
            $individual['reference'] = 'Practitioner/' . $reg->practitioner_ihs_id;
        }
        if (!empty($reg->nama_dokter) && $reg->nama_dokter !== '-') {
            $individual['display'] = $reg->nama_dokter;
        }
        if (!empty($individual)) {
            $payload['participant'] = [[
                'type' => [[
                    'coding' => [[
                        'system'  => self::PARTICIP_SYSTEM,
                        'code'    => 'ATND',
                        'display' => 'attender',
                    ]],
                ]],
                'individual' => $individual,
            ]];
        }

        // ── Location (poli) ───────────────────────────────────────────────
        $locationRef = [];
        if (!empty($reg->satusehat_location_id)) {
            $locationRef['reference'] = 'Location/' . $reg->satusehat_location_id;
        }
        if (!empty($reg->ruang_poliklinik) && $reg->ruang_poliklinik !== '0' && $reg->ruang_poliklinik !== '-') {
            $locationRef['display'] = $reg->ruang_poliklinik;
        }
        if (!empty($locationRef)) {
            $payload['location'] = [[
                'location' => $locationRef,
                'period'   => ['start' => $periodStart],
                'extension' => [[
                    'url'       => self::SVC_CLASS_URL,
                    'extension' => [
                        [
                            'url' => 'value',
                            'valueCodeableConcept' => [
                                'coding' => [[
                                    'system'  => self::SVC_CLASS_OUTPT,
                                    'code'    => 'reguler',
                                    'display' => 'Kelas Reguler',
                                ]],
                            ],
                        ],
                        [
                            'url' => 'upgradeClassIndicator',
                            'valueCodeableConcept' => [
                                'coding' => [[
                                    'system'  => self::UPGRADE_CLASS_URL,
                                    'code'    => 'kelas-tetap',
                                    'display' => 'Kelas Tetap Perawatan',
                                ]],
                            ],
                        ],
                    ],
                ]],
            ]];
        }

        return $payload;
    }
}
