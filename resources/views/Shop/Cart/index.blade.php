@extends('layouts.shop')

@section('title', 'Your Cart - ')

@section('content')
    <div class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[60vh]">
        <div class="mb-10">
            <div class="text-sm text-gray-500 font-medium tracking-wide uppercase mb-6">
                <a href="{{ route('shop.home') }}" class="hover:text-bark dark:hover:text-cream transition-colors">Home</a> &raquo;
                <span class="text-gray-900 dark:text-white">Shopping Cart</span>
            </div>
            <h1 class="font-display text-4xl mb-3 text-bark dark:text-cream">Your Cart</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 px-5 py-3 bg-sage/20 border border-sage/30 text-bark dark:text-cream text-sm rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 px-5 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-12">

                {{-- Cart Items Table --}}
                <div class="w-full lg:w-2/3">
                    {{-- Desktop Table --}}
                    <div class="hidden md:block">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-bark/10 dark:border-cream/10">
                                    <th class="text-left font-display text-xs font-bold tracking-[0.2em] uppercase text-gray-500 dark:text-gray-400 pb-4 pl-2">Product</th>
                                    <th class="text-center font-display text-xs font-bold tracking-[0.2em] uppercase text-gray-500 dark:text-gray-400 pb-4">Price</th>
                                    <th class="text-center font-display text-xs font-bold tracking-[0.2em] uppercase text-gray-500 dark:text-gray-400 pb-4">Quantity</th>
                                    <th class="text-right font-display text-xs font-bold tracking-[0.2em] uppercase text-gray-500 dark:text-gray-400 pb-4 pr-2">Subtotal</th>
                                    <th class="w-12 pb-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr class="border-b border-bark/5 dark:border-cream/5 group">
                                        {{-- Product --}}
                                        <td class="py-6 pl-2">
                                            <div class="flex items-center gap-5">
                                                <a href="{{ route('shop.product.show', $item['slug']) }}" class="flex-shrink-0">
                                                    @if($item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-24 object-cover rounded-lg shadow-sm" />
                                                    @else
                                                        <div class="w-20 h-24 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center text-gray-400">
                                                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        </div>
                                                    @endif
                                                </a>
                                                <div>
                                                    <a href="{{ route('shop.product.show', $item['slug']) }}" class="font-display text-sm font-bold uppercase tracking-wide hover:text-rust transition-colors">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Price --}}
                                        <td class="text-center text-sm font-medium py-6">₦{{ number_format($item['price'], 2) }}</td>

                                        {{-- Quantity --}}
                                        <td class="py-6">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center justify-center">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-gray-200 dark:border-neutral-700 rounded-sm">
                                                    <button type="button" class="px-3 py-2 text-sm opacity-50 hover:opacity-100 transition-opacity" onclick="changeCartQty(this, -1)">−</button>
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100"
                                                        class="w-10 text-center border-x border-gray-200 dark:border-neutral-700 bg-transparent py-2 text-sm focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                        onchange="this.form.submit()" />
                                                    <button type="button" class="px-3 py-2 text-sm opacity-50 hover:opacity-100 transition-opacity" onclick="changeCartQty(this, 1)">+</button>
                                                </div>
                                            </form>
                                        </td>

                                        {{-- Subtotal --}}
                                        <td class="text-right text-sm font-semibold py-6 pr-2">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</td>

                                        {{-- Remove --}}
                                        <td class="py-6 text-center">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-300 hover:text-red-500 dark:text-neutral-600 dark:hover:text-red-400 transition-colors opacity-0 group-hover:opacity-100" title="Remove">
                                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden space-y-4">
                        @foreach($cart as $id => $item)
                            <div class="flex gap-4 p-4 border border-bark/5 dark:border-cream/5 rounded-xl">
                                <a href="{{ route('shop.product.show', $item['slug']) }}" class="flex-shrink-0">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-24 object-cover rounded-lg" />
                                    @else
                                        <div class="w-20 h-24 bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                    @endif
                                </a>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('shop.product.show', $item['slug']) }}" class="font-display text-sm font-bold uppercase tracking-wide hover:text-rust transition-colors line-clamp-2">{{ $item['name'] }}</a>
                                    <p class="text-sm opacity-70 mt-1">₦{{ number_format($item['price'], 2) }}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-gray-200 dark:border-neutral-700 rounded-sm text-xs">
                                                <button type="button" class="px-2.5 py-1.5 opacity-50 hover:opacity-100" onclick="changeCartQty(this, -1)">−</button>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100"
                                                    class="w-8 text-center border-x border-gray-200 dark:border-neutral-700 bg-transparent py-1.5 text-xs focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                    onchange="this.form.submit()" />
                                                <button type="button" class="px-2.5 py-1.5 opacity-50 hover:opacity-100" onclick="changeCartQty(this, 1)">+</button>
                                            </div>
                                        </form>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors text-xs">Remove</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-sm font-semibold flex-shrink-0 pt-1">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Cart Actions --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mt-8 pt-6 border-t border-bark/5 dark:border-cream/5">
                        <a href="{{ route('shop.products') }}" class="flex items-center gap-2 text-sm font-display font-medium tracking-wider uppercase opacity-60 hover:opacity-100 transition-opacity">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                            Continue Shopping
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-display font-medium tracking-wider uppercase text-red-500 hover:text-red-600 transition-colors">Clear Cart</button>
                        </form>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-50 dark:bg-neutral-900 border border-bark/5 dark:border-cream/5 rounded-2xl p-8 sticky top-28">
                        <h2 class="font-display text-xl font-bold uppercase tracking-wider mb-6 pb-4 border-b border-bark/10 dark:border-cream/10">Order Summary</h2>

                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between">
                                <span class="opacity-60">Subtotal</span>
                                <span class="font-medium">₦{{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($discount > 0)
                                <div class="flex justify-between text-sage">
                                    <span>Discount ({{ $coupon['code'] }})</span>
                                    <span>-₦{{ number_format($discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-sm opacity-60">
                                <span>Shipping</span>
                                @if(!$shippingEnabled || (isset($freeShippingEnabled) && $freeShippingEnabled))
                                    <span class="text-sage font-medium">Free</span>
                                @elseif($flatRateEnabled)
                                    <span class="font-medium">+₦{{ number_format($flatRatePrice, 2) }}</span>
                                @else
                                    <span>Calculated at checkout</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between items-baseline pt-4 border-t border-bark/10 dark:border-cream/10 mb-6">
                            <span class="font-display text-lg font-bold uppercase tracking-wider">Total</span>
                            <span class="font-display text-2xl font-bold">₦{{ number_format($total, 2) }}</span>
                        </div>

                        {{-- Coupon --}}
                        <form action="{{ route('cart.coupon') }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex gap-2">
                                <input type="text" name="coupon_code" placeholder="Coupon code"
                                    value="{{ $coupon['code'] ?? '' }}"
                                    class="flex-1 bg-transparent border border-gray-200 dark:border-neutral-700 px-4 py-2.5 text-sm font-display tracking-wider uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-sm" />
                                <button type="submit" class="bg-bark dark:bg-cream text-cream dark:text-bark px-5 py-2.5 text-xs font-display font-bold tracking-widest uppercase hover:opacity-80 transition-opacity rounded-sm">Apply</button>
                            </div>
                        </form>

                        {{-- Checkout --}}
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-bark dark:bg-cream text-cream dark:text-bark text-center font-display text-sm font-bold tracking-[0.2em] uppercase py-4 hover:opacity-80 transition-opacity rounded-sm">
                            Proceed to Checkout
                        </a>

                        {{-- Trust Badges --}}
                        <div class="flex items-center justify-center gap-4 mt-6 pt-4 border-t border-bark/5 dark:border-cream/5">
                            <div class="flex items-center gap-1.5 text-[10px] tracking-wider uppercase opacity-40">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                Secure
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] tracking-wider uppercase opacity-40">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                Protected
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty Cart --}}
            <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                <div class="w-20 h-20 mb-6 bg-gray-50 dark:bg-neutral-800 rounded-full flex items-center justify-center text-gray-400">
                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-display font-medium text-bark dark:text-cream mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop.products') }}" class="btn-primary rounded-full px-8 py-3 text-sm font-medium tracking-wide">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <script>
        function changeCartQty(btn, delta) {
            const form = btn.closest('form');
            const input = form.querySelector('input[name="quantity"]');
            let val = parseInt(input.value || '1') + delta;
            const max = parseInt(input.getAttribute('max')) || 100;
            const min = parseInt(input.getAttribute('min')) || 1;
            if (val < min) val = min;
            if (val > max) val = max;
            input.value = val;
            form.submit();
        }
    </script>
@endsection
