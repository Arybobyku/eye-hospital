<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>SatuSehat API Explorer</title>
<style>
  :root {
    --green:  #49cc90; --green-bg: #f0fff4; --green-border: #49cc90;
    --blue:   #61affe; --blue-bg:  #eff8ff; --blue-border:  #61affe;
    --orange: #fca130; --orange-bg:#fff8f0; --orange-border:#fca130;
    --red:    #f93e3e; --red-bg:   #fff0f0; --red-border:   #f93e3e;
    --gray:   #6c757d;
    --sidebar-w: 240px;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: system-ui, -apple-system, sans-serif; background: #f5f7fa; color: #1e293b; display: flex; min-height: 100vh; }

  /* ── Sidebar ── */
  #sidebar {
    width: var(--sidebar-w); min-height: 100vh; background: #1e293b; color: #94a3b8;
    position: fixed; top: 0; left: 0; overflow-y: auto; z-index: 100;
    display: flex; flex-direction: column;
  }
  #sidebar .logo { padding: 20px 16px; border-bottom: 1px solid #334155; }
  #sidebar .logo h2 { color: #f1f5f9; font-size: 15px; font-weight: 700; }
  #sidebar .logo p  { font-size: 11px; color: #64748b; margin-top: 2px; }
  #sidebar .status-bar { padding: 12px 16px; border-bottom: 1px solid #334155; font-size: 11px; }
  #sidebar .status-bar span.dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; margin-right: 5px; }
  #sidebar nav { flex: 1; padding: 12px 0; }
  #sidebar nav .section-label { padding: 8px 16px 4px; font-size: 10px; text-transform: uppercase; letter-spacing: .08em; color: #475569; font-weight: 600; }
  #sidebar nav a { display: flex; align-items: center; gap: 8px; padding: 7px 16px; font-size: 13px; color: #94a3b8; text-decoration: none; border-left: 2px solid transparent; transition: all .15s; }
  #sidebar nav a:hover, #sidebar nav a.active { color: #f1f5f9; background: #334155; border-left-color: #3b82f6; }
  #sidebar nav a .method-dot { font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 3px; }
  .dot-get  { background: #064e3b; color: var(--green); }
  .dot-post { background: #78350f; color: var(--orange); }
  .dot-put  { background: #1e3a5f; color: var(--blue); }

  /* ── Main ── */
  #main { margin-left: var(--sidebar-w); flex: 1; padding: 24px; max-width: 960px; }
  #main h1 { font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
  #main .subtitle { color: #64748b; font-size: 13px; margin-bottom: 24px; }

  /* ── Section ── */
  .section { margin-bottom: 8px; }
  .section-title { font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .06em; padding: 0 0 8px; margin-top: 24px; margin-bottom: 4px; border-bottom: 1px solid #e2e8f0; }

  /* ── Endpoint Card ── */
  .endpoint {
    border-radius: 6px; margin-bottom: 6px; overflow: hidden;
    border: 1px solid #e2e8f0; background: white;
  }
  .endpoint.open { border-color: #cbd5e1; }
  .endpoint-header {
    display: flex; align-items: center; gap: 12px; padding: 11px 14px; cursor: pointer;
    user-select: none; transition: background .1s;
  }
  .endpoint-header:hover { background: #f8fafc; }
  .endpoint.get-ep    .endpoint-header { border-left: 4px solid var(--green); }
  .endpoint.post-ep   .endpoint-header { border-left: 4px solid var(--orange); }
  .endpoint.put-ep    .endpoint-header { border-left: 4px solid var(--blue); }
  .endpoint.delete-ep .endpoint-header { border-left: 4px solid var(--red); }
  .method-badge {
    font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; min-width: 48px; text-align: center;
  }
  .badge-GET    { background: var(--green-bg);  color: #166534; border: 1px solid #bbf7d0; }
  .badge-POST   { background: var(--orange-bg); color: #92400e; border: 1px solid #fde68a; }
  .badge-PUT    { background: var(--blue-bg);   color: #1e40af; border: 1px solid #bfdbfe; }
  .badge-DELETE { background: var(--red-bg);    color: #991b1b; border: 1px solid #fecaca; }
  .ep-path { font-family: monospace; font-size: 14px; font-weight: 600; color: #1e293b; flex: 1; }
  .ep-summary { font-size: 12px; color: #64748b; }
  .ep-toggle { color: #94a3b8; font-size: 16px; transition: transform .2s; }
  .endpoint.open .ep-toggle { transform: rotate(180deg); }

  .endpoint-body { display: none; padding: 16px 18px; border-top: 1px solid #f1f5f9; background: #fafbfc; }
  .endpoint.open .endpoint-body { display: block; }

  /* ── Form inside endpoint ── */
  .param-label { font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; }
  .param-desc  { font-size: 11px; color: #6b7280; margin-bottom: 6px; }
  .param-row   { margin-bottom: 12px; }
  input[type=text], textarea, select {
    width: 100%; padding: 7px 10px; border: 1px solid #d1d5db; border-radius: 5px;
    font-size: 13px; font-family: inherit; background: white; color: #1e293b;
    transition: border-color .15s;
  }
  input[type=text]:focus, textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 2px #dbeafe; }
  textarea { font-family: 'Menlo', 'Consolas', monospace; font-size: 12px; resize: vertical; min-height: 200px; background: #0f172a; color: #e2e8f0; border-color: #334155; }
  textarea:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px #1d4ed8aa; }

  .body-label { font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: flex; justify-content: space-between; align-items: center; }
  .body-label button { font-size: 11px; background: none; border: 1px solid #d1d5db; padding: 2px 8px; border-radius: 4px; cursor: pointer; color: #374151; }
  .body-label button:hover { background: #f3f4f6; }

  .btn-execute {
    background: #3b82f6; color: white; border: none; padding: 8px 20px; border-radius: 5px;
    font-size: 13px; font-weight: 600; cursor: pointer; transition: background .15s; margin-top: 12px;
  }
  .btn-execute:hover { background: #2563eb; }
  .btn-execute:active { background: #1d4ed8; }
  .btn-execute:disabled { background: #93c5fd; cursor: not-allowed; }

  /* ── Response ── */
  .response-box { margin-top: 14px; border-radius: 6px; overflow: hidden; display: none; }
  .response-box.visible { display: block; }
  .response-header {
    padding: 8px 12px; display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 600;
  }
  .response-header.ok    { background: #dcfce7; color: #166534; }
  .response-header.error { background: #fee2e2; color: #991b1b; }
  .response-header.loading { background: #f1f5f9; color: #475569; }
  .response-code { font-size: 18px; font-weight: 700; }
  .response-time { color: #6b7280; font-weight: 400; }
  .response-pre {
    padding: 12px; background: #0f172a; color: #e2e8f0; font-family: monospace; font-size: 12px;
    max-height: 400px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;
  }

  /* ── Status card ── */
  .status-cards { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
  .status-card { background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; flex: 1; min-width: 160px; }
  .status-card label { font-size: 10px; text-transform: uppercase; letter-spacing: .06em; color: #94a3b8; display: block; margin-bottom: 4px; }
  .status-card span  { font-size: 14px; font-weight: 600; color: #1e293b; }
</style>
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
  <div class="logo">
    <h2>🏥 SatuSehat</h2>
    <p>API Explorer — Dev Only</p>
  </div>
  <div class="status-bar" id="sidebar-status">
    <span class="dot" id="cache-dot" style="background:#475569"></span>
    <span id="cache-label">Memeriksa token...</span>
  </div>
  <nav>
    <div class="section-label">Auth</div>
    <a href="#token"><span class="method-dot dot-get">GET</span> Token Info</a>
    <a href="#token-refresh"><span class="method-dot dot-get">GET</span> Refresh Token</a>

    <div class="section-label">Master Data</div>
    <a href="#organization"><span class="method-dot dot-get">GET</span> Organization</a>
    <a href="#location"><span class="method-dot dot-get">GET</span> Location</a>

    <div class="section-label">Patient</div>
    <a href="#patient-nik"><span class="method-dot dot-get">GET</span> By NIK</a>
    <a href="#patient-id"><span class="method-dot dot-get">GET</span> By IHS ID</a>
    <a href="#patient-name"><span class="method-dot dot-get">GET</span> By Nama</a>

    <div class="section-label">Practitioner</div>
    <a href="#practitioner-nik"><span class="method-dot dot-get">GET</span> By NIK</a>
    <a href="#practitioner-id"><span class="method-dot dot-get">GET</span> By IHS ID</a>
    <a href="#practitioner-name"><span class="method-dot dot-get">GET</span> By Nama</a>

    <div class="section-label">Setup Organisasi</div>
    <a href="#organization-create"><span class="method-dot dot-post">POST</span> Create Org</a>
    <a href="#location-create"><span class="method-dot dot-post">POST</span> Create Location</a>

    <div class="section-label">Riwayat Keluarga & Alergi</div>
    <a href="#family-history-create"><span class="method-dot dot-post">POST</span> Family History</a>
    <a href="#allergy-create"><span class="method-dot dot-post">POST</span> Allergy</a>

    <div class="section-label">Riwayat Pengobatan</div>
    <a href="#med-statement-create"><span class="method-dot dot-post">POST</span> Medication Statement</a>
    <a href="#med-dispense-get"><span class="method-dot dot-get">GET</span> Dispense</a>
    <a href="#med-dispense-create"><span class="method-dot dot-post">POST</span> Dispense Create</a>
    <a href="#med-admin-create"><span class="method-dot dot-post">POST</span> Administration</a>

    <div class="section-label">Clinical Impression</div>
    <a href="#clinical-imp-create"><span class="method-dot dot-post">POST</span> Create</a>
    <a href="#clinical-imp-patch"><span class="method-dot dot-put">PATCH</span> Update</a>

    <div class="section-label">Goal & CarePlan</div>
    <a href="#goal-create"><span class="method-dot dot-post">POST</span> Goal</a>
    <a href="#goal-update"><span class="method-dot dot-put">PUT</span> Goal Update</a>
    <a href="#careplan-create"><span class="method-dot dot-post">POST</span> CarePlan</a>

    <div class="section-label">Pemeriksaan Penunjang</div>
    <a href="#service-req-create"><span class="method-dot dot-post">POST</span> ServiceRequest</a>
    <a href="#specimen-create"><span class="method-dot dot-post">POST</span> Specimen</a>
    <a href="#diagnostic-create"><span class="method-dot dot-post">POST</span> DiagnosticReport</a>
    <a href="#imaging-get"><span class="method-dot dot-get">GET</span> ImagingStudy</a>

    <div class="section-label">Risk & Questionnaire</div>
    <a href="#risk-create"><span class="method-dot dot-post">POST</span> RiskAssessment</a>
    <a href="#questionnaire-create"><span class="method-dot dot-post">POST</span> Questionnaire</a>

    <div class="section-label">Obat & Nutrisi</div>
    <a href="#medication-create"><span class="method-dot dot-post">POST</span> Medication</a>
    <a href="#nutrition-create"><span class="method-dot dot-post">POST</span> NutritionOrder</a>

    <div class="section-label">Dokumen & Bundle</div>
    <a href="#composition-create"><span class="method-dot dot-post">POST</span> Composition</a>
    <a href="#bundle-create"><span class="method-dot dot-post">POST</span> Bundle</a>

    <div class="section-label">Encounter</div>
    <a href="#encounter-create"><span class="method-dot dot-post">POST</span> Create</a>
    <a href="#encounter-update"><span class="method-dot dot-put">PUT</span> Update</a>
    <a href="#encounter-get"><span class="method-dot dot-get">GET</span> By ID</a>

    <div class="section-label">Condition</div>
    <a href="#condition-create"><span class="method-dot dot-post">POST</span> Create</a>

    <div class="section-label">Observation</div>
    <a href="#observation-create"><span class="method-dot dot-post">POST</span> Create</a>

    <div class="section-label">Procedure</div>
    <a href="#procedure-create"><span class="method-dot dot-post">POST</span> Create</a>

    <div class="section-label">MedicationRequest</div>
    <a href="#medreq-create"><span class="method-dot dot-post">POST</span> Create</a>

    <div class="section-label">KFA</div>
    <a href="#kfa-search"><span class="method-dot dot-get">GET</span> Search v1</a>
    <a href="#kfa-v2-search"><span class="method-dot dot-get">GET</span> Search v2</a>
    <a href="#kfa-detail"><span class="method-dot dot-get">GET</span> Detail</a>

    <div class="section-label">Consent</div>
    <a href="#consent-get"><span class="method-dot dot-get">GET</span> Cek Consent</a>
  </nav>
</nav>

<!-- Main -->
<div id="main">
  <h1>SatuSehat API Explorer</h1>
  <p class="subtitle">Environment: <strong>{{ strtoupper(env('APP_ENV', 'development')) }}</strong> &nbsp;|&nbsp; Base URL: <code>{{ env('API_SATUSEHAT_BASE', '-') }}</code></p>

  <div class="status-cards">
    <div class="status-card">
      <label>Organization ID</label>
      <span>{{ $orgId ?: '— belum diset' }}</span>
    </div>
    <div class="status-card">
      <label>Token Cache</label>
      <span id="token-cache-status">Memeriksa...</span>
    </div>
    <div class="status-card">
      <label>Auth URL</label>
      <span style="font-size:11px;word-break:break-all">{{ env('API_SATUSEHAT_AUTH', '-') }}</span>
    </div>
  </div>

  <!-- ── TOKEN ── -->
  <div class="section-title">🔐 Auth / Token</div>

  <div class="endpoint get-ep" id="token">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/token</span>
      <span class="ep-summary">Info token aktif (nilai disamarkan)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:13px;color:#475569;margin-bottom:14px">Tampilkan status token cache SatuSehat. Token akan diminta ke API jika cache kosong/expired.</p>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/token')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="token-refresh">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/token/refresh</span>
      <span class="ep-summary">Paksa refresh token dari SatuSehat API</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <p style="font-size:13px;color:#475569;margin-bottom:14px">Hapus cache token lama dan minta token baru. Gunakan jika token bermasalah.</p>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/token/refresh')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── ORGANIZATION ── -->
  <div class="section-title">🏥 Organization & Location</div>

  <div class="endpoint get-ep" id="organization">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/organization/{orgId}</span>
      <span class="ep-summary">Ambil data Organization faskes</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">orgId <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Organization ID SatuSehat faskes. Kosongkan untuk pakai nilai dari .env</span>
        <input type="text" id="p-org-id" placeholder="{{ $orgId ?: 'contoh: 10000005' }}" value="{{ $orgId }}">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/organization/' + (document.getElementById('p-org-id').value || ''))">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="location">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/location/{orgId}</span>
      <span class="ep-summary">Daftar Location (poli/ruangan) milik faskes</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">orgId <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Organization ID faskes. Kosongkan untuk pakai nilai dari .env</span>
        <input type="text" id="p-loc-org-id" placeholder="{{ $orgId ?: 'contoh: 10000005' }}" value="{{ $orgId }}">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/location/' + (document.getElementById('p-loc-org-id').value || ''))">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── PATIENT ── -->
  <div class="section-title">👤 Patient</div>

  <div class="endpoint get-ep" id="patient-nik">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/patient/{nik}</span>
      <span class="ep-summary">Cari Patient berdasarkan NIK KTP</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">nik <span style="color:#ef4444">*</span></label>
        <span class="param-desc">NIK KTP pasien (16 digit)</span>
        <input type="text" id="p-patient-nik" placeholder="contoh: 3174051612870001">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/patient/' + document.getElementById('p-patient-nik').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="patient-id">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/patient-by-id/{id}</span>
      <span class="ep-summary">Ambil Patient berdasarkan IHS Number</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Patient IHS Number dari SatuSehat (didapat dari pencarian by NIK)</span>
        <input type="text" id="p-patient-ihs" placeholder="contoh: 100000030006">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/patient-by-id/' + document.getElementById('p-patient-ihs').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="patient-name">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/patient-by-name</span>
      <span class="ep-summary">Cari Patient berdasarkan nama, tanggal lahir, dan gender</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">name</label>
        <span class="param-desc">Nama pasien (sebagian sudah cukup)</span>
        <input type="text" id="p-pname" placeholder="contoh: Budi">
      </div>
      <div class="param-row">
        <label class="param-label">birthdate</label>
        <span class="param-desc">Tanggal lahir format YYYY-MM-DD</span>
        <input type="text" id="p-pbd" placeholder="contoh: 1990-01-15">
      </div>
      <div class="param-row">
        <label class="param-label">gender</label>
        <span class="param-desc">Jenis kelamin: male / female</span>
        <input type="text" id="p-pgender" placeholder="male">
      </div>
      <button class="btn-execute" onclick="
        var q = [];
        if (document.getElementById('p-pname').value)   q.push('name='   + encodeURIComponent(document.getElementById('p-pname').value));
        if (document.getElementById('p-pbd').value)     q.push('birthdate=' + encodeURIComponent(document.getElementById('p-pbd').value));
        if (document.getElementById('p-pgender').value) q.push('gender=' + encodeURIComponent(document.getElementById('p-pgender').value));
        execGet(this, '/satusehat/patient-by-name?' + q.join('&'));
      ">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── PRACTITIONER ── -->
  <div class="section-title">👨‍⚕️ Practitioner (Dokter / Nakes)</div>

  <div class="endpoint get-ep" id="practitioner-nik">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/practitioner/{nik}</span>
      <span class="ep-summary">Cari Practitioner berdasarkan NIK KTP</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">nik <span style="color:#ef4444">*</span></label>
        <span class="param-desc">NIK KTP tenaga medis (16 digit)</span>
        <input type="text" id="p-pract-nik" placeholder="contoh: 3174051612870001">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/practitioner/' + document.getElementById('p-pract-nik').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="practitioner-id">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/practitioner-by-id/{id}</span>
      <span class="ep-summary">Ambil Practitioner berdasarkan IHS Number</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Practitioner IHS Number dari SatuSehat</span>
        <input type="text" id="p-pract-ihs" placeholder="contoh: N10000001">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/practitioner-by-id/' + document.getElementById('p-pract-ihs').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="practitioner-name">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/practitioner-by-name</span>
      <span class="ep-summary">Cari Practitioner berdasarkan nama, tanggal lahir, dan gender</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">name</label>
        <span class="param-desc">Nama practitioner (sebagian sudah cukup)</span>
        <input type="text" id="p-prname" placeholder="contoh: Budi">
      </div>
      <div class="param-row">
        <label class="param-label">birthdate</label>
        <span class="param-desc">Tanggal lahir format YYYY-MM-DD</span>
        <input type="text" id="p-prbd" placeholder="contoh: 1990-01-15">
      </div>
      <div class="param-row">
        <label class="param-label">gender</label>
        <span class="param-desc">Jenis kelamin: male / female</span>
        <input type="text" id="p-prgender" placeholder="male">
      </div>
      <button class="btn-execute" onclick="
        var q = [];
        if (document.getElementById('p-prname').value)   q.push('name='   + encodeURIComponent(document.getElementById('p-prname').value));
        if (document.getElementById('p-prbd').value)     q.push('birthdate=' + encodeURIComponent(document.getElementById('p-prbd').value));
        if (document.getElementById('p-prgender').value) q.push('gender=' + encodeURIComponent(document.getElementById('p-prgender').value));
        execGet(this, '/satusehat/practitioner-by-name?' + q.join('&'));
      ">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── SETUP ORGANISASI ── -->
  <div class="section-title">🏗️ Setup Organisasi</div>

  <div class="endpoint post-ep" id="organization-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/organization</span>
      <span class="ep-summary">Buat Organization (Fasilitas Kesehatan)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('organization-body', organizationBody)">Reset ke default</button>
      </div>
      <textarea id="organization-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/organization', 'organization-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="location-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/location</span>
      <span class="ep-summary">Buat Location (Ruangan / Poli)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('location-body', locationBody)">Reset ke default</button>
      </div>
      <textarea id="location-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/location', 'location-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── RIWAYAT KELUARGA & ALERGI ── -->
  <div class="section-title">👨‍👩‍👧 Riwayat Keluarga</div>

  <div class="endpoint post-ep" id="family-history-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/family-member-history</span>
      <span class="ep-summary">Buat FamilyMemberHistory (Riwayat Penyakit Keluarga)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('family-history-body', familyHistoryBody)">Reset ke default</button>
      </div>
      <textarea id="family-history-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/family-member-history', 'family-history-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="section-title">🤧 Alergi</div>

  <div class="endpoint post-ep" id="allergy-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/allergy-intolerance</span>
      <span class="ep-summary">Buat AllergyIntolerance (Alergi / Intoleransi)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('allergy-body', allergyBody)">Reset ke default</button>
      </div>
      <textarea id="allergy-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/allergy-intolerance', 'allergy-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── RIWAYAT PENGOBATAN ── -->
  <div class="section-title">💊 Riwayat Pengobatan</div>

  <div class="endpoint post-ep" id="med-statement-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/medication-statement</span>
      <span class="ep-summary">Buat MedicationStatement (Riwayat Pengobatan)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('med-statement-body', medStatementBody)">Reset ke default</button>
      </div>
      <textarea id="med-statement-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/medication-statement', 'med-statement-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="section-title">💉 MedicationDispense & Administration</div>

  <div class="endpoint get-ep" id="med-dispense-get">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/medication-dispense</span>
      <span class="ep-summary">Ambil MedicationDispense berdasarkan Patient ID</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">patient_id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Patient IHS Number</span>
        <input type="text" id="p-med-dispense-pid" placeholder="contoh: 100000030006">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/medication-dispense?patient_id=' + document.getElementById('p-med-dispense-pid').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="med-dispense-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/medication-dispense</span>
      <span class="ep-summary">Buat MedicationDispense (Pengeluaran Obat)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('med-dispense-body', medDispenseBody)">Reset ke default</button>
      </div>
      <textarea id="med-dispense-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/medication-dispense', 'med-dispense-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="med-admin-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/medication-administration</span>
      <span class="ep-summary">Buat MedicationAdministration (Pemberian Obat)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('med-admin-body', medAdminBody)">Reset ke default</button>
      </div>
      <textarea id="med-admin-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/medication-administration', 'med-admin-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── CLINICAL IMPRESSION ── -->
  <div class="section-title">🧠 Clinical Impression</div>

  <div class="endpoint post-ep" id="clinical-imp-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/clinical-impression</span>
      <span class="ep-summary">Buat ClinicalImpression (Riwayat Perjalanan Penyakit)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('clinical-imp-body', clinicalImpBody)">Reset ke default</button>
      </div>
      <textarea id="clinical-imp-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/clinical-impression', 'clinical-imp-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint put-ep" id="clinical-imp-patch">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-PUT">PATCH</span>
      <span class="ep-path">/satusehat/clinical-impression/{id}</span>
      <span class="ep-summary">Update ClinicalImpression (PATCH)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">ClinicalImpression ID</span>
        <input type="text" id="p-clinical-imp-id" placeholder="contoh: c65b7d8b-b691-4d71-9dbf-561e15c2e8b5">
      </div>
      <div class="body-label">
        Request Body (JSON Array - JSON Patch)
        <button onclick="resetBody('clinical-imp-patch-body', clinicalImpPatchBody)">Reset ke default</button>
      </div>
      <textarea id="clinical-imp-patch-body" rows="16"></textarea>
      <button class="btn-execute" onclick="
        var raw = document.getElementById('clinical-imp-patch-body').value;
        var body;
        try { body = JSON.parse(raw); } catch(e) { alert('JSON tidak valid: ' + e.message); return; }
        var btn = this;
        btn.disabled = true; btn.textContent = 'Loading...';
        var box = btn.nextElementSibling;
        var t = Date.now();
        fetch('/satusehat/clinical-impression/' + document.getElementById('p-clinical-imp-id').value, {
          method: 'PATCH',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content, 'Accept': 'application/json' },
          body: JSON.stringify(body)
        })
        .then(r => { var ok = r.status >= 200 && r.status < 300; return r.json().then(d => ({status: r.status, data: d, ok})); })
        .then(({status, data, ok}) => {
          btn.disabled = false; btn.textContent = 'Execute';
          box.className = 'response-box visible';
          var pretty = typeof data === 'string' ? data : JSON.stringify(data, null, 2);
          box.innerHTML = '<div class=\"response-header ' + (ok ? 'ok' : 'error') + '\"><span class=\"response-code\">' + status + '</span><span class=\"response-time\">' + (Date.now() - t) + 'ms</span></div><pre class=\"response-pre\">' + (String(pretty).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')) + '</pre>';
        })
        .catch(e => {
          btn.disabled = false; btn.textContent = 'Execute';
          box.className = 'response-box visible';
          box.innerHTML = '<div class=\"response-header error\"><span class=\"response-code\">0</span></div><pre class=\"response-pre\">Error: ' + e.message + '</pre>';
        });
      ">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── GOAL & CAREPLAN ── -->
  <div class="section-title">🎯 Goal & CarePlan</div>

  <div class="endpoint post-ep" id="goal-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/goal</span>
      <span class="ep-summary">Buat Goal (Tujuan Perawatan)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('goal-body', goalBody)">Reset ke default</button>
      </div>
      <textarea id="goal-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/goal', 'goal-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint put-ep" id="goal-update">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-PUT">PUT</span>
      <span class="ep-path">/satusehat/goal/{id}</span>
      <span class="ep-summary">Update Goal (Progress Tujuan Perawatan)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Goal ID</span>
        <input type="text" id="p-goal-id" placeholder="contoh: c65b7d8b-b691-4d71-9dbf-561e15c2e8b5">
      </div>
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('goal-update-body', goalUpdateBody)">Reset ke default</button>
      </div>
      <textarea id="goal-update-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPut(this, '/satusehat/goal/' + document.getElementById('p-goal-id').value, 'goal-update-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="careplan-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/care-plan</span>
      <span class="ep-summary">Buat CarePlan (Rencana Rawat Pasien)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('careplan-body', carePlanBody)">Reset ke default</button>
      </div>
      <textarea id="careplan-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/care-plan', 'careplan-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── PEMERIKSAAN PENUNJANG ── -->
  <div class="section-title">🔬 Pemeriksaan Penunjang</div>

  <div class="endpoint post-ep" id="service-req-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/service-request</span>
      <span class="ep-summary">Buat ServiceRequest (Permintaan Layanan Lab/Radiologi)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('service-req-body', serviceReqBody)">Reset ke default</button>
      </div>
      <textarea id="service-req-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/service-request', 'service-req-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="specimen-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/specimen</span>
      <span class="ep-summary">Buat Specimen (Spesimen / Sampel)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('specimen-body', specimenBody)">Reset ke default</button>
      </div>
      <textarea id="specimen-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/specimen', 'specimen-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="diagnostic-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/diagnostic-report</span>
      <span class="ep-summary">Buat DiagnosticReport (Laporan Diagnostik)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('diagnostic-body', diagnosticBody)">Reset ke default</button>
      </div>
      <textarea id="diagnostic-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/diagnostic-report', 'diagnostic-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="imaging-get">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/imaging-study</span>
      <span class="ep-summary">Ambil ImagingStudy berdasarkan Accession Number</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">org_id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Organization ID</span>
        <input type="text" id="p-img-org-id" placeholder="contoh: 10000005">
      </div>
      <div class="param-row">
        <label class="param-label">acsn <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Accession Number</span>
        <input type="text" id="p-img-acsn" placeholder="contoh: 2023001">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/imaging-study?org_id=' + document.getElementById('p-img-org-id').value + '&acsn=' + document.getElementById('p-img-acsn').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── RISK ASSESSMENT & QUESTIONNAIRE ── -->
  <div class="section-title">⚠️ Risk Assessment</div>

  <div class="endpoint post-ep" id="risk-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/risk-assessment</span>
      <span class="ep-summary">Buat RiskAssessment (Penilaian Risiko)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('risk-body', riskBody)">Reset ke default</button>
      </div>
      <textarea id="risk-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/risk-assessment', 'risk-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="section-title">📋 Questionnaire & Medication</div>

  <div class="endpoint post-ep" id="questionnaire-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/questionnaire-response</span>
      <span class="ep-summary">Buat QuestionnaireResponse (Pengkajian Resep)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('questionnaire-body', questionnaireBody)">Reset ke default</button>
      </div>
      <textarea id="questionnaire-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/questionnaire-response', 'questionnaire-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="medication-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/medication</span>
      <span class="ep-summary">Buat Medication (Data Obat)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('medication-body', medicationBody)">Reset ke default</button>
      </div>
      <textarea id="medication-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/medication', 'medication-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── NUTRITION & COMPOSITION ── -->
  <div class="section-title">🥗 Nutrition & Edukasi</div>

  <div class="endpoint post-ep" id="nutrition-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/nutrition-order</span>
      <span class="ep-summary">Buat NutritionOrder (Order Nutrisi)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('nutrition-body', nutritionBody)">Reset ke default</button>
      </div>
      <textarea id="nutrition-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/nutrition-order', 'nutrition-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="section-title">📄 Composition & Bundle</div>

  <div class="endpoint post-ep" id="composition-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/composition</span>
      <span class="ep-summary">Buat Composition (Dokumen Klinis)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('composition-body', compositionBody)">Reset ke default</button>
      </div>
      <textarea id="composition-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/composition', 'composition-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint post-ep" id="bundle-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/bundle</span>
      <span class="ep-summary">Kirim Bundle (Kumpulan Resource)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('bundle-body', bundleBody)">Reset ke default</button>
      </div>
      <textarea id="bundle-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/bundle', 'bundle-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── ENCOUNTER ── -->
  <div class="section-title">🏨 Encounter (Kunjungan)</div>

  <div class="endpoint post-ep" id="encounter-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/encounter</span>
      <span class="ep-summary">Buat Encounter baru (kunjungan pasien)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('encounter-create-body', encounterCreateBody)">Reset ke default</button>
      </div>
      <textarea id="encounter-create-body" rows="20"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/encounter', 'encounter-create-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint put-ep" id="encounter-update">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-PUT">PUT</span>
      <span class="ep-path">/satusehat/encounter/{id}</span>
      <span class="ep-summary">Update status Encounter (masuk ruang, selesai, dll)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">Encounter ID <span style="color:#ef4444">*</span></label>
        <span class="param-desc">ID Encounter yang akan diupdate (UUID dari SatuSehat)</span>
        <input type="text" id="p-enc-update-id" placeholder="contoh: c65b7d8b-b691-4d71-9dbf-561e15c2e8b5">
      </div>
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('encounter-update-body', encounterUpdateBody)">Reset ke default</button>
      </div>
      <textarea id="encounter-update-body" rows="20"></textarea>
      <button class="btn-execute" onclick="execPut(this, '/satusehat/encounter/' + document.getElementById('p-enc-update-id').value, 'encounter-update-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="encounter-get">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/encounter/{id}</span>
      <span class="ep-summary">Ambil Encounter berdasarkan ID</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">id <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Encounter ID dari SatuSehat (UUID)</span>
        <input type="text" id="p-enc-get-id" placeholder="contoh: c65b7d8b-b691-4d71-9dbf-561e15c2e8b5">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/encounter/' + document.getElementById('p-enc-get-id').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── CONDITION ── -->
  <div class="section-title">🩺 Condition (Diagnosa / Keluhan)</div>

  <div class="endpoint post-ep" id="condition-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/condition</span>
      <span class="ep-summary">Kirim data Condition (keluhan utama / diagnosa)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('condition-body', conditionBody)">Reset ke default</button>
      </div>
      <textarea id="condition-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/condition', 'condition-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── OBSERVATION ── -->
  <div class="section-title">📊 Observation (Tanda Vital)</div>

  <div class="endpoint post-ep" id="observation-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/observation</span>
      <span class="ep-summary">Kirim data Observation (tanda vital, hasil lab)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('observation-body', observationBody)">Reset ke default</button>
      </div>
      <textarea id="observation-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/observation', 'observation-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── PROCEDURE ── -->
  <div class="section-title">🔬 Procedure (Tindakan Medis)</div>

  <div class="endpoint post-ep" id="procedure-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/procedure</span>
      <span class="ep-summary">Kirim data Procedure (tindakan medis)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('procedure-body', procedureBody)">Reset ke default</button>
      </div>
      <textarea id="procedure-body" rows="18"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/procedure', 'procedure-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── MEDICATION REQUEST ── -->
  <div class="section-title">💊 MedicationRequest (Resep Obat)</div>

  <div class="endpoint post-ep" id="medreq-create">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-POST">POST</span>
      <span class="ep-path">/satusehat/medication-request</span>
      <span class="ep-summary">Kirim data MedicationRequest (resep obat)</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="body-label">
        Request Body (JSON)
        <button onclick="resetBody('medreq-body', medreqBody)">Reset ke default</button>
      </div>
      <textarea id="medreq-body" rows="20"></textarea>
      <button class="btn-execute" onclick="execPost(this, '/satusehat/medication-request', 'medreq-body')">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── KFA ── -->
  <div class="section-title">🔍 KFA (Katalog Farmasi)</div>

  <div class="endpoint get-ep" id="kfa-search">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/kfa/search/{keyword}</span>
      <span class="ep-summary">Cari produk di Katalog Farmasi v1</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">keyword <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Nama obat atau keyword pencarian</span>
        <input type="text" id="p-kfa-kw" placeholder="contoh: paracetamol">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/kfa/search/' + document.getElementById('p-kfa-kw').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="kfa-v2-search">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/kfa-v2/search/{keyword}</span>
      <span class="ep-summary">Cari produk di Katalog Farmasi v2</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">keyword <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Nama obat atau keyword pencarian (KFA v2)</span>
        <input type="text" id="p-kfav2-kw" placeholder="contoh: paracetamol">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/kfa-v2/search/' + document.getElementById('p-kfav2-kw').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <div class="endpoint get-ep" id="kfa-detail">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/kfa/detail/{code}</span>
      <span class="ep-summary">Detail produk KFA berdasarkan kode</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">code <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Kode produk KFA</span>
        <input type="text" id="p-kfa-code" placeholder="contoh: 93000051">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/kfa/detail/' + document.getElementById('p-kfa-code').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

  <!-- ── CONSENT ── -->
  <div class="section-title">✅ Consent</div>

  <div class="endpoint get-ep" id="consent-get">
    <div class="endpoint-header" onclick="toggleEndpoint(this)">
      <span class="method-badge badge-GET">GET</span>
      <span class="ep-path">/satusehat/consent/{patientId}</span>
      <span class="ep-summary">Cek status consent pasien</span>
      <span class="ep-toggle">▼</span>
    </div>
    <div class="endpoint-body">
      <div class="param-row">
        <label class="param-label">patientId <span style="color:#ef4444">*</span></label>
        <span class="param-desc">Patient IHS Number dari SatuSehat</span>
        <input type="text" id="p-consent-pid" placeholder="contoh: 100000030006">
      </div>
      <button class="btn-execute" onclick="execGet(this, '/satusehat/consent/' + document.getElementById('p-consent-pid').value)">Execute</button>
      <div class="response-box"></div>
    </div>
  </div>

</div><!-- /main -->

<script>
// ── Sample Payloads (dari Postman Collection Kemkes) ──────────────────────

@verbatim

const NOW = new Date().toISOString().replace('Z', '+00:00');
const TODAY_DATE = new Date().toISOString().slice(0,10);

// ── Missing / New Payloads ────────────────────────────────────────────────

const organizationBody = {
  "resourceType": "Organization",
  "active": true,
  "identifier": [
    {
      "use": "official",
      "system": "http://sys-ids.kemkes.go.id/organization/{{Org_id}}",
      "value": "{{Location_Physical_Type}}"
    }
  ],
  "type": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/organization-type",
          "code": "dept",
          "display": "Hospital Department"
        }
      ]
    }
  ],
  "name": "Klinik Umum",
  "telecom": [
    {
      "system": "phone",
      "value": "(021) 123456",
      "use": "work"
    }
  ],
  "address": [
    {
      "use": "work",
      "line": ["Jalan Sehat No. 1"],
      "city": "Jakarta",
      "postalCode": "10110",
      "country": "ID",
      "extension": [
        {
          "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
          "extension": [
            {"url": "province",    "valueCode": "31"},
            {"url": "city",        "valueCode": "3171"},
            {"url": "district",    "valueCode": "317101"},
            {"url": "village",     "valueCode": "3171010001"},
            {"url": "rt",          "valueCode": "002"},
            {"url": "rw",          "valueCode": "008"}
          ]
        }
      ]
    }
  ],
  "partOf": {
    "reference": "Organization/{{Org_id}}"
  }
};

const locationBody = {
  "resourceType": "Location",
  "status": "active",
  "name": "Ruang Poli Umum",
  "description": "Ruang Poli Umum Lantai 1",
  "mode": "instance",
  "telecom": [
    {
      "system": "phone",
      "value": "(021) 123456",
      "use": "work"
    }
  ],
  "address": {
    "use": "work",
    "line": ["Jalan Sehat No. 1"],
    "city": "Jakarta",
    "postalCode": "10110",
    "country": "ID"
  },
  "physicalType": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/location-physical-type",
        "code": "ro",
        "display": "Room"
      }
    ]
  },
  "position": {
    "longitude": 106.8451,
    "latitude": -6.2146,
    "altitude": 0
  },
  "managingOrganization": {
    "reference": "Organization/{{Org_id}}"
  }
};

const encounterCreateBody = {
  "resourceType": "Encounter",
  "status": "arrived",
  "class": {
    "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
    "code": "AMB",
    "display": "ambulatory"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "participant": [
    {
      "type": [
        {
          "coding": [
            {
              "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
              "code": "ATND",
              "display": "attender"
            }
          ]
        }
      ],
      "individual": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ],
  "period": {
    "start": "2023-06-04T07:00:00+07:00"
  },
  "location": [
    {
      "location": {
        "reference": "Location/{{Location_id}}",
        "display": "{{Location_Name}}"
      }
    }
  ],
  "statusHistory": [
    {
      "status": "arrived",
      "period": {
        "start": "2023-06-04T07:00:00+07:00"
      }
    }
  ],
  "serviceProvider": {
    "reference": "Organization/{{Org_id}}"
  }
};

const bundleBody = {
  "resourceType": "Bundle",
  "type": "transaction",
  "entry": [
    {
      "fullUrl": "urn:uuid:{{UUID_Encounter}}",
      "resource": {
        "resourceType": "Encounter",
        "status": "arrived",
        "class": {
          "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
          "code": "AMB",
          "display": "ambulatory"
        },
        "subject": {
          "reference": "Patient/{{Patient_id}}"
        },
        "serviceProvider": {
          "reference": "Organization/{{Org_id}}"
        }
      },
      "request": {
        "method": "POST",
        "url": "Encounter"
      }
    }
  ]
};

const observationBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "8480-6",
        "display": "Systolic blood pressure"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T07:00:00+07:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}"
    }
  ],
  "valueQuantity": {
    "value": 120,
    "unit": "mm[Hg]",
    "system": "http://unitsofmeasure.org",
    "code": "mm[Hg]"
  }
};

const familyHistoryBody = {
  "resourceType": "FamilyMemberHistory",
  "status": "completed",
  "relationship": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/v3-RoleCode",
        "code": "FAMMEMB",
        "display": "family member"
      }
    ]
  },
  "deceasedBoolean": false,
  "patient": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "date": "2023-06-04T05:40:00+00:00",
  "condition": [
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "719763000",
            "display": "Maternal history of diabetes mellitus type 2"
          }
        ]
      },
      "outcome": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "315051004",
            "display": "Diabetes resolved"
          }
        ]
      },
      "contributedToDeath": false,
      "onsetString": "Ibu pasien pernah menderita DM 10 tahun yll namun sudah dinyatakan sembuh"
    }
  ]
};

const allergyEnvBody = {
  "resourceType": "AllergyIntolerance",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/allergy/{{Org_id}}",
      "use": "official",
      "value": "202401123456"
    }
  ],
  "clinicalStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical",
        "code": "active",
        "display": "Active"
      }
    ]
  },
  "verificationStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-verification",
        "code": "confirmed",
        "display": "Confirmed"
      }
    ]
  },
  "category": [
    "environment"
  ],
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "128488006",
        "display": "House dust"
      }
    ],
    "text": "Debu Rumah"
  },
  "patient": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "recordedDate": "2023-06-04T05:40:00+00:00",
  "recorder": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  }
};

