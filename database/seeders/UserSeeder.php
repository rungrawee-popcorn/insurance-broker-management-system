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

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ibms.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}