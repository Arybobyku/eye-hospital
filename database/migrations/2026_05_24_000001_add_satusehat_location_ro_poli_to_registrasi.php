<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah dua kolom SatuSehat Location ke tabel registrasi untuk
 * melacak lokasi pasien saat masuk ke ruang RO dan Poli dokter.
 *
 * Flow lokasi pasien:
 *   Pendaftaran → satusehat_location_id      (Front Office Lantai 1)
 *   Masuk RO    → satusehat_location_ro_id   (Refraksi Optisi)
 *   Masuk Poli  → satusehat_location_poli_id (Poli Mata / sesuai ruang_poliklinik)
 *                 + satusehat_location_id diupdate ke poli agar encounter sync pakai poli
 *
 * Semua kolom berisi satusehat_id dari tabel satusehat_locations (FHIR Location.id).
 * EncounterBuilder akan menggunakan ketiga ID ini untuk mengisi location[] di Encounter.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->string('satusehat_location_ro_id',   64)
                  ->nullable()->default(null)
                  ->after('satusehat_location_id')
                  ->comment('SatuSehat Location ID ruang Refraksi Optisi (diisi saat pasien masuk RO)');

            $table->string('satusehat_location_poli_id', 64)
                  ->nullable()->default(null)
                  ->after('satusehat_location_ro_id')
                  ->comment('SatuSehat Location ID poli dokter (diisi saat pasien dipanggil masuk poli)');
        });
    }

    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn(['satusehat_location_ro_id', 'satusehat_location_poli_id']);
        });
    }
};
