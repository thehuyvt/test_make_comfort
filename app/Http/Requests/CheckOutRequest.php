<?php

namespace App\Http\Requests;

use App\Enums\OrderPaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckOutRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
            ],
            'address' => [
                'required',
                'string',
            ],
            'payment_method' => [
                'required',
                Rule::in(OrderPaymentMethodEnum::cases()),
            ],
        ];
    }
}
