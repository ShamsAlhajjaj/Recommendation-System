<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class ArticleController extends Controller
{
    protected $articleService;
    
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
   
    /**
     * Display a listing of all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $articles = $this->articleService->getAllArticles(10);
            
            // Get recommendations for the authenticated user
            $recommendedArticles = $this->articleService->getRecommendedArticlesForUser(Auth::user(), 3);
            
            return view('dashboard', compact('articles', 'recommendedArticles'));
        } catch (Exception $e) {
            Log::error('Error displaying articles: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->back()
                ->with('error', 'There was a problem loading the articles. Please try again later.');
        }
    }
    
    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        try {
            $article = $this->articleService->getArticleWithCategories($article);
            
            // Get recommendations for the authenticated user
            $recommendedArticles = $this->articleService->getRecommendedArticlesForUser(Auth::user(), 3);
            
            return view('articles.show', compact('article', 'recommendedArticles'));
        } catch (Exception $e) {
            Log::error('Error displaying article: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('dashboard')
                ->with('error', 'There was a problem loading the article. Please try again later.');
        }
    }
    
    // Other controller methods will go here...
} 