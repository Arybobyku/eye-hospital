<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom NIK dan status sinkronisasi SatuSehat ke tabel pengguna.
 *
 * - nik                    : NIK (16 digit) untuk lookup Practitioner di SatuSehat
 * - satusehat_sync_status  : status sync (pending / synced / not_found / failed)
 * - satusehat_synced_at    : waktu terakhir sync berhasil
 *
 * satusehat_ihs_id sudah ditambahkan di migration sebelumnya
 * (2026_05_12_000002_add_satusehat_ihs_id_to_pengguna.php)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->default(null);
            $table->string('satusehat_sync_status', 20)->nullable()->default(null);
            $table->timestamp('satusehat_synced_at')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['nik', 'satusehat_sync_status', 'satusehat_synced_at']);
        });
    }
};
