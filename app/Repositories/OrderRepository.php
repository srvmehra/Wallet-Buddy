<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function findByIdempotencyKey(?string $key)
    {
        if (!$key) {
            return null;
        }

        return Order::where('idempotency_key', $key)->first();
    }
}