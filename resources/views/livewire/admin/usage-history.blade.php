<div class="ml-[266px]">
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Calculator Usage History</h2>

    <table class="w-full table-auto bg-white rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">User</th>
                <th class="p-2 text-left">Calculator</th>
                <th class="p-2 text-left">IP Address</th>
                <th class="p-2 text-left">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usages as $usage)
                <tr class="border-t">
                    <td class="p-2">{{ $usage->user->name ?? 'Guest' }}</td>
                    <td class="p-2">{{ $usage->calculator->title ?? '-' }}</td>
                    <td class="p-2 text-sm text-gray-600">{{ $usage->ip_address }}</td>
                    <td class="p-2">{{ $usage->created_at->format('M d, Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $usages->links() }}
    </div>
</div>
</div>
