@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('page-header', 'Edit User')

@section('page-actions')
<a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-md text-white transition-colors" style="background-color: var(--accent-secondary);">
    Back to Users
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);" required>
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);" required>
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);">
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);">
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection 