<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'prep_time' => $this->prep_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'ingredients' => $this->ingredients->map(fn($ingredient) => $ingredient->only('id', 'name', 'calories', 'category_id')),
            'likes' => [
                'users' => $this->likes->load('user')->map(fn($like) => $like->user->only('id', 'name')),
                'amount' => $this->likes->count(),
            ]
        ];

        return $data;
    }
}
