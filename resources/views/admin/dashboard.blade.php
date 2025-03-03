@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-header', 'Dashboard')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold mb-4" style="color: var(--primary-color);">Welcome, {{ Auth::guard('admin')->user()->name }}!</h1>
    <p class="text-gray-700 mb-6">You are now logged in as an admin.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Articles Management Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 transition-all hover:shadow-md" style="border-top: 3px solid var(--primary-color);">
            <h2 class="text-xl font-semibold mb-3" style="color: var(--primary-color);">Article Management</h2>
            <p class="text-gray-600 mb-4">Create, edit, and manage articles for your recommendation system.</p>
            <a href="{{ route('admin.articles.index') }}" class="btn-primary inline-block">
                Manage Articles
            </a>
        </div>
        
        <!-- Categories Management Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 transition-all hover:shadow-md" style="border-top: 3px solid var(--secondary-color);">
            <h2 class="text-xl font-semibold mb-3" style="color: var(--secondary-color);">Category Management</h2>
            <p class="text-gray-600 mb-4">Create and manage categories to organize your articles.</p>
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary inline-block">
                Manage Categories
            </a>
        </div>
        
        <!-- Users Management Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 transition-all hover:shadow-md" style="border-top: 3px solid var(--accent-tertiary);">
            <h2 class="text-xl font-semibold mb-3" style="color: var(--accent-tertiary);">User Management</h2>
            <p class="text-gray-600 mb-4">Manage users and view their interactions and recommendations.</p>
            <a href="{{ route('admin.users.index') }}" class="btn-accent inline-block">
                Manage Users
            </a>
        </div>
    </div>
</div>
@endsection