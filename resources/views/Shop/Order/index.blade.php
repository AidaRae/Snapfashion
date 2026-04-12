@extends('layouts.shop')

@section('title', 'Pay for Order - ')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[60vh]">
    <div class="mb-10">
        <h1 class="font-display text-4xl mb-3 text-bark dark:text-cream">Order Payment</h1>
        <div class="text-sm text-gray-500 font-medium tracking-wide pb-2 border-b border-bark/10 dark:border-cream/10">
            Order ID: <span class="text-bark dark:text-cream font-bold">{{ $order->id }}</span> |
            Tracking Code: <span class="text-bark dark:text-cream font-bold">{{ $order->tracking_code }}</span>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 px-5 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-sm rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('order.pay.process', $order->tracking_code) }}" method="POST" id="payment-form" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col lg:flex-row gap-12">
            
            {{-- Left Column: Order Info & Payment Methods --}}
            <div class="w-full lg:w-2/3">
                
                {{-- Customer Info Snapshot --}}
                <div class="mb-10 pb-10 border-b border-bark/10 dark:border-cream/10">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wider mb-6">Delivery Details</h2>
                    <div class="bg-gray-50 dark:bg-neutral-800/50 p-6 rounded-xl border border-gray-100 dark:border-neutral-700 text-sm space-y-3">
                        <div class="flex">
                            <span class="w-24 text-gray-400 uppercase tracking-wide text-xs font-bold">Contact</span>
                            <span class="text-gray-900 dark:text-gray-200 flex-1">{{ $order->guest_name }} ({{ $order->guest_email }} / {{ $order->guest_phone }})</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 text-gray-400 uppercase tracking-wide text-xs font-bold">Ship To</span>
                            <span class="text-gray-900 dark:text-gray-200 flex-1">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Method Selection --}}
                <div class="mb-10">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wider mb-6">Select Payment Method</h2>
                    
                    <div class="space-y-4">
                        @if($enablePaystack)
                        <label class="flex items-center gap-4 p-4 border border-bark/20 dark:border-cream/20 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors group">
                            <input type="radio" name="payment_method" value="paystack" class="w-5 h-5 text-bark dark:text-cream border-gray-300 focus:ring-bark dark:focus:ring-cream" required>
                            <div class="flex-1">
                                <span class="block font-bold text-sm tracking-wide text-gray-900 dark:text-white mb-1">Card / Bank Transfer</span>
                                <span class="block text-xs text-gray-500">Pay securely via Paystack.</span>
                            </div>
                            <img src="https://paystack.com/assets/payment/img/paystack-badge-cards.png" alt="Paystack" class="h-6 object-contain hidden sm:block opacity-70 group-hover:opacity-100 transition-opacity">
                        </label>
                        @endif

                        @if($enableFlutterwave)
                        <label class="flex items-center gap-4 p-4 border border-bark/20 dark:border-cream/20 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors group">
                            <input type="radio" name="payment_method" value="flutterwave" class="w-5 h-5 text-bark dark:text-cream border-gray-300 focus:ring-bark dark:focus:ring-cream" required>
                            <div class="flex-1">
                                <span class="block font-bold text-sm tracking-wide text-gray-900 dark:text-white mb-1">Card / Bank / USSD</span>
                                <span class="block text-xs text-gray-500">Pay securely via Flutterwave.</span>
                            </div>
                            <svg class="h-6 w-auto hidden sm:block opacity-70 group-hover:opacity-100 transition-opacity" viewBox="0 0 120 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="120" height="30" rx="4" fill="#F5A623" fill-opacity="0.12"/>
                                <text x="60" y="19" font-family="sans-serif" font-size="11" font-weight="700" fill="#F5A623" text-anchor="middle" letter-spacing="0.5">FLUTTERWAVE</text>
                            </svg>
                        </label>
                        @endif

                        @if($enableCOD)
                        <label class="flex items-center gap-4 p-4 border border-gray-200 dark:border-neutral-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="payment_method" value="pod" class="w-5 h-5 text-bark dark:text-cream border-gray-300 focus:ring-bark dark:focus:ring-cream" required>
                            <div class="flex-1">
                                <span class="block font-bold text-sm tracking-wide text-gray-900 dark:text-white mb-1">Pay on Delivery</span>
                                <span class="block text-xs text-gray-500">Pay with cash upon delivery.</span>
                            </div>
                        </label>
                        @endif

                        @if($enableBankTransfer)
                        <label class="flex items-center gap-4 p-4 border border-gray-200 dark:border-neutral-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-bark dark:text-cream border-gray-300 focus:ring-bark dark:focus:ring-cream" required>
                            <div class="flex-1">
                                <span class="block font-bold text-sm tracking-wide text-gray-900 dark:text-white mb-1">Direct Bank Transfer</span>
                                <span class="block text-xs text-gray-500 mb-2">Transfer directly to our account.</span>
                                    
                                    @if(!empty($paymentSettings['bank_name']) && !empty($paymentSettings['bank_account_number']))
                                        <div class="mt-3 bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-700 rounded-xl overflow-hidden shadow-[0_2px_10px_rgba(0,0,0,0.02)] dark:shadow-[0_2px_10px_rgba(0,0,0,0.2)]">
                                            <div class="bg-gray-50/80 dark:bg-neutral-800/80 px-4 py-3 border-b border-gray-100 dark:border-neutral-700/80">
                                                <span class="block text-[10px] uppercase text-gray-400 dark:text-gray-500 mb-0.5 tracking-wider font-bold">Bank</span>
                                                <span class="block text-sm font-extrabold text-gray-900 dark:text-white tracking-wide">{{ $paymentSettings['bank_name'] }}</span>
                                            </div>
                                            <div class="p-4 space-y-4">
                                                <div>
                                                    <span class="block text-[10px] uppercase text-gray-400 dark:text-gray-500 mb-1.5 tracking-wider font-bold">Account Number</span>
                                                    <div class="flex items-center justify-between bg-gray-50 dark:bg-neutral-800 rounded-lg p-2.5 border border-gray-100 dark:border-neutral-700">
                                                        <span class="font-mono text-[15px] font-bold text-gray-900 dark:text-white tracking-widest" id="bank-account-num">{{ $paymentSettings['bank_account_number'] }}</span>
                                                        <button type="button" onclick="copyAccount(event)" class="text-gray-400 hover:text-bark dark:hover:text-cream transition-colors p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-neutral-700" title="Copy Number">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="block text-[10px] uppercase text-gray-400 dark:text-gray-500 mb-1 tracking-wider font-bold">Account Name</span>
                                                    <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">{{ !empty($paymentSettings['bank_account_name']) ? $paymentSettings['bank_account_name'] : config('app.name') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-3 flex items-start gap-2.5 text-[11.5px] text-gray-600 dark:text-gray-300 bg-amber-50/80 dark:bg-amber-900/10 p-3 rounded-lg border border-amber-100 dark:border-amber-900/30">
                                        <svg class="w-4 h-4 flex-shrink-0 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="leading-relaxed">Please use Tracking Code <strong class="font-mono font-bold text-amber-700 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/50 px-1.5 py-0.5 rounded text-xs mx-0.5">{{ $order->tracking_code }}</strong> as your payment reference.</span>
                                    </div>

                                    <div class="mt-4 border-t border-gray-100 dark:border-neutral-700/80 pt-4" onclick="event.stopPropagation()">
                                        <label for="payment_receipt" class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Upload Payment Receipt <span class="text-red-500">*</span></label>
                                        <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:uppercase file:tracking-wider file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-neutral-800 dark:file:text-gray-300 dark:hover:file:bg-neutral-700 transition cursor-pointer" />
                                        @error('payment_receipt')
                                            <span class="block text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</span>
                                        @enderror
                                        <span class="block text-[10px] text-gray-400 mt-1.5">Max size: 3MB. Formats: JPG, PNG, PDF.</span>
                                    </div>
                                </span>
                            </div>
                        </label>
                        @endif

                        @if(!$enablePaystack && !$enableFlutterwave && !$enableCOD && !$enableBankTransfer)
                            <div class="text-sm text-red-600 bg-red-50 p-4 rounded">No payment methods are currently available. Please contact store support.</div>
                        @endif
                    </div>
                </div>
                
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-gray-50 dark:bg-neutral-900 border border-bark/5 dark:border-cream/5 rounded-2xl p-8 sticky top-28 shadow-sm">
                    <h2 class="font-display text-xl font-bold uppercase tracking-wider mb-6 pb-4 border-b border-bark/10 dark:border-cream/10">Order Summary</h2>

                    {{-- Items --}}
                    <div class="mb-6 space-y-4 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($order->items as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-gray-100 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-800 relative rounded-md flex-shrink-0">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-md" />
                                @endif
                                <span class="absolute -top-2 -right-2 bg-bark dark:bg-cream text-cream dark:text-bark w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold z-10">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-1 min-w-0 py-1">
                                <h4 class="font-display text-xs font-bold uppercase tracking-wide truncate">{{ $item->product ? $item->product->name : 'Item' }}</h4>
                            </div>
                            <div class="text-sm font-semibold py-1 flex-shrink-0">₦{{ number_format($item->price * $item->quantity, 2) }}</div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="space-y-3 text-sm mb-6 border-t border-bark/10 dark:border-cream/10 pt-6">
                        <div class="flex justify-between">
                            <span class="opacity-60">Subtotal</span>
                            <span class="font-medium">₦{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-sage">
                                <span>Discount</span>
                                <span>-₦{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="opacity-60">Shipping</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300 text-right">
                                @if($order->shipping_fee == 0)
                                    <span class="text-sage font-semibold">Free</span>
                                @else
                                    ₦{{ number_format($order->shipping_fee, 2) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between items-baseline pt-4 border-t border-bark/10 dark:border-cream/10 mb-8">
                        <span class="font-display text-lg font-bold uppercase tracking-wider">Total</span>
                        <span class="font-display text-2xl font-bold">₦{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    {{-- Action Button --}}
                    <button type="submit" class="w-full bg-bark dark:bg-cream text-cream dark:text-bark border border-bark dark:border-cream text-center font-display text-sm font-bold tracking-[0.2em] uppercase py-4 hover:bg-transparent hover:text-bark dark:hover:text-clay dark:hover:border-clay transition-colors rounded-sm flex items-center justify-center gap-2 group">
                        <span>Pay ₦{{ number_format($order->total_amount, 2) }}</span>
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="group-hover:translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                    
                    <p class="text-center text-[10px] text-gray-400 mt-4 tracking-wide uppercase">Your payment is processed securely.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function copyAccount(e) {
    e.preventDefault();
    e.stopPropagation();
    const accNum = document.getElementById('bank-account-num').innerText;
    navigator.clipboard.writeText(accNum).then(() => {
        const btn = e.currentTarget;
        const oldHtml = btn.innerHTML;
        btn.innerHTML = `<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
        setTimeout(() => { btn.innerHTML = oldHtml; }, 2000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

// Intercept form submission when Flutterwave is selected
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selected = form.querySelector('input[name="payment_method"]:checked');
            if (selected && selected.value === 'flutterwave') {
                e.preventDefault();
                if (typeof payWithFlutterwave === 'function') {
                    payWithFlutterwave();
                } else {
                    alert('Flutterwave is not configured. Please contact support.');
                }
            }
        });
    }

    // Auto-launch if redirected back with launch_flutterwave flag
    @if(session('launch_flutterwave'))
        setTimeout(function() {
            if (typeof payWithFlutterwave === 'function') {
                payWithFlutterwave();
            }
        }, 500);
    @endif
});
</script>

{{-- Include Flutterwave Inline JS if enabled --}}
@if($enableFlutterwave)
    @include('Shop.payment.flutterwave.index')
@endif
@endsection
