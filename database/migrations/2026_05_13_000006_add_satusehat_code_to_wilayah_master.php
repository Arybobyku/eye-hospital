<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom satusehat_code ke tabel master wilayah lokal:
 *   provinsi, kab_kota, kecamatan, kelurahan
 *
 * Kolom ini diisi otomatis dari dashboard Wilayah SatuSehat
 * dengan mencocokkan nama wilayah lokal ke kode BPS SatuSehat.
 * Setelah terisi, buildPatientPayload akan menggunakan kode ini
 * untuk address.extension.administrativeCode pada FHIR Patient.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provinsi', function ($table) {
            if (!Schema::hasColumn('provinsi', 'satusehat_code')) {
                $table->string('satusehat_code', 20)->nullable()->default(null);
            }
        });

        Schema::table('kab_kota', function ($table) {
            if (!Schema::hasColumn('kab_kota', 'satusehat_code')) {
                $table->string('satusehat_code', 20)->nullable()->default(null);
            }
        });

        Schema::table('kecamatan', function ($table) {
            if (!Schema::hasColumn('kecamatan', 'satusehat_code')) {
                $table->string('satusehat_code', 20)->nullable()->default(null);
            }
        });

        Schema::table('kelurahan', function ($table) {
            if (!Schema::hasColumn('kelurahan', 'satusehat_code')) {
                $table->string('satusehat_code', 20)->nullable()->default(null);
            }
        });
    }

    public function down(): void
    {
        foreach (['provinsi', 'kab_kota', 'kecamatan', 'kelurahan'] as $tbl) {
            Schema::table($tbl, function ($table) {
                $table->dropColumnIfExists('satusehat_code');
            });
        }
    }
};
