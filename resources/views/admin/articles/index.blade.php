@extends('admin.layouts.app')

@section('title', 'Articles')

@section('page-header', 'Articles')

@section('page-actions')
<a href="{{ route('admin.articles.create') }}" class="btn-primary">
    Create New Article
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead style="background-color: rgba(38, 70, 83, 0.05);">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Title</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Categories</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Created At</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($articles as $article)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" style="color: var(--primary-color);">{{ $article->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @foreach($article->categories as $category)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mr-1" style="background-color: rgba(233, 106, 106, 0.2); color: #b33838;">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="transition-colors" style="color: var(--secondary-color);">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="transition-colors" style="color: var(--accent-tertiary);">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No articles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $articles->links() }}
</div>
@endsection 