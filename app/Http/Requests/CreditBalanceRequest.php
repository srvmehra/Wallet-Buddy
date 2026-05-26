<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreditBalanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:1000000',
                'decimal:0,2'
            ],

            'payment_type' => [
                'required',
                'string',
                'in:cash,online'
            ],

            'payment_mode' => [
                'required_if:payment_type,online',
                'string',
                'in:upi,netbanking,card,cash'
            ],

            'transaction_reference' => [
                'nullable',
                'string',
                'max:255'
            ],

            'notes' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }

    public function messages(): array
    {
        return [

            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be numeric.',
            'amount.min' => 'Minimum topup amount is 1.',
            'payment_type.required' => 'Payment type is required.',
            'payment_mode.required_if' =>   'Payment mode is required for online payments.'
        ];
    }
}
