<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Policy Detail
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('policies.edit', $policy->id) }}"
                   class="px-4 py-2 bg-amber-500 text-white rounded-md">
                    Edit
                </a>

                <a href="{{ route('policies.index') }}"
                   class="px-4 py-2 border rounded-md">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto">

            <x-flash-message />

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="flex justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold">
                            {{ $policy->policy_number }}
                        </h1>
                        <p class="text-gray-500">
                            Created by {{ $policy->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>

                        @if($policy->calculated_status == 'active')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">
                                Active
                            </span>

                        @elseif($policy->calculated_status == 'expired')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded">
                                Expired
                            </span>

                        @elseif($policy->calculated_status == 'expiring')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">
                                Expiring Soon
                            </span>

                        @else

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded">
                                {{ ucfirst($policy->calculated_status) }}
                            </span>

                        @endif

                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="text-gray-500">Customer</p>
                        <p>{{ $policy->customer->first_name ?? '' }} {{ $policy->customer->last_name ?? '' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Company</p>
                        <p>{{ $policy->insuranceCompany->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Type</p>
                        <p>{{ $policy->policyType->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Premium</p>
                        <p>{{ number_format($policy->premium, 2) }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Start Date</p>
                        <p>{{ $policy->start_date }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">End Date</p>

                        @php
                            $isExpired = now()->greaterThan($policy->end_date);
                            $daysLeft = now()->diffInDays($policy->end_date, false);
                        @endphp

                        <p class="{{ $isExpired ? 'text-red-600' : ($daysLeft <= 30 ? 'text-yellow-600' : '') }}">
                            {{ $policy->end_date }}
                        </p>

                        @if($isExpired)
                            <small class="text-red-500">Expired</small>
                        @elseif($daysLeft <= 30)
                            <small class="text-yellow-500">Expiring Soon</small>
                        @endif
                    </div>

                </div>

                <!-- Renew -->
                <form action="{{ route('policies.renew', $policy->id) }}" method="POST" class="mt-6">
                    @csrf

                    <input type="date" name="end_date"
                           class="border rounded px-3 py-2">

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Renew
                    </button>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>