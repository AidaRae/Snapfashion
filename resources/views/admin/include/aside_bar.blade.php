<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed left-0 top-0 bottom-0 z-30 w-60 bg-white dark:bg-neutral-800 border-r border-gray-100 dark:border-neutral-700 flex flex-col justify-between py-6 px-4 -translate-x-full lg:translate-x-0">
    <div>
        <div class="flex items-center justify-between mb-8 px-2">
            <div class="flex items-center gap-2">
                <svg width="34" height="20" viewBox="0 0 34 20" fill="none">
                    <rect x="0" y="6" width="10" height="10" rx="3" fill="#3b82f6" opacity="0.7" />
                    <rect x="12" y="2" width="10" height="14" rx="3" fill="#3b82f6" />
                    <rect x="24" y="6" width="10" height="10" rx="3" fill="#3b82f6" opacity="0.4" />
                </svg>
                <span style="font-family:'Syne',sans-serif;font-weight:700;"
                    class="text-xl tracking-tight text-brand">{{ $settings['site_name'] ?? config('app.name') }}</span>
            </div>
            <button onclick="closeSidebar()"
                class="lg:hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
        </div>
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700 text-sm">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" fill="currentColor" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" fill="currentColor"
                        opacity=".7" />
                </svg>
                Dashboard
            </a>
            @php
                $isProductRoute = request()->routeIs('admin.products.*') || request()->routeIs('admin.category*');
            @endphp
            <div>
                <button type="button" onclick="toggleDropdown('productsDropdown', 'productsIcon')"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm {{ $isProductRoute ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                    <span class="flex items-center gap-3">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                            <circle cx="12" cy="12" r="3" fill="currentColor" />
                        </svg>
                        Products
                    </span>
                    <svg id="productsIcon"
                        class="transition-transform duration-200 {{ $isProductRoute ? 'rotate-180' : '' }}"
                        width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path d="M6 9l6-6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
                <div id="productsDropdown" class="{{ $isProductRoute ? 'block' : 'hidden' }} ml-8 mt-1 space-y-0.5">
                    <a href="{{ route('admin.products.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.products.*') ? 'text-brand font-semibold dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">Product
                        List</a>
                    <a href="{{ route('admin.category') }}"
                        class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.category*') ? 'text-brand font-semibold dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">Categories</a>
                </div>
            </div>
            <a href="{{ route('admin.orders') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.orders') || request()->routeIs('admin.order.*') ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path d="M3 17l4-8 4 4 4-6 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Orders
            </a>
            <a href="{{ route('admin.sales.index') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.sales.index') ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path d="M3 3v18h18M7 15l4-4 4 4 6-6" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Sales
            </a>
            <a href="{{ route('admin.customers') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700 text-sm">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" />
                    <path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2M16 3.13a4 4 0 010 7.75M21 21v-2a4 4 0 00-3-3.87"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                Customers
            </a>


            <a href="{{ route('admin.stocks.index') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.stocks.*') ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" fill="none" />
                </svg>
                Stocks
            </a>
            <a href="{{ route('admin.notifications.index') }}" onclick="closeSidebar()"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.notifications.*') ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                    <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
                Notifications
            </a>
            @php
                $isSettingsRoute = request()->routeIs('admin.settings.*');
            @endphp
            <div>
                <button type="button" onclick="toggleDropdown('settingsDropdown', 'settingsIcon')"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm {{ $isSettingsRoute ? 'nav-active text-brand' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">
                    <span class="flex items-center gap-3">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"
                                stroke="currentColor" stroke-width="2" />
                        </svg>
                        Settings
                    </span>
                    <svg id="settingsIcon"
                        class="transition-transform duration-200 {{ $isSettingsRoute ? 'rotate-180' : '' }}"
                        width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path d="M6 9l6-6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div id="settingsDropdown" class="{{ $isSettingsRoute ? 'block' : 'hidden' }} ml-8 mt-1 space-y-0.5">
                    <a href="{{ route('admin.settings.website') }}"
                        class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.website') ? 'text-brand font-semibold dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">Web & Shipping</a>
                    <a href="{{ route('admin.settings.payment') }}"
                        class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.payment') ? 'text-brand font-semibold dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">Payment</a>
                    <a href="{{ route('admin.settings.email') }}"
                        class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.email*') ? 'text-brand font-semibold dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700' }}">Email</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="space-y-2">
        <div class="flex items-center justify-between px-3 py-2">
            <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Dark mode</span>
            <div class="toggle-track" onclick="toggleTheme()">
                <div class="toggle-thumb"></div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-700 text-sm w-full">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                    <polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" />
                </svg>
                Log out
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleDropdown(dropdownId, iconId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);

        dropdown.classList.toggle('hidden');
        if (dropdown.classList.contains('hidden')) {
            icon.classList.remove('rotate-180');
        } else {
            icon.classList.add('rotate-180');
        }
    }
</script>
