<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // IHS Number dari SatuSehat (contoh: P02478375538)
            $table->string('id_satu_sehat', 50)->nullable()->default(null)->after('no_identitas');

            /**
             * Status sinkronisasi:
             *   null / 'pending'   → belum diproses
             *   'synced'           → berhasil dapat IHS number
             *   'not_found'        → API mengembalikan 0 hasil (skip permanen)
             *   'failed'           → error saat hit API (akan retry run berikutnya)
             */
            $table->string('satusehat_sync_status', 20)->nullable()->default(null)->after('id_satu_sehat');

            // Waktu terakhir berhasil disync
            $table->timestamp('satusehat_synced_at')->nullable()->default(null)->after('satusehat_sync_status');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['id_satu_sehat', 'satusehat_sync_status', 'satusehat_synced_at']);
        });
    }
};
