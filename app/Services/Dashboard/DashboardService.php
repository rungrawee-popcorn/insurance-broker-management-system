<?php

namespace App\Services\Dashboard;

use App\DataTransferObjects\Dashboard\DashboardChartData;
use App\DataTransferObjects\Dashboard\DashboardData;
use App\DataTransferObjects\Dashboard\DashboardStatisticsData;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\ActivityLog;

class DashboardService
{
    public function getDashboardData(): DashboardData
    {
        return new DashboardData(
            statistics: $this->getStatistics(),
            charts: $this->getCharts(),
            activities: $this->getActivities(),
            expiringPolicies: $this->getExpiringPolicies(),
        );
    }

    private function getStatistics(): DashboardStatisticsData
    {
        return new DashboardStatisticsData(
            totalCustomers: Customer::count(),
            totalCompanies: InsuranceCompany::count(),
            totalPolicies: Policy::count(),
            expiredPolicies: Policy::expired()->count(),
            expiringSoonPolicies: Policy::expiringSoon()->count(),
        );
    }

    private function getCharts(): DashboardChartData
    {
        $monthly = Policy::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyPolicies = [];

        foreach ($monthly as $month => $total) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            $monthlyPolicies[$monthName] = $total;
        }

        $status = Policy::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return new DashboardChartData(
            monthlyPolicies: $monthlyPolicies,
            policyStatus: $status->toArray(),
        );
    }

    private function getActivities(): array
    {
        return ActivityLog::latest()
            ->take(10)
            ->get()
            ->map(fn ($log) => [
                'action' => $log->action,
                'description' => $log->description,
                'created_at' => $log->created_at->format('d M Y H:i'),
            ])
            ->toArray();
    }

    private function getExpiringPolicies(): array
    {
        return Policy::with('customer')
            ->expiringSoon()
            ->orderBy('end_date')
            ->take(10)
            ->get()
            ->map(fn ($policy) => [
                'policy_number' => $policy->policy_number,
                'customer_name' => $policy->customer->first_name . ' ' . $policy->customer->last_name,
                'end_date' => $policy->end_date->format('d M Y'),
                'days_left' => today()->diffInDays($policy->end_date, false),
            ])
            ->toArray();
    }
}