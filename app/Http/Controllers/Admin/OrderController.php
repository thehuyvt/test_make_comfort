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
            $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method)['name'];
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
//        if ($orders === null){
//            return redirect()->route('orders.index')
//                ->with('error', 'Đơn hàng không tồn tại!');
//        }
        foreach ($orders as $order){
            $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method)['name'];
            $order->status = OrderStatusEnum::getNameStatus($order->status);
            $order->placed_at = date_format(date_create($order->placed_at), 'H:i-d/m/Y');
            $order->total = number_format($order->total);
        }
        return view('order.pending',[
                'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (!$order){
            return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method)['name'];
        $order->status = OrderStatusEnum::getNameStatus($order->status);
        $orderProducts = OrderProduct::query()->with('variant.product')
            ->where('order_id', $order->id)
            ->get();
        return view('order.detail',[
                'order' => $order,
                'orderProducts' => $orderProducts,
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
        $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method)['name'];
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
