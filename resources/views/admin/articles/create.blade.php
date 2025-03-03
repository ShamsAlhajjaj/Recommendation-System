@extends('admin.layouts.app')

@section('title', 'Create Article')

@section('page-header', 'Create New Article')

@section('page-actions')
<a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-md text-white transition-colors" style="background-color: var(--accent-secondary);">
    Back to Articles
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
    <form action="{{ route('admin.articles.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);" required>
        </div>
        
        <div class="mb-4">
            <label for="body" class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Content</label>
            <textarea name="body" id="body" rows="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-opacity-50" style="focus:ring-color: var(--secondary-color); focus:border-color: var(--secondary-color);" required>{{ old('body') }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1" style="color: var(--primary-color);">Categories</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" class="h-4 w-4 focus:ring-opacity-50 border-gray-300 rounded" style="color: var(--secondary-color); focus:ring-color: var(--secondary-color);" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <label for="category-{{ $category->id }}" class="ml-2 block text-sm text-gray-900">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @if($categories->isEmpty())
                <p class="text-gray-500 text-sm mt-1">No categories available. Please create categories first.</p>
            @endif
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="btn-primary" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                Create Article
            </button>
        </div>
    </form>
</div>
@endsection 