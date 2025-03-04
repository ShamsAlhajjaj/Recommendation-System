<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    protected $recommendationService;
    
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
        
        // Generate fresh recommendations
        $this->recommendationService->generateRecommendations($user);
        
        // Get recommendations
        $recommendedArticles = $this->recommendationService->getRecommendationsForUser($user);
        
        return view('recommendations.index', compact('recommendedArticles'));
    }
} 