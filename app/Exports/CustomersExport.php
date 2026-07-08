<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * Export Customer Data
     */
    public function collection()
    {
        return Customer::select(
            'first_name',
            'last_name',
            'phone',
            'email',
            'national_id',
            'address'
        )->get();
    }


    /**
     * Excel Header
     */
    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Phone',
            'Email',
            'National ID',
            'Address',
        ];
    }
}