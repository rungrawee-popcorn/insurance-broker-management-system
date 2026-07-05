<?php

namespace App\Services\Search;

use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;

class SearchService
{
    /**
     * Global search across all modules
     */
    public function globalSearch(string $keyword): array
    {
        return [
            'customers' => $this->searchCustomers($keyword),
            'companies' => $this->searchCompanies($keyword),
            'policies'  => $this->searchPolicies($keyword),
        ];
    }

    /**
     * Search customers
     */
    private function searchCustomers(string $keyword): array
    {
        return Customer::query()
            ->where('first_name', 'like', "%{$keyword}%")
            ->orWhere('last_name', 'like', "%{$keyword}%")
            ->orWhere('phone', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Search insurance companies
     */
    private function searchCompanies(string $keyword): array
    {
        return InsuranceCompany::query()
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('code', 'like', "%{$keyword}%")
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Search policies
     */
    private function searchPolicies(string $keyword): array
    {
        return Policy::query()
            ->where('policy_number', 'like', "%{$keyword}%")
            ->orWhereHas('customer', function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%");
            })
            ->limit(10)
            ->get()
            ->toArray();
    }
}