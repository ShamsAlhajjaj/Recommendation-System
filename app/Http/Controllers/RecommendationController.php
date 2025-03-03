<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RecommendationController extends Controller
{
    protected $recommendationService;
    
    /**
     * Create a new controller instance.
     *
     * @param RecommendationService $recommendationService
     * @return void
     */
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }
    
    /**
     * Display a listing of recommended articles for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $cacheKey = "user_{$user->id}_recommendations_page";
        
        // Cache the recommendations page for 15 minutes
        $recommendedArticles = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($user) {
            // Generate fresh recommendations
            $this->recommendationService->generateRecommendations($user);
            
            // Get recommendations
            return $this->recommendationService->getRecommendationsForUser($user);
        });
        
        return view('recommendations.index', compact('recommendedArticles'));
    }
} 