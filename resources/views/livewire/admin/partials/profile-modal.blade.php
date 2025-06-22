@php
    $defaultAvatarSmall = 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=40&background=ddd&color=555';
    $defaultAvatarLarge = 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=128&background=ddd&color=555';
@endphp

<div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">

  <!-- Profile button -->
  <button class="flex items-center space-x-3 focus:outline-none cursor-pointer">
    <img
      src="{{ auth()->user()->profile_photo_url ?: $defaultAvatarSmall }}"
      alt="User Photo"
      class="w-10 h-10 rounded-lg object-cover"
    />
   
  </button>

  <!-- Popup Modal -->
  <div
    x-show="open"
    x-transition
    class="absolute right-0 mt-2 w-[300px]   rounded-md shadow-lg border border-gray-200 z-50"
    style="display: none;
    background-color: var(--kt-dark-bg, #fff);
    border: 1px solid var(--kt-dark-border, #e5e7eb);
    color: var(--kt-dark-text, #1f2937);
  "
  >
    <div class="flex p-4 space-x-4">
      <!-- User Image -->
      <img
        src="{{ auth()->user()->profile_photo_url ?: $defaultAvatarLarge }}"
        alt="User Photo"
        class="w-16 h-16 rounded-full object-cover"
      />
      <!-- User Info -->
      <div class="flex flex-col justify-center flex-grow">
        <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
      </div>
      <!-- User Role -->
      <div class="flex items-center">
        <span class="px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded-full">
          {{ auth()->user()->role ?? 'User' }}
        </span>
      </div>
    </div>

    <!-- Divider -->
    <hr class="border-t border-gray-200" />

    <!-- Menu Items -->
    <div class="flex flex-col py-2 text-gray-700">
      <a href="" class="px-4 py-2 hover:bg-gray-100">
        My Profile
      </a>

      <hr class="border-t border-gray-200 my-1" />

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
          Sign Out
        </button>
      </form>
    </div>
  </div>
</div>
