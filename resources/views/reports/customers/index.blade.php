<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Customer Report
    </h2>
</x-slot>

<div class="py-6">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Summary --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="text-gray-500">
            Total Customers
        </div>

        <div class="text-3xl font-bold">
            {{ $report->summary->totalCustomers ?? 0 }}
        </div>
    </div>


    {{-- Export --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">

        <div class="flex gap-3">

            <a href="{{ route('reports.customers.excel') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Export Excel
            </a>

            <a href="{{ route('reports.customers.pdf') }}"
               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Export PDF
            </a>

        </div>

    </div>


    {{-- Search --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">

        <div class="flex gap-2">

            <input type="text"
                   id="searchInput"
                   placeholder="Search customers..."
                   class="border rounded px-3 py-2 w-1/2">

            <button id="searchBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                Search
            </button>

        </div>

    </div>


    {{-- Table --}}
    <div class="bg-white p-6 rounded-lg shadow">

        <table class="w-full text-sm">

            <thead>
                <tr class="border-b text-left">
                    <th class="py-2">Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody id="customerTableBody">

                @include('reports.customers.partials.table', [
                    'customers' => $report->customers
                ])

            </tbody>

        </table>


        <div class="mt-4" id="paginationBox">

            @if(method_exists($report->customers, 'links'))
                {{ $report->customers->links() }}
            @endif

        </div>

    </div>

</div>
</div>


@push('scripts')

<script>

document.getElementById('searchBtn')
.addEventListener('click', function () {

    const keyword =
        document.getElementById('searchInput').value;


    fetch(`/reports/customers?search=${encodeURIComponent(keyword)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    .then(res => res.text())

    .then(html => {

        const doc =
            new DOMParser()
            .parseFromString(html, 'text/html');


        document.getElementById('customerTableBody')
            .innerHTML =
            doc.getElementById('customerTableBody').innerHTML;


        document.getElementById('paginationBox')
            .innerHTML =
            doc.getElementById('paginationBox').innerHTML;

    });

});

</script>

@endpush

</x-app-layout>