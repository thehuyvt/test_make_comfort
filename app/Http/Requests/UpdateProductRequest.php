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
}
