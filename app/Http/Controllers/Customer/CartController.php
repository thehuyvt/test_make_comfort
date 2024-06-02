<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderPaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOutRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $customerId = session()->get('customer_id');
        $order = Order::query()
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
                'total' => 0,
            ]);
        }

        $listProducts = OrderProduct::query()->with(['variant.product'])
            ->where('order_id', $order->id)
            ->get();

        $listPaymentMethods = OrderPaymentMethodEnum::getArrayPaymentMethod();
        return view('customer.cart',[
                    'listProducts' => $listProducts,
                    'order' => $order,
                    'listPaymentMethods' => $listPaymentMethods,
                ]
        );
    }
    public function addProductToCart(Request $request, Product $product)
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
            $orderProduct = $order->orderProducts()->where('product_variant_id', $productVariant->id)->first();
            if($orderProduct) {
                $orderProduct->quantity = $orderProduct->quantity + $quantity;
                $orderProduct->save();
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

    public function updateCart($id, Request $request)
    {
        $orderProduct = OrderProduct::find($id);
        $productVariant = ProductVariant::find($orderProduct->product_variant_id);
        if ($orderProduct->quantity < $request->input('quantity') && $productVariant->quantity < 1 ) {
            return redirect()->back()->with('error', 'Số lượng hàng không đủ.');
        }

        //Cập nhật số lượng sản phẩm còn lại
        $productVariant = ProductVariant::find($orderProduct->product_variant_id);
        $productVariant->quantity += ($orderProduct->quantity - $request->input('quantity'));
        $productVariant->save();

        //cap nhat lai total trong orders table
        $order = Order::query()->find($orderProduct->order_id);
        $order->total -= $orderProduct->price * ($orderProduct->quantity - $request->input('quantity'));
        $order->save();

        //Cập nhật số lượng - gía bán của sản phẩm trong đơn hàng
        $orderProduct->quantity = $request->input('quantity');
        $orderProduct->price = Product::find($productVariant->product_id)->sale_price;
        $orderProduct->save();

        return response()
            ->json([
                'success' => true,
                'order' => $order,
                ]);
    }

    public function removeProduct( $id) {
        // Logic to remove the product from the cart
        $productVariant = OrderProduct::find($id);

        $order = Order::query()->find($productVariant->order_id);
        $order->total -= $productVariant->price * $productVariant->quantity;
        $order->save();
        $variant = ProductVariant::find($productVariant->product_variant_id);
            $variant->quantity += $productVariant->quantity;
        $variant->save();

        $productVariant->delete();
        return response()
            ->json([
                'success' => true,
                'order' => $order,
            ]);
    }

    public function sumProductsInCart()
    {
        $order = Order::query()->where('customer_id', session()->get('customer_id'))
            ->where('status', OrderStatusEnum::DRAFT)->first();
        if (!$order) {
            return response()
                ->json([
                    'success' => true,
                    'total' => 0,
                ]);
        }
        $total = OrderProduct::where('order_id', $order->id)->sum('quantity');
        return response()
            ->json([
                'success' => true,
                'total' => $total,
            ]);
    }

    //Checkout còn thiếu thanh toán vnpay
    public function checkOut(CheckOutRequest $request, Order $order)
    {
        if ($request->payment_method == 1){
            $order->update([
                'payment_method' => $request->payment_method,
                'status' => OrderStatusEnum::PENDING,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'note' => $request->note,
                'placed_at' => date_format(now(), 'Y-m-d H:i:s'),
                'total' => $order->total + 30000,
            ]);
            return redirect()->route('customers.index')->with("success", "Bạn đã đặt đơn hàng thành công!");
        }
    }

    public function listProductsInCart()
    {
        $order = Order::query()->where('customer_id', session()->get('customer_id'))
            ->where('status', OrderStatusEnum::DRAFT)->first();
        if (!$order) {
            return response()
                ->json([
                    'success' => true,
                    'listProducts' => [],
                ]);
        }
        $listProducts = OrderProduct::query()->with(['variant.product'])
            ->where('order_id', $order->id)
            ->get();
        return response()
            ->json([
                'success' => true,
                'listProducts' => $listProducts,
                'order' => $order,
            ]);
    }
}
