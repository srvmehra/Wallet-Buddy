<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'available_balance' => $this->available_balance,
            'locked_balance' => $this->locked_balance,
            'updated_at' => $this->updated_at,
        ];
    }
}
