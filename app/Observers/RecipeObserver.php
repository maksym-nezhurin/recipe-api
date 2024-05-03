<?php

namespace App\Observers;

use App\Models\Recipe;

class RecipeObserver
{
    /**
     * Handle the Recipe "created" event.
     */
    public function created(Recipe $recipe): void
    {
//        $recipe->members()->attach($recipe()->creator_id);
    }

    /**
     * Handle the Recipe "updated" event.
     */
    public function updated(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "deleted" event.
     */
    public function deleted(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "restored" event.
     */
    public function restored(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "force deleted" event.
     */
    public function forceDeleted(Recipe $recipe): void
    {
        //
    }
}
