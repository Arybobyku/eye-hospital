<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom kode wilayah SatuSehat (BPS codes) ke tabel pasien.
 * Kolom ini diisi dari dashboard Wilayah setelah admin melakukan mapping/fetch.
 * Digunakan saat build Patient FHIR payload (address.extension administrativeCode).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            // Kode BPS SatuSehat — berbeda dari provinsi_id/kab_kota_id lokal
            $table->string('ss_province_code',    20)->nullable()->default(null)->after('satusehat_synced_at');
            $table->string('ss_city_code',        20)->nullable()->default(null)->after('ss_province_code');
            $table->string('ss_district_code',    20)->nullable()->default(null)->after('ss_city_code');
            $table->string('ss_subdistrict_code', 20)->nullable()->default(null)->after('ss_district_code');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn([
                'ss_province_code',
                'ss_city_code',
                'ss_district_code',
                'ss_subdistrict_code',
            ]);
        });
    }
};
