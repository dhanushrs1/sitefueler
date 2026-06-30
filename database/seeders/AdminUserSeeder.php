<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the default admin account (idempotent).
     */
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@sitefueler.test'],
            [
                'name' => 'SiteFueler Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
