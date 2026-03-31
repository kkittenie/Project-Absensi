<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            'Bahasa Inggris',
            'Bahasa Indonesia',
            'PAI',
            'Matematika',
            'IPS',
            'IPA',
            'TIK',
            'Seni Budaya',
            'Bahasa Arab',
            'Bahasa Cirebon',
            'PJOK',
            'PKN',
            'BTQ',
        ];

        foreach ($mapels as $mapel) {
            DB::table('mapels')->updateOrInsert(
                ['nama_mapel' => $mapel],
                []
            );
        }
    }
}