const allergyFoodBody = {
  "resourceType": "AllergyIntolerance",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/allergy/{{Org_id}}",
      "use": "official",
      "value": "2024011234"
    }
  ],
  "clinicalStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical",
        "code": "active",
        "display": "Active"
      }
    ]
  },
  "verificationStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-verification",
        "code": "confirmed",
        "display": "Confirmed"
      }
    ]
  },
  "category": [
    "food"
  ],
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "226963000",
        "display": "Duck - meat"
      }
    ],
    "text": "Alergi daging bebek sejak umur 10 tahun"
  },
  "patient": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "recordedDate": "2023-06-04T05:40:00+00:00",
  "recorder": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  }
};

const allergyMedBody = {
  "resourceType": "AllergyIntolerance",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/allergy/{{Org_id}}",
      "use": "official",
      "value": "2024011234"
    }
  ],
  "clinicalStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical",
        "code": "active",
        "display": "Active"
      }
    ]
  },
  "verificationStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-verification",
        "code": "confirmed",
        "display": "Confirmed"
      }
    ]
  },
  "category": [
    "medication"
  ],
  "code": {
    "coding": [
      {
        "system": "http://sys-ids.kemkes.go.id/kfa",
        "code": "93000359",
        "display": "Azithromycin 500 mg Tablet Salut Selaput (KIMIA FARMA)"
      }
    ],
    "text": "sempat gatal2 setelah minum Azitromicin 500mg, membawa bungkus azitromisin kimia farma"
  },
  "patient": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "recordedDate": "2023-06-04T05:40:00+00:00",
  "recorder": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  }
};

