@extends('layouts.admin')

@push('title', 'Order List')

@section('admin')
    <style>
        .s-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .dark .s-card {
            background: #262626;
            border-color: #404040;
        }

        .table-header-text {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #9ca3af;
        }

        .order-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .dark .order-title {
            color: #f3f4f6;
        }

        .badge-outline {
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
            border: 1px solid;
            text-transform: capitalize;
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
            color: #ef4444;
            background: rgba(239, 68, 68, 0.08);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background: #f9fafb;
            color: #111827;
        }

        .dark .btn-outline-custom {
            background: transparent;
            border-color: #374151;
            color: #d1d5db;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: #3b82f6;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: #3b82f6;
        }

        /* ── Row Action Buttons ── */
        .row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 2px;
        }

        .row-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 7px;
            color: #9ca3af;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }

        .row-action-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .dark .row-action-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
        }

        .row-action-btn.view:hover {
            background: #ede9fe;
            color: #3b82f6;
        }

        .dark .row-action-btn.view:hover {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
        }

        .row-action-btn.edit:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .dark .row-action-btn.edit:hover {
            background: rgba(2, 132, 199, 0.12);
            color: #38bdf8;
        }

        .row-action-btn.delete:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        .dark .row-action-btn.delete:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* Tooltip */
        .row-action-btn::before {
            content: attr(data-tip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            background: #1f2937;
            color: #fff;
            opacity: 0;
            pointer-events: none;
            transition: all 0.15s ease;
            z-index: 20;
        }

        .dark .row-action-btn::before {
            background: #374151;
        }

        .row-action-btn::after {
            content: '';
            position: absolute;
            bottom: calc(100% + 2px);
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: #1f2937;
            opacity: 0;
            pointer-events: none;
            transition: all 0.15s ease;
            z-index: 20;
        }

        .dark .row-action-btn::after {
            border-top-color: #374151;
        }

        .row-action-btn:hover::before {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .row-action-btn:hover::after {
            opacity: 1;
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
            <span class="text-gray-600 dark:text-gray-300 font-medium">Orders</span>
        </div>

        {{-- Messages --}}
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                {{ session('error') }}</div>
        @endif

        {{-- Main Card --}}
        <div class="s-card mb-6">
            {{-- Header Actions --}}
            <div
                class="flex flex-col xl:flex-row xl:items-center justify-between p-5 border-b border-gray-100 dark:border-neutral-800 gap-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Orders List</h2>

                <div class="flex flex-wrap items-center gap-3">
                    {{-- Date & Status Filter --}}
                    <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <input type="date" name="created_at" value="{{ request('created_at') }}"
                            class="btn-outline-custom" title="Select Date" onchange="this.form.submit()">

                        <select name="status" class="btn-outline-custom pr-8" onchange="this.form.submit()">
                            <option value="all">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>

                        @if (request()->hasAny(['search', 'created_at', 'status']))
                            <a href="{{ route('admin.orders') }}"
                                class="text-red-500 hover:text-red-600 text-sm font-medium ml-1">Clear</a>
                        @endif
                    </form>

                    <div class="h-6 w-px bg-gray-200 dark:bg-neutral-700 mx-1 hidden sm:block"></div>

                    {{-- Search --}}
                    <form action="{{ route('admin.orders') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search ID or Name..."
                            class="pl-9 pr-4 py-2 border border-gray-200 dark:border-neutral-700 rounded-lg text-sm bg-gray-50 dark:bg-neutral-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand w-48 sm:w-60 transition-all">
                        <svg class="absolute left-3 top-2.5 text-gray-400 w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        @if (request('created_at'))
                            <input type="hidden" name="created_at" value="{{ request('created_at') }}">
                        @endif
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                    </form>

                    {{-- Add Order --}}
                    <a href="{{ route('admin.order.add') }}" class="btn-primary-custom">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Order
                    </a>

                    {{-- Print --}}
                    <button type="button" onclick="window.print()" class="btn-outline-custom">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800 bg-gray-50/50 dark:bg-neutral-800/50">
                            <th class="py-4 pl-5 px-4 table-header-text">Order ID</th>
                            <th class="py-4 px-4 table-header-text">Customer</th>
                            <th class="py-4 px-4 table-header-text text-center">Items</th>
                            <th class="py-4 px-4 table-header-text">Amount</th>
                            <th class="py-4 px-4 table-header-text">Status</th>
                            <th class="py-4 px-4 table-header-text hidden md:table-cell">Date</th>
                            <th class="py-4 px-5 table-header-text text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                                {{-- Order ID --}}
                                <td class="py-4 pl-5 px-4">
                                    <span class="order-title">#{{ $order->id + 100 }}</span>
                                    @if ($order->tracking_code)
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $order->tracking_code }}</div>
                                    @endif
                                </td>

                                {{-- Customer --}}
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-brand-pale dark:bg-blue-900/30 text-brand flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $order->customer_name }}</h4>
                                            <span class="text-xs text-gray-500">{{ $order->customer_email }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Items Qty --}}
                                <td class="py-4 px-4 text-center text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $order->items->sum('quantity') }}
                                </td>

                                {{-- Amount --}}
                                <td class="py-4 px-4">
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                        ₦{{ number_format($order->total_amount, 2) }}
                                    </div>
                                    <div
                                        class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide bg-gray-100 dark:bg-neutral-800 inline-block px-1.5 py-0.5 rounded">
                                        {{ $order->payment_method }}
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4">
                                    <span class="badge-outline badge-{{ $order->status }}">{{ $order->status }}</span>
                                </td>

                                {{-- Date --}}
                                <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">
                                    {{ $order->created_at->format('d M, Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-5">
                                    <div class="row-actions">
                                        {{-- View --}}
                                        <a href="{{ route('admin.order.details', ['id' => $order->id]) }}"
                                            class="row-action-btn view" data-tip="View">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.order.edit', ['id' => $order->id]) }}"
                                            class="row-action-btn edit" data-tip="Edit">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <a href="javascript:;"
                                            onclick="if(confirm('Are you sure you want to delete this order?')) window.location.href='{{ route('admin.order.delete', ['id' => $order->id]) }}'"
                                            class="row-action-btn delete" data-tip="Delete">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="mx-auto text-gray-300 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">No Orders Found</h3>
                                    <p class="text-gray-500 text-sm mt-1 mb-4">You don't have any orders matching your
                                        criteria.</p>
                                    <a href="{{ route('admin.order.add') }}" class="btn-primary-custom">Add new order</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-neutral-800 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing {{ $orders->count() }} of {{ $orders->total() }} entries
                    </p>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
