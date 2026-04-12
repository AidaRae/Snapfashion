@extends('layouts.shop')

@section('title', 'View Order ' . $order->tracking_code . ' - ')

@section('content')
    <div class="max-w-4xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[70vh]">

        <div class="mb-10 text-center">
            <h1 class="font-display text-3xl font-bold uppercase tracking-wider mb-2 text-bark dark:text-cream">View Your
                Order</h1>
            <p class="text-sm text-gray-500 font-medium tracking-wide">
                Order: <span
                    class="font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-neutral-800 px-2 py-1 rounded">{{ $order->tracking_code }}</span>
                | Placed on: {{ $order->created_at->format('M d, Y') }}
            </p>
        </div>

        {{-- Order Status Display --}}
        <div
            class="bg-white dark:bg-neutral-900 p-8 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm mb-8">

            <div class="flex flex-col md:flex-row gap-6 mb-8 pb-8 border-b border-gray-100 dark:border-neutral-800">
                <div class="flex-1">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Order Status</span>
                    @php
                        $statusColors = [
                            'pending' => 'text-amber-500 bg-amber-50 dark:bg-amber-900/20',
                            'processing' => 'text-sky-500 bg-sky-50 dark:bg-sky-900/20',
                            'shipped' => 'text-blue-500 bg-blue-50 dark:bg-blue-900/20',
                            'delivered' => 'text-green-500 bg-green-50 dark:bg-green-900/20',
                            'cancelled' => 'text-red-500 bg-red-50 dark:bg-red-900/20',
                        ];
                        $colorClass = $statusColors[$order->status] ?? 'text-gray-500 bg-gray-50';
                    @endphp
                    <span
                        class="inline-flex items-center px-3 py-1 rounded text-xs font-bold uppercase tracking-wide {{ $colorClass }}">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="flex-1">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Payment
                        Status</span>
                    @php
                        $paymentColors = [
                            'pending' => 'text-amber-500',
                            'paid' => 'text-green-500',
                            'failed' => 'text-red-500',
                        ];
                        $pColorClass = $paymentColors[$order->payment_status] ?? 'text-gray-500';
                    @endphp
                    <span class="text-sm font-bold uppercase tracking-wide {{ $pColorClass }}">
                        {{ $order->payment_status }}
                    </span>
                    <span
                        class="text-xs text-gray-500 display-block ml-2">({{ ucfirst(str_replace('_', ' ', $order->payment_method)) }})</span>
                </div>

                <div class="flex-1">
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total
                        Amount</span>
                    <span class="font-display text-xl font-bold">₦{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Delivery Details --}}
                <div>
                    <h3
                        class="font-display mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-400 border-b border-gray-100 dark:border-neutral-800 pb-2">
                        Delivery Details</h3>
                    <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                        <div>
                            <span class="font-semibold block text-gray-900 dark:text-white">{{ $order->guest_name }}</span>
                            <span>{{ $order->guest_email }}</span><br>
                            <span>{{ $order->guest_phone }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs mb-1">Shipping Address:</span>
                            <p class="leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>
                        @if ($order->notes)
                            <div
                                class="bg-amber-50 dark:bg-amber-900/10 p-3 rounded border border-amber-100 dark:border-amber-900/20">
                                <span
                                    class="block text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider mb-1">Order
                                    Notes</span>
                                <p class="text-xs text-amber-800 dark:text-amber-200">{{ $order->notes }}</p>
                            </div>
                        @endif

                        @if($order->payment_receipt)
                            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-neutral-800">
                                <span class="block text-gray-500 text-xs mb-2">Payment Receipt Uploaded:</span>
                                @if(str_ends_with(strtolower($order->payment_receipt), '.pdf'))
                                    <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-600 hover:underline font-medium bg-gray-50 dark:bg-neutral-800 py-2 px-3 rounded-md border border-gray-100 dark:border-neutral-700 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        View PDF Receipt
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="block overflow-hidden rounded-md border border-gray-200 dark:border-neutral-700 hover:opacity-90 transition bg-gray-50 dark:bg-neutral-800 p-1.5 relative group cursor-zoom-in w-full max-w-[200px]">
                                        <img src="{{ asset('storage/' . $order->payment_receipt) }}" alt="Payment Receipt" class="w-full h-auto object-cover max-h-32 rounded">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded">
                                            <span class="text-white text-[10px] font-semibold px-2 py-1 bg-black/50 rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Enlarge
                                            </span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Order Items Summary --}}
                <div>
                    <h3
                        class="font-display mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-400 border-b border-gray-100 dark:border-neutral-800 pb-2">
                        Items Included</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 bg-gray-100 dark:bg-neutral-800 rounded relative flex-shrink-0">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded" />
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-xs font-bold uppercase tracking-wide truncate text-gray-900 dark:text-white">
                                        {{ $item->product ? $item->product->name : 'Item' }}</h4>
                                    <div class="text-[11px] text-gray-500 mt-0.5">
                                        Qty: {{ $item->quantity }} &times; ₦{{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                                <div class="text-xs font-bold flex-shrink-0">
                                    ₦{{ number_format($item->price * $item->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Fee Summary --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-neutral-800 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span>₦{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if ($order->shipping_fee > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Shipping</span>
                                <span>₦{{ number_format($order->shipping_fee, 2) }}</span>
                            </div>
                        @endif
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between text-sage">
                                <span>Discount</span>
                                <span>-₦{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        <div class="text-center mt-8">
            <a href="{{ route('shop.products') }}"
                class="inline-block bg-transparent text-bark dark:text-cream border border-bark dark:border-cream font-display text-xs font-bold tracking-[0.2em] uppercase py-3 px-8 hover:bg-bark dark:hover:bg-cream hover:text-white dark:hover:text-bark transition-colors rounded-sm">
                Continue Shopping
            </a>
        </div>

    </div>
@endsection
