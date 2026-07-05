<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalCompanies = InsuranceCompany::count();
        $totalPolicies = Policy::count();

        $today = Carbon::today();

        // =========================
        // REAL STATUS CALCULATION
        // =========================
        $expiredPolicies = Policy::whereDate('end_date', '<', $today)->count();

        $expiringSoonPolicies = Policy::whereDate('end_date', '>=', $today)
            ->whereDate('end_date', '<=', $today->copy()->addDays(30))
            ->count();

        $monthlyPolicies = Policy::selectRaw('MONTH(start_date) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // =========================
        // RECENT POLICIES (10 records)
        // =========================
        $recentPolicies = Policy::with(['customer', 'insuranceCompany'])
            ->latest()
            ->limit(10)
            ->get();

        // =========================
        // CALCULATE STATUS LIVE
        // =========================
        foreach ($recentPolicies as $p) {

            $end = Carbon::parse($p->end_date);

            if ($end->lt($today)) {
                $p->calculated_status = 'expired';
            } elseif ($end->lte($today->copy()->addDays(30))) {
                $p->calculated_status = 'expiring';
            } else {
                $p->calculated_status = 'active';
            }
        }

        return view('dashboard', [
            'report' => (object) [
                'summary' => (object) [
                    'customers' => $totalCustomers,
                    'companies' => $totalCompanies,
                    'policies' => $totalPolicies,
                    'expired' => $expiredPolicies,
                    'expiringSoon' => $expiringSoonPolicies,
                ],
                'charts' => (object) [
                    'monthlyPolicies' => $monthlyPolicies,
                ],
                'recentPolicies' => $recentPolicies,
            ]
        ]);
    }
}