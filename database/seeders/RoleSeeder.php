<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Agent',
                'slug' => 'agent',
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
            ],
        ]);
    }
}