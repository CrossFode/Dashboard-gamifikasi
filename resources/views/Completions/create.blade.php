@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Add New Completion</h1>
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

            <form action="{{ route('completions.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf

    {{-- Select Task --}}
    <div>
        <label class="block text-gray-700 font-medium mb-1">Task</label>
        <select name="task_id" class="w-full border rounded-lg p-2" required>
            <option value="">-- Select Task --</option>
            @foreach($tasks as $task)
                <option value="{{ $task['id'] }}">{{ $task['title'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-gray-700 font-medium mb-1">Status</label>
        <input type="text" value="Pending" disabled class="w-full border rounded-lg p-2 bg-gray-100 text-gray-700" />
        <input type="hidden" name="status" value="pending" />
    </div>

    {{-- Proof Image --}}
    <div class="md:col-span-2">
        <label class="block text-gray-700 font-medium mb-1">Proof Image (optional)</label>
        <input 
            type="file" 
            name="proof_image" 
            accept="image/*" 
            class="w-full border rounded-lg p-2" />
    </div>

    <div class="md:col-span-2 flex justify-end">
        <button 
            type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow">
            Create Completion
        </button>
    </div>
</form>


        </div>
    </div>
</div>

@endsection
