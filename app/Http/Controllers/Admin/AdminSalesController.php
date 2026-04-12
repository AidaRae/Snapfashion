<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminSalesController extends Controller
{
    /**
     * Display the Sales Analytics Dashboard
     */
    public function index()
    {
        // Fetch valid sales (Paid or Processing/Completed depending on business rule)
        // For simplicity, we assume paid orders or processing orders count as a "sale".
        $ordersQuery = Order::where(function ($query) {
            $query->where('payment_status', 'paid')
                  ->orWhere('status', 'completed')
                  ->orWhere('status', 'processing');
        });

        // Global KPI Metrics
        $totalRevenue = (clone $ordersQuery)->sum('total_amount');
        $totalOrders = (clone $ordersQuery)->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Chart.js Data Aggregation (Last 12 Months)
        $salesData = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            // Get boundaries for each month
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            // Sum total_amount for that month
            $monthRevenue = (clone $ordersQuery)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_amount');
                
            $labels[] = $monthStart->format('M Y');
            $salesData[] = $monthRevenue;
        }

        // Fetch recent successful orders for the history table
        $recentSales = (clone $ordersQuery)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.sales.sales', compact(
            'totalRevenue', 
            'totalOrders', 
            'averageOrderValue', 
            'labels', 
            'salesData',
            'recentSales'
        ));
    }
}
