<?php

namespace App\Observers;

use App\Models\Interaction;
use App\Services\RecommendationService;

class InteractionObserver
{
    protected $recommendationService;
    
    /**
     * Create a new observer instance.
     *
     * @param RecommendationService $recommendationService
     * @return void
     */
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }
    
    /**
     * Handle the Interaction "created" event.
     *
     * @param  \App\Models\Interaction  $interaction
     * @return void
     */
    public function created(Interaction $interaction)
    {
        // When a new interaction is created, generate recommendations for the user
        $this->recommendationService->generateRecommendations($interaction->user);
    }
    
    /**
     * Handle the Interaction "updated" event.
     *
     * @param  \App\Models\Interaction  $interaction
     * @return void
     */
    public function updated(Interaction $interaction)
    {
        //
    }
    
    /**
     * Handle the Interaction "deleted" event.
     *
     * @param  \App\Models\Interaction  $interaction
     * @return void
     */
    public function deleted(Interaction $interaction)
    {
        // When an interaction is deleted, regenerate recommendations for the user
        $this->recommendationService->generateRecommendations($interaction->user);
    }
} 