<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Insurance Policies
            </h2>

            <a
                href="{{ route('policies.create') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
            >
                + New Policy
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <!-- Search -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="p-6">

                    <form method="GET" action="{{ route('policies.index') }}">
                        <div class="flex gap-3">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search policy number, customer, company..."
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <button
                                class="rounded-md bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700"
                            >
                                Search
                            </button>

                            @if(request()->filled('search'))
                                <a
                                    href="{{ route('policies.index') }}"
                                    class="rounded-md border border-gray-300 px-5 py-2 hover:bg-gray-100"
                                >
                                    Clear
                                </a>
                            @endif

                        </div>
                    </form>

                </div>
            </div>

            <!-- Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Policy #
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Customer
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Company
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Type
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Premium
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Expiry
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($policies as $policy)

                                <tr class="hover:bg-gray-50">

                                    <!-- Policy Number -->
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $policy->policy_number }}
                                    </td>

                                    <!-- Customer -->
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $policy->customer->first_name ?? '' }}
                                        {{ $policy->customer->last_name ?? '' }}
                                    </td>

                                    <!-- Company -->
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $policy->insuranceCompany->name ?? '-' }}
                                    </td>

                                    <!-- Type -->
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $policy->policyType->name ?? '-' }}
                                    </td>

                                    <!-- Premium -->
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ number_format($policy->premium, 2) }}
                                    </td>

                                    <!-- Expiry -->
                                    <td class="px-6 py-4">

                                        @php
                                            $isExpiringSoon = now()->diffInDays($policy->end_date, false) <= 30;
                                            $isExpired = now()->greaterThan($policy->end_date);
                                        @endphp

                                        <span class="{{ $isExpired ? 'text-red-600 font-semibold' : ($isExpiringSoon ? 'text-yellow-600 font-semibold' : 'text-gray-700') }}">
                                            {{ $policy->end_date }}
                                        </span>

                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 text-center">

                                        @if($policy->status == 'active')
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                                Active
                                            </span>
                                        @elseif($policy->status == 'expired')
                                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                                Expired
                                            </span>
                                        @elseif($policy->status == 'cancelled')
                                            <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                                Pending
                                            </span>
                                        @endif

                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <a
                                                href="{{ route('policies.show', $policy->id) }}"
                                                class="px-3 py-1 text-sm bg-sky-600 text-white rounded hover:bg-sky-700"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('policies.edit', $policy->id) }}"
                                                class="px-3 py-1 text-sm bg-amber-500 text-white rounded hover:bg-amber-600"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                id="delete-form-{{ $policy->id }}"
                                                action="{{ route('policies.destroy', $policy->id) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('delete-form-{{ $policy->id }}')"
                                                    class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-10 text-gray-500">
                                        No policies found
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $policies->links() }}
            </div>

        </div>

    </div>

</x-app-layout>