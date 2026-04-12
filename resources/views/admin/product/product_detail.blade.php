@extends('layouts.admin')

@push('title', 'Product Details')

@section('admin')
<style>
    .s-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
    }
    .dark .s-card {
        background: #262626;
        border-color: #404040;
    }
    
    .detail-label {
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 2px;
    }
    .dark .detail-label {
        color: #9ca3af;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }
    .dark .detail-value {
        color: #f3f4f6;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid;
    }
    .badge-true { color: #10b981; background: rgba(16,185,129,0.08); border-color: rgba(16,185,129,0.3); }
    .badge-false { color: #ef4444; background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.3); }
    .badge-neutral { color: #6b7280; background: rgba(107,114,128,0.08); border-color: rgba(107,114,128,0.3); }

    .btn-outline-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        background: transparent;
        border: 1.5px solid #d1d5db;
        transition: all 0.2s;
    }
    .btn-outline-custom:hover {
        background: #f3f4f6;
        color: #111827;
    }
    .dark .btn-outline-custom {
        color: #d1d5db;
        border-color: #4b5563;
    }
    .dark .btn-outline-custom:hover {
        background: rgba(255,255,255,0.05);
        color: #fff;
    }

    .btn-primary-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background: #3b82f6;
        border: none;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #3b82f6;
    }
</style>

<div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <a href="{{ route('admin.products.index') }}" class="hover:text-brand transition-colors">Products</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <span class="text-gray-600 dark:text-gray-300 font-medium">Product Details</span>
    </div>

    {{-- Header Content --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">ID: #{{ $product->id }} &bull; SKU: {{ $product->sku ?? 'N/A' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">Back to List</a>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-primary-custom">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Images & Primary Details --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="s-card p-5">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 pb-3 border-b border-gray-100 dark:border-neutral-800">Product Images</h3>
                <div class="grid grid-cols-2 gap-4">
                    {{-- Primary Image --}}
                    <div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Primary Image</div>
                        <div class="aspect-square bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center overflow-hidden border border-gray-100 dark:border-neutral-700">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    {{-- Hover Image --}}
                    <div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Hover Image</div>
                        <div class="aspect-square bg-gray-100 dark:bg-neutral-800 rounded-lg flex items-center justify-center overflow-hidden border border-gray-100 dark:border-neutral-700">
                            @if($product->hover_image)
                                <img src="{{ asset('storage/' . $product->hover_image) }}" alt="{{ $product->name }} Hover" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-300 mx-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs text-gray-400 mt-1 block">Not set</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="s-card p-5">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 pb-3 border-b border-gray-100 dark:border-neutral-800">Status & Validation</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="detail-label mb-0">Status</span>
                        <span class="badge {{ $product->is_active ? 'badge-true' : 'badge-neutral' }}">{{ $product->is_active ? 'Active' : 'Draft' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="detail-label mb-0">Homepage Featured</span>
                        <span class="badge {{ $product->featured ? 'badge-true' : 'badge-neutral' }}">{{ $product->featured ? 'Yes' : 'No' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Detailed Specs --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="s-card p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 pb-3 border-b border-gray-100 dark:border-neutral-800">General Information</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4 mb-6">
                    <div>
                        <div class="detail-label">Category</div>
                        <div class="detail-value">{{ $product->category ? $product->category->name : 'Uncategorized' }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Slug</div>
                        <div class="detail-value">{{ $product->slug }}</div>
                    </div>
                </div>

                <div>
                    <div class="detail-label mb-1">Description</div>
                    <div class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg border border-gray-100 dark:border-neutral-700">
                        {{ $product->description ?: 'No description provided.' }}
                    </div>
                </div>
            </div>

            <div class="s-card p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 pb-3 border-b border-gray-100 dark:border-neutral-800">Pricing & Inventory</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <div class="detail-label">Regular Price</div>
                        <div class="detail-value text-xl text-gray-800 dark:text-white">₦{{ number_format($product->price, 2) }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Sale Price</div>
                        <div class="detail-value text-xl {{ $product->sale_price ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $product->sale_price ? '₦'.number_format($product->sale_price, 2) : 'N/A' }}
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Current Stock</div>
                        <div class="detail-value text-xl {{ $product->stock <= ($product->low_stock_qty ?? 5) ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">{{ $product->stock }}</div>
                    </div>

                    <div>
                        <div class="detail-label">Unit</div>
                        <div class="detail-value">{{ $product->unit ?: 'Per Piece' }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Low Stock Warning At</div>
                        <div class="detail-value">{{ $product->low_stock_qty ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Max Purchase Qty</div>
                        <div class="detail-value">{{ $product->max_purchase_qty ?: 'Unlimited' }}</div>
                    </div>
                </div>
            </div>

            <div class="s-card p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 pb-3 border-b border-gray-100 dark:border-neutral-800">Advanced Configurations</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $product->is_purchasable ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            @if($product->is_purchasable)
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @else
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" /></svg>
                            @endif
                        </div>
                        <div>
                            <div class="detail-label mb-0">Purchasable</div>
                            <div class="text-sm font-semibold {{ $product->is_purchasable ? 'text-green-600' : 'text-red-500' }}">{{ $product->is_purchasable ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $product->is_refundable ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                            @if($product->is_refundable)
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg>
                            @else
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            @endif
                        </div>
                        <div>
                            <div class="detail-label mb-0">Refundable</div>
                            <div class="text-sm font-semibold {{ $product->is_refundable ? 'text-blue-600' : 'text-gray-500' }}">{{ $product->is_refundable ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $product->show_stock_out ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                            @if($product->show_stock_out)
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            @else
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            @endif
                        </div>
                        <div>
                            <div class="detail-label mb-0">Show Stock Out</div>
                            <div class="text-sm font-semibold {{ $product->show_stock_out ? 'text-indigo-600' : 'text-gray-500' }}">{{ $product->show_stock_out ? 'Enabled' : 'Disabled' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
