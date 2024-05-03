<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = ['Tomatoes', 'Potatoes', 'Carrots', 'Cucumbers', 'Onions', 'Garlic', 'Peppers', 'Eggplants', 'Zucchinis', 'Pumpkins'];

        for ($i = 0; $i < count($ingredients) - 1; $i++) {
            DB::table('ingredients')->insert([
                'name' => $ingredients[$i],
                'category_id' => 2,
                'calories' => Str::random(10),
            ]);
        }
    }
}
