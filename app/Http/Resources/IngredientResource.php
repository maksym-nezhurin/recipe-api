<?php

namespace App\Http\Resources;

//use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            "name"      =>  $this->name,
            "category"  =>  $this->category,
//            "category"=>CategoryResource::collection($this->category),
            "calories"  =>  $this->calories,
        ];
    }
}
