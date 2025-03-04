@extends('admin.layouts.app')

@section('title', 'User Activity')

@section('page-header', 'User Activity: ' . $user->name)

@section('page-actions')
<a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-md text-white transition-colors" style="background-color: var(--accent-secondary);">
    Back to Users
</a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- User Information Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
        <h2 class="text-xl font-semibold mb-4" style="color: var(--primary-color);">User Information</h2>
        <div class="space-y-2">
            <p><span class="font-medium" style="color: var(--primary-color);">ID:</span> {{ $user->id }}</p>
            <p><span class="font-medium" style="color: var(--primary-color);">Name:</span> {{ $user->name }}</p>
            <p><span class="font-medium" style="color: var(--primary-color);">Email:</span> {{ $user->email }}</p>
            <p><span class="font-medium" style="color: var(--primary-color);">Registered:</span> {{ $user->created_at->format('M d, Y') }}</p>
            <p><span class="font-medium" style="color: var(--primary-color);">Total Interactions:</span> {{ $user->interactions->count() }}</p>
            <p><span class="font-medium" style="color: var(--primary-color);">Total Recommendations:</span> {{ $user->recommendations->count() }}</p>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary">
                Edit User
            </a>
        </div>
    </div>

    <!-- User Statistics Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
        <h2 class="text-xl font-semibold mb-4" style="color: var(--primary-color);">Activity Statistics</h2>
        <div class="space-y-4">
            <div>
                <h3 class="font-medium text-lg" style="color: var(--primary-color);">Interactions by Type</h3>
                <div class="mt-2 space-y-2">
                    @php
                        $viewCount = $user->interactions->where('interaction_type', 'view')->count();
                        $likeCount = $user->interactions->where('interaction_type', 'like')->count();
                    @endphp
                    <div class="flex items-center">
                        <span class="w-20">Views:</span>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full" style="background-color: var(--secondary-color); width: {{ $user->interactions->count() > 0 ? ($viewCount / $user->interactions->count() * 100) : 0 }}%"></div>
                        </div>
                        <span class="ml-2">{{ $viewCount }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20">Likes:</span>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full" style="background-color: var(--primary-color); width: {{ $user->interactions->count() > 0 ? ($likeCount / $user->interactions->count() * 100) : 0 }}%"></div>
                        </div>
                        <span class="ml-2">{{ $likeCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Interactions -->
<div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold" style="color: var(--primary-color);">Recent Interactions</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead style="background-color: rgba(38, 70, 83, 0.05);">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Article</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($interactions as $interaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $interaction->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($interaction->interaction_type == 'view')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white" style="background-color: var(--secondary-color);">View</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white" style="background-color: var(--primary-color);">Like</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" style="color: var(--primary-color);">
                            @if($interaction->article)
                                {{ $interaction->article->title }}
                            @else
                                <span class="text-gray-500">Article deleted</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No interactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $interactions->links() }}
    </div>
</div>

<!-- Recent Recommendations -->
<div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold" style="color: var(--primary-color);">Recent Recommendations</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead style="background-color: rgba(38, 70, 83, 0.05);">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--primary-color);">Article</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recommendations as $recommendation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $recommendation->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" style="color: var(--primary-color);">
                            @if($recommendation->article)
                                {{ $recommendation->article->title }}
                            @else
                                <span class="text-gray-500">Article deleted</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No recommendations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $recommendations->links() }}
    </div>
</div>
@endsection 