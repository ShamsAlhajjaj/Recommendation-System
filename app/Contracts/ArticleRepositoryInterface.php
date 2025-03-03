<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    /**
     * Get all articles
     *
     * @return Collection
     */
    public function all(): Collection;
    
    /**
     * Find an article by ID
     *
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article;
    
    /**
     * Create a new article
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article;
    
    /**
     * Update an article
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;
    
    /**
     * Delete an article
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * Find articles by category IDs
     *
     * @param array $categoryIds
     * @param array $excludeIds
     * @param int $limit
     * @return Collection
     */
    public function findByCategoryIds(array $categoryIds, array $excludeIds = [], int $limit = 5): Collection;
} 