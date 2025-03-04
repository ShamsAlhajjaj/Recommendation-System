<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class ArticleService
{
    protected $recommendationService;
    
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }
    
    /**
     * Get a paginated list of all articles
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllArticles(int $perPage = 10): LengthAwarePaginator
    {
        return Article::with('categories')->latest()->paginate($perPage);
    }
    
    /**
     * Get a specific article with its categories
     *
     * @param Article $article
     * @return Article
     */
    public function getArticleWithCategories(Article $article): Article
    {
        return $article->load('categories');
    }
    
    /**
     * Get recommended articles for a user
     *
     * @param \App\Models\User|null $user
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRecommendedArticlesForUser($user, int $limit = 3)
    {
        if (!$user) {
            return collect();
        }
        
        return $this->recommendationService->getRecommendationsForUser($user, $limit);
    }
} 