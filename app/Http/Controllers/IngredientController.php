<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Models\Ingredient;
use App\Http\Resources\IngredientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return IngredientResource::collection(Ingredient::paginate(10));
    }

    /**
     * @param Ingredient $ingredient
     * @return IngredientResource
     */
    public function show(Ingredient $ingredient): IngredientResource
    {
        return new IngredientResource($ingredient);
    }

    /**
     * @param StoreIngredientRequest $request
     * @return IngredientResource
     */
    public function store(StoreIngredientRequest $request): IngredientResource
    {
        $validated = $request->validated();
        $ingredient = new Ingredient();

        return new IngredientResource($ingredient->create($validated));
    }

    /**
     * @param UpdateIngredientRequest $request
     * @param Ingredient $ingredient
     * @return IngredientResource
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient): IngredientResource
    {
        $validated = $request->validated();
        $ingredient->update($validated);

        return new IngredientResource($ingredient);
    }

    /**
     * @param Ingredient $ingredient
     * @return Response
     */
    public function destroy(Ingredient $ingredient): Response
    {
        $ingredient->delete();
        return response()->noContent();
    }
}
