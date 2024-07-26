<?php

namespace App\Http\Requests;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'slug' => [
                'required',
                'string',
                Rule::unique(Product::class)->ignore($this->productId),
            ],
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'old_price' => [
                'required',
                'integer',
                'min:0',
            ],
            'sale_price' => [
                'integer',
                'min:0',
            ],
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
            'status' => [
                'required',
                Rule::in(ProductStatusEnum::getArrayStatus()),
            ],
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',

            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',

            'description.required' => 'Mô tả sản phẩm là bắt buộc.',
            'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',

            'old_price.required' => 'Giá cũ là bắt buộc.',
            'old_price.integer' => 'Giá cũ phải là số nguyên.',
            'old_price.min' => 'Giá cũ phải lớn hơn hoặc bằng 0.',

            'sale_price.integer' => 'Giá bán phải là số nguyên.',
            'sale_price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',

            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không tồn tại.',

            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'status.in' => 'Trạng thái sản phẩm không hợp lệ.',
        ];
    }
}
