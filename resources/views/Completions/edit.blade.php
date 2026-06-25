@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Completion</h1>
                <a href="{{ route('completions.index') }}" 
                   class="text-green-700 font-semibold hover:underline">
                    &larr; Back to Completions
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('completions.update', $completion['id']) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                {{-- Select Task --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Task</label>
                    <select name="task_id" class="w-full border rounded-lg p-2" required>
                        @foreach($tasks as $task)
                            <option value="{{ $task['id'] }}" {{ $completion['task_id'] == $task['id'] ? 'selected' : '' }}>
                                {{ $task['title'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status (read-only) --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <input 
                        type="text"
                        class="w-full border rounded-lg p-2 bg-gray-100 cursor-not-allowed"
                        value="{{ ucfirst($completion['status'] ?? '') }}"
                        readonly
                        aria-readonly="true"
                    >
                </div>

                {{-- Proof Image --}}
    <div class="md:col-span-2">
        <label class="block text-gray-700 font-medium mb-1">Proof Image</label>

        @if(!empty($completion['proof_image']))
            <a href="{{ env('API_BASE_URL') . '/storage/' . $completion['proof_image'] }}" target="_blank">
                <img 
                    src="{{ env('API_BASE_URL') . '/storage/' . $completion['proof_image'] }}" 
                    alt="Proof Image"
                    class="w-48 h-48 object-cover rounded shadow hover:opacity-80 transition"
                >
            </a>
        @else
            <div class="w-full border rounded-lg p-3 text-gray-500">No proof available</div>
        @endif
    </div>

                {{-- Completed At --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Completed At</label>
                    <input 
                        type="datetime-local" 
                        name="completed_at" 
                        value="{{ isset($completion['completed_at']) ? \Carbon\Carbon::parse($completion['completed_at'])->format('Y-m-d\TH:i') : '' }}" 
                        class="w-full border rounded-lg p-2">
                </div>

                <div class="md:col-span-2 flex justify-end items-center space-x-3">
                    <!-- Buttons set the status by submitting name="status" with the desired value -->
                
                    <button 
                        type="submit" 
                        name="status" 
                        value="cancelled"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow">
                        Cancelled
                    </button>

                    <button 
                        type="submit" 
                        name="status" 
                        value="completed"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow">
                        Completed
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
