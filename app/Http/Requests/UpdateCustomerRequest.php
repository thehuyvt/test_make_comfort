<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' =>[
                'required',
                'string' ,
            ],
            'phone_number' =>[
                'required',
                'string',
                'max:20',
                'min:10',
            ],
            'address' =>[
                'required',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng điền tên của bạn',
            'name.string' => 'Tên khách hàng phải là chuỗi',
            'phone_number.required' => 'Vui lòng điền số điện thoại của bạn',
            'phone_number.string' => 'Số điện thoại phải là chuỗi',
            'phone_number.min' => 'Số điện thoại phải có ít nhất :min ký tự',
            'phone_number.max' => 'Số điện thoại không được vượt quá :max ký tự',
            'address.required' => 'Vui lòng điền địa chỉ của bạn',
            'address.string' => 'Địa chỉ phải là chuỗi',
        ];
    }
}
