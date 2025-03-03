<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Recommendation;
use App\Contracts\RecommendationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationRepository implements RecommendationRepositoryInterface
{
    /**
     * Get all recommendations for a user
     *
     * @param User $user
     * @param int $limit
     * @return Collection
     */
    public function getForUser(User $user, int $limit = 5): Collection
    {
        $cacheKey = "user_{$user->id}_recommendations_limit_{$limit}";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($user, $limit) {
            return $user->recommendations()
                ->with('article.categories')
                ->latest()
                ->take($limit)
                ->get()
                ->pluck('article');
        });
    }
    
    /**
     * Create a new recommendation
     *
     * @param array $data
     * @return Recommendation
     */
    public function create(array $data): Recommendation
    {
        $recommendation = Recommendation::create([
            'user_id' => $data['user_id'],
            'article_id' => $data['article_id']
        ]);
        
        // Clear the cache for this user's recommendations
        $this->clearUserCache($data['user_id']);
        
        return $recommendation;
    }
    
    /**
     * Get existing recommendation article IDs for a user
     *
     * @param User $user
     * @return array
     */
    public function getExistingArticleIdsForUser(User $user): array
    {
        $cacheKey = "user_{$user->id}_recommendation_article_ids";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($user) {
            return $user->recommendations()
                ->pluck('article_id')
                ->toArray();
        });
    }
    
    /**
     * Clear the cache for a user's recommendations
     *
     * @param int $userId
     * @return void
     */
    private function clearUserCache(int $userId): void
    {
        Cache::forget("user_{$userId}_recommendations_limit_5");
        Cache::forget("user_{$userId}_recommendation_article_ids");
    }
} 