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
        // 1. YEARLY REVENUE CHART
        $yearlyChart = new YearlyRevenueChart;
        $yearlyData = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('YEAR(orders.created_at) as year, SUM(order_items.price * order_items.quantity) as total')
            ->groupBy('year')->orderBy('year', 'asc')
            ->pluck('total', 'year')->toArray();

        $yearlyChart->labels(array_keys($yearlyData));
        $yearlyChart->dataset('Yearly Revenue', 'line', array_values($yearlyData))
            ->color('#d4af37')->backgroundcolor('rgba(212, 175, 55, 0.1)');

        // 2. PRODUCT SHARE CHART (Top 10 - No Legend)
        $productChart = new ProductShareChart;
        $productSales = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name')
            ->selectRaw('CAST(SUM(order_items.price * order_items.quantity) AS UNSIGNED) as total')
            ->groupBy('products.name')
            ->orderBy('total', 'desc')
            ->take(10) // Limit to top 10
            ->get();

        $productChart->labels($productSales->pluck('name')->toArray());
        $productChart->dataset('Sales Share', 'pie', $productSales->pluck('total')->toArray())
            ->backgroundcolor(['#001f3f', '#d4af37', '#1a3a5a', '#b8860b', '#004080', '#2c3e50', '#f1c40f', '#2980b9', '#8e44ad', '#16a085']);
        
        // Disable Legend for cleaner UI
        $productChart->options([
            'legend' => ['display' => false],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ]);

        // 3. SALES PERFORMANCE CHART (All Time)
        $performanceChart = new SalesPerformanceChart;
        $firstOrder = Order::orderBy('created_at', 'asc')->first();
        $defaultStart = $firstOrder ? $firstOrder->created_at->format('Y-m-d') : now()->subDays(30)->format('Y-m-d');

        $start = $request->get('start_date', $defaultStart);
        $end = $request->get('end_date', now()->format('Y-m-d'));

        $rangeSales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->selectRaw('DATE(orders.created_at) as date, SUM(order_items.price * order_items.quantity) as total')
            ->whereBetween('orders.created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->groupBy('date')->orderBy('date')->get();

        $performanceChart->labels($rangeSales->pluck('date')->toArray());
        $performanceChart->dataset('Daily Sales', 'bar', $rangeSales->pluck('total')->toArray())
            ->color('#001f3f')->backgroundcolor('#001f3f');
        
        $performanceChart->options([
            'legend' => ['display' => false]
        ]);

        return view('admin.dashboard', compact('yearlyChart', 'productChart', 'performanceChart'));
    }
}