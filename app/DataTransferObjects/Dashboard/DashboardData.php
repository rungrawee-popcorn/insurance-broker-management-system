<?php

namespace App\DataTransferObjects\Dashboard;

final class DashboardData
{
    public function __construct(
        public readonly DashboardStatisticsData $statistics,
        public readonly DashboardChartData $charts,
        public readonly array $activities,
        public readonly array $expiringPolicies,
    ) {}
}