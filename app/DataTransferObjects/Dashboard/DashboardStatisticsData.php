<?php

namespace App\DataTransferObjects\Dashboard;

final class DashboardStatisticsData
{
    public function __construct(
        public readonly int $totalCustomers,
        public readonly int $totalCompanies,
        public readonly int $totalPolicies,
        public readonly int $expiredPolicies,
        public readonly int $expiringSoonPolicies,
    ) {
    }
}