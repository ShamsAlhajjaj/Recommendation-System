@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('page-header', 'Create New Category')

@section('page-actions')
<a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-md text-white transition-colors" style="background-color: var(--accent-secondary);">
    Back to Categories
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);" required>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection 