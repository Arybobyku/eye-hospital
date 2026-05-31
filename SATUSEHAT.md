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
11c. [Auto-Sync CarePlan (LISTEN/NOTIFY)](#11c-auto-sync-careplan-listennotify)
12. [Modul: CarePlan (Rencana Rawat)](#12-modul-careplan-rencana-rawat)
13. [Shared Services](#13-shared-services)
14. [Referensi API Routes](#14-referensi-api-routes)
15. [Artisan Commands](#15-artisan-commands)
16. [Alur Kerja Lengkap (Onboarding)](#16-alur-kerja-lengkap-onboarding)
17. [Deployment Production](#17-deployment-production)
18. [Troubleshooting](#18-troubleshooting)

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
| CarePlan | `CarePlan` | Kirim rencana rawat pasien otomatis saat dokter selesai periksa |
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
satusehat_encounter_id            VARCHAR(64)   -- FHIR Encounter.id (diisi setelah POST berhasil)
satusehat_encounter_status        VARCHAR(20)   -- null | waiting_patient | no_location | synced | failed
satusehat_encounter_synced_at     TIMESTAMP
satusehat_encounter_fhir_status   VARCHAR(20)   -- FHIR status aktif: arrived | in-progress | finished | cancelled
satusehat_location_id             VARCHAR(64)   -- FHIR Location.id (Front Office / lokasi utama)
satusehat_location_ro_id          VARCHAR(64)   -- FHIR Location.id ruang Refraksi Optisi
satusehat_location_poli_id        VARCHAR(64)   -- FHIR Location.id ruang Poli Dokter
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
| `satusehat_encounter_status_history` | Riwayat transisi FHIR status per Encounter (untuk `statusHistory` payload) |

### Tabel `satusehat_encounter_status_history`

```sql
CREATE TABLE satusehat_encounter_status_history (
    id               BIGSERIAL PRIMARY KEY,
    registrasi_uuid  UUID         NOT NULL,  -- FK ke registrasi.uuid
    status           VARCHAR(20)  NOT NULL,  -- arrived | in-progress | finished | cancelled
    period_start     TIMESTAMP    NOT NULL,  -- Waktu status dimulai (UTC)
    period_end       TIMESTAMP    DEFAULT NULL,  -- NULL = status masih aktif
    created_at       TIMESTAMP    DEFAULT NOW()
);
CREATE INDEX ON satusehat_encounter_status_history (registrasi_uuid);
```

Tabel ini dikelola sepenuhnya oleh `SyncEncounterToSatuSehat` job:
- `handlePost()` — insert baris `arrived` pertama kali
- `handleRo()` — tutup `arrived` (set `period_end`), insert `in-progress`
- `handleDokter()` — tutup semua open, insert `finished`
- `rollbackStatusUpdate()` — batalkan transisi jika PUT API gagal

`EncounterBuilder::buildStatusHistory()` membaca tabel ini untuk mengisi `statusHistory[]` di payload FHIR.

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
│   ├── ListenPasienSatuSehat.php      # Daemon LISTEN pg_notify → dispatch job Pasien
│   ├── ListenRegistrasiSatuSehat.php  # Daemon LISTEN pg_notify → dispatch job Encounter
│   ├── ListenCarePlanSatuSehat.php    # Daemon LISTEN pg_notify → dispatch job CarePlan
│   ├── SyncEncounterSatuSehat.php     # Scheduler bulk-sync Encounter
│   └── SyncCarePlanSatuSehat.php      # Scheduler bulk-sync CarePlan
│
├── Http/Controllers/SatuSehat/
│   ├── BridgeBase.php                 # HTTP client (OAuth2 token, request wrapper)
│   ├── PatientSyncCtrl.php            # Sync Pasien: one-by-one & bulk
│   ├── PractitionerSyncCtrl.php       # Sync Practitioner (Pengguna/Dokter)
│   ├── OrganizationCtrl.php           # Sync & cache Organization dari SatuSehat
│   ├── LocationCtrl.php               # Sync & cache Location dari SatuSehat
│   ├── EncounterSyncCtrl.php          # Sync Encounter: one-by-one & bulk
│   ├── CarePlanSyncCtrl.php           # Sync CarePlan: dashboard, list, sync, retry
│   └── WilayahCtrl.php                # Cache wilayah BPS
│
├── Jobs/
│   ├── SyncPasienToSatuSehat.php      # Queue job: sync 1 pasien (idempoten)
│   ├── SyncEncounterToSatuSehat.php   # Queue job: sync 1 encounter (idempoten)
│   └── SyncCarePlanToSatuSehat.php    # Queue job: sync 1 careplan (idempoten)
│
├── Observers/
│   ├── PasienObserver.php             # Eloquent hook: dispatch job saat Pasien dibuat
│   └── RegistrasiObserver.php         # Eloquent hook: dispatch job saat Registrasi dibuat/diupdate
│
├── Providers/
│   └── AppServiceProvider.php         # Register observer + dokumentasi strategi dual-layer
│
└── Services/SatuSehat/
    ├── PatientBuilder.php             # Build FHIR Patient payload (static)
    ├── EncounterBuilder.php           # Build FHIR Encounter payload (static)
    └── CarePlanBuilder.php            # Build FHIR CarePlan payload (static)

config/supervisor/
├── satusehat-listener.conf                # Daemon: listen-pasien
├── satusehat-registrasi-listener.conf     # Daemon: listen-registrasi
└── satusehat-careplan-listener.conf       # Daemon: listen-careplan

database/sql/
└── satu-sehat.sql                         # DDL: ALTER TABLE, CREATE TABLE, trigger pg_notify

resources/js/components/satusehat/
├── patient/index.vue                  # UI sync pasien
├── practitioner/index.vue             # UI sync practitioner
├── organization/index.vue             # UI sync & status organization
├── location/index.vue                 # UI sync & status location
├── encounter/index.vue                # UI sync encounter
└── careplan/index.vue                 # UI sync careplan (dashboard + tabel)

routes/
└── satusehat.php                      # Semua route /satusehat/...
```

---

## 5. Modul: Pasien

### Cara Kerja

1. Pasien baru dibuat (via Eloquent atau `DB::table()`)
2. **Auto-sync** terpicu (lihat [Bagian 11 — Auto-Sync Pasien](#11-auto-sync-pasien-listennotify))
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

### Siklus FHIR Status Encounter

Encounter mengikuti alur status FHIR berikut yang dipicu secara otomatis oleh trigger PostgreSQL:

```
[Pendaftaran CS]           [RO Selesai]              [Dokter Selesai]
      │                         │                           │
      ▼                         ▼                           ▼
   arrived  ──────────►  in-progress  ──────────►      finished
  (POST baru)         (PUT update — event ro)      (PUT update — event dokter)
```

| FHIR Status | Event Trigger | Dipicu Oleh |
|-------------|---------------|-------------|
| `arrived` | `encounter_post` | Pasien didaftarkan (location diisi, status_ro = 'Belum Diperiksa') |
| `in-progress` | `encounter_ro` | Status RO berubah ke 'Sudah Diperiksa RO' |
| `finished` | `encounter_dokter` | Status dokter berubah ke 'Sudah Diperiksa' |

### FHIR Encounter Payload — POST (arrived)

```json
{
  "resourceType": "Encounter",
  "status": "arrived",
  "class": { "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode", "code": "AMB" },
  "serviceType": { "coding": [{ "system": "...", "code": "397", "display": "Outpatients" }] },
  "identifier": [{ "system": "http://sys-ids.kemkes.go.id/encounter/{orgId}", "value": "REG-0001" }],
  "subject": { "reference": "Patient/{ihsNumber}", "display": "Nama Pasien" },
  "participant": [{ "type": [...], "individual": { "reference": "Practitioner/{ihsId}" } }],
  "period": { "start": "2024-01-15T08:00:00+07:00" },
  "statusHistory": [{ "status": "arrived", "period": { "start": "2024-01-15T08:00:00+07:00" } }],
  "location": [
    { "location": { "reference": "Location/{frontOfficeId}" }, "status": "completed" },
    { "location": { "reference": "Location/{roId}", "display": "Refraksi Optisi" }, "status": "completed" },
    { "location": { "reference": "Location/{poliId}", "display": "Poli Mata" }, "status": "active" }
  ],
  "serviceProvider": { "reference": "Organization/{orgId}" }
}
```

### FHIR Encounter Payload — PUT (in-progress / finished)

```json
{
  "resourceType": "Encounter",
  "id": "{encounterId}",
  "status": "finished",
  "statusHistory": [
    { "status": "arrived",     "period": { "start": "...", "end": "..." } },
    { "status": "in-progress", "period": { "start": "...", "end": "..." } },
    { "status": "finished",    "period": { "start": "..." } }
  ],
  "period": { "start": "2024-01-15T08:00:00+07:00", "end": "2024-01-15T09:30:00+07:00" },
  "location": [{ "location": { "reference": "Location/{poliId}", "display": "Poli Mata" } }],
  "participant": [{ "type": [...], "individual": { "reference": "Practitioner/{ihsId}" } }],
  "serviceProvider": { "reference": "Organization/{orgId}" }
}
```

> **Catatan**: Payload PUT tidak menyertakan `serviceType` (berbeda dengan POST) sesuai spesifikasi SatuSehat.

### Builder: `EncounterBuilder::build($reg, $orgId)`

```php
use App\Services\SatuSehat\EncounterBuilder;

$payload = EncounterBuilder::build($reg, $orgId);
```

- Digunakan untuk **POST Encounter baru** (status `arrived`)
- Mendukung multi-lokasi: Front Office, Refraksi Optisi, dan Poli Dokter sekaligus
- `statusHistory` dibangun dari tabel `satusehat_encounter_status_history`
- Identifier system diambil dari `satusehat_organizations` lokal; fallback ke `http://sys-ids.kemkes.go.id/encounter/{orgId}`

### Builder: `EncounterBuilder::buildPut($reg, $orgId, $newFhirStatus, $locationId, $locationDisplay, $withPractitioner)`

```php
$payload = EncounterBuilder::buildPut(
    $reg,
    $orgId,
    'in-progress',        // FHIR status baru
    $locationId,          // FHIR Location.id yang aktif
    'Refraksi Optisi',    // Display name lokasi
    false                 // true = sertakan participant.individual (untuk event dokter)
);
```

- Digunakan untuk **PUT Encounter** (update status ke `in-progress` atau `finished`)
- **Pemanggil wajib update `satusehat_encounter_status_history` di DB SEBELUM memanggil metode ini**, karena `buildStatusHistory()` membaca dari DB
- Payload selalu menyertakan `"id": "{encounterId}"` di root (diperlukan FHIR PUT)
- `period.end` diisi dengan waktu sekarang (WIB)

### Endpoint

```
POST /satusehat-api/encounter-sync/sync-one    → sync 1 registrasi (dari Vue)
POST /satusehat-api/encounter-sync/dashboard   → statistik: total, synced, failed, waiting
POST /satusehat-api/encounter-sync/list        → daftar dengan filter status & tanggal
POST /satusehat-api/encounter-sync/detail      → ambil detail Encounter dari SatuSehat (GET Encounter/{id})
POST /satusehat-api/encounter-sync/run-sync    → bulk sync semua pending
POST /satusehat-api/encounter-sync/retry-failed → reset failed/waiting → null (untuk retry)
```

### Expand Detail Encounter di UI Vue

Di halaman Encounter Sync, baris dengan `satusehat_encounter_status = 'synced'` menampilkan tombol chevron (▶). Klik tombol tersebut untuk memperluas baris dan menampilkan detail FHIR dari SatuSehat:

- **Subject** — referensi & nama pasien
- **Periode Kunjungan** — tanggal & jam mulai/selesai
- **Tenaga Medis** — Practitioner reference & display
- **Lokasi** — daftar Location dengan status
- **Riwayat Status** (`statusHistory`) — timeline transisi FHIR status
- **Identifier** — system & value

Data di-fetch secara lazy (saat pertama kali dibuka) via endpoint `POST /satusehat-api/encounter-sync/detail`.

### Artisan Command (bulk scheduler)

```bash
php artisan satusehat:sync-encounter [--batch=30] [--date-from=YYYY-MM-DD] [--date-to=YYYY-MM-DD]
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

### Arsitektur 3-Event

```
UPDATE tabel registrasi
        │
        └── PostgreSQL Trigger fn_notify_registrasi_upsert()
                  │
                  ├── EVENT encounter_post  (location diisi, status_ro='Belum Diperiksa', belum ada encounter_id)
                  │         └── pg_notify('satusehat_registrasi_upsert', {..., "event": "encounter_post"})
                  │
                  ├── EVENT encounter_ro   (status_ro berubah → 'Sudah Diperiksa RO')
                  │         └── pg_notify('satusehat_registrasi_upsert', {..., "event": "encounter_ro"})
                  │
                  └── EVENT encounter_dokter (status_dokter berubah → 'Sudah Diperiksa')
                            └── pg_notify('satusehat_registrasi_upsert', {..., "event": "encounter_dokter"})

pg_notify → ListenRegistrasiSatuSehat daemon
                  │
                  └── SyncEncounterToSatuSehat::dispatch($uuid, $event)
                            │
                            ├── encounter_post   → handlePost()   → POST /Encounter
                            ├── encounter_ro     → handleRo()     → PUT  /Encounter/{id}
                            └── encounter_dokter → handleDokter() → PUT  /Encounter/{id}
```

> **Catatan**: Trigger hanya mendengarkan `AFTER UPDATE` (bukan INSERT). Notifikasi INSERT tidak lagi diperlukan karena POST Encounter dipicu saat CS melengkapi data registrasi (field location diisi).

### Kondisi Trigger Notifikasi

| Event | Kondisi UPDATE |
|-------|----------------|
| `encounter_post` | `delete_soft=1`, `satusehat_encounter_id IS NULL`, `status_ro='Belum Diperiksa'`, dan salah satu field berubah: `satusehat_location_id`, `satusehat_encounter_status`, `pasien_uuid`, `pengguna_uuid`, `tanggal`, atau `waktu` |
| `encounter_ro` | `delete_soft=1`, `satusehat_encounter_id IS NOT NULL`, `status_ro` berubah ke `'Sudah Diperiksa RO'` |
| `encounter_dokter` | `delete_soft=1`, `satusehat_encounter_id IS NOT NULL`, `status_dokter` berubah dari `'Belum Diperiksa'` ke `'Sudah Diperiksa'` |

Tiga IF terpisah (bukan IF/ELSIF) — satu UPDATE **bisa** memicu lebih dari satu event sekaligus jika kondisinya overlap.

### Trigger PostgreSQL (`fn_notify_registrasi_upsert`)

```sql
-- Trigger hanya AFTER UPDATE (bukan INSERT)
CREATE TRIGGER trg_registrasi_upsert
    AFTER UPDATE ON registrasi
    FOR EACH ROW EXECUTE FUNCTION fn_notify_registrasi_upsert();
```

Migration untuk menerapkan versi terbaru:
```bash
php artisan migrate --path=database/migrations/2026_05_27_000002_update_encounter_trigger_3events.php
```

Atau langsung via psql:
```bash
psql -U postgres -d eye_hospital -f database/sql/satu-sehat.sql
```

### Status Encounter

| Status | Keterangan |
|--------|------------|
| `null` | Belum pernah diproses |
| `waiting_patient` | Pasien belum punya IHS Number — tunggu sync pasien |
| `no_location` | `satusehat_location_id` belum diisi |
| `synced` | Berhasil dikirim ke SatuSehat (POST maupun PUT) |
| `failed` | Gagal — akan di-retry oleh queue |

### FHIR Status vs Status Encounter

| `satusehat_encounter_fhir_status` | `satusehat_encounter_status` | Kondisi |
|-----------------------------------|------------------------------|---------|
| `arrived` | `synced` | POST berhasil |
| `in-progress` | `synced` | PUT encounter_ro berhasil |
| `finished` | `synced` | PUT encounter_dokter berhasil |
| _(sebelumnya)_ | `failed` | PUT/POST gagal — rollback otomatis |

### Job: `SyncEncounterToSatuSehat`

```php
class SyncEncounterToSatuSehat implements ShouldQueue
{
    public int $tries   = 1;               // tidak retry otomatis — business logic tiap event beda
    public array $backoff = [30, 120, 300];
    public int $timeout = 60;

    public function __construct(
        public string $registrasiUuid,
        public string $event = 'encounter_post'  // backward compatible
    ) {}
}
```

**Routing event di `handle()`**:
```php
match ($this->event) {
    'encounter_post'   => $this->handlePost($reg, $orgId, $bridge, $uuid),
    'encounter_ro'     => $this->handleRo($reg, $orgId, $bridge, $uuid),
    'encounter_dokter' => $this->handleDokter($reg, $orgId, $bridge, $uuid),
    default => Log::warning('Unknown event', ['event' => $this->event]),
};
```

**`handlePost()` — POST Encounter baru (arrived)**:
1. Guard: `satusehat_encounter_id` sudah ada & status `synced` → skip
2. Guard: pasien belum punya `id_satu_sehat` → status `waiting_patient`, return
3. Guard: `satusehat_location_id` kosong → status `no_location`, return
4. Insert baris `arrived` ke `satusehat_encounter_status_history`
5. Build payload via `EncounterBuilder::build($reg, $orgId)`
6. POST ke `/Encounter`
7. Sukses (201): simpan `satusehat_encounter_id`, `fhir_status = 'arrived'`, status `synced`
8. Duplikat (409/422): GET existing Encounter ID, update DB
9. Gagal: status `failed`, throw exception

**`handleRo()` — PUT Encounter in-progress**:
1. Guard: sudah `in-progress`/`finished`/`cancelled` → skip
2. Cari lokasi RO: prioritas `satusehat_location_ro_id`, fallback ILIKE `'%refraksi%'` atau `'%optisi%'` di `satusehat_locations`
3. DB::transaction: tutup `arrived` (set `period_end = now()`), insert `in-progress` (idempotent)
4. Build payload via `EncounterBuilder::buildPut($reg, $orgId, 'in-progress', $locId, $locDisplay, false)`
5. PUT ke `/Encounter/{id}`
6. Sukses: update `fhir_status = 'in-progress'`, status `synced`
7. Gagal: `rollbackStatusUpdate()`, throw exception

**`handleDokter()` — PUT Encounter finished**:
1. Guard: sudah `finished`/`cancelled` → skip; pasien tanpa IHS → skip
2. Cari lokasi poli: prioritas `satusehat_location_poli_id`, fallback ILIKE `'%poli%'` + `'%{ruang_poliklinik}%'`
3. DB::transaction: tutup SEMUA open periods (`arrived`, `in-progress`), insert `finished` (period_end = now())
4. Build payload via `EncounterBuilder::buildPut($reg, $orgId, 'finished', $locId, $locDisplay, true)`
5. PUT ke `/Encounter/{id}`
6. Sukses: update `fhir_status = 'finished'`, status `synced`
7. Gagal: `rollbackStatusUpdate()`, throw exception

**`rollbackStatusUpdate()` — Rollback pada PUT gagal**:
```php
private function rollbackStatusUpdate(string $uuid, string $newStatus, string $prevStatus): void
{
    // Hapus baris status baru dari history
    DB::table('satusehat_encounter_status_history')
        ->where('registrasi_uuid', $uuid)->where('status', $newStatus)->delete();
    // Buka kembali status sebelumnya (period_end = null)
    DB::table('satusehat_encounter_status_history')
        ->where('registrasi_uuid', $uuid)->where('status', $prevStatus)
        ->update(['period_end' => null]);
    // Kembalikan fhir_status di registrasi
    DB::table('registrasi')->where('uuid', $uuid)
        ->update(['satusehat_encounter_fhir_status' => $prevStatus]);
}
```

### Status `waiting_patient` — Alur Lengkap

Skenario: pasien baru didaftarkan bersamaan dengan registrasi.

1. INSERT ke `pasien` → trigger pasien → job `SyncPasienToSatuSehat` dispatch
2. UPDATE `registrasi` (location diisi) → trigger `encounter_post` → job dispatch
3. Job encounter berjalan: pasien belum punya `id_satu_sehat` → status `waiting_patient`
4. Job pasien selesai: `id_satu_sehat` terisi
5. Jalankan sync encounter manual dari UI atau tunggu scheduler (setiap 30 menit)

### Artisan Command

```bash
# Development
php artisan satusehat:listen-registrasi

# Dengan opsi
php artisan satusehat:listen-registrasi --timeout=5000 --max-jobs=1000 --heartbeat=30
```

### Supervisor (Production)

File: `config/supervisor/satusehat-registrasi-listener.conf`

```bash
sudo cp config/supervisor/satusehat-registrasi-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-registrasi-listener
```

---

## 11c. Auto-Sync CarePlan (LISTEN/NOTIFY)

### Arsitektur

```
UPDATE registrasi SET status_dokter = 'Sudah Diperiksa'
        │
        └── PostgreSQL Trigger fn_notify_careplan_ready()
                  │
                  └── pg_notify('satusehat_careplan_notify', payload_json)
                            │
                            └── ListenCarePlanSatuSehat daemon
                                      │
                                      └── SyncCarePlanToSatuSehat::dispatch(uuid)
                                                │
                                                └── POST /CarePlan ke SatuSehat
```

### Kondisi Trigger Notifikasi

Trigger `trg_registrasi_careplan` hanya berbunyi saat **semua** kondisi ini terpenuhi:
- `status_dokter` berubah ke `'Sudah Diperiksa'` (transisi, bukan update berulang)
- `satusehat_careplan_id IS NULL` (belum ter-sync)
- `delete_soft = 1` (registrasi aktif)

```sql
-- database/sql/satu-sehat.sql
CREATE OR REPLACE FUNCTION fn_notify_careplan_ready()
RETURNS trigger AS $$
BEGIN
    IF NEW.status_dokter = 'Sudah Diperiksa'
       AND (OLD.status_dokter IS DISTINCT FROM 'Sudah Diperiksa')
       AND NEW.satusehat_careplan_id IS NULL
       AND NEW.delete_soft = 1
    THEN
        PERFORM pg_notify('satusehat_careplan_notify', json_build_object(
            'uuid',                   NEW.uuid,
            'nomor',                  NEW.nomor,
            'pasien_uuid',            NEW.pasien_uuid,
            'pengguna_uuid',          NEW.pengguna_uuid,
            'satusehat_encounter_id', NEW.satusehat_encounter_id,
            'status_dokter',          NEW.status_dokter
        )::text);
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_registrasi_careplan
    AFTER UPDATE ON registrasi
    FOR EACH ROW EXECUTE FUNCTION fn_notify_careplan_ready();
```

### Status CarePlan

| Status | Keterangan |
|--------|------------|
| `null` | Belum pernah diproses |
| `waiting_patient` | Pasien belum punya IHS Number |
| `waiting_encounter` | Encounter belum ter-sync ke SatuSehat |
| `synced` | Berhasil dikirim ke SatuSehat |
| `failed` | Gagal — akan di-retry oleh queue (maks 3x) |

### Daemon Command

```bash
# Development
php artisan satusehat:listen-careplan

# Dengan opsi
php artisan satusehat:listen-careplan --timeout=5000 --max-jobs=1000
```

### Scheduler (Safety Net)

Selain daemon realtime, bulk sync berjalan setiap 15 menit sebagai jaring pengaman — menangkap registrasi yang `waiting_encounter` / `waiting_patient` setelah prasyaratnya terpenuhi:

```php
// app/Console/Kernel.php
$schedule->command('satusehat:sync-careplan --batch=30')
         ->everyFifteenMinutes()
         ->withoutOverlapping()
         ->appendOutputTo(storage_path('logs/satusehat-sync-careplan.log'));
```

---

## 12. Modul: CarePlan (Rencana Rawat)

Kirim **rencana rawat pasien** (FHIR `CarePlan`) ke SatuSehat secara otomatis saat dokter menyelesaikan pemeriksaan.

### Prasyarat

- Pasien sudah punya `id_satu_sehat` (IHS Number) — lihat Modul Pasien
- Registrasi sudah punya `satusehat_encounter_id` — lihat Modul Encounter
- Tabel `pemeriksaan_dokter` terisi untuk registrasi yang bersangkutan
- Dokter (opsional) sudah punya `satusehat_ihs_id`

### Kolom Tambahan di `registrasi`

```sql
ALTER TABLE registrasi
  ADD COLUMN IF NOT EXISTS satusehat_careplan_id         VARCHAR(64)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_status     VARCHAR(20)  DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS satusehat_careplan_synced_at  TIMESTAMP    DEFAULT NULL;
```

### FHIR CarePlan Payload (contoh)

```json
{
  "resourceType": "CarePlan",
  "status": "active",
  "intent": "plan",
  "category": [{
    "coding": [{
      "system": "http://snomed.info/sct",
      "code":   "736271009",
      "display": "Outpatient care plan"
    }]
  }],
  "title": "Rencana Rawat Jalan",
  "description": "Anamnese: Penglihatan kabur. Diagnosa: Katarak senilis",
  "subject": { "reference": "Patient/{ihsNumber}", "display": "Budi Santoso" },
  "encounter": { "reference": "Encounter/{encounterId}" },
  "period": {
    "start": "2024-01-15",
    "end":   "2024-02-15"
  },
  "author": { "reference": "Practitioner/{ihsId}", "display": "dr. Nama Dokter" },
  "contributor": [{ "reference": "Organization/{orgId}" }],
  "activity": [{
    "detail": {
      "kind": "ServiceRequest",
      "code": {
        "coding": [{
          "system": "http://snomed.info/sct",
          "code":   "308335008",
          "display": "Patient encounter procedure"
        }]
      },
      "status":      "in-progress",
      "description": "Pemeriksaan Mata"
    }
  }]
}
```

**Field yang diisi otomatis dari DB:**

| Field CarePlan | Sumber |
|----------------|--------|
| `subject.reference` | `pasien.id_satu_sehat` |
| `encounter.reference` | `registrasi.satusehat_encounter_id` |
| `description` | `pemeriksaan_dokter.anamnese` + `pemeriksaan_diagnosa` |
| `period.start` | `registrasi.tanggal` |
| `period.end` | `pemeriksaan_dokter.tanggal_kontrol_selanjutnya` (opsional) |
| `author.reference` | `pengguna.satusehat_ihs_id` (opsional) |
| `activity[].detail.description` | `layanan_pasien.nama_layanan` (dikecualikan obat-obatan) |

### Builder: `CarePlanBuilder::build($reg, $orgId)`

```php
use App\Services\SatuSehat\CarePlanBuilder;

$payload = CarePlanBuilder::build($reg, $orgId);
```

- `$reg` adalah object registrasi dari DB (sudah include join pasien + pengguna)
- Fetch otomatis `pemeriksaan_dokter` dan `layanan_pasien` by `registrasi_uuid`
- Aktivitas obat (`nama_layanan` = 'Obat-obatan' / 'Obat Racikan') **dikecualikan**

### Job: `SyncCarePlanToSatuSehat`

```php
class SyncCarePlanToSatuSehat implements ShouldQueue
{
    public int $tries   = 3;
    public array $backoff = [30, 120, 300];  // retry 30 detik, 2 menit, 5 menit
    public int $timeout = 60;
}
```

**Alur `handle()`**:
1. Fetch registrasi + join pasien, pengguna
2. Guard: `satusehat_careplan_id` sudah terisi → skip (idempoten)
3. Guard: pasien belum punya `id_satu_sehat` → status `waiting_patient`, return
4. Guard: `satusehat_encounter_id` kosong → status `waiting_encounter`, return
5. Build payload via `CarePlanBuilder::build($reg, $orgId)`
6. POST ke SatuSehat `/CarePlan`
7. Sukses: simpan `satusehat_careplan_id`, status `synced`, catat waktu
8. Gagal: status `failed`, throw untuk retry

### Endpoint API

```
POST /satusehat-api/careplan-sync/dashboard    → statistik (total, synced, failed, dll.)
POST /satusehat-api/careplan-sync/list         → daftar dengan filter & paginasi
POST /satusehat-api/careplan-sync/sync-one     → sync 1 registrasi
POST /satusehat-api/careplan-sync/run-sync     → trigger bulk sync semua pending
POST /satusehat-api/careplan-sync/retry-failed → reset failed/waiting → null (untuk retry)
```

### Supervisor (Production)

```bash
sudo cp config/supervisor/satusehat-careplan-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-careplan-listener
```

---

## 13. Shared Services

### `PatientBuilder` — `app/Services/SatuSehat/PatientBuilder.php`

```php
PatientBuilder::build(object $pasien, string $method = 'nik'): array
```

Membangun FHIR Patient payload. Logika di sini adalah **single source of truth** untuk semua kode yang perlu membangun Patient payload — baik sync one, sync bulk, maupun job auto-sync.

### `EncounterBuilder` — `app/Services/SatuSehat/EncounterBuilder.php`

```php
// POST Encounter baru (status arrived)
EncounterBuilder::build(object $reg, string $orgId): array

// PUT Encounter (update status in-progress / finished)
EncounterBuilder::buildPut(
    object $reg,
    string $orgId,
    string $newFhirStatus,    // 'in-progress' | 'finished' | 'cancelled'
    string $locationId,       // FHIR Location.id yang aktif
    string $locationDisplay,  // Display name lokasi
    bool   $withPractitioner = false  // true untuk event dokter (sertakan participant.individual)
): array

// Build statusHistory[] dari tabel satusehat_encounter_status_history
EncounterBuilder::buildStatusHistory(
    ?string $registrasiUuid,
    string  $defaultPeriodStart,
    string  $currentStatus = 'arrived'
): array
```

**`build()`** — digunakan untuk POST Encounter baru:
- Dipakai oleh `EncounterSyncCtrl::syncOne()` dan `SyncEncounterToSatuSehat::handlePost()`
- Mendukung multi-lokasi: Front Office, RO, dan Poli dalam satu payload
- Menyertakan `serviceType` (hanya untuk POST)

**`buildPut()`** — digunakan untuk PUT Encounter:
- Dipakai oleh `SyncEncounterToSatuSehat::handleRo()` dan `handleDokter()`
- **Pemanggil wajib update DB `satusehat_encounter_status_history` SEBELUM memanggil metode ini**
- Menyertakan `"id"` di root payload (wajib untuk FHIR PUT)
- Tidak menyertakan `serviceType` (berbeda dengan POST)
- `period.end` selalu diisi dengan waktu sekarang (WIB)

**`buildStatusHistory()`** — dipakai internal oleh `build()` dan `buildPut()`:
- Membaca tabel `satusehat_encounter_status_history` berurutan berdasarkan `period_start`
- Jika belum ada record, return default `[{ "status": "arrived", "period": { "start": ... } }]`
- Konversi otomatis timestamp UTC → ISO8601 +07:00 (WIB)

### `CarePlanBuilder` — `app/Services/SatuSehat/CarePlanBuilder.php`

```php
CarePlanBuilder::build(object $reg, string $orgId): array
```

Membangun FHIR CarePlan payload. Digunakan oleh:
- `CarePlanSyncCtrl::syncOne()` — sync dari UI Vue
- `SyncCarePlanToSatuSehat::handle()` — job auto-sync
- `SyncCarePlanSatuSehat::handle()` — bulk sync via Artisan scheduler

Builder secara otomatis fetch:
- `pemeriksaan_dokter` (by `registrasi_uuid`) → `description`, `period.end`
- `layanan_pasien` (by `registrasi_uuid`, kecualikan obat) → `activity[].detail.description`

### `BridgeBase` — `app/Http/Controllers/SatuSehat/BridgeBase.php`

Base class untuk semua controller SatuSehat. Menyediakan:
- `getToken()` — OAuth2 client credentials, dengan cache
- `request(method, endpoint, payload)` — wrapper HTTP call + logging ke `satusehat_api_logs`
- Base URL otomatis berdasarkan `SATUSEHAT_ENV`

---

## 14. Referensi API Routes

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
| `POST` | `/satusehat-api/encounter-sync/dashboard` | Statistik: total, synced, failed, waiting |
| `POST` | `/satusehat-api/encounter-sync/list` | Daftar dengan filter status & rentang tanggal |
| `POST` | `/satusehat-api/encounter-sync/sync-one` | Sync 1 registrasi by UUID |
| `POST` | `/satusehat-api/encounter-sync/detail` | Ambil detail FHIR Encounter dari SatuSehat |
| `POST` | `/satusehat-api/encounter-sync/run-sync` | Trigger bulk sync semua pending |
| `POST` | `/satusehat-api/encounter-sync/retry-failed` | Reset failed/waiting → null untuk retry |

### CarePlan

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat-api/careplan-sync/dashboard` | Statistik: total, synced, failed, waiting, pct |
| `POST` | `/satusehat-api/careplan-sync/list` | Daftar dengan filter status & paginasi |
| `POST` | `/satusehat-api/careplan-sync/sync-one` | Sync 1 registrasi by UUID |
| `POST` | `/satusehat-api/careplan-sync/run-sync` | Trigger bulk sync semua pending |
| `POST` | `/satusehat-api/careplan-sync/retry-failed` | Reset failed/waiting → null untuk retry |

### Wilayah

| Method | URL | Keterangan |
|--------|-----|------------|
| `POST` | `/satusehat/wilayah/fetch-province` | Fetch & cache provinsi |
| `POST` | `/satusehat/wilayah/fetch-city` | Fetch & cache kab/kota |
| `POST` | `/satusehat/wilayah/fetch-district` | Fetch & cache kecamatan |
| `POST` | `/satusehat/wilayah/fetch-village` | Fetch & cache kelurahan |
| `POST` | `/satusehat/wilayah/update-master` | Update satusehat_code di tabel master lokal |

---

## 15. Artisan Commands

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
php artisan satusehat:listen-registrasi [--timeout=5000] [--max-jobs=1000] [--heartbeat=30]
```

| Option | Default | Keterangan |
|--------|---------|------------|
| `--timeout` | `5000` | Timeout polling pg_notify (ms) |
| `--max-jobs` | `1000` | Restart daemon setelah N job (cegah memory leak) |
| `--heartbeat` | `30` | Interval log heartbeat dalam detik (0 = nonaktif) |

**Channel**: `satusehat_registrasi_upsert` — dipancarkan oleh trigger `fn_notify_registrasi_upsert()`.

**Events yang diproses**:
- `encounter_post` — dispatch `SyncEncounterToSatuSehat($uuid, 'encounter_post')` → POST Encounter
- `encounter_ro` — dispatch `SyncEncounterToSatuSehat($uuid, 'encounter_ro')` → PUT in-progress
- `encounter_dokter` — dispatch `SyncEncounterToSatuSehat($uuid, 'encounter_dokter')` → PUT finished

**Guard di daemon** (sebelum dispatch):
- Event tidak dikenal → skip dengan warning
- `encounter_post` + sudah punya `encounter_id` + status `synced` → skip (sudah ter-sync)

**Di production**, jalankan via Supervisor — lihat `config/supervisor/satusehat-registrasi-listener.conf`.

### `satusehat:sync-encounter`

```bash
php artisan satusehat:sync-encounter [--batch=30] [--date-from=YYYY-MM-DD] [--date-to=YYYY-MM-DD]
```

| Option | Default | Keterangan |
|--------|---------|------------|
| `--batch` | `30` | Jumlah registrasi per run |
| `--date-from` | _(7 hari lalu)_ | Filter tanggal mulai |
| `--date-to` | _(hari ini)_ | Filter tanggal akhir |

Bulk sync registrasi yang belum ter-sync (status `null`, `failed`, `waiting_patient`, `no_location`). Dijalankan otomatis setiap 30 menit via scheduler sebagai jaring pengaman.

### `satusehat:listen-careplan`

```bash
php artisan satusehat:listen-careplan [--timeout=5000] [--max-jobs=1000]
```

| Option | Default | Keterangan |
|--------|---------|------------|
| `--timeout` | `5000` | Timeout polling pg_notify (ms) |
| `--max-jobs` | `1000` | Restart daemon setelah N job (cegah memory leak) |

**Channel**: `satusehat_careplan_notify` — dipicu saat `status_dokter` berubah ke `'Sudah Diperiksa'`.
Di production, jalankan via Supervisor — lihat `config/supervisor/satusehat-careplan-listener.conf`.

### `satusehat:sync-careplan`

```bash
php artisan satusehat:sync-careplan [--batch=30] [--delay=200]
```

Bulk sync CarePlan: picks up semua registrasi dengan `status_dokter = 'Sudah Diperiksa'`, `satusehat_careplan_id IS NULL`, dan status `null`, `failed`, `waiting_encounter`, atau `waiting_patient`.

Dijalankan otomatis setiap 15 menit via scheduler (lihat `Kernel.php`).

### Queue Worker (untuk job)

```bash
php artisan queue:work --queue=default --sleep=3 --tries=3
```

Semua job SatuSehat (`SyncPasienToSatuSehat`, `SyncEncounterToSatuSehat`, `SyncCarePlanToSatuSehat`) membutuhkan queue worker aktif.

---

## 16. Alur Kerja Lengkap (Onboarding)

Checklist untuk setup pertama kali di environment baru:

1. **Isi `.env`** — `SATUSEHAT_CLIENT_ID`, `SATUSEHAT_CLIENT_SECRET`, `SATUSEHAT_ORGANIZATION_ID`, `SATUSEHAT_ENV`
2. **Jalankan SQL** — `psql -f database/sql/satu-sehat.sql` (DDL + trigger + kolom CarePlan)
3. **Sync Wilayah** — UI Wilayah → fetch semua level → update master
4. **Sync Organization** — UI Organization → Sync dari SatuSehat
5. **Sync Location** — UI Location → Sync dari SatuSehat
6. **Sync Practitioner** — UI Practitioner → Sync All (untuk semua dokter/nakes)
7. **Sync Pasien Existing** — UI Pasien → Sync All (untuk pasien lama)
8. **Jalankan Queue Worker** — `php artisan queue:work`
9. **Jalankan Daemon LISTEN (3 daemon)**:
   - `php artisan satusehat:listen-pasien` — auto-sync pasien baru
   - `php artisan satusehat:listen-registrasi` — auto-sync encounter baru
   - `php artisan satusehat:listen-careplan` — auto-sync careplan saat dokter selesai periksa
   - Di production: jalankan ketiganya via Supervisor (lihat Bagian 17)
10. **Aktifkan Laravel Scheduler** — tambahkan cron `* * * * *` di crontab (lihat Bagian 17)
11. **Test** — daftarkan pasien baru → cek `id_satu_sehat` terisi → selesaikan pemeriksaan → cek `satusehat_careplan_id` terisi

---

## 17. Deployment Production

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

### SatuSehat CarePlan Listener (Supervisor)

File: `config/supervisor/satusehat-careplan-listener.conf`

```bash
sudo cp config/supervisor/satusehat-careplan-listener.conf /etc/supervisor/conf.d/
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start satusehat-careplan-listener
```

### Scheduled Commands (Laravel Scheduler)

Di `app/Console/Kernel.php` sudah terdaftar tiga jadwal:

```php
// Safety net: pasien belum sync
$schedule->command('satusehat:sync-patient --batch=50 --delay=300')
         ->hourly()->withoutOverlapping();

// Safety net: encounter pending / waiting_patient
$schedule->command('satusehat:sync-encounter --batch=30 --delay=300')
         ->everyThirtyMinutes()->withoutOverlapping();

// Safety net: careplan pending / waiting_encounter / waiting_patient
$schedule->command('satusehat:sync-careplan --batch=30')
         ->everyFifteenMinutes()->withoutOverlapping();
```

Aktifkan cron (satu baris, berlaku untuk semua scheduler):
```bash
* * * * * cd /var/www/eye-hospital && php artisan schedule:run >> /dev/null 2>&1
```

Verifikasi jadwal terdaftar:
```bash
php artisan schedule:list
```

---

## 18. Troubleshooting

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

**Kemungkinan penyebab (POST):**
- Organization belum di-sync → `identifier_system` kosong, fallback dipakai
- Pasien belum punya `id_satu_sehat`
- Dokter/nakes belum punya `satusehat_ihs_id`
- `satusehat_location_id` tidak terisi di registrasi

**Solusi:** Pastikan urutan onboarding di Bagian 16 diikuti.

### Encounter PUT gagal (event ro / dokter)

**Kemungkinan penyebab:**
- `satusehat_encounter_id` kosong → Encounter belum pernah di-POST; tunggu event `encounter_post` selesai dulu
- Location RO atau Poli tidak ditemukan di `satusehat_locations` → sync Location dari UI terlebih dahulu
- Token SatuSehat expired (sangat jarang, BridgeBase auto-refresh)

**Cek status rollback:**
```sql
-- Lihat history status encounter
SELECT * FROM satusehat_encounter_status_history
WHERE registrasi_uuid = 'your-uuid'
ORDER BY period_start;

-- Cek fhir_status & encounter_status di registrasi
SELECT satusehat_encounter_id, satusehat_encounter_status,
       satusehat_encounter_fhir_status
FROM registrasi WHERE uuid = 'your-uuid';
```

**Reset & retry manual:**
```bash
# Dari UI Encounter Sync → klik Retry Failed
# ATAU reset via SQL (hati-hati):
UPDATE registrasi
SET satusehat_encounter_status = NULL,
    satusehat_encounter_fhir_status = 'arrived'
WHERE uuid = 'your-uuid';
DELETE FROM satusehat_encounter_status_history
WHERE registrasi_uuid = 'your-uuid' AND status IN ('in-progress', 'finished');
```

**Simulasi trigger manual untuk testing:**
```sql
-- Trigger encounter_ro (pastikan encounter_id sudah ada):
UPDATE registrasi SET status_ro = 'Sudah Diperiksa RO'
WHERE uuid = 'your-uuid';

-- Trigger encounter_dokter:
UPDATE registrasi SET status_dokter = 'Sudah Diperiksa'
WHERE uuid = 'your-uuid' AND status_dokter = 'Belum Diperiksa';
```

### Token SatuSehat expired

BridgeBase meng-cache token dan refresh otomatis. Jika tetap gagal, cek `SATUSEHAT_CLIENT_ID` dan `SATUSEHAT_CLIENT_SECRET` di `.env`.

### Daemon LISTEN tidak menerima notifikasi

```bash
# Cek trigger terpasang di tabel pasien
psql -c "SELECT tgname FROM pg_trigger WHERE tgrelid = 'pasien'::regclass;"

# Cek trigger terpasang di tabel registrasi
psql -c "SELECT tgname FROM pg_trigger WHERE tgrelid = 'registrasi'::regclass;"

# Verifikasi fungsi trigger registrasi versi 3-event
psql -c "SELECT prosrc FROM pg_proc WHERE proname = 'fn_notify_registrasi_upsert';"

# Test manual notifikasi pasien
psql -c "LISTEN satusehat_pasien_insert;"
# (di session lain) INSERT INTO pasien (...) VALUES (...);

# Test manual notifikasi encounter (encounter_post)
psql -c "LISTEN satusehat_registrasi_upsert;"
# (di session lain) UPDATE registrasi SET satusehat_location_id = 'loc-id'
#   WHERE uuid = 'your-uuid' AND satusehat_encounter_id IS NULL;
```

### CarePlan tidak ter-sync otomatis

**Kemungkinan penyebab:**
- Queue worker tidak berjalan → `php artisan queue:work`
- Daemon CarePlan tidak berjalan → `sudo supervisorctl status satusehat-careplan-listener`
- Encounter belum ter-sync → status `waiting_encounter`; tunggu scheduler atau sync encounter manual
- Pasien belum punya `id_satu_sehat` → status `waiting_patient`; sync pasien dulu

**Cek log:**
```bash
tail -f /var/log/supervisor/satusehat-careplan-listener.log
tail -f storage/logs/satusehat-sync-careplan.log
```

**Reset & retry dari UI:**
- Buka menu SatuSehat → CarePlan Sync
- Klik **"Retry Failed"** untuk reset status `failed`/`waiting` → trigger ulang bulk sync

**Test notifikasi manual:**
```sql
-- Simulasi trigger careplan
UPDATE registrasi SET status_dokter = 'Sudah Diperiksa'
WHERE uuid = 'your-reg-uuid' AND satusehat_careplan_id IS NULL;
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
