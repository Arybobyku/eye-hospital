<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tabel log semua request/response ke SatuSehat API.
 * Berguna untuk debugging integrasi, audit trail, dan monitoring.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satusehat_api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method', 10);               // GET | POST | PUT | PATCH
            $table->text('url');                         // URL lengkap yang dipanggil
            $table->text('request_body')->nullable();    // JSON payload request
            $table->text('response_body')->nullable();   // Raw response string
            $table->smallInteger('http_code')->nullable(); // HTTP status code (200, 404, 422, dst)
            // Konteks: patient_sync | encounter_sync | wilayah | organization | location | token | other
            $table->string('context', 100)->nullable()->index();
            $table->integer('duration_ms')->nullable();  // Durasi response dalam milidetik
            $table->boolean('is_success')->default(false); // true jika http_code 2xx
            $table->timestamp('created_at')->nullable()->useCurrent();
        });

        // Index untuk filter umum
        DB::statement('CREATE INDEX idx_ss_api_logs_created ON satusehat_api_logs (created_at DESC)');
        DB::statement('CREATE INDEX idx_ss_api_logs_method  ON satusehat_api_logs (method)');
        DB::statement('CREATE INDEX idx_ss_api_logs_success ON satusehat_api_logs (is_success)');
    }

    public function down(): void
    {
        Schema::dropIfExists('satusehat_api_logs');
    }
};
