<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Interaction;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    protected $recommendationService;
    
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }
    
    public function toggleLike(Article $article)
    {
        $user = Auth::user();
        
        $existingLike = Interaction::where([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'interaction_type' => 'like'
        ])->first();
        
        if ($existingLike) {
            $existingLike->delete();
        } else {
            Interaction::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'interaction_type' => 'like'
            ]);
            
            // Generate recommendations after a like interaction
            $this->recommendationService->generateRecommendations($user);
        }
        
        return back();
    }

    public function view(Article $article)
    {
        $user = Auth::user();
        
        // Record the view interaction
        Interaction::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'interaction_type' => 'view'
        ]);
        
        // Generate recommendations after a view interaction
        $this->recommendationService->generateRecommendations($user);
        
        // Redirect to the article show page
        return redirect()->route('articles.show', $article);
    }
} 