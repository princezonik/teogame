@extends('layouts.app')
@section('content')
    <div class="container w-[550px]">
        <h1>Submit Your Score</h1>
        <form action="{{ route('scores.store') }}" method="POST" id="score-form">
            @csrf
            <div class="form-group">
                <label for="score">Score</label>
                <input type="number" name="score" id="score" value="{{ old('score') }}" required min="0">
                @error('score')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="game_id">Game ID </label>
                <input type="text" name="game_id" id="game_id" value="" maxlength="255" required>
                @error('game_id')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit">Submit Score</button>
        </form>
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
    </div>

@endsection
@push('styles')
 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .success {
            color: green;
            font-size: 0.9em;
        }
    </style>    
@endpush

@push('scripts')
    <script>
        document.getElementById('score-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]').value,
                    },
                });

                if (response.ok) {
                    form.reset();
                    const successMessage = document.createElement('p');
                    successMessage.className = 'success';
                    successMessage.textContent = 'Score submitted successfully!';
                    form.after(successMessage);
                    setTimeout(() => successMessage.remove(), 3000);
                } else {
                    const error = await response.json();
                    alert('Error: ' + (error.message || 'Failed to submit score'));
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    </script>    
@endpush

