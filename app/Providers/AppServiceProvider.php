<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\RecommendationRepositoryInterface;
use App\Contracts\InteractionRepositoryInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\RecommendationRepository;
use App\Repositories\InteractionRepository;
use App\Models\Article;
use App\Models\Interaction;
use App\Observers\ArticleObserver;
use App\Observers\InteractionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(RecommendationRepositoryInterface::class, RecommendationRepository::class);
        $this->app->bind(InteractionRepositoryInterface::class, InteractionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // Register observers
        Article::observe(ArticleObserver::class);
        Interaction::observe(InteractionObserver::class);
    }
}
