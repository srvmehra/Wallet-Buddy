<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'is_active' => $this->is_active,
        ];
    }
}