const medStatementBody = {
  "resourceType": "MedicationStatement",
  "contained": [
    {
      "code": {
        "coding": [
          {
            "code": "93002313",
            "display": "Paracetamol 500 mg Tablet (PAMOL)",
            "system": "http://sys-ids.kemkes.go.id/kfa"
          }
        ]
      },
      "extension": [
        {
          "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
          "valueCodeableConcept": {
            "coding": [
              {
                "code": "NC",
                "display": "Non-compound",
                "system": "http://terminology.kemkes.go.id/CodeSystem/medication-type"
              }
            ]
          }
        }
      ],
      "form": {
        "coding": [
          {
            "code": "BS066",
            "display": "Tablet",
            "system": "http://terminology.kemkes.go.id/CodeSystem/medication-form"
          }
        ]
      },
      "id": "2024070141486-med001",
      "identifier": [
        {
          "system": "http://sys-ids.kemkes.go.id/medication/{{Org_id}}",
          "use": "official",
          "value": "2024070141486-med001"
        }
      ],
      "ingredient": [
        {
          "isActive": true,
          "itemCodeableConcept": {
            "coding": [
              {
                "code": "91000101",
                "display": "Paracetamol",
                "system": "http://sys-ids.kemkes.go.id/kfa"
              }
            ]
          },
          "strength": {
            "denominator": {
              "code": "TAB",
              "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
              "unit": "Tablet",
              "value": 1
            },
            "numerator": {
              "code": "mg",
              "system": "http://unitsofmeasure.org",
              "value": 500
            }
          }
        }
      ],
      "batch": {
        "lotNumber": "1625042A",
        "expirationDate": "2025-07-28"
      },
      "meta": {
        "profile": [
          "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
        ]
      },
      "resourceType": "Medication",
      "status": "active"
    }
  ],
  "status": "completed",
  "category": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/medication-statement-category",
        "code": "community",
        "display": "Community"
      }
    ]
  },
  "medicationReference": {
    "reference": "#2024070141486-med001",
    "display": "Paracetamol 500 mg Tablet (PAMOL)"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "dosage": [
    {
      "text": "Parasetamol 500 mg diminum 3x sehari",
      "timing": {
        "repeat": {
          "frequency": 3,
          "period": 1,
          "periodUnit": "d"
        }
      }
    }
  ],
  "effectiveDateTime": "2023-01-23T18:00:00+00:00",
  "dateAsserted": "2023-06-04T05:40:00+00:00",
  "informationSource": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "context": {
    "reference": "Encounter/{{Encounter_id}}"
  }
};

