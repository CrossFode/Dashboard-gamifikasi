@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6 w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Your Profile</h1>
                {{-- Edit Profile Button --}}
                <a href="{{ route('profile.edit') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    Edit Profile
                </a>
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

            {{-- Profile Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col items-center">
                    <img 
                        src="{{ $user['avatar_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) }}" 
                        alt="Avatar" 
                        class="w-32 h-32 rounded-full border-4 border-green-500 mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $user['name'] }}</h2>
                    
                    <span class="mt-2 px-3 py-1 text-sm bg-gray-200 rounded-full text-gray-700">
                        Role: {{ ucfirst($user['role'] ?? 'User') }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Full Name</label>
                        <p class="text-gray-800 text-lg font-semibold">{{ $user['name'] ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Username</label>
                        <p class="text-gray-800 text-lg font-semibold">{{ $user['username'] ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Email</label>
                        <p class="text-gray-800 text-lg font-semibold">{{ $user['email'] ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Role</label>
                        <p class="text-gray-800 text-lg font-semibold">{{ ucfirst($user['role'] ?? '-') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
