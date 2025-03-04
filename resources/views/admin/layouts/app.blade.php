<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Recommendation System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #264653;
            --primary-dark: #000000;
            --secondary-color: #2a9d8f;
            --accent-color: #e9c46a;
            --accent-secondary: #f4a261;
            --accent-tertiary: #e76f51;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: var(--light-bg);
        }
        
        .nav-link {
            position: relative;
            padding-bottom: 2px;
            color: #ffffff;
            transition: color 0.2s ease;
        }
        
        .nav-link:hover {
            color: var(--secondary-color);
        }
        
        .nav-link.active {
            font-weight: 500;
            color: var(--secondary-color);
        }
        
        .nav-link.active:after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--secondary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease;
        }
        
        .btn-secondary:hover {
            background-color: #248a7e;
        }
        
        .btn-accent {
            background-color: var(--accent-tertiary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease;
        }
        
        .btn-accent:hover {
            background-color: #d56144;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="p-4" style="background-color: var(--primary-color); color: white;">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">Admin Dashboard</a>
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.articles.index') }}" class="nav-link text-white hover:text-gray-200 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">Articles</a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link text-white hover:text-gray-200 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link text-white hover:text-gray-200 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit" class="bg-white text-gray-900 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto p-6">
        <!-- Page Header -->
        @hasSection('page-header')
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold" style="color: var(--primary-color);">@yield('page-header')</h1>
                @yield('page-actions')
            </div>
        @endif

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="border-l-4 p-4 mb-6" role="alert" style="background-color: rgba(42, 157, 143, 0.1); border-color: var(--secondary-color); color: var(--secondary-color);">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="border-l-4 p-4 mb-6" role="alert" style="background-color: rgba(231, 111, 81, 0.1); border-color: var(--accent-tertiary); color: var(--accent-tertiary);">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="border-l-4 p-4 mb-6" role="alert" style="background-color: rgba(231, 111, 81, 0.1); border-color: var(--accent-tertiary); color: var(--accent-tertiary);">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Content -->
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html> 