const medStatement2Body = {
  "resourceType": "MedicationStatement",
  "status": "active",
  "category": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/medication-statement-category",
        "code": "community",
        "display": "Community"
      }
    ]
  },
  "medicationCodeableConcept": {
    "coding": [
      {
        "system": "http://sys-ids.kemkes.go.id/kfa",
        "code": "93001819",
        "display": "Amlodipine Besilate 5 mg Tablet (HOLI PHARMA)"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "dosage": [
    {
      "text": "one capsule one time daily",
      "timing": {
        "repeat": {
          "frequency": 1,
          "period": 1,
          "periodUnit": "d"
        }
      }
    }
  ],
  "effectiveDateTime": "2023-01-23T18:00:00+00:00",
  "dateAsserted": "2023-06-04T05:40:00+00:00",
  "informationSource": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "context": {
    "reference": "Encounter/{{Encounter_id}}"
  }
};

const tdDiastolicBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "8462-4",
        "display": "Diastolic blood pressure"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 60,
    "unit": "mm[Hg]",
    "system": "http://unitsofmeasure.org",
    "code": "mm[Hg]"
  }
};

const suhuTubuhBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "8310-5",
        "display": "Body temperature"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 38.8,
    "unit": "Cel",
    "system": "http://unitsofmeasure.org",
    "code": "Cel"
  }
};

const denyutJantungBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "8867-4",
        "display": "Heart rate"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 80,
    "unit": "{beats}/min",
    "system": "http://unitsofmeasure.org",
    "code": "{beats}/min"
  }
};

const pernapasanBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "9279-1",
        "display": "Respiratory rate"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 22,
    "unit": "breaths/min",
    "system": "http://unitsofmeasure.org",
    "code": "/min"
  }
};

const tingkatKesadaranBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "67775-7",
        "display": "Level of responsiveness"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueCodeableConcept": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "248234008",
        "display": "Mentally alert"
      }
    ]
  }
};

const kepalaBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "exam",
          "display": "Exam"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "10199-8",
        "display": "Physical findings of Head Narrative"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueString": "Bentuk kepala simetris"
};

const mataBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "exam",
          "display": "Exam"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "10197-2",
        "display": "Physical findings of Eye Narrative"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueString": "Mata tampak sehat, konjungtiva tidak pucat"
};

const telingaBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "exam",
          "display": "Exam"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "10195-6",
        "display": "Physical findings of Ear Narrative"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueString": "Bentuk telinga simetris, liang telinga ada serumen, membran timpani utuh"
};

const hidungBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "exam",
          "display": "Exam"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "10203-8",
        "display": "Physical findings of Nose Narrative"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueString": "Septum nasi simetris, lubang hidung tidak ada sekret, dan tidak ada tanda inflamasi"
};

const rambutBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "exam",
          "display": "Exam"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "32436-8",
        "display": "Physical findings of Hair"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueString": "Rambut dalam batas normal"
};

const tinggiBadanBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "29463-7",
        "display": "Body weight"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 45,
    "unit": "kg",
    "system": "http://unitsofmeasure.org",
    "code": "kg"
  }
};

const beratBadanBody = {
  "resourceType": "Observation",
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "vital-signs",
          "display": "Vital Signs"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "8277-6",
        "display": "Body surface area"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T05:55:00+00:00",
  "issued": "2023-06-04T05:55:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}",
      "display": "{{Practitioner_Name}}"
    }
  ],
  "valueQuantity": {
    "value": 1.35,
    "unit": "m2",
    "system": "http://unitsofmeasure.org",
    "code": "m2"
  }
};

const clinicalImpBody = {
  "resourceType": "Goal",
  "lifecycleStatus": "planned",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/goal-category",
          "code": "nursing",
          "display": "Nursing"
        }
      ]
    }
  ],
  "description": {
    "text": "Perawatan dilakukan untuk mengatasi gejala DB"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "target": [
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8480-6",
            "display": "Systolic blood pressure"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    },
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8462-4",
            "display": "Diastolic blood pressure"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    },
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "26515-7",
            "display": "Platelets [#/volume] in Blood"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    }
  ],
  "statusDate": "2023-06-04",
  "expressedBy": {
    "reference": "Practitioner/{{Practitioner_id}}"
  },
  "addresses": [
    {
      "reference": "Condition/{{Condition_KeluhanUtama}}"
    }
  ]
};

const goalBody = {
  "resourceType": "Goal",
  "id": "{{Goal_TujuanPerawatan}}",
  "lifecycleStatus": "active",
  "achievementStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/goal-achievement",
        "code": "in-progress",
        "display": "In Progress"
      }
    ]
  },
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/goal-category",
          "code": "nursing",
          "display": "Nursing"
        }
      ]
    }
  ],
  "description": {
    "text": "Perawatan dilakukan untuk mengatasi gejala DB"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "target": [
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8480-6",
            "display": "Systolic blood pressure"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    },
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8462-4",
            "display": "Diastolic blood pressure"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    },
    {
      "measure": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "26515-7",
            "display": "Platelets [#/volume] in Blood"
          }
        ]
      },
      "detailCodeableConcept": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "17621005",
            "display": "Normal"
          }
        ]
      },
      "dueDate": "2023-06-04"
    }
  ],
  "statusDate": "2023-06-04",
  "expressedBy": {
    "reference": "Practitioner/{{Practitioner_id}}"
  },
  "addresses": [
    {
      "reference": "Condition/{{Condition_KeluhanUtama}}"
    }
  ],
  "outcomeCode": [
    {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "706907002",
          "display": "Some progress toward goal"
        }
      ]
    }
  ]
};

const goalUpdateBody = {
  "resourceType": "CarePlan",
  "status": "active",
  "intent": "plan",
  "category": [
    {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "736271009",
          "display": "Outpatient care plan"
        }
      ]
    }
  ],
  "title": "Rencana Rawat Pasien",
  "description": "Penanganan DB Pasien dilakukan dengan pemeriksaan penunjang dan pemberian pengobatan DB",
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "created": "2023-06-04T06:15:00+00:00",
  "author": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  },
  "goal": [
    {
      "reference": "Goal/{{Goal_TujuanPerawatan}}"
    }
  ]
};

const carePlanBody = {
  "resourceType": "CarePlan",
  "status": "active",
  "intent": "plan",
  "category": [
    {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "736271009",
          "display": "Outpatient care plan"
        }
      ]
    }
  ],
  "title": "Instruksi Medik dan Keperawatan Pasien",
  "description": "Penanganan DB Pasien dilakukan dengan pemberian pengobatan melalui infus, pemeriksaan laboratorium jumlah trombosit dalam darah, pemeriksaan radiologi CXR",
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "created": "2023-06-04T06:15:00+00:00",
  "author": {
    "reference": "Practitioner/{{Practitioner_id}}"
  },
  "goal": [
    {
      "reference": "Goal/{{Goal_TujuanPerawatan}}"
    }
  ]
};

const carePlanInstrukBody = {
  "resourceType": "Procedure",
  "status": "not-done",
  "category": {
    "coding": [
      {
        "system": "http://terminology.kemkes.go.id",
        "code": "TK000028",
        "display": "Diagnostic procedure"
      }
    ],
    "text": "Prosedur diagnostik"
  },
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "792805006",
        "display": "Fasting"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "performedPeriod": {
    "start": "2023-06-04T07:15:00+00:00",
    "end": "2023-06-04T07:15:00+00:00"
  },
  "performer": [
    {
      "actor": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ],
  "note": [
    {
      "text": "Tidak puasa"
    }
  ]
};

const procedureStatusPuasaBody = {
  "resourceType": "ServiceRequest",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/servicerequest/{{Org_id}}",
      "value": "{{Lab_SRID_Nominal}}"
    }
  ],
  "status": "active",
  "intent": "original-order",
  "priority": "routine",
  "category": [
    {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "108252007",
          "display": "Laboratory procedure"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "57743-7",
        "display": "ABO group [Type] in Blood by Confirmatory method"
      },
      {
        "system": "http://terminology.kemkes.go.id/CodeSystem/kptl",
        "code": "13120.JS004",
        "display": "Pemeriksaan golongan darah, Konfirmasi"
      }
    ],
    "text": "Pemeriksaan Golongan Darah"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "occurrenceDateTime": "2023-06-04T07:15:00+00:00",
  "authoredOn": "2023-06-04T07:15:00+00:00",
  "requester": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  },
  "performer": [
    {
      "reference": "Practitioner/N10000005",
      "display": "Fatma"
    }
  ],
  "reasonCode": [
    {
      "text": "Pemeriksaan Golongan Darah"
    }
  ],
  "note": [
    {
      "text": "Pasien tidak perlu berpuasa terlebih dahulu"
    }
  ],
  "supportingInfo": [
    {
      "reference": "Procedure/{{Procedure_StatusPuasa_Nominal}}"
    }
  ]
};

