<?php

namespace App\Repositories;

use App\Models\LedgerEntry;

class LedgerRepository
{
    public function create(array $data)
    {
        return LedgerEntry::create($data);
    }
}