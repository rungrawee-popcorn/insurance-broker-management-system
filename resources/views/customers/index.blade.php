<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers
            </h2>

            <a
                href="{{ route('customers.create') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
            >
                + New Customer
            </a>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <!-- Search -->
            <div class="bg-white shadow-sm rounded-lg mb-6">

                <div class="p-6">

                    <form
                        method="GET"
                        action="{{ route('customers.index') }}"
                    >

                        <div class="flex gap-3">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name, phone or email..."
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <button
                                type="submit"
                                class="rounded-md bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700"
                            >
                                Search
                            </button>

                            @if(request()->filled('search'))

                                <a
                                    href="{{ route('customers.index') }}"
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

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Name
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Phone
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    National ID
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($customers as $customer)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $customer->phone ?: '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $customer->email ?: '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $customer->national_id ?: '-' }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <a
                                                href="{{ route('customers.show', $customer->id) }}"
                                                class="rounded-md bg-sky-600 px-3 py-2 text-sm text-white hover:bg-sky-700"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('customers.edit', $customer->id) }}"
                                                class="rounded-md bg-amber-500 px-3 py-2 text-sm text-white hover:bg-amber-600"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                id="delete-customer-{{ $customer->id }}"
                                                action="{{ route('customers.destroy', $customer->id) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('delete-customer-{{ $customer->id }}')"
                                                    class="rounded-md bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-6 py-10 text-center text-gray-500"
                                    >
                                        No customers found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- Pagination -->

            <div class="mt-6">
                {{ $customers->links() }}
            </div>

        </div>

    </div>

</x-app-layout>