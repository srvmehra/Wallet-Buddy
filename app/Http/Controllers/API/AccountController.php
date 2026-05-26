<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\BalanceManager;
use App\Http\Requests\CreditBalanceRequest;
use App\Helpers\PaymentHelper;

class AccountController extends Controller
{
    protected $balanceManager;

    public function __construct(BalanceManager $balanceManager)
    {
        $this->balanceManager = $balanceManager;
    }

    public function show()
    {
        $user = User::first();

        return response()->json([
            'success' => true,
            'data' => $user->account
        ]);
    }

    public function credit(CreditBalanceRequest $request)
    {
        $user = User::first();
        $paymentDetails = PaymentHelper::paymentDetails($request);

        $account = $this->balanceManager->credit($user->id, $request->amount, 'wallet_topup',  null, null, $paymentDetails);

        return response()->json([
            'success' => true,
            'message' => 'Balance added successfully.',
            'data' => $account
        ]);
    }

    public function ledger()
    {
        $user = User::first();
        $data = $user->ledgerEntries()->latest()->paginate(10);
        return response()->json([
            'success' =>  true,
            'data'    =>  $data
        ]);
    }
}