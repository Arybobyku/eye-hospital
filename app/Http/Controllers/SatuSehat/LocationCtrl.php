<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use PenggunaHelp;

class LocationCtrl extends Controller
{
    private string $orgId;
    private string $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
        $this->orgId = (new ConfigSatusehat())->getOrganizationId();
    }

    // ── Profile / Summary (hit saat halaman dibuka) ───────────────────────
    public function profile(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge  = new BridgeBase();
        $raw     = $bridge->getJson('Location?organization=' . $this->orgId);
        $entries = $raw['entry'] ?? [];

        // Hitung stats dari semua entry
        $total     = $raw['total'] ?? count($entries);
        $active    = 0;
        $inactive  = 0;
        $suspended = 0;
        $tipeCount = [];

        foreach ($entries as $e) {
            $res    = $e['resource'] ?? [];
            $status = strtolower($res['status'] ?? '');
            if ($status === 'active')         $active++;
            elseif ($status === 'inactive')   $inactive++;
            elseif ($status === 'suspended')  $suspended++;

            $tipe = $res['physicalType']['coding'][0]['code'] ?? '-';
            $tipeCount[$tipe] = ($tipeCount[$tipe] ?? 0) + 1;
        }

        arsort($tipeCount);

        return response()->json([
            'data' => [
                'organization_id' => $this->orgId,
                'total'           => (int) $total,
                'active'          => $active,
                'inactive'        => $inactive,
                'suspended'       => $suspended,
                'tipe_count'      => $tipeCount,
            ]
        ]);
    }

    // ── List / Search ─────────────────────────────────────────────────────
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge  = new BridgeBase();
        $keyword = $request->search ?? '';

        if ($keyword !== '') {
            $raw = $bridge->getJson('Location?name=' . urlencode($keyword));
        } else {
            $raw = $bridge->getJson('Location?organization=' . $this->orgId);
        }

        $entries = $raw['entry'] ?? [];
        $data    = array_values(array_map(fn($e) => $this->flatten($e['resource'] ?? []), $entries));
        $total   = $raw['total'] ?? count($data);

        return response()->json(['data' => $data, 'total' => $total]);
    }

    // ── Add (POST) ────────────────────────────────────────────────────────
    public function add(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge  = new BridgeBase();
        $payload = $this->buildPayload($request);
        $result  = $bridge->postJson('Location', $payload);

        if (isset($result['id'])) {
            PenggunaHelp::log('Menambahkan Location SatuSehat: ' . ($result['id'] ?? '-'));
            return response()->json(['data' => 'berhasil', 'result' => $result]);
        }

        return response()->json(['data' => 'gagal', 'result' => $result], 422);
    }

    // ── Edit (GET by FHIR ID) ─────────────────────────────────────────────
    public function edit(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge = new BridgeBase();
        $data   = $bridge->getJson('Location/' . $request->satusehat_id);

        return response()->json(['data' => $data]);
    }

    // ── Update (PUT) ──────────────────────────────────────────────────────
    public function update(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge  = new BridgeBase();
        $id      = $request->satusehat_id;
        $payload = array_merge($this->buildPayload($request), ['id' => $id]);
        $result  = $bridge->putJson('Location/' . $id, $payload);

        if (isset($result['id'])) {
            PenggunaHelp::log('Mengupdate Location SatuSehat: ' . $id);
            return response()->json(['data' => 'berhasil', 'result' => $result]);
        }

        return response()->json(['data' => 'gagal', 'result' => $result], 422);
    }

    // ── Sync → local DB ───────────────────────────────────────────────────

    /**
     * Fetch ALL locations from SatuSehat and upsert into satusehat_locations.
     */
    public function sync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        try {
            $bridge  = new BridgeBase();
            $raw     = $bridge->getJson('Location?organization=' . $this->orgId . '&_count=500');
            $entries = $raw['entry'] ?? [];

            if (empty($entries)) {
                return response()->json([
                    'data'    => 'berhasil',
                    'message' => 'Tidak ada lokasi ditemukan di SatuSehat.',
                    'count'   => 0,
                ]);
            }

            $now   = now();
            $saved = 0;

            foreach ($entries as $e) {
                $res = $e['resource'] ?? [];
                if (empty($res['id'])) continue;

                $row = $this->flattenForDb($res);

                DB::table('satusehat_locations')->upsert(
                    array_merge($row, [
                        'raw_data'   => json_encode($res),
                        'synced_at'  => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]),
                    ['satusehat_id'],                 // unique key
                    array_merge(array_keys($row), ['raw_data', 'synced_at', 'updated_at'])
                );
                $saved++;
            }

            PenggunaHelp::log("Sync Location SatuSehat: {$saved} lokasi disimpan ke satusehat_locations.");

            return response()->json([
                'data'    => 'berhasil',
                'message' => "{$saved} lokasi berhasil disinkronkan ke database lokal.",
                'count'   => $saved,
            ]);

        } catch (\Throwable $e) {
            return response()->json(['data' => 'gagal', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Return local sync status: total records, last sync time.
     */
    public function syncStatus(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $total    = DB::table('satusehat_locations')->count();
        $lastSync = DB::table('satusehat_locations')->max('synced_at');

        return response()->json([
            'data' => [
                'total'      => (int) $total,
                'last_synced'=> $lastSync,
            ]
        ]);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Build a FHIR Location payload from incoming form data.
     */
    private function buildPayload(Request $request): array
    {
        // ── resolve relasi awal (diperlukan untuk derivasi identifier) ───
        $partOfId   = trim($request->part_of              ?? '');
        $managingId = trim($request->managing_organization ?? '');

        // ── identifier ───────────────────────────────────────────────────
        // Sub-lokasi  (ada partOf)   → system berasal dari identifier Location induk
        // Lokasi root (tanpa partOf) → system berasal dari identifier managing Organization
        // Rumus: parent.identifier[0].system + '/' + parent.identifier[0].value
        $identifier = [];
        if ($request->kode) {
            if ($partOfId) {
                // Fetch parent Location
                $parentRes    = (new BridgeBase())->getJson('Location/' . $partOfId);
                $parentIdent  = $parentRes['identifier'][0] ?? [];
                $parentSystem = $parentIdent['system'] ?? 'https://fhir.kemkes.go.id/id/org-number';
                $parentValue  = $parentIdent['value']  ?? $this->orgId;
            } else {
                // Fetch managing Organization
                $orgId        = $managingId ?: $this->orgId;
                $parentRes    = (new BridgeBase())->getJson('Organization/' . $orgId);
                $parentIdent  = $parentRes['identifier'][0] ?? [];
                $parentSystem = $parentIdent['system'] ?? 'https://fhir.kemkes.go.id/id/org-number';
                $parentValue  = $parentIdent['value']  ?? $orgId;
            }
            $identifier[] = [
                'use'    => 'official',
                'system' => rtrim($parentSystem, '/') . '/' . $parentValue,
                'value'  => $request->kode,
            ];
        }

        // ── alias ────────────────────────────────────────────────────────
        $alias = [];
        if ($request->alias) {
            $alias = [$request->alias];
        }

        // ── operationalStatus ────────────────────────────────────────────
        $opStatusMap = [
            'O' => 'Occupied',
            'C' => 'Closed',
            'H' => 'Housekeeping',
            'K' => 'Contaminated',
            'I' => 'Isolated',
            'U' => 'Unoccupied',
        ];
        $opCode    = trim($request->operational_status ?? '');
        $opDisplay = $opStatusMap[$opCode] ?? '';

        // ── type (tipe layanan) ──────────────────────────────────────────
        $tipeLayanan    = trim($request->tipe_layanan         ?? '');
        $tipeLayananDisp = trim($request->tipe_layanan_display ?? $tipeLayanan);

        // ── telecom ──────────────────────────────────────────────────────
        $telecom = [];
        if ($request->telepon) $telecom[] = ['system' => 'phone', 'value' => $request->telepon, 'use' => 'work'];
        if ($request->fax)     $telecom[] = ['system' => 'fax',   'value' => $request->fax,     'use' => 'work'];
        if ($request->email)   $telecom[] = ['system' => 'email', 'value' => $request->email];
        if ($request->website) $telecom[] = ['system' => 'url',   'value' => $request->website, 'use' => 'work'];

        // ── address ──────────────────────────────────────────────────────
        $adminExt = [];
        if ($request->kode_provinsi)  $adminExt[] = ['url' => 'province',  'valueCode' => $request->kode_provinsi];
        if ($request->kode_kota)      $adminExt[] = ['url' => 'city',       'valueCode' => $request->kode_kota];
        if ($request->kode_kecamatan) $adminExt[] = ['url' => 'district',   'valueCode' => $request->kode_kecamatan];
        if ($request->kode_kelurahan) $adminExt[] = ['url' => 'village',    'valueCode' => $request->kode_kelurahan];
        if ($request->rt)             $adminExt[] = ['url' => 'rt',         'valueCode' => $request->rt];
        if ($request->rw)             $adminExt[] = ['url' => 'rw',         'valueCode' => $request->rw];

        $address = [
            'use'        => $request->address_use ?? 'work',
            'line'       => [$request->alamat    ?? ''],
            'city'       => $request->kota        ?? '',
            'postalCode' => $request->kode_pos    ?? '',
            'country'    => 'ID',
        ];
        if ($adminExt) {
            $address['extension'] = [[
                'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                'extension' => $adminExt,
            ]];
        }

        // ── physicalType ─────────────────────────────────────────────────
        $physCode    = $request->tipe_fisik         ?? 'ro';
        $physDisplay = $request->tipe_fisik_display ?? 'Room';

        // ── position ─────────────────────────────────────────────────────
        $position = [];
        if ($request->longitude || $request->latitude) {
            $position = [
                'longitude' => (float)($request->longitude ?? 0),
                'latitude'  => (float)($request->latitude  ?? 0),
                'altitude'  => (float)($request->altitude  ?? 0),
            ];
        }

        // ── managingOrganization ─────────────────────────────────────────
        $managingOrg = ['reference' => 'Organization/' . ($managingId ?: $this->orgId)];

        // ── hoursOfOperation ─────────────────────────────────────────────
        $hoursOfOperation = [];
        $hoursDays = trim($request->hours_days ?? '');
        if ($hoursDays || $request->hours_opening || $request->hours_closing) {
            $daysArr  = $hoursDays ? array_filter(array_map('trim', explode(',', $hoursDays))) : [];
            $allDay   = filter_var($request->hours_all_day ?? 'false', FILTER_VALIDATE_BOOLEAN);
            $hoursItem = ['allDay' => $allDay];
            if ($daysArr) {
                $hoursItem['daysOfWeek'] = array_values($daysArr);
            }
            if ($request->hours_opening) {
                $open = $request->hours_opening;
                $hoursItem['openingTime'] = (strlen($open) === 5) ? $open . ':00' : $open;
            }
            if ($request->hours_closing) {
                $close = $request->hours_closing;
                $hoursItem['closingTime'] = (strlen($close) === 5) ? $close . ':00' : $close;
            }
            $hoursOfOperation[] = $hoursItem;
        }

        // ── serviceClass extension ────────────────────────────────────────
        $scCode = trim($request->service_class ?? '');
        $extensions = [];
        if ($scCode) {
            $scMap = [
                '1'    => ['code' => 'kelas_1', 'display' => 'Kelas 1'],
                '2'    => ['code' => 'kelas_2', 'display' => 'Kelas 2'],
                '3'    => ['code' => 'kelas_3', 'display' => 'Kelas 3'],
                'VIP'  => ['code' => 'vip',     'display' => 'VIP'],
                'VVIP' => ['code' => 'vvip',    'display' => 'VVIP'],
            ];
            $sc = $scMap[$scCode] ?? null;
            if ($sc) {
                $extensions[] = [
                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/LocationServiceClass',
                    'extension' => [[
                        'url' => 'inpatientServiceClass',
                        'valueCodeableConcept' => [
                            'coding' => [[
                                'system'  => 'http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Rawat-Inap',
                                'code'    => $sc['code'],
                                'display' => $sc['display'],
                            ]],
                        ],
                    ]],
                ];
            }
        }

        // ── assemble payload ──────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Location',
            'identifier'   => $identifier,
            'status'      => $request->status ?? 'active',
            'name'        => $request->nama    ?? '',
            'description' => $request->deskripsi ?? '',
            'mode'        => $request->mode     ?? 'instance',
            'telecom'     => $telecom,
            'address'     => $address,
            'physicalType' => [
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/location-physical-type',
                    'code'    => $physCode,
                    'display' => $physDisplay,
                ]],
            ],
            'managingOrganization' => $managingOrg,
        ];

        if ($alias)           $payload['alias']   = $alias;
        if ($extensions)      $payload['extension'] = $extensions;
        if ($position)        $payload['position'] = $position;
        if ($partOfId)        $payload['partOf']   = ['reference' => 'Location/' . $partOfId];

        if ($opCode && $opDisplay) {
            $payload['operationalStatus'] = [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0116',
                'code'    => $opCode,
                'display' => $opDisplay,
            ];
        }

        if ($tipeLayanan) {
            $payload['type'] = [[
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-RoleCode',
                    'code'    => $tipeLayanan,
                    'display' => $tipeLayananDisp,
                ]],
            ]];
        }

        if ($hoursOfOperation) {
            $payload['hoursOfOperation'] = $hoursOfOperation;
        }

        $avail = trim($request->availability_exceptions ?? '');
        if ($avail) {
            $payload['availabilityExceptions'] = $avail;
        }

        return $payload;
    }

    /**
     * Flatten a FHIR Location resource into a simple array for the datatable.
     */
    private function flatten(array $res): array
    {
        $telepon = '';
        $email   = '';
        $website = '';
        foreach ($res['telecom'] ?? [] as $t) {
            if ($t['system'] === 'phone') $telepon = $t['value'];
            if ($t['system'] === 'email') $email   = $t['value'];
            if ($t['system'] === 'url')   $website = $t['value'];
        }

        $addr    = $res['address'] ?? [];
        $opCode  = $res['operationalStatus']['code'] ?? '';
        $tipeLayanan = $res['type'][0]['coding'][0]['code'] ?? '-';

        // service class
        $scExt   = collect($res['extension'] ?? [])->firstWhere('url', 'https://fhir.kemkes.go.id/r4/StructureDefinition/LocationServiceClass');
        $scInner = collect($scExt['extension'] ?? [])->firstWhere('url', 'inpatientServiceClass');
        $scCode  = $scInner['valueCodeableConcept']['coding'][0]['code'] ?? '';
        $serviceClass = $scCode ? strtoupper(str_replace('kelas_', '', $scCode)) : '-';

        return [
            'satusehat_id'   => $res['id']                                    ?? '-',
            'kode'           => $res['identifier'][0]['value']                ?? '-',
            'nama'           => $res['name']                                  ?? '-',
            'alias'          => implode(', ', $res['alias'] ?? []) ?: '-',
            'status'         => ucfirst($res['status']                        ?? '-'),
            'operational_status' => $opCode ?: '-',
            'deskripsi'      => $res['description']                           ?? '-',
            'tipe_layanan'   => $tipeLayanan,
            'tipe_fisik'     => $res['physicalType']['coding'][0]['display']  ?? '-',
            'service_class'  => $serviceClass,
            'telepon'        => $telepon ?: '-',
            'email'          => $email   ?: '-',
            'website'        => $website ?: '-',
            'kota'           => $addr['city']       ?? '-',
            'kode_pos'       => $addr['postalCode'] ?? '-',
            'managing_organization' => $res['managingOrganization']['reference'] ?? '-',
            'part_of'        => $res['partOf']['reference'] ?? '-',
        ];
    }

    /**
     * Flatten a FHIR Location resource into a full row for satusehat_locations table.
     */
    private function flattenForDb(array $res): array
    {
        // Telecom
        $telepon = $email = $website = '';
        foreach ($res['telecom'] ?? [] as $t) {
            if ($t['system'] === 'phone') $telepon = $t['value'];
            if ($t['system'] === 'email') $email   = $t['value'];
            if ($t['system'] === 'url')   $website = $t['value'];
        }

        // Address + administrativeCode extension
        $addr    = $res['address'] ?? [];
        $adminExt = $addr['extension'][0]['extension'] ?? [];
        $getCode  = fn($url) => collect($adminExt)->firstWhere('url', $url)['valueCode'] ?? null;

        // Service class
        $scExt    = collect($res['extension'] ?? [])->firstWhere('url', 'https://fhir.kemkes.go.id/r4/StructureDefinition/LocationServiceClass');
        $scInner  = collect($scExt['extension'] ?? [])->firstWhere('url', 'inpatientServiceClass');
        $scCode   = $scInner['valueCodeableConcept']['coding'][0]['code'] ?? '';
        $scLabel  = $scCode ? strtoupper(str_replace('kelas_', '', $scCode)) : null;

        // Hours of operation
        $hours    = $res['hoursOfOperation'][0] ?? null;
        $allDay   = (bool)($hours['allDay']       ?? false);
        $days     = implode(',', $hours['daysOfWeek'] ?? []);
        $opening  = $hours['openingTime'] ?? null;
        $closing  = $hours['closingTime'] ?? null;

        // partOf & managingOrganization — strip prefix to keep only FHIR ID
        $partOfRef  = $res['partOf']['reference']              ?? '';
        $mgRef      = $res['managingOrganization']['reference'] ?? '';
        $partOfId   = $partOfRef ? preg_replace('/^Location\//', '', $partOfRef)     : null;
        $managingId = $mgRef     ? preg_replace('/^Organization\//', '', $mgRef)     : null;

        return [
            'satusehat_id'         => $res['id'],
            'kode'                 => $res['identifier'][0]['value']               ?? null,
            'nama'                 => $res['name']                                 ?? '',
            'alias'                => ($res['alias'][0] ?? null),
            'status'               => $res['status']                               ?? 'active',
            'operational_status'   => $res['operationalStatus']['code']            ?? null,
            'deskripsi'            => $res['description']                          ?? null,
            'mode'                 => $res['mode']                                 ?? 'instance',
            'tipe_layanan'         => $res['type'][0]['coding'][0]['code']         ?? null,
            'tipe_layanan_display' => $res['type'][0]['coding'][0]['display']       ?? null,
            'tipe_fisik'           => $res['physicalType']['coding'][0]['code']    ?? null,
            'tipe_fisik_display'   => $res['physicalType']['coding'][0]['display'] ?? null,
            'service_class'        => $scLabel,
            'telepon'              => $telepon   ?: null,
            'email'                => $email     ?: null,
            'website'              => $website   ?: null,
            'alamat'               => $addr['line'][0]   ?? null,
            'kota'                 => $addr['city']      ?? null,
            'kode_pos'             => $addr['postalCode'] ?? null,
            'kode_provinsi'        => $getCode('province'),
            'kode_kota'            => $getCode('city'),
            'kode_kecamatan'       => $getCode('district'),
            'kode_kelurahan'       => $getCode('village'),
            'rt'                   => $getCode('rt'),
            'rw'                   => $getCode('rw'),
            'latitude'             => isset($res['position']['latitude'])  ? (float)$res['position']['latitude']  : null,
            'longitude'            => isset($res['position']['longitude']) ? (float)$res['position']['longitude'] : null,
            'managing_organization'=> $managingId,
            'part_of'              => $partOfId,
            'hours_all_day'        => $allDay,
            'hours_days'           => $days     ?: null,
            'hours_opening'        => $opening,
            'hours_closing'        => $closing,
            'availability_exceptions' => $res['availabilityExceptions'] ?? null,
        ];
    }
}
