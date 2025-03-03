<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;
use App\Contracts\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    protected $recommendationService;
    protected $articleRepository;
    
    public function __construct(RecommendationService $recommendationService, ArticleRepositoryInterface $articleRepository)
    {
        $this->recommendationService = $recommendationService;
        $this->articleRepository = $articleRepository;
    }
   
    /**
     * Display a listing of all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Cache::remember('articles_recent', now()->addHours(1), function () {
            return $this->articleRepository->all();
        });
        
        // Get recommendations for the authenticated user
        $recommendedArticles = collect();
        if (Auth::check()) {
            $recommendedArticles = $this->recommendationService->getRecommendationsForUser(Auth::user(), 3);
        }
        
        return view('dashboard', compact('articles', 'recommendedArticles'));
    }
    
    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $cacheKey = "article_{$article->id}";
        
        $article = Cache::remember($cacheKey, now()->addHours(1), function () use ($article) {
            return $this->articleRepository->find($article->id);
        });
        
        // Get recommendations for the authenticated user
        $recommendedArticles = collect();
        if (Auth::check()) {
            $recommendedArticles = $this->recommendationService->getRecommendationsForUser(Auth::user(), 3);
        }
        
        return view('articles.show', compact('article', 'recommendedArticles'));
    }
    
    // Other controller methods will go here...
} 