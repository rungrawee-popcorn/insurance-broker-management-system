<?php

namespace App\Http\Controllers\PolicyType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PolicyType;

class PolicyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PolicyType::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $types = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('policy-types.index', compact('types'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('policy-types.create');
    }

    /**
     * Store new policy type
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:policy_types,name',
            'description' => 'nullable',
        ]);

        PolicyType::create($request->only([
            'name',
            'description'
        ]));

        return redirect()
            ->route('policy-types.index')
            ->with('success', 'Policy Type created successfully');
    }

    /**
     * Display single record
     */
    public function show($id)
    {
        $type = PolicyType::findOrFail($id);

        return view('policy-types.show', compact('type'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $type = PolicyType::findOrFail($id);

        return view('policy-types.edit', compact('type'));
    }

    /**
     * Update existing record
     */
    public function update(Request $request, $id)
    {
        $type = PolicyType::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:policy_types,name,' . $id,
            'description' => 'nullable',
        ]);

        $type->update($request->only([
            'name',
            'description'
        ]));

        return redirect()
            ->route('policy-types.index')
            ->with('success', 'Policy Type updated successfully');
    }

    /**
     * Delete record
     */
    public function destroy($id)
    {
        $type = PolicyType::findOrFail($id);

        $type->delete();

        return redirect()
            ->route('policy-types.index')
            ->with('success', 'Policy Type deleted successfully');
    }
}