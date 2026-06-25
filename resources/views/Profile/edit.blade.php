@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6 w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
                
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Avatar Section --}}
                    <div class="flex flex-col items-center">
                        <img 
                            src="{{ $user['avatar_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) }}" 
                            alt="Avatar" 
                            class="w-32 h-32 rounded-full border-4 border-green-500 mb-4">
                        <input 
                            type="url" 
                            name="avatar_url" 
                            value="{{ old('avatar_url', $user['avatar_url'] ?? '') }}" 
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                            placeholder="Avatar URL (https://example.com/avatar.png)">
                    </div>

                    {{-- Editable Fields --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $user['name']) }}" 
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Username</label>
                            <input 
                                type="text" 
                                name="username" 
                                value="{{ old('username', $user['username']) }}" 
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $user['email']) }}" 
                                class="w-full border rounded-lg p-2 ">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Role</label>
                            <input 
                                type="text" 
                                name="role" 
                                value="{{ ucfirst($user['role'] ?? 'User') }}" 
                                class="w-full border rounded-lg p-2 bg-gray-100 text-gray-600 cursor-not-allowed"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('profile') }}" 
                       class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
