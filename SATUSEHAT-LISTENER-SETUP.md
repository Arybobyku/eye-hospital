# Setup Auto-Sync SatuSehat via PostgreSQL LISTEN/NOTIFY

Panduan menjalankan daemon listener untuk auto-sync **Pasien** dan **Encounter (Registrasi)** ke SatuSehat secara real-time menggunakan PostgreSQL LISTEN/NOTIFY.

---

## Daftar Isi

1. [Prasyarat](#1-prasyarat)
2. [Setup Database (Wajib, sekali saja)](#2-setup-database-wajib-sekali-saja)
3. [Development](#3-development)
4. [Production (Supervisor)](#4-production-supervisor)
5. [Verifikasi & Monitoring](#5-verifikasi--monitoring)
6. [Troubleshooting](#6-troubleshooting)

---

## 1. Prasyarat

- PostgreSQL (bukan MySQL/SQLite) — LISTEN/NOTIFY hanya didukung PostgreSQL
- PHP dengan ekstensi `pdo_pgsql` aktif
- Ekstensi `pcntl` aktif (untuk graceful shutdown via SIGTERM)
- Queue worker berjalan (job di-dispatch ke queue)
- `.env` sudah terisi: `SATUSEHAT_CLIENT_ID`, `SATUSEHAT_CLIENT_SECRET`, `SATUSEHAT_ORGANIZATION_ID`

**Cek ekstensi PHP:**
```bash
php -m | grep -E "pdo_pgsql|pcntl"
# Harus muncul keduanya
```

---

## 2. Setup Database (Wajib, sekali saja)

Jalankan SQL migration untuk membuat trigger PostgreSQL. Wajib dijalankan sekali sebelum daemon bisa menerima notifikasi.

```bash
psql -U postgres -d nama_database -f database/sql/satu-sehat.sql
```

Atau lewat Laravel tinker jika koneksi DB sudah dikonfigurasi:
```bash
php artisan db:seed --class=SatuSehatSqlSeeder
```

**Verifikasi trigger terpasang:**
```bash
psql -U postgres -d nama_database -c "
SELECT tgname, tgrelid::regclass AS table_name
FROM pg_trigger
WHERE tgname IN ('trg_pasien_inserted', 'trg_registrasi_upsert')
ORDER BY tgname;
"
```

Output yang diharapkan:
```
           tgname           | table_name
----------------------------+------------
 trg_pasien_inserted        | pasien
 trg_registrasi_upsert      | registrasi
```

---

## 3. Development

Di environment development, jalankan semua proses secara manual di terminal terpisah.

### 3.1 Queue Worker

Diperlukan agar job yang di-dispatch oleh daemon diproses. Buka **Terminal 1**:

```bash
php artisan queue:work --sleep=3 --tries=3 --timeout=60
```

> Jika menggunakan `QUEUE_CONNECTION=sync` di `.env`, queue worker tidak diperlukan — job langsung dieksekusi sinkron. Namun untuk testing yang lebih realistis, gunakan `QUEUE_CONNECTION=database`.

### 3.2 Daemon Pasien Listener

Buka **Terminal 2**:

```bash
php artisan satusehat:listen-pasien
```

Dengan opsi kustom:
```bash
php artisan satusehat:listen-pasien --timeout=5000 --max-jobs=1000
```

Output awal yang diharapkan:
```
[SatuSehat Listener] Memulai daemon — channel: satusehat_pasien_insert
[SatuSehat Listener] PID: 12345
[SatuSehat Listener] LISTEN aktif pada channel: satusehat_pasien_insert
```

### 3.3 Daemon Registrasi Listener

Buka **Terminal 3**:

```bash
php artisan satusehat:listen-registrasi
```

Dengan opsi kustom:
```bash
php artisan satusehat:listen-registrasi --timeout=5000 --max-jobs=1000
```

Output awal yang diharapkan:
```
[SatuSehat Registrasi Listener] Memulai daemon — channel: satusehat_registrasi_upsert
[SatuSehat Registrasi Listener] PID: 12346
[SatuSehat Registrasi Listener] LISTEN aktif pada channel: satusehat_registrasi_upsert
```

### 3.4 Test Manual

Buka **Terminal 4** dan test trigger secara langsung lewat psql:

```bash
# Masuk ke psql
psql -U postgres -d nama_database

# Test notifikasi pasien (simulasi INSERT)
INSERT INTO pasien (uuid, nama, no_identitas, delete_soft, ...)
VALUES (gen_random_uuid(), 'Test Pasien', '3273011234560001', 1, ...);

# Pantau di Terminal 2 — seharusnya muncul:
# [SatuSehat Listener] ✓ Dispatched job untuk pasien <uuid>
```

### 3.5 Hentikan Daemon

Tekan `Ctrl+C` di terminal daemon untuk graceful shutdown:
```
^C
[SatuSehat Listener] Daemon dihentikan (graceful shutdown).
```

---

## 4. Production (Supervisor)

Di production, semua proses dikelola oleh **Supervisor** agar restart otomatis jika crash.

### 4.1 Install Supervisor

```bash
sudo apt-get update
sudo apt-get install -y supervisor
```

### 4.2 Install Config Files

```bash
# Copy semua config listener ke Supervisor
sudo cp config/supervisor/satusehat-listener.conf \
        /etc/supervisor/conf.d/

sudo cp config/supervisor/satusehat-registrasi-listener.conf \
        /etc/supervisor/conf.d/
```

> Sesuaikan path `/var/www/eye-hospital` di dalam file `.conf` jika path project Anda berbeda.

### 4.3 (Opsional) Config Queue Worker

Buat file `/etc/supervisor/conf.d/eye-hospital-worker.conf`:

```ini
[program:eye-hospital-worker]
command=/usr/bin/php /var/www/eye-hospital/artisan queue:work --sleep=3 --tries=3 --max-time=3600
directory=/var/www/eye-hospital
user=www-data
numprocs=2
autostart=true
autorestart=true
startretries=10
startsecs=3
stdout_logfile=/var/log/supervisor/eye-hospital-worker.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stderr_logfile=/var/log/supervisor/eye-hospital-worker-error.log
```

### 4.4 Aktifkan & Jalankan

```bash
# Reload konfigurasi Supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Jalankan semua program
sudo supervisorctl start satusehat-listener
sudo supervisorctl start satusehat-registrasi-listener
sudo supervisorctl start eye-hospital-worker   # jika ada

# Atau jalankan semua sekaligus
sudo supervisorctl start all
```

Output `reread` dan `update` yang diharapkan:
```
satusehat-listener: added
satusehat-registrasi-listener: added
```

---

### 4.5 Verifikasi Setelah Copy Config

Ikuti langkah-langkah berikut untuk memastikan daemon berjalan dengan benar.

#### Langkah 1 — Cek Status

```bash
sudo supervisorctl status
```

**✅ Berhasil** — statusnya `RUNNING`:
```
satusehat-listener              RUNNING   pid 4821, uptime 0:00:15
satusehat-registrasi-listener   RUNNING   pid 4822, uptime 0:00:15
```

**❌ Gagal** — statusnya `FATAL` atau `BACKOFF`:
```
satusehat-listener              FATAL     Exited too quickly (process log may have details)
```

#### Langkah 2 — Cek Log jika FATAL atau BACKOFF

```bash
sudo tail -30 /var/log/supervisor/satusehat-listener-error.log
sudo tail -30 /var/log/supervisor/satusehat-registrasi-listener-error.log
```

Penyebab umum yang muncul di log error:

| Pesan Error | Solusi |
|-------------|--------|
| `No such file or directory` | Path project di `.conf` salah — sesuaikan `/var/www/eye-hospital` |
| `SQLSTATE: connection refused` | Database belum jalan atau `DB_HOST` di `.env` salah |
| `Call to undefined function pgsqlGetNotify` | Ekstensi `pdo_pgsql` belum aktif di PHP |
| `ENV file not found` | Jalankan daemon dari direktori project yang benar |
| `permission denied` | User `www-data` tidak punya akses ke folder project |

#### Langkah 3 — Test Notifikasi Berjalan

Pantau log real-time di **Terminal 1**:

```bash
sudo tail -f /var/log/supervisor/satusehat-listener.log
```

Lakukan insert pasien baru lewat aplikasi atau psql di **Terminal 2**:

```bash
psql -U postgres -d nama_database -c "
INSERT INTO pasien (uuid, nama, no_identitas, delete_soft, jenis_kelamin, tanggal_lahir)
VALUES (gen_random_uuid(), 'Test Pasien', '3273011234560001', 1, 'laki-laki', '1990-01-01');
"
```

**✅ Berhasil** — muncul di log:
```
[SatuSehat Listener] LISTEN aktif pada channel: satusehat_pasien_insert
[SatuSehat Listener] ✓ Dispatched job untuk pasien abc-123 (NIK: 3273011234560001) — total: 1
```

#### Langkah 4 — Konfirmasi Job Diproses

Cek tabel pasien — `id_satu_sehat` harus terisi setelah beberapa detik:

```bash
psql -U postgres -d nama_database -c "
SELECT uuid, nama, id_satu_sehat, satusehat_sync_status, satusehat_synced_at
FROM pasien
ORDER BY id DESC
LIMIT 5;
"
```

Atau cek job yang gagal jika `id_satu_sehat` tidak terisi:

```bash
php artisan queue:failed
```

---

### Referensi Cepat Status Supervisor

| Status | Arti | Tindakan |
|--------|------|----------|
| `RUNNING` | ✅ Berjalan normal | — |
| `STARTING` | Sedang start, tunggu sebentar | Tunggu lalu cek ulang |
| `BACKOFF` | Gagal start, sedang retry otomatis | Cek error log |
| `FATAL` | Gagal total setelah semua retry | Perbaiki error → `sudo supervisorctl start <name>` |
| `STOPPED` | Sengaja dihentikan | `sudo supervisorctl start <name>` |

---

### 4.6 Perintah Supervisor Lainnya

```bash
# Restart satu program
sudo supervisorctl restart satusehat-listener
sudo supervisorctl restart satusehat-registrasi-listener

# Stop
sudo supervisorctl stop satusehat-listener

# Reload setelah perubahan kode (deploy baru)
sudo supervisorctl restart all

# Lihat log real-time
sudo tail -f /var/log/supervisor/satusehat-listener.log
sudo tail -f /var/log/supervisor/satusehat-registrasi-listener.log
```

### 4.7 Setup Cron untuk Laravel Scheduler

Tambahkan ke crontab (untuk bulk-sync encounter via scheduler):

```bash
sudo crontab -e -u www-data
```

Tambahkan baris:
```cron
* * * * * cd /var/www/eye-hospital && php artisan schedule:run >> /dev/null 2>&1
```

---

## 5. Verifikasi & Monitoring

### Cek Trigger Aktif di PostgreSQL

```sql
SELECT
    tgname       AS trigger_name,
    tgrelid::regclass AS table_name,
    CASE tgenabled WHEN 'O' THEN 'ENABLED' ELSE 'DISABLED' END AS status
FROM pg_trigger
WHERE tgname IN ('trg_pasien_inserted', 'trg_registrasi_upsert');
```

### Pantau Log Daemon

```bash
# Development
php artisan satusehat:listen-pasien      # log langsung di terminal

# Production
tail -f /var/log/supervisor/satusehat-listener.log
tail -f /var/log/supervisor/satusehat-registrasi-listener.log
```

### Cek Antrian Job yang Gagal

```bash
php artisan queue:failed
php artisan queue:retry all   # retry semua job gagal
```

### Cek Status Sync di Database

```sql
-- Pasien: berapa yang belum sync?
SELECT satusehat_sync_status, COUNT(*) 
FROM pasien 
WHERE delete_soft = 1 
GROUP BY satusehat_sync_status;

-- Registrasi: status encounter?
SELECT satusehat_encounter_status, COUNT(*)
FROM registrasi
WHERE delete_soft = 1
GROUP BY satusehat_encounter_status;

-- Log API terbaru
SELECT method, url, http_code, is_success, duration_ms, created_at
FROM satusehat_api_logs
ORDER BY created_at DESC
LIMIT 20;
```

---

## 6. Troubleshooting

### Daemon langsung berhenti / tidak muncul di `supervisorctl status`

**Penyebab**: Error saat startup (koneksi DB gagal, `.env` tidak terbaca, ekstensi PHP tidak ada).

```bash
# Lihat log error
sudo tail -50 /var/log/supervisor/satusehat-listener-error.log

# Test manual sebagai user www-data
sudo -u www-data php /var/www/eye-hospital/artisan satusehat:listen-pasien
```

### Notifikasi diterima daemon tapi job tidak diproses

**Penyebab**: Queue worker tidak berjalan.

```bash
# Development
php artisan queue:work

# Production — cek status worker
sudo supervisorctl status eye-hospital-worker
```

### Pasien ter-insert tapi tidak ada notifikasi di daemon

**Penyebab 1**: Trigger tidak terpasang — jalankan ulang SQL migration.
```bash
psql -U postgres -d nama_database -f database/sql/satu-sehat.sql
```

**Penyebab 2**: NIK tidak valid (bukan 16 digit) atau `delete_soft != 1` — trigger tidak kirim notifikasi untuk kondisi ini (by design).

**Penyebab 3**: Daemon mendengarkan channel berbeda — pastikan `CHANNEL` di command sama dengan nama channel di trigger.

### Error `pgsqlGetNotify(): not a PostgreSQL connection`

Koneksi database di `.env` bukan PostgreSQL. Pastikan `DB_CONNECTION=pgsql`.

### `pcntl` tidak tersedia — graceful shutdown tidak bekerja

```bash
# Install ekstensi pcntl
sudo apt-get install php-pcntl

# Atau aktifkan di php.ini
extension=pcntl
```

Tanpa `pcntl`, daemon tetap berjalan normal — hanya tidak bisa graceful shutdown via SIGTERM (Supervisor akan paksa kill setelah `stopwaitsecs`).

### Encounter stuck di status `waiting_patient`

Pasien belum di-sync ke SatuSehat. Setelah pasien ter-sync, jalankan bulk sync encounter untuk pick up registrasi dengan status ini:

```bash
php artisan satusehat:sync-encounter --batch=50
```

Atau klik tombol **Sync** di UI Encounter dashboard.
