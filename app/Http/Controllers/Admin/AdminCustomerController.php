<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of unique guest customers (aggregated from orders).
     */
    public function index(Request $request)
    {
        $query = Order::whereNotNull('guest_email')
            ->select(
                'guest_email',
                DB::raw('MAX(guest_name) as guest_name'),
                DB::raw('MAX(guest_phone) as guest_phone'),
                DB::raw('MAX(shipping_address) as shipping_address'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_spent'),
                DB::raw('MAX(created_at) as last_order_at')
            )
            ->groupBy('guest_email');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'LIKE', "%{$search}%")
                  ->orWhere('guest_email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->orderByDesc('last_order_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.customer.customer', compact('customers'));
    }

    /**
     * Display all orders from a specific guest email.
     */
    public function show(string $email)
    {
        $orders = Order::where('guest_email', $email)
            ->with('items.product')
            ->latest()
            ->paginate(15);

        $customerName = $orders->first()?->guest_name ?? $email;

        return view('admin.customer.customer_show', compact('orders', 'email', 'customerName'));
    }
}
