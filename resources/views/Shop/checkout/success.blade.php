@extends('layouts.shop')

@section('title', 'Order Success - ')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[60vh] flex items-center justify-center">
    <div class="max-w-2xl w-full bg-gray-50 dark:bg-neutral-900 border border-bark/5 dark:border-cream/5 rounded-2xl p-8 md:p-12 text-center shadow-sm">
        
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="font-display text-3xl font-bold uppercase tracking-wider mb-2 text-bark dark:text-cream">Order Received!</h1>
        <p class="text-gray-500 mb-8 border-b border-bark/10 dark:border-cream/10 pb-8">Thank you for your purchase. Your order has been placed securely.</p>
        
        <div class="space-y-4 text-left bg-white dark:bg-neutral-800 p-6 rounded-xl border border-gray-100 dark:border-neutral-700 mb-8 mx-auto max-w-md">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-neutral-700 uppercase">
                <span class="text-[10px] font-bold text-gray-400 tracking-wider">Tracking Code</span>
                <span class="font-mono text-sm font-bold bg-gray-100 dark:bg-neutral-900 px-3 py-1 rounded text-bark dark:text-cream">{{ $order->tracking_code }}</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-neutral-700 uppercase">
                <span class="text-[10px] font-bold text-gray-400 tracking-wider">Order Status</span>
                <span class="text-xs font-bold text-sage">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-neutral-700 uppercase">
                <span class="text-[10px] font-bold text-gray-400 tracking-wider">Payment Status</span>
                <span class="text-xs font-bold @if($order->payment_status === 'paid') text-green-500 @else text-amber-500 @endif">{{ ucfirst($order->payment_status) }}</span>
            </div>
            <div class="flex justify-between items-center uppercase text-sm pt-2">
                <span class="text-[11px] font-bold text-gray-400 tracking-wider">Total Paid</span>
                <span class="font-display font-bold">₦{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
            <a href="{{ route('order.track', $order->tracking_code) }}" class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-gray-900 dark:text-white text-center font-display text-xs font-bold tracking-[0.2em] uppercase py-4 transition-colors rounded-sm">
                View Order
            </a>
            <a href="{{ route('shop.products') }}" class="flex-1 bg-bark dark:bg-cream text-cream dark:text-bark border border-bark dark:border-cream text-center font-display text-xs font-bold tracking-[0.2em] uppercase py-4 hover:bg-transparent hover:text-bark dark:hover:text-cream transition-colors rounded-sm">
                Shop More
            </a>
        </div>
    </div>
</div>
@endsection
