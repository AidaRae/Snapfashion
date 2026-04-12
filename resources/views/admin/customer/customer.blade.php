@extends('layouts.admin')

@push('title', 'Customer List')

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

        .customer-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .dark .customer-name {
            color: #f3f4f6;
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

        /* Row Action Buttons */
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

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-chip.orders {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.08);
        }

        .stat-chip.spent {
            color: #10b981;
            background: rgba(16, 185, 129, 0.08);
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
            <span class="text-gray-600 dark:text-gray-300 font-medium">Customers</span>
        </div>

        {{-- Messages --}}
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main Card --}}
        <div class="s-card mb-6">
            {{-- Header Actions --}}
            <div
                class="flex flex-col xl:flex-row xl:items-center justify-between p-5 border-b border-gray-100 dark:border-neutral-800 gap-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ 'Customer List' }}</h2>

                <div class="flex flex-wrap items-center gap-3">
                    {{-- Search --}}
                    <form action="{{ route('admin.customers') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ 'Search by name or email' }}..."
                            class="pl-9 pr-4 py-2 border border-gray-200 dark:border-neutral-700 rounded-lg text-sm bg-gray-50 dark:bg-neutral-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand w-48 sm:w-60 transition-all">
                        <svg class="absolute left-3 top-2.5 text-gray-400 w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>

                    @if (request()->hasAny(['search']))
                        <a href="{{ route('admin.customers') }}"
                            class="text-red-500 hover:text-red-600 text-sm font-medium ml-1">{{ 'Clear' }}</a>
                    @endif

                    {{-- Print --}}
                    <button type="button" onclick="window.print()" class="btn-outline-custom">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        {{ 'Print' }}
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse print-table">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800 bg-gray-50/50 dark:bg-neutral-800/50">
                            <th class="py-4 pl-5 px-4 table-header-text">#</th>
                            <th class="py-4 px-4 table-header-text">{{ 'Customer' }}</th>
                            <th class="py-4 px-4 table-header-text">{{ 'Phone' }}</th>
                            <th class="py-4 px-4 table-header-text">{{ 'Address' }}</th>
                            <th class="py-4 px-4 table-header-text text-center">{{ 'Orders' }}</th>
                            <th class="py-4 px-4 table-header-text">{{ 'Total Spent' }}</th>
                            <th class="py-4 px-4 table-header-text hidden md:table-cell">{{ 'Last Order' }}
                            </th>
                            <th class="py-4 px-5 table-header-text text-right">{{ 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($customers as $key => $customer)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors">
                                {{-- # --}}
                                <td class="py-4 pl-5 px-4 text-sm text-gray-500">{{ $customers->firstItem() + $key }}</td>

                                {{-- Customer Name & Email --}}
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-brand-pale dark:bg-blue-900/30 text-brand flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($customer->guest_name ?? 'G', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="customer-name">{{ $customer->guest_name ?? 'N/A' }}</h4>
                                            <span class="text-xs text-gray-500">{{ $customer->guest_email }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Phone --}}
                                <td class="py-4 px-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $customer->guest_phone ?? '—' }}
                                </td>

                                {{-- Address --}}
                                <td class="py-4 px-4 text-sm text-gray-700 dark:text-gray-300 max-w-[200px] truncate">
                                    {{ $customer->shipping_address ?? '—' }}
                                </td>

                                {{-- Order Count --}}
                                <td class="py-4 px-4 text-center">
                                    <span class="stat-chip orders">{{ $customer->order_count }}</span>
                                </td>

                                {{-- Total Spent --}}
                                <td class="py-4 px-4">
                                    <span class="stat-chip spent">₦{{ number_format($customer->total_spent, 2) }}</span>
                                </td>

                                {{-- Last Order --}}
                                <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($customer->last_order_at)->format('d M, Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-5">
                                    <div class="row-actions">
                                        <a href="{{ route('admin.customer.show', ['email' => $customer->guest_email]) }}"
                                            class="row-action-btn view" data-tip="{{ 'View Orders' }}">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="mx-auto text-gray-300 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                                        {{ 'No Customers Found' }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">
                                        {{ 'Customers will appear here once guest orders are placed.' }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($customers->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-neutral-800 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        {{ 'Showing' }} {{ $customers->count() }} {{ 'of' }}
                        {{ $customers->total() }} {{ 'entries' }}
                    </p>
                    <div>
                        {{ $customers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
