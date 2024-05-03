<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    use HasFactory;
//    public $table = 'ingredients';
    protected $fillable = ['name', 'category', 'calories'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient');
    }
}
