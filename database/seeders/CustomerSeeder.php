<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '0811111111',
            'email' => 'john@example.com',
            'national_id' => '1111111111111',
            'address' => 'Bangkok',
            'created_at' => Carbon::now()->subDays(10),
        ]);

        Customer::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone' => '0822222222',
            'email' => 'jane@example.com',
            'national_id' => '2222222222222',
            'address' => 'Chiang Mai',
            'created_at' => Carbon::now()->subDays(20),
        ]);

        Customer::create([
            'first_name' => 'Michael',
            'last_name' => 'Johnson',
            'phone' => '0833333333',
            'email' => 'michael@example.com',
            'national_id' => '3333333333333',
            'address' => 'Phuket',
            'created_at' => Carbon::now()->subDays(30),
        ]);

        Customer::create([
            'first_name' => 'Emily',
            'last_name' => 'Brown',
            'phone' => '0844444444',
            'email' => 'emily@example.com',
            'national_id' => '4444444444444',
            'address' => 'Khon Kaen',
            'created_at' => Carbon::now()->subDays(40),
        ]);

        Customer::create([
            'first_name' => 'David',
            'last_name' => 'Wilson',
            'phone' => '0855555555',
            'email' => 'david@example.com',
            'national_id' => '5555555555555',
            'address' => 'Chonburi',
            'created_at' => Carbon::now()->subDays(50),
        ]);
    }
}