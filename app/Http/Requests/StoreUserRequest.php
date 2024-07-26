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
                'regex:/^(0[35789][0-9]{8}|\+84[35789][0-9]{8})$/',
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
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',

            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'phone_number.unique' => 'Số điện thoại đã tồn tại.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.between' => 'Mật khẩu phải có độ dài từ 6 đến 16 ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}
