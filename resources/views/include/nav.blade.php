@php
    $navCategories = \App\Models\Category::roots()->active()->with('children')->get();
@endphp
<nav class="fixed top-0 left-0 right-0 z-50 px-6 md:px-12 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <!-- Mobile Hamburger Button -->
        <button class="md:hidden -ml-2 p-1.5 opacity-70 hover:opacity-100 transition-opacity"
            onclick="toggleMobileMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <a href="{{ route('shop.home') ?? '#' }}" class="font-display text-2xl font-bold tracking-tight flex items-center">
            @if(!empty($settings['logo']))
                <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? config('app.name') }}" class="h-10 w-auto">
            @else
                {{ $settings['site_name'] ?? config('app.name') }}
            @endif
        </a>
    </div>

    <div class="hidden md:flex items-center gap-8 text-sm font-medium relative">
        <a href="{{ route('shop.products') }}" class="opacity-70 hover:opacity-100 transition-opacity">Shop</a>

        @foreach($navCategories as $cat)
        <div class="group relative py-4 -my-4">
            <a href="{{ route('shop.category', $cat->slug) }}" class="opacity-70 group-hover:opacity-100 flex items-center gap-1 transition-opacity">
                {{ $cat->name }}
                @if($cat->children->count() > 0)
                <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                @endif
            </a>
            @if($cat->children->count() > 0)
            <div
                class="absolute top-full left-0 mt-0 w-48 bg-cream dark:bg-bark border border-sand dark:border-[#404040]/50 shadow-xl rounded-2xl py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-50">
                @foreach($cat->children as $child)
                <a href="{{ route('shop.category', $child->slug) }}"
                    class="block px-5 py-2 text-sm opacity-80 hover:opacity-100 hover:bg-sand/50 dark:hover:bg-black/20 hover:text-rust dark:hover:text-clay transition-colors">{{ $child->name }}</a>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach

        <a href="{{ route('shop.track.form') }}" class="opacity-70 hover:opacity-100 transition-opacity">Track Order</a>
        <a href="{{ route('page.about') }}" class="opacity-70 hover:opacity-100 transition-opacity">About Us</a>
    </div>

    <div class="flex items-center gap-4">
        <!-- Search -->
        <div class="hidden md:flex items-center">
            <form action="{{ route('shop.search') }}" method="GET">
                <input type="text" name="q" placeholder="Search…" value="{{ request('q') }}"
                    class="search-input text-sm px-4 py-1.5 rounded-full w-36 focus:w-48 transition-all duration-300 font-body"
                    id="searchInput" />
            </form>
        </div>

        <!-- Dark mode toggle -->
        <div class="toggle-track" onclick="toggleDark()" title="Toggle dark mode">
            <div class="toggle-thumb"></div>
        </div>

        <!-- Wishlist -->
        @php
            $navUserId = auth()->id();
            if (!session()->has('wishlist_session_active')) {
                session()->put('wishlist_session_active', true);
            }
            $navSessionId = hash('sha256', session()->getId());
            
            $navWQuery = \App\Models\Wishlist::query();
            if($navUserId) {
                $navWQuery->where('user_id', $navUserId);
            } else {
                $navWQuery->where('session_id', $navSessionId);
            }
            $navWishlistCount = $navWQuery->count();
        @endphp
        <a href="{{ route('wishlist.index') }}" class="relative p-1.5 opacity-70 hover:opacity-100 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                stroke-width="1.7" viewBox="0 0 24 24">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
            <span id="wishlistCount" class="cart-count {{ $navWishlistCount > 0 ? '' : 'hidden' }}">{{ $navWishlistCount }}</span>
        </a>

        <!-- Cart -->
        <button class="relative p-1.5 opacity-70 hover:opacity-100 transition-opacity" onclick="toggleCart()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                stroke-width="1.7" viewBox="0 0 24 24">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <path d="M16 10a4 4 0 0 1-8 0" />
            </svg>
            <span id="cartCount" class="cart-count hidden">0</span>
        </button>
    </div>
</nav>

<!-- Mobile Menu Drawer -->
<div id="mobileMenu"
    class="fixed inset-0 z-40 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col pt-24 px-6 pb-8 overflow-y-auto w-full"
    style="background:var(--cart-bg, #F7F3EE);">
    <div class="flex flex-col gap-6 text-xl font-medium">
        <a href="#collections" onclick="toggleMobileMenu()"
            class="opacity-80 hover:opacity-100 hover:text-rust transition-colors border-b border-bark/10 dark:border-cream/10 pb-4">Shop</a>

        @foreach($navCategories as $cat)
        <div class="space-y-4">
            @if($cat->children->count() > 0)
                <button onclick="toggleMobileDropdown('catDrop_{{ $cat->id }}', 'catIcon_{{ $cat->id }}')"
                    class="w-full flex items-center justify-between text-xl font-medium opacity-80 hover:opacity-100 hover:text-rust transition-colors py-2 border-b border-bark/10 dark:border-cream/10">
                    {{ $cat->name }}
                    <svg id="catIcon_{{ $cat->id }}" class="w-4 h-4 transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="catDrop_{{ $cat->id }}" class="hidden grid-cols-2 gap-3 pb-2 transition-all">
                    @foreach($cat->children as $child)
                    <a href="{{ route('shop.category', $child->slug) }}" onclick="toggleMobileMenu()"
                        class="block text-base opacity-80 hover:opacity-100 hover:text-rust px-4 py-2 bg-black/5 dark:bg-white/5 rounded-xl transition-colors">{{ $child->name }}</a>
                    @endforeach
                </div>
            @else
                <a href="{{ route('shop.category', $cat->slug) }}" onclick="toggleMobileMenu()"
                    class="block w-full text-xl font-medium opacity-80 hover:opacity-100 hover:text-rust transition-colors py-2 border-b border-bark/10 dark:border-cream/10">
                    {{ $cat->name }}
                </a>
            @endif
        </div>
        @endforeach

        <a href="{{ route('shop.track.form') }}" onclick="toggleMobileMenu()"
            class="opacity-80 hover:opacity-100 hover:text-rust transition-colors pb-4">Track Order</a>
        <a href="#" onclick="toggleMobileMenu()"
            class="opacity-80 hover:opacity-100 hover:text-rust transition-colors pb-4">About Us</a>
    </div>
</div>

<script>
    function toggleMobileDropdown(id, iId) {
        const drop = document.getElementById(id);
        const icon = document.getElementById(iId);
        if (drop.classList.contains('hidden')) {
            drop.classList.remove('hidden');
            drop.classList.add('grid');
            icon.classList.add('rotate-180');
        } else {
            drop.classList.add('hidden');
            drop.classList.remove('grid');
            icon.classList.remove('rotate-180');
        }
    }

    let mobileMenuOpen = false;

    function toggleMobileMenu() {
        mobileMenuOpen = !mobileMenuOpen;
        const menu = document.getElementById('mobileMenu');

        // Sync the background color based on current dark mode state
        // Uses the same background variable --cart-bg logic as cart drawer for consistency
        menu.style.setProperty('--cart-bg', document.documentElement.classList.contains('dark') ? '#1A1410' :
            '#F7F3EE');

        if (mobileMenuOpen) {
            menu.classList.remove('-translate-x-full');
            document.body.style.overflow = 'hidden';
        } else {
            menu.classList.add('-translate-x-full');
            document.body.style.overflow = '';
        }
    }
</script>
