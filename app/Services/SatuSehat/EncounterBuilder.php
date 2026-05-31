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
    private const SVCTYPE_SYSTEM        = 'http://terminology.hl7.org/CodeSystem/service-type';
    private const PARTICIP_SYSTEM       = 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType';
    private const SVC_CLASS_URL         = 'https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass';
    private const SVC_CLASS_OUTPT       = 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient';
    private const UPGRADE_CLASS_URL     = 'http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass';

    // ── Status FHIR yang valid (outpatient) ───────────────────────────────────
    public const FHIR_STATUSES = [
        'arrived'     => 'Tiba / Mendaftar',
        'in-progress' => 'Sedang Diperiksa',
        'finished'    => 'Selesai',
        'cancelled'   => 'Dibatalkan',
    ];

    /**
     * Build FHIR Encounter resource payload dari satu baris registrasi.
     *
     * @param  object $reg    Baris registrasi
     * @param  string $orgId  Organization FHIR ID
     * @return array          FHIR Encounter payload siap di-POST/PUT ke API
     */
    public static function build(object $reg, string $orgId): array
    {
        // ── Identifier system ─────────────────────────────────────────────
        $orgLocal    = DB::table('satusehat_organizations')
            ->where('satusehat_id', $orgId)
            ->first();
        $identSystem = ($orgLocal && $orgLocal->identifier_system && $orgLocal->identifier_value)
            ? rtrim($orgLocal->identifier_system, '/') . '/' . $orgLocal->identifier_value
            : self::FALLBACK_IDENT_PREFIX . $orgId;

        // ── Period start ──────────────────────────────────────────────────
        $waktu       = $reg->waktu ?? '00:00';
        $periodStart = $reg->tanggal . 'T' . $waktu . ':00+07:00';

        // ── FHIR current status + statusHistory ───────────────────────────
        // Saat pertama POST: default 'arrived'.
        // Saat PUT (update): ambil dari DB.
        $fhirStatus    = $reg->satusehat_encounter_fhir_status ?? 'arrived';
        $statusHistory = self::buildStatusHistory($reg->uuid ?? null, $periodStart, $fhirStatus);

        // ── Payload dasar ─────────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Encounter',
            'identifier'   => [[
                'system' => $identSystem,
                'value'  => $reg->nomor,
            ]],
            'status' => $fhirStatus,
            'class'  => [
                'system'  => self::CLASS_SYSTEM,
                'code'    => 'AMB',
                'display' => 'ambulatory',
            ],
            'serviceType' => [
                'coding' => [[
                    'system'  => self::SVCTYPE_SYSTEM,
                    'code'    => '397',
                    'display' => 'Outpatients',
                ]],
            ],
            'subject' => [
                'reference' => 'Patient/' . $reg->patient_ihs_id,
                'display'   => $reg->nama_pasien ?? '',
            ],
            'period'          => ['start' => $periodStart],
            'statusHistory'   => $statusHistory,
            'serviceProvider' => ['reference' => 'Organization/' . $orgId],
        ];

        // Tambahkan period.end jika encounter sudah selesai/dibatalkan
        if (in_array($fhirStatus, ['finished', 'cancelled'])) {
            $lastHistory = end($statusHistory);
            if (!empty($lastHistory['period']['start'])) {
                $payload['period']['end'] = $lastHistory['period']['start'];
            }
        }

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

        // ── Locations — mendukung multi-location: Front Office, RO, Poli ────
        $serviceClassExtension = [
            'url' => self::SVC_CLASS_URL,
        ];

        $locations = [];

        // 1. Front Office / primary location
        if (!empty($reg->satusehat_location_id)) {
            $ref = ['reference' => 'Location/' . $reg->satusehat_location_id];
            if (
                empty($reg->satusehat_location_poli_id)
                && !empty($reg->ruang_poliklinik)
                && $reg->ruang_poliklinik !== '0'
                && $reg->ruang_poliklinik !== '-'
            ) {
                $ref['display'] = $reg->ruang_poliklinik;
            }
            $locations[] = [
                'location'  => $ref,
                'status'    => 'completed',
                'period'    => ['start' => $periodStart],
                'extension' => [$serviceClassExtension],
            ];
        }

        // 2. Ruang Refraksi Optisi / RO
        if (!empty($reg->satusehat_location_ro_id)) {
            $locations[] = [
                'location'  => [
                    'reference' => 'Location/' . $reg->satusehat_location_ro_id,
                    'display'   => 'Refraksi Optisi',
                ],
                'status'    => 'completed',
                'period'    => ['start' => $periodStart],
                'extension' => [$serviceClassExtension],
            ];
        }

        // 3. Ruang Poli Dokter — active saat in-progress, completed saat selesai
        if (!empty($reg->satusehat_location_poli_id)) {
            $poliRef = ['reference' => 'Location/' . $reg->satusehat_location_poli_id];
            if (!empty($reg->ruang_poliklinik) && $reg->ruang_poliklinik !== '0' && $reg->ruang_poliklinik !== '-') {
                $poliRef['display'] = $reg->ruang_poliklinik;
            }
            $locations[] = [
                'location'  => $poliRef,
                'status'    => in_array($fhirStatus, ['finished', 'cancelled']) ? 'completed' : 'active',
                'period'    => ['start' => $periodStart],
                'extension' => [$serviceClassExtension],
            ];
        }

        if (!empty($locations)) {
            $payload['location'] = $locations;
        }

        return $payload;
    }

    /**
     * Build FHIR Encounter payload untuk PUT (update progress).
     *
     * Dipakai oleh SyncEncounterToSatuSehat job untuk event encounter_ro dan encounter_dokter.
     * Pemanggil HARUS memperbarui tabel satusehat_encounter_status_history di DB
     * SEBELUM memanggil method ini, supaya buildStatusHistory() membaca data yang sudah benar.
     *
     * @param  object $reg              Baris registrasi (dengan join pasien & pengguna)
     * @param  string $orgId            Organization FHIR ID
     * @param  string $newFhirStatus    Status baru: 'in-progress' | 'finished' | 'cancelled'
     * @param  string $locationId       FHIR Location.id yang akan dipakai
     * @param  string $locationDisplay  Display name lokasi
     * @param  bool   $withPractitioner Sertakan participant.individual (untuk event dokter)
     * @return array  FHIR Encounter payload siap di-PUT ke API
     */
    public static function buildPut(
        object $reg,
        string $orgId,
        string $newFhirStatus,
        string $locationId,
        string $locationDisplay,
        bool   $withPractitioner = false,
        array  $diagnosis = [],
        string $periodStart = ''    // jika kosong, fallback ke waktu registrasi
    ): array {
        // ── Identifier system ─────────────────────────────────────────────
        $orgLocal    = DB::table('satusehat_organizations')
            ->where('satusehat_id', $orgId)
            ->first();
        $identSystem = ($orgLocal && $orgLocal->identifier_system && $orgLocal->identifier_value)
            ? rtrim($orgLocal->identifier_system, '/') . '/' . $orgLocal->identifier_value
            : self::FALLBACK_IDENT_PREFIX . $orgId;

        // ── Period start ──────────────────────────────────────────────────
        // Jika pemanggil menyediakan timestamp eksplisit (mis. waktu RO dicatat
        // atau waktu RO selesai), gunakan itu. Fallback ke waktu registrasi.
        if ($periodStart === '') {
            $waktu       = $reg->waktu ?? '00:00';
            $periodStart = $reg->tanggal . 'T' . $waktu . ':00+07:00';
        }

        // ── Period end = waktu sekarang (WIB) ─────────────────────────────
        $periodEnd = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))
            ->format('Y-m-d\TH:i:sP');

        // ── statusHistory dari DB (DB sudah diperbarui oleh pemanggil) ────
        // Kirim $periodEnd agar entry terakhir selalu punya period.end (SatuSehat mensyaratkannya)
        $statusHistory = self::buildStatusHistory($reg->uuid ?? null, $periodStart, $newFhirStatus, $periodEnd);

        // ── Participant ───────────────────────────────────────────────────
        $participantType = [[
            'coding' => [[
                'system'  => self::PARTICIP_SYSTEM,
                'code'    => 'ATND',
                'display' => 'attender',
            ]],
        ]];

        $participantEntry = ['type' => $participantType];

        if ($withPractitioner) {
            $individual = [];
            if (!empty($reg->practitioner_ihs_id)) {
                $individual['reference'] = 'Practitioner/' . $reg->practitioner_ihs_id;
            }
            if (!empty($reg->nama_dokter) && $reg->nama_dokter !== '-') {
                $individual['display'] = $reg->nama_dokter;
            }
            if (!empty($individual)) {
                $participantEntry['individual'] = $individual;
            }
        }

        $payload = [
            'resourceType' => 'Encounter',
            'id'           => $reg->satusehat_encounter_id,
            'identifier'   => [[
                'system' => $identSystem,
                'value'  => $reg->nomor,
            ]],
            'status' => $newFhirStatus,
            'class'  => [
                'system'  => self::CLASS_SYSTEM,
                'code'    => 'AMB',
                'display' => 'ambulatory',
            ],
            'subject' => [
                'reference' => 'Patient/' . ($reg->patient_ihs_id ?? ''),
                'display'   => $reg->nama_pasien ?? '',
            ],
            'participant' => [$participantEntry],
            'period'      => [
                'start' => $periodStart,
                'end'   => $periodEnd,
            ],
            'location' => [[
                'location' => [
                    'reference' => 'Location/' . $locationId,
                    'display'   => $locationDisplay,
                ],
            ]],
            'statusHistory'   => $statusHistory,
            'serviceProvider' => ['reference' => 'Organization/' . $orgId],
        ];

        // Sertakan diagnosis array jika ada Condition yang sudah di-POST
        if (!empty($diagnosis)) {
            $payload['diagnosis'] = $diagnosis;
        }

        return $payload;
    }

    /**
     * Build FHIR statusHistory array dari tabel satusehat_encounter_status_history.
     * Jika belum ada record, kembalikan default [arrived].
     *
     * @param  string $defaultPeriodEnd  Nilai fallback period.end untuk entry terakhir jika masih null.
     *                                   SatuSehat mensyaratkan period.end ada di semua entry statusHistory,
     *                                   termasuk status yang sedang berjalan. Biasanya diisi dengan
     *                                   $periodEnd dari buildPut() (= timestamp sekarang WIB).
     */
    public static function buildStatusHistory(
        ?string $registrasiUuid,
        string  $defaultPeriodStart,
        string  $currentStatus    = 'arrived',
        string  $defaultPeriodEnd = ''
    ): array {
        // Urutan status logis, bukan pakai period_start timestamp
        // (timestamp bisa tidak konsisten antara waktu registrasi vs now())
        $statusOrder = "CASE status
            WHEN 'arrived'     THEN 1
            WHEN 'in-progress' THEN 2
            WHEN 'finished'    THEN 3
            WHEN 'cancelled'   THEN 4
            ELSE 5 END";

        if (!$registrasiUuid) {
            $entry = ['status' => 'arrived', 'period' => ['start' => $defaultPeriodStart]];
            if ($defaultPeriodEnd !== '') {
                $entry['period']['end'] = $defaultPeriodEnd;
            }
            return [$entry];
        }

        $rows = DB::table('satusehat_encounter_status_history')
            ->where('registrasi_uuid', $registrasiUuid)
            ->orderByRaw($statusOrder)
            ->orderBy('id')
            ->get(['status', 'period_start', 'period_end']);

        if ($rows->isEmpty()) {
            $entry = ['status' => 'arrived', 'period' => ['start' => $defaultPeriodStart]];
            if ($defaultPeriodEnd !== '') {
                $entry['period']['end'] = $defaultPeriodEnd;
            }
            return [$entry];
        }

        $history = [];
        foreach ($rows as $row) {
            $entry = [
                'status' => $row->status,
                'period' => ['start' => self::toFhirDateTime($row->period_start)],
            ];
            if (!empty($row->period_end)) {
                $entry['period']['end'] = self::toFhirDateTime($row->period_end);
            }
            $history[] = $entry;
        }

        // Pastikan entry terakhir punya period.end — SatuSehat menolak jika undefined
        $lastIdx = count($history) - 1;
        if (!isset($history[$lastIdx]['period']['end']) && $defaultPeriodEnd !== '') {
            $history[$lastIdx]['period']['end'] = $defaultPeriodEnd;
        }

        return $history;
    }

    /**
     * Konversi timestamp DB (UTC/any) ke ISO8601 +07:00 (WIB).
     */
    private static function toFhirDateTime(string $ts): string
    {
        try {
            $dt = new \DateTime($ts, new \DateTimeZone('UTC'));
            $dt->setTimezone(new \DateTimeZone('Asia/Jakarta'));
            return $dt->format('Y-m-d\TH:i:sP');
        } catch (\Throwable) {
            return $ts;
        }
    }
}
