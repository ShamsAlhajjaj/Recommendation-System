<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $recommendationService;
    
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }
   
    /**
     * Display a listing of all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('categories')->latest()->paginate(10);
        
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
        $article->load('categories');
        
        // Get recommendations for the authenticated user
        $recommendedArticles = collect();
        if (Auth::check()) {
            $recommendedArticles = $this->recommendationService->getRecommendationsForUser(Auth::user(), 3);
        }
        
        return view('articles.show', compact('article', 'recommendedArticles'));
    }
    
    // Other controller methods will go here...
} 