<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Policy;
use App\Models\User;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use Carbon\Carbon;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        $customers = Customer::all();
        $companies = InsuranceCompany::all();
        $types = PolicyType::all();

        if ($customers->isEmpty() || $companies->isEmpty() || $types->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 10; $i++) {

            $start = Carbon::now()->subDays(rand(30, 1000));

            // =========================
            // FORCE STATUS DISTRIBUTION
            // =========================

            if ($i <= 3) {
                // Expired 
                $end = Carbon::now()->subDays(rand(1, 500));
                $status = 'Expired';

            } elseif ($i <= 6) {
                // Expiring Soon 
                $end = Carbon::now()->addDays(rand(1, 30));
                $status = 'Expiring';

            } else {
                // Active
                $end = Carbon::now()->addDays(rand(31, 365));
                $status = 'Active';
            }

            Policy::create([
                'policy_number' => 'POL-' . str_pad($i, 5, '0', STR_PAD_LEFT),

                'customer_id' => $customers->random()->id,
                'insurance_company_id' => $companies->random()->id,
                'policy_type_id' => $types->random()->id,
                'user_id' => $admin?->id,

                'start_date' => $start,
                'end_date' => $end,

                'premium' => rand(5000, 80000),

                'status' => $status,
            ]);
        }
    }
}