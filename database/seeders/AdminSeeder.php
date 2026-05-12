<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@maison.sn'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'Admin@Maison2025!')),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['admin']);
    }
}
