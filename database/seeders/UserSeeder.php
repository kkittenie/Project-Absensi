<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $superadmin = User::firstOrCreate(
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'superadmin',
                'username' => 'superadmin',
                'password' => bcrypt('superadmin'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );
        $superadmin->assignRole($superadminRole);

        $admin = User::firstOrCreate(
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        $admin->assignRole($adminRole);
    }
}
