<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'calories', 'category_id', 'creator_id'];
    protected $casts = [
        'calories' => 'integer',
        'created_at' => 'datetime:Y-m-d',
    ];
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
