<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Interaction;
use App\Services\InteractionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class InteractionController extends Controller
{
    protected $interactionService;
    
    public function __construct(InteractionService $interactionService)
    {
        $this->interactionService = $interactionService;
    }
    
    /**
     * Toggle like status for an article
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function toggleLike(Article $article)
    {
        try {
            $message = $this->interactionService->toggleLike(Auth::user(), $article);
            return back()->with('success', $message);
        } catch (Exception $e) {
            Log::error('Error toggling article like: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id,
                'user_id' => Auth::id()
            ]);
            
            return back()->with('error', 'There was a problem processing your request. Please try again later.');
        }
    }

    /**
     * Record a view interaction for an article
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function view(Article $article)
    {
        try {
            $this->interactionService->recordView(Auth::user(), $article);
            
            // Redirect to the article show page
            return redirect()->route('articles.show', $article);
        } catch (Exception $e) {
            Log::error('Error recording article view: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('dashboard')
                ->with('error', 'There was a problem viewing the article. Please try again later.');
        }
    }
} 