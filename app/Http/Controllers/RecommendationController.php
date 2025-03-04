<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

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
        try {
            $user = Auth::user();
            
            // Generate fresh recommendations
            $this->recommendationService->generateRecommendations($user);
            
            // Get recommendations
            $recommendedArticles = $this->recommendationService->getRecommendationsForUser($user);
            
            return view('recommendations.index', compact('recommendedArticles'));
        } catch (Exception $e) {
            Log::error('Error generating or displaying recommendations: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('dashboard')
                ->with('error', 'There was a problem loading your recommendations. Please try again later.');
        }
    }
} 