<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $agentRole = Role::where('slug', 'agent')->first();
        $staffRole = Role::where('slug', 'staff')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ibms.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole?->id,
        ]);

        User::create([
            'name' => 'Agent User',
            'email' => 'agent@ibms.com',
            'password' => Hash::make('password'),
            'role_id' => $agentRole?->id,
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@ibms.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole?->id,
        ]);
    }
}