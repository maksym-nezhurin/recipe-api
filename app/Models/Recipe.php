<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'prep_time'];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }

//    public function ingredients()
//    {
//        return $this->hasMany(Ingredient::class);
//    }
}
