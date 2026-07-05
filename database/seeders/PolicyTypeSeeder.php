<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PolicyType;

class PolicyTypeSeeder extends Seeder
{
    public function run(): void
    {
        PolicyType::create([
            'name' => 'Life Insurance',
            'description' => 'Life coverage insurance',
        ]);

        PolicyType::create([
            'name' => 'Health Insurance',
            'description' => 'Medical and hospital coverage',
        ]);

        PolicyType::create([
            'name' => 'Car Insurance',
            'description' => 'Vehicle insurance coverage',
        ]);
    }
}