<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
//
//Route::middleware('auth:sanctum')->get('/recipes', function () {
//    return response()->json(['user' => auth()->user()]);
//});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes']);
    Route::get('/recipes-by-ingredients', [RecipeController::class, 'getRecipesByIngredients']);
    Route::get('/recipes-by-at-least-one-ingredients', [RecipeController::class, 'getRecipesByIngredientsAtLeastOne']);

    Route::apiResource('ingredients', IngredientController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
//    Route::apiResource('recipes.ingredients', RecipeController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('recipes.comments', CommentController::class)->only(['index', 'store']);
    Route::apiResource('ingredients.comments', CommentController::class)->only(['index', 'store']);
});

Route::apiResource('recipes', RecipeController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
