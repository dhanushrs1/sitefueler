<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Customer',    'slug' => 'customer',    'description' => 'Standard customer account (default for sign-ups).'],
            ['name' => 'Admin',       'slug' => 'admin',       'description' => 'Manages the store and content via the admin panel.'],
            ['name' => 'Editor',      'slug' => 'editor',      'description' => 'Manages content such as templates, plugins, and blog.'],
            ['name' => 'Support',     'slug' => 'support',     'description' => 'Handles customer support and orders.'],
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full access, including user and role management.'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
