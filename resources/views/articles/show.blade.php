<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Articles
                                </a>
                            </div>
                            
                            <div class="article-content">
                                <p class="text-secondary small mb-4">
                                    Published: {{ $article->created_at->format('F j, Y') }}
                                </p>
                                
                                @if($article->categories->count() > 0)
                                    <div class="mb-3">
                                        <strong>Categories:</strong>
                                        @foreach($article->categories as $category)
                                            <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="article-body">
                                    {{ $article->body }}
                                </div>
                            </div>

                            <div class="article-actions">
                                <form action="{{ route('articles.like', $article) }}" method="POST" class="like-form">
                                    @csrf
                                    <button type="submit" class="like-button {{ $article->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                                        <i class="fa {{ $article->isLikedBy(auth()->user()) ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                        <span class="like-count">{{ $article->likes()->count() }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 