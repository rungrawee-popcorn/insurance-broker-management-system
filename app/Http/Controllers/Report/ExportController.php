<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

use App\Exports\CustomersExport;
use App\Exports\PoliciesExport;

use App\Models\Customer;
use App\Models\Policy;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;


class ExportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Excel Export
    |--------------------------------------------------------------------------
    */


    public function customersExcel()
    {
        return Excel::download(
            new CustomersExport,
            'customers.xlsx'
        );
    }


    public function policiesExcel()
    {
        return Excel::download(
            new PoliciesExport,
            'policies.xlsx'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | PDF Export
    |--------------------------------------------------------------------------
    */


    public function customersPdf()
    {
        $customers = Customer::latest()->get();


        $pdf = Pdf::loadView(
            'reports.pdf.customers',
            [
                'customers' => $customers
            ]
        );


        return $pdf->download(
            'customers-report.pdf'
        );
    }



    public function policiesPdf()
    {
        $policies = Policy::with([
            'customer',
            'insuranceCompany',
            'policyType'
        ])
        ->latest()
        ->get();


        $pdf = Pdf::loadView(
            'reports.pdf.policies',
            [
                'policies' => $policies
            ]
        );


        return $pdf->download(
            'policies-report.pdf'
        );
    }

}