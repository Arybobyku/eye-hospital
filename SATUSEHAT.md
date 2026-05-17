# SATUSEHAT — Dokumentasi Integrasi

Dokumentasi teknis lengkap untuk modul integrasi **SatuSehat (FHIR R4)** pada sistem Eye Hospital.

---

## Daftar Isi

1. [Gambaran Umum](#1-gambaran-umum)
2. [Prasyarat & Konfigurasi](#2-prasyarat--konfigurasi)
3. [Skema Database](#3-skema-database)
4. [Arsitektur File](#4-arsitektur-file)
5. [Modul: Pasien](#5-modul-pasien)
6. [Modul: Practitioner (Pengguna)](#6-modul-practitioner-pengguna)
7. [Modul: Organization](#7-modul-organization)
8. [Modul: Location](#8-modul-location)
9. [Modul: Encounter (Registrasi)](#9-modul-encounter-registrasi)
10. [Modul: Wilayah (BPS Code)](#10-modul-wilayah-bps-code)
11. [Auto-Sync Pasien (LISTEN/NOTIFY)](#11-auto-sync-pasien-listennotify)
11b. [Auto-Sync Encounter/Registrasi (LISTEN/NOTIFY)](#11b-auto-sync-encounterregistrasi-listennotify)
12. [Shared Services](#12-shared-services)
13. [Referensi API Routes](#13-referensi-api-routes)
14. [Artisan Commands](#14-artisan-commands)
15. [Alur Kerja Lengkap (Onboarding)](#15-alur-kerja-lengkap-onboarding)
16. [Deployment Production](#16-deployment-production)
17. [Troubleshooting](#17-troubleshooting)

---

## 1. Gambaran Umum

Modul SatuSehat mengintegrasikan sistem Eye Hospital dengan platform **FHIR R4** milik Kementerian Kesehatan RI. Setiap resource FHIR dikirim melalui REST API SatuSehat menggunakan Bearer Token OAuth2.

### Fitur yang Tersedia

| Modul | Resource FHIR | Keterangan |
|-------|--------------|------------|
| Pasien | `Patient` | Sync NIK → IHS Number; auto-sync via PostgreSQL NOTIFY |
| Practitioner | `Practitioner` | Sync NIK dokter/nakes → IHS Practitioner ID |
| Organization | `Organization` | Sync & cache organisasi fasyankes dari SatuSehat |
| Location | `Location` | Sync & cache lokasi/ruangan dari SatuSehat |
| Encounter | `Encounter` | Kirim data kunjungan pasien (registrasi) ke SatuSehat |
| Wilayah | _(BPS Code lookup)_ | Cache kode administratif BPS untuk address mapping |

---

## 2. Prasyarat & Konfigurasi

### `.env` Variables

```env
# ── SatuSehat OAuth2 ──────────────────────────────────────────────────────────
SATUSEHAT_ENV=development          # development | staging | production
SATUSEHAT_CLIENT_ID=your-client-id
SATUSEHAT_CLIENT_SECRET=your-client-secret
SATUSEHAT_ORGANIZATION_ID=your-org-id   # FHIR Organization ID fasyankes Anda

# ── URL (otomatis ditentukan oleh BridgeBase berdasarkan SATUSEHAT_ENV) ───────
# development : https://api-satusehat-dev.dto.kemkes.go.id
# staging     : https://api-satusehat-stg.dto.kemkes.go.id
# production  : https://api-satusehat.dto.kemkes.go.id
```

### Setup Database

Jalankan migration SQL berikut (idempotent, aman dijalankan ulang):

```bash
psql -U postgres -d eye_hospital -f database/sql/satu-sehat.sql
```

---

## 3. Skema Database

### Kolom Tambahan pada Tabel Existing

**`pasien`**
```sql
id_satu_sehat          VARCHAR(50)   -- IHS Number hasil sync
satusehat_sync_status  VARCHAR(20)   -- null | synced | failed
satusehat_synced_at    TIMESTAMP
```

**`registrasi`**
```sql
satusehat_encounter_id         VARCHAR(64)   -- FHIR Encounter.id
satusehat_encounter_status     VARCHAR(20)
satusehat_encounter_synced_at  TIMESTAMP
satusehat_location_id          VARCHAR(64)   -- Location FHIR ID yang dipakai
```

**`pengguna`**
```sql
satusehat_ihs_id       VARCHAR(64)   -- IHS Practitioner ID
nik                    VARCHAR(20)
satusehat_sync_status  VARCHAR(20)
satusehat_synced_at    TIMESTAMP
```

**`provinsi` / `kab_kota` / `kecamatan` / `kelurahan`**
```sql
satusehat_code  VARCHAR(20)   -- Kode BPS SatuSehat
```

### Tabel Baru

| Tabel | Fungsi |
|-------|--------|
| `satusehat_wilayah` | Cache kode BPS dari API SatuSehat (province/city/district/subdistrict) |
| `satusehat_api_logs` | Log semua request/response API SatuSehat |
| `satusehat_locations` | Cache lokal FHIR Location resources |
| `satusehat_organizations` | Cache lokal FHIR Organization resources |

### Tabel `satusehat_organizations` (penting untuk Encounter)

```sql
CREATE TABLE satusehat_organizations (
    satusehat_id         VARCHAR(64)  NOT NULL UNIQUE,  -- FHIR Organization.id
    identifier_system    VARCHAR(500),                   -- Dipakai di Encounter.identifier[].system
    identifier_value     VARCHAR(255),                   -- Dipakai di Encounter.identifier[].value
    nama                 VARCHAR(500) NOT NULL DEFAULT '',
    aktif                BOOLEAN      DEFAULT TRUE,
    part_of              VARCHAR(64),                    -- Parent Organization FHIR ID
    ...
);
```

> **Catatan**: Kolom `identifier_system` dan `identifier_value` digunakan oleh `EncounterBuilder` untuk mengisi `identifier[0].system` pada payload Encounter — tanpa ini Encounter akan ditolak SatuSehat.

---

## 4. Arsitektur File

```
app/
├── Console/Commands/
│   ├── ListenPasienSatuSehat.php      # Daemon LISTEN pg_notify → dispatch job
│   └── SyncEncounterSatuSehat.php     # Scheduler bulk-sync Encounter
│
├── Http/Controllers/SatuSehat/
│   ├── BridgeBase.php                 # HTTP client (OAuth2 token, request wrapper)
│   ├── PatientSyncCtrl.php            # Sync Pasien: one-by-one & bulk
│   ├── PractitionerSyncCtrl.php       # Sync Practitioner (Pengguna/Dokter)
│   ├── OrganizationCtrl.php           # Sync & cache Organization dari SatuSehat
│   ├── LocationCtrl.php               # Sync & cache Location dari SatuSehat
│   ├── EncounterSyncCtrl.php          # Sync Encounter: one-by-one & bulk
│   └── WilayahCtrl.php                # Cache wilayah BPS
│
├── Jobs/
│   └── SyncPasienToSatuSehat.php      # Queue job: sync 1 pasien (idempoten)
│
├── Observers/
│   └── PasienObserver.php             # Eloquent hook: dispatch job saat Pasien dibuat
│
├── Providers/
│   └── AppServiceProvider.php         # Register observer + dokumentasi strategi dual-layer
│
└── Services/SatuSehat/
    ├── PatientBuilder.php             # Build FHIR Patient payload (static)
    └── EncounterBuilder.php           # Build FHIR Encounter payload (static)

config/supervisor/
└── satusehat-listener.conf            # Supervisor config untuk daemon LISTEN

database/sql/
└── satu-sehat.sql                     # DDL: ALTER TABLE, CREATE TABLE, trigger pg_notify

resources/js/components/satusehat/
├── patient/index.vue                  # UI sync pasien
├── practitioner/index.vue             # UI sync practitioner
├── organization/index.vue             # UI sync & status organization
├── location/index.vue                 # UI sync & status location
└── encounter/index.vue                # UI sync encounter

routes/
└── satusehat.php                      # Semua route /satusehat/...
```

---

## 5. Modul: Pasien

### Cara Kerja

1. Pasien baru dibuat (via Eloquent atau `DB::table()`)
2. **Auto-sync** terpicu (lihat [Bagian 11](#11-auto-sync-pasien-listennotify))
3. `SyncPasienToSatuSehat` job melakukan POST ke `/fhir-r4/v1/Patient`
4. Respons `id` dari SatuSehat disimpan ke `pasien.id_satu_sehat`

### FHIR Patient Payload (contoh)

```json
{
  "resourceType": "Patient",
  "meta": { "profile": ["https://fhir.kemkes.go.id/r4/StructureDefinition/Patient"] },
  "identifier": [
    {
      "use": "official",
      "system": "https://fhir.kemkes.go.id/id/nik",
      "value": "3273011234560001"
    }
  ],
  "name": [{ "use": "official", "text": "Budi Santoso" }],
  "gender": "male",
  "birthDate": "1990-01-15",
  "address": [{
    "use": "home",
    "line": ["Jl. Merdeka No. 1"],
    "city": "Kota Bandung",
    "postalCode": "40111",
    "country": "ID",
    "extension": [{
      "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
      "extension": [
        { "url": "province",    "valueCode": "32" },
        { "url": "city",        "valueCode": "3273" },
        { "url": "district",    "valueCode": "327301" },
        { "url": "village",     "valueCode": "3273011001" }
      ]
    }]
  }]
}
```

### Builder: `PatientBuilder::build($pasien, $method = 'nik')`

```php
use App\Services\SatuSehat\PatientBuilder;

$payload = PatientBuilder::build($pasien, 'nik');
```

- **`$method = 'nik'`**: Identifier menggunakan NIK (`https://fhir.kemkes.go.id/id/nik`)
- **`$method = 'ihs-number'`**: Identifier menggunakan IHS Number (untuk update)
- Gender mapping: `laki-laki/l → male`, `perempuan/p → female`
- Marital status: `menikah → M`, `belum → U`, `hidup_sendiri → D`, `mati → W`
- BPS code diambil via FK: `pasien.provinsi_id → provinsi.satusehat_code`

---

## 6. Modul: Practitioner (Pengguna)

Sync NIK dokter/tenaga kesehatan ke **IHS Practitioner ID** SatuSehat.

### Endpoint

```
POST /satusehat/practitioners/sync-one
POST /satusehat/practitioners/sync-all
GET  /satusehat/practitioners/sync-status
```

### Prasyarat

- `pengguna.nik` harus terisi (16 digit)
- Setelah sync berhasil: `pengguna.satusehat_ihs_id` diisi
- IHS Practitioner ID ini dipakai pada `Encounter.participant[].individual.reference`

---

## 7. Modul: Organization

Cache data Organization dari SatuSehat ke tabel `satusehat_organizations` lokal.

### Kenapa perlu di-cache?

Setiap Encounter membutuhkan `identifier[].system` yang nilainya adalah:
```
{parent.identifier[0].system}/{parent.identifier[0].value}
```
Tanpa cache lokal, setiap sync Encounter harus hit API SatuSehat terlebih dahulu.

### Cara Sync

1. Buka menu SatuSehat → Organization
2. Klik tombol **"Sync dari SatuSehat"**
3. Sistem fetch root org + semua sub-org via API
4. Data di-upsert ke `satusehat_organizations`

### Endpoint

```
POST /satusehat/organizations/sync        → jalankan sync
POST /satusehat/organizations/sync-status → cek total & last sync
```

---

## 8. Modul: Location

Cache data Location (ruangan/gedung) dari SatuSehat ke tabel `satusehat_locations` lokal.

### Cara Sync

Sama dengan Organization — buka UI Location, klik Sync.

### Endpoint

```
POST /satusehat/locations/sync        → jalankan sync
POST /satusehat/locations/sync-status → cek total & last sync
GET  /satusehat/locations/list        → daftar location untuk dropdown
```

Location yang tersimpan di lokal dipakai sebagai opsi di form Encounter saat memilih `satusehat_location_id`.

---

## 9. Modul: Encounter (Registrasi)

Kirim data kunjungan pasien (tabel `registrasi`) ke SatuSehat sebagai FHIR **Encounter**.

### Prasyarat

- `registrasi.satusehat_location_id` harus diisi (pilih dari dropdown Location)
- Pasien sudah punya `id_satu_sehat` (IHS Number)
- Dokter/nakes sudah punya `satusehat_ihs_id` (IHS Practitioner ID)
- Organization sudah di-sync (untuk `identifier_system`)

### FHIR Encounter Payload (ringkas)

```json
{
  "resourceType": "Encounter",
  "status": "finished",
  "class": { "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode", "code": "AMB" },
  "identifier": [{
    "system": "http://sys-ids.kemkes.go.id/encounter/{orgId}",
    "value": "REG-0001"
  }],
  "subject": { "reference": "Patient/{ihsNumber}", "display": "Nama Pasien" },
  "participant": [{
    "type": [{ "coding": [{ "system": "...", "code": "ATND" }] }],
    "individual": { "reference": "Practitioner/{ihsId}", "display": "dr. Nama" }
  }],
  "period": { "start": "2024-01-15T08:00:00+07:00", "end": "2024-01-15T09:00:00+07:00" },
  "location": [{ "location": { "reference": "Location/{locationId}" } }],
  "serviceProvider": { "reference": "Organization/{orgId}" }
}
```

### Builder: `EncounterBuilder::build($reg, $orgId)`

```php
use App\Services\SatuSehat\EncounterBuilder;

$payload = EncounterBuilder::build($reg, $orgId);
```

- Single source of truth — dipakai oleh **controller** (sync one) maupun **Artisan command** (bulk)
- `$reg` adalah object registrasi dari DB (dengan join pasien, dokter, dll.)
- Identifier system diambil dari `satusehat_organizations` lokal; fallback ke `http://sys-ids.kemkes.go.id/encounter/{orgId}`

### Endpoint

```
POST /satusehat/encounters/sync-one    → sync 1 registrasi (from Vue)
GET  /satusehat/encounters/sync-status → statistik pending/synced/failed
```

### Artisan Command (bulk scheduler)

```bash
php artisan satusehat:sync-encounter --limit=50 --days=7
```

---

## 10. Modul: Wilayah (BPS Code)

Cache kode administratif BPS (Provinsi/Kab-Kota/Kecamatan/Kelurahan) dari API SatuSehat.

### Cara Kerja

- `satusehat_wilayah` menyimpan semua level (`province`, `city`, `district`, `village`)
- Setelah cache terisi, kode BPS di-update ke tabel master wilayah lokal (`provinsi.satusehat_code`, dll.)
- `PatientBuilder` mengambil kode BPS dari FK relasi tabel master, bukan dari lookup real-time

### Endpoint

```
POST /satusehat/wilayah/fetch-province
POST /satusehat/wilayah/fetch-city
POST /satusehat/wilayah/fetch-district
POST /satusehat/wilayah/fetch-village
POST /satusehat/wilayah/update-master
```

---

## 11. Auto-Sync Pasien (LISTEN/NOTIFY)

### Arsitektur Dual-Layer

```
INSERT ke tabel pasien
        │
        ├─── via Eloquent (new Pasien()->save())
        │         │
        │         └── PasienObserver::created()
        │                   │
        │                   └── Bus::dispatchAfterResponse(SyncPasienToSatuSehat)
        │
        └─── via raw DB::table('pasien')->insert() ATAU Eloquent
                  │
                  └── PostgreSQL Trigger fn_notify_pasien_inserted()
                            │
                            └── pg_notify('satusehat_pasien_insert', payload_json)
                                      │
                                      └── ListenPasienSatuSehat daemon
                                                │
                                                └── SyncPasienToSatuSehat::dispatch(uuid)
```

**Kedua jalur dapat aktif bersamaan dengan aman** — `SyncPasienToSatuSehat::handle()` cek `id_satu_sehat` di awal; jika sudah terisi, skip tanpa hit API.

### Layer 1: PostgreSQL LISTEN/NOTIFY

**Trigger** (di `database/sql/satu-sehat.sql`):
```sql
CREATE OR REPLACE FUNCTION fn_notify_pasien_inserted()
RETURNS trigger AS $$
BEGIN
    IF NEW.delete_soft = 1
       AND NEW.no_identitas IS NOT NULL
       AND NEW.no_identitas <> ''
       AND NEW.id_satu_sehat IS NULL
    THEN
        PERFORM pg_notify(
            'satusehat_pasien_insert',
            json_build_object(
                'uuid',          NEW.uuid,
                'no_identitas',  NEW.no_identitas,
                'id_satu_sehat', NEW.id_satu_sehat,
                'delete_soft',   NEW.delete_soft
            )::text
        );
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_pasien_inserted
    AFTER INSERT ON pasien
    FOR EACH ROW EXECUTE FUNCTION fn_notify_pasien_inserted();
```

**Daemon** (`php artisan satusehat:listen-pasien`):
- Loop polling `pgsqlGetNotify()` dengan timeout 5 detik
- Saat notifikasi diterima → validasi NIK → `SyncPasienToSatuSehat::dispatch($uuid)`
- Graceful shutdown: SIGTERM/SIGINT set flag `$shouldStop = true`
- Auto-reconnect jika koneksi PostgreSQL putus

### Layer 2: Eloquent Observer (Fallback)

```php
// app/Observers/PasienObserver.php
public function created(Pasien $pasien): void
{
    if (!empty($pasien->id_satu_sehat)) return;
    if (!preg_match('/^\d{16}$/', trim($pasien->no_identitas ?? ''))) return;

    Bus::dispatchAfterResponse(new SyncPasienToSatuSehat($pasien->uuid));
}
```

- **`dispatchAfterResponse()`** — job dikirim setelah HTTP response selesai, tidak memblok request
- Aktif sebagai safety net saat daemon tidak berjalan

### Job: `SyncPasienToSatuSehat`

```php
// app/Jobs/SyncPasienToSatuSehat.php
class SyncPasienToSatuSehat implements ShouldQueue
{
    public int $tries   = 2;
    public array $backoff = [30, 120];  // retry setelah 30 detik, lalu 2 menit
    public int $timeout = 60;
}
```

**Alur `handle()`**:
1. Fetch pasien dari DB by UUID
2. Guard: `id_satu_sehat` sudah ada → return (idempoten)
3. Validasi NIK 16 digit
4. Build payload via `PatientBuilder::build($pasien)`
5. POST ke `/fhir-r4/v1/Patient`
6. Sukses (201): simpan `id_satu_sehat`, set `status = 'synced'`
7. Duplikat (409/422): GET existing IHS Number, update DB
8. Gagal: set `status = 'failed'`, throw exception (trigger retry)

---

## 11b. Auto-Sync Encounter/Registrasi (LISTEN/NOTIFY)

### Arsitektur Dual-Layer (sama dengan Pasien)

```
INSERT / UPDATE ke tabel registrasi
        │
        ├─── via Eloquent (new Registrasi()->save() / $reg->update([...]))
        │         │
        │         └── RegistrasiObserver::created() / updated()
        │                   │
        │                   └── Bus::dispatchAfterResponse(SyncEncounterToSatuSehat)
        │
        └─── via raw DB::table('registrasi')->insert/update ATAU Eloquent
                  │
                  └── PostgreSQL Trigger fn_notify_registrasi_upsert()
                            │
                            └── pg_notify('satusehat_registrasi_upsert', payload_json)
                                      │
                                      └── ListenRegistrasiSatuSehat daemon
                                                │
                                                └── SyncEncounterToSatuSehat::dispatch(uuid)
```

### Kondisi Trigger Notifikasi

**INSERT**: Selalu kirim notifikasi jika `delete_soft = 1`

**UPDATE**: Kirim notifikasi jika `delete_soft = 1` DAN encounter belum/gagal sync, DAN salah satu field relevan berubah:
- `satusehat_location_id` berubah (baru diisi)
- `satusehat_encounter_status` berubah (di-reset untuk retry)
- `pasien_uuid` atau `pengguna_uuid` berubah
- `tanggal` atau `waktu` berubah

Ini berarti update yang tidak relevan (misal ubah catatan/diagnosis) tidak memicu notifikasi yang tidak perlu.

### Status Encounter

| Status | Keterangan |
|--------|------------|
| `null` | Belum pernah diproses |
| `waiting_patient` | Pasien belum punya IHS Number — tunggu sync pasien |
| `no_location` | `satusehat_location_id` belum diisi |
| `synced` | Berhasil dikirim ke SatuSehat |
| `failed` | Gagal — akan di-retry oleh queue (maks 3x) |

### Status `waiting_patient` — Alur Lengkap

Skenario umum: pasien baru didaftarkan bersamaan dengan registrasi.

1. INSERT ke `pasien` → trigger pasien → job `SyncPasienToSatuSehat` dispatch
2. INSERT ke `registrasi` → trigger registrasi → job `SyncEncounterToSatuSehat` dispatch
3. Job encounter berjalan: pasien belum punya `id_satu_sehat` → status `waiting_patient`
4. Job pasien selesai: `id_satu_sehat` terisi
5. Setelah pasien di-sync, **jalankan sync encounter manual** dari UI atau scheduler untuk pick up status `waiting_patient`

> Untuk otomatisasi penuh, aktifkan trigger UPDATE pada pasien yang memicu re-dispatch encounter yang `waiting_patient`. Lihat catatan di bagian trigger.

### Job: `SyncEncounterToSatuSehat`

```php
class SyncEncounterToSatuSehat implements ShouldQueue
{
    public int $tries   = 3;
    public array $backoff = [30, 120, 300];  // retry 30 detik, 2 menit, 5 menit
    public int $timeout = 60;
}
```

**Alur `handle()`**:
1. Fetch registrasi + join pasien, pengguna
2. Guard: `satusehat_encounter_id` terisi & status `synced` → skip
3. Guard: pasien belum punya `id_satu_sehat` → status `waiting_patient`, return
4. Guard: `satusehat_location_id` kosong → status `no_location`, return
5. Build payload via `EncounterBuilder::build($reg, $orgId)`
6. POST ke SatuSehat
7. Sukses: simpan `satusehat_encounter_id`, status `synced`
8. Duplikat: GET existing Encounter ID, update DB
9. Gagal: status `failed`, throw untuk retry

### Artisan Command

```bash
# Development
php artisan satusehat:listen-registrasi

# Dengan opsi
php artisan satusehat:listen-registrasi --timeout=5000 --max-jobs=1000
```

### Supervisor (Production)

File: `config/supervisor/satusehat-registrasi-listener.conf`

```bash
sudo cp config/supervisor/satusehat-registrasi-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-registrasi-listener
```

---

## 12. Shared Services

### `PatientBuilder` — `app/Services/SatuSehat/PatientBuilder.php`

```php
PatientBuilder::build(object $pasien, string $method = 'nik'): array
```

Membangun FHIR Patient payload. Logika di sini adalah **single source of truth** untuk semua kode yang perlu membangun Patient payload — baik sync one, sync bulk, maupun job auto-sync.

### `EncounterBuilder` — `app/Services/SatuSehat/EncounterBuilder.php`

```php
EncounterBuilder::build(object $reg, string $orgId): array
```

Membangun FHIR Encounter payload. Digunakan oleh:
- `EncounterSyncCtrl::syncOne()` — sync dari UI Vue
- `SyncEncounterSatuSehat::handle()` — bulk sync via Artisan scheduler

Keduanya memanggil `EncounterBuilder::build()` sehingga perubahan payload cukup dilakukan di satu tempat.

### `BridgeBase` — `app/Http/Controllers/SatuSehat/BridgeBase.php`

Base class untuk semua controller SatuSehat. Menyediakan:
- `getToken()` — OAuth2 client credentials, dengan cache
- `request(method, endpoint, payload)` — wrapper HTTP call + logging ke `satusehat_api_logs`
- Base URL otomatis berdasarkan `SATUSEHAT_ENV`

---

## 13. Referensi API Routes

File: `routes/satusehat.php`

### Pasien

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/patients/sync-one` | Sync 1 pasien by UUID |
| `POST` | `/satusehat/patients/sync-all` | Bulk sync semua pasien belum sync |
| `GET`  | `/satusehat/patients/sync-status` | Statistik sync pasien |

### Practitioner

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/practitioners/sync-one` | Sync 1 pengguna |
| `POST` | `/satusehat/practitioners/sync-all` | Bulk sync |
| `GET`  | `/satusehat/practitioners/sync-status` | Statistik |

### Organization

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/organizations/sync` | Sync & cache dari SatuSehat |
| `POST` | `/satusehat/organizations/sync-status` | Total & last sync |

### Location

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/locations/sync` | Sync & cache dari SatuSehat |
| `POST` | `/satusehat/locations/sync-status` | Total & last sync |
| `GET`  | `/satusehat/locations/list` | Daftar untuk dropdown |

### Encounter

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/encounters/sync-one` | Sync 1 registrasi |
| `GET`  | `/satusehat/encounters/sync-status` | Statistik |

### Wilayah

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/wilayah/fetch-province` | Fetch & cache provinsi |
| `POST` | `/satusehat/wilayah/fetch-city` | Fetch & cache kab/kota |
| `POST` | `/satusehat/wilayah/fetch-district` | Fetch & cache kecamatan |
| `POST` | `/satusehat/wilayah/fetch-village` | Fetch & cache kelurahan |
| `POST` | `/satusehat/wilayah/update-master` | Update satusehat_code di tabel master lokal |

---

## 14. Artisan Commands

### `satusehat:listen-pasien`

```bash
php artisan satusehat:listen-pasien [--timeout=5000] [--max-jobs=1000]
```

| Option | Default | Keterangan |
|--------|---------|------------|
| `--timeout` | `5000` | Timeout polling pg_notify (ms) |
| `--max-jobs` | `1000` | Restart daemon setelah N job (cegah memory leak) |

**Catatan**: Di production, jalankan via Supervisor — lihat `config/supervisor/satusehat-listener.conf`.

### `satusehat:listen-registrasi`

```bash
php artisan satusehat:listen-registrasi [--timeout=5000] [--max-jobs=1000]
```

| Option | Default | Keterangan |
|--------|---------|------------|
| `--timeout` | `5000` | Timeout polling pg_notify (ms) |
| `--max-jobs` | `1000` | Restart daemon setelah N job (cegah memory leak) |

**Catatan**: Di production, jalankan via Supervisor — lihat `config/supervisor/satusehat-registrasi-listener.conf`.

### `satusehat:sync-encounter`

```bash
php artisan satusehat:sync-encounter [--batch=30] [--delay=300]
```

Bulk sync registrasi yang belum ter-sync (termasuk status `waiting_patient` setelah pasien di-sync).

### Queue Worker (untuk job)

```bash
php artisan queue:work --queue=default --sleep=3 --tries=3
```

Job `SyncPasienToSatuSehat` membutuhkan queue worker aktif.

---

## 15. Alur Kerja Lengkap (Onboarding)

Checklist untuk setup pertama kali di environment baru:

1. **Isi `.env`** — `SATUSEHAT_CLIENT_ID`, `SATUSEHAT_CLIENT_SECRET`, `SATUSEHAT_ORGANIZATION_ID`, `SATUSEHAT_ENV`
2. **Jalankan SQL** — `psql -f database/sql/satu-sehat.sql` (DDL + trigger)
3. **Sync Wilayah** — UI Wilayah → fetch semua level → update master
4. **Sync Organization** — UI Organization → Sync dari SatuSehat
5. **Sync Location** — UI Location → Sync dari SatuSehat
6. **Sync Practitioner** — UI Practitioner → Sync All (untuk semua dokter/nakes)
7. **Sync Pasien Existing** — UI Pasien → Sync All (untuk pasien lama)
8. **Jalankan Queue Worker** — `php artisan queue:work`
9. **Jalankan Daemon LISTEN** — via Supervisor atau manual `php artisan satusehat:listen-pasien`
10. **Test** — daftarkan pasien baru, cek `pasien.id_satu_sehat` terisi otomatis

---

## 16. Deployment Production

### Queue Worker (Supervisor)

```ini
[program:eye-hospital-worker]
command=/usr/bin/php /var/www/eye-hospital/artisan queue:work --sleep=3 --tries=3 --max-time=3600
directory=/var/www/eye-hospital
user=www-data
autostart=true
autorestart=true
stdout_logfile=/var/log/supervisor/eye-hospital-worker.log
```

### SatuSehat Listener Daemon (Supervisor)

File: `config/supervisor/satusehat-listener.conf`

```ini
[program:satusehat-listener]
command=/usr/bin/php /var/www/eye-hospital/artisan satusehat:listen-pasien --timeout=5000 --max-jobs=1000
directory=/var/www/eye-hospital
user=www-data
autostart=true
autorestart=true
startretries=10
startsecs=3
stopsignal=TERM
stopwaitsecs=10
stdout_logfile=/var/log/supervisor/satusehat-listener.log
stderr_logfile=/var/log/supervisor/satusehat-listener-error.log
```

**Install Supervisor:**
```bash
sudo apt-get install supervisor
sudo cp config/supervisor/satusehat-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-listener
```

### SatuSehat Registrasi Listener (Supervisor)

File: `config/supervisor/satusehat-registrasi-listener.conf`

```bash
sudo cp config/supervisor/satusehat-registrasi-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-registrasi-listener
```

### Scheduled Command (Laravel Scheduler)

Di `app/Console/Kernel.php`:
```php
$schedule->command('satusehat:sync-encounter --limit=100')->hourly();
```

Aktifkan cron:
```bash
* * * * * cd /var/www/eye-hospital && php artisan schedule:run >> /dev/null 2>&1
```

---

## 17. Troubleshooting

### Pasien tidak ter-sync otomatis

**Kemungkinan penyebab:**
- Queue worker tidak berjalan → jalankan `php artisan queue:work`
- Daemon LISTEN tidak berjalan → `sudo supervisorctl status satusehat-listener`
- NIK pasien tidak valid (bukan 16 digit angka)
- `delete_soft != 1` (pasien non-aktif)

**Cek log:**
```bash
tail -f /var/log/supervisor/satusehat-listener.log
php artisan queue:failed  # lihat job yang gagal
```

### Encounter ditolak SatuSehat (400/422)

**Kemungkinan penyebab:**
- Organization belum di-sync → `identifier_system` kosong, fallback dipakai
- Pasien belum punya `id_satu_sehat`
- Dokter/nakes belum punya `satusehat_ihs_id`
- `satusehat_location_id` tidak terisi di registrasi

**Solusi:** Pastikan urutan onboarding di Bagian 15 diikuti.

### Token SatuSehat expired

BridgeBase meng-cache token dan refresh otomatis. Jika tetap gagal, cek `SATUSEHAT_CLIENT_ID` dan `SATUSEHAT_CLIENT_SECRET` di `.env`.

### Daemon LISTEN tidak menerima notifikasi

```bash
# Cek trigger terpasang
psql -c "\d pasien"  # lihat list trigger
psql -c "SELECT tgname FROM pg_trigger WHERE tgrelid = 'pasien'::regclass;"

# Test manual
psql -c "LISTEN satusehat_pasien_insert;"
# (di session lain) INSERT INTO pasien (...) VALUES (...);
```

### Double-sync (job dikirim 2x untuk pasien yang sama)

Ini **normal** dan **aman** — job kedua akan skip karena `id_satu_sehat` sudah terisi oleh job pertama. Tidak ada data ganda dikirim ke SatuSehat.

### Log API

Semua request/response tersimpan di tabel `satusehat_api_logs`:
```sql
SELECT method, url, http_code, is_success, duration_ms, created_at
FROM satusehat_api_logs
ORDER BY created_at DESC
LIMIT 50;
```

---

*Dokumentasi ini dihasilkan otomatis bersama kode — update setiap ada perubahan arsitektur signifikan.*
