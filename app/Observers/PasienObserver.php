<?php

namespace App\Observers;

use App\Models\Pasien;
use App\Jobs\SyncPasienToSatuSehat;
use Illuminate\Support\Facades\Bus;

/**
 * PasienObserver — mendengarkan Eloquent events pada model Pasien.
 *
 * Didaftarkan di AppServiceProvider::boot() via:
 *   Pasien::observe(PasienObserver::class);
 *
 * Observer ini HANYA berjalan ketika pasien dibuat via Eloquent (new Pasien → save()).
 * Insert raw via DB::table('pasien')->insert() TIDAK akan memicu observer ini —
 * hal ini disengaja karena insert raw dipakai hanya untuk migrasi data lama.
 */
class PasienObserver
{
    /**
     * Dipanggil setiap kali Pasien baru berhasil disimpan ke database.
     *
     * Bus::dispatchAfterResponse() memastikan job dijalankan SETELAH HTTP response
     * dikirim ke client — sehingga proses simpan pasien di UI tidak terganggu.
     *
     * Dengan QUEUE_CONNECTION=sync  → berjalan di proses yang sama, setelah response
     * Dengan QUEUE_CONNECTION=database/redis → diproses worker secara async
     */
    public function created(Pasien $pasien): void
    {
        // Lewati jika sudah memiliki IHS ID (misal: diisi manual saat import)
        if (!empty($pasien->id_satu_sehat)) {
            return;
        }

        // Lewati jika NIK tidak valid — tidak bisa di-POST ke SatuSehat
        $nik = trim($pasien->no_identitas ?? '');
        if (!preg_match('/^\d{16}$/', $nik)) {
            return;
        }

        // Dispatch job setelah response dikirim ke client
        Bus::dispatchAfterResponse(new SyncPasienToSatuSehat($pasien->uuid));
    }

    /**
     * Dipanggil setiap kali data Pasien diupdate.
     *
     * Jika NIK berubah dan IHS ID lama tidak valid lagi, bisa ditambahkan
     * logika re-sync di sini di masa mendatang. Untuk saat ini, update tidak
     * memicu auto-sync karena update pasien biasanya bukan perubahan NIK.
     */
    public function updated(Pasien $pasien): void
    {
        // Cek apakah NIK berubah dan IHS ID belum ada (atau perlu re-sync)
        // Aktifkan blok ini jika ingin auto-sync saat NIK pasien diubah:
        //
        // if ($pasien->wasChanged('no_identitas') && empty($pasien->id_satu_sehat)) {
        //     $nik = trim($pasien->no_identitas ?? '');
        //     if (preg_match('/^\d{16}$/', $nik)) {
        //         Bus::dispatchAfterResponse(new SyncPasienToSatuSehat($pasien->uuid));
        //     }
        // }
    }
}