const serviceReqCreateBody = {
  "resourceType": "Specimen",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/specimen/{{Org_id}}",
      "value": "{{Lab_SpecID_Nominal}}",
      "assigner": {
        "reference": "Organization/{{Org_id}}"
      }
    }
  ],
  "status": "available",
  "type": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "119297000",
        "display": "Blood specimen"
      }
    ]
  },
  "collection": {
    "collector": {
      "reference": "Practitioner/N10000005",
      "display": "Fatma"
    },
    "collectedDateTime": "2023-06-04T07:15:00+00:00",
    "quantity": {
      "value": 10,
      "code": "mL",
      "unit": "mL",
      "system": "http://unitsofmeasure.org"
    },
    "method": {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "82078001",
          "display": "Collection of blood specimen for laboratory"
        }
      ]
    },
    "bodySite": {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "280388002",
          "display": "Structure of skin crease of elbow region"
        }
      ]
    },
    "fastingStatusCodeableConcept": {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/v2-0916",
          "code": "NF",
          "display": "The patient indicated they did not fast prior to the procedure."
        }
      ]
    }
  },
  "processing": [
    {
      "procedure": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "9265001",
            "display": "Specimen processing"
          }
        ]
      },
      "timeDateTime": "2023-06-04T07:15:00+00:00"
    }
  ],
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "request": [
    {
      "reference": "ServiceRequest/{{ServiceRequest_Nominal}}"
    }
  ],
  "receivedTime": "2023-06-04T07:15:00+00:00"
};

const specimenCreateBody = {
  "resourceType": "Observation",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/observation/{{Org_id}}",
      "value": "O111111"
    }
  ],
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "laboratory",
          "display": "Laboratory"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "57743-7",
        "display": "ABO group [Type] in Blood by Confirmatory method"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T07:15:00+00:00",
  "issued": "2023-06-04T07:15:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}"
    },
    {
      "reference": "Organization/{{Org_id}}"
    }
  ],
  "specimen": {
    "reference": "Specimen/{{Specimen_Nominal}}"
  },
  "basedOn": [
    {
      "reference": "ServiceRequest/{{ServiceRequest_Nominal}}"
    }
  ],
  "valueCodeableConcept": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "LA19710-5",
        "display": "Group A"
      }
    ]
  }
};

const golonganDarahObsBody = {
  "resourceType": "DiagnosticReport",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/diagnostic/{{Org_id}}/lab",
      "use": "official",
      "value": "5234342"
    }
  ],
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/v2-0074",
          "code": "HM",
          "display": "Hematology"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "57743-7",
        "display": "ABO group [Type] in Blood by Confirmatory method"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T07:15:00+00:00",
  "issued": "2023-06-04T07:15:00+00:00",
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}"
    },
    {
      "reference": "Organization/{{Org_id}}"
    }
  ],
  "result": [
    {
      "reference": "Observation/{{Observation_Nominal}}"
    }
  ],
  "specimen": [
    {
      "reference": "Specimen/{{Specimen_Nominal}}"
    }
  ],
  "basedOn": [
    {
      "reference": "ServiceRequest/{{ServiceRequest_Nominal}}"
    }
  ],
  "conclusionCode": [
    {
      "coding": [
        {
          "system": "http://loinc.org",
          "code": "LA19710-5",
          "display": "Group A"
        }
      ]
    }
  ]
};

const golonganDarahDiagBody = {
  "resourceType": "Procedure",
  "status": "not-done",
  "category": {
    "coding": [
      {
        "system": "http://terminology.kemkes.go.id",
        "code": "TK000028",
        "display": "Diagnostic procedure"
      }
    ],
    "text": "Prosedur diagnostik"
  },
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "792805006",
        "display": "Fasting"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "performedPeriod": {
    "start": "2023-06-04T07:14:00+00:00",
    "end": "2023-06-04T07:14:00+00:00"
  },
  "performer": [
    {
      "actor": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ],
  "note": [
    {
      "text": "Tidak puasa"
    }
  ]
};

const clinicalImpRasionalBody = {
  "resourceType": "Condition",
  "clinicalStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/condition-clinical",
        "code": "active",
        "display": "Active"
      }
    ]
  },
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/condition-category",
          "code": "encounter-diagnosis",
          "display": "Encounter Diagnosis"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://hl7.org/fhir/sid/icd-10",
        "code": "A91",
        "display": "Dengue haemorrhagic fever"
      },
      {
        "system": "http://snomed.info/sct",
        "code": "20927009",
        "display": "Dengue hemorrhagic fever"
      }
    ],
    "text": "Diagnosis primer Demam Berdarah (DHF)"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "onsetDateTime": "2023-06-04T08:30:00+00:00",
  "recordedDate": "2023-06-04T08:30:00+00:00",
  "stage": [
    {
      "assessment": [
        {
          "reference": "ClinicalImpression/{{Rasional_Klinis}}"
        }
      ]
    }
  ]
};

const conditionPrimaryBody = {
  "resourceType": "Condition",
  "clinicalStatus": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/condition-clinical",
        "code": "active",
        "display": "Active"
      }
    ]
  },
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/condition-category",
          "code": "encounter-diagnosis",
          "display": "Encounter Diagnosis"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://hl7.org/fhir/sid/icd-10",
        "code": "E11.9",
        "display": "Type 2 diabetes mellitus, Type 2 diabetes mellitus"
      },
      {
        "system": "http://snomed.info/sct",
        "code": "44054006",
        "display": "Diabetes mellitus type 2"
      }
    ],
    "text": "Diagnosis Sekunder Diabetes Mellitus tipe 2"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "onsetDateTime": "2023-06-04T08:30:00+00:00",
  "recordedDate": "2023-06-04T08:30:00+00:00",
  "stage": [
    {
      "assessment": [
        {
          "reference": "ClinicalImpression/{{Rasional_Klinis}}"
        }
      ]
    }
  ]
};

const clinicalImpPatchBody = {
  "resourceType": "RiskAssessment",
  "status": "final",
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "709510001",
        "display": "Assessment of risk for disease"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "performer": {
    "reference": "Practitioner/{{Practitioner_id}}"
  },
  "condition": {
    "reference": "Condition/{{Diagnosis_Primer}}"
  },
  "reasonReference": [
    {
      "reference": "Condition/{{Condition_KeluhanUtama}}"
    }
  ],
  "prediction": [
    {
      "outcome": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "409678004",
            "display": "Dengue hemorrhagic fever, grade III"
          }
        ]
      },
      "probabilityDecimal": 0.2
    }
  ],
  "mitigation": "Perlu diberikan infus untuk mencegah DB semakin parah"
};

const riskAssessmentBody = {
    "op": "add",
    "path": "/prognosisReference",
    "value": [
      {
        "reference": "RiskAssessment/{{Penilaian_Risiko}}"
      }
    ]
  };

const serviceReqEkgBody = {
  "resourceType": "Procedure",
  "basedOn": [
    {
      "reference": "ServiceRequest/{{SR_EKG}}"
    }
  ],
  "status": "completed",
  "category": {
    "coding": [
      {
        "system": "http://terminology.kemkes.go.id",
        "code": "TK000028",
        "display": "Diagnostic procedure"
      }
    ],
    "text": "Prosedur Diagnostik"
  },
  "code": {
    "coding": [
      {
        "system": "http://hl7.org/fhir/sid/icd-9-cm",
        "code": "89.52",
        "display": "Electrocardiogram"
      },
      {
        "system": "http://snomed.info/sct",
        "code": "29303009",
        "display": "Electrocardiographic procedure"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "performedPeriod": {
    "end": "2023-06-04T09:30:00+00:00",
    "start": "2023-06-04T09:30:00+00:00"
  },
  "performer": [
    {
      "actor": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ],
  "usedCode": [
    {
      "coding": [
        {
          "system": "http://sys-ids.kemkes.go.id/kfa",
          "code": "33999999",
          "display": "Alat EKG merk X"
        }
      ]
    }
  ]
};

const procedureEkgBody = {
  "resourceType": "Observation",
  "basedOn": [
    {
      "reference": "ServiceRequest/{{SR_EKG}}"
    }
  ],
  "partOf": [
    {
      "reference": "Procedure/{{Procedure_EKG}}"
    }
  ],
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/observation-category",
          "code": "procedure",
          "display": "Procedure"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "34534-8",
        "display": "12 lead EKG panel"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "performer": [
    {
      "reference": "Practitioner/{{Practitioner_id}}"
    }
  ],
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "effectiveDateTime": "2023-06-04T09:30:00+00:00",
  "issued": "2023-06-04T09:30:00+00:00",
  "component": [
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "426783006",
            "display": "Electrocardiogram: sinus rhythm"
          }
        ]
      },
      "valueBoolean": false
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "164889003",
            "display": "Electrocardiographic atrial fibrillation"
          }
        ]
      },
      "valueBoolean": true
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "76388001",
            "display": "ST segment elevation"
          }
        ]
      },
      "valueBoolean": true
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "26141007",
            "display": "ST segment depression"
          }
        ]
      },
      "valueBoolean": true
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "59931005",
            "display": "Inverted T wave"
          }
        ]
      },
      "valueBoolean": true
    },
    {
      "code": {
        "coding": [
          {
            "system": "http://snomed.info/sct",
            "code": "164873001",
            "display": "Electrocardiographic left ventricle hypertrophy"
          }
        ]
      },
      "valueBoolean": true
    }
  ],
  "valueString": "Hasil pemeriksaan EKG menunjukkan adanya gangguan pada jantung"
};

const medicationCreateBody = {
  "resourceType": "MedicationRequest",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/prescription/{{Org_id}}",
      "use": "official",
      "value": "123456788"
    },
    {
      "system": "http://sys-ids.kemkes.go.id/prescription-item/{{Org_id}}",
      "use": "official",
      "value": "123456788-1"
    }
  ],
  "status": "completed",
  "intent": "order",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
          "code": "community",
          "display": "Community"
        }
      ]
    }
  ],
  "priority": "routine",
  "medicationReference": {
    "reference": "Medication/{{Medication_ForRequest}}",
    "display": "{{Medication_Name}}"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "authoredOn": "2023-08-31T03:27:00+00:00",
  "requester": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  },
  "reasonReference": [
    {
      "reference": "Condition/{{Diagnosis_Primer}}",
      "display": "{{DiagnosisPrimer_Text}}"
    }
  ],
  "courseOfTherapyType": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
        "code": "continuous",
        "display": "Continuing long term therapy"
      }
    ]
  },
  "dosageInstruction": [
    {
      "sequence": 1,
      "additionalInstruction": [
        {
          "coding": [
            {
              "system": "http://snomed.info/sct",
              "code": "418577003",
              "display": "Take at regular intervals. Complete the prescribed course unless otherwise directed"
            }
          ]
        }
      ],
      "patientInstruction": "4 tablet perhari, diminum setiap hari tanpa jeda sampai prose pengobatan berakhir",
      "timing": {
        "repeat": {
          "frequency": 1,
          "period": 1,
          "periodUnit": "d"
        }
      },
      "route": {
        "coding": [
          {
            "system": "http://www.whocc.no/atc",
            "code": "O",
            "display": "Oral"
          }
        ]
      },
      "doseAndRate": [
        {
          "type": {
            "coding": [
              {
                "system": "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                "code": "ordered",
                "display": "Ordered"
              }
            ]
          },
          "doseQuantity": {
            "value": 4,
            "unit": "TAB",
            "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
            "code": "TAB"
          }
        }
      ]
    }
  ],
  "dispenseRequest": {
    "dispenseInterval": {
      "value": 1,
      "unit": "days",
      "system": "http://unitsofmeasure.org",
      "code": "d"
    },
    "validityPeriod": {
      "start": "2023-08-31T03:27:00+00:00",
      "end": "2024-07-22T14:27:00+00:00"
    },
    "numberOfRepeatsAllowed": 0,
    "quantity": {
      "value": 120,
      "unit": "TAB",
      "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
      "code": "TAB"
    },
    "expectedSupplyDuration": {
      "value": 30,
      "unit": "days",
      "system": "http://unitsofmeasure.org",
      "code": "d"
    },
    "performer": {
      "reference": "Organization/{{Org_id}}"
    }
  }
};

