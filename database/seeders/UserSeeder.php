<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['username' => 'superadmin'],
            [
                'uuid' => Str::uuid(),
                'name' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'is_active' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}