<?php

namespace App\Services\Policy;

use App\Models\Policy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PolicyQueryService
{
    public function get(Request $request)
    {
        $query = Policy::with(['customer', 'insuranceCompany', 'policyType', 'user']);

        // =========================
        // GLOBAL SEARCH
        // =========================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('policy_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('insuranceCompany', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // =========================
        // STATUS FILTER
        // =========================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // =========================
        // COMPANY FILTER
        // =========================
        if ($request->filled('company_id')) {
            $query->where('insurance_company_id', $request->company_id);
        }

        // =========================
        // POLICY TYPE FILTER
        // =========================
        if ($request->filled('policy_type_id')) {
            $query->where('policy_type_id', $request->policy_type_id);
        }

        // =========================
        // EXPIRY FILTER (7 / 30 / 60 days)
        // =========================
        if ($request->filled('expiry')) {
            $days = (int) $request->expiry;

            $query->whereDate('end_date', '>=', today())
                ->whereDate('end_date', '<=', Carbon::today()->addDays($days));
        }

        return $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
    }
}