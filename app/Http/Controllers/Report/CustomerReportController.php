<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // =========================
        // SEARCH FILTER
        // =========================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // =========================
        // TOTALS
        // =========================
        $totalCustomers = Customer::count();

        // New monthly customers (last 12 months)
        $monthlyCustomers = Customer::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // =========================
        // DATA LIST
        // =========================
        $customers = $query->latest()->paginate(10);

        return view('reports.customers.index', [
            'report' => (object) [
                'summary' => (object) [
                    'totalCustomers' => $totalCustomers,
                ],
                'charts' => (object) [
                    'monthlyCustomers' => $monthlyCustomers,
                ],
                'customers' => $customers,
            ]
        ]);
    }
}