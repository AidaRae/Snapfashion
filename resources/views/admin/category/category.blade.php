@extends('layouts.admin')

@push('title', 'Categories')

@section('admin')
    <style>
        .s-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .dark .s-card {
            background: #1c1c2e;
            border-color: #2a2a3e;
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

        /* ── Category Card ── */
        .cat-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }

        .cat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
            transform: translateY(-3px);
        }

        .dark .cat-card {
            background: #1c1c2e;
            border-color: #2a2a3e;
        }

        .dark .cat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }

        /* ── Thumbnail Area ── */
        .cat-thumb-wrap {
            position: relative;
            width: 100%;
            height: 150px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .dark .cat-thumb-wrap {
            background: #12121a;
        }

        .cat-thumb-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .cat-card:hover .cat-thumb-wrap img {
            transform: scale(1.05);
        }

        /* Gradient overlay for actions visibility */
        .cat-thumb-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.25) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.25s;
            pointer-events: none;
            z-index: 1;
        }

        .cat-card:hover .cat-thumb-wrap::after {
            opacity: 1;
        }

        /* Placeholder thumbnail */
        .cat-thumb-placeholder {
            width: 100%;
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #f8f7ff 0%, #f0eeff 50%, #eef2ff 100%);
            position: relative;
            overflow: hidden;
        }

        .dark .cat-thumb-placeholder {
            background: linear-gradient(135deg, #1a1a2e 0%, #1e1b33 50%, #191930 100%);
        }

        /* Decorative grid pattern */
        .cat-thumb-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.04) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .dark .cat-thumb-placeholder::before {
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.06) 1px, transparent 1px);
        }

        .cat-thumb-placeholder .placeholder-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .dark .cat-thumb-placeholder .placeholder-icon {
            background: rgba(59, 130, 246, 0.12);
        }

        .cat-thumb-placeholder .placeholder-text {
            font-size: 11px;
            font-weight: 500;
            color: #b4aee8;
            position: relative;
            z-index: 1;
        }

        /* ── Action Buttons ── */
        .card-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            align-items: center;
            gap: 2px;
            padding: 4px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transform: translateY(-4px);
            transition: all 0.2s ease;
            z-index: 10;
        }

        .dark .card-actions {
            background: rgba(20, 20, 36, 0.92);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .cat-card:hover .card-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            color: #6b7280;
            transition: all 0.15s;
        }

        .action-btn:hover {
            background: #f3f4f6;
            color: #3b82f6;
        }

        .dark .action-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #60a5fa;
        }

        .action-btn.danger:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        .dark .action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* ── Category Info Row ── */
        .cat-info {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            position: relative;
        }

        .dark .cat-info {
            background: #1c1c2e;
            border-color: #2a2a3e;
        }

        .cat-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .cat-icon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cat-icon-fallback {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #3b82f6;
            flex-shrink: 0;
        }

        .dark .cat-icon-fallback {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(99, 102, 241, 0.12) 100%);
            color: #60a5fa;
        }

        .cat-title {
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: #111827;
            line-height: 1.3;
        }

        .dark .cat-title {
            color: #f3f4f6;
        }

        .sub-count-badge {
            font-size: 11px;
            font-weight: 600;
            color: #3b82f6;
            background: #f0edff;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .dark .sub-count-badge {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
        }

        /* Add sub link */
        .add-sub-link {
            position: absolute;
            right: 14px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #3b82f6;
            background: #ede9fe;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .dark .add-sub-link {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }

        .add-sub-link:hover {
            background: #3b82f6;
            color: #fff;
        }

        .dark .add-sub-link:hover {
            background: rgba(59, 130, 246, 0.8);
            color: #fff;
        }

        /* ── Subcategory List ── */
        .sub-list {
            padding: 12px 16px;
            flex: 1;
            background: #fafafa;
        }

        .dark .sub-list {
            background: #171723;
        }

        .sub-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0 8px 12px;
            border-left: 2px solid rgba(59, 130, 246, 0.2);
            margin-bottom: 6px;
            border-radius: 0 6px 6px 0;
            transition: all 0.15s;
        }

        .sub-item:last-child {
            margin-bottom: 0;
        }

        .sub-item:hover {
            background: rgba(59, 130, 246, 0.03);
            border-left-color: #3b82f6;
        }

        .dark .sub-item:hover {
            background: rgba(59, 130, 246, 0.05);
        }

        .sub-item-left {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            flex: 1;
        }

        .sub-icon {
            width: 22px;
            height: 22px;
            border-radius: 5px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sub-icon-fallback {
            width: 22px;
            height: 22px;
            border-radius: 5px;
            background: #f0edff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
            color: #8b7cf7;
            flex-shrink: 0;
        }

        .dark .sub-icon-fallback {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sub-name {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dark .sub-name {
            color: #d1d5db;
        }

        .sub-actions {
            display: flex;
            align-items: center;
            gap: 2px;
            opacity: 0;
            transition: opacity 0.15s;
            padding-left: 8px;
        }

        .sub-item:hover .sub-actions {
            opacity: 1;
        }

        .sub-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 5px;
            color: #9ca3af;
            transition: all 0.15s;
        }

        .sub-action-btn:hover {
            background: #f3f4f6;
            color: #3b82f6;
        }

        .dark .sub-action-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #60a5fa;
        }

        .sub-action-btn.danger:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        .dark .sub-action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* Sub-sub items */
        .subsub-list {
            margin-top: 6px;
            margin-left: 22px;
            padding-left: 10px;
            border-left: 1px dashed #d1d5db;
        }

        .dark .subsub-list {
            border-color: #374151;
        }

        .subsub-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 0;
        }

        .subsub-name {
            font-size: 12px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dark .subsub-name {
            color: #9ca3af;
        }

        .subsub-arrow {
            color: #c7c3e8;
            font-size: 10px;
        }

        .subsub-actions {
            display: flex;
            gap: 2px;
            opacity: 0;
            transition: opacity 0.15s;
        }

        .subsub-item:hover .subsub-actions {
            opacity: 1;
        }

        /* ── Empty State ── */
        .empty-state {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f0f0;
            padding: 48px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .dark .empty-state {
            background: #1c1c2e;
            border-color: #2a2a3e;
        }

        .empty-state::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(99, 102, 241, 0.04) 0%, transparent 50%);
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f0edff 0%, #e8e4ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            position: relative;
        }

        .dark .empty-icon {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(59, 130, 246, 0.08) 100%);
        }

        /* ── Sub-list empty state ── */
        .sub-empty {
            text-align: center;
            padding: 20px 12px;
            color: #b0adc4;
            font-size: 13px;
        }

        .sub-empty-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Categories</span>
        </div>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Categories</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your product categories and subcategories.</p>
            </div>
            <a href="{{ route('admin.category.add') }}" class="btn-primary-custom">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add new Category
            </a>
        </div>

        {{-- Messages --}}
        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                {{ session('error') }}</div>
        @endif

        {{-- Category Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php
                $categories = App\Models\Category::where('parent_id', 0)
                    ->orderBy('sort', 'asc')
                    ->orderBy('title', 'asc')
                    ->get();
            @endphp

            @foreach ($categories as $category)
                @php
                    $subCategories = App\Models\Category::where('parent_id', $category->id)
                        ->orderBy('sort', 'asc')
                        ->orderBy('title', 'asc')
                        ->get();
                @endphp

                <div class="cat-card relative">
                    {{-- Action buttons --}}
                    <div class="card-actions">
                        <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}" class="action-btn"
                            title="Edit">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.category.delete', ['id' => $category->id]) }}" class="action-btn danger"
                            title="Delete" onclick="return confirm('Delete this category and all its subcategories?')">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>
                    </div>

                    {{-- Thumbnail --}}
                    @if ($category->thumbnail || $category->image)
                        <div class="cat-thumb-wrap">
                            <img src="{{ asset('storage/' . ($category->thumbnail ?? $category->image)) }}"
                                alt="{{ $category->title }}">
                        </div>
                    @else
                        <div class="cat-thumb-placeholder">
                            <div class="placeholder-icon">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"
                                        stroke="#8b7cf7" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <rect x="3" y="3" width="18" height="18" rx="3" stroke="#8b7cf7"
                                        stroke-width="1.5" />
                                    <circle cx="8.5" cy="8.5" r="1.5" fill="#8b7cf7" opacity=".3" />
                                </svg>
                            </div>
                            <span class="placeholder-text">No thumbnail</span>
                        </div>
                    @endif

                    {{-- Category Info --}}
                    <div class="cat-info group">
                        @if ($category->icon)
                            <div class="cat-icon-wrap">
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="">
                            </div>
                        @else
                            <div class="cat-icon-fallback">
                                {{ strtoupper(substr($category->title ?? $category->name, 0, 1)) }}</div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <h6 class="cat-title truncate">{{ $category->title ?? $category->name }}</h6>
                            <span class="sub-count-badge">{{ count($subCategories) }} sub</span>
                        </div>

                        <a href="{{ route('admin.category.add', ['parent' => $category->id]) }}" class="add-sub-link"
                            title="Add Subcategory">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add
                        </a>
                    </div>

                    {{-- Subcategories --}}
                    <div class="sub-list">
                        @if (count($subCategories) > 0)
                            @foreach ($subCategories as $subCategory)
                                @php
                                    $subSubCategories = App\Models\Category::where('parent_id', $subCategory->id)
                                        ->orderBy('sort', 'asc')
                                        ->orderBy('title', 'asc')
                                        ->get();
                                @endphp

                                <div class="sub-item">
                                    <div class="sub-item-left">
                                        @if ($subCategory->icon)
                                            <img class="sub-icon" src="{{ asset('storage/' . $subCategory->icon) }}"
                                                alt="">
                                        @else
                                            <div class="sub-icon-fallback">
                                                {{ strtoupper(substr($subCategory->title ?? $subCategory->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="sub-name">{{ $subCategory->title ?? $subCategory->name }}</span>
                                    </div>
                                    <div class="sub-actions">
                                        <a href="{{ route('admin.category.add', ['parent' => $subCategory->id]) }}"
                                            class="sub-action-btn" title="Add Sub-Subcategory">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.category.edit', ['id' => $subCategory->id]) }}"
                                            class="sub-action-btn" title="Edit">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.category.delete', ['id' => $subCategory->id]) }}"
                                            class="sub-action-btn danger" title="Delete"
                                            onclick="return confirm('Are you sure?')">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Sub-Subcategories --}}
                                @if (count($subSubCategories) > 0)
                                    <div class="subsub-list">
                                        @foreach ($subSubCategories as $subSub)
                                            <div class="subsub-item group">
                                                <span class="subsub-name">
                                                    <span class="subsub-arrow">↳</span>
                                                    {{ $subSub->title ?? $subSub->name }}
                                                </span>
                                                <div class="subsub-actions">
                                                    <a href="{{ route('admin.category.edit', ['id' => $subSub->id]) }}"
                                                        class="sub-action-btn" title="Edit">
                                                        <svg width="12" height="12" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.category.delete', ['id' => $subSub->id]) }}"
                                                        class="sub-action-btn danger" title="Delete"
                                                        onclick="return confirm('Are you sure?')">
                                                        <svg width="12" height="12" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="sub-empty">
                                <div class="sub-empty-icon">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                        stroke="#b0adc4" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6a2 2 0 012-2h2l2 2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                    </svg>
                                </div>
                                No subcategories yet
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty State --}}
        @if (count($categories) == 0)
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                        <path stroke="#3b82f6" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 6a2 2 0 012-2h2l2 2h8a2 2 0 012 2v2m-2 4h4m-2-2v4m-12 4h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 relative">No Categories Found</h3>
                <p class="text-gray-500 text-sm mt-1 mb-5 relative">You haven't created any product categories yet.</p>
                <a href="{{ route('admin.category.add') }}" class="btn-primary-custom relative">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add your first Category
                </a>
            </div>
        @endif
    </div>
@endsection
