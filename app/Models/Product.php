<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'old_price',
        'sale_price',
        'thumb',
        'category_id',
        'status',
        'options',
    ];
    protected $cast = [
        'created_at' => 'datetime:d/m/Y',
    ];

    // relations
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function images():HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function variants():HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return ProductStatusEnum::getNameStatus($this->status);
    }

    protected function options(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => json_decode($value ?? '', true),
            set: fn (array $value) => json_encode($value),
        );
    }
}
