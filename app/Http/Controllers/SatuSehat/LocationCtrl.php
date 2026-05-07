<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            if ($status === 'active')    $active++;
            elseif ($status === 'inactive')  $inactive++;
            elseif ($status === 'suspended') $suspended++;

            $tipe = $res['physicalType']['coding'][0]['code'] ?? '-';
            $tipeCount[$tipe] = ($tipeCount[$tipe] ?? 0) + 1;
        }

        // Urutkan tipe terbanyak di atas
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

        $result = $bridge->postJson('Location', $payload);

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

        $result = $bridge->putJson('Location/' . $id, $payload);

        if (isset($result['id'])) {
            PenggunaHelp::log('Mengupdate Location SatuSehat: ' . $id);
            return response()->json(['data' => 'berhasil', 'result' => $result]);
        }

        return response()->json(['data' => 'gagal', 'result' => $result], 422);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Build a FHIR Location payload from incoming form data.
     */
    private function buildPayload(Request $request): array
    {
        $telecom = [];
        if ($request->telepon) {
            $telecom[] = ['system' => 'phone', 'value' => $request->telepon, 'use' => 'work'];
        }
        if ($request->fax) {
            $telecom[] = ['system' => 'fax', 'value' => $request->fax, 'use' => 'work'];
        }
        if ($request->email) {
            $telecom[] = ['system' => 'email', 'value' => $request->email];
        }
        if ($request->website) {
            $telecom[] = ['system' => 'url', 'value' => $request->website, 'use' => 'work'];
        }

        $adminExt = [];
        if ($request->kode_provinsi)  $adminExt[] = ['url' => 'province',  'valueCode' => $request->kode_provinsi];
        if ($request->kode_kota)      $adminExt[] = ['url' => 'city',       'valueCode' => $request->kode_kota];
        if ($request->kode_kecamatan) $adminExt[] = ['url' => 'district',   'valueCode' => $request->kode_kecamatan];
        if ($request->kode_kelurahan) $adminExt[] = ['url' => 'village',    'valueCode' => $request->kode_kelurahan];
        if ($request->rt)             $adminExt[] = ['url' => 'rt',         'valueCode' => $request->rt];
        if ($request->rw)             $adminExt[] = ['url' => 'rw',         'valueCode' => $request->rw];

        $physicalTypeMap = [
            'ro'  => 'Room',
            'bu'  => 'Building',
            'wi'  => 'Wing',
            'lvl' => 'Level',
            'co'  => 'Corridor',
            'wa'  => 'Ward',
            've'  => 'Vehicle',
            'ho'  => 'House',
            'ca'  => 'Cabinet',
            'rd'  => 'Road',
            'area'=> 'Area',
            'jdn' => 'Jurisdiction',
        ];
        $physCode    = $request->tipe_fisik ?? 'ro';
        $physDisplay = $physicalTypeMap[$physCode] ?? 'Room';

        $position = [];
        if ($request->longitude || $request->latitude) {
            $position = [
                'longitude' => (float)($request->longitude ?? 0),
                'latitude'  => (float)($request->latitude  ?? 0),
                'altitude'  => (float)($request->altitude  ?? 0),
            ];
        }

        $payload = [
            'resourceType' => 'Location',
            'identifier'   => [[
                'system' => 'http://sys-ids.kemkes.go.id/location/' . $this->orgId,
                'value'  => $request->kode,
            ]],
            'status'      => $request->status      ?? 'active',
            'name'        => $request->nama,
            'description' => $request->deskripsi   ?? '',
            'mode'        => $request->mode         ?? 'instance',
            'telecom'     => $telecom,
            'address'     => [
                'use'        => 'work',
                'line'       => [$request->alamat ?? ''],
                'city'       => $request->kota       ?? '',
                'postalCode' => $request->kode_pos   ?? '',
                'country'    => 'ID',
                'extension'  => $adminExt ? [[
                    'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                    'extension' => $adminExt,
                ]] : [],
            ],
            'physicalType' => [
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/location-physical-type',
                    'code'    => $physCode,
                    'display' => $physDisplay,
                ]],
            ],
            'managingOrganization' => [
                'reference' => 'Organization/' . $this->orgId,
            ],
        ];

        if ($position) {
            $payload['position'] = $position;
        }

        return $payload;
    }

    /**
     * Flatten a FHIR Location resource into a simple array for the datatable.
     */
    private function flatten(array $res): array
    {
        $telepon = '';
        foreach ($res['telecom'] ?? [] as $t) {
            if ($t['system'] === 'phone') $telepon = $t['value'];
        }

        return [
            'satusehat_id' => $res['id']                                        ?? '-',
            'kode'         => $res['identifier'][0]['value']                    ?? '-',
            'nama'         => $res['name']                                      ?? '-',
            'status'       => ucfirst($res['status'] ?? '-'),
            'deskripsi'    => $res['description']                               ?? '-',
            'tipe_fisik'   => $res['physicalType']['coding'][0]['display']      ?? '-',
            'telepon'      => $telepon ?: '-',
        ];
    }
}
