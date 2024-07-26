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
                'regex:/^(0[35789][0-9]{8}|\+84[35789][0-9]{8})$/',
                Rule::unique('customers', 'phone_number')->ignore('customerId'),
            ],
            'address'=>[
                'required',
                'string',
            ],
            'gender'=>[
                'required',
//                Rule::in(GenderEnum::getArrayGender()),
            ],
            'status'=>[
                Rule::in(UserStatusEnum::getArrayStatus()),
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.between' => 'Mật khẩu phải có độ dài từ 6 đến 16 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',

            'password_confirmation.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'password_confirmation.string' => 'Xác nhận mật khẩu phải là một chuỗi ký tự.',
            'password_confirmation.between' => 'Xác nhận mật khẩu phải có độ dài từ 6 đến 16 ký tự.',
            'password_confirmation.same' => 'Xác nhận mật khẩu không khớp với mật khẩu.',

            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 50 ký tự.',

            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'phone_number.unique' => 'Số điện thoại đã tồn tại.',

            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',

            'gender.required' => 'Giới tính là bắt buộc.',

            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
