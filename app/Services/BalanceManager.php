<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\LedgerRepository;
use Exception;

class BalanceManager
{
    protected $accountRepository;
    protected $ledgerRepository;

    public function __construct(AccountRepository $accountRepository, LedgerRepository $ledgerRepository) {
        $this->accountRepository = $accountRepository;
        $this->ledgerRepository = $ledgerRepository;
    }

    public function credit($userId, $amount, $activity, $referenceType = null, $referenceId = null, $paymentDetails = [])
    {
        $account = $this->accountRepository->getUserAccountForUpdate($userId);

        $beforeBalance = $account->available_balance;
        $afterBalance = $beforeBalance + $amount;

        $account->update([
            'available_balance' => $afterBalance
        ]);

        $this->createLedgerEntry($userId, 'credit', $activity, $amount, $beforeBalance, $afterBalance, $referenceType, $referenceId, $paymentDetails);  

        return $account->fresh();
    }

    public function debit($userId, $amount, $activity, $referenceType = null, $referenceId = null, $paymentDetails = [])
    {
        $account = $this->accountRepository->getUserAccountForUpdate($userId);

        if ($account->available_balance < $amount) {
            throw new Exception('User Do not have sufficient Balance.');
        }

        $beforeBalance = $account->available_balance;
        $afterBalance = $beforeBalance - $amount;

        $account->update([
            'available_balance' => $afterBalance
        ]);

        $this->createLedgerEntry($userId, 'debit', $activity, $amount, $beforeBalance, $afterBalance, $referenceType, $referenceId, $paymentDetails);

        return $account->fresh();
    }


    public function createLedgerEntry( $userId, $entryType, $activity, $amount, $beforeBalance, $afterBalance, $referenceType = null, $referenceId = null, $paymentDetails = []) {

        return $this->ledgerRepository->create([
            'user_id' => $userId,
            'entry_type' => $entryType,
            'activity' => $activity,
            'amount' => $amount,
            'balance_before' => $beforeBalance,
            'balance_after' => $afterBalance,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'payment_type' => $paymentDetails ? $paymentDetails['payment_type'] : 'cash',
            'payment_mode' => $paymentDetails ? $paymentDetails['payment_mode'] : 'cash',
            'transaction_reference' => $paymentDetails ? $paymentDetails['transaction_reference'] : null,
            'notes' => $paymentDetails ? $paymentDetails['notes'] : null,
        ]);
    }
}