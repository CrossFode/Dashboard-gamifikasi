@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Tasks</h1>

                <div class="flex flex-wrap gap-3 items-center">
                    {{-- Period Dropdown (server populated, filters tasks) --}}
                    <form method="GET" action="{{ route('tasks.index') }}">
                        <select id="periodFilter" name="period_id"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-green-500 focus:outline-none transition"
                                onchange="this.form.submit()">
                            <option value="">All Periods</option>
                            @isset($periods)
                                @foreach($periods as $period)
                                    @php
                                        $pid = $period['id'] ?? $period['ID'] ?? $period['Id'] ?? '';
                                        $labelName = $period['name'] ?? $period['title'] ?? '-';
                                        $selected = (string)($selectedPeriod ?? request('period_id')) === (string)$pid ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $pid }}" {{ $selected }}>
                                        {{ $labelName }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </form>

                    {{-- Add Task Button --}}
                    <a href="{{ route('tasks.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        + Add Task
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tasks Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-lg overflow-hidden">
                    <thead class="bg-green-600 text-white text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-left">Points</th>
                            <th class="px-4 py-3 text-left">Period</th> <!-- added -->
                            <th class="px-4 py-3 text-left">Active</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tasks as $task)
                            @php
                                // compute global index for each row
                                $rowNumber = ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration;

                                // try several shapes the API might return
                                $taskPeriodId = $task['period_id'] ?? $task['periodId'] ?? $task['period'] ?? null;
                                $periodName = '-';

                                // if task has nested period object
                                if (is_array($task['period'] ?? null) && !empty($task['period']['name'] ?? null)) {
                                    $periodName = $task['period']['name'];
                                } else if (!empty($task['period_name'] ?? null)) {
                                    $periodName = $task['period_name'];
                                } else {
                                    // fallback: resolve from the $periods list passed to the view
                                    if (!empty($periods) && $taskPeriodId !== null) {
                                        foreach ($periods as $p) {
                                            $pid = $p['id'] ?? $p['ID'] ?? $p['Id'] ?? null;
                                            if ((string)$pid === (string)$taskPeriodId) {
                                                $periodName = $p['name'] ?? $p['title'] ?? $periodName;
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-green-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $rowNumber }}</td>
                                <td class="px-4 py-3">{{ $task['title'] }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $task['description'] }}</td>
                                <td class="px-4 py-3">{{ $task['points'] }}</td>

                                <!-- Period column -->
                                <td class="px-4 py-3">{{ $periodName }}</td>

                                <td class="px-4 py-3">
                                    <span class="{{ !empty($task['is_active']) ?? $task['is_active'] ? 'text-green-600 font-semibold' : 'text-red-500' }}">
                                        {{ !empty($task['is_active']) ?? $task['is_active'] ? 'Yes' : 'No' }}
                                    </span>
                                <td class="px-4 py-3 flex justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('tasks.edit', $task['id']) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white rounded p-2 transition"
                                       title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                             class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" 
                                                  stroke-linejoin="round" 
                                                  stroke-width="2" 
                                                  d="M16.862 3.487a2.1 2.1 0 113.001 3.001L7.5 18.85l-4 1 1-4 12.362-12.363z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('tasks.destroy', $task['id']) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white rounded p-2 transition"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                 class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" 
                                                      stroke-linejoin="round" 
                                                      stroke-width="2" 
                                                      d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7z"/>
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
                    @if($tasks->onFirstPage())
                        <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Prev</span>
                    @else
                        <a href="{{ $tasks->previousPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Prev</a>
                    @endif

                    {{-- Page Numbers (Smart Pagination) --}}
                    @php
                        $current = $tasks->currentPage();
                        $last = $tasks->lastPage();
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
                            <a href="{{ $tasks->url($page) }}" class="px-3 py-2 rounded bg-white text-green-600 border border-green-200 hover:bg-green-50">
                                {{ $page }}
                            </a>
                        @endif

                        @php $lastShown = $page; @endphp
                    @endforeach

                    {{-- Next --}}
                    @if($tasks->hasMorePages())
                        <a href="{{ $tasks->nextPageUrl() }}" class="px-3 py-2 rounded bg-green-600 text-white hover:bg-green-700">Next</a>
                    @else
                        <span class="px-3 py-2 rounded bg-green-100 text-green-500 cursor-default">Next</span>
                    @endif
                </nav>
            </div>

        </div>
    </div>
</div>

@endsection
