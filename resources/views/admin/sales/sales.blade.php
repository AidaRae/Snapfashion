@extends('layouts.admin')

@section('title', 'Sales Analytics')

@section('admin')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto printable-area">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8 no-print">
        <div>
            <h1 class="text-2xl sm:text-3xl tracking-tight text-gray-900 dark:text-white font-bold mb-1"
                style="font-family:'Syne',sans-serif;">
                Sales Analytics
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Track your revenue, analyze trends, and export sales reports.
            </p>
        </div>
        <button onclick="window.print()"
                class="add-btn inline-flex items-center justify-center gap-2 w-full sm:w-auto shrink-0">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 14h12v8H6v-8z"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Print Report
        </button>
    </div>

    {{-- ===== PRINT-ONLY HEADER ===== --}}
    <div class="hidden print-only mb-8 text-center">
        <h1 class="text-3xl font-bold">Sales Report — {{ config('app.name') }}</h1>
        <p class="text-gray-500 mt-1">Generated on {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">

        {{-- Revenue --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 sm:p-6
                    border border-gray-100 dark:border-neutral-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 shrink-0 rounded-xl
                            bg-green-500/10 dark:bg-green-500/20
                            flex items-center justify-center
                            text-green-600 dark:text-green-400">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"
                              stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium truncate">
                        Total Revenue
                    </p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate"
                        style="font-family:'Syne',sans-serif;">
                        ${{ number_format($totalRevenue, 2) }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 sm:p-6
                    border border-gray-100 dark:border-neutral-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 shrink-0 rounded-xl
                            bg-blue-500/10 dark:bg-blue-500/20
                            flex items-center justify-center
                            text-blue-600 dark:text-blue-400">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                              stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium truncate">
                        Total Sales
                    </p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate"
                        style="font-family:'Syne',sans-serif;">
                        {{ number_format($totalOrders) }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Avg Order Value --}}
        <div class="bg-white dark:bg-neutral-800 rounded-2xl p-5 sm:p-6
                    border border-gray-100 dark:border-neutral-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 sm:w-12 sm:h-12 shrink-0 rounded-xl
                            bg-blue-500/10 dark:bg-blue-500/20
                            flex items-center justify-center text-brand">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"
                              stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium truncate">
                        Avg. Order Value
                    </p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate"
                        style="font-family:'Syne',sans-serif;">
                        ${{ number_format($averageOrderValue, 2) }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== SALES CHART ===== --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl
                border border-gray-100 dark:border-neutral-700 shadow-sm mb-8 overflow-hidden">
        <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-neutral-700">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                Revenue Over Time (12 Months)
            </h2>
        </div>
        {{-- Horizontal scroll wrapper so chart never squishes below 480px --}}
        <div class="p-4 sm:p-6 overflow-x-auto -webkit-overflow-scrolling-touch">
            <div class="relative h-64 sm:h-80 lg:h-96" style="min-width:460px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== RECENT TRANSACTIONS TABLE ===== --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl
                border border-gray-100 dark:border-neutral-700 shadow-sm overflow-hidden mb-8">

        <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-neutral-700">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                Recent Transactions
            </h2>
        </div>

        {{-- ── DESKTOP TABLE (hidden on mobile) ── --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-neutral-800/50
                               border-b border-gray-100 dark:border-neutral-700
                               text-xs uppercase tracking-wider
                               text-gray-500 dark:text-gray-400 font-medium">
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Total Amount</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 no-print text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-neutral-700/50 text-sm">
                    @forelse($recentSales as $order)
                    <tr class="row-hover">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            #{{ $order->tracking_code ?? $order->id }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                            {{ $order->user
                                ? $order->user->first_name . ' ' . $order->user->last_name
                                : ($order->guest_name ?? 'Guest') }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $order->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 no-print text-right">
                            <a href="{{ route('admin.order.details', $order->id ?? 1) }}"
                               class="text-brand hover:text-brand-light font-medium">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-10 h-10 text-gray-300 dark:text-neutral-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 12H4M8 16l-4-4 4-4"/>
                                </svg>
                                <p>No sales recorded yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── MOBILE CARD LIST (visible only on mobile) ── --}}
        <div class="sm:hidden divide-y divide-gray-100 dark:divide-neutral-700/50">
            @forelse($recentSales as $order)
            <div class="px-4 py-4 flex flex-col gap-2">

                {{-- Row 1: Order ID + Amount --}}
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        #{{ $order->tracking_code ?? $order->id }}
                    </span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                        ${{ number_format($order->total_amount, 2) }}
                    </span>
                </div>

                {{-- Row 2: Customer --}}
                <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-300">
                    <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ $order->user
                        ? $order->user->first_name . ' ' . $order->user->last_name
                        : ($order->guest_name ?? 'Guest') }}
                </div>

                {{-- Row 3: Date + View link --}}
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        {{ $order->created_at->format('M d, Y · h:i A') }}
                    </span>
                    <a href="{{ route('admin.order.details', $order->id ?? 1) }}"
                       class="text-xs font-semibold text-brand hover:text-brand-light
                              px-3 py-1 rounded-lg bg-brand/5 hover:bg-brand/10 transition-colors">
                        View →
                    </a>
                </div>

            </div>
            @empty
            <div class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-10 h-10 text-gray-300 dark:text-neutral-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 12H4M8 16l-4-4 4-4"/>
                    </svg>
                    <p class="text-sm">No sales recorded yet.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($recentSales->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-neutral-700
                    bg-gray-50/50 dark:bg-neutral-800/50 no-print">
            {{ $recentSales->links() }}
        </div>
        @endif

    </div>{{-- /transactions card --}}

</div>{{-- /page wrapper --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = {!! json_encode($labels) !!};
    const data   = {!! json_encode($salesData) !!};

    const ctx      = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.45)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Revenue ($)',
                data,
                backgroundColor: gradient,
                borderColor: '#3b82f6',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    titleFont: { family: "'DM Sans', sans-serif", size: 12 },
                    bodyFont:  { family: "'DM Sans', sans-serif", size: 13, weight: 'bold' },
                    displayColors: false,
                    callbacks: {
                        label: ctx => '$' + ctx.parsed.y.toLocaleString(),
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: {
                        font: { family: "'DM Sans', sans-serif", size: 11 },
                        maxRotation: 45,   /* rotate labels on small screens */
                        autoSkip: true,
                        maxTicksLimit: 12,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.1)', drawBorder: false },
                    ticks: {
                        font: { family: "'DM Sans', sans-serif", size: 11 },
                        callback: v => '$' + v.toLocaleString(),
                        maxTicksLimit: 6,
                    },
                },
            },
        },
    });
});
</script>

<style>
/* ── Print styles ─────────────────────────────────────── */
@media print {
    body { background:#fff !important; color:#000 !important; margin:0; padding:0; }

    #sidebar, .admin-header, header, nav, .no-print { display:none !important; }

    .dark * { color:#000 !important; border-color:#ddd !important; }

    .lg\:ml-60 { margin-left:0 !important; }

    .print-only { display:block !important; }

    .sm\:hidden { display:none !important; }   /* hide mobile cards on print */

    canvas { max-width:100%; }

    @page { margin:1.5cm; size:auto; }
}

/* ── Mobile card hover/active state ──────────────────── */
@media (max-width:639px) {
    /* Smooth tap highlight for mobile rows */
    .sm\:hidden > div:active {
        background-color: rgba(59, 130, 246, 0.04);
    }
}
</style>
@endpush