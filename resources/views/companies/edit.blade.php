<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Insurance Company
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <div class="bg-white shadow-sm rounded-lg">

                <div class="p-6">

                    <form
                        action="{{ route('companies.update', $company->id) }}"
                        method="POST"
                    >
                        @method('PUT')

                        @include('companies.partials.form')

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>