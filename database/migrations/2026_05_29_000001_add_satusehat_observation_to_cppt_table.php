<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tambah kolom SatuSehat Observation ke tabel cppt.
 * Setiap baris CPPT (dengan asesmen IS NOT NULL) akan di-sync sebagai FHIR Observation.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cppt', function (Blueprint $table) {
            $table->string('satusehat_observation_id',     64)->nullable()->after('sebagai');
            $table->string('satusehat_observation_status', 20)->nullable()->after('satusehat_observation_id');
            $table->timestamp('satusehat_observation_synced_at')->nullable()->after('satusehat_observation_status');
        });

        DB::statement("COMMENT ON COLUMN cppt.satusehat_observation_id     IS 'FHIR Observation.id dari SatuSehat API'");
        DB::statement("COMMENT ON COLUMN cppt.satusehat_observation_status IS 'null | waiting_patient | waiting_encounter | waiting_assessment | synced | failed'");
        DB::statement("COMMENT ON COLUMN cppt.satusehat_observation_synced_at IS 'Waktu terakhir berhasil sync ke SatuSehat'");

        DB::statement('CREATE INDEX IF NOT EXISTS idx_cppt_ss_obs_status ON cppt (satusehat_observation_status) WHERE satusehat_observation_status IS NOT NULL');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_cppt_registrasi_uuid ON cppt (registrasi_uuid)');
    }

    public function down(): void
    {
        Schema::table('cppt', function (Blueprint $table) {
            $table->dropColumn([
                'satusehat_observation_id',
                'satusehat_observation_status',
                'satusehat_observation_synced_at',
            ]);
        });
    }
};
