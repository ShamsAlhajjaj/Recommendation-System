@extends('admin.layouts.app')

@section('title', 'Users')

@section('page-header', 'Users')

@section('page-actions')
<a href="{{ route('admin.users.create') }}" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
    Create New User
</a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interactions</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recommendations</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->interactions_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->recommendations_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.users.activity', $user) }}" class="text-gray-700 hover:text-black transition-colors">Activity</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-700 hover:text-black transition-colors">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their interactions and recommendations.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-700 hover:text-black transition-colors">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection 