<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $hasGuestEmail = Schema::hasColumn('orders', 'guest_email');
        $hasPaymentStatus = Schema::hasColumn('orders', 'payment_status');
        $hasIsActive = Schema::hasColumn('products', 'is_active');

        // Analytics Timeframes
        $currentStart = now()->subDays(30);
        $previousStart = now()->subDays(60);

        // Revenue
        $currentRevenue = $hasPaymentStatus 
            ? Order::where('payment_status', 'paid')->where('created_at', '>=', $currentStart)->sum('total_amount')
            : Order::where('created_at', '>=', $currentStart)->sum('total_amount');
        $previousRevenue = $hasPaymentStatus 
            ? Order::where('payment_status', 'paid')->whereBetween('created_at', [$previousStart, $currentStart])->sum('total_amount')
            : Order::whereBetween('created_at', [$previousStart, $currentStart])->sum('total_amount');
        $revenueGrowth = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;

        // Total Revenue (all time)
        $totalRevenue = $hasPaymentStatus 
            ? Order::where('payment_status', 'paid')->sum('total_amount')
            : Order::sum('total_amount');

        // Orders
        $currentOrders = Order::where('created_at', '>=', $currentStart)->count();
        $previousOrders = Order::whereBetween('created_at', [$previousStart, $currentStart])->count();
        $ordersGrowth = $previousOrders > 0 ? (($currentOrders - $previousOrders) / $previousOrders) * 100 : 0;

        // Customers
        $currentCustomers = User::where('created_at', '>=', $currentStart)->count();
        $previousCustomers = User::whereBetween('created_at', [$previousStart, $currentStart])->count();
        $customersGrowth = $previousCustomers > 0 ? (($currentCustomers - $previousCustomers) / $previousCustomers) * 100 : 0;

        $stats = [
            'total_revenue' => $totalRevenue,
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth' => round($revenueGrowth, 1),
            
            'total_orders' => Order::count(),
            'current_orders' => $currentOrders,
            'previous_orders' => $previousOrders,
            'orders_growth' => round($ordersGrowth, 1),

            'total_customers' => User::count(),
            'current_customers' => $currentCustomers,
            'previous_customers' => $previousCustomers,
            'customers_growth' => round($customersGrowth, 1),
            
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'low_stock' => Product::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
        ];

        // Low Stock Products Alert
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('items.product', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Top Products
        $topProducts = Product::select('products.*')
            ->selectSub(function ($query) {
                $query->from('order_items')
                    ->whereColumn('order_items.product_id', 'products.id')
                    ->selectRaw('COALESCE(SUM(quantity), 0)');
            }, 'sales_count')
            ->selectSub(function ($query) {
                $query->from('order_items')
                    ->whereColumn('order_items.product_id', 'products.id')
                    ->selectRaw('COALESCE(SUM(quantity * price), 0)');
            }, 'total_revenue')
            ->orderByDesc('sales_count')
            ->take(5)
            ->get();

        // Revenue Chart (Monthly for current year)
        $monthlyRevenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Sparkline Data (Last 7 days revenue)
        $sparklineData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailyTotal = Order::whereDate('created_at', $date)->sum('total_amount');
            $sparklineData[] = $dailyTotal;
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'lowStockProducts', 'chartData', 'sparklineData'));
    }

    /**
     * Display analytics page.
     */
    public function analytics()
    {
        $hasPaymentStatus = Schema::hasColumn('orders', 'payment_status');

        $salesQuery = $hasPaymentStatus
            ? Order::where('payment_status', 'paid')
            : Order::query();

        $salesByDay = $salesQuery
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(10)
            ->get();

        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.analytics', compact('salesByDay', 'topProducts', 'ordersByStatus'));
    }
}
