<?php

namespace App\Observers;

use App\Models\Interaction;
use App\Services\RecommendationService;

class InteractionObserver
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Handle the Interaction "created" event.
     */
    public function created(Interaction $interaction): void
    {
        $this->recommendationService->generateRecommendations($interaction->user);
    }

    /**
     * Handle the Interaction "updated" event.
     */
    public function updated(Interaction $interaction): void
    {
        //
    }

    /**
     * Handle the Interaction "deleted" event.
     */
    public function deleted(Interaction $interaction): void
    {
        if ($interaction->interaction_type === 'like') {
            $this->recommendationService->generateRecommendations($interaction->user);
        }
    }

    /**
     * Handle the Interaction "restored" event.
     */
    public function restored(Interaction $interaction): void
    {
        //
    }

    /**
     * Handle the Interaction "force deleted" event.
     */
    public function forceDeleted(Interaction $interaction): void
    {
        //
    }
}
