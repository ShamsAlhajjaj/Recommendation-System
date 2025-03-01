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
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::guard('admin')->user()->name }}!</h1>
            <p class="text-gray-700">You are now logged in as an admin.</p>
        </div>
    </div>
</body>
</html>