<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PolicyReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Policy::with(['customer', 'insuranceCompany', 'policyType']);

        // =========================
        // SEARCH
        // =========================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('policy_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($c) use ($search) {
                      $c->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('insuranceCompany', function ($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $policies = $query->latest()->paginate(10);

        // =========================
        // STATUS CALCULATION (REAL TIME)
        // =========================
        $today = Carbon::today();

        $total = $policies->total();

        $active = 0;
        $expired = 0;
        $expiring = 0;

        foreach ($policies as $p) {

            $end = Carbon::parse($p->end_date);

            if ($end->lt($today)) {
                $expired++;
                $p->calculated_status = 'expired';

            } elseif ($end->lte($today->copy()->addDays(30))) {
                $expiring++;
                $p->calculated_status = 'expiring';

            } else {
                $active++;
                $p->calculated_status = 'active';
            }
        }

        // =========================
        // CHART (based on ALL data, not only page)
        // =========================
        $allPolicies = Policy::all();

        $chart = [
            'Active' => 0,
            'Expired' => 0,
            'Expiring' => 0,
        ];

        foreach ($allPolicies as $p) {
            $end = Carbon::parse($p->end_date);

            if ($end->lt($today)) {
                $chart['Expired']++;
            } elseif ($end->lte($today->copy()->addDays(30))) {
                $chart['Expiring']++;
            } else {
                $chart['Active']++;
            }
        }

        return view('reports.policies.index', [
            'report' => (object) [
                'summary' => (object) [
                    'total' => $total,
                    'active' => $active,
                    'expired' => $expired,
                    'expiring' => $expiring,
                ],
                'charts' => (object) [
                    'status' => $chart,
                ],
                'policies' => $policies,
            ]
        ]);
    }
}