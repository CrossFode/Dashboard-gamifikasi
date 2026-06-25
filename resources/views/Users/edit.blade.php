@extends('layouts.template')
@section('content')

<div class="flex">
    <x-sidebar />

    <div class="w-full min-h-screen bg-gray-100 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
                <a href="{{ route('users.list') }}" class="text-green-700 font-semibold hover:underline">
                    &larr; Back to Users
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('users.update', $user['id']) }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user['username']) }}" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user['name']) }}" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user['email']) }}" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Role</label>
                    <select name="role" class="w-full border rounded-lg p-2" required>
                        <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Avatar URL</label>
                    <input type="url" name="avatar_url" value="{{ old('avatar_url', $user['avatar_url']) }}" class="w-full border rounded-lg p-2">
                </div>

               <div class="md:col-span-2">
                    <div class="flex justify-end">
                        <button 
                            type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-l shadow"
                            style="min-width: 120px;">
                            Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
