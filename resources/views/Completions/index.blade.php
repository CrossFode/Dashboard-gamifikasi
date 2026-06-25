@extends('layouts.template')
@section('content')

    <div class="flex">
        <x-sidebar />

        <div class="w-full min-h-screen bg-gray-100 p-8">
            <div class="bg-white shadow-lg rounded-2xl p-6">
                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <h1 class="text-3xl font-bold text-gray-800">Completions</h1>

                    <div class="flex flex-wrap gap-3 items-center">
                        {{-- Add Completion Button --}}
                        <a href="{{ route('completions.create') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            + Add Completion
                        </a>
                    </div>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Completions Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded-lg overflow-hidden">
                        <thead class="bg-green-600 text-white text-sm uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">User</th>
                                <th class="px-4 py-3 text-left">Task</th>
                                <th class="px-4 py-3 text-left">Proof</th>
                                <th class="px-4 py-3 text-left">Points</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($completions as $completion)
                                @php
                                    $rowNumber = ($completions->currentPage() - 1) * $completions->perPage() + $loop->iteration;
                                    $status = strtolower($completion['status'] ?? '');
                                @endphp

                                <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-green-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $rowNumber }}</td>
                                    <td class="px-4 py-3">{{ $completion['user']['name'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $completion['task']['title'] ?? 'N/A' }}</td>

                                    <td class="px-4 py-3 text-center">
    @if(!empty($completion['proof_image']))
        <a href="{{ env('API_BASE_URL') . '/storage/' . $completion['proof_image'] }}" target="_blank">
            <img 
                src="{{ env('API_BASE_URL') . '/storage/' . $completion['proof_image'] }}" 
                alt="Proof Image"
                class="w-16 h-16 object-cover rounded shadow hover:opacity-80 transition"
            >
        </a>
    @else
        <span class="text-gray-500">No proof</span>
    @endif
</td>


                                    <td class="px-4 py-3">
                                        {{ $completion['task']['points'] ?? 'N/A' }}
                                    </td>

                                    {{-- ✅ Status (dynamic from DB) --}}
                                    <td class="px-4 py-3">
                                        <span class="
                                            @if($status === 'completed' || $status === 'approved') text-green-600 font-semibold
                                            @elseif($status === 'rejected') text-yellow-600 font-semibold
                                            @else text-red-600
                                            @endif">
                                            {{ ucfirst($status) ?: 'Pending' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 flex justify-center gap-2">
                                        <a href="{{ route('completions.edit', $completion['id']) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white rounded p-2 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16.862 3.487a2.1 2.1 0 113.001 3.001L7.5 18.85l-4 1 1-4 12.362-12.363z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('completions.destroy', $completion['id']) }}" method="POST"
                                            onsubmit="return confirm('Delete this completion?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white rounded p-2 transition"
                                                title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-600 py-4">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- pagination links --}}
                <div class="mt-4 flex justify-center">
                    <nav class="inline-flex items-center space-x-1 flex-wrap gap-1" aria-label="Pagination">
                        {{-- Previous --}}
                        @if($completions->onFirstPage())
                            <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Prev</span>
                        @else
                            <a href="{{ $completions->previousPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Prev</a>
                        @endif

                        {{-- Page Numbers (Smart Pagination) --}}
                        @php
                            $current = $completions->currentPage();
                            $last = $completions->lastPage();
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
                                <a href="{{ $completions->url($page) }}" class="px-3 py-2 rounded bg-white text-green-600 border border-green-200 hover:bg-green-50">
                                    {{ $page }}
                                </a>
                            @endif

                            @php $lastShown = $page; @endphp
                        @endforeach

                        {{-- Next --}}
                        @if($completions->hasMorePages())
                            <a href="{{ $completions->nextPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Next</a>
                        @else
                            <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Next</span>
                        @endif
                    </nav>
                </div>

            </div>
        </div>
    </div>

@endsection