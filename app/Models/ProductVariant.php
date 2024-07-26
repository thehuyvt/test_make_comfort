<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'quantity',
        'product_id'
    ];

    public $timestamps = false;
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
