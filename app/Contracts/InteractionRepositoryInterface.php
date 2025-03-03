<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Interaction;
use Illuminate\Database\Eloquent\Collection;

interface InteractionRepositoryInterface
{
    /**
     * Get recent interactions for a user
     *
     * @param User $user
     * @param int $count
     * @return Collection
     */
    public function getRecentForUser(User $user, int $count = 3): Collection;
    
    /**
     * Create a new interaction
     *
     * @param array $data
     * @return Interaction
     */
    public function create(array $data): Interaction;
    
    /**
     * Get article IDs that a user has interacted with
     *
     * @param User $user
     * @return array
     */
    public function getInteractedArticleIds(User $user): array;
    
    /**
     * Toggle like interaction for a user and article
     *
     * @param User $user
     * @param int $articleId
     * @return bool
     */
    public function toggleLike(User $user, int $articleId): bool;
} 