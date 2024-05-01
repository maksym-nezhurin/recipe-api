<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = QueryBuilder::for(Recipe::class)
            ->allowedFilters(['name', 'description', 'image', 'prep_time'])
            ->defaultSort('name')
            ->allowedSorts(['name', 'description', 'image', 'prep_time'])
            ->paginate();

        return new RecipeCollection($recipes);
//        return new RecipeCollection(Recipe::paginate());
    }

    public function show(Request $request, Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    public function store(StoreRecipeRequest $request)
    {
        $validated = $request->validated();
        $recipe = Recipe::create($validated);
        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();
        $recipe->update($validated);
        return new RecipeResource($recipe);
    }

    public function destroy(Request $request, Recipe $recipe)
    {
        $recipe->delete();
        return response()->noContent();
    }
}
