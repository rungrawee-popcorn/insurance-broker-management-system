<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>
        Customer Report
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }

    </style>

</head>

<body>


<h2>
    Customer Report
</h2>


<table>

<thead>

<tr>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>National ID</th>
    <th>Address</th>
</tr>

</thead>


<tbody>

@foreach($customers as $customer)

<tr>

    <td>
        {{ $customer->first_name }}
        {{ $customer->last_name }}
    </td>


    <td>
        {{ $customer->phone ?? '-' }}
    </td>


    <td>
        {{ $customer->email ?? '-' }}
    </td>


    <td>
        {{ $customer->national_id ?? '-' }}
    </td>


    <td>
        {{ $customer->address ?? '-' }}
    </td>

</tr>

@endforeach

</tbody>

</table>


</body>
</html>