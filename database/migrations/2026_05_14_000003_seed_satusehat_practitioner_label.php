<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    public function up(): void
    {
        $link = '/dashboard/satusehat-practitioner-sync';

        $exists = DB::table('label')
            ->where('link', $link)
            ->where('delete_soft', 1)
            ->exists();

        if (!$exists) {
            DB::table('label')->insert([
                'uuid'        => (string) Uuid::uuid4(),
                'nama'        => 'Practitioner Sync',
                'based'       => 'SatuSehat',
                'icon'        => 'user-check',
                'link'        => $link,
                'posisi'      => 7,
                'delete_soft' => 1,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('label')
            ->where('link', '/dashboard/satusehat-practitioner-sync')
            ->delete();
    }
};