const medRequestCreateBody = {
  "resourceType": "QuestionnaireResponse",
  "questionnaire": "https://fhir.kemkes.go.id/Questionnaire/Q0007",
  "status": "completed",
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "authored": "2023-06-04T10:00:00+00:00",
  "author": {
    "reference": "Practitioner/N10000003",
    "display": "Apoteker Miller"
  },
  "source": {
    "reference": "Patient/{{Patient_id}}"
  },
  "item": [
    {
      "linkId": "1",
      "text": "Persyaratan Administrasi",
      "item": [
        {
          "linkId": "1.1",
          "text": "Apakah nama, umur, jenis kelamin, berat badan dan tinggi badan pasien sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.2",
          "text": "Apakah nama, nomor ijin, alamat dan paraf dokter sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.3",
          "text": "Apakah tanggal resep sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.4",
          "text": "Apakah ruangan/unit asal resep sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        }
      ]
    },
    {
      "linkId": "2",
      "text": "Persyaratan Farmasetik",
      "item": [
        {
          "linkId": "2.1",
          "text": "Apakah nama obat, bentuk dan kekuatan sediaan sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "2.2",
          "text": "Apakah dosis dan jumlah obat sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "2.3",
          "text": "Apakah stabilitas obat sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "2.4",
          "text": "Apakah aturan dan cara penggunaan obat sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        }
      ]
    },
    {
      "linkId": "3",
      "text": "Persyaratan Klinis",
      "item": [
        {
          "linkId": "3.1",
          "text": "Apakah ketepatan indikasi, dosis, dan waktu penggunaan obat sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "3.2",
          "text": "Apakah terdapat duplikasi pengobatan?",
          "answer": [
            {
              "valueBoolean": false
            }
          ]
        },
        {
          "linkId": "3.3",
          "text": "Apakah terdapat alergi dan reaksi obat yang tidak dikehendaki (ROTD)?",
          "answer": [
            {
              "valueBoolean": false
            }
          ]
        },
        {
          "linkId": "3.4",
          "text": "Apakah terdapat kontraindikasi pengobatan?",
          "answer": [
            {
              "valueBoolean": false
            }
          ]
        },
        {
          "linkId": "3.5",
          "text": "Apakah terdapat dampak interaksi obat?",
          "answer": [
            {
              "valueBoolean": false
            }
          ]
        }
      ]
    },
    {
      "linkId": "4",
      "text": "Resep yang dilakukan pengkajian resep",
      "answer": [
        {
          "valueReference": {
            "reference": "MedicationRequest/{{MedicationRequest_id1}}"
          }
        }
      ]
    }
  ]
};

const questionnaireResponseBody = {
  "resourceType": "Medication",
  "meta": {
    "profile": [
      "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
    ]
  },
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/medication/{{Org_id}}",
      "use": "official",
      "value": "123456789"
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://sys-ids.kemkes.go.id/kfa",
        "code": "93001019",
        "display": "Rifampicin 150 mg / Isoniazid 75 mg / Pyrazinamide 400 mg / Ethambutol 275 mg Tablet Salut Selaput (KIMIA FARMA)"
      }
    ]
  },
  "status": "active",
  "manufacturer": {
    "reference": "Organization/900001"
  },
  "form": {
    "coding": [
      {
        "system": "http://terminology.kemkes.go.id/CodeSystem/medication-form",
        "code": "BS023",
        "display": "Kaplet Salut Selaput"
      }
    ]
  },
  "ingredient": [
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000330",
            "display": "Rifampin"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 150,
          "system": "http://unitsofmeasure.org",
          "code": "mg"
        },
        "denominator": {
          "value": 1,
          "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
          "code": "TAB"
        }
      }
    },
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000328",
            "display": "Isoniazid"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 75,
          "system": "http://unitsofmeasure.org",
          "code": "mg"
        },
        "denominator": {
          "value": 1,
          "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
          "code": "TAB"
        }
      }
    },
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000329",
            "display": "Pyrazinamide"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 400,
          "system": "http://unitsofmeasure.org",
          "code": "mg"
        },
        "denominator": {
          "value": 1,
          "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
          "code": "TAB"
        }
      }
    },
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000288",
            "display": "Ethambutol"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 275,
          "system": "http://unitsofmeasure.org",
          "code": "mg"
        },
        "denominator": {
          "value": 1,
          "system": "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
          "code": "TAB"
        }
      }
    }
  ],
  "batch": {
    "lotNumber": "1625042A",
    "expirationDate": "2025-07-22T14:27:00+00:00"
  },
  "extension": [
    {
      "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
      "valueCodeableConcept": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id/CodeSystem/medication-type",
            "code": "NC",
            "display": "Non-compound"
          }
        ]
      }
    }
  ]
};

const medDispenseCreateBody = {
  "resourceType": "MedicationRequest",
  "contained": [
    {
      "resourceType": "Medication",
      "identifier": [
        {
          "system": "http://sys-ids.kemkes.go.id/medication/{{Org_id}}",
          "use": "official",
          "value": "123456789"
        }
      ],
      "id": "123456789",
      "code": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "93000374",
            "display": "Ringer Lactate (NATURA LABORATORIA PRIMA, 500 mL)"
          }
        ]
      },
      "status": "active",
      "manufacturer": {
        "reference": "Organization/90000001"
      },
      "form": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id/CodeSystem/medication-form",
            "code": "BS035",
            "display": "Infus"
          }
        ]
      },
      "ingredient": [
        {
          "itemCodeableConcept": {
            "coding": [
              {
                "system": "http://sys-ids.kemkes.go.id/kfa",
                "code": "91000568",
                "display": "Calcium Chloride, Dihydration"
              }
            ]
          },
          "isActive": true,
          "strength": {
            "numerator": {
              "value": 0.1,
              "system": "http://unitsofmeasure.org",
              "code": "g"
            },
            "denominator": {
              "value": 1,
              "unit": "Bottle - unit of product usage",
              "system": "http://snomed.info/sct",
              "code": "419672006"
            }
          }
        },
        {
          "itemCodeableConcept": {
            "coding": [
              {
                "system": "http://sys-ids.kemkes.go.id/kfa",
                "code": "91000171",
                "display": "Sodium Chloride"
              }
            ]
          },
          "isActive": true,
          "strength": {
            "numerator": {
              "value": 1.55,
              "system": "http://unitsofmeasure.org",
              "code": "g"
            },
            "denominator": {
              "value": 1,
              "unit": "Bottle - unit of product usage",
              "system": "http://snomed.info/sct",
              "code": "419672006"
            }
          }
        },
        {
          "itemCodeableConcept": {
            "coding": [
              {
                "system": "http://sys-ids.kemkes.go.id/kfa",
                "code": "91000265",
                "display": "Sodium Lactate"
              }
            ]
          },
          "isActive": true,
          "strength": {
            "numerator": {
              "value": 3,
              "system": "http://unitsofmeasure.org",
              "code": "g"
            },
            "denominator": {
              "value": 1,
              "unit": "Bottle - unit of product usage",
              "system": "http://snomed.info/sct",
              "code": "419672006"
            }
          }
        },
        {
          "itemCodeableConcept": {
            "coding": [
              {
                "system": "http://sys-ids.kemkes.go.id/kfa",
                "code": "91000198",
                "display": "Potassium Chloride"
              }
            ]
          },
          "isActive": true,
          "strength": {
            "numerator": {
              "value": 0.15,
              "system": "http://unitsofmeasure.org",
              "code": "g"
            },
            "denominator": {
              "value": 1,
              "unit": "Bottle - unit of product usage",
              "system": "http://snomed.info/sct",
              "code": "419672006"
            }
          }
        }
      ],
      "extension": [
        {
          "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
          "valueCodeableConcept": {
            "coding": [
              {
                "system": "http://terminology.kemkes.go.id/CodeSystem/medication-type",
                "code": "NC",
                "display": "Non-compound"
              }
            ]
          }
        }
      ]
    }
  ],
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/prescription/{{Org_id}}",
      "use": "official",
      "value": "123456788"
    },
    {
      "system": "http://sys-ids.kemkes.go.id/prescription-item/{{Org_id}}",
      "use": "official",
      "value": "123456788-1"
    }
  ],
  "status": "completed",
  "intent": "order",
  "category": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
          "code": "outpatient",
          "display": "Outpatient"
        }
      ]
    }
  ],
  "priority": "routine",
  "medicationReference": {
    "reference": "#123456789",
    "display": "{{Medication_Name}}"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "authoredOn": "2023-06-04T10:00:00+00:00",
  "requester": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  },
  "reasonReference": [
    {
      "reference": "Condition/{{Diagnosis_Primer}}",
      "display": "{{DiagnosisPrimer_Text}}"
    }
  ],
  "courseOfTherapyType": {
    "coding": [
      {
        "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
        "code": "acute",
        "display": "Short course (acute) therapy"
      }
    ]
  },
  "dosageInstruction": [
    {
      "sequence": 1,
      "patientInstruction": "1 botol per 8 jam",
      "additionalInstruction": [
        {
          "coding": [
            {
              "system": "http://snomed.info/sct",
              "code": "421769005",
              "display": "Follow directions"
            }
          ]
        }
      ],
      "timing": {
        "repeat": {
          "frequency": 1,
          "period": 8,
          "periodUnit": "h"
        }
      },
      "route": {
        "coding": [
          {
            "system": "http://www.whocc.no/atc",
            "code": "P",
            "display": "Parenteral"
          }
        ]
      },
      "doseAndRate": [
        {
          "type": {
            "coding": [
              {
                "system": "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                "code": "ordered",
                "display": "Ordered"
              }
            ]
          },
          "doseQuantity": {
            "value": 1,
            "unit": "Bottle - unit of product usage",
            "system": "http://snomed.info/sct",
            "code": "419672006"
          }
        }
      ]
    }
  ],
  "dispenseRequest": {
    "dispenseInterval": {
      "value": 8,
      "unit": "hour",
      "system": "http://unitsofmeasure.org",
      "code": "h"
    },
    "validityPeriod": {
      "start": "2023-06-04T10:00:00+00:00",
      "end": "2023-06-05T10:00:00+00:00"
    },
    "numberOfRepeatsAllowed": 0,
    "quantity": {
      "value": 1,
      "unit": "Bottle - unit of product usage",
      "system": "http://snomed.info/sct",
      "code": "419672006"
    },
    "expectedSupplyDuration": {
      "value": 8,
      "unit": "hour",
      "system": "http://unitsofmeasure.org",
      "code": "h"
    },
    "performer": {
      "reference": "Organization/{{Org_id}}"
    }
  }
};

const medRequestContainedBody = {
  "resourceType": "QuestionnaireResponse",
  "questionnaire": "https://fhir.kemkes.go.id/Questionnaire/Q0007",
  "status": "completed",
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "authored": "2023-06-04T10:00:00+00:00",
  "author": {
    "reference": "Practitioner/N10000003",
    "display": "Apoteker Miller"
  },
  "source": {
    "reference": "Patient/{{Patient_id}}"
  },
  "item": [
    {
      "linkId": "1",
      "text": "Persyaratan Administrasi",
      "item": [
        {
          "linkId": "1.1",
          "text": "Apakah nama, umur, jenis kelamin, berat badan dan tinggi badan pasien sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.2",
          "text": "Apakah nama, nomor ijin, alamat dan paraf dokter sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.3",
          "text": "Apakah tanggal resep sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "1.4",
          "text": "Apakah ruangan/unit asal resep sudah sesuai?",
          "answer": [
            {
              "valueCoding": {
                "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                "code": "OV000052",
                "display": "Sesuai"
              }
            }
          ]
        },
        {
          "linkId": "2",
          "text": "Persyaratan Farmasetik",
          "item": [
            {
              "linkId": "2.1",
              "text": "Apakah nama obat, bentuk dan kekuatan sediaan sudah sesuai?",
              "answer": [
                {
                  "valueCoding": {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                    "code": "OV000052",
                    "display": "Sesuai"
                  }
                }
              ]
            },
            {
              "linkId": "2.2",
              "text": "Apakah dosis dan jumlah obat sudah sesuai?",
              "answer": [
                {
                  "valueCoding": {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                    "code": "OV000052",
                    "display": "Sesuai"
                  }
                }
              ]
            },
            {
              "linkId": "2.3",
              "text": "Apakah stabilitas obat sudah sesuai?",
              "answer": [
                {
                  "valueCoding": {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                    "code": "OV000052",
                    "display": "Sesuai"
                  }
                }
              ]
            },
            {
              "linkId": "2.4",
              "text": "Apakah aturan dan cara penggunaan obat sudah sesuai?",
              "answer": [
                {
                  "valueCoding": {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                    "code": "OV000052",
                    "display": "Sesuai"
                  }
                }
              ]
            }
          ]
        },
        {
          "linkId": "3",
          "text": "Persyaratan Klinis",
          "item": [
            {
              "linkId": "3.1",
              "text": "Apakah ketepatan indikasi, dosis, dan waktu penggunaan obat sudah sesuai?",
              "answer": [
                {
                  "valueCoding": {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                    "code": "OV000052",
                    "display": "Sesuai"
                  }
                }
              ]
            },
            {
              "linkId": "3.2",
              "text": "Apakah terdapat duplikasi pengobatan?",
              "answer": [
                {
                  "valueBoolean": false
                }
              ]
            },
            {
              "linkId": "3.3",
              "text": "Apakah terdapat alergi dan reaksi obat yang tidak dikehendaki (ROTD)?",
              "answer": [
                {
                  "valueBoolean": false
                }
              ]
            },
            {
              "linkId": "3.4",
              "text": "Apakah terdapat kontraindikasi pengobatan?",
              "answer": [
                {
                  "valueBoolean": false
                }
              ]
            },
            {
              "linkId": "3.5",
              "text": "Apakah terdapat dampak interaksi obat?",
              "answer": [
                {
                  "valueBoolean": false
                }
              ]
            }
          ]
        },
        {
          "linkId": "4",
          "text": "Resep yang dilakukan pengkajian resep",
          "answer": [
            {
              "valueReference": {
                "reference": "MedicationRequest/{{MedicationRequest_id2}}"
              }
            }
          ]
        }
      ]
    }
  ]
};

