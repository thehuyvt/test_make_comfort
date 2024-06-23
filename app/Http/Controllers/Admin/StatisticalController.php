<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;
use Illuminate\Support\Str;

class StatisticalController extends Controller
{
    public function getData(Request $request)
    {
        $date = $request->date('date') ?? now();
        $startDate = $date->clone()->startOfDay()->subDay();
        $endDate = $date->clone()->endOfDay();

        $orders = Order::query()
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) as total_cancel', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('COUNT(CASE WHEN status != ? THEN 1 END) as total_order', [OrderStatusEnum::CANCELLED->value])
            ->whereBetween('placed_at', [$startDate, $endDate])
            ->groupByRaw('DATE(placed_at)')
            ->orderByDesc('placed_at')
            ->get();

        $customers = Customer::query()
            ->selectRaw('COUNT(*) as total_customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('created_at')
            ->get();
        $data = [];
        foreach($orders as $key => $order) {
            $data[$key] = $order;
            $data[$key]->total_customer = $customers[$key]->total_customer ?? 0;
        }

        return response()->json($data);
    }

    public function getDataOrderChart(Request $request): JsonResponse
    {
        $startDate = Carbon::now()->startOfDay()->subDay(14);
        $endDate = Carbon::now()->endOfDay();

        $allDates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $date = $currentDate->format('m-d');
            $allDates[$date] = [
                'total_add_to_cart' => 0,
                'total_checkout' => 0,
                'total_order' => 0,
                'conversion_rate' => 0,
                'date' => $date
            ];
            $currentDate->addDay();
        }

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = Order::query()
            ->selectRaw('COUNT(*) as total_add_to_cart')
            ->selectRaw('COUNT(CASE WHEN status > ? THEN 1 END) as total_checkout', [OrderStatusEnum::DRAFT->value])
            ->selectRaw('COUNT(CASE WHEN status > ? THEN 1 END) as total_order', [OrderStatusEnum::ORDERING->value])
            ->selectRaw('DATE(placed_at) as date')
            ->whereBetween('placed_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        foreach($data as $each){
            $date = Str::after($each->date, '-');
            $allDates[$date]['total_add_to_cart'] = $each->total_add_to_cart;
            $allDates[$date]['total_checkout'] = $each->total_checkout;
            $allDates[$date]['total_order'] = $each->total_order;
            $allDates[$date]['conversion_rate'] = $each->total_order / $each->total_add_to_cart * 100;
        }

        $arr['add_to_cart'] = array_column($allDates, 'total_add_to_cart');
        $arr['checkout'] = array_column($allDates, 'total_checkout');
        $arr['order'] = array_column($allDates, 'total_order');
        $arr['conversion_rate'] = array_column($allDates, 'conversion_rate');
        $arr['date'] = array_keys($allDates);
        return response()->json($arr);
    }

    public function getTopProductSell()
    {
        $startDate = Carbon::now()->startOfDay()->subDay(14);
        $endDate = Carbon::now()->endOfDay();

        $bestSellingProducts = OrderProduct::query()
            ->select([
                'products.id',
                'products.name',
            ])
            ->selectRaw('SUM(order_products.quantity) as total_quantity')
            ->join('product_variants', 'order_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereBetween('orders.placed_at', [$startDate, $endDate])
            ->groupBy('products.id')
            ->orderByDesc('total_quantity')
            ->get();

        return response()->json($bestSellingProducts);
    }
}
