<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    public function getRevenue(Request $request)
    {
        if ($request->input('start_date') && $request->input('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
        } else {
            $startDate = Carbon::now()->startOfDay()->toDateTimeString();
            $endDate = Carbon::now()->endOfDay()->toDateTimeString();
        }
        // Lấy tổng doanh thu trong khoảng thời gian
        $totalRevenue = Order::query()->whereBetween('placed_at', [$startDate, $endDate])
            ->sum('total');

        // Lấy doanh thu theo ngày trong khoảng thời gian
        $dailyRevenue = Order::query()->whereBetween('placed_at', [$startDate, $endDate])
            ->selectRaw('DATE(placed_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'total_revenue' => $totalRevenue,
            'daily_revenue' => $dailyRevenue,
        ]);
    }

    public function getSumOrders(Request $request)
    {
        if ($request->input('start_date') && $request->input('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
        } else {
            $startDate = Carbon::now()->startOfDay()->toDateTimeString();
            $endDate = Carbon::now()->endOfDay()->toDateTimeString();
        }

        $sumOrders = Order::query()->whereBetween('placed_at', [$startDate, $endDate])
            ->count();
        //status = 6 =>cancelled
        $sumCancelOrders = Order::query()->whereBetween('placed_at', [$startDate, $endDate])
            ->where('status', 6)
            ->count();

        return response()->json([
            'orders' => $sumOrders,
            'cancel_orders' => $sumCancelOrders,
        ]);
    }
}
