<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\InsuranceCompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\InsuranceCompany;

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
     * Show create form
     */
    public function create(): View
    {
        return view('companies.create');
    }

    /**
     * Store
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9-]+$/',
            ],
            'name' => 'required|string|max:255',
            'phone' => 'nullable|digits_between:9,10',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $this->insuranceCompanyService->create(
            $request->only([
                'code',
                'name',
                'phone',
                'email',
                'address'
            ])
        );

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company created successfully.');
    }

    /**
     * Show
     */
    public function show(int $id): View
    {
        $company = $this->insuranceCompanyService->findById($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Edit
     */
    public function edit(int $id): View
    {
        $company = $this->insuranceCompanyService->findById($id);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9-]+$/',
            ],
            'name' => 'required|string|max:255',
            'phone' => 'nullable|digits_between:9,10',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $this->insuranceCompanyService->update(
            $id,
            $request->only([
                'code',
                'name',
                'phone',
                'email',
                'address'
            ])
        );

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company updated successfully.');
    }

    /**
     * Delete (SOFT DELETE + FLASH MESSAGE)
     */
    public function destroy(int $id): RedirectResponse
    {
        $company = InsuranceCompany::findOrFail($id);

        // Prevent deletion if company has policies
        if ($company->policies()->exists()) {
            return redirect()
                ->route('companies.index')
                ->with('error', 'Cannot delete insurance company because policies exist.');
        }

        $this->insuranceCompanyService->delete($id);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Insurance company deleted successfully.');
    }
}