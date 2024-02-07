<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'key_id' => 'required',
            'key_secret'=>'required',

            // 'stripe_client_id'
            // 'stripe_client_secret'

            // 'paypal_type'
            // 'paypal_client_id'
            // 'paypal_client_secret'
        ];
    }
}
