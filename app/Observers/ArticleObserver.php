<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        // Clear any cached article lists
        $this->clearArticleCache();
    }
    
    /**
     * Handle the Article "updated" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        // Clear any cached article lists and the specific article cache
        $this->clearArticleCache();
        Cache::forget("article_{$article->id}");
    }
    
    /**
     * Handle the Article "deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        // Clear any cached article lists and the specific article cache
        $this->clearArticleCache();
        Cache::forget("article_{$article->id}");
    }
    
    /**
     * Clear article-related caches
     *
     * @return void
     */
    private function clearArticleCache(): void
    {
        Cache::forget('articles_all');
        Cache::forget('articles_recent');
        
        // Clear category-based article caches
        $keys = Cache::get('article_category_cache_keys', []);
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
} 