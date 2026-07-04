<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company Details
            </h2>

            <div class="flex gap-2">

                <a
                    href="{{ route('companies.edit', $company->id) }}"
                    class="rounded-md bg-amber-500 px-4 py-2 text-sm text-white hover:bg-amber-600"
                >
                    Edit
                </a>

                <a
                    href="{{ route('companies.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                    Back
                </a>

            </div>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Code -->
                    <div>
                        <p class="text-sm text-gray-500">Company Code</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $company->code }}
                        </p>
                    </div>

                    <!-- Name -->
                    <div>
                        <p class="text-sm text-gray-500">Company Name</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $company->name }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="text-lg text-gray-800">
                            {{ $company->phone ?? '-' }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg text-gray-800">
                            {{ $company->email ?? '-' }}
                        </p>
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-lg text-gray-800 whitespace-pre-line">
                            {{ $company->address ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>