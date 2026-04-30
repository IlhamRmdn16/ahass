<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'entry']);
        Role::create(['name' => 'viewer']);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@suryawijaya.com',
            'password' => Hash::make('rahasia161102'),
        ]);

        $superAdmin->assignRole('super_admin');
    }
}
