<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Recipe::class, 'recipe');
    }
    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        return RecipeResource::collection(Recipe::paginate(10));
//        return RecipeResource::collection(Recipe::where(['creator_id'=>auth()->user()->id])->paginate(10));
    }

    public function myRecipes(): AnonymousResourceCollection
    {
        return RecipeResource::collection(Recipe::where(['creator_id'=>auth()->user()->id])->paginate(10));
    }

    /**
     * @param Recipe $recipe
     * @return RecipeResource
     */
    public function show(Recipe $recipe): RecipeResource
    {
        // allowing to get list of ingredients for each recipe
        $recipe->load('ingredients');

        return new RecipeResource($recipe);
    }

    /**
     * @param StoreRecipeRequest $request
     * @return RecipeResource
     */
    public function store(StoreRecipeRequest $request): RecipeResource
    {
        $validated = $request->validated();

        // What about this line? Is it create recipe for the authenticated user only?
        $recipe = Auth::user()->recipes()->create($validated);

        foreach ($validated['ids'] as $ingredientId) {
            $recipe->ingredients()->attach($ingredientId);
        }

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

        foreach ($validated['ids'] as $ingredientId) {
            $recipe->ingredients()->attach($ingredientId);
        }

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
