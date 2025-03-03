<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\RecommendationRepositoryInterface;
use App\Contracts\InteractionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    protected $articleRepository;
    protected $recommendationRepository;
    protected $interactionRepository;
    
    /**
     * Create a new service instance.
     *
     * @param ArticleRepositoryInterface $articleRepository
     * @param RecommendationRepositoryInterface $recommendationRepository
     * @param InteractionRepositoryInterface $interactionRepository
     * @return void
     */
    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        RecommendationRepositoryInterface $recommendationRepository,
        InteractionRepositoryInterface $interactionRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->recommendationRepository = $recommendationRepository;
        $this->interactionRepository = $interactionRepository;
    }
    
    /**
     * Generate recommendations for a user based on their recent interactions
     *
     * @param User $user
     * @param int $limit Maximum number of recommendations to generate
     * @return void
     */
    public function generateRecommendations(User $user, int $limit = 5): void
    {
        $cacheKey = "user_{$user->id}_generate_recommendations_{$limit}";
        
        // Use a lock to prevent multiple simultaneous recommendation generations
        Cache::lock($cacheKey, 10)->block(5, function () use ($user, $limit) {
            $recentInteractions = $this->interactionRepository->getRecentForUser($user);
                
            if ($recentInteractions->isEmpty()) {
                return;
            }
            
            $interactedArticleIds = $this->interactionRepository->getInteractedArticleIds($user);
            $existingRecommendationIds = $this->recommendationRepository->getExistingArticleIdsForUser($user);
            $categoryIds = $this->extractCategoryIdsFromInteractions($recentInteractions);
            
            if (empty($categoryIds)) {
                return;
            }
            
            $recommendedArticles = $this->articleRepository->findByCategoryIds(
                $categoryIds, 
                array_merge($interactedArticleIds, $existingRecommendationIds), 
                $limit
            );
                
            $this->createRecommendations($user, $recommendedArticles);
        });
    }
    
    /**
     * Extract category IDs from user interactions
     *
     * @param Collection $interactions
     * @return array
     */
    private function extractCategoryIdsFromInteractions(Collection $interactions): array
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
     * Create recommendation records for a user
     *
     * @param User $user
     * @param Collection $articles
     * @return void
     */
    private function createRecommendations(User $user, Collection $articles): void
    {
        foreach ($articles as $article) {
            $this->recommendationRepository->create([
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
     * @return Collection
     */
    public function getRecommendationsForUser(User $user, int $limit = 5): Collection
    {
        return $this->recommendationRepository->getForUser($user, $limit);
    }
} 