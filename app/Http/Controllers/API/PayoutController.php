<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\PayoutManager;
use App\Http\Requests\CreatePayoutRequest;

class PayoutController extends Controller
{
    protected $payoutManager;

    public function __construct(PayoutManager $payoutManager)
    {
        $this->payoutManager = $payoutManager;
    }

    public function store(CreatePayoutRequest $request)
    {
        $user = User::first();

        $payoutRequest = $this->payoutManager->createRequest($user, $request->amount, $request->header('Idempotency-Key'));

        return response()->json([
            'success' => true,
            'message' => 'Payout request submitted successfully.',
            'data'    => $payoutRequest
        ]);
    }
}