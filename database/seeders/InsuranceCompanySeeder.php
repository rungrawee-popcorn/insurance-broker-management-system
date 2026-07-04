<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceCompany;

class InsuranceCompanySeeder extends Seeder
{
    public function run(): void
    {
        InsuranceCompany::insert([
            [
                'code' => 'AIA',
                'name' => 'AIA Insurance',
            ],
            [
                'code' => 'MTL',
                'name' => 'Muang Thai Life',
            ],
            [
                'code' => 'AZL',
                'name' => 'Allianz Ayudhya',
            ],
        ]);
    }
}