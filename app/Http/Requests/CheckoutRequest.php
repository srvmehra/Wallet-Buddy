<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            ],
            'items' => [
                'required',
                'array',
                'min:1'
            ],
            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id'
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100'
            ]
        ];
    }
}
