@extends('layouts.shop')

@section('title', $product->name . ' - ')

@section('content')
<div class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-16">

    <!-- Breadcrumbs -->
    <div class="text-sm text-gray-500 font-medium tracking-wide uppercase mb-10">
        <a href="{{ route('shop.home') }}" class="hover:text-bark dark:hover:text-cream transition-colors">Home</a> &raquo;
        <a href="{{ route('shop.products') }}" class="hover:text-bark dark:hover:text-cream transition-colors">Shop</a>
        @if($product->category)
            &raquo; <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-bark dark:hover:text-cream transition-colors">{{ $product->category->name }}</a>
        @endif
    </div>

    <!-- Product Detail Row -->
    <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">

        <!-- LEFT: Product Image -->
        <div class="w-full lg:w-1/2 flex-shrink-0">
            <div class="group relative overflow-hidden bg-gray-50 dark:bg-neutral-900 aspect-square">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-500 opacity-100 {{ $product->hover_image ? 'group-hover:opacity-0' : '' }}" id="mainImage" />
                @else
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-300">
                        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                @if($product->hover_image)
                    <img src="{{ asset('storage/' . $product->hover_image) }}" alt="{{ $product->name }} Alternate View" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-500 opacity-0 group-hover:opacity-100" />
                @endif

                @if($product->stock <= 0)
                    <div class="absolute top-6 left-0 z-10 bg-gray-400/90 text-white text-xs font-bold tracking-widest uppercase px-4 py-2">Sold Out</div>
                @endif
            </div>

            {{-- Thumbnail strip --}}
            @if($product->image && $product->hover_image)
                <div class="flex gap-3 mt-4">
                    <button class="w-20 h-20 border-2 border-bark dark:border-cream overflow-hidden transition-all hover:opacity-80" onclick="swapMainImage('{{ asset('storage/' . $product->image) }}')">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="Primary">
                    </button>
                    <button class="w-20 h-20 border-2 border-transparent hover:border-bark dark:hover:border-cream overflow-hidden opacity-60 hover:opacity-100 transition-all" onclick="swapMainImage('{{ asset('storage/' . $product->hover_image) }}')">
                        <img src="{{ asset('storage/' . $product->hover_image) }}" class="w-full h-full object-cover" alt="Hover">
                    </button>
                </div>
            @endif
        </div>

        <!-- RIGHT: Product Info -->
        <div class="w-full lg:w-1/2">

            {{-- Product Name --}}
            <h1 class="font-display text-2xl md:text-3xl font-bold uppercase tracking-tight leading-tight mb-4">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="mb-6">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-2xl font-medium"><span class="line-through text-gray-400">₦{{ number_format($product->price, 2) }}</span></span>
                    <span class="text-2xl font-medium ml-2">₦{{ number_format($product->sale_price, 2) }}</span>
                @else
                    <span class="text-2xl font-medium"><span class="line-through decoration-1">₦</span>{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            {{-- Short Description --}}
            @if($product->description)
                <div class="text-sm text-gray-600 dark:text-gray-400 font-display tracking-wider uppercase leading-relaxed mb-8">
                    {!! nl2br(e(strip_tags($product->description))) !!}
                </div>
            @endif

            {{-- Size Selector --}}
            @if(!empty($product->sizes) && is_array($product->sizes))
            <div class="mb-5">
                <label class="block text-xs font-display font-bold uppercase tracking-[0.2em] text-gray-700 dark:text-gray-300 mb-3">Size</label>
                <div class="relative">
                    <select id="sizeSelector" class="w-full appearance-none bg-transparent border border-gray-300 dark:border-neutral-600 text-gray-900 dark:text-gray-200 py-3 pl-5 pr-12 text-sm font-display tracking-wider uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-none">
                        <option value="" class="bg-white dark:bg-neutral-900 text-gray-900 dark:text-gray-200">Choose an Option</option>
                        @foreach($product->sizes as $size)
                            <option value="{{ strtolower($size) }}" class="bg-white dark:bg-neutral-900 text-gray-900 dark:text-gray-200">{{ $size }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            @endif

            {{-- Color Selector --}}
            @if(!empty($product->colors) && is_array($product->colors))
            <div class="mb-6">
                <label class="block text-xs font-display font-bold uppercase tracking-[0.2em] text-gray-700 dark:text-gray-300 mb-3">Color</label>
                <div class="relative">
                    <select id="colorSelector" class="w-full appearance-none bg-transparent border border-gray-300 dark:border-neutral-600 text-gray-900 dark:text-gray-200 py-3 pl-5 pr-12 text-sm font-display tracking-wider uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-none">
                        <option value="" class="bg-white dark:bg-neutral-900 text-gray-900 dark:text-gray-200">Choose an Option</option>
                        @foreach($product->colors as $color)
                            <option value="{{ strtolower($color) }}" class="bg-white dark:bg-neutral-900 text-gray-900 dark:text-gray-200">{{ $color }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            @endif
            {{-- Quantity + Add to Cart --}}
            @if($product->stock > 0 && $product->is_purchasable)
                <div class="mb-5">
                    <div class="flex items-stretch gap-0">
                        {{-- Qty Selector --}}
                        <div class="flex items-center border border-gray-300 dark:border-neutral-600">
                            <button type="button" class="px-4 py-3.5 text-lg font-light opacity-60 hover:opacity-100 transition-opacity leading-none" onclick="changeQty(-1)">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->max_purchase_qty ?? $product->stock }}" class="w-12 text-center border-x border-gray-300 dark:border-neutral-600 bg-transparent py-3.5 text-sm font-medium focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" id="qtyInput">
                            <button type="button" class="px-4 py-3.5 text-lg font-light opacity-60 hover:opacity-100 transition-opacity leading-none" onclick="changeQty(1)">+</button>
                        </div>

                        {{-- Add to Cart Button --}}
                        <button type="button" onclick="handleAddCart(this)" data-id="{{ $product->id }}" class="flex items-center justify-center gap-3 bg-bark dark:bg-neutral-800 text-cream font-display text-xs font-bold tracking-[0.2em] uppercase py-3.5 px-10 hover:opacity-80 transition-opacity ml-3">
                            Add To Cart
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                        </button>
                    </div>
                </div>
            @else
                <div class="mb-5">
                    <button disabled class="w-full bg-gray-300 text-gray-500 font-display text-xs font-bold tracking-[0.2em] uppercase py-3.5 px-8 cursor-not-allowed">Out of Stock</button>
                </div>
            @endif

            {{-- Wishlist + Compare --}}
            <div class="flex items-stretch gap-3 mb-8">
                <button type="button" onclick="toggleWishlist(event, {{ $product->id }})" class="flex items-center justify-center gap-3 border border-gray-300 dark:border-neutral-600 text-gray-700 dark:text-gray-300 font-display text-xs font-bold tracking-[0.15em] uppercase py-3 px-6 hover:border-bark dark:hover:border-cream hover:text-bark dark:hover:text-cream transition-colors flex-1">
                    Add to wishlist
                    <span id="wbtn-{{ $product->id }}" class="text-xl leading-none" style="margin-top:-2px;">♡</span>
                </button>
                <button class="flex items-center justify-center border border-gray-300 dark:border-neutral-600 text-gray-700 dark:text-gray-300 py-3 px-4 hover:border-bark dark:hover:border-cream hover:text-bark dark:hover:text-cream transition-colors">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l-4-4m0 0l4-4m-4 4h11a4 4 0 010 8h-1" /></svg>
                </button>
            </div>

            {{-- SKU / Categories / Share --}}
            <div class="space-y-2 text-sm font-display tracking-wider uppercase mb-6 pt-6 border-t border-gray-200 dark:border-neutral-700">
                @if($product->sku)
                    <p class="text-gray-600 dark:text-gray-400">
                        <span class="font-bold text-gray-800 dark:text-gray-200">SKU:</span> {{ $product->sku }}
                    </p>
                @else
                    <p class="text-gray-600 dark:text-gray-400">
                        <span class="font-bold text-gray-800 dark:text-gray-200">SKU:</span> N/A
                    </p>
                @endif
                @if($product->category)
                    <p class="text-gray-600 dark:text-gray-400">
                        <span class="font-bold text-gray-800 dark:text-gray-200">Categories:</span>
                        <a href="{{ route('shop.category', $product->category->slug) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $product->category->name }}</a>
                    </p>
                @endif
            </div>

            {{-- Share Icons --}}
            <div class="flex items-center gap-4 text-sm font-display tracking-wider uppercase text-gray-600 dark:text-gray-400">
                <span class="font-bold text-gray-800 dark:text-gray-200">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-300 dark:border-neutral-600 flex items-center justify-center hover:border-bark dark:hover:border-cream hover:text-bark dark:hover:text-cream transition-colors text-xs font-bold">f</a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-300 dark:border-neutral-600 flex items-center justify-center hover:border-bark dark:hover:border-cream hover:text-bark dark:hover:text-cream transition-colors text-xs font-bold">𝕏</a>
                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($product->name) }}" target="_blank" class="w-8 h-8 rounded-full border border-gray-300 dark:border-neutral-600 flex items-center justify-center hover:border-bark dark:hover:border-cream hover:text-bark dark:hover:text-cream transition-colors text-xs font-bold">P</a>
            </div>
        </div>
    </div>

    <!-- Tabs: Description / Additional Information / Reviews -->
    <div class="mt-16 pt-10 border-t border-gray-200 dark:border-neutral-700">

        {{-- Tab Headers --}}
        <div class="flex justify-center gap-10 mb-8">
            <button class="tab-btn text-sm font-display font-bold tracking-[0.15em] uppercase pb-3 border-b-2 border-bark dark:border-cream text-bark dark:text-cream transition-colors" data-tab="description" onclick="switchTab('description')">Description</button>
            <button class="tab-btn text-sm font-display font-bold tracking-[0.15em] uppercase pb-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" data-tab="additional" onclick="switchTab('additional')">Additional Information</button>
            <button class="tab-btn text-sm font-display font-bold tracking-[0.15em] uppercase pb-3 border-b-2 border-transparent text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" data-tab="reviews" onclick="switchTab('reviews')">Reviews (0)</button>
        </div>

        <div class="border-t border-gray-200 dark:border-neutral-700 pt-8">

            {{-- Description Tab --}}
            <div id="tab-description" class="tab-content">
                @if($product->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-display tracking-wider uppercase leading-relaxed max-w-3xl mx-auto text-center">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                @else
                    <p class="text-sm text-gray-400 text-center font-display tracking-wider uppercase">No description available.</p>
                @endif
            </div>

            {{-- Additional Information Tab --}}
            <div id="tab-additional" class="tab-content hidden">
                <table class="w-full max-w-xl mx-auto text-sm font-display tracking-wider">
                    @if($product->unit)
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <td class="py-3 font-bold uppercase text-gray-700 dark:text-gray-300">Unit</td>
                            <td class="py-3 text-gray-600 dark:text-gray-400 uppercase">{{ $product->unit }}</td>
                        </tr>
                    @endif
                    <tr class="border-b border-gray-100 dark:border-neutral-800">
                        <td class="py-3 font-bold uppercase text-gray-700 dark:text-gray-300">Stock</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400 uppercase">{{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}</td>
                    </tr>
                    @if($product->is_refundable)
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <td class="py-3 font-bold uppercase text-gray-700 dark:text-gray-300">Refundable</td>
                            <td class="py-3 text-gray-600 dark:text-gray-400 uppercase">Yes</td>
                        </tr>
                    @endif
                </table>
            </div>

            {{-- Reviews Tab --}}
            <div id="tab-reviews" class="tab-content hidden">
                <p class="text-sm text-gray-400 text-center font-display tracking-wider uppercase">There are no reviews yet.</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16 pt-10 border-t border-gray-200 dark:border-neutral-700">
            <div class="text-center mb-12">
                <h2 class="font-display text-2xl md:text-3xl font-bold uppercase tracking-tight">Related Products</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                @foreach($relatedProducts as $related)
                    <div class="group cursor-pointer">
                        <a href="{{ route('shop.product.show', $related->slug) }}" class="block relative overflow-hidden bg-gray-50 dark:bg-neutral-900 aspect-[370/444] mb-4">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-100 {{ $related->hover_image ? 'group-hover:opacity-0' : '' }}" />
                            @endif
                            @if($related->hover_image)
                                <img src="{{ asset('storage/' . $related->hover_image) }}" alt="{{ $related->name }} Alternate" class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-0 group-hover:opacity-100 scale-105" />
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 bg-bark/90 text-cream text-center py-3 text-xs font-medium tracking-widest uppercase translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                View Details
                            </div>
                        </a>
                        <div class="text-center">
                            <h3 class="font-display text-sm font-bold uppercase tracking-wide leading-snug mb-1.5">{{ $related->name }}</h3>
                            <p class="text-sm opacity-70 font-medium">₦{{ number_format($related->sale_price && $related->sale_price < $related->price ? $related->sale_price : $related->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>


<script>
    function changeQty(delta) {
        const input = document.getElementById('qtyInput');
        if (!input) return;
        let val = parseInt(input.value || '1') + delta;
        const max = parseInt(input.getAttribute('max')) || 999;
        const min = parseInt(input.getAttribute('min')) || 1;
        if (val < min) val = min;
        if (val > max) val = max;
        input.value = val;
    }

   function handleAddCart(btn) {
    const id = btn.getAttribute('data-id');
    const qtyInput = document.getElementById('qtyInput');
    const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;

    const sizeSelect = document.getElementById('sizeSelector');
    let size = null;
    if (sizeSelect) {
        if (sizeSelect.value === "") {
            if (typeof showToast === 'function') { showToast('Please select a size first'); } else { alert('Please select a size first'); }
            return;
        }
        size = sizeSelect.value;
    }

    const colorSelect = document.getElementById('colorSelector');
    let color = null;
    if (colorSelect) {
        if (colorSelect.value === "") {
            if (typeof showToast === 'function') { showToast('Please select a color first'); } else { alert('Please select a color first'); }
            return;
        }
        color = colorSelect.value;
    }

    if (typeof addToCart === 'function') {
        // addToCart may need to be updated to accept color
        addToCart(id, qty, size, color);
    } else {
        console.error('addToCart function not found');
    }
}

    function swapMainImage(src) {
        const img = document.getElementById('mainImage');
        if (img) img.src = src;
    }

    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(function(el) { el.classList.add('hidden'); });
        document.getElementById('tab-' + tabName).classList.remove('hidden');

        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('border-bark', 'dark:border-cream', 'text-bark', 'dark:text-cream');
            btn.classList.add('border-transparent', 'text-gray-400');
        });
        var activeBtn = document.querySelector('.tab-btn[data-tab="' + tabName + '"]');
        activeBtn.classList.remove('border-transparent', 'text-gray-400');
        activeBtn.classList.add('border-bark', 'dark:border-cream', 'text-bark', 'dark:text-cream');
    }
</script>
@endsection
