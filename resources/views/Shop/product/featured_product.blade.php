<!-- FEATURED PRODUCTS -->
<section id="products" class="py-16 md:py-24 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <div class="section-line mx-auto"></div>
            <h2 class="font-display text-3xl md:text-4xl tracking-tight">Shop The Latest Collections</h2>
        </div>

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
            <!-- Product Grid -->
            <div id="featuredGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach ($featuredProducts as $product)
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
                                        onclick="event.stopPropagation(); toggleWishlist(event, {{ $product->id }})" id="wbtn-{{ $product->id }}">
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
                    View All Products
                </a>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <p class="text-lg font-display">No featured products yet.</p>
                <p class="text-sm mt-2">Mark products as "Featured" in the admin panel to display them here.</p>
            </div>
        @endif
    </div>
</section>
