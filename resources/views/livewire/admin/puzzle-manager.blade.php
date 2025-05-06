<div>
    <h2 class="text-xl font-semibold mb-4">Puzzle Manager</h2>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Date</th>
                <th>Seed</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($puzzles as $puzzle)
                <tr>
                    <td>{{ $puzzle->date }}</td>
                    <td>{{ $puzzle->seed }}</td>
                    <td>
                        <button wire:click="regenerate('{{ $puzzle->date }}')" class="text-blue-600">Regenerate</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>