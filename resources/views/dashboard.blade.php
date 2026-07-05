<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ========================= -->
            <!-- STATISTICS -->
            <!-- ========================= -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Customers</div>
                    <div class="text-2xl font-bold">
                        {{ $dashboard->statistics->totalCustomers }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Companies</div>
                    <div class="text-2xl font-bold">
                        {{ $dashboard->statistics->totalCompanies }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-500 text-sm">Policies</div>
                    <div class="text-2xl font-bold">
                        {{ $dashboard->statistics->totalPolicies }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-red-500 text-sm">Expired</div>
                    <div class="text-2xl font-bold text-red-600">
                        {{ $dashboard->statistics->expiredPolicies }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-yellow-500 text-sm">Expiring Soon</div>
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $dashboard->statistics->expiringSoonPolicies }}
                    </div>
                </div>

            </div>

            <!-- ========================= -->
            <!-- CHART -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Policy Overview
                </h3>

                <canvas id="policyChart" height="100"></canvas>
            </div>

            <!-- ========================= -->
            <!-- RECENT ACTIVITIES -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Recent Activities
                </h3>

                @forelse($dashboard->activities as $activity)
                    <div class="border-b py-3">
                        <div class="font-medium text-gray-800">
                            {{ $activity['action'] }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $activity['description'] }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $activity['created_at'] }}
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-sm">
                        No activities found
                    </div>
                @endforelse
            </div>

            <!-- ========================= -->
            <!-- EXPIRING POLICIES -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">
                    Expiring Policies
                </h3>

                @forelse($dashboard->expiringPolicies as $policy)
                    <div class="border-b py-3">
                        <div class="font-medium text-gray-800">
                            {{ $policy['policy_number'] }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $policy['customer_name'] }}
                        </div>
                        <div class="text-sm text-red-600">
                            Expires {{ $policy['end_date'] }}
                            ({{ $policy['days_left'] }} days left)
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-sm">
                        No expiring policies
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- ========================= -->
    <!-- CHART SCRIPT -->
    <!-- ========================= -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json(array_keys($dashboard->charts->monthlyPolicies));
        const data = @json(array_values($dashboard->charts->monthlyPolicies));

        new Chart(document.getElementById('policyChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Policies',
                    data: data
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
    @endpush

</x-app-layout>