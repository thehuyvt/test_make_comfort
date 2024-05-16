<?php

namespace App\Http\Requests;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name'=>[
                'required',
                'string',
                'min:2',
            ],
            'phone_number'=>[
                'required',
                'string',
                'max:20',
                Rule::unique(User::class)->ignore($this->userId),
            ],
            'email'=>[
                'required',
                'email',
                'sometimes',
                Rule::unique(User::class)->ignore($this->userId),
            ],
            'password'=>[
                'required',
                'string',
                'between:6, 16',
                'sometimes',
            ],
            'status'=>[
                'required',
                Rule::in(UserStatusEnum::getArrayStatus()),
            ]
        ];
    }
}
