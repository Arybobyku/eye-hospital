<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom SatuSehat Encounter ke table registrasi:
     *   - satusehat_encounter_id      : IHS Encounter ID yang dikembalikan SatuSehat setelah POST berhasil
     *   - satusehat_encounter_status  : null (pending) | synced | failed
     *   - satusehat_encounter_synced_at: waktu terakhir berhasil sync
     *   - satusehat_location_id       : SatuSehat Location ID untuk poli yang digunakan
     */
    public function up(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->string('satusehat_encounter_id',     64)->nullable()->default(null)->after('id');
            $table->string('satusehat_encounter_status', 20)->nullable()->default(null)->after('satusehat_encounter_id');
            $table->timestamp('satusehat_encounter_synced_at')->nullable()->default(null)->after('satusehat_encounter_status');
            $table->string('satusehat_location_id',      64)->nullable()->default(null)->after('satusehat_encounter_synced_at');
        });
    }

    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn([
                'satusehat_encounter_id',
                'satusehat_encounter_status',
                'satusehat_encounter_synced_at',
                'satusehat_location_id',
            ]);
        });
    }
};
