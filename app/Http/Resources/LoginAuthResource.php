<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'image' => $this->resource->avatar,
            ],
            'message' => 'Login successful',
            'success' => true,
            'access_token' => $this->resource->createToken('api_token')->plainTextToken,
        ];
    }
}
