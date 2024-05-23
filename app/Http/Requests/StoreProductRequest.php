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
}
