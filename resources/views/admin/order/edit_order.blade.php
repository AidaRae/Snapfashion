@extends('layouts.admin')

@push('title', 'Edit Order')

@section('admin')
<style>
    .s-card { background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; box-shadow: 0 1px 8px rgba(0,0,0,0.02); }
    .dark .s-card { background: #262626; border-color: #404040; }
    
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .dark .form-label { color: #d1d5db; }
    
    .form-input { width: 100%; background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; font-size: 14px; color: #1f2937; transition: all 0.2s; outline: none; }
    .form-input:focus { border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59, 130, 246,0.1); }
    .dark .form-input { background: rgba(0,0,0,0.2); border-color: #374151; color: #f3f4f6; }
    .dark .form-input:focus { border-color: #3b82f6; background: rgba(0,0,0,0.4); }
    
    .btn-primary-custom { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; color: #fff; background: #3b82f6; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-primary-custom:hover { background: #3b82f6; }
    
    .btn-outline-custom { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; color: #4b5563; background: transparent; border: 1.5px solid #d1d5db; cursor: pointer; transition: all 0.2s; }
    .btn-outline-custom:hover { background: #f3f4f6; color: #111827; }
    .dark .btn-outline-custom { color: #d1d5db; border-color: #4b5563; }
</style>

<div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
        <a href="{{ route('admin.dashboard') ?? '#' }}" class="hover:text-brand transition-colors">Dashboard</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <a href="{{ route('admin.orders') ?? '#' }}" class="hover:text-brand transition-colors">Orders</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <span class="text-gray-600 dark:text-gray-300 font-medium">Edit Order</span>
    </div>

    <div class="s-card max-w-4xl mx-auto">
        <div class="p-5 sm:p-8 border-b border-gray-100 dark:border-neutral-800 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Order #{{ ($order->id ?? 0) + 100 }}</h2>
                <p class="text-sm text-gray-500 mt-1">Modify order details or update the delivery status.</p>
            </div>
            <a href="{{ route('admin.order.details', $order->id ?? 0) ?? '#' }}" class="btn-outline-custom">View Full Details</a>
        </div>

        <form action="{{ route('admin.order.update', $order->id ?? 0) ?? '#' }}" method="POST" class="p-5 sm:p-8 space-y-8">
            @csrf

            {{-- Status Update (Primary use case for order edit) --}}
            <div class="bg-gray-50 dark:bg-neutral-800/50 p-6 rounded-xl border border-gray-100 dark:border-neutral-800">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Update Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Order Stage</label>
                        <select name="status" class="form-input">
                            @if(class_exists('\App\Models\Order_status'))
                                @foreach (\App\Models\Order_status::orderBy('name', 'asc')->get() as $status)
                                    <option value="{{ $status->identifier }}" @if (($order->status ?? 'pending') == $status->identifier) selected @endif>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-input">
                            <option value="unpaid" {{ ($order->payment_status ?? 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ ($order->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ ($order->payment_status ?? '') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Customer Selection (Optional modification) --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-100 dark:border-neutral-800 pb-2">Customer & Shipping Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Customer Email or Phone</label>
                        <input type="text" name="customer" value="{{ $order->customer->email ?? '' }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Shipping Address</label>
                        <textarea name="shipping_address" class="form-input" rows="2">{{ $order->shipping_address ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Order Specifics --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-100 dark:border-neutral-800 pb-2">Order Specifics</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="form-label">Total Amount</label>
                        <input type="number" step="0.01" name="grand_total" value="{{ $order->grand_total ?? '' }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-input">
                            <option value="Cash on Delivery" {{ ($order->payment_method ?? '') == 'Cash on Delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                            <option value="Stripe" {{ ($order->payment_method ?? '') == 'Stripe' ? 'selected' : '' }}>Stripe</option>
                            <option value="PayPal" {{ ($order->payment_method ?? '') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-neutral-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.orders') ?? '#' }}" class="btn-outline-custom">Discard Changes</a>
                <button type="submit" class="btn-primary-custom">Save Updates</button>
            </div>
        </form>
    </div>
</div>
@endsection
