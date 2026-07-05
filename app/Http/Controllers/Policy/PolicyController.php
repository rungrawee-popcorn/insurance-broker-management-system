<?php

namespace App\Http\Controllers\Policy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PolicyController extends Controller
{
    public function index(Request $request)
    {
        // exclude soft deleted records
        $query = Policy::with(['customer', 'insuranceCompany', 'policyType', 'user'])
            ->whereNull('deleted_at');

        /*
        |-------------------------
        | GLOBAL SEARCH
        |-------------------------
        */
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

        /*
        |-------------------------
        | STATUS FILTER
        |-------------------------
        */
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |-------------------------
        | COMPANY FILTER
        |-------------------------
        */
        if ($request->filled('company_id')) {
            $query->where('insurance_company_id', $request->company_id);
        }

        /*
        |-------------------------
        | POLICY TYPE FILTER
        |-------------------------
        */
        if ($request->filled('policy_type_id')) {
            $query->where('policy_type_id', $request->policy_type_id);
        }

        /*
        |-------------------------
        | EXPIRY FILTER
        |-------------------------
        | expired | soon | valid
        */
        if ($request->filled('expiry')) {

            if ($request->expiry === 'expired') {
                $query->whereDate('end_date', '<', today());
            }

            if ($request->expiry === 'soon') {
                $query->whereDate('end_date', '>=', today())
                      ->whereDate('end_date', '<=', today()->copy()->addDays(30));
            }

            if ($request->expiry === 'valid') {
                $query->whereDate('end_date', '>', today()->copy()->addDays(30));
            }
        }

        $policies = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        /*
        |-------------------------
        | REALTIME STATUS CALCULATION
        |-------------------------
        */
        $today = Carbon::today();

        foreach ($policies as $policy) {

            $end = Carbon::parse($policy->end_date);

            if ($end->lt($today)) {
                $policy->calculated_status = 'expired';
            } elseif ($end->lte($today->copy()->addDays(30))) {
                $policy->calculated_status = 'expiring';
            } else {
                $policy->calculated_status = 'active';
            }
        }

        return view('policies.index', compact('policies'));
    }

    public function create()
    {
        return view('policies.create', [
            'customers' => Customer::all(),
            'companies' => InsuranceCompany::all(),
            'types' => PolicyType::all(),
        ]);
    }

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

    public function show($id)
    {
        $policy = Policy::with(['customer','insuranceCompany','policyType','user'])
            ->findOrFail($id);

        /*
        |-------------------------
        | REALTIME STATUS CALCULATION
        |-------------------------
        */
        $today = Carbon::today();
        $end = Carbon::parse($policy->end_date);

        if ($end->lt($today)) {
            $policy->calculated_status = 'expired';
        } elseif ($end->lte($today->copy()->addDays(30))) {
            $policy->calculated_status = 'expiring';
        } else {
            $policy->calculated_status = 'active';
        }

        return view('policies.show', compact('policy'));
    }

    public function edit($id)
    {
        return view('policies.edit', [
            'policy' => Policy::findOrFail($id),
            'customers' => Customer::all(),
            'companies' => InsuranceCompany::all(),
            'types' => PolicyType::all(),
        ]);
    }

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

        $policy->update($request->only([
            'customer_id',
            'insurance_company_id',
            'policy_type_id',
            'start_date',
            'end_date',
            'premium',
            'status'
        ]));

        return redirect()->route('policies.index')
            ->with('success', 'Policy updated successfully');
    }

    public function destroy($id)
    {
        $policy = Policy::findOrFail($id);

        // soft delete
        $policy->delete();

        return redirect()->route('policies.index')
            ->with('success', 'Policy deleted successfully (soft delete)');
    }

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

    private function generatePolicyNumber()
    {
        return 'POL-' . strtoupper(Str::random(8)) . '-' . date('Y');
    }
}