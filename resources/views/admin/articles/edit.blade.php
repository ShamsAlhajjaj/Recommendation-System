<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Article</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Admin Dashboard</a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.articles.index') }}" class="hover:underline">Articles</a>
                <a href="{{ route('admin.categories.index') }}" class="hover:underline">Categories</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit Article: {{ $article->title }}</h1>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to Articles
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
            <form action="{{ route('admin.articles.update', $article) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="body" id="body" rows="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>{{ old('body', $article->body) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                    {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                                <label for="category-{{ $category->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @if($categories->isEmpty())
                        <p class="text-red-500 text-sm mt-1">No categories available. Please create categories first.</p>
                    @endif
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                        Update Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 