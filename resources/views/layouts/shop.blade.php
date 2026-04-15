<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (!empty($settings['description']))
        <meta name="description" content="{{ $settings['description'] }}">
    @endif
    @if (!empty($settings['keywords']))
        <meta name="keywords" content="{{ $settings['keywords'] }}">
    @endif
    @if (!empty($settings['meta_author']))
        <meta name="author" content="{{ $settings['meta_author'] }}">
    @endif
    <title>{{ $settings['site_title'] ?? config('app.name') }}</title>
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endif
    {!! $settings['custom_header_code'] ?? '' !!}
    @if (!empty($settings['google_analytics']))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $settings['google_analytics'] }}');
        </script>
    @endif
    @if (!empty($settings['facebook_pixel']))
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $settings['facebook_pixel'] }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $settings['facebook_pixel'] }}&ev=PageView&noscript=1" /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif
    <script>
        // Apply saved theme immediately to prevent flash
        (function() {
            const saved = localStorage.getItem('snapfashion_dark');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = saved !== null ? saved === 'true' : prefersDark;
            document.documentElement.classList.toggle('dark', isDark);
            document.documentElement.classList.toggle('light', !isDark);
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Jost:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Bodoni Moda"', 'serif'],
                        body: ['Jost', 'sans-serif'],
                    },
                    colors: {
                        cream: '#F7F3EE',
                        bark: '#2C2218',
                        clay: '#C4A882',
                        sage: '#8A9E8C',
                        rust: '#B5522A',
                        sand: '#E8DDD0',
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease forwards',
                        'fade-in': 'fadeIn 0.4s ease forwards',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': {
                                opacity: 0,
                                transform: 'translateY(24px)'
                            },
                            '100%': {
                                opacity: 1,
                                transform: 'translateY(0)'
                            },
                        },
                        fadeIn: {
                            '0%': {
                                opacity: 0
                            },
                            '100%': {
                                opacity: 1
                            },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Jost', sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: '"Bodoni Moda"', serif;
        }

        /* Light mode */
        .light body,
        body {
            background: #F7F3EE;
            color: #2C2218;
        }

        /* Dark mode */
        .dark body {
            background: #1A1410;
            color: #E8DDD0;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .btn-primary {
            background: #2C2218;
            color: #F7F3EE;
            transition: background 0.25s, transform 0.2s;
        }

        .dark .btn-primary {
            background: #E8DDD0;
            color: #1A1410;
        }

        .btn-primary:hover {
            background: #B5522A;
            transform: scale(1.03);
        }

        .dark .btn-primary:hover {
            background: #C4A882;
        }

        .tag {
            font-size: 0.68rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        /* Nav */
        nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .light nav {
            background: rgba(247, 243, 238, 0.85);
            border-bottom: 1px solid #E8DDD0;
        }

        .dark nav {
            background: rgba(26, 20, 16, 0.88);
            border-bottom: 1px solid #2C2218;
        }

        /* Toggle */
        .toggle-track {
            width: 48px;
            height: 26px;
            border-radius: 999px;
            transition: background 0.3s;
            position: relative;
            cursor: pointer;
        }

        .light .toggle-track {
            background: #2C2218;
        }

        .dark .toggle-track {
            background: #C4A882;
        }

        .toggle-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #F7F3EE;
            position: absolute;
            top: 3px;
            left: 3px;
            transition: transform 0.3s;
        }

        .dark .toggle-thumb {
            transform: translateX(22px);
            background: #1A1410;
        }

        /* Hero */
        .hero-bg {
            background: linear-gradient(135deg, #EDE6DB 0%, #D9CDBE 50%, #C4B8A8 100%);
        }

        .dark .hero-bg {
            background: linear-gradient(135deg, #2C2218 0%, #1F1A14 50%, #141009 100%);
        }

        .product-img-wrap {
            overflow: hidden;
            border-radius: 12px;
            aspect-ratio: 3/4;
            background: #E8DDD0;
        }

        .dark .product-img-wrap {
            background: #2C2218;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card-hover:hover .product-img-wrap img {
            transform: scale(1.07);
        }

        /* Skeleton loader shimmer */
        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #e8ddd0 25%, #f0e8df 50%, #e8ddd0 75%);
            background-size: 800px 100%;
            animation: shimmer 1.5s infinite;
        }

        .dark .shimmer {
            background: linear-gradient(90deg, #2C2218 25%, #3a2f25 50%, #2C2218 75%);
            background-size: 800px 100%;
        }

        .stagger-1 {
            animation-delay: 0.05s;
            opacity: 0;
        }

        .stagger-2 {
            animation-delay: 0.15s;
            opacity: 0;
        }

        .stagger-3 {
            animation-delay: 0.25s;
            opacity: 0;
        }

        .stagger-4 {
            animation-delay: 0.35s;
            opacity: 0;
        }

        .stagger-5 {
            animation-delay: 0.45s;
            opacity: 0;
        }

        .stagger-6 {
            animation-delay: 0.55s;
            opacity: 0;
        }

        .badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 500;
        }

        .badge-new {
            background: #2C2218;
            color: #F7F3EE;
        }

        .dark .badge-new {
            background: #E8DDD0;
            color: #1A1410;
        }

        .badge-sale {
            background: #B5522A;
            color: #fff;
        }

        .rating {
            color: #C4A882;
        }

        .filter-btn {
            border: 1px solid #C4A882;
            transition: background 0.2s, color 0.2s;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: #2C2218;
            color: #F7F3EE;
            border-color: #2C2218;
        }

        .dark .filter-btn.active,
        .dark .filter-btn:hover {
            background: #E8DDD0;
            color: #1A1410;
            border-color: #E8DDD0;
        }

        .cart-count {
            background: #B5522A;
            color: #fff;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -6px;
            right: -6px;
        }

        .section-line {
            width: 48px;
            height: 2px;
            background: #C4A882;
            margin-bottom: 16px;
        }

        .testimonial-card {
            border-left: 3px solid #C4A882;
        }

        footer {
            border-top: 1px solid #E8DDD0;
        }

        .dark footer {
            border-top: 1px solid #2C2218;
        }

        /* Notification toast */
        #toast {
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.35s ease, opacity 0.35s ease;
            pointer-events: none;
        }

        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Search bar */
        .search-input {
            border: 1px solid #C4A882;
            background: transparent;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #B5522A;
            box-shadow: 0 0 0 3px rgba(181, 82, 42, 0.12);
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        .overlay-wishlist {
            opacity: 0;
            transition: opacity 0.25s;
        }

        .card-hover:hover .overlay-wishlist {
            opacity: 1;
        }
    </style>
</head>

<body class="min-h-screen">

    @include('include.nav')

    @yield('content')

    @include('include.footer')

    @include('Shop.Cart.cart')

    <script>
        @php
            $wUserId = auth()->id();

            if (!session()->has('wishlist_session_active')) {
                session()->put('wishlist_session_active', true);
            }
            $wSessionId = hash('sha256', session()->getId());

            $wQuery = \App\Models\Wishlist::query();
            if ($wUserId) {
                $wQuery->where('user_id', $wUserId);
            } else {
                $wQuery->where('session_id', $wSessionId);
            }
            $wishlistArray = $wQuery->pluck('product_id')->toArray();
        @endphp

        // ── State ──
        let darkMode = document.documentElement.classList.contains('dark');
        let wishlist = {!! json_encode($wishlistArray) !!};
        let cartOpen = false;
        let activeFilter = 'All';
        const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        function fmt(n) {
            return '₦' + Number(n).toLocaleString();
        }

        // ── Server-Synced Cart Functions ──

        async function addToCart(productId, quantity = 1, size = null, color = null) {
            try {
                const bodyObj = {
                    quantity: quantity
                };
                if (size) bodyObj.size = size;
                if (color) bodyObj.color = color;

                const res = await fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(bodyObj)
                });
                const data = await res.json();
                if (data.success) {
                    renderCartDrawer(data.cart);
                    showToast(data.message);
                    if (!cartOpen) {
                        toggleCart();
                        setTimeout(() => {
                            if (cartOpen) toggleCart();
                        }, 3000);
                    }
                } else {
                    showToast(data.message || 'Failed to add to cart');
                }
            } catch (err) {
                console.error('addToCart error:', err);
                showToast('Failed to add to cart');
            }
        }

        async function removeFromCart(rowId) {
            try {
                const res = await fetch(`/cart/remove/${rowId}`, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    renderCartDrawer(data.cart);
                    showToast(data.message);
                }
            } catch (err) {
                showToast('Failed to remove item');
            }
        }

        function renderCartDrawer(cartData) {
            const cc = document.getElementById('cartCount');
            if (cc) {
                cc.textContent = cartData.count;
                cc.classList.toggle('hidden', cartData.count === 0);
            }
            const totalEl = document.getElementById('cartTotal');
            if (totalEl) totalEl.textContent = fmt(cartData.subtotal);

            const items = document.getElementById('cartItems');
            if (!items) return;

            if (!cartData.items || cartData.items.length === 0) {
                items.innerHTML = '<p class="text-sm opacity-50 text-center mt-8">Your cart is empty.</p>';
                return;
            }

            items.innerHTML = '';
            cartData.items.forEach(item => {
                const el = document.createElement('div');
                el.className = 'flex gap-3 items-start';
                const imgSrc = item.image || '';
                const sizeHtml = item.size ?
                    `<span class="text-[10px] opacity-60 ml-1 bg-bark/5 dark:bg-cream/5 px-1.5 py-0.5 rounded">Size: ${item.size.toUpperCase()}</span>` :
                    '';
                const colorHtml = item.color ?
                    `<span class="text-[10px] opacity-60 ml-1 bg-bark/5 dark:bg-cream/5 px-1.5 py-0.5 rounded">Color: ${item.color}</span>` :
                    '';

                el.innerHTML = `
                    ${imgSrc ? `<img src="${imgSrc}" class="w-16 h-20 object-cover rounded-lg flex-shrink-0"/>` : '<div class="w-16 h-20 bg-gray-100 dark:bg-neutral-800 rounded-lg flex-shrink-0"></div>'}
                    <div class="flex-1 min-w-0">
                        <div class="font-display text-sm leading-tight">${item.name} ${sizeHtml} ${colorHtml}</div>
                        <div class="text-xs opacity-50 mt-0.5">${fmt(item.price)} × ${item.quantity}</div>
                        <div class="text-xs font-semibold mt-1">${fmt(item.subtotal)}</div>
                    </div>
                    <button onclick="removeFromCart('${item.row_id}')" class="text-xs opacity-40 hover:opacity-100 mt-1">✕</button>
                `;
                items.appendChild(el);
            });
        }

        async function loadCart() {
            try {
                const res = await fetch('/cart/data', {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                renderCartDrawer(data);
            } catch (err) {}
        }

        function toggleCart() {
            cartOpen = !cartOpen;
            const drawer = document.getElementById('cartDrawer');
            const ov = document.getElementById('overlay');
            drawer.style.setProperty('--cart-bg', darkMode ? '#1A1410' : '#F7F3EE');
            drawer.style.background = darkMode ? '#1A1410' : '#F7F3EE';
            drawer.classList.toggle('translate-x-full', !cartOpen);
            ov.classList.toggle('hidden', !cartOpen);
        }

        // ── Wishlist ──

        async function toggleWishlist(e, id) {
            e.stopPropagation();
            const btn = document.getElementById('wbtn-' + id);
            const isAdding = !wishlist.includes(id);

            // Optimistic UI
            if (isAdding) {
                wishlist.push(id);
                if (btn) btn.innerHTML = '<span style="color:#B5522A;">♥</span>';
            } else {
                wishlist = wishlist.filter(x => x !== id);
                if (btn) {
                    btn.innerHTML = '♡';
                    btn.style.color = '';
                }
            }

            const wc = document.getElementById('wishlistCount');
            if (wc) {
                wc.textContent = wishlist.length;
                wc.classList.toggle('hidden', wishlist.length === 0);
            }

            try {
                const res = await fetch(`/wishlist/toggle/${id}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                showToast(data.message);
            } catch (err) {
                // Revert on error
                if (isAdding) {
                    wishlist = wishlist.filter(x => x !== id);
                    if (btn) {
                        btn.innerHTML = '♡';
                        btn.style.color = '';
                    }
                } else {
                    wishlist.push(id);
                    if (btn) btn.innerHTML = '<span style="color:#B5522A;">♥</span>';
                }
                if (wc) {
                    wc.textContent = wishlist.length;
                    wc.classList.toggle('hidden', wishlist.length === 0);
                }
                showToast('Failed to update wishlist');
            }
        }

        // ── Utilities ──

        function showToast(msg) {
            const t = document.getElementById('toast');
            const tm = document.getElementById('toastMsg');
            if (!t || !tm) return;
            tm.textContent = msg;
            t.style.background = darkMode ? '#E8DDD0' : '#2C2218';
            t.style.color = darkMode ? '#1A1410' : '#F7F3EE';
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2500);
        }

        function toggleDark() {
            darkMode = !darkMode;
            document.documentElement.classList.toggle('dark', darkMode);
            document.documentElement.classList.toggle('light', !darkMode);
            localStorage.setItem('snapfashion_dark', darkMode);
        }

        function checkout() {
            window.location.href = '/checkout';
        }

        function handleNewsletter() {
            const email = document.querySelector('input[type=email]');
            if (!email || !email.value || !email.value.includes('@')) {
                showToast('Enter a valid email');
                return;
            }
            showToast('Welcome to the inner circle ✦');
            email.value = '';
        }

        // ── Init ──

        loadCart();

        document.addEventListener('DOMContentLoaded', () => {
            // Hydrate wishlist icons
            if (typeof wishlist !== 'undefined' && Array.isArray(wishlist)) {
                wishlist.forEach(id => {
                    const btn = document.getElementById('wbtn-' + id);
                    if (btn) btn.innerHTML = '<span style="color:#B5522A; margin-top:-2px;">♥</span>';
                });
            }
        });
    </script>


</body>

</html>
