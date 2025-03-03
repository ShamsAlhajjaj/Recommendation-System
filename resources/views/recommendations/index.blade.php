<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Recommended Articles') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="fs-5 fw-medium mb-4">Articles Recommended For You</h3>
                            
                            @if($recommendedArticles->count() > 0)
                                <div class="row">
                                    @foreach($recommendedArticles as $article)
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h4 class="fs-5 fw-bold">{{ $article->title }}</h4>
                                                    <p class="text-secondary small">
                                                        {{ \Illuminate\Support\Str::limit($article->body, 150) }}
                                                    </p>
                                                    
                                                    @if($article->categories->count() > 0)
                                                        <div class="mb-2">
                                                            @foreach($article->categories as $category)
                                                                <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    
                                                    <a href="{{ route('articles.view', $article) }}" class="btn btn-sm btn-primary">Read Article</a>
                                                    
                                                    <div class="like-section mt-2">
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
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <p class="mb-0">No recommendations available yet. Try interacting with some articles first!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 