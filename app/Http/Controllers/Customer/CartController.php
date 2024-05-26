<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function update(Request $request, Product $product)
    {
        $variantKey = implode('-', $request->input('options'));
        $quantity = $request->input('quantity');

        session()->put('variant', $variantKey);

        $productVariant = ProductVariant::query()
            ->where('key', $variantKey)
            ->where('product_id', $product->id)
            ->first();

        if(!$productVariant) {
            return redirect()->back()->with('error', 'Không tìm thấy option.');
        }

        if($quantity > $productVariant->quantity) {
            return redirect()->back()->with('error', 'Số lượng trong kho không đủ.');
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

            $order->total += $product->sale_price * $quantity;
            $order->save();
        }

        $productVariant->quantity -= $quantity;
        $productVariant->save();

        return redirect()->back()->with('success', 'Thêm sản phẩm vào giỏ hàng thành công.');
    }
}
