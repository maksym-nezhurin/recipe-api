<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

//    protected static function booted(): void
//    {
//        static::addGlobalScope('creator', function (Builder $builder) {
//            $builder->where('creator_id', Auth::id());
//        });
//    }

//    public function ingredients()
//    {
//        return $this->hasMany(Ingredient::class);
//    }
}
