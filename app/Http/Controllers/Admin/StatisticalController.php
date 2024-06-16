<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class StatisticalController extends Controller
{
    public function getData(Request $request)
    {
        $startDate = Carbon::now()->startOfDay()->subDay(1);
        $endDate = Carbon::now()->endOfDay();

        $data = Order::query()
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) as total_cancel', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('COUNT(CASE WHEN status != ? THEN 1 END) as total_order', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('DATE(placed_at) as date')
            ->whereBetween('placed_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        if ($data->count() == 1) {
            $arr = [];
            $arr['total_revenue'] = 0;
            $arr['total_cancel'] = 0;
            $arr['total_order'] = 0;
            if ($data[0]->date === $endDate->format('Y-m-d')) {
                $arr['date'] = $startDate->toDate()->format('Y-m-d');
                $data->add($arr);
            }else{
                $arr['date'] = $endDate->toDate()->format('Y-m-d');
                $data->prepend($arr);
            }
        }

        return response()->json($data->toArray());
    }

    public function getDataCustomer()
    {
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth();

        // Tính toán khoảng thời gian cho tháng này
        $thisMonthStartDate = Carbon::now()->startOfMonth();
        $thisMonthEndDate = Carbon::now()->endOfMonth();

        // Lấy dữ liệu cho tháng trước
        $lastMonthData = Customer::query()
            ->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])
            ->count();

        // Lấy dữ liệu cho tháng này
        $thisMonthData = Customer::query()
            ->whereBetween('created_at', [$thisMonthStartDate, $thisMonthEndDate])
            ->count();

        // Kết hợp dữ liệu của tháng này và tháng trước
        $data = [$thisMonthData, $lastMonthData];

        return response()->json($data);
    }

    public function getDataOrderChart(Request $request): \Illuminate\Http\JsonResponse
    {
        $startDate = Carbon::now()->startOfDay()->subDay(14);
        $endDate = Carbon::now()->endOfDay();

        $allDates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $allDates[$currentDate->format('Y-m-d')] = [
                'total_revenue' => 0,
                'total_cancel' => 0,
                'total_order' => 0,
                'date' => $currentDate->format('Y-m-d'),
            ];
            $currentDate->addDay();
        }

        // Lấy dữ liệu từ cơ sở dữ liệu
        $data = Order::query()
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) as total_cancel', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('COUNT(CASE WHEN status != ? THEN 1 END) as total_order', [OrderStatusEnum::CANCELLED->value])
            ->selectRaw('DATE(placed_at) as date')
            ->whereBetween('placed_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        // Chuyển đổi dữ liệu lấy được từ cơ sở dữ liệu thành mảng với khóa là ngày
        $dataByDate = $data->keyBy('date');

        // Kết hợp dữ liệu từ cơ sở dữ liệu với danh sách tất cả các ngày
        foreach ($allDates as $key => &$values) {
            $date = $values['date'];
            $key = Carbon::createFromFormat('Y-m-d', $date)->format('d-m');
            unset($allDates[$date]);
            $allDates[$key] = $values;
            if (isset($dataByDate[$date])) {
                $values['total_revenue'] = $dataByDate[$date]->total_revenue;
                $values['total_cancel'] = $dataByDate[$date]->total_cancel;
                $values['total_order'] = $dataByDate[$date]->total_order;
            }
        }

        return response()->json($allDates);
    }

    public function getTopProductSell()
    {
        $startDate = Carbon::now()->startOfDay()->subDay(14);
        $endDate = Carbon::now()->endOfDay();

        $bestSellingProducts = DB::table('order_products')
            ->join('product_variants', 'order_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->select('products.id', 'products.name', DB::raw('SUM(order_products.quantity) as total_quantity'))
            ->whereBetween('orders.placed_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->get();
        return response()->json($bestSellingProducts->toArray());
    }
}
