<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Hapus kolom override manual ss_*_code dari tabel pasien.
 *
 * Kode wilayah BPS sekarang diambil langsung dari relasi ke tabel master:
 *   provinsi_id  → provinsi.satusehat_code
 *   kab_kota_id  → kab_kota.satusehat_code
 *   kecamatan_id → kecamatan.satusehat_code
 *   kelurahan_id → kelurahan.satusehat_code
 *
 * Pastikan satusehat_code di tabel master sudah terisi via
 *   Dashboard → SatuSehat → Wilayah → Sync ke Master.
 */
return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('ss_province_code',    20)->nullable()->default(null)->after('satusehat_synced_at');
            $table->string('ss_city_code',        20)->nullable()->default(null)->after('ss_province_code');
            $table->string('ss_district_code',    20)->nullable()->default(null)->after('ss_city_code');
            $table->string('ss_subdistrict_code', 20)->nullable()->default(null)->after('ss_district_code');
        });
    }
};
