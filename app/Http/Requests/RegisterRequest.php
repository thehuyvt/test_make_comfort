<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email'=>[
                'required',
                'email',
                Rule::unique('customers', 'email'),
            ],
            'password'=>[
                'required',
                'string',
                'between:6,16',
                'confirmed',
            ],
            'password_confirmation'=>[
                'required',
                'string',
                'between:6,16',
                'same:password',
            ],
            'name'=>[
                'required',
                'string',
                'max:50',
            ],
            'phone_number'=>[
                'required',
                'string',
                'max:20',
                Rule::unique('customers', 'phone_number')->ignore('customerId'),
            ],
            'address'=>[
                'required',
                'string',
            ],
            'gender'=>[
                'required',
                Rule::in(GenderEnum::getArrayGender()),
            ],
            'status'=>[
                Rule::in(UserStatusEnum::getArrayStatus()),
            ],
        ];
    }
}
