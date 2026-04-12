@extends('layouts.admin')

@section('title', 'Analytics')

@section('admin')

    <div class="p-4 sm:p-6 space-y-6">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white tracking-tight">Analytics</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Track performance and business growth</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Date Range Picker --}}
                <div class="relative">
                    <select id="dateRange"
                        class="appearance-none pl-3 pr-8 py-2 text-sm bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-lg text-gray-700 dark:text-gray-300 font-medium cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand/30">
                        <option value="7">Last 7 days</option>
                        <option value="30" selected>Last 30 days</option>
                        <option value="90">Last 90 days</option>
                        <option value="365">This year</option>
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <button class="add-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- KPI STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Revenue --}}
            <div
                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-neutral-700 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-brand/5 dark:bg-brand/10 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start justify-between">
                    <div class="w-9 h-9 rounded-xl bg-brand-pale dark:bg-brand/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold {{ $stats['revenue_growth'] >= 0 ? 'text-green-500 bg-green-50 dark:bg-green-500/10' : 'text-red-500 bg-red-50 dark:bg-red-500/10' }} px-2 py-0.5 rounded-full">
                        {{ $stats['revenue_growth'] > 0 ? '+' : '' }}{{ $stats['revenue_growth'] }}%
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Revenue</p>
                    <p class="text-xl sm:text-2xl font-display font-bold text-gray-900 dark:text-white mt-0.5">₦{{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">vs ₦{{ number_format($stats['previous_revenue'], 2) }} last period</p>
                </div>
            </div>

            {{-- Total Orders --}}
            <div
                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-neutral-700 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-500/5 dark:bg-blue-500/10 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start justify-between">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold {{ $stats['orders_growth'] >= 0 ? 'text-green-500 bg-green-50 dark:bg-green-500/10' : 'text-red-500 bg-red-50 dark:bg-red-500/10' }} px-2 py-0.5 rounded-full">
                        {{ $stats['orders_growth'] > 0 ? '+' : '' }}{{ $stats['orders_growth'] }}%
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Orders</p>
                    <p class="text-xl sm:text-2xl font-display font-bold text-gray-900 dark:text-white mt-0.5">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">vs {{ number_format($stats['previous_orders']) }} last period</p>
                </div>
            </div>

            {{-- Customers --}}
            <div
                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-neutral-700 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-emerald-500/5 dark:bg-emerald-500/10 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start justify-between">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold {{ $stats['customers_growth'] >= 0 ? 'text-green-500 bg-green-50 dark:bg-green-500/10' : 'text-red-500 bg-red-50 dark:bg-red-500/10' }} px-2 py-0.5 rounded-full">
                        {{ $stats['customers_growth'] > 0 ? '+' : '' }}{{ $stats['customers_growth'] }}%
                    </span>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Customers</p>
                    <p class="text-xl sm:text-2xl font-display font-bold text-gray-900 dark:text-white mt-0.5">{{ number_format($stats['total_customers']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">vs {{ number_format($stats['previous_customers']) }} last period</p>
                </div>
            </div>

            {{-- Products --}}
            <div
                class="bg-white dark:bg-neutral-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-neutral-700 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-indigo-500/5 dark:bg-indigo-500/10 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-start justify-between">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-50 dark:bg-gray-500/10 px-2 py-0.5 rounded-full">Active</span>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Products</p>
                    <p class="text-xl sm:text-2xl font-display font-bold text-gray-900 dark:text-white mt-0.5">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-xs mt-1">
                        @if($stats['out_of_stock'] > 0 || $stats['low_stock'] > 0)
                            <span class="text-red-500 dark:text-red-400 font-semibold">{{ $stats['out_of_stock'] }}</span> out of stock &bull; 
                            <span class="text-amber-500 dark:text-amber-400 font-semibold">{{ $stats['low_stock'] }}</span> low
                        @else
                            <span class="text-emerald-500 dark:text-emerald-400 font-medium">All stocks healthy</span>
                        @endif
                    </p>
                </div>
            </div>

        </div>

        {{-- REVENUE CHART + BREAKDOWN --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Revenue Chart --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Revenue Overview</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Monthly revenue vs expenses</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand inline-block"></span> Revenue
                        </span>
                        <span class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400 inline-block"></span> Expenses
                        </span>
                    </div>
                </div>
                <canvas id="revenueChart" height="220"></canvas>
            </div>

            {{-- Traffic Sources --}}
            <div
                class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700 flex flex-col">
                <div class="mb-4">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Traffic Sources</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Where visitors come from</p>
                </div>
                <div class="flex items-center justify-center my-2">
                    <canvas id="donutChart" width="180" height="180"></canvas>
                </div>
                <div class="mt-4 space-y-3">
                    @php
                        $sources = [
                            ['label' => 'Organic Search', 'value' => '38%', 'color' => '#3b82f6'],
                            ['label' => 'Direct', 'value' => '24%', 'color' => '#60a5fa'],
                            ['label' => 'Social Media', 'value' => '21%', 'color' => '#34d399'],
                            ['label' => 'Referral', 'value' => '17%', 'color' => '#f87171'],
                        ];
                    @endphp
                    @foreach ($sources as $source)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                    style="background:{{ $source['color'] }}"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ $source['label'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-1.5 rounded-full bg-gray-100 dark:bg-neutral-700 overflow-hidden">
                                    <div class="h-full rounded-full"
                                        style="width:{{ $source['value'] }};background:{{ $source['color'] }}"></div>
                                </div>
                                <span
                                    class="text-xs font-semibold text-gray-700 dark:text-gray-300 w-8 text-right">{{ $source['value'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ORDERS CHART + TOP PRODUCTS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Top Products Table --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 rounded-2xl border border-gray-100 dark:border-neutral-700 overflow-hidden">
                <div class="flex items-center justify-between px-5 pt-5 pb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Top Products</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Best performing items this period</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-xs text-brand font-semibold hover:underline">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-t border-gray-100 dark:border-neutral-700">
                                <th
                                    class="text-left px-5 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Product</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Sales</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-neutral-700/60">
                            @foreach ($topProducts as $p)
                                <tr class="row-hover">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($p->image)
                                                <img src="{{ asset('storage/' . $p->image) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100 dark:bg-neutral-700" alt="{{ $p->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-neutral-700 flex items-center justify-center text-gray-400">
                                                    📦
                                                </div>
                                            @endif
                                            <div>
                                                <p
                                                    class="text-xs font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                                                    {{ $p->name }}</p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                    {{ $p->sku }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-xs font-medium text-gray-700 dark:text-gray-300">
                                        {{ number_format($p->sales_count) }}</td>
                                    <td class="px-3 py-3 text-xs font-semibold text-gray-800 dark:text-gray-200">
                                        ₦{{ number_format($p->total_revenue, 2) }}</td>
                                </tr>
                            @endforeach
                            @if(count($topProducts) == 0)
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No products sold yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Goals / Targets --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Monthly Goals</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Progress toward targets</p>
                </div>
                <div class="space-y-5">
                    @php
                        $goals = [
                            [
                                'label' => 'Revenue',
                                'current' => $stats['current_revenue'],
                                'target' => 50000,
                                'unit' => '₦',
                                'color' => '#3b82f6',
                            ],
                            [
                                'label' => 'Orders',
                                'current' => $stats['current_orders'],
                                'target' => 500,
                                'unit' => '',
                                'color' => '#60a5fa',
                            ],
                            [
                                'label' => 'New Customers',
                                'current' => $stats['current_customers'],
                                'target' => 100,
                                'unit' => '',
                                'color' => '#34d399',
                            ],
                        ];
                    @endphp
                    @foreach ($goals as $g)
                        @php $pct = round(($g['current'] / $g['target']) * 100); @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span
                                    class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $g['label'] }}</span>
                                <span
                                    class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $pct }}%</span>
                            </div>
                            <div class="h-2 bg-gray-100 dark:bg-neutral-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700"
                                    style="width:{{ $pct }}%;background:{{ $g['color'] }}"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span
                                    class="text-xs text-gray-400 dark:text-gray-500">{{ $g['unit'] }}{{ number_format($g['current']) }}</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">Goal:
                                    {{ $g['unit'] }}{{ number_format($g['target']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mini Sparkline info --}}
                <div class="mt-6 pt-5 border-t border-gray-100 dark:border-neutral-700">
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-3">This Week</p>
                    <canvas id="sparklineChart" height="55"></canvas>
                </div>
            </div>

        </div>

        {{-- BOTTOM ROW: Recent Activity + Device Stats --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Recent Orders --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 rounded-2xl border border-gray-100 dark:border-neutral-700 overflow-hidden">
                <div class="flex items-center justify-between px-5 pt-5 pb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Recent Orders</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Latest transactions</p>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="text-xs text-brand font-semibold hover:underline">View
                        all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-t border-gray-100 dark:border-neutral-700">
                                <th
                                    class="text-left px-5 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Order</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Customer</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Amount</th>
                                <th
                                    class="text-left px-3 py-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-neutral-700/60">
                            @foreach ($recentOrders as $o)
                                @php
                                    $name = $o->customer_name ?? 'Guest';
                                    $avatar = strtoupper(substr($name, 0, 2));
                                    if(empty($avatar)) $avatar = 'G';
                                    $statusColors = [
                                        'pending' => 'text-amber-600 bg-amber-50 dark:text-amber-400 dark:bg-amber-500/10',
                                        'processing' => 'text-sky-600 bg-sky-50 dark:text-sky-400 dark:bg-sky-500/10',
                                        'shipped' => 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-500/10',
                                        'delivered' => 'text-emerald-600 bg-emerald-50 dark:text-emerald-400 dark:bg-emerald-500/10',
                                        'cancelled' => 'text-red-600 bg-red-50 dark:text-red-400 dark:bg-red-500/10',
                                    ];
                                    $statusColor = $statusColors[strtolower($o->status)] ?? $statusColors['pending'];
                                @endphp
                                <tr class="row-hover">
                                    <td class="px-5 py-3">
                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                            #{{ $o->tracking_code ?? $o->id }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $o->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 rounded-full bg-brand-pale dark:bg-brand/20 flex items-center justify-center text-xs font-bold text-brand flex-shrink-0">
                                                {{ $avatar }}</div>
                                            <span
                                                class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-xs font-semibold text-gray-800 dark:text-gray-200">
                                        ₦{{ number_format($o->total_amount, 2) }}</td>
                                    <td class="px-3 py-3">
                                        <span
                                            class="status-badge px-2.5 py-1 rounded-full {{ $statusColor }}">{{ ucfirst($o->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($recentOrders) == 0)
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No recent orders found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Inventory Alerts --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 border border-gray-100 dark:border-neutral-700">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800 dark:text-white">Inventory Alerts</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Products requiring restock</p>
                    </div>
                    <a href="{{ route('admin.stocks.index') }}" class="text-xs text-brand font-semibold hover:underline">Manage</a>
                </div>
                
                <div class="space-y-4">
                    @forelse ($lowStockProducts as $lp)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-50 dark:bg-neutral-700 flex-shrink-0 border border-gray-100 dark:border-neutral-600">
                                @if($lp->image)
                                    <img src="{{ asset('storage/' . $lp->image) }}" class="w-full h-full object-cover" alt="{{ $lp->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">📦</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-0.5">
                                    <p class="text-xs font-medium text-gray-900 dark:text-gray-100 truncate pr-2">{{ $lp->name }}</p>
                                    <span class="text-xs font-bold {{ $lp->stock == 0 ? 'text-red-600 dark:text-red-400' : 'text-amber-600 dark:text-amber-500' }}">{{ $lp->stock }} left</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-neutral-700 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $lp->stock == 0 ? 'bg-red-500' : 'bg-amber-500' }}" style="width: {{ max(5, ($lp->stock / 5) * 100) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.products.edit', $lp->id) }}" class="p-1.5 inline-flex items-center justify-center text-gray-400 hover:text-brand hover:bg-brand/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">All Clear!</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">No products are low on stock.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>{{-- /p-6 --}}

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        /* ─── helpers ─── */
        const isDark = () => document.documentElement.classList.contains('dark');
        const gridColor = () => isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
        const textColor = () => isDark() ? '#9ca3af' : '#6b7280';

        /* ─── Revenue Chart ─── */
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');

        const gradientRevenue = revenueCtx.createLinearGradient(0, 0, 0, 260);
        gradientRevenue.addColorStop(0, 'rgba(59, 130, 246,0.18)');
        gradientRevenue.addColorStop(1, 'rgba(59, 130, 246,0.00)');

        const gradientExpense = revenueCtx.createLinearGradient(0, 0, 0, 260);
        gradientExpense.addColorStop(0, 'rgba(248,113,113,0.14)');
        gradientExpense.addColorStop(1, 'rgba(248,113,113,0.00)');

        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Revenue',
                        data: @json($chartData),
                        borderColor: '#3b82f6',
                        borderWidth: 2.5,
                        backgroundColor: gradientRevenue,
                        fill: true,
                        tension: 0.45,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#3b82f6',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    },
                    {
                        label: 'Expenses',
                        data: @json(array_map(function($v) { return $v * 0.7; }, $chartData)), // Rough estimate for expenses placeholder
                        borderColor: '#f87171',
                        borderWidth: 2,
                        backgroundColor: gradientExpense,
                        fill: true,
                        tension: 0.45,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#f87171',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                        borderDash: [5, 4],
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark() ? '#1f2937' : '#fff',
                        titleColor: isDark() ? '#e5e7eb' : '#111',
                        bodyColor: textColor(),
                        borderColor: isDark() ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: ctx => ` ₦${ctx.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: textColor(),
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: gridColor(),
                            drawBorder: false
                        },
                        border: {
                            display: false,
                            dash: [4, 4]
                        },
                        ticks: {
                            color: textColor(),
                            font: {
                                size: 11
                            },
                            callback: v => '₦' + (v >= 1000 ? (v / 1000) + 'K' : v)
                        }
                    }
                }
            }
        });

        /* ─── Donut Chart ─── */
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Organic', 'Direct', 'Social', 'Referral'],
                datasets: [{
                    data: [38, 24, 21, 17],
                    backgroundColor: ['#3b82f6', '#60a5fa', '#34d399', '#f87171'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: isDark() ? '#1f2937' : '#fff',
                        titleColor: isDark() ? '#e5e7eb' : '#111',
                        bodyColor: textColor(),
                        borderColor: isDark() ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.parsed}%`
                        }
                    }
                }
            }
        });

        /* ─── Sparkline ─── */
        const sparkCtx = document.getElementById('sparklineChart').getContext('2d');
        const sparkGrad = sparkCtx.createLinearGradient(0, 0, 0, 55);
        sparkGrad.addColorStop(0, 'rgba(59, 130, 246,0.20)');
        sparkGrad.addColorStop(1, 'rgba(59, 130, 246,0.00)');

        new Chart(sparkCtx, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Today'],
                datasets: [{
                    data: @json($sparklineData),
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    backgroundColor: sparkGrad,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: textColor(),
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
