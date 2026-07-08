<?php

namespace App\Exports;

use App\Models\Policy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PoliciesExport implements FromCollection, WithHeadings
{
    /**
     * Export Policy Data
     */
    public function collection()
    {
        return Policy::with([
            'customer',
            'insuranceCompany',
            'policyType'
        ])
        ->get()
        ->map(function ($policy) {

            return [
                'policy_number' =>
                    $policy->policy_number,

                'customer' =>
                    ($policy->customer->first_name ?? '')
                    .' '.
                    ($policy->customer->last_name ?? ''),

                'company' =>
                    $policy->insuranceCompany->name ?? '-',

                'policy_type' =>
                    $policy->policyType->name ?? '-',

                'start_date' =>
                    $policy->start_date?->format('Y-m-d'),

                'end_date' =>
                    $policy->end_date?->format('Y-m-d'),

                'premium' =>
                    $policy->premium,

                'status' =>
                    ucfirst($policy->calculated_status),
            ];

        });
    }


    /**
     * Excel Header
     */
    public function headings(): array
    {
        return [
            'Policy Number',
            'Customer',
            'Insurance Company',
            'Policy Type',
            'Start Date',
            'End Date',
            'Premium',
            'Status',
        ];
    }
}