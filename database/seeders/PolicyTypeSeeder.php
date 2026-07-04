<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PolicyType;

class PolicyTypeSeeder extends Seeder
{
    public function run(): void
    {
        PolicyType::insert([
            [
                'name' => 'Life Insurance',
                'description' => 'Life coverage insurance',
            ],
            [
                'name' => 'Health Insurance',
                'description' => 'Medical and hospital coverage',
            ],
            [
                'name' => 'Car Insurance',
                'description' => 'Vehicle insurance coverage',
            ],
        ]);
    }
}