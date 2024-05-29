<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'prep_time'];

//    protected $casts = [
//        'is_done' => 'boolean',
//    ];

    protected $hidden = [
        'updated_at',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }

    // Working for getting ingredient for the recipe, but if I added // : BelongsToMany stop working
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients');
    }

    public function likes()
    {
        return $this->hasMany(RecipeLike::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
