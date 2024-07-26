<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password'=>[
                'required',
            ],
            'new_password'=>[
                'required',
                'string',
                'between:6,16',
                'confirmed'
            ],
            'new_password_confirmation'=>[
                'required',
                'string',
                'between:6,16',
            ]
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu hiện tại là bắt buộc.',

            'new_password.required' => 'Mật khẩu mới là bắt buộc.',
            'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
            'new_password.between' => 'Mật khẩu mới phải có độ dài từ 6 đến 16 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',

            'new_password_confirmation.required' => 'Xác nhận mật khẩu mới là bắt buộc.',
            'new_password_confirmation.string' => 'Xác nhận mật khẩu mới phải là chuỗi ký tự.',
            'new_password_confirmation.between' => 'Xác nhận mật khẩu mới phải có độ dài từ 6 đến 16 ký tự.',
        ];
    }
}
