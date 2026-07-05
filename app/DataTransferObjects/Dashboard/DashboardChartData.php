<?php

namespace App\DataTransferObjects\Dashboard;

final class DashboardChartData
{
    public function __construct(
        public readonly array $monthlyPolicies,
        public readonly array $policyStatus,
    ) {
    }
}