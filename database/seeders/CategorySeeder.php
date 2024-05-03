<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

// how to run
// php artisan db:seed --class=CategorySeeder

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Spice']);
        Category::create(['name' => 'Vegetable']);
        Category::create(['name' => 'Fruit']);
        Category::create(['name' => 'Meat']);
        Category::create(['name' => 'Dairy']);
        Category::create(['name' => 'Legume']);
        Category::create(['name' => 'Bean']);
        Category::create(['name' => 'Grain']);
        Category::create(['name' => 'Cereal']);
        Category::create(['name' => 'Poultry']);
        Category::create(['name' => 'Fish']);
        Category::create(['name' => 'Seafood']);
        Category::create(['name' => 'Herb']);
        Category::create(['name' => 'Oil']);
        Category::create(['name' => 'Fat']);
        Category::create(['name' => 'Nut']);
        Category::create(['name' => 'Seed']);

    }
}
