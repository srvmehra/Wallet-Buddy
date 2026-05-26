<?php

namespace App\Services;

use Exception;
use App\Jobs\HandlePayoutRequest;
use Illuminate\Support\Facades\DB;
use App\Repositories\PayoutRepository;
use App\Repositories\AccountRepository;

class PayoutManager
{
    protected $payoutRepository;
    protected $accountRepository;
    protected $balanceManager;

    public function __construct(PayoutRepository $payoutRepository, AccountRepository $accountRepository, BalanceManager $balanceManager) {
        $this->payoutRepository = $payoutRepository;
        $this->accountRepository = $accountRepository;
        $this->balanceManager = $balanceManager;
    }

    public function createRequest($user, $amount, $idempotencyKey = null)
    {
        DB::beginTransaction();

        try {
            if ($idempotencyKey) {
                $existingPayoutRequest = $this->payoutRepository->findByIdempotencyKey($idempotencyKey);
                if ($existingPayoutRequest) {
                    return $existingPayoutRequest;
                }
            }

            $account = $this->accountRepository->getUserAccountForUpdate($user->id);

            if ($account->available_balance < $amount) {
                throw new Exception('User Do not have sufficient Balance.');
            }

            $account->update([
                'available_balance' =>  $account->available_balance - $amount,
                'locked_balance'    =>  $account->locked_balance + $amount
            ]);

            $payoutRequest = $this->payoutRepository->create([
                'user_id' => $user->id,
                'reference' => 'PAY-' . strtoupper(uniqid()),
                'amount' => $amount,
                'status' => 'queued',
                'idempotency_key' => $idempotencyKey
            ]);

            DB::commit();

            HandlePayoutRequest::dispatch($payoutRequest);

            return $payoutRequest;

        } catch (Exception $exception) {

            DB::rollBack();

            throw $exception;
        }
    }
}