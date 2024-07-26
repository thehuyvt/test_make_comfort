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
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class StatisticalController extends Controller
{
    public function __construct()
    {
        $title = 'Thống kê';
        View::share('title', $title);
    }

    public function getData(Request $request)
    {
        $date = $request->date('date') ?? now();
        $startDate = $date->clone()->startOfDay()->subDay();
        $endDate = $date->clone()->endOfDay();

        $orders = Order::query()
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) as total_cancel', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('COUNT(CASE WHEN status >= ? THEN 1 END) as total_order', [OrderStatusEnum::ORDERING->value])
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupByRaw('DATE(updated_at)')
            ->orderByDesc('updated_at')
            ->get();

        $customers = Customer::query()
            ->selectRaw('COUNT(*) as total_customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->orderByDesc('created_at')
            ->get();
        $data = [];
        foreach ($orders as $key => $order) {
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
            ->selectRaw('DATE(updated_at) as date')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        foreach ($data as $each) {
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

    public function getRevenue()
    {
        $year = Carbon::now()->year;

        // Truy vấn dữ liệu doanh thu hàng tháng và trạng thái đơn hàng
        $monthlyRevenue = DB::table('orders')
            ->select(
                DB::raw('MONTH(placed_at) as month'),
                DB::raw('SUM(total) as total'),
                DB::raw('SUM(CASE WHEN status != ' . OrderStatusEnum::DRAFT->value . ' THEN 1 ELSE 0 END) as total_orders'),
                DB::raw('SUM(CASE WHEN status = ' . OrderStatusEnum::CANCELLED->value . ' THEN 1 ELSE 0 END) as cancelled_orders'),
                DB::raw('SUM(CASE WHEN status = ' . OrderStatusEnum::CANCELLED->value . ' THEN total ELSE 0 END) as cancelled_revenue'),
                DB::raw('SUM(CASE WHEN status = ' . OrderStatusEnum::REJECT->value . ' THEN total ELSE 0 END) as rejected_revenue'),
                DB::raw('SUM(CASE WHEN status = ' . OrderStatusEnum::PENDING->value . ' THEN total ELSE 0 END) as pending_revenue'),
                DB::raw('SUM(CASE WHEN status = ' . OrderStatusEnum::PROCESSED->value . ' THEN total ELSE 0 END) as successful_revenue')
            )
            ->whereYear('placed_at', $year)
            ->groupBy(DB::raw('MONTH(placed_at)'))
            ->get();

        // Tạo dữ liệu cho biểu đồ Highcharts
        $monthlyRevenueData = [];
        foreach ($monthlyRevenue as $data) {
            $monthName = 'Tháng ' . $data->month;
            $monthlyRevenueData[] = [
                'name' => $monthName,
                'y' => (int)$data->total,
                'drilldown' => $monthName,
            ];
            $successRevenueData[$monthName] = (int)$data->successful_revenue;
            $cancelledRevenueData[$monthName] = (int)$data->cancelled_revenue + (int)$data->rejected_revenue;
            $pendingRevenueData[$monthName] = (int)$data->pending_revenue;
        }

        $detailRevenue = [];
        foreach ($monthlyRevenueData as $data) {
            $month = $data['name'];
            $detailRevenue[] = [
                'name' => $month,
                'id' => $month,
                'data' => [
                    ['Đơn hoàn thành', $successRevenueData[$month]],
                    ['Đơn chưa hoàn thành', $pendingRevenueData[$month]],
                    ['Đơn bị hủy và từ chối', $cancelledRevenueData[$month]]
                ]
            ];
        }
        return view('statistical.revenue', [
            'monthlyRevenueData' => json_encode($monthlyRevenueData),
            'detailRevenue' => json_encode($detailRevenue),
        ]);
    }
}
