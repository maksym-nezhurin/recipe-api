<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeLikeResource;
use App\Models\RecipeLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipeLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():AnonymousResourceCollection
    {
        //
        return RecipeLikeResource::collection(RecipeLike::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $recipeId = $request->recipe_id;

        $recipeLike = RecipeLike::where('user_id', $user->id)
            ->where('recipe_id', $recipeId)
            ->first();

        if ($recipeLike) {
            // If a like exists, delete it
            $recipeLike->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            // If no like exists, create one
            $recipeLike = new RecipeLike();
            $recipeLike->user_id = $user->id;
            $recipeLike->recipe_id = $recipeId;
            $recipeLike->save();
            return response()->json(['status' => 'liked']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RecipeLike $recipeLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecipeLike $recipeLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecipeLike $recipeLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecipeLike $recipeLike)
    {
        //
    }
}
