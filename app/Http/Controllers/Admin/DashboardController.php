<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Charts\YearlyRevenueChart;
use App\Charts\SalesPerformanceChart;
use App\Charts\ProductShareChart;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. YEARLY REVENUE CHART (Line Chart per Year)
        $yearlyChart = new YearlyRevenueChart;
        $yearlyData = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('YEAR(orders.created_at) as year, SUM(order_items.price * order_items.quantity) as total')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->pluck('total', 'year')
            ->toArray();

        // Labels are now the years (2022, 2023, etc.)
        $yearlyChart->labels(array_keys($yearlyData));
        $yearlyChart->dataset('Yearly Revenue Trend', 'line', array_values($yearlyData))
            ->color('#d4af37')->backgroundcolor('rgba(212, 175, 55, 0.1)');

        // 2. PRODUCT SHARE CHART (PIE) - UNTOUCHED
        $productChart = new ProductShareChart;
        $productSales = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('products.name')->get();

        $productChart->labels($productSales->pluck('name')->toArray());
        $productChart->dataset('Sales Share', 'pie', $productSales->pluck('total')->toArray())
            ->backgroundcolor(['#001f3f', '#d4af37', '#1a3a5a', '#b8860b', '#004080']);

        // 3. SALES PERFORMANCE CHART (BAR) - UNTOUCHED
        $performanceChart = new SalesPerformanceChart;
        $start = $request->get('start_date', now()->subDays(7)->format('Y-m-d'));
        $end = $request->get('end_date', now()->format('Y-m-d'));

        $rangeSales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('DATE(orders.created_at) as date, SUM(order_items.price * order_items.quantity) as total')
            ->whereBetween('orders.created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->groupBy('date')->orderBy('date')->get();

        $performanceChart->labels($rangeSales->pluck('date')->toArray());
        $performanceChart->dataset('Daily Sales', 'bar', $rangeSales->pluck('total')->toArray())
            ->color('#001f3f')->backgroundcolor('#001f3f');

        return view('admin.dashboard', compact('yearlyChart', 'productChart', 'performanceChart'));
    }
}