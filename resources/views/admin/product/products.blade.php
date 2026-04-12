@extends('layouts.admin')

@section('admin')
    <style>
        .s-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }
        .dark .s-card {
            background: #262626;
            border-color: #404040;
        }

        .table-header-text {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #9ca3af;
        }

        .prod-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }
        .dark .prod-title {
            color: #f3f4f6;
        }

        .badge-outline {
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
            border: 1px solid;
        }
        .badge-active {
            color: #10b981;
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .badge-inactive {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.05);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .table-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid #d1d5db;
            appearance: none;
            -webkit-appearance: none;
            outline: none;
            cursor: pointer;
            position: relative;
        }
        .table-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .table-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        .btn-outline-custom:hover {
            background: #f9fafb;
            color: #111827;
        }
        .dark .btn-outline-custom {
            background: transparent;
            border-color: #374151;
            color: #d1d5db;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: #3b82f6;
            border: none;
            transition: background 0.2s ease;
        }
        .btn-primary-custom:hover {
            background: #3b82f6;
        }

        /* ── Row Action Buttons ── */
        .row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 2px;
        }
        .row-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 7px;
            color: #9ca3af;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }
        .row-action-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }
        .dark .row-action-btn:hover {
            background: rgba(255,255,255,0.06);
            color: #e5e7eb;
        }
        /* View */
        .row-action-btn.view:hover {
            background: #ede9fe;
            color: #3b82f6;
        }
        .dark .row-action-btn.view:hover {
            background: rgba(59, 130, 246,0.12);
            color: #60a5fa;
        }
        /* Edit */
        .row-action-btn.edit:hover {
            background: #e0f2fe;
            color: #0284c7;
        }
        .dark .row-action-btn.edit:hover {
            background: rgba(2,132,199,0.12);
            color: #38bdf8;
        }
        /* Delete */
        .row-action-btn.delete:hover {
            background: #fef2f2;
            color: #ef4444;
        }
        .dark .row-action-btn.delete:hover {
            background: rgba(239,68,68,0.1);
            color: #f87171;
        }

        /* Tooltip */
        .row-action-btn::before {
            content: attr(data-tip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            background: #1f2937;
            color: #fff;
            opacity: 0;
            pointer-events: none;
            transition: all 0.15s ease;
            z-index: 20;
        }
        .dark .row-action-btn::before {
            background: #374151;
        }
        .row-action-btn::after {
            content: '';
            position: absolute;
            bottom: calc(100% + 2px);
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: #1f2937;
            opacity: 0;
            pointer-events: none;
            transition: all 0.15s ease;
            z-index: 20;
        }
        .dark .row-action-btn::after {
            border-top-color: #374151;
        }
        .row-action-btn:hover::before {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .row-action-btn:hover::after {
            opacity: 1;
        }

        /* Product image */
        .prod-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
            flex-shrink: 0;
        }
        .prod-img-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f8f7ff 0%, #f0eeff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dark .prod-img-placeholder {
            background: linear-gradient(135deg, #1a1a2e 0%, #1e1b33 100%);
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Products</span>
        </div>

        {{-- Main Card --}}
        <div class="s-card mb-6">

            {{-- Header Actions --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 border-b border-gray-100 dark:border-neutral-800 gap-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Products list</h2>

                <div class="flex items-center gap-3">
                    {{-- Search --}}
                    <form action="{{ route('admin.products.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="pl-9 pr-4 py-2 border border-gray-200 dark:border-neutral-700 rounded-lg text-sm bg-gray-50 dark:bg-neutral-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand w-48 transition-all">
                        <svg class="absolute left-3 top-2.5 text-gray-400 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                    </form>

                    {{-- Filter --}}
                    <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
                        <select name="status" class="btn-outline-custom pr-8" onchange="this.form.submit()">
                            <option value="">Filter Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </form>

                    <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">See All</a>
                    <a href="{{ route('admin.products.create') }}" class="btn-primary-custom">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800 bg-gray-50/50 dark:bg-neutral-800/50">
                            <th class="py-4 pl-5 pr-2 w-12 text-gray-400">
                                <input type="checkbox" class="table-checkbox" id="selectAll">
                            </th>
                            <th class="py-4 px-4 table-header-text">Product Name <span class="text-[10px] ml-1">▼</span></th>
                            <th class="py-4 px-4 table-header-text hidden md:table-cell">Category <span class="text-[10px] ml-1">▼</span></th>
                            <th class="py-4 px-4 table-header-text">Price <span class="text-[10px] ml-1">▼</span></th>
                            <th class="py-4 px-4 table-header-text hidden sm:table-cell">Stock <span class="text-[10px] ml-1">▼</span></th>
                            <th class="py-4 px-4 table-header-text">Status <span class="text-[10px] ml-1">▼</span></th>
                            <th class="py-4 px-4 table-header-text hidden lg:table-cell">Featured</th>
                            <th class="py-4 px-5 table-header-text text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/50 transition-colors group">
                                <td class="py-4 pl-5 pr-2">
                                    <input type="checkbox" name="product_ids[]" class="table-checkbox product-checkbox" value="{{ $product->id }}">
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="prod-img">
                                        @else
                                            <div class="prod-img-placeholder">
                                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" stroke="#8b7cf7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <rect x="3" y="3" width="18" height="18" rx="3" stroke="#8b7cf7" stroke-width="1.5"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <span class="prod-title">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 hidden md:table-cell text-sm text-gray-600 dark:text-gray-400">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200 font-medium">
                                    @if ($product->sale_price > 0 && $product->sale_price < $product->price)
                                        {{ config('app.currency_symbol', '₦') }}{{ number_format($product->sale_price, 2) }}
                                        <div class="text-xs text-red-500 line-through font-normal">
                                            {{ config('app.currency_symbol', '₦') }}{{ number_format($product->price, 2) }}
                                        </div>
                                    @else
                                        {{ config('app.currency_symbol', '₦') }}{{ number_format($product->price, 2) }}
                                    @endif
                                </td>
                                <td class="py-4 px-4 hidden sm:table-cell text-sm text-gray-600 dark:text-gray-400">
                                    {{ $product->stock }}
                                </td>
                                <td class="py-4 px-4">
                                    @if ($product->is_active)
                                        <span class="badge-outline badge-active">Active</span>
                                    @else
                                        <span class="badge-outline badge-inactive">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 hidden lg:table-cell">
                                    <button onclick="toggleFeatured({{ $product->id }}, this)" class="p-1.5 rounded-lg transition-colors {{ $product->featured ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-400' }}" data-tip="{{ $product->featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $product->featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="row-actions">
                                        {{-- View --}}
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="row-action-btn view" data-tip="View">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="row-action-btn edit" data-tip="Edit">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="row-action-btn delete" data-tip="Delete">
                                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-500 dark:text-gray-400">
                                    No products found. <a href="{{ route('admin.products.create') }}" class="text-brand font-medium hover:underline">Add one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-neutral-800">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function(cb) { cb.checked = this.checked; }.bind(this));
        });

        function toggleFeatured(productId, btn) {
            fetch('/admin/products/' + productId + '/toggle-featured', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var svg = btn.querySelector('svg');
                if (data.featured) {
                    btn.classList.remove('text-gray-300', 'dark:text-gray-600', 'hover:text-yellow-400');
                    btn.classList.add('text-yellow-500');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.classList.add('text-gray-300', 'dark:text-gray-600', 'hover:text-yellow-400');
                    btn.classList.remove('text-yellow-500');
                    svg.setAttribute('fill', 'none');
                }
            });
        }
    </script>
@endsection