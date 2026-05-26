<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\CheckoutManager;
use App\Http\Requests\CheckoutRequest;
use App\Helpers\PaymentHelper;

class CheckoutController extends Controller
{
    protected $checkoutManager;

    public function __construct(CheckoutManager $checkoutManager)
    {
        $this->checkoutManager = $checkoutManager;
    }

    public function store(CheckoutRequest $request)
    {
        $user = User::first();
        $paymentDetails = PaymentHelper::paymentDetails($request);
        $order = $this->checkoutManager->placeOrder($user, $request->items, $paymentDetails, $request->header('Idempotency-Key'));

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.',
            'data' => $order
        ]);
    }
}