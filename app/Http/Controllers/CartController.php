<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Customer;

class CartController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $variantKey = implode('-', $request->input('options'));
        $quantity = $request->input('quantity');

        $productVariant = ProductVariant::query()
            ->where('key', $variantKey)
            ->where('product_id', $product->id)
            ->first();

        if(!$productVariant) {
            return redirect()->back()->with('error', 'Options not found');
        }

        if($quantity > $productVariant->quantity) {
            return redirect()->back()->with('error', 'Quantity not available');
        }

        $customerId = session()->get('customer_id');
        $order = Order::query()
            ->with('orderProducts')
            ->where('customer_id', $customerId)
            ->where('status', OrderStatusEnum::DRAFT)
            ->first();

        if(!$order) {
            $customer = Customer::find($customerId);

            $order = Order::create([
                'customer_id' => $customerId,
                'status' => OrderStatusEnum::DRAFT,
                'name' => $customer->name,
                'address' => $customer->address,
                'phone_number' => $customer->phone_number,
                'total' => $product->sale_price * $quantity,
            ]);

            $order->orderProducts()->create([
                'product_variant_id' => $productVariant->id,
                'quantity' => $quantity,
                'price' => $product->sale_price,
                'thumb' => $product->thumb,
            ]);
        } else {
            $check = $order->orderProducts()->where('product_variant_id', $productVariant->id)->first();
            if($check) {
                $check->quantity = $check->quantity + $quantity;
                $check->save();
            } else {
                $order->orderProducts()->create([
                    'product_variant_id' => $productVariant->id,
                    'quantity' => $quantity,
                    'price' => $product->sale_price,
                    'thumb' => $product->thumb,
                ]);
            }

            $order->total = $product->sale_price * $quantity;
            $order->save();
        }

        $productVariant->quantity = $productVariant->quantity - $quantity;
        $productVariant->save();

        return redirect()->back()->with('success', 'Product added to cart');
    }
}
