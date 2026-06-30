<?php

namespace Database\Seeders;

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
        User::updateOrCreate(
            ['email' => 'admin@sitefueler.test'],
            [
                'name' => 'SiteFueler Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}
