@forelse($policies ?? [] as $p)
<tr class="border-b hover:bg-gray-50">

    <td class="py-2 font-medium">{{ $p->policy_number ?? '-' }}</td>

    <td>
        {{ $p->customer->first_name ?? '-' }}
        {{ $p->customer->last_name ?? '' }}
    </td>

    <td>{{ $p->insuranceCompany->name ?? '-' }}</td>

    <td>
        @php $status = strtolower($p->status ?? ''); @endphp

        @if($status === 'active')
            <span class="text-green-600">Active</span>
        @elseif($status === 'expired')
            <span class="text-red-600">Expired</span>
        @else
            <span class="text-gray-600">{{ $p->status }}</span>
        @endif
    </td>

    <td>
        {{ $p->end_date ? \Carbon\Carbon::parse($p->end_date)->format('Y-m-d') : '-' }}
    </td>

</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4 text-gray-500">
        No data
    </td>
</tr>
@endforelse