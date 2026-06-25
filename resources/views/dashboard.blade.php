@extends('layouts.template')
@section('content')

    <div class="flex">
        <x-sidebar />

        <div class="w-full min-h-screen bg-gray-100 p-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">
                    Welcome, {{ $user['name'] ?? 'User' }}
                </h1>

                {{-- 🔥 Active Period + Active Tasks (side-by-side) --}}
                <div class="p-4">
                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <!-- Active Period -->
                        <div class="w-full sm:w-80 md:w-96">
                            <div class="rounded-2xl bg-gradient-to-br from-green-400 to-green-600 text-white shadow-lg p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-m opacity-90">Active Period</p>
                                        
                                        <h3 class="mt-2 text-3xl md:text-4xl font-extrabold tracking-tight">
                                            
    {{ $activePeriod ?? 'No active period' }}
</h3>

<p class="mt-1 text-sm opacity-90">
    Active Period
</p>
                                    </div>

                                    <div class="text-right">
                                        @if(!empty($activePeriod['days_remaining']))
                                            <div class="text-4xl md:text-5xl font-bold leading-none">
                                                {{ $activePeriod['days_remaining'] }}
                                            </div>
                                            <div class="text-xs opacity-90">days left</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Tasks (compact stat) -->
                        <div class="w-full sm:w-80 md:w-56">
                            <div class="rounded-2xl bg-gradient-to-br from-green-400 to-green-600 text-white shadow-lg p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-m opacity-90">Active Tasks</p>
                                        <div class="mt-2 text-3xl md:text-4xl font-extrabold tracking-tight">
                                            {{ $activeTaskCount }}
                                        </div>
                                        <p class="mt-1 text-sm opacity-90">total tasks</p>
                                    </div>
                                    <div class="text-right">
                                        {{-- optional icon/placeholder --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Completions -->
                        <div class="w-full sm:w-80 md:w-56">
                            <div class="rounded-2xl bg-gradient-to-br from-green-400 to-green-600 text-white shadow-lg p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-m opacity-90">Total Completions</p>
                                        <div class="mt-2 text-3xl md:text-4xl font-extrabold tracking-tight">
                                            {{ $totalCompletions }}
                                        </div>
                                        <p class="mt-1 text-sm opacity-90">from active period</p>
                                    </tdiv>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- 🏆 Top Users --}}
                <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3 ">Top 3 Users</h2>
                    <ul class="space-y-3">
                        @foreach($topUsers as $rank => $topUser)
                            <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-green-600">#{{ $rank + 1 }}</span>

                                    <div>
                                        <p class="font-medium text-gray-800">{{ $topUser['name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $topUser['email'] }}</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-green-700">{{ $topUser['points'] }} pts</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection