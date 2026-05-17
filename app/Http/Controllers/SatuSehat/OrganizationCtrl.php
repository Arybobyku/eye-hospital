<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $bridge  = new BridgeBase();
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
        $result  = $bridge->postJson('Organization', $payload);

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

        // Telecom dari contact[0].telecom, fallback ke telecom langsung
        $phone = '';
        $email = '';
        foreach (($res['contact'][0]['telecom'] ?? []) as $t) {
            if ($t['system'] === 'phone') $phone = $t['value'];
            if ($t['system'] === 'email') $email = $t['value'];
        }
        if (!$phone && !$email) {
            foreach (($res['telecom'] ?? []) as $t) {
                if ($t['system'] === 'phone') $phone = $t['value'];
                if ($t['system'] === 'email') $email = $t['value'];
            }
        }
        $website = '';
        foreach (($res['telecom'] ?? []) as $t) {
            if ($t['system'] === 'url') $website = $t['value'];
        }

        $addr     = $res['address'][0] ?? [];
        $adminExt = $addr['extension'][0]['extension'] ?? [];
        $getCode  = fn($url) => collect($adminExt)->firstWhere('url', $url)['valueCode'] ?? '-';

        $profile = [
            'satusehat_id'   => $res['id'],
            'nama'           => $res['name']     ?? '-',
            'alias'          => $res['alias']    ?? [],
            'active'         => $res['active']   ?? false,
            'tipe'           => $res['type'][0]['coding'][0]['display'] ?? '-',
            'tipe_code'      => $res['type'][0]['coding'][0]['code']    ?? '-',
            'telepon'        => $phone   ?: '-',
            'email'          => $email   ?: '-',
            'website'        => $website ?: '-',
            'address_use'    => $addr['use']  ?? '-',
            'address_type'   => $addr['type'] ?? '-',
            'alamat'         => $addr['line'][0]   ?? '-',
            'kota'           => $addr['city']       ?? '-',
            'kode_pos'       => $addr['postalCode'] ?? '-',
            'provinsi'       => $addr['state']      ?? '-',
            'kecamatan'      => $addr['district']   ?? '-',
            'kode_provinsi'  => $getCode('province'),
            'kode_kota'      => $getCode('city'),
            'kode_kecamatan' => $getCode('district'),
            'kode_kelurahan' => $getCode('village'),
            'part_of'        => $res['partOf']['reference'] ?? '-',
            // Contact tujuan (pertama jika ada)
            'contact_purpose'=> $res['contact'][0]['purpose']['coding'][0]['display'] ?? '-',
            'contact_purpose_code' => $res['contact'][0]['purpose']['coding'][0]['code'] ?? '-',
            'contact_nama'   => $res['contact'][0]['name']['text'] ?? '-',
            'contact_telepon'=> collect($res['contact'][0]['telecom'] ?? [])->firstWhere('system', 'phone')['value'] ?? '-',
            'contact_email'  => collect($res['contact'][0]['telecom'] ?? [])->firstWhere('system', 'email')['value'] ?? '-',
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
        $result  = $bridge->putJson('Organization/' . $id, $payload);

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
        // ── partOf (resolved early — needed for identifier derivation) ──
        $partOfId = trim($request->part_of ?? '');

        // ── identifier ──────────────────────────────────────────────────
        // Sub-org  → system is derived from the parent org's identifier:
        //            parent.identifier[0].system + '/' + parent.identifier[0].value
        // Root-org → (no kode submitted for root, so this block won't fire in practice)
        $identifier = [];
        if ($request->kode) {
            if ($partOfId) {
                // Fetch parent from SatuSehat to build the correct system URL
                $parentRes    = (new BridgeBase())->getJson('Organization/' . $partOfId);
                $parentIdent  = $parentRes['identifier'][0] ?? [];
                $parentSystem = $parentIdent['system'] ?? ('https://fhir.kemkes.go.id/id/org-number');
                $parentValue  = $parentIdent['value']  ?? $this->orgId;
                $identifier[] = [
                    'use'    => 'official',
                    'system' => rtrim($parentSystem, '/') . '/' . $parentValue,
                    'value'  => $request->kode,
                ];
            } else {
                // No parent: standard root-level identifier
                $identifier[] = [
                    'use'    => 'official',
                    'system' => 'https://fhir.kemkes.go.id/id/org-number',
                    'value'  => $request->kode,
                ];
            }
        }

        // ── alias ───────────────────────────────────────────────────────
        $alias = [];
        if ($request->alias) {
            $alias = [$request->alias];
        }

        // ── telecom ─────────────────────────────────────────────────────
        $telecom = [];
        if ($request->telepon) {
            $telecom[] = ['system' => 'phone', 'value' => $request->telepon, 'use' => 'work'];
        }
        if ($request->email) {
            $telecom[] = ['system' => 'email', 'value' => $request->email, 'use' => 'work'];
        }
        if ($request->website) {
            $telecom[] = ['system' => 'url',   'value' => $request->website, 'use' => 'work'];
        }

        // ── address ─────────────────────────────────────────────────────
        $adminExt = [];
        if ($request->kode_provinsi)  $adminExt[] = ['url' => 'province', 'valueCode' => $request->kode_provinsi];
        if ($request->kode_kota)      $adminExt[] = ['url' => 'city',     'valueCode' => $request->kode_kota];
        if ($request->kode_kecamatan) $adminExt[] = ['url' => 'district', 'valueCode' => $request->kode_kecamatan];
        if ($request->kode_kelurahan) $adminExt[] = ['url' => 'village',  'valueCode' => $request->kode_kelurahan];

        $address = [[
            'use'        => $request->address_use  ?? 'work',
            'type'       => $request->address_type ?? 'both',
            'line'       => [$request->alamat    ?? ''],
            'city'       => $request->kota        ?? '',
            'postalCode' => $request->kode_pos    ?? '',
            'country'    => 'ID',
        ]];
        if ($adminExt) {
            $address[0]['extension'] = [[
                'url'       => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                'extension' => $adminExt,
            ]];
        }

        // ── partOf ──────────────────────────────────────────────────────
        $partOf = ['reference' => 'Organization/' . ($partOfId ?: $this->orgId)];

        // ── contact ─────────────────────────────────────────────────────
        $contact = [];
        $purposeCode = trim($request->contact_purpose_code ?? '');
        if ($purposeCode) {
            $purposeDisplay = trim($request->contact_purpose_display ?? $purposeCode);
            $ctTelecom = [];
            if ($request->contact_telepon) {
                $ctTelecom[] = ['system' => 'phone', 'value' => $request->contact_telepon, 'use' => 'work'];
            }
            if ($request->contact_email) {
                $ctTelecom[] = ['system' => 'email', 'value' => $request->contact_email, 'use' => 'work'];
            }

            $contactItem = [
                'purpose' => [
                    'coding' => [[
                        'system'  => 'http://terminology.hl7.org/CodeSystem/contactentity-type',
                        'code'    => $purposeCode,
                        'display' => $purposeDisplay,
                    ]],
                ],
            ];
            if ($request->contact_nama) {
                $contactItem['name'] = [
                    'use'  => 'official',
                    'text' => $request->contact_nama,
                ];
            }
            if ($ctTelecom) {
                $contactItem['telecom'] = $ctTelecom;
            }
            $contact[] = $contactItem;
        }

        // ── assemble payload ─────────────────────────────────────────────
        $payload = [
            'resourceType' => 'Organization',
            'active'       => filter_var($request->active ?? 'true', FILTER_VALIDATE_BOOLEAN),
            'identifier'   => $identifier,
            'type'         => [[
                'coding' => [[
                    'system'  => 'http://terminology.hl7.org/CodeSystem/organization-type',
                    'code'    => $request->tipe_code    ?? 'dept',
                    'display' => $request->tipe_display ?? 'Hospital Department',
                ]],
            ]],
            'name'    => $request->nama ?? '',
            'telecom' => $telecom,
            'address' => $address,
            'partOf'  => $partOf,
        ];

        if ($alias)   $payload['alias']   = $alias;
        if ($contact) $payload['contact'] = $contact;

        return $payload;
    }

    // ── Sync to Local DB ──────────────────────────────────────────────────

    /**
     * Fetch all organizations from SatuSehat API and upsert into satusehat_organizations.
     */
    public function sync(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $bridge  = new BridgeBase();
        $synced  = 0;
        $failed  = 0;
        $now     = now();

        // Fetch root org first
        $rootRes = $bridge->getJson('Organization/' . $this->orgId);
        if (!empty($rootRes['id'])) {
            try {
                DB::table('satusehat_organizations')->upsert(
                    [$this->flattenForDb($rootRes, $now)],
                    ['satusehat_id'],
                    array_keys($this->flattenForDb($rootRes, $now))
                );
                $synced++;
            } catch (\Exception $e) {
                $failed++;
            }
        }

        // Fetch sub-organizations
        $page  = 1;
        $done  = false;
        $url   = 'Organization?partof=' . $this->orgId . '&_count=500';

        while (!$done) {
            $raw     = $bridge->getJson($url);
            $entries = $raw['entry'] ?? [];

            if (empty($entries)) break;

            $rows = [];
            foreach ($entries as $entry) {
                $res = $entry['resource'] ?? [];
                if (empty($res['id'])) continue;
                try {
                    $rows[] = $this->flattenForDb($res, $now);
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            if ($rows) {
                try {
                    DB::table('satusehat_organizations')->upsert(
                        $rows,
                        ['satusehat_id'],
                        array_diff(array_keys($rows[0]), ['satusehat_id', 'created_at'])
                    );
                    $synced += count($rows);
                } catch (\Exception $e) {
                    $failed += count($rows);
                }
            }

            // Follow next link
            $nextLink = collect($raw['link'] ?? [])->firstWhere('relation', 'next')['url'] ?? null;
            if ($nextLink) {
                // Extract relative path after base FHIR URL
                $url  = preg_replace('/^.*?\/fhir-r4\/v1\//', '', $nextLink);
                $page++;
            } else {
                $done = true;
            }
        }

        PenggunaHelp::log("Sync Organization ke DB lokal: {$synced} berhasil, {$failed} gagal");

        return response()->json([
            'data'   => 'berhasil',
            'synced' => $synced,
            'failed' => $failed,
        ]);
    }

    /**
     * Return sync status summary from local satusehat_organizations table.
     */
    public function syncStatus(Request $request)
    {
        if ($this->error !== 'next') {
            return response()->json(['data' => $this->error]);
        }

        $total      = DB::table('satusehat_organizations')->count();
        $lastSynced = DB::table('satusehat_organizations')->max('synced_at');

        return response()->json([
            'data' => [
                'total'       => $total,
                'last_synced' => $lastSynced,
            ],
        ]);
    }

    /**
     * Flatten a FHIR Organization resource into a DB row for satusehat_organizations.
     */
    private function flattenForDb(array $res, $now): array
    {
        // Telecom
        $telepon = null;
        $email   = null;
        $website = null;
        foreach (array_merge($res['telecom'] ?? [], $res['contact'][0]['telecom'] ?? []) as $t) {
            if ($t['system'] === 'phone' && !$telepon) $telepon = $t['value'];
            if ($t['system'] === 'email' && !$email)   $email   = $t['value'];
            if ($t['system'] === 'url'   && !$website) $website = $t['value'];
        }

        // Address & BPS codes
        $addr     = $res['address'][0] ?? [];
        $adminExt = $addr['extension'][0]['extension'] ?? [];
        $getCode  = fn($u) => collect($adminExt)->firstWhere('url', $u)['valueCode'] ?? null;

        // partOf — strip "Organization/" prefix
        $partOfRaw = $res['partOf']['reference'] ?? null;
        $partOf    = $partOfRaw ? preg_replace('/^Organization\//', '', $partOfRaw) : null;

        // identifier
        $ident          = $res['identifier'][0] ?? [];
        $identSystem    = $ident['system'] ?? null;
        $identValue     = $ident['value']  ?? null;

        return [
            'satusehat_id'      => $res['id'],
            'kode'              => $identValue,
            'identifier_system' => $identSystem,
            'identifier_value'  => $identValue,
            'nama'              => $res['name']                             ?? '',
            'alias'             => implode(', ', $res['alias'] ?? []) ?: null,
            'aktif'             => ($res['active'] ?? false) ? true : false,
            'tipe'              => $res['type'][0]['coding'][0]['code']    ?? null,
            'tipe_display'      => $res['type'][0]['coding'][0]['display'] ?? null,
            'telepon'           => $telepon,
            'email'             => $email,
            'website'           => $website,
            'alamat'            => $addr['line'][0]   ?? null,
            'kota'              => $addr['city']       ?? null,
            'kode_pos'          => $addr['postalCode'] ?? null,
            'kode_provinsi'     => $getCode('province'),
            'kode_kota'         => $getCode('city'),
            'kode_kecamatan'    => $getCode('district'),
            'kode_kelurahan'    => $getCode('village'),
            'part_of'           => $partOf,
            'raw_data'          => json_encode($res),
            'synced_at'         => $now,
            'created_at'        => $now,
            'updated_at'        => $now,
        ];
    }

    /**
     * Flatten a FHIR Organization resource into a simple array for the datatable.
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

        $addr         = $res['address'][0] ?? [];
        $adminExt     = $addr['extension'][0]['extension'] ?? [];
        $getCode      = fn($url) => collect($adminExt)->firstWhere('url', $url)['valueCode'] ?? '-';
        $purposeCode  = $res['contact'][0]['purpose']['coding'][0]['code'] ?? '';

        return [
            'satusehat_id'   => $res['id']                                ?? '-',
            'kode'           => $res['identifier'][0]['value']            ?? '-',
            'nama'           => $res['name']                              ?? '-',
            'alias'          => implode(', ', $res['alias'] ?? []) ?: '-',
            'active'         => ($res['active'] ?? false) ? 'Aktif' : 'Tidak Aktif',
            'tipe'           => $res['type'][0]['coding'][0]['display']   ?? '-',
            'tipe_code'      => $res['type'][0]['coding'][0]['code']      ?? '-',
            'telepon'        => $telepon ?: '-',
            'email'          => $email   ?: '-',
            'website'        => $website ?: '-',
            'kota'           => $addr['city']       ?? '-',
            'kode_pos'       => $addr['postalCode'] ?? '-',
            'kode_provinsi'  => $getCode('province'),
            'kode_kota'      => $getCode('city'),
            'kode_kecamatan' => $getCode('district'),
            'kode_kelurahan' => $getCode('village'),
            'part_of'        => $res['partOf']['reference'] ?? '-',
            'contact_purpose'=> $purposeCode,
            'contact_nama'   => $res['contact'][0]['name']['text'] ?? '-',
        ];
    }
}
