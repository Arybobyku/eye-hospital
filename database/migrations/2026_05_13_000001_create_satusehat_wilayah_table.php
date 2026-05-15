<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cache tabel untuk data wilayah administratif SatuSehat (BPS codes).
 * Level: province | city | district | sub_district
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satusehat_wilayah', function (Blueprint $table) {
            $table->id();
            // province | city | district | sub_district
            $table->string('level', 20)->index();
            // Kode BPS/SatuSehat (2 digit provinsi, 4 kota, 6 kecamatan, 10 kelurahan)
            $table->string('code', 20)->unique();
            $table->string('name', 255);
            // Kode parent (kota → provinsi, kecamatan → kota, kelurahan → kecamatan)
            $table->string('parent_code', 20)->nullable()->index();
            // Raw JSON dari API SatuSehat
            $table->jsonb('raw_data')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satusehat_wilayah');
    }
};
