<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipe = Recipe::first();

        DB::table('recipe_ingredients')->insert([
            'recipe_id' => $recipe->id,
            'ingredient_id' => 1
        ]);
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => $recipe->id,
            'ingredient_id' => 2
        ]);
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => $recipe->id,
            'ingredient_id' => 3
        ]);
    }
}
