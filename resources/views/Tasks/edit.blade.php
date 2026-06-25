@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Task</h1>
                <a href="{{ route('tasks.index') }}" 
                   class="text-green-700 font-semibold hover:underline">
                    &larr; Back to Tasks
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('tasks.update', $task['id']) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ $task['title'] }}" 
                        class="w-full border rounded-lg p-2" 
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Points</label>
                    <input 
                        type="number" 
                        name="points" 
                        value="{{ $task['points'] }}" 
                        class="w-full border rounded-lg p-2">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea 
                        name="description" 
                        class="w-full border rounded-lg p-2" 
                        rows="4">{{ $task['description'] }}</textarea>
                </div>

                <!-- Period select -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Period</label>
                    <select name="period_id" class="w-full border rounded-lg p-2">
                        <option value="">-- Select period --</option>
                        @isset($periods)
                            @foreach($periods as $period)
                                @php
                                    $periodId = $period['id'] ?? $period['ID'] ?? $period['Id'] ?? '';
                                    $current = old('period_id', $task['period_id'] ?? $task['periodId'] ?? $task['period'] ?? '');
                                @endphp
                                <option value="{{ $periodId }}" {{ $current == $periodId ? 'selected' : '' }}>
                                    {{ $period['name'] ?? ($period['title'] ?? '-') }}
                                    @if(!empty($period['start_date']) && !empty($period['end_date']))
                                        ({{ $period['start_date'] }} — {{ $period['end_date'] }})
                                    @endif
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

              

                <div class="md:col-span-2">
                    <div class="flex justify-end gap-2">
                    
                        <button 
                            type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow"
                            style="min-width: 120px;">
                            Update Task
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
