@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('page-header', 'Edit User: ' . $user->name)

@section('page-actions')
<a href="{{ route('admin.users.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
    Back to Users
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:border-gray-500" required>
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:border-gray-500" required>
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (leave blank to keep current password)</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:border-gray-500">
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:border-gray-500">
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection 