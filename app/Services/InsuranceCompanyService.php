<?php

namespace App\Services;

use App\Models\InsuranceCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InsuranceCompanyService
{
    /**
     * Get all insurance companies with search and pagination.
     */
    public function getAll(?string $search = null): LengthAwarePaginator
    {
        $query = InsuranceCompany::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Get a single insurance company by ID.
     */
    public function findById(int $id): InsuranceCompany
    {
        return InsuranceCompany::findOrFail($id);
    }

    /**
     * Create a new insurance company.
     */
    public function create(array $data): InsuranceCompany
    {
        return InsuranceCompany::create($data);
    }

    /**
     * Update an existing insurance company.
     */
    public function update(int $id, array $data): InsuranceCompany
    {
        $company = $this->findById($id);

        $company->update($data);

        return $company;
    }

    /**
     * Delete an insurance company.
     */
    public function delete(int $id): void
    {
        $company = $this->findById($id);

        $company->delete();
    }
}