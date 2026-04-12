<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Mail\OrderStatusUpdatedMail;
use App\Services\OrderMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    /**
     * Display order listing.
     */
    public function index(Request $request)
    {
        $query = Order::with('items.product');

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        // Search by tracking code, guest name, guest email, or order ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'LIKE', "%{$search}%")
                  ->orWhere('guest_name', 'LIKE', "%{$search}%")
                  ->orWhere('guest_email', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.order.order', compact('orders'));
    }

    /**
     * Show form to add a new order.
     */
    public function create()
    {
        return view('admin.order.add_order');
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer'        => 'nullable|string|max:255',
            'shipping_address'=> 'nullable|string',
            'quantity'        => 'nullable|integer|min:1',
            'amount'          => 'nullable|numeric|min:0',
            'payment_method'  => 'required|string',
            'payment_status'  => 'required|string',
            'status'          => 'required|string',
        ]);

        $order = Order::create([
            'guest_name'       => $validated['customer'] ?? null,
            'guest_email'      => $validated['customer'] ?? null,
            'shipping_address' => $validated['shipping_address'] ?? '',
            'total_amount'     => $validated['amount'] ?? 0,
            'subtotal'         => $validated['amount'] ?? 0,
            'payment_method'   => $validated['payment_method'],
            'payment_status'   => $validated['payment_status'],
            'status'           => $validated['status'],
        ]);

        return redirect()->route('admin.orders')->with('success', 'Order #' . ($order->id + 100) . ' created successfully.');
    }

    /**
     * Display order details.
     */
    public function details($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.order.order_detail', compact('order'));
    }

    /**
     * Show form to edit an existing order.
     */
    public function edit($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.order.edit_order', compact('order'));
    }

    /**
     * Update an existing order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status'          => 'required|string',
            'payment_status'  => 'required|string',
            'payment_method'  => 'nullable|string',
            'grand_total'     => 'nullable|numeric|min:0',
            'customer'        => 'nullable|string',
            'shipping_address'=> 'nullable|string',
        ]);

        $oldStatus = $order->status;

        $order->update([
            'status'           => $validated['status'],
            'payment_status'   => $validated['payment_status'],
            'payment_method'   => $validated['payment_method'] ?? $order->payment_method,
            'total_amount'     => $validated['grand_total'] ?? $order->total_amount,
            'guest_email'      => $validated['customer'] ?? $order->guest_email,
            'shipping_address' => $validated['shipping_address'] ?? $order->shipping_address,
        ]);

        // Send status update email if status changed (service handles toggle + error handling)
        if ($oldStatus !== $validated['status']) {
            OrderMailService::sendStatusUpdate($order);
        }

        return redirect()->route('admin.orders')->with('success', 'Order #' . ($order->id + 100) . ' updated successfully.');
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
    }

    /**
     * Generate invoice for the order.
     */
    public function invoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.order.invoice', compact('order'));
    }
}
