<div class="max-w-md mx-auto p-4">
    <form wire:submit.prevent="login">
        <input type="email" wire:model="email" placeholder="Email" class="w-full mb-2" />
        <input type="password" wire:model="password" placeholder="Password" class="w-full mb-2" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Login</button>
        @if(session('error'))
            <div class="text-red-600 mt-2">{{ session('error') }}</div>
        @endif
    </form>
</div>
