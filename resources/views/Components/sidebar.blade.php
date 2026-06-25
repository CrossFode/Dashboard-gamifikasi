<aside class="w-64 bg-white text-gray-800 min-h-screen flex flex-col rounded-xl shadow-lg">
    <div class="p-6 flex items-center">
        <img src="{{ asset('images/logo web.png') }}" class="w-16 h-16 object-cover rounded-md">
    </div>

    <nav class="flex-1 p-6">
        <div class="mb-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">Menu</div>

        {{-- Dashboard --}}
        <a href="{{ url('/dashboard') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('dashboard') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="3" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Dashboard
        </a>

        {{-- Profile --}}
        <a href="{{ url('/profile') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('profile') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Profile
        </a>

        {{-- Users --}}
        <a href="{{ url('/users') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('users') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15.644 7A4.992 4.992 0 0112 9c-1.657 0-3.156-.804-4.144-2M15.644 7A4.992 4.992 0 0018 4.99999c0-.17-.006-.338-.018-.506M15.644 7L12 9m0 0L8.356 7M12 9v12"/>
            </svg>
            Users
        </a>

        {{-- Tasks --}}
        <a href="{{ url('/tasks') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('tasks') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
            </svg>
            Tasks
        </a>

        {{-- Periods --}}
        <a href="{{ url('/periods') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('periods') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Periods 
        </a>

        {{-- Completions --}}
        <a href="{{ url('/completions') }}"
           class="flex items-center px-4 py-2 rounded-lg mb-2 transition {{ request()->is('completions') ? 'bg-green-100 text-green-700 font-semibold' : 'hover:bg-green-700 hover:text-white' }}">
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2l4 -4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
            </svg>
            Completions
        </a>
    </nav>

    

    <div class="p-4 border-gray-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-center">
                Logout
            </button>
        </form>
    </div>
</aside>
