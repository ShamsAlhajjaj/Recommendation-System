<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\InteractionRepositoryInterface;

class InteractionController extends Controller
{
    protected $interactionRepository;
    
    /**
     * Create a new controller instance.
     *
     * @param InteractionRepositoryInterface $interactionRepository
     * @return void
     */
    public function __construct(InteractionRepositoryInterface $interactionRepository)
    {
        $this->interactionRepository = $interactionRepository;
    }
    
    /**
     * Record a view interaction for an article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function view(Article $article)
    {
        $user = Auth::user();
        
        // Record the view interaction
        $this->interactionRepository->create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'interaction_type' => 'view'
        ]);
        
        return redirect()->route('articles.show', $article);
    }
    
    /**
     * Toggle a like interaction for an article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function toggleLike(Article $article)
    {
        $user = Auth::user();
        
        // Toggle the like interaction
        $this->interactionRepository->toggleLike($user, $article->id);
        
        return back();
    }
} 