<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderPaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $model;
    public function __construct()
    {
        $title = 'Đơn hàng';

        View::share('title', $title);
    }
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('status', '!=', 1)
            ->when($request->payment_method, function ($q,$value){
                $q->where('payment_method', $value);
            })
            ->when($request->status, function ($q, $value){
                $q->where('status', $value);
            })
            ->when($request->id, function ($q, $value){
                $q->where('id', $value);
            })
            ->when($request->key, function ($q, $value){
                $q->where(function($q) use ($value){
                    $q->orWhere('phone_number', 'like', '%'.$value.'%');
                    $q->orWhere('name', 'like', '%'.$value.'%');
                });
            })
            ->orderByDesc('placed_at')
            ->paginate(10);

        foreach ($orders as $order){
            $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
            $order->status = OrderStatusEnum::getNameStatus($order->status);
            $order->placed_at = date_format(date_create($order->placed_at), 'H:i-d/m/Y');
        }

        $listStatus = OrderStatusEnum::getArrayStatus();
        $paymentMethods = OrderPaymentMethodEnum::getArrayPaymentMethod();

        return view('order.index',[
                'orders' => $orders,
                'listStatus' => $listStatus,
                'paymentMethods' => $paymentMethods,
            ]
        );
    }

    public function getOrdersByStatus($status)
    {
        $orders = Order::query()
            ->where('status', $status)
            ->orderByDesc('placed_at')
            ->paginate(10);
        foreach ($orders as $order){
            $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
            $order->status = OrderStatusEnum::getNameStatus($order->status);
            $order->placed_at = date_format(date_create($order->placed_at), 'H:i-d/m/Y');
            $order->total = number_format($order->total);
        }
        return view('order.index',[
                'orders' => $orders,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (!$order){
            return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
        $order->status = OrderStatusEnum::getNameStatus($order->status);
        $user = User::query()->find($order->user_id);
        $orderProducts = OrderProduct::query()->with('variant.product')
            ->where('order_id', $order->id)
            ->get();
        return view('order.detail',[
                'order' => $order,
                'orderProducts' => $orderProducts,
                'user' => $user,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        if (!$order){
            return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
        $order->status = OrderStatusEnum::getNameStatus($order->status);
        $orderProducts = OrderProduct::query()->with('variant.product')
            ->where('order_id', $order->id)
            ->get();
        return view('order.edit',[
                'order' => $order,
                'orderProducts' => $orderProducts,
            ]
        );
    }

    public function update($orderId, UpdateOrderRequest $request)
    {
        $order = Order::query()->find($orderId);
        if (!$order){
            return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->user_id = session('id');
        $order->name = $request->name;
        $order->address = $request->address;
        $order->phone_number = $request->phone_number;
        $order->save();
        return redirect()->route('orders.edit', $order->id)
            ->with('success', 'Cập nhật thông tin nhận hàng thành công!');
    }

    public function updateStatus(Order $order)
    {
        if($order->status === OrderStatusEnum::PENDING->value){
            $order->status = OrderStatusEnum::PROCESSED->value;
            $order->user_id = session('id');
            $order->approved_at = now();
            $order->save();
            $user = User::query()->find($order->user_id);
        }
        return response()->json(['success' => true, 'data' => ['user_name' => $user->name]]);
    }

    public function rejectOrder(Order $order)
    {
        if($order->status === OrderStatusEnum::PENDING->value){
            $productsInOrder = $order->orderProducts;
            foreach ($productsInOrder as $product)
            {
                $productVariant = ProductVariant::query()->find($product->product_variant_id);
                $productVariant->quantity += $product->quantity;
                $productVariant->save();
            }
            $order->status = OrderStatusEnum::REJECT->value;
            $order->user_id = session('id');
            $order->save();

            $user = User::query()->find($order->user_id);
        }else{
            return false;
        }
        return response()->json(['success' => true, 'data' => ['user_name' => $user->name]]);
    }
}