const medAdminBody = {
  "resourceType": "Medication",
  "meta": {
    "profile": [
      "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
    ]
  },
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/medication/{{Org_id}}",
      "use": "official",
      "value": "123456788"
    }
  ],
  "status": "active",
  "form": {
    "coding": [
      {
        "system": "http://terminology.kemkes.go.id/CodeSystem/medication-form",
        "code": "BS030",
        "display": "Krim"
      }
    ]
  },
  "ingredient": [
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000517",
            "display": "Clobetasol"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 0.75,
          "system": "http://unitsofmeasure.org",
          "code": "mg"
        },
        "denominator": {
          "value": 1,
          "system": "http://unitsofmeasure.org",
          "code": "g"
        }
      }
    },
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000290",
            "display": "Bacitracin"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 500,
          "system": "http://unitsofmeasure.org",
          "code": "[IU]"
        },
        "denominator": {
          "value": 1,
          "system": "http://unitsofmeasure.org",
          "code": "g"
        }
      }
    },
    {
      "itemCodeableConcept": {
        "coding": [
          {
            "system": "http://sys-ids.kemkes.go.id/kfa",
            "code": "91000291",
            "display": "Polymyxin B"
          }
        ]
      },
      "isActive": true,
      "strength": {
        "numerator": {
          "value": 100000,
          "system": "http://unitsofmeasure.org",
          "code": "[IU]"
        },
        "denominator": {
          "value": 1,
          "system": "http://unitsofmeasure.org",
          "code": "g"
        }
      }
    }
  ],
  "extension": [
    {
      "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
      "valueCodeableConcept": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id/CodeSystem/medication-type",
            "code": "SD",
            "display": "Gives of such doses"
          }
        ]
      }
    }
  ]
};

const nutritionOrderBody = {
  "resourceType": "Procedure",
  "status": "completed",
  "category": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "409073007",
        "display": "Education"
      }
    ]
  },
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "61310001",
        "display": "Nutrition education"
      },
      {
        "system": "http://terminology.kemkes.go.id/CodeSystem/kptl",
        "code": "10913",
        "display": "Edukasi Kesehatan Individu"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "performedPeriod": {
    "start": "2023-06-04T10:24:00+00:00",
    "end": "2023-06-04T10:24:00+00:00"
  },
  "performer": [
    {
      "actor": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ]
};

const encounterUpdatePulangBody = {
  "resourceType": "Composition",
  "identifier": {
    "system": "http://sys-ids.kemkes.go.id/composition/{{Org_id}}",
    "value": "P20240001"
  },
  "status": "final",
  "category": [
    {
      "coding": [
        {
          "system": "http://loinc.org",
          "code": "LP173421-1",
          "display": "Report"
        }
      ]
    }
  ],
  "type": {
    "coding": [
      {
        "system": "http://loinc.org",
        "code": "88645-7",
        "display": "Outpatient hospital Discharge summary"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "date": "2023-06-04T10:24:47+00:00",
  "title": "Resume Medis Pasien Rawat Jalan {{Patient_Name}} pada tanggal 4 Juni 2023",
  "author": [
    {
      "reference": "Practitioner/{{Practitioner_id}}"
    }
  ],
  "custodian": {
    "reference": "Organization/{{Org_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "section": [
    {
      "title": "Anamnesis",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000003",
            "display": "Anamnesis"
          }
        ]
      },
      "section": [
        {
          "title": "Keluhan Utama",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "10154-3",
                "display": "Chief complaint Narrative - Reported"
              }
            ]
          },
          "entry": [
            {
              "reference": "Condition/{{Condition_KeluhanUtama}}"
            }
          ]
        },
        {
          "title": "Keluhan Penyerta",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "11450-4",
                "display": "Problem list - Reported"
              }
            ]
          },
          "entry": [
            {
              "reference": "Condition/{{Condition_KeluhanPenyerta}}"
            }
          ]
        },
        {
          "title": "Riwayat Penyakit Pribadi Terdahulu",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "11348-0",
                "display": "History of Past illness Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "Condition/{{Condition_RiwayatPenyakitPribadiTerdahulu}}"
            }
          ]
        },
        {
          "title": "Riwayat Penyakit Pribadi Sekarang",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "10164-2",
                "display": "History of Present illness Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "Condition/{{Condition_RiwayatPenyakitPribadiSekarang}}"
            }
          ]
        },
        {
          "title": "Riwayat Penyakit Keluarga",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "10157-6",
                "display": "History of family member diseases Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "FamilyMemberHistory/{{FamilyMemberHistory_RiwayatPenyakitKeluarga}}"
            }
          ]
        },
        {
          "title": "Riwayat Alergi",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "48765-2",
                "display": "Allergies"
              }
            ]
          },
          "entry": [
            {
              "reference": "AllergyIntolerance/{{AllergyIntolerance_Lingkungan}}"
            },
            {
              "reference": "AllergyIntolerance/{{AllergyIntolerance_Makanan}}"
            },
            {
              "reference": "AllergyIntolerance/{{AllergyIntolerance_Obat}}"
            }
          ]
        },
        {
          "title": "Riwayat Pengobatan",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "10160-0",
                "display": "History of Medication use Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "MedicationStatement/{{MedicationStatement_id2}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Pemeriksaan Fisik",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000007",
            "display": "Pemeriksaan Fisik"
          }
        ]
      },
      "section": [
        {
          "title": "Tanda Vital",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "8716-3",
                "display": "Vital signs"
              }
            ]
          },
          "entry": [
            {
              "reference": "Observation/{{Observation_TDSistolik}}"
            },
            {
              "reference": "Observation/{{Observation_TDDiastolik}}"
            },
            {
              "reference": "Observation/{{Observation_SuhuTubuh}}"
            },
            {
              "reference": "Observation/{{Observation_DenyutJantung}}"
            },
            {
              "reference": "Observation/{{Observation_Pernapasan}}"
            },
            {
              "reference": "Observation/{{Observation_Kesadaran}}"
            },
            {
              "reference": "Observation/{{Antrop_BB}}"
            },
            {
              "reference": "Observation/{{Antrop_TB}}"
            },
            {
              "reference": "Observation/{{Antrop_Luas}}"
            }
          ]
        },
        {
          "title": "Pemeriksaan Fisik Head to Toe",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "10187-3",
                "display": "Review of systems Narrative - Reported"
              }
            ]
          },
          "entry": [
            {
              "reference": "Observation/{{PemeriksaanFisik_Mata}}"
            },
            {
              "reference": "Observation/{{PemeriksaanFisik_Telinga}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Pemeriksaan Fungsional",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "47420-5",
            "display": "Functional status assessment note"
          }
        ]
      },
      "entry": [
        {
          "reference": "Observation/{{StatusPsikologis}}"
        }
      ]
    },
    {
      "title": "Perencanaan Perawatan",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "18776-5",
            "display": "Plan of care note"
          }
        ]
      },
      "entry": [
        {
          "reference": "ClinicalImpression/{{RiwayatPerjalananPenyakit}}"
        },
        {
          "reference": "Goal/{{Goal_TujuanPerawatan}}"
        },
        {
          "reference": "CarePlan/{{CarePlan_RencanaRawat}}"
        },
        {
          "reference": "CarePlan/{{CarePlan_Instruksi}}"
        }
      ]
    },
    {
      "title": "Pemeriksaan Penunjang",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000009",
            "display": "Hasil Pemeriksaan Penunjang"
          }
        ]
      },
      "section": [
        {
          "title": "Hasil Pemeriksaan Laboratorium",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "11502-2",
                "display": "Laboratory report"
              }
            ]
          },
          "entry": [
            {
              "reference": "ServiceRequest/{{ServiceRequest_Kuantitatif}}"
            },
            {
              "reference": "Procedure/{{Procedure_StatusPuasa_Kuantitatif}}"
            },
            {
              "reference": "Specimen/{{Specimen_Kuantitatif}}"
            },
            {
              "reference": "Observation/{{Observation_Kuantitatif}}"
            },
            {
              "reference": "DiagnosticReport/{{DiagnosticReport_Kuantitatif}}"
            }
          ]
        },
        {
          "title": "Hasil Pemeriksaan Radiologi",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "18782-3",
                "display": "Radiology Study observation (narrative)"
              }
            ]
          },
          "entry": [
            {
              "reference": "ServiceRequest/{{ServiceRequest_Rad}}"
            },
            {
              "reference": "Procedure/{{Procedure_Rad}}"
            },
            {
              "reference": "Observation/{{Observation_Rad1}}"
            },
            {
              "reference": "AllergyIntolerance/{{AllergyIntolerance_Rad}}"
            },
            {
              "reference": "ImagingStudy/{{ImagingStudy_id}}"
            },
            {
              "reference": "Observation/{{Observation_Rad}}"
            },
            {
              "reference": "DiagnosticReport/{{DiagnosticReport_Rad}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Diagnosis",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000004",
            "display": "Diagnosis"
          }
        ]
      },
      "section": [
        {
          "title": "Diagnosis Akhir",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "78375-3",
                "display": "Discharge diagnosis Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "ClinicalImpression/{{Rasional_Klinis}}"
            },
            {
              "reference": "Condition/{{Diagnosis_Primer}}"
            },
            {
              "reference": "Condition/{{Diagnosis_Sekunder}}"
            },
            {
              "reference": "RiskAssessment/{{Penilaian_Risiko}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Tindakan/Prosedur Medis",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000005",
            "display": "Tindakan/Prosedur Medis"
          }
        ]
      },
      "entry": [
        {
          "reference": "Procedure/{{Procedure_EKG}}"
        },
        {
          "reference": "Observation/{{Observation_EKG}}"
        },
        {
          "reference": "Procedure/{{Procedure_Nebu}}"
        }
      ]
    },
    {
      "title": "Farmasi",
      "code": {
        "coding": [
          {
            "system": "http://terminology.kemkes.go.id",
            "code": "TK000013",
            "display": "Obat"
          }
        ]
      },
      "section": [
        {
          "title": "Obat Saat Kunjungan",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "42346-7",
                "display": "Medications on admission (narrative)"
              }
            ]
          },
          "entry": [
            {
              "reference": "MedicationRequest/{{MedicationRequest_id2}}"
            },
            {
              "reference": "MedicationDispense/{{MedicationDispense_id2}}"
            },
            {
              "reference": "MedicationAdministration/{{MedicationAdministration_id2}}"
            }
          ]
        },
        {
          "title": "Obat Pulang",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "75311-1",
                "display": "Discharge medications Narrative"
              }
            ]
          },
          "entry": [
            {
              "reference": "MedicationRequest/{{MedicationRequest_id1}}"
            },
            {
              "reference": "MedicationDispense/{{MedicationDispense_id1}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Diet",
      "section": [
        {
          "title": "Rekomendasi Diet",
          "code": {
            "coding": [
              {
                "system": "http://loinc.org",
                "code": "42344-2",
                "display": "Discharge diet (narrative)"
              }
            ]
          },
          "entry": [
            {
              "reference": "NutritionOrder/{{NutritionOrder_Diet}}"
            }
          ]
        }
      ]
    },
    {
      "title": "Edukasi",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "34895-3",
            "display": "Education note"
          }
        ]
      },
      "entry": [
        {
          "reference": "Procedure/{{Procedure_Edukasi}}"
        }
      ]
    },
    {
      "title": "Kondisi Saat Meninggalkan Rumah Sakit",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "10184-0",
            "display": "Hospital discharge physical findings Narrative"
          }
        ]
      },
      "entry": [
        {
          "reference": "ClinicalImpression/{{Prognosis_Pulang}}"
        },
        {
          "reference": "Condition/{{KondisiMeninggalkanRS}}"
        }
      ]
    },
    {
      "title": "Rencana Tindak Lanjut",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8653-8",
            "display": "Hospital Discharge instructions"
          }
        ]
      },
      "entry": [
        {
          "reference": "ServiceRequest/{{ServiceRequest_Kontrol}}"
        }
      ]
    },
    {
      "title": "Perjalanan Kunjungan Pasien",
      "code": {
        "coding": [
          {
            "system": "http://loinc.org",
            "code": "8648-8",
            "display": "Hospital course Narrative"
          }
        ]
      },
      "text": {
        "status": "additional",
        "div": "Pasien {{Patient_Name}} masuk rumah sakit pada tanggal 4 Juni 2023 dengan keluhan utama yang sudah dirasakan selama 2 hari sebelum kunjungan. Selama anamnesis, pasien mengeluhkan selama 2 hari sebelum kunjungan. Riwayat penyakit terdahulu menunjukkan bahwa pasien sudah mengalami gejala selama 3 tahun dan tidak rutin berobat. Riwayat penyakit saat ini menunjukkan keluhan dimulai 2 hari sebelum kunjungan dengan intensitas sedang yang meningkat selama 2 jam terakhir. Pasien memiliki riwayat penyakit keluarga terkait keluhannya. Pasien juga memiliki riwayat alergi terhadap dan melaporkan mengonsumsi obat dua kali sehari selama 2 minggu terakhir. Hasil pemeriksaan fisik, menunjukkan hasil dalam batas normal. Pemeriksaan fungsional dan sosial juga dilakukan. Pasien kemudian menjalani pemeriksaan penunjang laboratorium dan radiologi. Pasien juga menjalani prosedur diagnostik dan terapetik. Pasien terkonfirmasi dengan {{DiagnosisKeluar}}. Pasien diberi obat pada saat saat kunjungan dan obat untuk dibawa pulang. Pasien pulang dengan prognosis baik dan keadaan stabil. Pasien direncanakan untuk melakukan kontrol kembali."
      }
    }
  ]
};

