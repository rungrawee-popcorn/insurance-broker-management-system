<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Insurance Policy
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <div class="bg-white shadow-sm rounded-lg">

                <div class="p-6">

                    <form action="{{ route('policies.update', $policy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">

                            <!-- Policy Number (read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Policy Number
                                </label>

                                <input
                                    type="text"
                                    value="{{ $policy->policy_number }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-600"
                                    readonly
                                >
                            </div>

                            <!-- Customer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Customer <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="customer_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">-- Select Customer --</option>

                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $policy->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('customer_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Insurance Company -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Insurance Company <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="insurance_company_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">-- Select Company --</option>

                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $policy->insurance_company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('insurance_company_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Policy Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Policy Type <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="policy_type_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="">-- Select Policy Type --</option>

                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $policy->policy_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('policy_type_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Start Date <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    value="{{ $policy->start_date }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >

                                @error('start_date')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    End Date <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    value="{{ $policy->end_date }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >

                                @error('end_date')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Premium -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Premium Amount <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="premium"
                                    value="{{ $policy->premium }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >

                                @error('premium')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Status <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option value="active" {{ $policy->status == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="pending" {{ $policy->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="cancelled" {{ $policy->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>

                                @error('status')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="mt-8 flex gap-3">

                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                                Update Policy
                            </button>

                            <a
                                href="{{ route('policies.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>