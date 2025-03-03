<?php

namespace App\Services;

use App\Models\User;
use App\Models\Article;
use App\Models\Recommendation;

class RecommendationService
{
    /**
     * Generate recommendations for a user based on their recent interactions
     *
     * @param User $user
     * @param int $limit Maximum number of recommendations to generate
     * @return void
     */
    public function generateRecommendations(User $user, int $limit = 5): void
    {
        $recentInteractions = $this->getUserRecentInteractions($user);
            
        if ($recentInteractions->isEmpty()) {
            return;
        }
        
        $interactedArticleIds = $this->getInteractedArticleIds($user);
        $existingRecommendationIds = $this->getExistingRecommendationIds($user);
        $categoryIds = $this->extractCategoryIdsFromInteractions($recentInteractions);
        
        if (empty($categoryIds)) {
            return;
        }
        
        $recommendedArticles = $this->findRecommendedArticles(
            $categoryIds, 
            $interactedArticleIds, 
            $existingRecommendationIds, 
            $limit
        );
            
        $this->createRecommendations($user, $recommendedArticles);
    }
    
    /**
     * Get the user's recently interacted articles
     *
     * @param User $user
     * @param int $count Number of recent interactions to retrieve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUserRecentInteractions(User $user, int $count = 3)
    {
        return $user->interactions()
            ->latest()
            ->take($count)
            ->get();
    }
    
    /**
     * Get article IDs the user has already interacted with
     *
     * @param User $user
     * @return array
     */
    private function getInteractedArticleIds(User $user): array
    {
        return $user->interactions()
            ->pluck('article_id')
            ->unique()
            ->toArray();
    }
    
    /**
     * Get article IDs the user already has recommendations for
     *
     * @param User $user
     * @return array
     */
    private function getExistingRecommendationIds(User $user): array
    {
        return $user->recommendations()
            ->pluck('article_id')
            ->toArray();
    }
    
    /**
     * Extract category IDs from user interactions
     *
     * @param \Illuminate\Database\Eloquent\Collection $interactions
     * @return array
     */
    private function extractCategoryIdsFromInteractions($interactions): array
    {
        $categoryIds = [];
        foreach ($interactions as $interaction) {
            $article = $interaction->article;
            $articleCategoryIds = $article->categories()->pluck('categories.id')->toArray();
            $categoryIds = array_merge($categoryIds, $articleCategoryIds);
        }
        return array_unique($categoryIds);
    }
    
    /**
     * Find articles to recommend based on categories and exclusion lists
     *
     * @param array $categoryIds
     * @param array $interactedArticleIds
     * @param array $existingRecommendationIds
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function findRecommendedArticles(
        array $categoryIds, 
        array $interactedArticleIds, 
        array $existingRecommendationIds, 
        int $limit
    ) {
        return Article::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->whereNotIn('id', $interactedArticleIds)
            ->whereNotIn('id', $existingRecommendationIds)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * Create recommendation records for a user
     *
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Collection $articles
     * @return void
     */
    private function createRecommendations(User $user, $articles): void
    {
        foreach ($articles as $article) {
            Recommendation::create([
                'user_id' => $user->id,
                'article_id' => $article->id
            ]);
        }
    }
    
    /**
     * Get recommendations for a user
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecommendationsForUser(User $user, int $limit = 5)
    {
        return $user->recommendations()
            ->with('article.categories')
            ->latest()
            ->take($limit)
            ->get()
            ->pluck('article');
    }
} 