const compositionResumeBody = {
  "resourceType": "ServiceRequest",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/servicerequest/{{Org_id}}",
      "value": "000012345"
    }
  ],
  "status": "active",
  "intent": "original-order",
  "priority": "routine",
  "category": [
    {
      "coding": [
        {
          "system": "http://snomed.info/sct",
          "code": "3457005",
          "display": "Patient referral"
        }
      ]
    }
  ],
  "code": {
    "coding": [
      {
        "system": "http://snomed.info/sct",
        "code": "737481003",
        "display": "Inpatient care management"
      }
    ]
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}"
  },
  "encounter": {
    "reference": "Encounter/{{Encounter_id}}"
  },
  "occurrenceDateTime": "2023-06-04T10:24:00+00:00",
  "requester": {
    "reference": "Practitioner/{{Practitioner_id}}",
    "display": "{{Practitioner_Name}}"
  },
  "performer": [
    {
      "reference": "Practitioner/N10000005",
      "display": "Fatma"
    }
  ],
  "reasonCode": [
    {
      "coding": [
        {
          "system": "http://hl7.org/fhir/sid/icd-10",
          "code": "A91",
          "display": "Dengue haemorrhagic fever"
        }
      ]
    }
  ],
  "locationCode": [
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/v3-RoleCode",
          "code": "HOSP",
          "display": "Hospital"
        }
      ]
    },
    {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/v3-RoleCode",
          "code": "AMB",
          "display": "Ambulance"
        }
      ]
    }
  ],
  "patientInstruction": "Rujukan ke Rawat Inap RSUP Fatmawati. Dalam keadaan darurat dapat menghubungi hotline Fasyankes di nomor 14045"
};

const serviceReqRujukanBody = {
  "resourceType": "Encounter",
  "id": "{{Encounter_id}}",
  "identifier": [
    {
      "system": "http://sys-ids.kemkes.go.id/encounter/{{Org_id}}",
      "value": "{{Registration_ID}}"
    }
  ],
  "status": "finished",
  "class": {
    "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
    "code": "AMB",
    "display": "ambulatory"
  },
  "subject": {
    "reference": "Patient/{{Patient_id}}",
    "display": "{{Patient_Name}}"
  },
  "participant": [
    {
      "type": [
        {
          "coding": [
            {
              "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
              "code": "ATND",
              "display": "attender"
            }
          ]
        }
      ],
      "individual": {
        "reference": "Practitioner/{{Practitioner_id}}",
        "display": "{{Practitioner_Name}}"
      }
    }
  ],
  "period": {
    "start": "2023-06-04T05:24:47+00:00",
    "end": "2023-06-04T10:24:47+00:00"
  },
  "location": [
    {
      "location": {
        "reference": "Location/{{Location_Poli}}",
        "display": "{{Location_Poli_Name}}"
      },
      "period": {
        "start": "2023-06-04T05:24:47+00:00",
        "end": "2023-06-04T10:24:47+00:00"
      },
      "extension": [
        {
          "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
          "extension": [
            {
              "url": "value",
              "valueCodeableConcept": {
                "coding": [
                  {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                    "code": "reguler",
                    "display": "Kelas Reguler"
                  }
                ]
              }
            },
            {
              "url": "upgradeClassIndicator",
              "valueCodeableConcept": {
                "coding": [
                  {
                    "system": "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                    "code": "kelas-tetap",
                    "display": "Kelas Tetap Perawatan"
                  }
                ]
              }
            }
          ]
        }
      ]
    }
  ],
  "diagnosis": [
    {
      "condition": {
        "reference": "Condition/{{Diagnosis_Primer}}",
        "display": "{{DiagnosisPrimer_Text}}"
      },
      "use": {
        "coding": [
          {
            "system": "http://terminology.hl7.org/CodeSystem/diagnosis-role",
            "code": "DD",
            "display": "Discharge diagnosis"
          }
        ]
      },
      "rank": 1
    },
    {
      "condition": {
        "reference": "Condition/{{Diagnosis_Sekunder}}",
        "display": "{{DiagnosisSekunder_Text}}"
      },
      "use": {
        "coding": [
          {
            "system": "http://terminology.hl7.org/CodeSystem/diagnosis-role",
            "code": "DD",
            "display": "Discharge diagnosis"
          }
        ]
      },
      "rank": 2
    },
    {
      "condition": {
        "reference": "Condition/{{Condition_KeluhanUtama}}"
      },
      "use": {
        "coding": [
          {
            "system": "http://terminology.hl7.org/CodeSystem/diagnosis-role",
            "code": "CC",
            "display": "Chief Complaint"
          }
        ]
      }
    }
  ],
  "statusHistory": [
    {
      "status": "arrived",
      "period": {
        "start": "2023-06-04T05:24:47+00:00",
        "end": "2023-06-04T05:25:00+00:00"
      }
    },
    {
      "status": "in-progress",
      "period": {
        "start": "2023-06-04T05:25:00+00:00",
        "end": "2023-06-04T10:24:00+00:00"
      }
    },
    {
      "status": "finished",
      "period": {
        "start": "2023-06-04T10:24:00+00:00",
        "end": "2023-06-04T10:24:47+00:00"
      }
    }
  ],
  "hospitalization": {
    "dischargeDisposition": {
      "coding": [
        {
          "system": "http://terminology.hl7.org/CodeSystem/discharge-disposition",
          "code": "oth",
          "display": "other-hcf"
        }
      ],
      "text": "Rujukan ke RSUP Fatmawati dengan nomor rujukan {{No_Rujukan_Pasien}}"
    }
  },
  "serviceProvider": {
    "reference": "Organization/{{Org_id}}"
  }
};


// ── Aliases: map HTML reset-button names → actual const names ─────────────
const allergyBody         = allergyEnvBody;
const medDispenseBody     = medDispenseCreateBody;
const serviceReqBody      = serviceReqCreateBody;
const specimenBody        = specimenCreateBody;
const diagnosticBody      = golonganDarahDiagBody;
const riskBody            = riskAssessmentBody;
const questionnaireBody   = questionnaireResponseBody;
const medicationBody      = medicationCreateBody;
const nutritionBody       = nutritionOrderBody;
const compositionBody     = compositionResumeBody;
const procedureBody       = procedureStatusPuasaBody;
const medreqBody          = medRequestCreateBody;
const encounterUpdateBody = encounterUpdatePulangBody;
const conditionBody       = conditionPrimaryBody;

// ── Init: isi semua textarea dengan payload default ───────────────────────
function initTextareas() {
  document.getElementById('encounter-create-body').value = JSON.stringify(encounterCreateBody, null, 2);
  document.getElementById('encounter-update-body').value = JSON.stringify(encounterUpdateBody, null, 2);
  document.getElementById('condition-body').value        = JSON.stringify(conditionBody, null, 2);
  document.getElementById('observation-body').value      = JSON.stringify(observationBody, null, 2);
  document.getElementById('procedure-body').value        = JSON.stringify(procedureBody, null, 2);
  document.getElementById('medreq-body').value           = JSON.stringify(medreqBody, null, 2);
  document.getElementById('organization-body').value     = JSON.stringify(organizationBody, null, 2);
  document.getElementById('location-body').value         = JSON.stringify(locationBody, null, 2);
  document.getElementById('family-history-body').value   = JSON.stringify(familyHistoryBody, null, 2);
  document.getElementById('allergy-body').value          = JSON.stringify(allergyEnvBody, null, 2);
  document.getElementById('med-statement-body').value    = JSON.stringify(medStatementBody, null, 2);
  document.getElementById('med-dispense-body').value     = JSON.stringify(medDispenseBody, null, 2);
  document.getElementById('med-admin-body').value        = JSON.stringify(medAdminBody, null, 2);
  document.getElementById('clinical-imp-body').value     = JSON.stringify(clinicalImpBody, null, 2);
  document.getElementById('clinical-imp-patch-body').value = JSON.stringify(clinicalImpPatchBody, null, 2);
  document.getElementById('goal-body').value             = JSON.stringify(goalBody, null, 2);
  document.getElementById('goal-update-body').value      = JSON.stringify(goalUpdateBody, null, 2);
  document.getElementById('careplan-body').value         = JSON.stringify(carePlanBody, null, 2);
  document.getElementById('service-req-body').value      = JSON.stringify(serviceReqCreateBody, null, 2);
  document.getElementById('specimen-body').value         = JSON.stringify(specimenCreateBody, null, 2);
  document.getElementById('diagnostic-body').value       = JSON.stringify(diagnosticBody, null, 2);
  document.getElementById('risk-body').value             = JSON.stringify(riskAssessmentBody, null, 2);
  document.getElementById('questionnaire-body').value    = JSON.stringify(questionnaireResponseBody, null, 2);
  document.getElementById('medication-body').value       = JSON.stringify(medicationCreateBody, null, 2);
  document.getElementById('nutrition-body').value        = JSON.stringify(nutritionOrderBody, null, 2);
  document.getElementById('composition-body').value      = JSON.stringify(compositionResumeBody, null, 2);
  document.getElementById('bundle-body').value           = JSON.stringify(bundleBody, null, 2);
}
initTextareas();

function resetBody(id, obj) {
  document.getElementById(id).value = JSON.stringify(obj, null, 2);
}

// ── Accordion ─────────────────────────────────────────────────────────────
function toggleEndpoint(header) {
  header.parentElement.classList.toggle('open');
  // scroll into view
  if (header.parentElement.classList.contains('open')) {
    setTimeout(() => header.parentElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
  }
}

// Handle anchor links from sidebar
document.querySelectorAll('#sidebar nav a').forEach(a => {
  a.addEventListener('click', function(e) {
    var id = this.getAttribute('href').slice(1);
    var el = document.getElementById(id);
    if (el) {
      e.preventDefault();
      if (!el.classList.contains('open')) el.querySelector('.endpoint-header').click();
      setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 80);
    }
  });
});

// ── HTTP Helpers ──────────────────────────────────────────────────────────
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function showLoading(btn) {
  btn.disabled = true;
  btn.textContent = 'Loading...';
  var box = btn.nextElementSibling;
  box.className = 'response-box visible';
  box.innerHTML = '<div class="response-header loading">⏳ Mengirim request...</div>';
}

function showResponse(btn, status, data, ms) {
  btn.disabled = false;
  btn.textContent = 'Execute';
  var box = btn.nextElementSibling;
  var isOk = status >= 200 && status < 300;
  var cls  = isOk ? 'ok' : 'error';
  var pretty = typeof data === 'string' ? data : JSON.stringify(data, null, 2);
  box.innerHTML =
    '<div class="response-header ' + cls + '">' +
      '<span class="response-code">' + status + '</span>' +
      '<span class="response-time">' + ms + 'ms</span>' +
    '</div>' +
    '<pre class="response-pre">' + escHtml(pretty) + '</pre>';
}

function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

async function execGet(btn, url) {
  showLoading(btn);
  var t = Date.now();
  try {
    var r = await fetch(url, { headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
    var data = await r.json();
    showResponse(btn, r.status, data, Date.now() - t);
  } catch(e) {
    showResponse(btn, 0, 'Error: ' + e.message, Date.now() - t);
  }
}

async function execPost(btn, url, textareaId) {
  var raw = document.getElementById(textareaId).value;
  var body;
  try { body = JSON.parse(raw); } catch(e) { alert('JSON tidak valid: ' + e.message); return; }
  showLoading(btn);
  var t = Date.now();
  try {
    var r = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
      body: JSON.stringify(body)
    });
    var data = await r.json();
    showResponse(btn, r.status, data, Date.now() - t);
  } catch(e) {
    showResponse(btn, 0, 'Error: ' + e.message, Date.now() - t);
  }
}

async function execPut(btn, url, textareaId) {
  var raw = document.getElementById(textareaId).value;
  var body;
  try { body = JSON.parse(raw); } catch(e) { alert('JSON tidak valid: ' + e.message); return; }
  showLoading(btn);
  var t = Date.now();
  try {
    var r = await fetch(url, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
      body: JSON.stringify(body)
    });
    var data = await r.json();
    showResponse(btn, r.status, data, Date.now() - t);
  } catch(e) {
    showResponse(btn, 0, 'Error: ' + e.message, Date.now() - t);
  }
}

// ── Cek token cache on load ───────────────────────────────────────────────
fetch('/satusehat/token', { headers: { 'Accept': 'application/json' } })
  .then(r => r.json())
  .then(d => {
    var cached = d.from_cache;
    document.getElementById('token-cache-status').textContent = cached ? '✅ Ada di cache' : '⚠️ Belum ada';
    document.getElementById('cache-dot').style.background = cached ? '#22c55e' : '#f59e0b';
    document.getElementById('cache-label').textContent = cached ? 'Token aktif (cache)' : 'Token belum ada';
  })
  .catch(() => {
    document.getElementById('token-cache-status').textContent = '❌ Gagal cek';
  });

@endverbatim
</script>
</body>
</html>