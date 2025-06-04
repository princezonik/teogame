<x-app-layout>

    @section('content')
        <h1>Admin Login</h1>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <label for="email">Emailll:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    @endsection
</x-app-layout>