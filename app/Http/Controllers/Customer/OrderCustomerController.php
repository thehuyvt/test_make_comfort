<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderPaymentMethodEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use function PHPUnit\Framework\isEmpty;

class OrderCustomerController extends Controller
{
    public function history()
    {
        $orders = Order::query()
            ->where('customer_id', session('customer_id'))
            ->where('status', '!=', 1)
            ->orderByDesc('placed_at')->get();
        foreach ($orders as $order){
            $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
            $order->status_name = OrderStatusEnum::getNameStatus($order->status);
            $order->placed_at = date_format(date_create($order->placed_at), 'H:i-d/m/Y');
            $order->total = number_format($order->total);
        }
        return view('customer.order.history', compact('orders'));
    }

    public function detail($orderId)
    {
        $order = Order::query()->with('orderProducts.variant.product')
            ->where('customer_id', session('customer_id'))
            ->where('id', $orderId)
            ->first();

        if ($order == []){
            return redirect()->route('orders.history')
                ->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->payment_method = OrderPaymentMethodEnum::getNamePaymentMethod($order->payment_method);
        $order->status_name = OrderStatusEnum::getNameStatus($order->status);
        $order->placed_at = date_format(date_create($order->placed_at), 'H:i-d/m/Y');
        $order->total = number_format($order->total);
        return view('customer.order.detail', compact('order'));
    }

    public function cancel($orderId)
    {
        $order = Order::query()->where('customer_id', session('customer_id'))
            ->where('id', $orderId)
            ->where('status', OrderStatusEnum::PENDING->value)
            ->first();

        if ($order->all() == []) {
            return redirect()->route('orders.history')
                ->with('error', 'Đơn hàng không tồn tại!');
        }
        $order->status = 6;
        $order->save();
        return redirect()->route('orders.history')
            ->with('success', 'Đơn hàng đã hủy thành công!');
    }
}
