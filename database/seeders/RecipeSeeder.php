<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        DB::table('recipes')->insert([
            "creator_id" => $user->id,
            'name' => 'Tomato Soup',
            'description' => 'A delicious tomato soup',
            "image" => "https://static.vkusnyblog.com/full/uploads/2008/09/kurinyi-sup-s-lapshoi-new.jpg",
//            'calories' => 100,
            "prep_time" => 2500,
//            'instructions' => 'Boil tomatoes, add salt, pepper, and sugar, blend, and serve',
        ]);
    }
}
