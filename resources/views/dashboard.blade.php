<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ========================= -->
            <!-- SUMMARY REPORT -->
            <!-- ========================= -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Customers</div>
                    <div class="text-2xl font-bold">
                        {{ $report->summary->customers }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Companies</div>
                    <div class="text-2xl font-bold">
                        {{ $report->summary->companies }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Policies</div>
                    <div class="text-2xl font-bold">
                        {{ $report->summary->policies }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-red-500 text-sm">Expired</div>
                    <div class="text-2xl font-bold text-red-600">
                        {{ $report->summary->expired }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-yellow-500 text-sm">Expiring Soon</div>
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $report->summary->expiringSoon }}
                    </div>
                </div>

            </div>

            <!-- ========================= -->
            <!-- CHART -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Policy Monthly Report</h3>
                <canvas id="policyChart" height="100"></canvas>
            </div>

            <!-- ========================= -->
            <!-- RECENT REPORT TABLE -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-lg shadow">

                <h3 class="text-lg font-semibold mb-4">
                    Recent Policies Report
                </h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Policy</th>
                            <th>Customer</th>
                            <th>Company</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($report->recentPolicies as $policy)
                            <tr class="border-b">
                                <td class="py-2">{{ $policy->policy_number }}</td>
                                <td>{{ $policy->customer->first_name ?? '-' }}</td>
                                <td>{{ $policy->insuranceCompany->name ?? '-' }}</td>

                                {{-- ========================= --}}
                                {{-- REAL STATUS (SAFE FALLBACK) --}}
                                {{-- ========================= --}}
                                @php
                                    $status = $policy->calculated_status ?? strtolower($policy->status);

                                    // กันค่าพังจาก DB เช่น Active / ACTIVE
                                    $status = strtolower($status);
                                @endphp

                                <td>
                                    @if($status === 'active')
                                        <span class="text-green-600 font-semibold">Active</span>

                                    @elseif($status === 'expired')
                                        <span class="text-red-600 font-semibold">Expired</span>

                                    @else
                                        <span class="text-yellow-600 font-semibold">Expiring Soon</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <!-- ========================= -->
    <!-- CHART SCRIPT -->
    <!-- ========================= -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = Object.keys(@json($report->charts->monthlyPolicies));
        const data = Object.values(@json($report->charts->monthlyPolicies));

        new Chart(document.getElementById('policyChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Policies',
                    data: data
                }]
            }
        });
    </script>
    @endpush

</x-app-layout>