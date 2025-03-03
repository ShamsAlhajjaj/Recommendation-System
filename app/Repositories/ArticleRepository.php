<?php

namespace App\Repositories;

use App\Models\Article;
use App\Contracts\ArticleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Article::with('categories')->latest()->get();
    }
    
    /**
     * Find an article by ID
     *
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article
    {
        return Article::with('categories')->find($id);
    }
    
    /**
     * Create a new article
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        
        if (isset($data['categories'])) {
            $article->categories()->attach($data['categories']);
        }
        
        return $article;
    }
    
    /**
     * Update an article
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $article = Article::find($id);
        
        if (!$article) {
            return false;
        }
        
        $updated = $article->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        
        if (isset($data['categories'])) {
            $article->categories()->sync($data['categories']);
        }
        
        return $updated;
    }
    
    /**
     * Delete an article
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $article = Article::find($id);
        
        if (!$article) {
            return false;
        }
        
        return $article->delete();
    }
    
    /**
     * Find articles by category IDs
     *
     * @param array $categoryIds
     * @param array $excludeIds
     * @param int $limit
     * @return Collection
     */
    public function findByCategoryIds(array $categoryIds, array $excludeIds = [], int $limit = 5): Collection
    {
        return Article::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
} 