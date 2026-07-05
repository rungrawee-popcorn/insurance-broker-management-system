<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search (name, phone, email)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('id', 'desc')->paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store new customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'  => 'required',
            'last_name'   => 'required',
            'phone'       => 'nullable',
            'email'       => 'nullable|email',
            'national_id' => 'nullable',
            'address'     => 'nullable',
        ]);

        Customer::create($request->all());

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display customer details
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show edit form
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update customer
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name'  => 'required',
            'last_name'   => 'required',
            'phone'       => 'nullable',
            'email'       => 'nullable|email',
            'national_id' => 'nullable',
            'address'     => 'nullable',
        ]);

        $customer->update($request->all());

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Soft delete customer
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}