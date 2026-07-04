<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Policy Types
            </h2>

            <a
                href="{{ route('policy-types.create') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
            >
                + New Policy Type
            </a>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <!-- Search -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="p-6">

                    <form method="GET" action="{{ route('policy-types.index') }}">
                        <div class="flex gap-3">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name or description..."
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
                                    href="{{ route('policy-types.index') }}"
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

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                                    Name
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                                    Description
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase text-gray-600">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($types as $type)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $type->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $type->description ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <a
                                                href="{{ route('policy-types.show', $type->id) }}"
                                                class="rounded-md bg-sky-600 px-3 py-2 text-sm text-white hover:bg-sky-700"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('policy-types.edit', $type->id) }}"
                                                class="rounded-md bg-amber-500 px-3 py-2 text-sm text-white hover:bg-amber-600"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                id="delete-form-{{ $type->id }}"
                                                action="{{ route('policy-types.destroy', $type->id) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('delete-form-{{ $type->id }}')"
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
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                        No policy types found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $types->links() }}
            </div>

        </div>

    </div>

</x-app-layout>