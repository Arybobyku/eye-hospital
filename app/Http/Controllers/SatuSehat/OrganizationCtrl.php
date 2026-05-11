<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use PenggunaHelp;

class OrganizationCtrl extends Controller
{
    private string $orgId;
    private string $error = 'next';

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->error = PenggunaHelp::acl();
        $this->orgId = (new ConfigSatusehat())->getOrganizationId();
    }

    // ── List / Search ─────────────────────────────────────────────────────
    public function list(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge = new BridgeBase();

        $keyword = $request->search ?? '';
        if ($keyword !== '') {
            $raw = $bridge->getJson('Organization?name=' . urlencode($keyword));
        } else {
            $raw = $bridge->getJson('Organization?partof=' . $this->orgId);
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

        $result = $bridge->postJson('Organization', $payload);

        if (isset($result['id'])) {
            PenggunaHelp::log('Menambahkan Organization SatuSehat: ' . ($result['id'] ?? '-'));
            return response()->json(['data' => 'berhasil', 'result' => $result]);
        }

        return response()->json(['data' => 'gagal', 'result' => $result], 422);
    }

    // ── Profile (GET main org by env SATUSEHAT_ORGANIZATION_ID) ──────────
    public function profile(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge = new BridgeBase();
        $res    = $bridge->getJson('Organization/' . $this->orgId);

        if (empty($res['id'])) {
            return response()->json(['data' => 'gagal', 'result' => $res], 422);
        }

        // Telecom dari contact[0].telecom (berbeda dengan telecom langsung)
        $phone = '';
        $email = '';
        foreach (($res['contact'][0]['telecom'] ?? []) as $t) {
            if ($t['system'] === 'phone') $phone = $t['value'];
            if ($t['system'] === 'email') $email = $t['value'];
        }
        // Fallback ke telecom langsung jika contact kosong
        if (!$phone && !$email) {
            foreach (($res['telecom'] ?? []) as $t) {
                if ($t['system'] === 'phone') $phone = $t['value'];
                if ($t['system'] === 'email') $email = $t['value'];
            }
        }

        $addr    = $res['address'][0]  ?? [];
        $adminExt= ($addr['extension'][0]['extension'] ?? []);
        $getCode = fn($url) => collect($adminExt)->firstWhere('url', $url)['valueCode'] ?? '-';

        $profile = [
            'satusehat_id'   => $res['id'],
            'nama'           => $res['name']          ?? '-',
            'active'         => $res['active']         ?? false,
            'tipe'           => $res['type'][0]['coding'][0]['display'] ?? '-',
            'telepon'        => $phone                 ?: '-',
            'email'          => $email                 ?: '-',
            'alamat'         => $addr['line'][0]       ?? '-',
            'kota'           => $addr['city']          ?? '-',
            'provinsi'       => $addr['state']         ?? '-',
            'kecamatan'      => $addr['district']      ?? '-',
            'kode_provinsi'  => $getCode('province'),
            'kode_kota'      => $getCode('city'),
            'kode_kecamatan' => $getCode('district'),
            'kode_kelurahan' => $getCode('village'),
            'last_updated'   => $res['meta']['lastUpdated'] ?? '-',
        ];

        return response()->json(['data' => $profile]);
    }

    // ── Edit (GET by FHIR ID) ─────────────────────────────────────────────
    public function edit(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge = new BridgeBase();
        $data   = $bridge->getJson('Organization/' . $request->satusehat_id);

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

        $result = $bridge->putJson('Organization/' . $id, $payload);

        if (isset($result['id'])) {
            PenggunaHelp::log('Mengupdate Organization SatuSehat: ' . $id);
            return response()->json(['data' => 'berhasil', 'result' => $result]);
        }

        return response()->json(['data' => 'gagal', 'result' => $result], 422);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Build a FHIR Organization payload from incoming form data.
     */
    private function buildPayload(Request $request): array
    {
        $telecom = [];
        if ($request->telepon) {
            $telecom[] = ['system' => 'phone', 'value' => $request->telepon, 'use' => 'work'];
        }
        if ($request->email) {
            $telecom[] = ['system' => 'email', 'value' => $request->email, 'use' => 'work'];
        }
        if ($request->website) {
            $telecom[] = ['system' => 'url', 'value' => $request->website, 'use' => 'work'];
        }

        $adminExt = [];
        if ($request->kode_provinsi)  $adminExt[] = ['url' => 'province',  'valueCode' => $request->kode_provinsi];
        if ($request->kode_kota)      $adminExt[] = ['url' => 'city',       'valueCode' => $request->kode_kota];
        if ($request->kode_kecamatan) $adminExt[] = ['url' => 'district',   'valueCode' => $request->kode_kecamatan];
        if ($request->kode_kelurahan) $adminExt[] = ['url' => 'village',    'valueCode' => $request->kode_kelurahan];

        return [
            'resourceType' => 'Organization',
            'active'       => filter_var($request->active ?? 'true', FILTER_VALIDATE_BOOLEAN),
            'identifier'   => [[
                'use'    => 'official',
                'system' => 'http://sys-ids.kemkes.go.id/organization/' . $this->orgId,
                'value'  => $request->kode,
            ]],
            'type' => [[
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/organization-type',
                    'code'    => $request->tipe_code    ?? 'dept',
                    'display' => $request->tipe_display ?? 'Hospital Department',
                ]],
            ]],
            'name'    => $request->nama,
            'telecom' => $telecom,
            'address' => [[
                'use'        => 'work',
                'type'       => 'both',
                'line'       => [$request->alamat ?? ''],
                'city'       => $request->kota       ?? '',
                'postalCode' => $request->kode_pos   ?? '',
                'country'    => 'ID',
                'extension'  => $adminExt ? [[
                    'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                    'extension' => $adminExt,
                ]] : [],
            ]],
            'partOf' => ['reference' => 'Organization/' . $this->orgId],
        ];
    }

    /**
     * Flatten a FHIR Organization resource into a simple array for the datatable.
     */
    private function flatten(array $res): array
    {
        $telepon = '';
        $email   = '';
        foreach ($res['telecom'] ?? [] as $t) {
            if ($t['system'] === 'phone') $telepon = $t['value'];
            if ($t['system'] === 'email') $email   = $t['value'];
        }

        return [
            'satusehat_id' => $res['id']                                ?? '-',
            'kode'         => $res['identifier'][0]['value']            ?? '-',
            'nama'         => $res['name']                              ?? '-',
            'active'       => ($res['active'] ?? false) ? 'Aktif' : 'Tidak Aktif',
            'tipe'         => $res['type'][0]['coding'][0]['display']   ?? '-',
            'telepon'      => $telepon ?: '-',
            'email'        => $email   ?: '-',
        ];
    }
}
