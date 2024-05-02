<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        return RecipeResource::collection(Recipe::paginate(10));
//        return RecipeResource::collection(Recipe::where(['creator_id'=>auth()->user()->id])->paginate(10));
    }

    /**
     * @param Recipe $recipe
     * @return RecipeResource
     */
    public function show(Recipe $recipe): RecipeResource
    {
        return new RecipeResource($recipe);
    }

    /**
     * @param StoreRecipeRequest $request
     * @return RecipeResource
     */
    public function store(StoreRecipeRequest $request): RecipeResource
    {
        $validated = $request->validated();

        // Log errors
        Log::info(Auth::user());
        $recipe = Auth::user()->recipes()->create($validated);
//       $recipe = Recipe::create($validated);
        return new RecipeResource($recipe);
    }

    /**
     * @param UpdateRecipeRequest $request
     * @param Recipe $recipe
     * @return RecipeResource
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): RecipeResource
    {
        $validated = $request->validated();
        $recipe->update($validated);
        return new RecipeResource($recipe);
    }

    /**
     * @param Recipe $recipe
     * @return Response
     */
    public function destroy(Recipe $recipe): Response
    {
        $recipe->delete();
        return response()->noContent();
    }
}
