<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Customer',    'slug' => 'customer'],
            ['name' => 'Admin',       'slug' => 'admin'],
            ['name' => 'Editor',      'slug' => 'editor'],
            ['name' => 'Support',     'slug' => 'support'],
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
