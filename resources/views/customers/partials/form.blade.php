@csrf

@if(isset($customer))
    @method('PUT')
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- First Name -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            First Name <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="first_name"
            value="{{ old('first_name', $customer->first_name ?? '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >

        @error('first_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Last Name -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Last Name <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="last_name"
            value="{{ old('last_name', $customer->last_name ?? '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >

        @error('last_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Phone
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone', $customer->phone ?? '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email', $customer->email ?? '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >

        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- National ID -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            National ID
        </label>

        <input
            type="text"
            name="national_id"
            value="{{ old('national_id', $customer->national_id ?? '') }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >
    </div>

    <!-- Address -->
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Address
        </label>

        <textarea
            name="address"
            rows="4"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >{{ old('address', $customer->address ?? '') }}</textarea>
    </div>

</div>

<div class="mt-8 flex justify-end gap-3">

    <a
        href="{{ route('customers.index') }}"
        class="rounded-md border border-gray-300 px-5 py-2 hover:bg-gray-100"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="rounded-md bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700"
    >
        {{ isset($customer) ? 'Update Customer' : 'Create Customer' }}
    </button>

</div>