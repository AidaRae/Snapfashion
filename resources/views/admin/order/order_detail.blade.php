@extends('layouts.admin')

@push('title', 'Order Details')

@section('admin')
    <style>
        .s-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
        }

        .dark .s-card {
            background: #262626;
            border-color: #404040;
        }

        .badge-outline {
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
            border: 1px solid;
        }

        .badge-pending {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.08);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .badge-processing {
            color: #0ea5e9;
            background: rgba(14, 165, 233, 0.08);
            border-color: rgba(14, 165, 233, 0.3);
        }

        .badge-shipped {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .badge-delivered {
            color: #10b981;
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .badge-cancelled {
            color: #37054e;
            background: rgba(239, 68, 68, 0.08);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .badge-paid {
            color: #10b981;
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .badge-unpaid {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.08);
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* Custom form select styling */
        .status-select {
            appearance: none;
            background-color: transparent;
            border: 1px solid #3b82f6;
            color: #3b82f6;
            padding: 6px 30px 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            padding-right: 32px;    
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%233b82f6'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 14px;
            min-width: 120px;
        }

        .status-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .status-select option {
            color: #1f2937;
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <a href="{{ route('admin.orders') }}"
                class="hover:text-brand dark:hover:text-blue-400 transition-colors">Online Orders</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">View</span>
        </div>

        {{-- Error / Success messages --}}
        @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Order Header Card --}}
        <form action="{{ route('admin.order.update', ['id' => $order->id]) }}" method="POST"
            class="s-card mb-6 p-5 sm:p-6 lg:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            @csrf
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
                    <span class="font-normal text-gray-600 dark:text-gray-400">Order ID:</span> #{{ $order->id + 100 }}
                    <span
                        class="badge-outline badge-{{ $order->payment_status == 'paid' ? 'paid' : 'unpaid' }} text-xs">{{ ucfirst($order->payment_status) }}</span>
                    <span class="badge-outline badge-{{ $order->status }} text-xs capitalize">{{ $order->status }}</span>
                </h2>
                <div class="mt-4 text-[13px] text-gray-500 space-y-2">
                    <p class="flex items-center gap-2">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $order->created_at->format('h:i A, d-m-Y') }}
                    </p>
                    <p>Payment Type: <span
                            class="text-gray-800 dark:text-gray-200 uppercase">{{ $order->payment_method }}</span></p>
                    <p>Order Type: <span class="text-gray-800 dark:text-gray-200">Delivery</span></p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                {{-- Update Payment Status --}}
                <select name="payment_status" class="status-select bg-white" onchange="this.form.submit()">
                    <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>

                {{-- Update Order Status --}}
                <select name="status" class="status-select bg-white" onchange="this.form.submit()">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <a href="{{ route('admin.order.invoice', ['id' => $order->id, 'download' => 'pdf']) }}" target="_blank"
                    class="bg-[#3b82f6] hover:bg-[#2563eb] text-white px-5 py-[7px] rounded-md text-[13px] font-medium flex items-center gap-2 transition-colors border border-[#3b82f6]">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Invoice
                </a>
            </div>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            {{-- Left: Order Details (Items) --}}
            <div class="s-card overflow-hidden h-full">
                <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-neutral-800">
                    <h3 class="text-[17px] font-semibold text-gray-600 dark:text-gray-300">Order Details</h3>
                </div>

                <div class="p-2 sm:p-4">
                    <div class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @foreach ($order->items as $item)
                            @php
                                $product = $item->product;
                            @endphp
                            <div class="flex items-center gap-4 py-4 px-2">
                                <div class="relative shrink-0">
                                    @if ($product && $product->image)
                                        <div
                                            class="w-16 h-16 rounded-md bg-gray-100 border border-gray-200 dark:border-neutral-700 overflow-hidden">
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="w-full h-full object-cover" alt="Product">
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-md bg-gray-100 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span
                                        class="absolute -left-2 -top-2 flex items-center justify-center w-6 h-6 rounded-full bg-[#1e1e2d] text-white text-[11px] font-semibold border-2 border-white dark:border-neutral-900">
                                        {{ $item->quantity }}
                                    </span>
                                </div>

                                <div class="flex-grow">
                                    <h4 class="text-[15px] font-medium text-[#7a859e] dark:text-gray-300">
                                        {{ $product ? $product->name : 'Unknown Product' }}</h4>
                                    <p class="text-[13px] text-[#7a859e] mt-0.5">Quantity: {{ $item->quantity }}</p>
                                    <div class="mt-1">
                                        <span
                                            class="text-[15px] font-semibold text-[#7a859e]">₦{{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Summary & Address --}}
            <div class="space-y-6">
                {{-- Order Summary --}}
                <div class="s-card p-5 sm:p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-[15px] text-[#2c3e50] dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>₦{{ number_format($order->subtotal, 2) }}</span>
                        </div>

                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between items-center text-[15px] text-[#2c3e50] dark:text-gray-400">
                                <span>Discount</span>
                                <span>-₦{{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-[15px] text-[#2c3e50] dark:text-gray-400">
                            <span>Shipping Charge</span>
                            <span class="text-green-500 font-medium">₦0.00</span>
                        </div>

                        <div
                            class="pt-4 mt-2 border-t border-gray-100 dark:border-neutral-800 flex justify-between items-center">
                            <span class="text-[16px] font-bold text-[#7a859e] dark:text-gray-100">Total</span>
                            <span
                                class="text-[16px] font-bold text-[#7a859e] dark:text-gray-100">₦{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="s-card p-5 sm:p-6">
                    <h3
                        class="text-[17px] font-semibold text-gray-600 dark:text-gray-300 mb-4 pb-2 border-b border-gray-100 dark:border-neutral-800">
                        Shipping Address</h3>
                    <div class="text-[14px] text-gray-500 dark:text-gray-400 leading-relaxed font-normal">
                        <p class="mb-1"><strong class="font-semibold text-gray-700 dark:text-gray-300">Name:</strong>
                            {{ $order->customer_name }}</p>
                        <p class="mb-1"><strong class="font-semibold text-gray-700 dark:text-gray-300">Phone:</strong>
                            {{ $order->guest_phone ?? 'N/A' }}</p>
                        <p class="mb-1"><strong class="font-semibold text-gray-700 dark:text-gray-300">Email:</strong>
                            <a href="mailto:{{ $order->customer_email }}"
                                class="text-brand hover:underline">{{ $order->customer_email }}</a></p>
                        <p class="mt-3"><strong
                                class="font-semibold text-gray-700 dark:text-gray-300 block mb-1">Address:</strong>
                            {{ $order->shipping_address ?? 'No shipping address provided.' }}</p>

                        @if ($order->tracking_code)
                            <p class="mt-3"><strong class="font-semibold text-gray-700 dark:text-gray-300">Tracking
                                    Code:</strong> {{ $order->tracking_code }}</p>
                        @endif
                    </div>
                </div>

                {{-- Payment Receipt --}}
                <div class="s-card p-5 sm:p-6">
                    <h3 class="text-[17px] font-semibold text-gray-600 dark:text-gray-300 mb-4 pb-2 border-b border-gray-100 dark:border-neutral-800">
                        Payment Receipt
                    </h3>
                    <div class="mt-2 text-[14px]">
                        @if($order->payment_receipt)
                            @if(str_ends_with(strtolower($order->payment_receipt), '.pdf'))
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="flex items-center gap-2 text-[#3b82f6] hover:text-[#2563eb] hover:underline font-medium bg-gray-50 dark:bg-neutral-800 p-3 rounded-lg border border-gray-100 dark:border-neutral-700">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    View PDF Document
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-200 dark:border-neutral-700 hover:opacity-90 transition bg-gray-50 dark:bg-neutral-800 p-2 relative group cursor-zoom-in">
                                    <img src="{{ asset('storage/' . $order->payment_receipt) }}" alt="Payment Receipt" class="w-full h-auto object-cover max-h-48 rounded">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded">
                                        <span class="text-white text-xs font-semibold px-3 py-1.5 bg-black/50 rounded-full flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Click to enlarge
                                        </span>
                                    </div>
                                </a>
                            @endif
                        @else
                            <div class="text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-neutral-800/50 p-4 rounded-lg border border-gray-100 dark:border-neutral-700/50 flex flex-col items-center justify-center text-center">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                No payment receipt uploaded for this order.
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
