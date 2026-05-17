<?php

namespace App\Observers;

use App\Models\Registrasi;
use App\Jobs\SyncEncounterToSatuSehat;
use Illuminate\Support\Facades\Bus;

/**
 * RegistrasiObserver — Fallback layer untuk auto-sync Encounter ke SatuSehat.
 *
 * ──────────────────────────────────────────────────────────────────────────────
 * PERAN dalam arsitektur dual-layer:
 * ──────────────────────────────────────────────────────────────────────────────
 *
 *   PRIMARY  : PostgreSQL LISTEN/NOTIFY via daemon satusehat:listen-registrasi
 *              → menangkap SEMUA INSERT/UPDATE dari sumber manapun (Eloquent,
 *                DB::table(), raw SQL, migration, seeder)
 *
 *   FALLBACK : Observer ini — hanya menangkap INSERT/UPDATE via Eloquent model
 *              (new Registrasi → save() / $reg->update([...]))
 *              → aktif otomatis sebagai safety net jika daemon tidak berjalan
 *
 * Aman dipakai bersamaan dengan daemon (idempoten):
 *   - Daemon + Observer keduanya dispatch job untuk UUID yang sama
 *   - Job pertama berhasil → job kedua skip (cek encounter_id di awal)
 *
 * ──────────────────────────────────────────────────────────────────────────────
 */
class RegistrasiObserver
{
    /**
     * Dipanggil saat Registrasi baru dibuat via Eloquent.
     * Dispatch job sync encounter setelah HTTP response dikirim ke client.
     */
    public function created(Registrasi $registrasi): void
    {
        $this->maybeDispatch($registrasi);
    }

    /**
     * Dipanggil saat Registrasi diupdate via Eloquent.
     * Dispatch job sync jika encounter belum ter-sync atau gagal.
     *
     * Kondisi re-sync:
     *   - satusehat_encounter_id masih NULL (belum pernah berhasil sync)
     *   - ATAU satusehat_encounter_status = 'failed' / 'waiting_patient' / 'no_location'
     *     (berarti perlu dicoba ulang — kemungkinan pasien sudah di-sync atau
     *     location_id sudah diisi setelah update)
     */
    public function updated(Registrasi $registrasi): void
    {
        // Skip jika sudah berhasil sync (tidak perlu kirim ulang)
        if (
            !empty($registrasi->satusehat_encounter_id) &&
            $registrasi->satusehat_encounter_status === 'synced'
        ) {
            return;
        }

        // Hanya dispatch jika status mengindikasikan perlu retry
        $retryStatuses = ['failed', 'waiting_patient', 'no_location', null, ''];
        if (!in_array($registrasi->satusehat_encounter_status, $retryStatuses, true)) {
            return;
        }

        $this->maybeDispatch($registrasi);
    }

    /**
     * Validasi dasar sebelum dispatch — hemat satu round-trip DB di job jika
     * jelas tidak memenuhi syarat.
     */
    private function maybeDispatch(Registrasi $registrasi): void
    {
        // Hanya proses registrasi aktif
        if (($registrasi->delete_soft ?? 0) != 1) {
            return;
        }

        Bus::dispatchAfterResponse(new SyncEncounterToSatuSehat($registrasi->uuid));
    }
}
