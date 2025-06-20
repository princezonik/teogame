<div class="flex flex-col ml-[265px] p-[50px]">
    <div class="mb-[30px] mt-[30px]" >
        
        <div class="calculator-tabs">
            <h1 class="text-xl font-semibold mb-4">Calculators</h1>
            
            <livewire:admin.partials.breadcrumb :items="[
                [
                    'label' => 'Dashboard', 
                    'url' => route('admin.dashboard')
                ],

                ['label' => 'Usage History']
            ]" />
        </div>

    </div>
  <table class="table-auto w-full">
    <thead>
        <tr>
            <th>User</th>
            <th>Inputs</th>
            <th>Result</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usages as $usage)
            <tr>
                <td>{{ $usage->user->name ?? 'Guest' }}</td>
                <td class="text-sm">{{ json_encode($usage->inputs) }}</td>
                <td class="text-sm">{{ json_encode($usage->result) }}</td>
                <td>{{ $usage->created_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
