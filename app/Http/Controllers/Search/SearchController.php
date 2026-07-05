<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;

class SearchController extends Controller
{
    /**
     * Global search API
     * Return JSON for AJAX search
     */
    public function index(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([
                'customers' => [],
                'companies' => [],
                'policies' => [],
            ]);
        }

        /*
        |------------------------------------------
        | Customers search
        |------------------------------------------
        */
        $customers = Customer::query()
            ->where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        /*
        |------------------------------------------
        | Insurance Companies search
        |------------------------------------------
        */
        $companies = InsuranceCompany::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        /*
        |------------------------------------------
        | Policies search
        |------------------------------------------
        */
        $policies = Policy::query()
            ->where('policy_number', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json([
            'customers' => $customers,
            'companies' => $companies,
            'policies' => $policies,
        ]);
    }
}