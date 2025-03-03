@extends('admin.layouts.app')

@section('title', 'Categories')

@section('page-header', 'Categories')

@section('page-actions')
<a href="{{ route('admin.categories.create') }}" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
    Create New Category
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles Count</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->articles_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-700 hover:text-black transition-colors">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-700 hover:text-black transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection 