<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LedgerEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'entry_type' => $this->entry_type,
            'activity' => $this->activity,
            'amount' => $this->amount,
            'balance_before' => $this->balance_before,
            'balance_after' => $this->balance_after,
            'payment_type' => $this->payment_type,
            'payment_mode' => $this->payment_mode,
            'transaction_reference' => $this->transaction_reference,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}
