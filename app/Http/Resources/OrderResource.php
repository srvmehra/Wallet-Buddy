<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'reference' => $this->reference,
            'amount' => $this->amount,
            'status' => $this->status,
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_title' => $item->product?->title,
                    'product_sku' => $item->product?->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ];
            }),
            'created_at' => $this->created_at,
        ];
    }
}