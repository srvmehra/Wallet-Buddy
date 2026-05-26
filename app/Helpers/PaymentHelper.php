<?php

namespace App\Helpers;

class PaymentHelper
{
    public static function paymentDetails($request): array
    {
        return [
            'payment_type'  => $request->payment_type,
            'payment_mode'  => $request->payment_mode,
            'notes'         => $request->notes,
            'transaction_reference' => $request->transaction_reference,
        ];
    }
}