<?php

namespace App\Http\Controllers\Policy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Policy;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use Illuminate\Support\Str;

class PolicyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Policy::with(['customer', 'insuranceCompany', 'policyType', 'user']);

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

        $policies = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('policies.index', compact('policies'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('policies.create', [
            'customers' => Customer::all(),
            'companies' => InsuranceCompany::all(),
            'types' => PolicyType::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'insurance_company_id' => 'required',
            'policy_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'premium' => 'required|numeric',
            'status' => 'required',
        ]);

        Policy::create([
            'policy_number' => $this->generatePolicyNumber(),
            'customer_id' => $request->customer_id,
            'insurance_company_id' => $request->insurance_company_id,
            'policy_type_id' => $request->policy_type_id,
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'premium' => $request->premium,
            'status' => $request->status,
        ]);

        return redirect()->route('policies.index')
            ->with('success', 'Policy created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $policy = Policy::with(['customer','insuranceCompany','policyType','user'])
            ->findOrFail($id);

        return view('policies.show', compact('policy'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        return view('policies.edit', [
            'policy' => Policy::findOrFail($id),
            'customers' => Customer::all(),
            'companies' => InsuranceCompany::all(),
            'types' => PolicyType::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (FIXED - SAFE)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        $request->validate([
            'customer_id' => 'required',
            'insurance_company_id' => 'required',
            'policy_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'premium' => 'required|numeric',
            'status' => 'required',
        ]);

        $policy->update([
            'customer_id' => $request->customer_id,
            'insurance_company_id' => $request->insurance_company_id,
            'policy_type_id' => $request->policy_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'premium' => $request->premium,
            'status' => $request->status,
        ]);

        return redirect()->route('policies.index')
            ->with('success', 'Policy updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Policy::findOrFail($id)->delete();

        return redirect()->route('policies.index')
            ->with('success', 'Policy deleted successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | RENEW POLICY
    |--------------------------------------------------------------------------
    */
    public function renew(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        $request->validate([
            'end_date' => 'required|date|after:' . $policy->end_date,
        ]);

        $policy->update([
            'start_date' => $policy->end_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return redirect()->route('policies.show', $id)
            ->with('success', 'Policy renewed successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE POLICY NUMBER
    |--------------------------------------------------------------------------
    */
    private function generatePolicyNumber()
    {
        return 'POL-' . strtoupper(Str::random(8)) . '-' . date('Y');
    }
}