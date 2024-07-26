<?php

namespace App\Http\Requests;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'string',
                Rule::unique(Product::class)->ignore($this->product),
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
                'min:1',
            ],
            'sale_price' => [
                'integer',
                'min:1',
                'lte:old_price',
            ],
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
            'status' => [
                'required',
                Rule::in(ProductStatusEnum::cases()),
            ],
            'thumb' => [
                'nullable',
                'image',
                Rule::requiredIf(! $this->old_thumb),
            ],

            // relations
            'images' => [
                'nullable',
                'array',
                Rule::requiredIf(! $this->old_images),
            ],
            'variants' => [
                'required',
                'array',
            ],
            'variants.*' => [
                'integer',
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
            'old_price.min' => 'Giá cũ phải lớn hơn hoặc bằng 1.',

            'sale_price.integer' => 'Giá bán phải là số nguyên.',
            'sale_price.min' => 'Giá bán phải lớn hơn hoặc bằng 1.',
            'sale_price.lte' => 'Giá bán phải nhỏ hơn giá cũ.',

            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không tồn tại.',

            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'status.in' => 'Trạng thái sản phẩm không hợp lệ.',

            'thumb.image' => 'Ảnh phải là một tệp hình ảnh.',
            'thumb.required_if' => 'Ảnh là bắt buộc khi không có ảnh cũ.',

            'images.array' => 'Hình ảnh phải là một mảng.',
            'images.required_if' => 'Hình ảnh là bắt buộc khi không có hình ảnh cũ.',

            'variants.required' => 'Biến thể là bắt buộc.',
            'variants.array' => 'Biến thể phải là một mảng.',
        ];
    }
}
