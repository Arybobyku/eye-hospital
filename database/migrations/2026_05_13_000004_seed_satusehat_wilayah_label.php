<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    public function up(): void
    {
        $label = [
            'nama'   => 'Wilayah',
            'based'  => 'SatuSehat',
            'icon'   => 'map-pin',
            'link'   => '/dashboard/satusehat-wilayah',
            'posisi' => 6,
        ];

        $exists = DB::table('label')
            ->where('link', $label['link'])
            ->where('delete_soft', 1)
            ->exists();

        if (!$exists) {
            DB::table('label')->insert([
                'uuid'        => (string) Uuid::uuid4(),
                'nama'        => $label['nama'],
                'based'       => $label['based'],
                'icon'        => $label['icon'],
                'link'        => $label['link'],
                'posisi'      => $label['posisi'],
                'delete_soft' => 1,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('label')
            ->where('link', '/dashboard/satusehat-wilayah')
            ->delete();
    }
};
