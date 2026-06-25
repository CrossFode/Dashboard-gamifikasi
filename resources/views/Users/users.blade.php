@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Registered Users</h1>
                <a href="{{ route('users.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    + Add User
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($users) && $users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded-lg overflow-hidden">
                        <thead class="bg-green-600 text-white text-sm uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Username</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Role</th>
                                <th class="px-4 py-3 text-left">Points</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($users as $user)
                                @php
                                    $rowNumber = ($users->currentPage() - 1) * $users->perPage() + $loop->iteration;
                                @endphp
                                <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-green-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $rowNumber }}</td>
                                    <td class="px-4 py-3">{{ $user['username'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $user['name'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $user['email'] ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-sm{{ ($user['role'] ?? 'user') === 'admin'
    ? 'bg-green-100 text-green-700 font-semibold'
    : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($user['role'] ?? 'user') }}
                                        </span>
                                    </td>
                                <td class="px-4 py-3 font-semibold text-green-700">
                                    {{ $user['total_points'] ?? $user->total_points ?? '0' }}
                                </td>
                                    <td class="px-4 py-3 flex justify-center gap-2">
                                        <form action="{{ route('users.edit', $user['id']) }}" method="GET">
                                            <button 
                                                type="submit" 
                                                class="bg-green-600 hover:bg-green-700 text-white rounded px-3 py-1.5 text-sm transition flex items-center gap-1"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.1 2.1 0 113.001 3.001L7.5 18.85l-4 1 1-4 12.362-12.363z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('users.delete', $user['id']) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white rounded px-3 py-1.5 text-sm transition flex items-center gap-1"
                                                title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- pagination links --}}
                <div class="mt-4 flex justify-center">
                    <nav class="inline-flex items-center space-x-1 flex-wrap gap-1" aria-label="Pagination">
                        {{-- Previous --}}
                        @if($users->onFirstPage())
                            <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Prev</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Prev</a>
                        @endif

                        {{-- Page Numbers (Smart Pagination) --}}
                        @php
                            $current = $users->currentPage();
                            $last = $users->lastPage();
                            $window = 2; // pages to show around current page
                            $show = [];
                            
                            // Always show first page
                            $show[] = 1;
                            
                            // Show pages around current
                            for ($i = max(2, $current - $window); $i <= min($last - 1, $current + $window); $i++) {
                                $show[] = $i;
                            }
                            
                            // Always show last page if more than 1
                            if ($last > 1) {
                                $show[] = $last;
                            }
                            
                            $show = array_unique(sort($show) ? $show : []);
                        @endphp

                        @php $lastShown = 0; @endphp
                        @foreach($show as $page)
                            {{-- Show ellipsis if gap --}}
                            @if($page - $lastShown > 1)
                                <span class="px-2 py-2 text-gray-500">...</span>
                            @endif

                            {{-- Show page link --}}
                            @if($page == $current)
                                <span class="px-3 py-2 rounded bg-green-600 text-white font-bold">{{ $page }}</span>
                            @else
                                <a href="{{ $users->url($page) }}" class="px-3 py-2 rounded bg-white text-green-600 border border-green-200 hover:bg-green-50">
                                    {{ $page }}
                                </a>
                            @endif

                            @php $lastShown = $page; @endphp
                        @endforeach

                        {{-- Next --}}
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Next</a>
                        @else
                            <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Next</span>
                        @endif
                    </nav>
                </div>
            @else
                <p class="text-gray-500">No users found.</p>
            @endif
        </div>
    </div>
</div>

@endsection