<!-- BOTTOM NAV (mobile only) -->
<nav id="bottomNav"
    class="fixed bottom-0 left-0 right-0 z-20 lg:hidden bg-white/90 dark:bg-neutral-800/90 border-t border-gray-200 dark:border-neutral-700 flex items-center justify-around px-2 py-2">
    <a href="{{ route('admin.dashboard') }}"
        class="flex flex-col items-center gap-0.5 px-3 py-1 text-gray-400 dark:text-gray-500">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7" />
            <rect x="14" y="3" width="7" height="7" rx="1.5" fill="currentColor" />
            <rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor" />
            <rect x="14" y="14" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7" />
        </svg>
        <span class="text-[10px] font-medium">Home</span>
    </a>
    <a href="{{ route('admin.products.index') }}"
        class="flex flex-col items-center gap-0.5 px-3 py-1 text-brand dark:text-blue-400">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
            <circle cx="12" cy="12" r="3" fill="currentColor" />
        </svg>
        <span class="text-[10px] font-semibold">Products</span>
    </a>
    <a href="{{ route('admin.sales.index') }}"
        class="flex flex-col items-center gap-0.5 px-3 py-1 {{ request()->routeIs('admin.sales.index') ? 'text-brand dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
            <path d="M3 17l4-8 4 4 4-6 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span class="text-[10px] font-medium">Sales</span>
    </a>
    <a href="{{ route('admin.stocks.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-1 text-gray-400 dark:text-gray-500">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" fill="none" />
        </svg>
        <span class="text-[10px] font-medium">Stocks</span>
    </a>

</nav>
