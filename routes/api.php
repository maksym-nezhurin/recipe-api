<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\RecipeLikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// describe routes for all and for one recipe
Route::apiResource('recipes', RecipeController::class)->only(['index', 'show']);

// Just for logged users
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/like', RecipeLikeController::class)->only(['index', 'store', 'destroy']);
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes']);
    Route::get('/liked-recipes', [RecipeController::class, 'likedRecipes']);
    Route::get('/recipes-by-ingredients', [RecipeController::class, 'getRecipesByIngredients']);
    Route::get('/recipes-by-at-least-one-ingredients', [RecipeController::class, 'getRecipesByIngredientsAtLeastOne']);
    Route::apiResource('recipes', RecipeController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('ingredients', IngredientController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
//    Route::apiResource('recipes.ingredients', RecipeController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('recipes.comments', CommentController::class)->only(['index', 'store']);
    Route::apiResource('ingredients.comments', CommentController::class)->only(['index', 'store']);
});
