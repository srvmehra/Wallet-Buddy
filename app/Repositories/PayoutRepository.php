<?php

namespace App\Repositories;

use App\Models\PayoutRequest;

class PayoutRepository
{
    public function create(array $data)
    {
        return PayoutRequest::create($data);
    }

    public function getQueuedPayouts()
    {
        return PayoutRequest::where('status', 'queued')->get();
    }

    public function findByIdempotencyKey($idempotencyKey)
    {
        return PayoutRequest::where('idempotency_key', $idempotencyKey)->first();
    }
}