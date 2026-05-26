<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function getUserAccount(int $userId)
    {
        return Account::where('user_id', $userId)->first();
    }

    public function getUserAccountForUpdate(int $userId)
    {
        return Account::where('user_id', $userId)->lockForUpdate()->first();
    }

    public function create(array $data)
    {
        return Account::create($data);
    }

    public function updateBalance(Account $account, float $amount)
    {
        return $account->update([
            'available_balance' => $amount
        ]);
    }
}