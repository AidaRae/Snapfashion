@extends('layouts.shop')

@section('title', 'Your Wishlist - ')

@section('content')
    <div class="max-w-6xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-36 md:pb-16 min-h-[60vh]">
        {{-- Page Header --}}
        <div class="mb-10 text-center md:text-left">
            <h1 class="font-display text-4xl mb-3 text-bark dark:text-cream">Your Wishlist</h1>
            <p class="text-gray-600 dark:text-gray-400">Curated pieces you love. Come back anytime to make them yours.</p>
        </div>

        @if($wishlists->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-gray-300 dark:border-neutral-700 rounded-2xl">
                <div class="w-20 h-20 mb-6 bg-gray-50 dark:bg-neutral-800 rounded-full flex items-center justify-center text-gray-400">
                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-display font-medium text-bark dark:text-cream mb-2">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-6">Hit the heart icon on any product to save it here.</p>
                <a href="{{ route('shop.products') }}" class="btn-primary rounded-full px-8 py-3 text-sm font-medium tracking-wide">
                    Explore Shop
                </a>
            </div>
        @else
            {{-- Wishlist Table (Desktop) --}}
            <div class="hidden md:block wishlist-table-wrap" style="animation: fadeUp 0.5s ease forwards;">
                <table class="w-full border-collapse" id="wishlistTable">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-neutral-700">
                            <th class="py-4 px-4 text-left text-xs font-body font-semibold uppercase tracking-[0.15em] text-bark/70 dark:text-cream/70" style="width:55%">Product</th>
                            <th class="py-4 px-4 text-left text-xs font-body font-semibold uppercase tracking-[0.15em] text-bark/70 dark:text-cream/70" style="width:18%">Price</th>
                            <th class="py-4 px-4 text-left text-xs font-body font-semibold uppercase tracking-[0.15em] text-bark/70 dark:text-cream/70" style="width:15%">Stock Status</th>
                            <th class="py-4 px-4 text-right text-xs font-body font-semibold uppercase tracking-[0.15em] text-bark/70 dark:text-cream/70" style="width:12%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $wishlist)
                            @php $p = $wishlist->product; @endphp
                            @if($p)
                                <tr class="wishlist-row border-b border-gray-100 dark:border-neutral-800 transition-all duration-300 hover:bg-sand/30 dark:hover:bg-neutral-800/40" data-product-id="{{ $p->id }}">
                                    {{-- Remove + Product Image + Name --}}
                                    <td class="py-5 px-4">
                                        <div class="flex items-center gap-5">
                                            {{-- Remove button --}}
                                            <button type="button"
                                                    class="wishlist-remove-btn flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-gray-400 hover:text-rust hover:bg-rust/10 transition-all duration-200 text-sm"
                                                    onclick="removeFromWishlistPage({{ $p->id }}, this)"
                                                    title="Remove from wishlist">
                                                ✕
                                            </button>

                                            {{-- Product Image --}}
                                            <a href="{{ route('shop.product.show', $p->slug) }}" class="flex-shrink-0 rounded-lg overflow-hidden bg-sand dark:bg-neutral-800" style="width:80px; height:80px;">
                                                @if($p->image)
                                                    <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" loading="lazy"/>
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    </div>
                                                @endif
                                            </a>

                                            {{-- Product Name --}}
                                            <div class="min-w-0">
                                                <a href="{{ route('shop.product.show', $p->slug) }}" class="font-display text-base leading-snug text-bark dark:text-cream hover:text-rust dark:hover:text-clay transition-colors duration-200 uppercase tracking-wide">
                                                    {{ $p->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Price --}}
                                    <td class="py-5 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-body text-[15px] font-medium text-bark dark:text-cream">₦{{ number_format($p->effective_price, 2) }}</span>
                                            @if($p->sale_price && $p->sale_price < $p->price)
                                                <span class="text-xs text-gray-400 line-through mt-0.5">₦{{ number_format($p->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Stock Status --}}
                                    <td class="py-5 px-4">
                                        @if($p->stock > 0)
                                            <span class="inline-flex items-center text-sm font-body font-medium text-bark dark:text-cream uppercase tracking-wide">
                                                In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-sm font-body font-medium text-gray-400 uppercase tracking-wide">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Select Options Button --}}
                                    <td class="py-5 px-4 text-right">
                                        @if($p->stock > 0)
                                            <a href="{{ route('shop.product.show', $p->slug) }}"
                                               class="btn-primary inline-flex items-center gap-2 px-6 py-2.5 rounded text-xs font-body font-medium uppercase tracking-[0.12em]">
                                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                                </svg>
                                                Select options
                                            </a>
                                        @else
                                            <span class="inline-block px-6 py-2.5 rounded text-xs font-body font-medium uppercase tracking-[0.12em] bg-gray-200 dark:bg-neutral-700 text-gray-400 dark:text-neutral-500 cursor-not-allowed">
                                                Sold Out
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Wishlist Cards (Mobile) --}}
            <div class="md:hidden space-y-4" id="wishlistMobile">
                @foreach($wishlists as $wishlist)
                    @php $p = $wishlist->product; @endphp
                    @if($p)
                        <div class="wishlist-card-mobile border border-gray-200 dark:border-neutral-700 rounded-xl p-4 transition-all duration-300" data-product-id="{{ $p->id }}" style="animation: fadeUp 0.5s ease 0.1s forwards; opacity:0;">
                            <div class="flex gap-4">
                                {{-- Remove Button --}}
                                <button type="button"
                                        class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-gray-400 hover:text-rust transition-colors text-xs self-start mt-1"
                                        onclick="removeFromWishlistPage({{ $p->id }}, this)"
                                        title="Remove from wishlist">
                                    ✕
                                </button>

                                {{-- Product Image --}}
                                <a href="{{ route('shop.product.show', $p->slug) }}" class="flex-shrink-0 rounded-lg overflow-hidden bg-sand dark:bg-neutral-800" style="width:72px; height:72px;">
                                    @if($p->image)
                                        <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover" loading="lazy"/>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </a>

                                {{-- Product Info --}}
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('shop.product.show', $p->slug) }}" class="font-display text-sm leading-snug text-bark dark:text-cream uppercase tracking-wide block mb-1.5">
                                        {{ $p->name }}
                                    </a>
                                    <div class="text-sm font-medium text-bark dark:text-cream mb-1">₦{{ number_format($p->effective_price, 2) }}</div>
                                    <div class="text-xs uppercase tracking-wide {{ $p->stock > 0 ? 'text-bark dark:text-cream' : 'text-gray-400' }}">
                                        {{ $p->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Select Options Button --}}
                            <div class="mt-3 pl-10">
                                @if($p->stock > 0)
                                    <a href="{{ route('shop.product.show', $p->slug) }}"
                                       class="btn-primary inline-flex items-center gap-2 px-5 py-2 rounded text-xs font-body font-medium uppercase tracking-[0.12em] w-full justify-center">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                        </svg>
                                        Select options
                                    </a>
                                @else
                                    <span class="inline-block px-5 py-2 rounded text-xs font-body font-medium uppercase tracking-[0.12em] bg-gray-200 dark:bg-neutral-700 text-gray-400 dark:text-neutral-500 text-center w-full">
                                        Sold Out
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Continue Shopping Link --}}
            <div class="mt-10 text-center">
                <a href="{{ route('shop.products') }}" class="inline-flex items-center gap-2 text-sm font-body font-medium text-bark/60 dark:text-cream/60 hover:text-rust dark:hover:text-clay transition-colors duration-200 uppercase tracking-wide">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <style>
        /* Wishlist table styles */
        .wishlist-table-wrap {
            background: rgba(247, 243, 238, 0.5);
            border-radius: 16px;
            padding: 8px;
            border: 1px solid rgba(232, 221, 208, 0.6);
        }

        .dark .wishlist-table-wrap {
            background: rgba(44, 34, 24, 0.3);
            border-color: rgba(44, 34, 24, 0.6);
        }

        .wishlist-row td {
            vertical-align: middle;
        }

        .wishlist-row:last-child {
            border-bottom: none;
        }

        /* Subtle hover glow on remove button */
        .wishlist-remove-btn:hover {
            box-shadow: 0 0 0 4px rgba(181, 82, 42, 0.08);
        }

        /* Mobile card subtle shadow */
        .wishlist-card-mobile {
            background: rgba(247, 243, 238, 0.5);
        }

        .dark .wishlist-card-mobile {
            background: rgba(44, 34, 24, 0.3);
        }
    </style>

    <script>
        /**
         * Remove a product from the wishlist page with proper AJAX handling.
         */
        async function removeFromWishlistPage(productId, btn) {
            // Find the correct parent element (row or mobile card)
            const row = btn.closest('.wishlist-row') || btn.closest('.wishlist-card-mobile');

            // Visual feedback immediately
            if (row) {
                row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                row.style.opacity = '0.4';
                row.style.pointerEvents = 'none';
            }

            try {
                const res = await fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (data.status === 'removed') {
                    // Animate out and remove
                    if (row) {
                        row.style.opacity = '0';
                        row.style.transform = row.classList.contains('wishlist-row')
                            ? 'translateX(-20px)'
                            : 'scale(0.95)';
                        row.style.maxHeight = row.offsetHeight + 'px';

                        setTimeout(() => {
                            row.style.maxHeight = '0';
                            row.style.padding = '0';
                            row.style.margin = '0';
                            row.style.overflow = 'hidden';

                            setTimeout(() => {
                                row.remove();

                                // Update global wishlist state
                                if (typeof wishlist !== 'undefined') {
                                    wishlist = wishlist.filter(x => x !== productId);
                                }

                                // Update wishlist count badge
                                const wc = document.getElementById('wishlistCount');
                                if (wc && data.count !== undefined) {
                                    wc.textContent = data.count;
                                    wc.classList.toggle('hidden', data.count === 0);
                                }

                                // If table is now empty, reload to show empty state
                                const table = document.getElementById('wishlistTable');
                                const mobile = document.getElementById('wishlistMobile');
                                const tableEmpty = table && table.querySelector('tbody').children.length === 0;
                                const mobileEmpty = mobile && mobile.children.length === 0;

                                if (tableEmpty || mobileEmpty) {
                                    location.reload();
                                }
                            }, 300);
                        }, 250);
                    }

                    if (typeof showToast === 'function') {
                        showToast(data.message);
                    }
                } else {
                    // Unexpected response — restore
                    if (row) {
                        row.style.opacity = '1';
                        row.style.pointerEvents = '';
                    }
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Something went wrong');
                    }
                }
            } catch (err) {
                // Network error — restore and show message
                if (row) {
                    row.style.opacity = '1';
                    row.style.pointerEvents = '';
                }
                if (typeof showToast === 'function') {
                    showToast('Failed to update wishlist. Please try again.');
                }
            }
        }
    </script>
@endsection