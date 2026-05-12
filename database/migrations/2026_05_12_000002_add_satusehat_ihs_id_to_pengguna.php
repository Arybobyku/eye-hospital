<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah satusehat_ihs_id ke table pengguna.
     * Field ini berisi IHS Number Practitioner dari SatuSehat untuk dokter/nakes,
     * digunakan sebagai referensi di resource Encounter.participant.individual.
     */
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('satusehat_ihs_id', 64)->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn('satusehat_ihs_id');
        });
    }
};
