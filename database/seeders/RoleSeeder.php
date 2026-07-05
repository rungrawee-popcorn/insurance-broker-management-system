<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        Role::create([
            'name' => 'Agent',
            'slug' => 'agent',
        ]);

        Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
        ]);
    }
}