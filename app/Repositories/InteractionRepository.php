<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Interaction;
use App\Contracts\InteractionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class InteractionRepository implements InteractionRepositoryInterface
{
    /**
     * Get recent interactions for a user
     *
     * @param User $user
     * @param int $count
     * @return Collection
     */
    public function getRecentForUser(User $user, int $count = 3): Collection
    {
        $cacheKey = "user_{$user->id}_recent_interactions_{$count}";
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user, $count) {
            return $user->interactions()
                ->with('article.categories')
                ->latest()
                ->take($count)
                ->get();
        });
    }
    
    /**
     * Create a new interaction
     *
     * @param array $data
     * @return Interaction
     */
    public function create(array $data): Interaction
    {
        $interaction = Interaction::create([
            'user_id' => $data['user_id'],
            'article_id' => $data['article_id'],
            'interaction_type' => $data['interaction_type']
        ]);
        
        // Clear the cache for this user's interactions
        $this->clearUserCache($data['user_id']);
        
        return $interaction;
    }
    
    /**
     * Get article IDs that a user has interacted with
     *
     * @param User $user
     * @return array
     */
    public function getInteractedArticleIds(User $user): array
    {
        $cacheKey = "user_{$user->id}_interacted_article_ids";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($user) {
            return $user->interactions()
                ->pluck('article_id')
                ->unique()
                ->toArray();
        });
    }
    
    /**
     * Toggle like interaction for a user and article
     *
     * @param User $user
     * @param int $articleId
     * @return bool
     */
    public function toggleLike(User $user, int $articleId): bool
    {
        $existingLike = $user->interactions()
            ->where('article_id', $articleId)
            ->where('interaction_type', 'like')
            ->first();
            
        if ($existingLike) {
            $result = $existingLike->delete();
        } else {
            $this->create([
                'user_id' => $user->id,
                'article_id' => $articleId,
                'interaction_type' => 'like'
            ]);
            $result = true;
        }
        
        // Clear the cache for this user's interactions
        $this->clearUserCache($user->id);
        
        return $result;
    }
    
    /**
     * Clear the cache for a user's interactions
     *
     * @param int $userId
     * @return void
     */
    private function clearUserCache(int $userId): void
    {
        Cache::forget("user_{$userId}_recent_interactions_3");
        Cache::forget("user_{$userId}_interacted_article_ids");
    }
} 