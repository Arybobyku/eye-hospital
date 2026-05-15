# Dokumentasi Integrasi SatuSehat

> Sistem Informasi Rumah Sakit Mata — Integrasi FHIR R4 dengan Platform SatuSehat (Kemenkes RI)

---

## Daftar Isi

1. [Overview](#1-overview)
2. [Konfigurasi Environment](#2-konfigurasi-environment)
3. [Skema Database](#3-skema-database)
4. [Arsitektur Service Layer](#4-arsitektur-service-layer)
5. [Menu & Halaman Dashboard](#5-menu--halaman-dashboard)
6. [Artisan Commands](#6-artisan-commands)
7. [Scheduler (Otomatis)](#7-scheduler-otomatis)
8. [Flow Teknis Lengkap](#8-flow-teknis-lengkap)
9. [API Logging](#9-api-logging)
10. [Troubleshooting](#10-troubleshooting)

---

## 1. Overview

Integrasi SatuSehat memungkinkan SIMRS mengirimkan data klinis ke platform nasional Kemenkes RI sesuai standar **FHIR R4**. Resource yang di-implementasikan:

| FHIR Resource | Fungsi | Sumber Data Lokal |
|---|---|---|
| `Patient` | Daftarkan / cari pasien di SatuSehat | Tabel `pasien` (NIK) |
| `Encounter` | Kirim data kunjungan/registrasi | Tabel `registrasi` |
| `Organization` | Profil rumah sakit | Konfigurasi env |
| `Location` | Data poli/ruangan | Konfigurasi env |

---

## 2. Konfigurasi Environment

Tambahkan variabel berikut di file `.env`:

```env
# ── Credentials OAuth2 ────────────────────────────────────────────
CLIENT_ID_SATUSEHAT=<client_id_dari_portal_satusehat>
CLIENT_SECRET_SATUSEHAT=<client_secret_dari_portal_satusehat>

# ── URL API ───────────────────────────────────────────────────────
# Staging
API_SATUSEHAT_AUTH=https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/
API_SATUSEHAT_BASE=https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/

# Production
# API_SATUSEHAT_AUTH=https://api-satusehat.kemkes.go.id/oauth2/v1/
# API_SATUSEHAT_BASE=https://api-satusehat.kemkes.go.id/fhir-r4/v1/

# Masterdata (diturunkan otomatis dari BASE URL, tidak perlu diisi manual)
# API_SATUSEHAT_MASTERDATA=https://api-satusehat-stg.dto.kemkes.go.id/masterdata/v1/

# ── Identitas Fasilitas ───────────────────────────────────────────
SATUSEHAT_ORGANIZATION_ID=<org_id_dari_portal_satusehat>
SATUSEHAT_LOCATION_ID=<location_id_default_poli>
```

> **URL Masterdata** diturunkan otomatis dari `API_SATUSEHAT_BASE` dengan mengganti path `/fhir-r4/v1/` menjadi `/masterdata/v1/`. Override dengan `API_SATUSEHAT_MASTERDATA` jika berbeda.

---

## 3. Skema Database

### 3.1 Migrasi yang Ditambahkan

Jalankan seluruh migrasi berikut secara berurutan:

```bash
php artisan migrate
```

| File Migrasi | Perubahan |
|---|---|
| `2026_05_13_000001_create_satusehat_wilayah_table` | Buat tabel `satusehat_wilayah` |
| `2026_05_13_000002_add_ss_area_codes_to_pasien` | Tambah kolom `ss_*_code` ke `pasien` |
| `2026_05_13_000003_create_satusehat_api_logs_table` | Buat tabel `satusehat_api_logs` |
| `2026_05_13_000004_seed_satusehat_wilayah_label` | Label menu Wilayah |
| `2026_05_13_000005_seed_satusehat_apilog_label` | Label menu API Logs |
| `2026_05_13_000006_add_satusehat_code_to_wilayah_master` | Kolom `satusehat_code` ke tabel master wilayah |

Atau jalankan langsung SQL-nya (untuk PostgreSQL):

```bash
psql -d <database> -f database/sql/satu-sehat.sql
```

### 3.2 Kolom Tambahan pada Tabel Existing

**Tabel `pasien`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id_satu_sehat` | `VARCHAR(50)` | IHS Number dari SatuSehat |
| `satusehat_sync_status` | `VARCHAR(20)` | `synced` / `not_found` / `failed` / NULL |
| `satusehat_synced_at` | `TIMESTAMP` | Waktu terakhir sync berhasil |
| `ss_province_code` | `VARCHAR(20)` | Kode BPS provinsi (override manual) |
| `ss_city_code` | `VARCHAR(20)` | Kode BPS kota/kabupaten (override manual) |
| `ss_district_code` | `VARCHAR(20)` | Kode BPS kecamatan (override manual) |
| `ss_subdistrict_code` | `VARCHAR(20)` | Kode BPS kelurahan/desa (override manual) |

**Tabel `registrasi`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `satusehat_encounter_id` | `VARCHAR(64)` | Encounter ID dari SatuSehat |
| `satusehat_encounter_status` | `VARCHAR(20)` | `synced` / `failed` / NULL |
| `satusehat_encounter_synced_at` | `TIMESTAMP` | Waktu sync encounter |
| `satusehat_location_id` | `VARCHAR(64)` | Location ID poli yang dikaitkan |

**Tabel `pengguna`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `satusehat_ihs_id` | `VARCHAR(64)` | IHS Practitioner ID dokter |

**Tabel master wilayah (`provinsi`, `kab_kota`, `kecamatan`, `kelurahan`):**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `satusehat_code` | `VARCHAR(20)` | Kode BPS SatuSehat hasil sync wilayah |

### 3.3 Tabel Baru

**`satusehat_wilayah`** — Cache kode wilayah BPS dari SatuSehat Masterdata API:

```sql
id          BIGSERIAL PRIMARY KEY
level       VARCHAR(20)   -- 'province' | 'city' | 'district' | 'sub_district'
code        VARCHAR(20) UNIQUE  -- kode BPS: '31', '3171', '317101', '3171010001'
name        VARCHAR(255)  -- nama wilayah, contoh: 'DKI JAKARTA'
parent_code VARCHAR(20)   -- kode parent (NULL untuk provinsi)
raw_data    JSONB         -- response mentah dari API
fetched_at  TIMESTAMP     -- kapan terakhir di-fetch
```

**`satusehat_api_logs`** — Log semua request/response ke SatuSehat API:

```sql
id            BIGSERIAL PRIMARY KEY
method        VARCHAR(10)   -- GET | POST | PUT | PATCH
url           TEXT          -- URL lengkap yang dipanggil
request_body  TEXT          -- body request (JSON)
response_body TEXT          -- body response dari API
http_code     SMALLINT      -- kode HTTP response (200, 201, 400, dll)
context       VARCHAR(100)  -- 'patient_sync' | 'encounter_sync' | 'wilayah' | 'other'
duration_ms   INTEGER       -- lama eksekusi dalam milidetik
is_success    BOOLEAN       -- true jika http_code 2xx
created_at    TIMESTAMP
```

---

## 4. Arsitektur Service Layer

```
app/Services/SatuSehat/
├── Config/
│   └── ConfigSatusehat.php        # Baca .env, sediakan semua URL & credentials
├── Foundation/
│   ├── Http/
│   │   └── Authentication.php     # OAuth2 client_credentials token
│   └── Handler/
│       └── SimpleCurlFactory.php  # HTTP executor (cURL), capture lastHttpCode
└── Bridge/
    ├── BridgeBase.php             # Base class: getJson/postJson/putJson + logging
    └── BridgeMasterdata.php       # Override baseUrl() ke /masterdata/v1/
```

### BridgeBase — Cara Kerja

Setiap method `getJson()`, `postJson()`, `putJson()` memanggil `callWithLog()` yang:

1. Catat waktu mulai (`microtime`)
2. Eksekusi HTTP request via `SimpleCurlFactory`
3. Capture `http_code` via `curl_getinfo(CURLINFO_HTTP_CODE)`
4. Insert log ke tabel `satusehat_api_logs`
5. Return decoded JSON array

```php
// Contoh penggunaan di controller
$bridge = new BridgeBase();
$bridge->logContext = 'patient_sync';   // label untuk kolom context di log

$result = $bridge->getJson('Patient?identifier=...');
$result = $bridge->postJson('Encounter', $payload);
```

### ConfigSatusehat — Derivasi URL Masterdata

```php
// Input  : API_SATUSEHAT_BASE=https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/
// Output : https://api-satusehat-stg.dto.kemkes.go.id/masterdata/v1/
$parsed = parse_url($this->urlBase);
$defaultMasterdata = $parsed['scheme'] . '://' . $parsed['host'] . '/masterdata/v1/';
```

---

## 5. Menu & Halaman Dashboard

Semua halaman diakses dari `/dashboard/satusehat-*`.

### 5.1 Token (`/dashboard/satusehat-token`)

Halaman untuk memantau dan me-refresh access token OAuth2.

- Tampilkan status token (aktif/expired), `client_id`, waktu expire
- Tombol **Refresh Token** memanggil `POST /satusehat-api/token/refresh`
- Token di-cache oleh `Authentication.php` — tidak disimpan di DB

**Controller:** `TokenCtrl`
**Routes:** `POST /satusehat-api/token/status`, `POST /satusehat-api/token/refresh`

### 5.2 Organization (`/dashboard/satusehat-organization`)

Kelola profil Organization FHIR rumah sakit.

- Lihat profil Organization yang sudah terdaftar di SatuSehat
- Tambah / Edit Organization
- Organization ID disimpan di `.env` sebagai `SATUSEHAT_ORGANIZATION_ID`

**Controller:** `OrganizationCtrl`
**Routes:** `POST /satusehat-api/organization/{profile|list|add|edit|update}`

### 5.3 Location (`/dashboard/satusehat-location`)

Kelola data Location FHIR (poli/ruangan).

- Lihat daftar Location terdaftar
- Tambah / Edit Location
- Location ID dapat dikaitkan ke `registrasi.satusehat_location_id`

**Controller:** `LocationCtrl`
**Routes:** `POST /satusehat-api/location/{profile|list|add|edit|update}`

### 5.4 Sync Pasien (`/dashboard/sync-pasien`)

Dashboard sinkronisasi data pasien → SatuSehat Patient resource.

**Statistik yang ditampilkan:**
- Total pasien, % sudah sync, synced, not_found, failed, pending
- Badge per baris: indikator kode wilayah tersedia/tidak

**Aksi tersedia:**

| Aksi | Keterangan |
|---|---|
| **Run Sync** | Jalankan `Artisan::call('satusehat:sync-patient')` via UI |
| **Retry Failed** | Reset status `failed` → NULL agar ikut batch berikutnya |
| **Create NIK** | Sync satu pasien secara manual (create ke SatuSehat) |
| **Create NIK IBU** | Sync menggunakan NIK Ibu (untuk bayi tanpa NIK) |

**Status nilai pasien:**

| Status | Arti |
|---|---|
| `synced` | IHS Number berhasil didapat, tersimpan di `id_satu_sehat` |
| `not_found` | NIK tidak ditemukan di SatuSehat (skip permanen) |
| `failed` | Error sementara, akan di-retry scheduler berikutnya |
| NULL | Belum pernah diproses |

**Indikator Wilayah (badge hijau/kuning):**

Setiap baris menampilkan badge apakah payload address pasien akan menyertakan `administrativeCode`. Badge hijau jika:
- Ada nilai di `ss_province_code` + `ss_city_code` pada record pasien, **ATAU**
- `provinsi.satusehat_code` + `kab_kota.satusehat_code` sudah terisi via FK

**Controller:** `PatientSyncCtrl`
**Routes:** `POST /satusehat-api/patient-sync/{dashboard|list|run-sync|retry-failed|create-one|create-bulk}`

### 5.5 Sync Encounter (`/dashboard/satusehat-encounter`)

Dashboard sinkronisasi kunjungan → SatuSehat Encounter resource.

**Statistik yang ditampilkan:**
- Total registrasi, synced, failed, pending, not_eligible (pasien belum sync)

**Aksi tersedia:**

| Aksi | Keterangan |
|---|---|
| **Run Sync** | Jalankan `Artisan::call('satusehat:sync-encounter')` via UI |
| **Retry Failed** | Reset status `failed` → NULL |
| **Set Location** | Kaitkan `satusehat_location_id` ke satu atau banyak registrasi |
| **Sync One** | Sync satu encounter secara manual |

**Syarat encounter bisa di-sync:**
- Pasien harus sudah memiliki `id_satu_sehat` (sudah sync Patient terlebih dahulu)
- `satusehat_encounter_id` masih NULL

**Controller:** `EncounterSyncCtrl`
**Routes:** `POST /satusehat-api/encounter-sync/{dashboard|list|run-sync|retry-failed|set-location|sync-one}`

### 5.6 Wilayah (`/dashboard/satusehat-wilayah`)

Dashboard untuk fetch dan kelola kode BPS administratif dari SatuSehat Masterdata API.

**Panel Fetch Semua:**

Satu tombol **Fetch Semua** yang secara otomatis:
1. Fetch semua Provinsi (34 data)
2. Fetch Kota/Kabupaten dari setiap Provinsi (~500+ data)
3. Fetch Kecamatan dari setiap Kota (opsional, dicentang by default, ~7.000+ data)
4. Fetch Kelurahan/Desa dari setiap Kecamatan (opsional, nonaktif by default, ~80.000+ data)

Opsi checkbox tersedia untuk mengaktifkan/menonaktifkan level kecamatan dan kelurahan. Proses berjalan di background (server-side `set_time_limit(600)`). Log per-step ditampilkan setelah selesai dalam panel terminal.

**Panel Sync ke Master Data:**

Tombol **Sync Semua ke Master** mencocokkan nama wilayah di cache SatuSehat ke tabel master lokal (`provinsi`, `kab_kota`, `kecamatan`, `kelurahan`) dan mengisi kolom `satusehat_code`.

Aturan matching:
1. Exact match (case-insensitive)
2. Partial string contains (fallback)
3. Hanya record yang `satusehat_code IS NULL` yang diupdate

Tersedia juga tombol sync per level (Provinsi / Kota / Kecamatan / Kelurahan) untuk kontrol granular.

**Fetch Manual per Level:** Panel collapsible untuk fetch satu kota atau satu kecamatan tertentu.

**Stats Cards:** Jumlah data ter-cache per level.

**Controller:** `WilayahCtrl`
**Routes:**

```
POST /satusehat-api/wilayah/dashboard
POST /satusehat-api/wilayah/list
POST /satusehat-api/wilayah/fetch
POST /satusehat-api/wilayah/fetch-all
POST /satusehat-api/wilayah/select
POST /satusehat-api/wilayah/sync-to-master
POST /satusehat-api/wilayah/sync-all-to-master
POST /satusehat-api/wilayah/master-stats
```

### 5.7 API Logs (`/dashboard/satusehat-api-logs`)

Viewer untuk semua log request/response ke SatuSehat API.

**Fitur:**
- Filter berdasarkan method (GET/POST/PUT/PATCH), context, status (sukses/gagal), pencarian URL
- Klik baris untuk expand melihat request body dan response body (pretty-printed JSON)
- Stats: total request, sukses, gagal, rata-rata durasi, breakdown per context
- Tombol **Hapus Log Lama** (> 30 hari) dan **Hapus Semua**

**Context values:**

| Context | Sumber |
|---|---|
| `patient_sync` | Semua request dari `PatientSyncCtrl` |
| `encounter_sync` | Semua request dari `EncounterSyncCtrl` |
| `wilayah` | Semua request dari `BridgeMasterdata` |
| `other` | Default jika tidak di-set |

**Controller:** `ApiLogCtrl`
**Routes:** `POST /satusehat-api/api-logs/{dashboard|list|detail|clear|clear-all}`

---

## 6. Artisan Commands

### 6.1 `satusehat:sync-patient`

Sinkronisasi IHS Number untuk pasien berdasarkan NIK.

```bash
php artisan satusehat:sync-patient
php artisan satusehat:sync-patient --batch=100 --delay=500
```

**Options:**

| Option | Default | Keterangan |
|---|---|---|
| `--batch` | `50` | Jumlah pasien diproses per iterasi |
| `--delay` | `300` | Delay antar request dalam milidetik (hindari rate-limit) |

**Logika:**
1. Query pasien: `no_identitas NOT NULL`, `id_satu_sehat IS NULL`, status bukan `synced`/`not_found`
2. Validasi format NIK: harus 16 digit angka
3. Panggil `GET Patient?identifier=https://fhir.kemkes.go.id/id/nik|{NIK}`
4. Jika ditemukan → simpan `id_satu_sehat`, set status `synced`
5. Jika tidak ditemukan → set status `not_found` (skip permanen)
6. Jika error → set status `failed` (akan di-retry)

**Log output:** `storage/logs/satusehat-sync-patient.log`

### 6.2 `satusehat:sync-encounter`

Kirim data Encounter (kunjungan) ke SatuSehat.

```bash
php artisan satusehat:sync-encounter
php artisan satusehat:sync-encounter --batch=20 --delay=500
```

**Options:**

| Option | Default | Keterangan |
|---|---|---|
| `--batch` | `30` | Jumlah encounter diproses per iterasi |
| `--delay` | `300` | Delay antar request dalam milidetik |

**Logika:**
1. Query registrasi: `satusehat_encounter_id IS NULL`, status NULL atau `failed`
2. JOIN ke `pasien` dan `pengguna` untuk ambil `patient_ihs_id` dan `practitioner_ihs_id`
3. Jika `patient_ihs_id` kosong → lewati (pasien belum sync), coba lagi berikutnya
4. Build FHIR Encounter payload (lihat section 8.3)
5. Panggil `POST Encounter`
6. Jika berhasil → simpan `satusehat_encounter_id`, set status `synced`
7. Jika gagal → set status `failed`

**Log output:** `storage/logs/satusehat-sync-encounter.log`

---

## 7. Scheduler (Otomatis)

Didefinisikan di `app/Console/Kernel.php`. Aktifkan dengan menambahkan cron job di server:

```bash
# Tambahkan ke crontab (crontab -e)
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

**Jadwal yang sudah dikonfigurasi:**

| Command | Frekuensi | Overlap | Log File |
|---|---|---|---|
| `satusehat:sync-patient --batch=50 --delay=300` | Setiap jam | `withoutOverlapping` | `satusehat-sync-patient.log` |
| `satusehat:sync-encounter --batch=30 --delay=300` | Setiap 30 menit | `withoutOverlapping` | `satusehat-sync-encounter.log` |

`withoutOverlapping()` memastikan tidak ada dua proses sync yang berjalan bersamaan.

**Periksa jadwal yang berjalan:**

```bash
php artisan schedule:list
php artisan schedule:run --verbose   # jalankan manual sekali
```

---

## 8. Flow Teknis Lengkap

### 8.1 Flow Sinkronisasi Pasien (IHS Number)

```
Cron (tiap jam)
    └─► php artisan satusehat:sync-patient
            │
            ├─► ConfigSatusehat::__construct()     // baca .env
            ├─► Authentication::getToken()          // POST OAuth2 token
            └─► Loop pasien (batch=50)
                    │
                    ├─► Validasi NIK (16 digit)
                    │
                    └─► BridgeBase::getJson(
                            "Patient?identifier=.../nik|{NIK}"
                        )
                            │
                            ├─► SimpleCurlFactory::request()   // HTTP GET
                            ├─► capture lastHttpCode
                            ├─► INSERT satusehat_api_logs
                            └─► return decoded JSON
                                    │
                                    ├─► total > 0 → UPDATE pasien
                                    │       id_satu_sehat = entry[0].resource.id
                                    │       status = 'synced'
                                    │
                                    ├─► total = 0 → status = 'not_found'
                                    └─► exception → status = 'failed'
```

### 8.2 Flow Sinkronisasi Encounter

```
Cron (tiap 30 menit)
    └─► php artisan satusehat:sync-encounter
            │
            ├─► ConfigSatusehat + Authentication (token)
            └─► Loop registrasi (batch=30)
                    │
                    ├─► pasien.id_satu_sehat kosong? → SKIP (retry berikutnya)
                    │
                    └─► buildPayload(registrasi, orgId)
                            │
                            ├─► resourceType: Encounter
                            ├─► subject: Patient/{patient_ihs_id}
                            ├─► participant: Practitioner/{practitioner_ihs_id}  [jika ada]
                            ├─► location: Location/{satusehat_location_id}       [jika ada]
                            ├─► period.start: tanggal + waktu + "+07:00"
                            └─► serviceProvider: Organization/{orgId}
                                    │
                                    └─► BridgeBase::postJson("Encounter", payload)
                                            │
                                            ├─► INSERT satusehat_api_logs
                                            └─► response.id ada?
                                                    ├─► Ya  → status = 'synced'
                                                    └─► Tidak → status = 'failed'
```

### 8.3 Payload FHIR Patient — Address Extension

Saat create/update Patient di SatuSehat, address administrativeCode diisi dengan kode BPS. Prioritas sumber kode:

```
Prioritas 1: pasien.ss_province_code (kolom override manual)
     ↓ jika NULL
Prioritas 2: provinsi.satusehat_code  (via FK pasien.provinsi_id)
     ↓ jika NULL
Tidak sertakan extension address
```

```json
{
  "address": [{
    "extension": [{
      "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
      "extension": [
        { "url": "province",     "valueCode": "31" },
        { "url": "city",         "valueCode": "3171" },
        { "url": "district",     "valueCode": "317101" },
        { "url": "village",      "valueCode": "3171010001" }
      ]
    }]
  }]
}
```

Extension hanya disertakan jika minimal `province` + `city` terisi.

### 8.4 Flow Fetch Wilayah (BPS Cache)

```
User klik "Fetch Semua" di /dashboard/satusehat-wilayah
    │
    └─► POST /satusehat-api/wilayah/fetch-all
            │
            ├─► set_time_limit(600)
            ├─► BridgeMasterdata::__construct()
            │       └─► baseUrl() = ConfigSatusehat::getUrlMasterdata()
            │                     = https://...kemkes.go.id/masterdata/v1/
            │
            ├─► [Step 1] getProvinces()
            │       GET masterdata/v1/wilayah/provinsi
            │       → upsert ke satusehat_wilayah (level='province')
            │
            ├─► [Step 2] For each provinceCode:
            │       getCities(provinceCode)
            │       GET masterdata/v1/wilayah/kota?provinsi_id={code}
            │       → upsert ke satusehat_wilayah (level='city')
            │
            ├─► [Step 3] if with_district=true:
            │       For each cityCode:
            │           getDistricts(cityCode)
            │           → upsert ke satusehat_wilayah (level='district')
            │
            ├─► [Step 4] if with_subdistrict=true:
            │       For each districtCode:
            │           getSubDistricts(districtCode)
            │           → upsert ke satusehat_wilayah (level='sub_district')
            │
            └─► return { log: [...], total: {...}, message: "..." }
```

### 8.5 Flow Sync Wilayah ke Master Data Lokal

```
User klik "Sync Semua ke Master"
    │
    └─► POST /satusehat-api/wilayah/sync-all-to-master
            │
            └─► For each level in [province, city, district, sub_district]:
                    │
                    ├─► Load ssCodes dari satusehat_wilayah
                    │       keyBy: strtoupper(name) → {code, name}
                    │
                    ├─► Load localItems dari tabel master
                    │       WHERE delete_soft=1 AND satusehat_code IS NULL
                    │
                    └─► For each localItem:
                            ├─► Exact match? (strtoupper)
                            │       → UPDATE satusehat_code = ssItem.code
                            │
                            └─► Partial match? (str_contains)
                                    → UPDATE satusehat_code = ssItem.code
```

---

## 9. API Logging

Semua request/response ke SatuSehat API dicatat otomatis tanpa kode tambahan di controller.

**Cara kerja:** `BridgeBase::callWithLog()` dipanggil oleh setiap `getJson()`, `postJson()`, `putJson()`.

**Mengubah context log di controller:**

```php
$bridge = new BridgeBase();
$bridge->logContext = 'patient_sync';   // label bebas
```

**Menonaktifkan logging (opsional):**

```php
$bridge->enableLogging = false;
```

**Melihat log via UI:** `/dashboard/satusehat-api-logs`

**Query manual di database:**

```sql
-- 10 request terakhir yang gagal
SELECT method, url, http_code, context, duration_ms, created_at
FROM satusehat_api_logs
WHERE is_success = false
ORDER BY created_at DESC
LIMIT 10;

-- Rata-rata durasi per context
SELECT context, COUNT(*) as total, ROUND(AVG(duration_ms)) as avg_ms
FROM satusehat_api_logs
GROUP BY context
ORDER BY total DESC;
```

---

## 10. Troubleshooting

### Token expired / 401 Unauthorized

Token OAuth2 di-cache dalam memory per request. Jika expired, sistem akan otomatis request token baru saat `Authentication::getToken()` dipanggil. Jika tetap gagal, periksa `CLIENT_ID_SATUSEHAT` dan `CLIENT_SECRET_SATUSEHAT` di `.env`.

### Patient payload ditolak — "Code not found: '722'"

Artinya kode BPS kota/kabupaten tidak valid. Penyebab: kolom `satusehat_code` di tabel `kab_kota` belum terisi. Lakukan:
1. Fetch wilayah di `/dashboard/satusehat-wilayah` → **Fetch Semua**
2. Sync ke master → **Sync Semua ke Master**
3. Periksa tabel `kab_kota` — kolom `satusehat_code` harus sudah terisi

### Encounter ditolak — pasien tidak ditemukan

Pastikan pasien sudah di-sync terlebih dahulu (kolom `id_satu_sehat` tidak NULL). Encounter tidak bisa dibuat tanpa `Patient` terdaftar di SatuSehat.

### Scheduler tidak berjalan

Pastikan cron sudah aktif:

```bash
crontab -l   # pastikan ada entry scheduler
php artisan schedule:run --verbose   # test manual
```

Periksa log:

```bash
tail -f storage/logs/satusehat-sync-patient.log
tail -f storage/logs/satusehat-sync-encounter.log
```

### Fetch Semua timeout

Default PHP `max_execution_time` bisa di-override paksa. Jika server menggunakan PHP-FPM yang membatasi waktu eksekusi via `request_terminate_timeout`, pertimbangkan untuk:
- Menonaktifkan fetch kelurahan (terlalu banyak, ratusan ribu data)
- Menjalankan `fetch-all` secara terjadwal via Artisan command terpisah daripada via HTTP request

### Melihat semua log error SatuSehat

```bash
grep "GAGAL\|failed\|error" storage/logs/satusehat-sync-patient.log
```

Atau via dashboard `/dashboard/satusehat-api-logs` dengan filter Status = Gagal.
