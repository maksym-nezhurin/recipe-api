<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content'];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
