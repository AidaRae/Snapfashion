<!-- Topbar -->
<header
    class="bg-white dark:bg-neutral-800 border-b border-gray-100 dark:border-neutral-700 sticky top-0 z-10 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-3">
    <div class="flex items-center gap-3">
        <button onclick="openSidebar()"
            class="lg:hidden text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-1 -ml-1">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                <path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
        <h1 style="font-family:'Syne',sans-serif;font-weight:700;"
            class="text-xl sm:text-2xl text-gray-800 dark:text-gray-100 tracking-tight">{{ $title ?? 'Dashboard' }}</h1>
    </div>  
    <div class="flex items-center gap-2 sm:gap-3">
        <div
            class="hidden sm:flex items-center gap-2 bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 rounded-xl px-3 py-2 w-44 md:w-56">
            <svg class="text-gray-400 flex-shrink-0" width="14" height="14" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <input type="text" placeholder="Search…"
                class="bg-transparent text-sm text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 outline-none w-full"
                oninput="handleSearch(this.value)">
        </div>
        <button class="sm:hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
        <div class="relative group" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="relative text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none flex items-center justify-center p-1 rounded-full hover:bg-gray-100 dark:hover:bg-neutral-700 transition">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                    <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                @if(auth('admin')->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-neutral-800 rounded-full"></span>
                @endif
            </button>

            <!-- Dropdown -->
            <div x-show="open" style="display: none;" 
                 class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gray-100 dark:border-neutral-700 overflow-hidden z-50">
                <div class="p-4 border-b border-gray-100 dark:border-neutral-700 flex items-center justify-between bg-gray-50/50 dark:bg-neutral-800/50">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                    <div class="flex items-center gap-3">
                        @if(auth('admin')->user()->unreadNotifications->count() > 0)
                            <span class="text-xs font-medium text-brand bg-brand/10 px-2 py-0.5 rounded-full">{{ auth('admin')->user()->unreadNotifications->count() }} new</span>
                        @endif
                        <a href="{{ route('admin.notifications.index') }}" class="text-xs text-gray-500 hover:text-brand transition-colors">View All</a>
                    </div>
                </div>
                
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-neutral-700/50">
                    @forelse(auth('admin')->user()->notifications()->take(5)->get() as $notification)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-neutral-700/30 transition-colors {{ is_null($notification->read_at) ? 'bg-brand/5 dark:bg-brand/10' : '' }}">
                            <div class="flex gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5
                                    {{ $notification->data['type'] == 'new_payment' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : '' }}
                                    {{ $notification->data['type'] == 'payment_failure' ? 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400' : '' }}
                                    {{ $notification->data['type'] == 'new_order' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400' : '' }}
                                    {{ $notification->data['type'] == 'new_customer' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400' : '' }}
                                ">
                                    @if($notification->data['type'] == 'new_payment')
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @elseif($notification->data['type'] == 'payment_failure')
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @elseif($notification->data['type'] == 'new_order')
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $notification->data['title'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</span>
                                        <div class="flex items-center gap-2">
                                            @if($notification->data['url'] ?? false)
                                                <a href="{{ $notification->data['url'] }}" class="text-xs font-medium text-brand hover:underline">View Details</a>
                                            @endif
                                            @if(is_null($notification->read_at))
                                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Mark Read</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center flex flex-col items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-neutral-800 flex items-center justify-center text-gray-400 mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">All caught up!</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Check back later for new notifications.</p>
                        </div>
                    @endforelse
                </div>
                
                @if(auth('admin')->user()->unreadNotifications->count() > 0)
                    <div class="p-3 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-800/50 text-center">
                        <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-medium text-gray-600 dark:text-gray-300 hover:text-brand transition-colors w-full text-center">
                                Mark all as read
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.profile') }}" title="My Profile"
            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-br from-blue-400 to-brand flex items-center justify-center text-white font-semibold text-sm cursor-pointer select-none flex-shrink-0 hover:ring-2 hover:ring-brand/40 transition-shadow">
            {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}</a>
        <!-- Theme toggle in topbar for mobile -->
        <div class="lg:hidden toggle-track" onclick="toggleTheme()">
            <div class="toggle-thumb"></div>
        </div>
    </div>
</header>
