@extends('layouts.admin')

@push('title', 'Edit Category')

@section('admin')
    <style>
        .s-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.02);
        }

        .dark .s-card {
            background: #1c1c2e;
            border-color: #2a2a3e;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .dark .form-label {
            color: #d1d5db;
        }

        .form-input {
            width: 100%;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1f2937;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dark .form-input {
            background: rgba(0, 0, 0, 0.2);
            border-color: #374151;
            color: #f3f4f6;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: #3b82f6;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary-custom:hover {
            background: #3b82f6;
        }

        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            background: transparent;
            border: 1.5px solid #d1d5db;
            cursor: pointer;
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

        /* ── Image Uploader ── */
        .img-uploader {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            background: #f9fafb;
            transition: all 0.25s ease;
            overflow: hidden;
        }

        .dark .img-uploader {
            background: rgba(0, 0, 0, 0.15);
            border-color: #374151;
        }

        .img-uploader:hover,
        .img-uploader.drag-over {
            border-color: #3b82f6;
            background: #f5f3ff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.06);
        }

        .dark .img-uploader:hover,
        .dark .img-uploader.drag-over {
            background: rgba(59, 130, 246, 0.06);
            border-color: #7c5cfc;
        }

        .img-uploader.has-file {
            border-style: solid;
            border-color: #e5e7eb;
        }

        .dark .img-uploader.has-file {
            border-color: #2a2a3e;
        }

        .img-uploader .drop-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
            cursor: pointer;
            text-align: center;
            min-height: 180px;
        }

        .img-uploader .drop-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #ede9fe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: transform 0.2s, background 0.2s;
        }

        .dark .img-uploader .drop-icon {
            background: rgba(59, 130, 246, 0.15);
        }

        .img-uploader:hover .drop-icon {
            transform: translateY(-2px);
            background: #ddd6fe;
        }

        .img-uploader .drop-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }

        .dark .img-uploader .drop-title {
            color: #e5e7eb;
        }

        .img-uploader .drop-hint {
            font-size: 12px;
            color: #9ca3af;
            line-height: 1.4;
        }

        .img-uploader .drop-hint .browse-link {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .img-uploader .drop-formats {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 10px;
            padding: 4px 10px;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 6px;
            font-size: 11px;
            color: #9ca3af;
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .dark .img-uploader .drop-formats {
            background: rgba(255, 255, 255, 0.04);
        }

        /* Preview state */
        .img-uploader .preview-state {
            display: none;
            position: relative;
        }

        .img-uploader.has-file .drop-zone {
            display: none;
        }

        .img-uploader.has-file .preview-state {
            display: block;
        }

        .img-uploader .preview-img-wrap {
            position: relative;
            width: 100%;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: repeating-conic-gradient(#f3f4f6 0% 25%, transparent 0% 50%) 50%/16px 16px;
            overflow: hidden;
        }

        .dark .img-uploader .preview-img-wrap {
            background: repeating-conic-gradient(#1f1f35 0% 25%, transparent 0% 50%) 50%/16px 16px;
        }

        .img-uploader .preview-img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .img-uploader .preview-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: #fff;
            border-top: 1px solid #f0f0f0;
        }

        .dark .img-uploader .preview-bar {
            background: #1c1c2e;
            border-color: #2a2a3e;
        }

        .img-uploader .preview-file-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f0fdf4;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dark .img-uploader .preview-file-icon {
            background: rgba(34, 197, 94, 0.1);
        }

        .img-uploader .preview-meta {
            flex: 1;
            min-width: 0;
        }

        .img-uploader .preview-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dark .img-uploader .preview-name {
            color: #f3f4f6;
        }

        .img-uploader .preview-size {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 1px;
        }

        .img-uploader .preview-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .img-uploader .preview-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #9ca3af;
            transition: all 0.15s;
        }

        .img-uploader .preview-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .dark .img-uploader .preview-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
        }

        .img-uploader .preview-btn.remove:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        .dark .img-uploader .preview-btn.remove:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* Current-image badge */
        .current-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            background: #ede9fe;
            color: #3b82f6;
        }

        .dark .current-badge {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <a href="{{ route('admin.category') }}" class="hover:text-brand transition-colors">Categories</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Edit Category</span>
        </div>

        <div class="s-card max-w-3xl mx-auto">
            <div class="p-5 sm:p-8 border-b border-gray-100 dark:border-neutral-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Category</h2>
                <p class="text-sm text-gray-500 mt-1">Update the details for this category below.</p>
            </div>

            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                class="p-5 sm:p-8 space-y-6">
                @csrf

                <div>
                    <label class="form-label">Category Title *</label>
                    <input type="text" name="title" value="{{ old('title', $category->title ?? $category->name) }}"
                        class="form-input" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-input">
                        <option value="0">None (Root Category)</option>
                        @php
                            $rootCategories = App\Models\Category::where('parent_id', 0)
                                ->where('id', '!=', $category->id)
                                ->orderBy('sort', 'asc')
                                ->orderBy('title', 'asc')
                                ->get();
                        @endphp
                        @foreach ($rootCategories as $rootCat)
                            <option value="{{ $rootCat->id }}" {{ old('parent_id', $category->parent_id) == $rootCat->id ? 'selected' : '' }}>
                                {{ $rootCat->title ?? $rootCat->name }}
                            </option>
                            @php
                                $subCategories = App\Models\Category::where('parent_id', $rootCat->id)
                                    ->where('id', '!=', $category->id)
                                    ->orderBy('sort', 'asc')
                                    ->orderBy('title', 'asc')
                                    ->get();
                            @endphp
                            @foreach ($subCategories as $subCat)
                                <option value="{{ $subCat->id }}" {{ old('parent_id', $category->parent_id) == $subCat->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;-- {{ $subCat->title ?? $subCat->name }}
                                </option>
                                @php
                                    $subSubCategories = App\Models\Category::where('parent_id', $subCat->id)
                                        ->where('id', '!=', $category->id)
                                        ->orderBy('sort', 'asc')
                                        ->orderBy('title', 'asc')
                                        ->get();
                                @endphp
                                @foreach ($subSubCategories as $subSubCat)
                                    <option value="{{ $subSubCat->id }}" {{ old('parent_id', $category->parent_id) == $subSubCat->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---- {{ $subSubCat->title ?? $subSubCat->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Image Uploaders ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Thumbnail --}}
                    <div>
                        <label class="form-label">Thumbnail Image</label>
                        <div class="img-uploader {{ $category->thumbnail ? 'has-file' : '' }}" id="uploaderThumb"
                            data-has-existing="{{ $category->thumbnail ? '1' : '0' }}">
                            <input type="file" name="thumbnail" accept="image/*" hidden id="inputThumb">

                            {{-- Empty / drop state --}}
                            <div class="drop-zone" onclick="document.getElementById('inputThumb').click()">
                                <div class="drop-icon">
                                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"
                                            stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <rect x="3" y="3" width="18" height="18" rx="3" stroke="#3b82f6"
                                            stroke-width="1.5" />
                                        <circle cx="8.5" cy="8.5" r="1.5" fill="#3b82f6" opacity=".4" />
                                    </svg>
                                </div>
                                <p class="drop-title">Upload Thumbnail</p>
                                <p class="drop-hint">Drag & drop or <span class="browse-link">browse</span></p>
                                <span class="drop-formats">PNG, JPG, WEBP — max 2 MB</span>
                            </div>

                            {{-- Preview state --}}
                            <div class="preview-state">
                                <div class="preview-img-wrap">
                                    <img src="{{ $category->thumbnail ? asset('storage/' . $category->thumbnail) : '' }}"
                                        alt="Preview" class="preview-img" id="previewThumb">
                                </div>
                                <div class="preview-bar">
                                    <div class="preview-file-icon">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                            <path d="M5 3h8l6 6v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                stroke="#22c55e" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M13 3v6h6" stroke="#22c55e" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="preview-meta">
                                        <div class="preview-name" id="nameThumb">
                                            {{ $category->thumbnail ? basename($category->thumbnail) : '—' }}</div>
                                        <div class="preview-size" id="sizeThumb">
                                            @if ($category->thumbnail)
                                                <span class="current-badge">Current</span>
                                            @else
                                                —
                                            @endif
                                        </div>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" class="preview-btn" title="Replace"
                                            onclick="document.getElementById('inputThumb').click()">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                                <path d="M4 4v5h5M20 20v-5h-5" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M20.49 9A9 9 0 005.64 5.64L4 4m16 16l-1.64-1.64A9 9 0 013.51 15"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button type="button" class="preview-btn remove" title="Remove"
                                            onclick="clearUploader('Thumb')">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('thumbnail')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Icon --}}
                    <div>
                        <label class="form-label">Icon Image</label>
                        <div class="img-uploader {{ $category->icon ? 'has-file' : '' }}" id="uploaderIcon"
                            data-has-existing="{{ $category->icon ? '1' : '0' }}">
                            <input type="file" name="icon" accept="image/*" hidden id="inputIcon">

                            <div class="drop-zone" onclick="document.getElementById('inputIcon').click()">
                                <div class="drop-icon">
                                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="7" height="7" rx="2" stroke="#3b82f6"
                                            stroke-width="1.5" />
                                        <rect x="14" y="3" width="7" height="7" rx="2" stroke="#3b82f6"
                                            stroke-width="1.5" />
                                        <rect x="3" y="14" width="7" height="7" rx="2" stroke="#3b82f6"
                                            stroke-width="1.5" />
                                        <circle cx="17.5" cy="17.5" r="3.5" stroke="#3b82f6"
                                            stroke-width="1.5" />
                                    </svg>
                                </div>
                                <p class="drop-title">Upload Icon</p>
                                <p class="drop-hint">Drag & drop or <span class="browse-link">browse</span></p>
                                <span class="drop-formats">PNG, SVG, WEBP — max 1 MB</span>
                            </div>

                            <div class="preview-state">
                                <div class="preview-img-wrap">
                                    <img src="{{ $category->icon ? asset('storage/' . $category->icon) : '' }}"
                                        alt="Preview" class="preview-img" id="previewIcon">
                                </div>
                                <div class="preview-bar">
                                    <div class="preview-file-icon">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                                            <path d="M5 3h8l6 6v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                stroke="#22c55e" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M13 3v6h6" stroke="#22c55e" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="preview-meta">
                                        <div class="preview-name" id="nameIcon">
                                            {{ $category->icon ? basename($category->icon) : '—' }}</div>
                                        <div class="preview-size" id="sizeIcon">
                                            @if ($category->icon)
                                                <span class="current-badge">Current</span>
                                            @else
                                                —
                                            @endif
                                        </div>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" class="preview-btn" title="Replace"
                                            onclick="document.getElementById('inputIcon').click()">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                                <path d="M4 4v5h5M20 20v-5h-5" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M20.49 9A9 9 0 005.64 5.64L4 4m16 16l-1.64-1.64A9 9 0 013.51 15"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button type="button" class="preview-btn remove" title="Remove"
                                            onclick="clearUploader('Icon')">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('icon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort" value="{{ old('sort', $category->sort) }}" min="0"
                            class="form-input w-32">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                class="w-4 h-4 text-brand rounded focus:ring-brand"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (visible)</span>
                        </label>
                    </div>
                </div>

                <div
                    class="mt-8 pt-6 border-t border-gray-100 dark:border-neutral-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.category') }}" class="btn-outline-custom">Cancel</a>
                    <button type="submit" class="btn-primary-custom">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Uploader logic ──
        function initUploader(key) {
            const wrapper = document.getElementById('uploader' + key);
            const input = document.getElementById('input' + key);

            // Drag events
            ['dragenter', 'dragover'].forEach(evt => {
                wrapper.addEventListener(evt, e => {
                    e.preventDefault();
                    wrapper.classList.add('drag-over');
                });
            });
            ['dragleave', 'drop'].forEach(evt => {
                wrapper.addEventListener(evt, e => {
                    e.preventDefault();
                    wrapper.classList.remove('drag-over');
                });
            });
            wrapper.addEventListener('drop', e => {
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                    showPreview(key, file);
                }
            });

            // File input change
            input.addEventListener('change', function() {
                if (this.files[0]) showPreview(key, this.files[0]);
            });
        }

        function showPreview(key, file) {
            const wrapper = document.getElementById('uploader' + key);
            const preview = document.getElementById('preview' + key);
            const nameEl = document.getElementById('name' + key);
            const sizeEl = document.getElementById('size' + key);

            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            nameEl.textContent = file.name;
            sizeEl.innerHTML = formatSize(file.size);
            wrapper.classList.add('has-file');
        }

        function clearUploader(key) {
            const wrapper = document.getElementById('uploader' + key);
            const input = document.getElementById('input' + key);
            const preview = document.getElementById('preview' + key);
            const nameEl = document.getElementById('name' + key);
            const sizeEl = document.getElementById('size' + key);

            input.value = '';
            preview.src = '';
            nameEl.textContent = '—';
            sizeEl.innerHTML = '—';
            wrapper.classList.remove('has-file');
            // Clear existing flag so it stays cleared
            wrapper.dataset.hasExisting = '0';
        }

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(2) + ' MB';
        }

        // Boot uploaders
        document.addEventListener('DOMContentLoaded', () => {
            initUploader('Thumb');
            initUploader('Icon');
        });
    </script>
@endsection
