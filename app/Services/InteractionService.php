<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class InteractionService
{
    /**
     * Toggle like status for an article
     *
     * @param User $user
     * @param Article $article
     * @return string Success message
     * @throws Exception
     */
    public function toggleLike(User $user, Article $article): string
    {
        return DB::transaction(function () use ($user, $article) {
            $existingLike = Interaction::where([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'interaction_type' => 'like'
            ])->first();
            
            if ($existingLike) {
                $existingLike->delete();
                $message = 'Article unliked successfully.';
            } else {
                Interaction::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                    'interaction_type' => 'like'
                ]);
                
                $message = 'Article liked successfully.';
            }
            
            return $message;
        });
    }

    /**
     * Record a view interaction for an article
     *
     * @param User $user
     * @param Article $article
     * @throws Exception
     */
    public function recordView(User $user, Article $article): void
    {
        DB::transaction(function () use ($user, $article) {
            Interaction::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'interaction_type' => 'view'
            ]);
        });
    }
} 