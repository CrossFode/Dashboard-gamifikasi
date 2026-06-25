@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Periods</h1>

                <div class="flex flex-wrap gap-3 items-center">
                    {{-- Add Period Button --}}
                    <a href="{{ route('periods.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        + Add Period
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Periods Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-lg overflow-hidden">
                    <thead class="bg-green-600 text-white text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Start Date</th>
                            <th class="px-4 py-3 text-left">End Date</th>
                            <th class="px-4 py-3 text-left">Active</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($periods as $i => $period)
                            <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-green-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">{{ $period['name'] ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $period['start_date'] ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $period['end_date'] ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
    @if(!empty($period['is_active']) && $period['is_active'])
        <span class="text-green-600 font-semibold">Active</span>
    @else
        <form action="{{ route('periods.setActive', $period['id']) }}" method="POST" onsubmit="return confirm('Set this period as active?');">
            @csrf
            <button type="submit" class="bg-gray-300 hover:bg-green-600 hover:text-white text-gray-700 px-3 py-1 rounded transition">
                Set Active
            </button>
        </form>
    @endif
</td>

                                <td class="px-4 py-3 flex justify-center gap-2">

                                
                                    {{-- Edit Button --}}
                                    <a href="{{ route('periods.edit', $period['id']) }}"
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
                                    <form action="{{ route('periods.destroy', $period['id']) }}" method="POST" onsubmit="return confirm('Delete this period?');">
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
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-600 py-4">No periods found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
