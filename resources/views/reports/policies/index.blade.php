<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Policy Report
    </h2>
</x-slot>

<div class="py-6">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-6 rounded shadow">
            <div class="text-sm text-gray-500">
                Total
            </div>
            <div class="text-2xl font-bold">
                {{ $report->summary->total ?? 0 }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <div class="text-sm text-green-500">
                Active
            </div>
            <div class="text-2xl font-bold text-green-600">
                {{ $report->summary->active ?? 0 }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <div class="text-sm text-red-500">
                Expired
            </div>
            <div class="text-2xl font-bold text-red-600">
                {{ $report->summary->expired ?? 0 }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <div class="text-sm text-yellow-500">
                Expiring
            </div>
            <div class="text-2xl font-bold text-yellow-600">
                {{ $report->summary->expiring ?? 0 }}
            </div>
        </div>

    </div>


    {{-- EXPORT --}}
    <div class="bg-white p-6 rounded shadow mb-6">

        <div class="flex gap-3">

            <a href="{{ route('reports.policies.excel') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Export Excel
            </a>


            <a href="{{ route('reports.policies.pdf') }}"
               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Export PDF
            </a>

        </div>

    </div>


    {{-- CHART --}}
    <div class="bg-white p-6 rounded shadow mb-6">

        <h3 class="font-semibold mb-4 text-center">
            Policy Status Breakdown
        </h3>


        <div class="flex justify-center">

            <div class="w-56 h-56">
                <canvas id="statusChart"></canvas>
            </div>

        </div>

    </div>


    {{-- SEARCH --}}
    <div class="bg-white p-6 rounded shadow mb-6">

        <div class="flex gap-2 justify-center">

            <input type="text"
                   id="searchInput"
                   placeholder="Search policy number / customer..."
                   class="border px-3 py-2 rounded w-1/2">


            <button id="searchBtn"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Search
            </button>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="bg-white p-6 rounded shadow">

        <table class="w-full text-sm">

            <thead>
            <tr class="border-b text-left">
                <th class="py-2">Policy</th>
                <th>Customer</th>
                <th>Company</th>
                <th>Status</th>
                <th>End Date</th>
            </tr>
            </thead>


            <tbody id="policyTableBody">

            @foreach($report->policies as $p)

                @php
                    $status = strtolower($p->calculated_status ?? $p->status);
                @endphp


                <tr class="border-b hover:bg-gray-50">

                    <td class="py-2 font-medium">
                        {{ $p->policy_number }}
                    </td>


                    <td>
                        {{ $p->customer->first_name ?? '-' }}
                        {{ $p->customer->last_name ?? '' }}
                    </td>


                    <td>
                        {{ $p->insuranceCompany->name ?? '-' }}
                    </td>


                    <td>

                        @if($status === 'active')

                            <span class="text-green-600 font-semibold">
                                Active
                            </span>

                        @elseif($status === 'expired')

                            <span class="text-red-600 font-semibold">
                                Expired
                            </span>

                        @else

                            <span class="text-yellow-600 font-semibold">
                                Expiring
                            </span>

                        @endif

                    </td>


                    <td>
                        {{ $p->end_date?->format('Y-m-d') ?? '-' }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>


        <div class="mt-4" id="paginationBox">
            {{ $report->policies->links() }}
        </div>

    </div>

</div>
</div>


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const statusData =
    @json($report->charts->status ?? []);


new Chart(document.getElementById('statusChart'), {

    type: 'pie',

    data: {

        labels: Object.keys(statusData),

        datasets: [{
            data: Object.values(statusData),
            backgroundColor:[
                '#22c55e',
                '#ef4444',
                '#f59e0b'
            ]
        }]

    }

});



document.getElementById('searchBtn')
.addEventListener('click', function(){

    const keyword =
        document.getElementById('searchInput').value;


    fetch(`/reports/policies?search=${encodeURIComponent(keyword)}`, {

        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }

    })

    .then(res => res.text())

    .then(html => {

        const doc =
            new DOMParser()
            .parseFromString(html,'text/html');


        const newTable =
            doc.getElementById('policyTableBody');


        const newPage =
            doc.getElementById('paginationBox');


        if(newTable){

            document.getElementById('policyTableBody')
                .innerHTML =
                newTable.innerHTML;

        }


        if(newPage){

            document.getElementById('paginationBox')
                .innerHTML =
                newPage.innerHTML;

        }

    });

});

</script>

@endpush

</x-app-layout>