<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CommentController extends Controller
{
    public function __construct()
    {
        Route::bind('recipe', function ($value) {
            return Recipe::findOrFail($value);
        });
        Route::bind('ingredient', function ($value) {
            return Ingredient::findOrFail($value);
        });
    }

    public function index(Request $request, Recipe|Ingredient $model)
    {
        $comments = $model->comments()->orderByDesc("created_at")->paginate();
        return new CommentCollection($comments);
    }
    public function store(StoreCommentRequest $request, Recipe|Ingredient $model)
    {
        $validated = $request->validated();
        $comment = $model->comments()->make($validated);

        $comment->user()->associate(Auth::user());

        $comment->save();
        return new CommentResource($comment);
    }
}
