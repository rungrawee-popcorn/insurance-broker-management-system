<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>
    Policy Report
</title>


<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
}


h2 {
    text-align:center;
}


table {

    width:100%;
    border-collapse:collapse;

}


th,
td {

    border:1px solid #333;
    padding:5px;

}


th {

    background:#eeeeee;

}


</style>

</head>


<body>


<h2>
    Policy Report
</h2>


<table>


<thead>

<tr>

<th>
Policy Number
</th>

<th>
Customer
</th>

<th>
Company
</th>

<th>
Type
</th>

<th>
Start Date
</th>

<th>
End Date
</th>

<th>
Premium
</th>

<th>
Status
</th>


</tr>

</thead>



<tbody>


@foreach($policies as $policy)


<tr>


<td>
{{ $policy->policy_number }}
</td>


<td>

{{ $policy->customer->first_name ?? '' }}

{{ $policy->customer->last_name ?? '' }}

</td>


<td>
{{ $policy->insuranceCompany->name ?? '-' }}
</td>


<td>
{{ $policy->policyType->name ?? '-' }}
</td>


<td>
{{ $policy->start_date?->format('Y-m-d') ?? '-' }}
</td>


<td>
{{ $policy->end_date?->format('Y-m-d') ?? '-' }}
</td>


<td>
{{ number_format($policy->premium,2) }}
</td>


<td>
{{ ucfirst($policy->calculated_status) }}
</td>


</tr>


@endforeach


</tbody>


</table>


</body>

</html>