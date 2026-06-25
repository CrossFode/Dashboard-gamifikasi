@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6 max-w-2xl mx-auto">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Add New Period</h1>
                <p class="text-gray-500 mt-1">Create a new active period for your system.</p>
            </div>

            {{-- Error Message --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('periods.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>

                {{-- Start Date --}}
                <div>
                    <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date</label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="{{ old('start_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>

                {{-- End Date --}}
                <div>
                    <label for="end_date" class="block text-gray-700 font-semibold mb-2">End Date</label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>

                

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('Periods.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
