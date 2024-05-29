<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipe_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

//    public function getLikedReceipts($userId)
//    {
//        // temporary comment
////        $userId = auth()->user()->id;
//        return Recipe::whereHas('likes', function ($query) use ($userId) {
//            $query->where('user_id', $userId);
//        })->get();
//    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
