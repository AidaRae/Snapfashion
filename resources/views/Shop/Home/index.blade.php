@extends('layouts.shop')

@section('content')
    <!-- HERO SLIDER -->
    <section class="relative w-full h-screen md:h-[120vh] xl:h-[130vh] overflow-hidden bg-bark pt-20">
        <!-- Slider Container -->
        <div id="heroSlider"
            class="absolute inset-0 w-full h-full flex transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)]">
            @php
                $slides = [
                    'images/slide/D5CC2195-BCB4-414C-B831-76A85F24519C.jpg',
                    'images/slide/DC510544-133C-4451-B407-B3ED15BCD489.jpg',
                    'images/slide/DE0088DF-68C0-4DFF-8913-23FE13BC1939.jpg',
                    'images/slide/F0F3044D-4617-46E2-A339-BE86CEF034CA.jpg',
                    'images/slide/IMG_7636.jpg',
                ];
            @endphp

            @foreach ($slides as $index => $slide)
                <div class="relative w-full h-full flex-shrink-0">
                    <div class="absolute inset-0 bg-black/30 z-10"></div>
                    <img src="{{ asset($slide) }}" alt="Slide {{ $index + 1 }}"
                        class="w-full h-full object-cover object-center" />

                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button id="sliderPrevBtn"
            class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/50 text-white backdrop-blur-md transition-all border border-white/10 group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="sliderNextBtn"
            class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/50 text-white backdrop-blur-md transition-all border border-white/10 group">
            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            @foreach ($slides as $index => $slide)
                <button id="dot-{{ $index }}"
                    class="w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/40' }}"></button>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('heroSlider');
            if (!container) return;

            let current = 0;
            const total = {{ count($slides) }};
            let slideInterval;

            function goTo(idx) {
                current = idx;
                container.style.transform = `translateX(-${current * 100}%)`;
                for (let i = 0; i < total; i++) {
                    const dot = document.getElementById(`dot-${i}`);
                    if (!dot) continue;
                    if (i === current) {
                        dot.className = 'w-2.5 h-2.5 rounded-full transition-all duration-300 bg-white scale-125';
                    } else {
                        dot.className = 'w-2.5 h-2.5 rounded-full transition-all duration-300 bg-white/40';
                    }
                }
            }

            function next() {
                goTo((current + 1) % total);
                resetInterval();
            }

            function prev() {
                goTo((current - 1 + total) % total);
                resetInterval();
            }

            function resetInterval() {
                clearInterval(slideInterval);
                slideInterval = setInterval(next, 5000);
            }

            document.getElementById('sliderNextBtn').addEventListener('click', next);
            document.getElementById('sliderPrevBtn').addEventListener('click', prev);

            @foreach ($slides as $index => $slide)
                const dot{{ $index }} = document.getElementById('dot-{{ $index }}');
                if (dot{{ $index }}) dot{{ $index }}.addEventListener('click', () => {
                    goTo({{ $index }});
                    resetInterval();
                });
            @endforeach

            slideInterval = setInterval(next, 5000);
        });
    </script>

    <!-- CATEGORY STRIP -->
    <section id="collections" class="py-24 md:py-32 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="section-line"></div>
            <h2 class="font-display text-3xl mb-16">Shop by Category</h2>
            @if(isset($categories) && $categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach($categories->where('parent_id', 0)->take(6) as $category)
                        <a href="{{ route('shop.category', $category->slug) }}"
                           class="group cursor-pointer relative overflow-hidden rounded-2xl aspect-square card-hover block">
                            @if($category->thumbnail)
                                <img src="{{ asset('storage/' . $category->thumbnail) }}"
                                     alt="{{ $category->name }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-bark/40 to-bark/80 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-bark/70 to-transparent flex items-end p-6">
                                <div>
                                    <div class="font-display text-white text-2xl">{{ $category->name }}</div>
                                    <div class="text-xs text-clay mt-1">
                                        {{ $category->products_count ?? $category->products()->active()->count() }} {{ Str::plural('Product', $category->products_count ?? $category->products()->active()->count()) }} · Shop Now
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-400">
                    <p class="text-lg font-display">No categories yet.</p>
                    <p class="text-sm mt-2">Add categories in the admin panel to display them here.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    @include('Shop.product.featured_product')

    <!-- NEW ARRIVALS / LATEST PRODUCTS -->
    @if(isset($latestProducts) && $latestProducts->count() > 0)
    <section id="new-arrivals" class="py-16 md:py-24 px-6 md:px-12 bg-gray-50/50 dark:bg-neutral-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <div class="section-line mx-auto"></div>
                <h2 class="font-display text-3xl md:text-4xl tracking-tight">New Arrivals</h2>
                <p class="text-sm text-gray-500 mt-3">The latest additions to our collection</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach ($latestProducts as $product)
                    <div class="group cursor-pointer">
                        <!-- Image Container -->
                        <div onclick="window.location.href='{{ route('shop.product.show', $product->slug) }}'" class="block relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 aspect-[370/444] mb-4 cursor-pointer">
                            <!-- Primary Image -->
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-100 {{ $product->hover_image ? 'group-hover:opacity-0' : '' }}" />
                            @else
                                <div class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-400">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            <!-- Hover Image -->
                            @if($product->hover_image)
                                <img src="{{ asset('storage/' . $product->hover_image) }}" alt="{{ $product->name }} Alternate View"
                                    class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-0 group-hover:opacity-100 scale-105" />
                            @endif

                            <!-- Sold Out Badge -->
                            @if($product->stock <= 0)
                                <div class="absolute top-3 left-0 z-10 bg-gray-400/90 text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1.5">Sold Out</div>
                            @endif

                            <!-- Quick View Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 bg-bark/90 text-cream text-center py-3 text-xs font-medium tracking-widest uppercase translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Quick View
                            </div>

                            <!-- Action Buttons -->
                            <div class="absolute top-4 right-4 flex flex-col gap-2.5 z-20 transition-all duration-300 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:translate-x-4 lg:group-hover:translate-x-0">
                                <!-- Wishlist Button -->
                                <button type="button" class="bg-white/95 dark:bg-neutral-800/95 rounded-full w-10 h-10 flex items-center justify-center text-gray-800 dark:text-gray-200 shadow-md hover:bg-bark hover:text-white dark:hover:bg-cream dark:hover:text-bark transition-colors"
                                        onclick="event.stopPropagation(); toggleWishlist(event, {{ $product->id }})" id="wbtn-latest-{{ $product->id }}">
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                </button>

                                <!-- Quick Cart Button -->
                                <a href="{{ route('shop.product.show', $product->slug) }}" class="bg-white/95 dark:bg-neutral-800/95 rounded-full w-10 h-10 flex items-center justify-center text-gray-800 dark:text-gray-200 shadow-md hover:bg-bark hover:text-white dark:hover:bg-cream dark:hover:text-bark transition-colors"
                                        onclick="event.stopPropagation();">
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z" /></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="text-center">
                            <a href="{{ route('shop.product.show', $product->slug) }}">
                                <h3 class="font-display text-sm md:text-base font-bold uppercase tracking-wide leading-snug mb-1.5 hover:text-gray-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <div class="text-sm opacity-70 font-medium">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="text-red-500 line-through text-xs mr-1">₦{{ number_format($product->price, 2) }}</span>
                                    <span>₦{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span>₦{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center mt-14">
                <a href="{{ route('shop.products') }}"
                    class="inline-block bg-bark dark:bg-cream text-cream dark:text-bark font-display text-sm font-bold tracking-widest uppercase px-10 py-4 rounded-sm hover:opacity-80 transition-opacity">
                    Browse All Products
                </a>
            </div>
        </div>
    </section>
    @endif






    <!-- BANNER -->
    <section class="my-16 mx-6 md:mx-12 rounded-3xl overflow-hidden relative" style="background:#2C2218;min-height:260px;">
        <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=1200&q=80" alt="Banner"
            class="absolute inset-0 w-full h-full object-cover opacity-30" />
        <div class="relative z-10 max-w-7xl mx-auto px-8 py-16 flex flex-wrap items-center justify-between gap-8">
            <div>
                <span class="tag text-clay mb-3 block">Limited Time</span>
                <h2 class="font-display text-4xl md:text-5xl text-cream">Up to 40% Off<br />Selected Pieces</h2>
                <p class="text-sand opacity-70 mt-3 text-sm">Ends April 15th — no code needed.</p>
            </div>
            <a href="#products"
                class="bg-clay text-bark font-medium px-8 py-4 rounded-full text-sm hover:bg-rust hover:text-white transition-colors">Shop
                the Sale</a>
        </div>
    </section>

    <!-- NEWSLETTER -->
    <section class="py-16 px-6 md:px-12">
        <div class="max-w-xl mx-auto text-center">
            <div class="section-line mx-auto"></div>
            <h2 class="font-display text-3xl mb-3">The Inner Circle</h2>
            <p class="opacity-60 text-sm mb-8">Early access to our latest collections — straight to
                your inbox.</p>
            <div class="flex gap-2 max-w-sm mx-auto">
                <input type="email" placeholder="your@email.com"
                    class="search-input flex-1 px-5 py-3 rounded-full text-sm font-body" />
                <button class="btn-primary px-6 py-3 rounded-full text-sm font-medium font-body whitespace-nowrap"
                    onclick="handleNewsletter()">Join</button>
            </div>
        </div>
    </section>
@endsection
