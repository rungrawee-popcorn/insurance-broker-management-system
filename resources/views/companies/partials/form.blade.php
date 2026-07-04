@csrf

<div class="grid grid-cols-1 gap-6">

    <!-- Company Code -->
    <div>
        <label for="code" class="block text-sm font-medium text-gray-700">
            Company Code <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            id="code"
            name="code"
            value="{{ old('code', $company->code ?? '') }}"
            placeholder="Enter company code"
            maxlength="50"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >

        @error('code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Company Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            Company Name <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $company->name ?? '') }}"
            placeholder="Enter company name"
            maxlength="255"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >

        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Phone -->
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">
            Phone
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            value="{{ old('phone', $company->phone ?? '') }}"
            placeholder="Enter phone number"
            maxlength="20"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >

        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $company->email ?? '') }}"
            placeholder="Enter email address"
            maxlength="255"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >

        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">
            Address
        </label>

        <textarea
            id="address"
            name="address"
            rows="4"
            placeholder="Enter company address"
            class="mt-1 block w-full resize-y rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >{{ old('address', $company->address ?? '') }}</textarea>

        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-8 flex items-center gap-3">

    <button
        type="submit"
        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        {{ isset($company) ? 'Update Company' : 'Create Company' }}
    </button>

    <a
        href="{{ route('companies.index') }}"
        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        Cancel
    </a>

</div>