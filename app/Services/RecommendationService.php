<?php

namespace App\Services;

use App\Models\User;
use App\Models\Article;
use App\Models\Recommendation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class RecommendationService
{
    /**
     * Generate recommendations for a user based on their recent interactions
     *
     * @param User $user
     * @param int $limit Maximum number of recommendations to generate
     * @return void
     * @throws Exception
     */
    public function generateRecommendations(User $user, int $limit = 5): void
    {
        try {
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
        } catch (Exception $e) {
            Log::error('Error generating recommendations: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Get the user's recently interacted articles
     *
     * @param User $user
     * @param int $count Number of recent interactions to retrieve
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    private function getUserRecentInteractions(User $user, int $count = 3)
    {
        try {
            return $user->interactions()
                ->latest()
                ->take($count)
                ->get();
        } catch (Exception $e) {
            Log::error('Error retrieving user recent interactions: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
                'count' => $count
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Get article IDs the user has already interacted with
     *
     * @param User $user
     * @return array
     * @throws Exception
     */
    private function getInteractedArticleIds(User $user): array
    {
        try {
            return $user->interactions()
                ->pluck('article_id')
                ->unique()
                ->toArray();
        } catch (Exception $e) {
            Log::error('Error retrieving interacted article IDs: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Get article IDs the user already has recommendations for
     *
     * @param User $user
     * @return array
     * @throws Exception
     */
    private function getExistingRecommendationIds(User $user): array
    {
        try {
            return $user->recommendations()
                ->pluck('article_id')
                ->toArray();
        } catch (Exception $e) {
            Log::error('Error retrieving existing recommendation IDs: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Extract category IDs from user interactions
     *
     * @param \Illuminate\Database\Eloquent\Collection $interactions
     * @return array
     * @throws Exception
     */
    private function extractCategoryIdsFromInteractions($interactions): array
    {
        try {
            $categoryIds = [];
            foreach ($interactions as $interaction) {
                $article = $interaction->article;
                if (!$article) {
                    Log::warning('Article not found for interaction', [
                        'interaction_id' => $interaction->id
                    ]);
                    continue;
                }
                $articleCategoryIds = $article->categories()->pluck('categories.id')->toArray();
                $categoryIds = array_merge($categoryIds, $articleCategoryIds);
            }
            return array_unique($categoryIds);
        } catch (Exception $e) {
            Log::error('Error extracting category IDs from interactions: ' . $e->getMessage(), [
                'exception' => $e,
                'interaction_count' => $interactions->count()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Find articles to recommend based on categories and exclusion lists
     *
     * @param array $categoryIds
     * @param array $interactedArticleIds
     * @param array $existingRecommendationIds
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    private function findRecommendedArticles(
        array $categoryIds, 
        array $interactedArticleIds, 
        array $existingRecommendationIds, 
        int $limit
    ) {
        try {
            return Article::whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('categories.id', $categoryIds);
                })
                ->whereNotIn('id', $interactedArticleIds)
                ->whereNotIn('id', $existingRecommendationIds)
                ->orderBy('created_at', 'desc')
                ->take($limit)
                ->get();
        } catch (Exception $e) {
            Log::error('Error finding recommended articles: ' . $e->getMessage(), [
                'exception' => $e,
                'category_ids' => $categoryIds,
                'interacted_article_ids_count' => count($interactedArticleIds),
                'existing_recommendation_ids_count' => count($existingRecommendationIds),
                'limit' => $limit
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Create recommendation records for a user
     *
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Collection $articles
     * @return void
     * @throws Exception
     */
    private function createRecommendations(User $user, $articles): void
    {
        try {
            DB::transaction(function () use ($user, $articles) {
                foreach ($articles as $article) {
                    Recommendation::create([
                        'user_id' => $user->id,
                        'article_id' => $article->id
                    ]);
                }
            });
        } catch (Exception $e) {
            Log::error('Error creating recommendations: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
                'article_count' => $articles->count()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Get recommendations for a user
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getRecommendationsForUser(User $user, int $limit = 5)
    {
        try {
            return $user->recommendations()
                ->with('article.categories')
                ->latest()
                ->take($limit)
                ->get()
                ->pluck('article');
        } catch (Exception $e) {
            Log::error('Error retrieving recommendations for user: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
                'limit' => $limit
            ]);
            
            throw $e;
        }
    }
} 