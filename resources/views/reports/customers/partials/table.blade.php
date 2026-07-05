@forelse($customers ?? [] as $c)
<tr class="border-b">

    <td class="py-2">
        {{ $c->first_name }} {{ $c->last_name }}
    </td>

    <td>{{ $c->phone ?? '-' }}</td>
    <td>{{ $c->email ?? '-' }}</td>

    <td>
        {{ $c->created_at
            ? \Carbon\Carbon::parse($c->created_at)->format('Y-m-d')
            : '-' }}
    </td>

</tr>
@empty
<tr>
    <td colspan="4" class="text-center py-4 text-gray-500">
        No data
    </td>
</tr>
@endforelse