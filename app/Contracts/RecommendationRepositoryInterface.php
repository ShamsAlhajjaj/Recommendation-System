<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Recommendation;
use Illuminate\Database\Eloquent\Collection;

interface RecommendationRepositoryInterface
{
    /**
     * Get all recommendations for a user
     *
     * @param User $user
     * @param int $limit
     * @return Collection
     */
    public function getForUser(User $user, int $limit = 5): Collection;
    
    /**
     * Create a new recommendation
     *
     * @param array $data
     * @return Recommendation
     */
    public function create(array $data): Recommendation;
    
    /**
     * Get existing recommendation article IDs for a user
     *
     * @param User $user
     * @return array
     */
    public function getExistingArticleIdsForUser(User $user): array;
} 