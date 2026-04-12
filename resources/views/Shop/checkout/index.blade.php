@extends('layouts.shop')

@section('title', 'Checkout - ')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-8 pt-20 pb-12 md:pt-28 md:pb-16 min-h-[60vh]">
    <style>
        .receipt-container {
            background-color: #fcfcfc;
            position: relative;
            padding-top: 20px;
        }
        .receipt-scallop {
            position: absolute;
            top: -12px;
            left: 0;
            right: 0;
            height: 12px;
            background-image: radial-gradient(circle at 10px 0, transparent 10px, #fcfcfc 11px);
            background-size: 20px 20px;
            background-repeat: repeat-x;
        }
        
        /* Dark mode overrides for receipt */
        .dark .receipt-container {
            background-color: #2C2218;
            border-color: rgba(196, 168, 130, 0.2) !important;
        }
        .dark .receipt-scallop {
            background-image: radial-gradient(circle at 10px 0, transparent 10px, #2C2218 11px);
        }
    </style>

    {{-- Coupon Notice --}}
    <div class="mb-10 text-[15px]">
        <span class="text-gray-900 dark:text-sand font-medium">Have a coupon?</span> 
        <a href="{{ route('cart.index') }}" class="text-brand dark:text-clay hover:text-gray-600 dark:hover:text-cream transition-colors underline decoration-2 underline-offset-2">Click here to enter your code</a>
    </div>

    @if(session('error'))
        <div class="mb-6 px-5 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Holiday / delay notice from admin --}}
    @if(!empty($holidayNotice))
        <div class="mb-6 px-5 py-3 bg-amber-50 border border-amber-200 text-amber-700 text-sm rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ $holidayNotice }}
        </div>
    @endif

    <form action="{{ route('checkout.process') ?? '#' }}" method="POST" id="checkout-form">
        @csrf
        <div class="flex flex-col lg:flex-row gap-12">
            
            {{-- Left Column: BILLING DETAILS --}}
            <div class="w-full lg:w-[60%]">
                <h2 class="font-display text-xl font-bold uppercase mb-6 text-gray-900 dark:text-cream">BILLING DETAILS</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    {{-- First Name & Last Name --}}
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">First name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" required value="{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : old('first_name') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Last name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" required value="{{ auth()->check() && count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : old('last_name') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>
                    
                    {{-- Company Name --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Company name (optional)</label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>

                    {{-- Country / Region --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Country / Region <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="country" required class="w-full appearance-none bg-transparent dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm text-gray-700 dark:text-cream cursor-pointer">
                                @if(isset($countries) && is_array($countries))
                                    @foreach($countries as $c)
                                        <option value="{{ $c }}" {{ $c === 'Nigeria' ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                @else
                                    <option value="Nigeria" selected>Nigeria</option>
                                @endif
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 dark:text-clay/60">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Street Address --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Street address <span class="text-red-500">*</span></label>
                        <input type="text" name="address" required placeholder="House number and street name" value="{{ old('address') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm mb-3 dark:text-cream" />
                        <input type="text" name="address2" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('address2') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>

                    {{-- Email & Phone --}}
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Phone <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required value="{{ old('phone') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Email address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 dark:text-sand mb-2">Order Notes (optional)</label>
                        <textarea name="notes" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."
                            class="w-full bg-white dark:bg-[#1A1410] border border-gray-300 dark:border-clay/30 px-4 py-3 text-sm focus:outline-none focus:border-gray-500 dark:focus:border-clay focus:ring-0 rounded-sm dark:text-cream">{{ old('notes') }}</textarea>
                    </div>
                </div>
                
            </div>

            {{-- Right Column: YOUR ORDER --}}
            <div class="w-full lg:w-[45%] xl:w-[40%]">
                <div class="receipt-container p-8 sm:p-10 shadow-sm border border-gray-100/50">
                    <div class="receipt-scallop"></div>
                    <h2 class="font-display text-xl font-medium uppercase text-center mb-6 text-gray-900 dark:text-cream">YOUR ORDER</h2>

                    <div class="w-full flex justify-between uppercase text-xs font-bold tracking-wider border-b border-gray-200 dark:border-clay/20 pb-3 mb-4 text-gray-800 dark:text-sand">
                        <span>Product</span>
                        <span>Subtotal</span>
                    </div>

                    {{-- Cart Items --}}
                    <div class="space-y-4 mb-4 pb-4 border-b border-gray-200 dark:border-clay/20">
                        @if(isset($cart) && count($cart) > 0)
                            @foreach($cart as $id => $item)
                                <div class="flex justify-between items-center text-sm">
                                    <div class="text-gray-600 dark:text-sand">
                                        {{ $item['name'] }} <strong class="text-gray-900 dark:text-cream font-bold ml-1">× {{ $item['quantity'] }}</strong>
                                        @if(isset($item['size']))
                                            <span class="text-xs text-gray-400 dark:text-clay/60 block uppercase">{{ $item['size'] }}</span>
                                        @endif
                                    </div>
                                    <div class="text-gray-600 dark:text-sand font-medium whitespace-nowrap">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- Subtotal --}}
                    <div class="flex justify-between items-center text-[15px] font-bold pb-4 mb-4 text-gray-900 dark:text-cream">
                        <span>Subtotal</span>
                        <span class="text-gray-900 dark:text-cream font-medium">₦{{ number_format($subtotal ?? 0, 2) }}</span>
                    </div>
                    
                    @if(isset($discount) && $discount > 0)
                        <div class="flex justify-between items-center text-sm font-bold border-b border-gray-200 dark:border-clay/20 pb-4 mb-4 text-gray-900 dark:text-cream">
                            <span>Discount</span>
                            <span class="text-sage font-medium">- ₦{{ number_format($discount, 2) }}</span>
                        </div>
                    @endif

                    {{-- Shipping Options based on design --}}
                    <div class="mb-6 pt-2 border-t border-dotted border-gray-300 dark:border-clay/30">
                        <div class="flex flex-col items-start mt-4 space-y-4 w-full" id="shippingOptionsContainer">
                            @if(isset($shippingEnabled) && !$shippingEnabled)
                                <div class="w-full text-center py-2">
                                    <span class="text-[14.5px] text-gray-600 dark:text-sand">Shipping is automatically free for this order.</span>
                                </div>
                                <input type="hidden" name="state" value="Free Shipping" data-rate="0" class="shipping-radio">
                            @else
                                {{-- Free Shipping Logic --}}
                                @if($qualifiesForFreeShipping)
                                    <label class="flex justify-start items-start gap-3 cursor-pointer group">
                                        <input type="radio" name="state" value="Free Shipping" data-rate="0" class="shipping-radio w-4 h-4 text-gray-900 focus:ring-gray-900 dark:text-clay dark:focus:ring-clay mt-0.5" {{ (isset($freeShippingEnabled) && $freeShippingEnabled) || (count($stateZoneMap) == 0) ? 'checked' : '' }} required>
                                        <span class="text-[14.5px] text-gray-600 dark:text-sand flex-1">Free Shipping <span class="text-sage font-medium ml-1">₦0.00</span></span>
                                    </label>
                                @endif

                                {{-- Admin Zones mapped as Radio buttons --}}
                                @php
                                    $allZones = [];
                                @endphp
                                @foreach($stateZoneMap as $state => $zoneMeta)
                                    @php
                                        // deduplicate zones based on rate and names
                                        $zoneKey = ($zoneMeta['zone'] ?? '') . '_' . $zoneMeta['rate'];
                                        if(!isset($allZones[$zoneKey])) {
                                            $allZones[$zoneKey] = [
                                                'label' => $state,
                                                'value' => $state,
                                                'rate' => $zoneMeta['rate'],
                                                'days' => $zoneMeta['days']
                                            ];
                                        } else {
                                            // Append this state name if it's uniquely typed
                                            if(!str_contains($allZones[$zoneKey]['label'], $state)) {
                                                $allZones[$zoneKey]['label'] .= ', ' . $state;
                                            }
                                        }
                                    @endphp
                                @endforeach

                                @foreach($allZones as $zone)
                                    <label class="flex justify-start items-start gap-3 cursor-pointer group w-full">
                                        <input type="radio" name="state" value="{{ $zone['value'] }}" data-rate="{{ $zone['rate'] }}" class="shipping-radio w-4 h-4 text-gray-900 focus:ring-gray-900 dark:text-clay dark:focus:ring-clay mt-0.5 flex-shrink-0" {{ (count($allZones) == 1) ? 'checked' : '' }} required>
                                        <span class="text-[14.5px] text-gray-800 dark:text-sand leading-tight max-w-[90%]">{{ $zone['label'] }}: <span class="text-gray-900 dark:text-cream font-medium ml-1">₦{{ number_format($zone['rate'], 2) }}</span></span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="flex justify-between items-center text-gray-900 dark:text-cream border-t border-gray-200 dark:border-clay/20 pt-5 mb-8 mt-2">
                        <span class="font-bold uppercase tracking-wider text-[16px]">Total</span>
                        <span id="orderTotal" class="font-display text-[24px] font-bold text-gray-900 dark:text-cream">₦{{ number_format($total ?? 0, 2) }}</span>
                    </div>

                    {{-- Action Button --}}
                    <button type="submit" class="w-full btn-primary font-display text-sm font-bold tracking-[0.1em] uppercase py-4 transition-colors flex items-center justify-center gap-2">
                        PLACE ORDER
                    </button>
                    
                    <p class="text-center text-xs text-gray-500 dark:text-clay/60 mt-4 tracking-wide font-medium">Your personal data will be used to process your order safely.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const qualifiesForFreeShipping = @json($qualifiesForFreeShipping);
    const baseSubtotal = {{ $subtotal ?? 0 }};
    const discountAmount = {{ $discount ?? 0 }};
    
    function fmt(n) {
        return '₦' + Number(n).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Attach event listeners to all shipping radio buttons
    const shippingRadios = document.querySelectorAll('.shipping-radio');
    const orderTotalDisplay = document.getElementById('orderTotal');

    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Get the rate from the selected radio button
            const rate = parseFloat(this.getAttribute('data-rate')) || 0;
            
            // Calculate new total
            const newTotal = baseSubtotal - discountAmount + rate;
            
            // Update UI
            orderTotalDisplay.textContent = fmt(Math.max(0, newTotal));
        });
    });
    
    // Trigger recalculation on load if any radio is pre-selected
    const checkedRadio = document.querySelector('.shipping-radio:checked');
    if(checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
</script>
@endsection
