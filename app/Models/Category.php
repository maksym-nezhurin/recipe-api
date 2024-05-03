<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

//    public function ingredients()
//    {
//        return $this->hasMany(Ingredient::class);
//    }
}