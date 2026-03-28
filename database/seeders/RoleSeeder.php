<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'provider']);
        // Usuario admin inicial
        $admin = User::firstOrCreate(
            ['email' => 'admin@suplementoshub.com'],
            [
                'name'             => 'Admin',
                'password'         => bcrypt('password'),
                'status'           => 'approved',
                'catalog_active'   => false,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');
    }
}
