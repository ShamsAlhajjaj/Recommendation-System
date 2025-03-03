@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('page-header', 'Edit Category: ' . $category->name)

@section('page-actions')
<a href="{{ route('admin.categories.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
    Back to Categories
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:border-gray-500" required>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection 