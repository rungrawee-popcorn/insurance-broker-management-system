<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreInsuranceCompanyRequest;
use App\Http\Requests\Company\UpdateInsuranceCompanyRequest;
use App\Services\InsuranceCompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InsuranceCompanyController extends Controller
{
    public function __construct(
        private InsuranceCompanyService $insuranceCompanyService
    ) {
    }

    /**
     * Display a listing of insurance companies.
     */
    public function index(Request $request): View
    {
        $companies = $this->insuranceCompanyService->getAll(
            $request->input('search')
        );

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new insurance company.
     */
    public function create(): View
    {
        return view('companies.create');
    }

    /**
     * Store a newly created insurance company.
     */
    public function store(StoreInsuranceCompanyRequest $request): RedirectResponse
    {
        $this->insuranceCompanyService->create(
            $request->validated()
        );

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company created successfully.');
    }

    /**
     * Display the specified insurance company.
     */
    public function show(int $id): View
    {
        $company = $this->insuranceCompanyService->findById($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified insurance company.
     */
    public function edit(int $id): View
    {
        $company = $this->insuranceCompanyService->findById($id);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified insurance company.
     */
    public function update(
        UpdateInsuranceCompanyRequest $request,
        int $id
    ): RedirectResponse {
        $this->insuranceCompanyService->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company updated successfully.');
    }

    /**
     * Remove the specified insurance company.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->insuranceCompanyService->delete($id);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company deleted successfully.');
    }
}