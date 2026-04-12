@extends('layouts.admin')
@section('title', 'Stocks Management')

@section('admin')
<main class="flex-1 w-full flex flex-col pt-20 lg:pt-0">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 style="font-family:'Syne',sans-serif;font-weight:700;" class="text-3xl tracking-tight text-gray-900 dark:text-white mb-2">
                    Stocks <span class="text-gray-400 dark:text-gray-500 font-medium tracking-normal text-xl ml-2">{{ $totalProducts }} items</span>
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Keep track of your product inventory and manage low stock alerts.</p>
            </div>
            
            <div class="flex gap-3">
                <form action="{{ route('admin.stocks.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                        class="pl-10 pr-4 py-2 border border-gray-200 dark:border-neutral-700 rounded-xl text-sm bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand focus:border-transparent outline-none w-64 transition-all">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button type="submit" class="hidden">Search</button>
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 p-4 rounded-xl text-sm flex items-center justify-between border border-emerald-100 dark:border-emerald-500/20">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.stocks.index') }}" class="relative bg-white dark:bg-neutral-800 p-5 rounded-2xl border {{ !request('status') ? 'border-brand ring-1 ring-brand' : 'border-gray-200 dark:border-neutral-700' }} hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer block overflow-hidden">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase overflow-hidden text-ellipsis whitespace-nowrap">All Products</p>
                        <h2 style="font-family:'Syne',sans-serif;font-weight:700;" class="text-3xl text-gray-900 dark:text-white mt-1">{{ $totalProducts }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-500/10 text-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('admin.stocks.index', ['status' => 'low_stock', 'search' => request('search')]) }}" class="relative bg-white dark:bg-neutral-800 p-5 rounded-2xl border {{ request('status') == 'low_stock' ? 'border-amber-500 ring-1 ring-amber-500' : 'border-gray-200 dark:border-neutral-700' }} hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer block overflow-hidden">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-amber-500 dark:text-amber-400 uppercase overflow-hidden text-ellipsis whitespace-nowrap">Low Stock (≤ 5)</p>
                        <h2 style="font-family:'Syne',sans-serif;font-weight:700;" class="text-3xl text-gray-900 dark:text-white mt-1">{{ $lowStock }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-500/10 text-amber-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.stocks.index', ['status' => 'out_of_stock', 'search' => request('search')]) }}" class="relative bg-white dark:bg-neutral-800 p-5 rounded-2xl border {{ request('status') == 'out_of_stock' ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-200 dark:border-neutral-700' }} hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer block overflow-hidden">
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-red-500 dark:text-red-400 uppercase overflow-hidden text-ellipsis whitespace-nowrap">Out of Stock</p>
                        <h2 style="font-family:'Syne',sans-serif;font-weight:700;" class="text-3xl text-gray-900 dark:text-white mt-1">{{ $outOfStock }}</h2>
                    </div>
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-100 dark:border-neutral-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-neutral-700/30 border-b border-gray-100 dark:border-neutral-700 text-xs uppercase tracking-wider text-gray-400 dark:text-gray-500 font-semibold">
                            <th class="px-6 py-4">Product Details</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Current Stock</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-neutral-700/50">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50/30 dark:hover:bg-neutral-700/20 transition-colors {{ $product->stock == 0 ? 'bg-red-50/30 dark:bg-red-900/10' : ($product->stock <= 5 ? 'bg-amber-50/30 dark:bg-amber-900/10' : '') }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl border border-gray-100 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800 overflow-hidden flex-shrink-0">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">₦{{ number_format($product->price, 2) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-gray-300">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->stock == 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-200 dark:border-red-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            Out of Stock
                                        </span>
                                    @elseif($product->stock <= 5)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                                             <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" required
                                            class="w-20 px-3 py-1.5 text-sm border border-gray-200 dark:border-neutral-700 rounded-lg bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition-all {{ $product->stock == 0 ? 'text-red-600 dark:text-red-400 font-bold' : ($product->stock <= 5 ? 'text-amber-600 dark:text-amber-500 font-bold' : '') }}">
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-brand hover:bg-brand/10 rounded-lg transition-colors" title="Update Stock">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-neutral-700/50 hover:bg-gray-200 dark:hover:bg-neutral-600 rounded-lg transition-colors border border-gray-200 dark:border-neutral-600">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Product
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-neutral-800 mb-4">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm">No products found for this stock filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/50">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
</main>
@endsection
