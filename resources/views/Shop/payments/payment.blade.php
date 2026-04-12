@extends('layouts.shop')

@section('title', 'Payment History - ')

@section('content')
    <div class="max-w-6xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[60vh]">
        
        {{-- Page Header & Breadcrumb --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <nav class="flex text-xs font-body uppercase tracking-wider text-gray-400 mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-bark dark:hover:text-cream transition-colors">Home</a>
                        </li>
                        <li>
                            <span class="mx-2">/</span>
                        </li>
                        <li class="text-bark dark:text-cream font-medium" aria-current="page">
                            Payment History
                        </li>
                    </ol>
                </nav>
                <h1 class="font-display text-4xl text-bark dark:text-cream">Payment History</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Track and manage your past transactions and invoices.</p>
            </div>
            
            <div class="hidden lg:block">
                {{-- Example: Dashboard nav link if applicable --}}
            </div>
        </div>

        @if(isset($payments) && $payments->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                <div class="w-20 h-20 mb-6 bg-gray-50 dark:bg-neutral-800 rounded-full flex items-center justify-center text-gray-400">
                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-display font-medium text-bark dark:text-cream mb-2">No payments found</h3>
                <p class="text-gray-500 mb-6">You haven't made any transactions yet.</p>
                <a href="{{ route('shop.products') }}" class="btn-primary rounded-full px-8 py-3 text-sm font-medium tracking-wide">
                    Start Shopping
                </a>
            </div>
        @else
            {{-- Payments Table (Desktop) --}}
            <div class="hidden md:block auth-card" style="animation: fadeUp 0.5s ease forwards;">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-neutral-700">
                            <th class="py-4 px-5 text-left font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[5%]">#</th>
                            <th class="py-4 px-5 text-left font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[20%]">Order ID</th>
                            <th class="py-4 px-5 text-left font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[20%]">Amount</th>
                            <th class="py-4 px-5 text-left font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[15%]">Status</th>
                            <th class="py-4 px-5 text-left font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[25%]">Method</th>
                            <th class="py-4 px-5 text-right font-body font-semibold uppercase tracking-[0.15em] text-xs text-bark/70 dark:text-cream/70 w-[15%]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                            <tr class="border-b border-gray-100 dark:border-neutral-800 transition-colors duration-300 hover:bg-sand/30 dark:hover:bg-neutral-800/40">
                                {{-- Index --}}
                                <td class="py-5 px-5 text-gray-500 font-medium">
                                    {{ $payments->firstItem() + $key }}
                                </td>

                                {{-- Order ID --}}
                                <td class="py-5 px-5">
                                    <div class="font-display font-medium text-bark dark:text-cream tracking-wide">
                                        @php
                                            $order_ids = json_decode($payment->order_id, true) ?? [];
                                            $formatted_ids = array_map(function($id) {
                                                return '#' . ($id + 100);
                                            }, $order_ids);
                                        @endphp
                                        {{ implode(', ', $formatted_ids) }}
                                    </div>
                                </td>

                                {{-- Amount --}}
                                <td class="py-5 px-5 font-body font-semibold text-bark dark:text-cream">
                                    {{ $payment->currency_code ?? '₦' }}{{ number_format($payment->total_amount, 2) }}
                                </td>

                                {{-- Status --}}
                                <td class="py-5 px-5">
                                    @if ($payment->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-md">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-rust bg-rust/10 dark:text-clay dark:bg-clay/10 rounded-md">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-yellow-700 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-500 rounded-md">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Payment Method / Details --}}
                                <td class="py-5 px-5">
                                    <div class="mb-1 pointer-events-none">
                                        <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 dark:bg-neutral-700 dark:text-gray-300 rounded-md">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    </div>
                                    
                                    @if($payment->payment_method === 'offline' && !empty($payment->payment_details))
                                        @php
                                            $payment_details = is_string($payment->payment_details) ? json_decode($payment->payment_details) : (object) $payment->payment_details;
                                        @endphp
                                        <div class="text-[11px] text-gray-500 mt-2 space-y-0.5">
                                            @if(isset($payment_details->bank_no))<div><strong>Bank No:</strong> {{ $payment_details->bank_no }}</div>@endif
                                            @if(isset($payment_details->phone_no))<div><strong>Phone:</strong> {{ $payment_details->phone_no }}</div>@endif
                                            @if(isset($payment_details->file_path))
                                                <div class="mt-1">
                                                    <a href="{{ asset('storage/' . $payment_details->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-rust hover:text-bark dark:hover:text-cream transition-colors">
                                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                        View Proof Document
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="py-5 px-5 text-right">
                                    <a href="{{ route('customer.payment.invoice', ['payment_id' => $payment->id]) }}" 
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2 text-[11px] font-body uppercase tracking-[0.1em] font-medium border border-gray-300 dark:border-neutral-600 rounded text-bark dark:text-cream hover:bg-bark hover:text-cream dark:hover:bg-cream dark:hover:text-bark transition-colors">
                                        Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden space-y-4">
                @foreach ($payments as $key => $payment)
                    <div class="auth-card p-5 relative" style="animation: fadeUp 0.5s ease {{ $key * 0.1 }}s forwards; opacity:0;">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-xs text-gray-500 block mb-1">Order ID</span>
                                <div class="font-display font-medium text-bark dark:text-cream">
                                    @php
                                        $order_ids = json_decode($payment->order_id, true) ?? [];
                                        $formatted_ids = array_map(function($id) {
                                            return '#' . ($id + 100);
                                        }, $order_ids);
                                    @endphp
                                    {{ implode(', ', $formatted_ids) }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block mb-1">Amount</span>
                                <div class="font-body font-semibold text-bark dark:text-cream">
                                    {{ $payment->currency_code ?? '₦' }}{{ number_format($payment->total_amount, 2) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            @if ($payment->status === 'paid')
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-md">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            @elseif($payment->status === 'pending')
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-rust bg-rust/10 dark:text-clay dark:bg-clay/10 rounded-md">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-yellow-700 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-500 rounded-md">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            @endif

                            <span class="inline-flex items-center px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 dark:bg-neutral-700 dark:text-gray-300 rounded-md">
                                {{ ucfirst($payment->payment_method) }}
                            </span>
                        </div>

                        @if($payment->payment_method === 'offline' && !empty($payment->payment_details))
                            @php
                                $payment_details = is_string($payment->payment_details) ? json_decode($payment->payment_details) : (object) $payment->payment_details;
                            @endphp
                            <div class="bg-gray-50 dark:bg-neutral-800/50 rounded-lg p-3 text-xs text-gray-500 mb-4 space-y-1">
                                <div><strong class="text-gray-700 dark:text-gray-300">Offline Details:</strong></div>
                                @if(isset($payment_details->bank_no))<div>Bank No: {{ $payment_details->bank_no }}</div>@endif
                                @if(isset($payment_details->phone_no))<div>Phone: {{ $payment_details->phone_no }}</div>@endif
                                @if(isset($payment_details->file_path))
                                    <div class="pt-1">
                                        <a href="{{ asset('storage/' . $payment_details->file_path) }}" target="_blank" class="text-rust hover:text-bark dark:hover:text-cream transition-colors underline">
                                            View Proof
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-100 dark:border-neutral-800">
                            <a href="{{ route('customer.payment.invoice', ['payment_id' => $payment->id]) }}" 
                               class="flex items-center justify-center gap-2 w-full py-3 text-xs font-body uppercase tracking-[0.1em] font-medium border border-gray-300 dark:border-neutral-600 rounded text-bark dark:text-cream hover:bg-bark hover:text-cream dark:hover:bg-cream dark:hover:text-bark transition-colors">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                View Invoice
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center custom-pagination">
                {{ $payments->links('pagination::tailwind') ?? $payments->links() }}
            </div>
        @endif
    </div>

    <style>
        .auth-card {
            background: rgba(247, 243, 238, 0.5);
            border-radius: 16px;
            padding: 8px;
            border: 1px solid rgba(232, 221, 208, 0.6);
        }
        .dark .auth-card {
            background: rgba(44, 34, 24, 0.3);
            border-color: rgba(44, 34, 24, 0.6);
        }

        /* Override pagination styles softly for theme matching */
        .custom-pagination nav > div > div > p {
            display: none;
        }
        .custom-pagination .bg-white {
            background-color: transparent !important;
        }
        .custom-pagination span[aria-current="page"] > span {
            background-color: var(--color-bark, #2c2218) !important;
            color: var(--color-cream, #f7f3ee) !important;
            border-color: var(--color-bark, #2c2218) !important;
        }
        .dark .custom-pagination span[aria-current="page"] > span {
            background-color: var(--color-cream, #f7f3ee) !important;
            color: var(--color-bark, #2c2218) !important;
            border-color: var(--color-cream, #f7f3ee) !important;
        }
    </style>
@endsection
