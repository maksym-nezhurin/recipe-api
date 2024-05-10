<?php

namespace Tests\Feature\CommentController;

use App\Models\Ingredient;
use App\Models\Recipe;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentStoreTest extends TestCase
{
    public function test_store_method()
    {
        $recipe = Recipe::factory()->create();
        Sanctum::actingAs($recipe->creator);

        $route = route('recipes.comments.store', $recipe);

        $response = $this->postJson($route, [
            'title' => 'Test comment',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'content' => "Test comment",
            'user_id' => $recipe->creator->id,
            'commentable_id' => $recipe->id,
            'commentable_type' => Recipe::class,
        ]);
    }

    public function test_can_create_comments_for_ingrediens(): void
    {
        $ingredient = Ingredient::factory()->create();
        Sanctum::actingAs($ingredient->creator);

        $route = route('ingredients.comments.store', $ingredient);

        $response = $this->postJson($route, [
            'title' => 'Test comment',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'content' => 'Bar',
            'user_id' => $ingredient->creator->id,
            'commentable_id' => $ingredient->id,
            'commentable_type' => Ingredient::class,
        ]);
    }
}
