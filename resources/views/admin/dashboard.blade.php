<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

    <!-- Dashboard Content -->
    <div class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::guard('admin')->user()->name }}!</h1>
            <p class="text-gray-700 mb-6">You are now logged in as an admin.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Articles Management Card -->
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-3">Article Management</h2>
                    <p class="text-gray-600 mb-4">Create, edit, and manage articles for your recommendation system.</p>
                    <a href="{{ route('admin.articles.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Manage Articles
                    </a>
                </div>
                
                <!-- Categories Management Card -->
                <div class="bg-green-50 p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-3">Category Management</h2>
                    <p class="text-gray-600 mb-4">Create and manage categories to organize your articles.</p>
                    <a href="{{ route('admin.categories.index') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Manage Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>