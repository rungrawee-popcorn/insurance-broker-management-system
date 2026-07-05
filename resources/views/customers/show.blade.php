<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer Details
            </h2>

            <div class="flex gap-2">

                <a
                    href="{{ route('customers.edit', $customer->id) }}"
                    class="rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600"
                >
                    Edit
                </a>

                <a
                    href="{{ route('customers.index') }}"
                    class="rounded-md bg-gray-500 px-4 py-2 text-sm font-medium text-white hover:bg-gray-600"
                >
                    Back
                </a>

            </div>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg">

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                First Name
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->first_name }}
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Last Name
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->last_name }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Phone
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->phone ?: '-' }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Email
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->email ?: '-' }}
                            </div>
                        </div>

                        <!-- National ID -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                National ID
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->national_id ?: '-' }}
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Address
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 min-h-[120px]">
                                {{ $customer->address ?: '-' }}
                            </div>
                        </div>

                        <!-- Created -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Created At
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->created_at?->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <!-- Updated -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">
                                Updated At
                            </label>

                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3">
                                {{ $customer->updated_at?->format('d/m/Y H:i') }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>