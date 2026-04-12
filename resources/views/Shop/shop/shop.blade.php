@extends('layouts.shop')

@section('title', 'Shop - ')

@section('content')
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-16">
        <div class="flex flex-col md:flex-row gap-10">

            <!-- Sidebar Filters -->
            <aside class="w-full md:w-1/4 flex-shrink-0 space-y-8 md:pt-12">
                <form id="filterForm" action="{{ route('shop.products') }}" method="GET" class="space-y-8">
                    <!-- Category Filter -->
                    <div>
                        <h3 onclick="toggleFilterSection('filter-category', this)"
                            class="font-display font-medium text-lg uppercase tracking-wide flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-neutral-800 cursor-pointer hover:text-bark dark:hover:text-cream transition-colors">
                            Category
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>
                        <div id="filter-category" class="space-y-3 transition-all duration-300">
                            @php
                                $rootCategories = $categories->where('parent_id', 0)->sortBy('sort');
                            @endphp
                            @foreach ($rootCategories as $category)
                                <div class="category-group">
                                    @php
                                        $subCategories = $categories->where('parent_id', $category->id)->sortBy('sort');
                                        $hasSelectedDescendant = false;
                                        $selectedCats = (array) request('category', []);
                                        foreach ($subCategories as $sc) {
                                            if (in_array($sc->slug, $selectedCats)) {
                                                $hasSelectedDescendant = true;
                                            }
                                            foreach ($categories->where('parent_id', $sc->id) as $ssc) {
                                                if (in_array($ssc->slug, $selectedCats)) {
                                                    $hasSelectedDescendant = true;
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="flex items-center justify-between">
                                        <label class="flex items-center gap-3 cursor-pointer group w-full">
                                            <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                                                class="w-4 h-4 rounded-sm border-gray-300 text-bark focus:ring-bark dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-cream dark:checked:border-cream"
                                                {{ in_array($category->slug, $selectedCats) ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit()">
                                            <span
                                                class="text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-bark dark:group-hover:text-cream transition-colors uppercase font-display tracking-wider">
                                                {{ $category->name }} <span
                                                    class="text-xs text-gray-400">({{ $category->products()->active()->count() }})</span>
                                            </span>
                                        </label>
                                        @if ($subCategories->count() > 0)
                                            <button type="button"
                                                class="ml-2 p-1 text-gray-400 hover:text-bark dark:hover:text-cream focus:outline-none"
                                                onclick="toggleSubcategory('sub-{{ $category->id }}', this)">
                                                <svg class="w-4 h-4 transition-transform duration-200 {{ $hasSelectedDescendant ? 'rotate-180' : '' }}"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Subcategories --}}
                                    @if ($subCategories->count() > 0)
                                        <div id="sub-{{ $category->id }}"
                                            class="{{ $hasSelectedDescendant ? '' : 'hidden' }} pl-6 mt-2 space-y-2 border-l-2 border-gray-100 dark:border-neutral-800 ml-2 mb-3">
                                            @foreach ($subCategories as $subCategory)
                                                <div class="subcategory-group">
                                                    @php
                                                        $subSubCategories = $categories
                                                            ->where('parent_id', $subCategory->id)
                                                            ->sortBy('sort');
                                                        $hasSelectedSubDescendant = false;
                                                        foreach ($subSubCategories as $ssc) {
                                                            if (in_array($ssc->slug, $selectedCats)) {
                                                                $hasSelectedSubDescendant = true;
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="flex items-center justify-between">
                                                        <label class="flex items-center gap-3 cursor-pointer group w-full">
                                                            <input type="checkbox" name="category[]"
                                                                value="{{ $subCategory->slug }}"
                                                                class="w-3.5 h-3.5 rounded-[3px] border-gray-300 text-bark focus:ring-bark dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-cream dark:checked:border-cream"
                                                                {{ in_array($subCategory->slug, $selectedCats) ? 'checked' : '' }}
                                                                onchange="document.getElementById('filterForm').submit()">
                                                            <span
                                                                class="text-[13px] font-medium text-gray-500 dark:text-gray-400 group-hover:text-bark dark:group-hover:text-cream transition-colors">
                                                                {{ $subCategory->name }}
                                                                <span
                                                                    class="text-[10px] text-gray-400 ml-1">({{ $subCategory->products()->active()->count() }})</span>
                                                            </span>
                                                        </label>
                                                        @if ($subSubCategories->count() > 0)
                                                            <button type="button"
                                                                class="ml-2 p-1 text-gray-400 hover:text-bark dark:hover:text-cream focus:outline-none"
                                                                onclick="toggleSubcategory('sub-sub-{{ $subCategory->id }}', this)">
                                                                <svg class="w-3.5 h-3.5 transition-transform duration-200 {{ $hasSelectedSubDescendant ? 'rotate-180' : '' }}"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>

                                                    {{-- Sub-Subcategories --}}
                                                    @if ($subSubCategories->count() > 0)
                                                        <div id="sub-sub-{{ $subCategory->id }}"
                                                            class="{{ $hasSelectedSubDescendant ? '' : 'hidden' }} pl-5 mt-1.5 space-y-1.5 border-l border-gray-100 dark:border-neutral-800 ml-1 mb-2">
                                                            @foreach ($subSubCategories as $subSubCat)
                                                                <label
                                                                    class="flex items-center gap-2.5 cursor-pointer group w-full">
                                                                    <input type="checkbox" name="category[]"
                                                                        value="{{ $subSubCat->slug }}"
                                                                        class="w-3 h-3 rounded-[2px] border-gray-300 text-bark focus:ring-bark dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-cream dark:checked:border-cream"
                                                                        {{ in_array($subSubCat->slug, $selectedCats) ? 'checked' : '' }}
                                                                        onchange="document.getElementById('filterForm').submit()">
                                                                    <span
                                                                        class="text-[12px] font-medium text-gray-400 group-hover:text-bark dark:group-hover:text-cream transition-colors">
                                                                        {{ $subSubCat->name }}
                                                                        <span
                                                                            class="text-[9px] opacity-70 ml-0.5">({{ $subSubCat->products()->active()->count() }})</span>
                                                                    </span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div>
                        <h3 onclick="toggleFilterSection('filter-size', this)"
                            class="font-display font-medium text-lg uppercase tracking-wide flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-neutral-800 cursor-pointer hover:text-bark dark:hover:text-cream transition-colors">
                            Size
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>
                        <div id="filter-size" class="relative transition-all duration-300">
                            <select name="size" onchange="document.getElementById('filterForm').submit()"
                                class="w-full appearance-none bg-transparent border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-gray-300 py-2.5 pl-4 pr-10 text-sm font-display tracking-widest uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-none">
                                <option value="">Any size</option>
                                <option value="s" {{ request('size') == 's' ? 'selected' : '' }}>Small</option>
                                <option value="m" {{ request('size') == 'm' ? 'selected' : '' }}>Medium</option>
                                <option value="l" {{ request('size') == 'l' ? 'selected' : '' }}>Large</option>
                                <option value="xl" {{ request('size') == 'xl' ? 'selected' : '' }}>X-Large</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Color Filter -->
                    <div>
                        <h3 onclick="toggleFilterSection('filter-color', this)"
                            class="font-display font-medium text-lg uppercase tracking-wide flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-neutral-800 cursor-pointer hover:text-bark dark:hover:text-cream transition-colors">
                            Color
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>
                        <div id="filter-color" class="relative transition-all duration-300">
                            <select name="color" onchange="document.getElementById('filterForm').submit()"
                                class="w-full appearance-none bg-transparent border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-gray-300 py-2.5 pl-4 pr-10 text-sm font-display tracking-widest uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-none">
                                <option value="">Any color</option>
                                <option value="black" {{ request('color') == 'black' ? 'selected' : '' }}>Black</option>
                                <option value="white" {{ request('color') == 'white' ? 'selected' : '' }}>White</option>
                                <option value="red" {{ request('color') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="blue" {{ request('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <h3 onclick="toggleFilterSection('filter-price', this)"
                            class="font-display font-medium text-lg uppercase tracking-wide flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-neutral-800 cursor-pointer hover:text-bark dark:hover:text-cream transition-colors">
                            Price
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transition-transform duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>
                        <div id="filter-price" class="relative transition-all duration-300">
                            <select name="price" onchange="document.getElementById('filterForm').submit()"
                                class="w-full appearance-none bg-transparent border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-gray-300 py-2.5 pl-4 pr-10 text-sm font-display tracking-widest uppercase focus:outline-none focus:border-bark dark:focus:border-cream rounded-none">
                                <option value="">Any price</option>
                                <option value="0-50000" {{ request('price') == '0-50000' ? 'selected' : '' }}>Under
                                    ₦50,000</option>
                                <option value="50000-100000" {{ request('price') == '50000-100000' ? 'selected' : '' }}>
                                    ₦50,000 - ₦100,000</option>
                                <option value="100000+" {{ request('price') == '100000+' ? 'selected' : '' }}>Over
                                    ₦100,000</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Main Product Area -->
            <main class="w-full md:w-3/4">

                <!-- Header Section -->
                @if(isset($currentCategory) && $currentCategory->thumbnail)
                    <div class="relative rounded-2xl overflow-hidden mb-10 aspect-[4/1] min-h-[160px] max-h-[260px]">
                        <img src="{{ asset('storage/' . $currentCategory->thumbnail) }}"
                             alt="{{ $currentCategory->name }}"
                             class="absolute inset-0 w-full h-full object-cover object-center" />
                        <div class="absolute inset-0 bg-gradient-to-r from-bark/80 via-bark/50 to-transparent"></div>
                        <div class="relative z-10 h-full flex flex-col justify-end p-6 md:p-10">
                            <div class="text-xs text-cream/70 font-medium tracking-wide uppercase mb-2">
                                <a href="{{ route('shop.home') }}" class="hover:text-cream transition-colors">Home</a> &raquo;
                                <a href="{{ route('shop.products') }}" class="hover:text-cream transition-colors">Shop</a> &raquo;
                                <span class="text-cream">{{ $currentCategory->name }}</span>
                            </div>
                            <h1 class="font-display text-3xl md:text-4xl text-cream">{{ $currentCategory->name }}</h1>
                            @if($currentCategory->description)
                                <p class="text-cream/60 text-sm mt-2 max-w-lg">{{ $currentCategory->description }}</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-6">
                        <div>
                            <h1 class="font-display text-4xl mb-2">
                                {{ isset($currentCategory) ? $currentCategory->name : 'Shop' }}
                            </h1>
                            <div class="text-sm text-gray-500 font-medium tracking-wide uppercase">
                                <a href="{{ route('shop.home') }}"
                                    class="hover:text-bark dark:hover:text-cream transition-colors">Home</a> &raquo;
                                @if(isset($currentCategory))
                                    <a href="{{ route('shop.products') }}"
                                        class="hover:text-bark dark:hover:text-cream transition-colors">Shop</a> &raquo;
                                    <span class="text-gray-900 dark:text-white">{{ $currentCategory->name }}</span>
                                @else
                                    <span class="text-gray-900 dark:text-white">Shop</span>
                                @endif
                            </div>
                        </div>

                     <!-- Sorting Dropdown -->
                    <div class="relative min-w-[200px]">
                        <select
                            class="w-full appearance-none bg-gray-100 dark:bg-neutral-800 border-none text-gray-700 dark:text-gray-300 py-3 pl-5 pr-12 text-xs font-bold font-display tracking-widest uppercase focus:outline-none focus:ring-1 focus:ring-bark dark:focus:ring-cream rounded-sm"
                            onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                                {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Default sorting
                            </option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}"
                                {{ request('sort') == 'price_low' ? 'selected' : '' }}>Sort by price: low to high</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}"
                                {{ request('sort') == 'price_high' ? 'selected' : '' }}>Sort by price: high to low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}"
                                {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by name</option>
                        </select>
                        <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}" form="filterForm">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Product Grid -->
                @if ($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-10">
                        @foreach ($products as $product)
                            <div class="group cursor-pointer relative">
                                <!-- Image Container -->
                                <div onclick="window.location.href='{{ route('shop.product.show', $product->slug) }}'"
                                    class="block relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 aspect-[370/444] mb-4 cursor-pointer">

                                    <!-- Sold Out Badge -->
                                    @if ($product->stock <= 0)
                                        <div
                                            class="absolute top-4 left-0 z-10 bg-gray-400/90 text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1.5 shadow-sm">
                                            Sold Out
                                        </div>
                                    @endif

                                    <!-- Primary Image -->
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-100 {{ $product->hover_image ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}" />
                                    @else
                                        <div
                                            class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-400">
                                            No Image</div>
                                    @endif

                                    <!-- Hover Image -->
                                    @if ($product->hover_image)
                                        <img src="{{ asset('storage/' . $product->hover_image) }}"
                                            alt="{{ $product->name }} Alternate View"
                                            class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-500 opacity-0 group-hover:opacity-100 scale-105" />
                                    @endif

                                    <!-- Quick View Overlay (Optional interaction if you use JS modals) -->
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-bark/90 text-cream text-center py-3 text-xs font-medium tracking-widest uppercase translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
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
                                        <h3
                                            class="font-display text-sm md:text-base font-bold uppercase tracking-wide leading-snug mb-1.5 hover:text-gray-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                    </a>

                                    <!-- Price -->
                                    <div class="text-sm opacity-70 font-medium flex justify-center items-center gap-2">
                                        @if ($product->sale_price && $product->sale_price < $product->price)
                                            <span
                                                class="text-red-500 line-through text-xs">₦{{ number_format($product->price, 2) }}</span>
                                            <span>₦{{ number_format($product->sale_price, 2) }}</span>
                                        @else
                                            <span>₦{{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="mt-14 pt-8 border-t border-gray-100 dark:border-neutral-800">
                            {{ $products->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-20 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-20" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg font-medium">No products found matching your criteria.</p>
                        <p class="mt-2 text-sm text-gray-400">Try adjusting your filters or search terms.</p>
                        <a href="{{ route('shop.products') }}"
                            class="inline-block mt-6 px-6 py-2 border border-bark text-bark hover:bg-bark hover:text-white transition-colors uppercase tracking-widest text-xs font-bold dark:border-cream dark:text-cream dark:hover:bg-cream dark:hover:text-bark rounded-sm">Clear
                            Filters</a>
                    </div>
                @endif

            </main>
        </div>
    </div>
    <script>
        function toggleSubcategory(id, btn) {
            const el = document.getElementById(id);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                btn.querySelector('svg').classList.add('rotate-180');
                localStorage.setItem(id, 'expanded');
            } else {
                el.classList.add('hidden');
                btn.querySelector('svg').classList.remove('rotate-180');
                localStorage.setItem(id, 'collapsed');
            }
        }

        function toggleFilterSection(id, element) {
            const el = document.getElementById(id);
            const svg = element.querySelector('svg');
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                svg.classList.remove('rotate-180');
                localStorage.setItem(id, 'expanded');
            } else {
                el.classList.add('hidden');
                svg.classList.add('rotate-180');
                localStorage.setItem(id, 'collapsed');
            }
        }
    </script>
@endsection
