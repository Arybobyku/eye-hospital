<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    public function up(): void
    {
        $labels = [
            [
                'nama'   => 'Patient Sync',
                'based'  => 'SatuSehat',
                'icon'   => 'users',
                'link'   => '/dashboard/satusehat-patient-sync',
                'posisi' => 4,
            ],
        ];

        foreach ($labels as $label) {
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
    }

    public function down(): void
    {
        DB::table('label')
            ->where('link', '/dashboard/satusehat-patient-sync')
            ->delete();
    }
};
