<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Policy Type Details
            </h2>

            <a
                href="{{ route('policy-types.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            >
                Back
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <div class="bg-white shadow-sm rounded-lg">

                <div class="p-6 space-y-6">

                    <!-- Name -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Name</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $type->name }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-1 text-gray-800">
                            {{ $type->description ?? '-' }}
                        </p>
                    </div>

                    <!-- Timestamps -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                            <p class="text-gray-700">
                                {{ $type->created_at }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Updated At</h3>
                            <p class="text-gray-700">
                                {{ $type->updated_at }}
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 flex gap-3">

                    <a
                        href="{{ route('policy-types.edit', $type->id) }}"
                        class="inline-flex items-center rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600"
                    >
                        Edit
                    </a>

                    <form
                        id="delete-form-{{ $type->id }}"
                        action="{{ route('policy-types.destroy', $type->id) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            onclick="confirmDelete('delete-form-{{ $type->id }}')"
                            class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                        >
                            Delete
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>