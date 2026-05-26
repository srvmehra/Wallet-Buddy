<?php

namespace App\Jobs;

use Exception;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
use App\Models\PayoutRequest;
use App\Services\BalanceManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandlePayoutRequest implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 30;
    protected $payoutRequest;

    public function __construct(PayoutRequest $payoutRequest)
    {
        $this->payoutRequest = $payoutRequest;
    }

    public function handle(BalanceManager $balanceManager)
    {
        DB::beginTransaction();

        try {

            Log::info('Started payout processing.', [
                'payout_request_id' => $this->payoutRequest->id
            ]);

            $payoutRequest = PayoutRequest::lockForUpdate()
                ->find($this->payoutRequest->id);

            if (!$payoutRequest) {

                Log::warning('Payout request not found.', [
                    'payout_request_id' => $this->payoutRequest->id
                ]);

                return;
            }

            if ($payoutRequest->status !== 'queued') {

                Log::warning('Payout request already processed.', [
                    'payout_request_id' => $payoutRequest->id,
                    'status' => $payoutRequest->status
                ]);

                return;
            }

            $account = Account::lockForUpdate()
                ->where('user_id', $payoutRequest->user_id)
                ->first();

            if (!$account) {

                Log::error('Account not found for payout.', [
                    'user_id' => $payoutRequest->user_id
                ]);

                throw new Exception('Account not found.');
            }

            if ($account->locked_balance < $payoutRequest->amount) {

                Log::error('Locked balance is insufficient.', [
                    'user_id' => $payoutRequest->user_id,
                    'locked_balance' => $account->locked_balance,
                    'requested_amount' => $payoutRequest->amount
                ]);

                throw new Exception('Locked balance is insufficient.');
            }

            $account->update([
                'locked_balance' => $account->locked_balance - $payoutRequest->amount
            ]);

            $payoutRequest->update(['status' => 'processed', 'processed_at' => now()]);

            $balanceManager->createLedgerEntry($payoutRequest->user_id, 'debit', 'payout_processed', $payoutRequest->amount, $account->available_balance, $account->available_balance, 'payout_request', $payoutRequest->id);

            DB::commit();

            Log::info('Payout processed successfully.', [
                'payout_request_id' => $payoutRequest->id,
                'amount' => $payoutRequest->amount
            ]);

        } catch (Exception $exception) {

            DB::rollBack();

            Log::error('Payout processing failed.', [
                'payout_request_id' => $this->payoutRequest->id,
                'message' => $exception->getMessage()
            ]);

            throw $exception;
        }
    }

    public function failed($exception)
    {
        $this->payoutRequest->update([
            'status' => 'failed',
            'failure_reason' => $exception->getMessage()
        ]);

        Log::error('Payout job failed permanently.', [
            'payout_request_id' => $this->payoutRequest->id,
            'message' => $exception->getMessage()
        ]);
    }
}