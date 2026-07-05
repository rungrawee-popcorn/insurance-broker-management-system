<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsuranceCompany;

class InsuranceCompanySeeder extends Seeder
{
    public function run(): void
    {
        InsuranceCompany::create([
            'code' => 'AIA',
            'name' => 'AIA Thailand',
            'phone' => '021111111',
            'email' => 'contact@aia.com',
            'address' => 'Bangkok',
        ]);

        InsuranceCompany::create([
            'code' => 'BKI',
            'name' => 'Bangkok Insurance',
            'phone' => '022222222',
            'email' => 'contact@bangkokinsurance.com',
            'address' => 'Bangkok',
        ]);

        InsuranceCompany::create([
            'code' => 'VIRIYA',
            'name' => 'Viriyah Insurance',
            'phone' => '023333333',
            'email' => 'contact@viriyah.com',
            'address' => 'Bangkok',
        ]);
    }
}