@extends('layouts.admin')

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
        background: rgba(0,0,0,0.2);
        border-color: #374151;
        color: #f3f4f6;
    }
    .dark .form-input:focus {
        border-color: #3b82f6;
        background: rgba(0,0,0,0.4);
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
    .dark .btn-outline-custom:hover {
        background: rgba(255,255,255,0.05);
        color: #fff;
    }
    
    .file-drop {
        border: 2px dashed #d1d5db;
        padding: 30px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        background: #f9fafb;
        transition: all 0.2s;
    }
    .file-drop:hover {
        border-color: #3b82f6;
        background: #f3f0ff;
    }
    .dark .file-drop {
        background: transparent;
        border-color: #4b5563;
    }
    .dark .file-drop:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
    }
</style>

<div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-brand transition-colors">Dashboard</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <a href="{{ route('admin.products.index') }}" class="hover:text-brand transition-colors">Products</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <span class="text-gray-600 dark:text-gray-300 font-medium">Edit Product</span>
    </div>

    <div class="s-card">
        <div class="p-5 sm:p-8 border-b border-gray-100 dark:border-neutral-800">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Product</h2>
            <p class="text-sm text-gray-500 mt-1">Update the product information below.</p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Details --}}
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-input" required>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="5" class="form-input">{{ old('description', $product->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Regular Price *</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-input" required>
                            @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Sale Price (Optional)</label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="form-input">
                            @error('sale_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" class="form-input" placeholder="e.g. pc, kg, pack">
                            @error('unit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Min. Stock Warning</label>
                            <input type="number" name="low_stock_qty" value="{{ old('low_stock_qty', $product->low_stock_qty) }}" class="form-input" placeholder="0" min="0">
                            @error('low_stock_qty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Max. Purchase Qty</label>
                            <input type="number" name="max_purchase_qty" value="{{ old('max_purchase_qty', $product->max_purchase_qty) }}" class="form-input" placeholder="Unlimited" min="1">
                            @error('max_purchase_qty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Sizes (comma-separated)</label>
                            <input type="text" name="sizes" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}" class="form-input" placeholder="e.g. S, M, L, XL">
                            @error('sizes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Colors (comma-separated)</label>
                            <input type="text" name="colors" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}" class="form-input" placeholder="e.g. Black, White, Red">
                            @error('colors')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Sidebar Details --}}
                <div class="space-y-6">
                    <div>
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-input" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Stock Quantity *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-input" required>
                        @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">SKU / Barcode</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-input">
                        @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Product Image</label>
                        @if($product->image)
                            <div class="mb-3" id="imagePreviewContainer">
                                <img id="imagePreview" src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto rounded-lg object-contain border border-gray-200 dark:border-neutral-700 max-h-40" alt="{{ $product->name }}">
                            </div>
                        @else
                            <div id="imagePreviewContainer" class="mb-3 hidden">
                                <img id="imagePreview" src="#" class="w-full h-auto rounded-lg object-contain border border-gray-200 dark:border-neutral-700 max-h-40" alt="Preview">
                            </div>
                        @endif
                        <label class="file-drop block relative">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'imagePreview', 'imagePreviewContainer', 'fileName2')">
                            <span id="fileName2" class="text-sm text-gray-500 font-medium">Click to change image</span>
                        </label>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Hover Image <span class="text-gray-400 font-normal">(shown on hover)</span></label>
                        @if($product->hover_image)
                            <div class="mb-3" id="hoverPreviewContainer">
                                <img id="hoverPreview" src="{{ asset('storage/' . $product->hover_image) }}" class="w-full h-auto rounded-lg object-contain border border-gray-200 dark:border-neutral-700 max-h-40" alt="Hover Image">
                                <label class="flex items-center gap-2 mt-2 cursor-pointer text-xs text-red-500 hover:text-red-700 transition-colors">
                                    <input type="checkbox" name="remove_hover_image" value="1" class="w-3.5 h-3.5 rounded text-red-500 focus:ring-red-400">
                                    Remove hover image
                                </label>
                            </div>
                        @else
                            <div id="hoverPreviewContainer" class="mb-3 hidden">
                                <img id="hoverPreview" src="#" class="w-full h-auto rounded-lg object-contain border border-gray-200 dark:border-neutral-700 max-h-40" alt="Hover Preview">
                            </div>
                        @endif
                        <label class="file-drop block relative">
                            <input type="file" name="hover_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'hoverPreview', 'hoverPreviewContainer', 'hoverFileName2')">
                            <span id="hoverFileName2" class="text-sm text-gray-500 font-medium">Click to {{ $product->hover_image ? 'change' : 'upload' }} hover image</span>
                        </label>
                        @error('hover_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Gallery Images --}}
                    <div>
                        <label class="form-label">Gallery Images <span class="text-gray-400 font-normal">(up to 10)</span></label>
                        @if($product->images && $product->images->count())
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                @foreach($product->images as $img)
                                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-neutral-700 aspect-square">
                                        <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-full object-cover" alt="Gallery">
                                        <form action="{{ route('admin.products.gallery.delete', $img->id) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs shadow" title="Remove" onclick="return confirm('Remove this image?')">✕</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="galleryPreviewContainer" class="grid grid-cols-3 gap-2 mb-3"></div>
                        <label class="file-drop block relative">
                            <input type="file" name="gallery_images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewGallery(this)">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" class="mx-auto mb-2 text-gray-400">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15v3a2 2 0 002 2h14a2 2 0 002-2v-3M12 15V3m0 0L8.5 6.5M12 3l3.5 3.5"/>
                            </svg>
                            <span id="galleryFileName" class="text-sm text-gray-500 font-medium">Click to add more images</span>
                        </label>
                        @error('gallery_images')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        @error('gallery_images.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-3 pt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="w-4 h-4 text-brand rounded focus:ring-brand" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status: Active</span>
                        </label>
                        
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" class="w-4 h-4 text-brand rounded focus:ring-brand" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Feature on Homepage</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_purchasable" value="1" class="w-4 h-4 text-brand rounded focus:ring-brand" {{ old('is_purchasable', $product->is_purchasable) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Can Purchasable</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="show_stock_out" value="1" class="w-4 h-4 text-brand rounded focus:ring-brand" {{ old('show_stock_out', $product->show_stock_out) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Show Stock Out</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_refundable" value="1" class="w-4 h-4 text-brand rounded focus:ring-brand" {{ old('is_refundable', $product->is_refundable) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Refundable</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-neutral-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">Cancel</a>
                <button type="submit" class="btn-primary-custom">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId, containerId, fileNameId) {
        if (input.files && input.files[0]) {
            if (fileNameId) document.getElementById(fileNameId).innerText = input.files[0].name;
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(containerId).classList.remove('hidden');
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewGallery(input) {
        const container = document.getElementById('galleryPreviewContainer');
        const label = document.getElementById('galleryFileName');
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            label.innerText = input.files.length + ' new image(s) selected';
            Array.from(input.files).forEach(function(file, idx) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var div = document.createElement('div');
                    div.className = 'relative rounded-lg overflow-hidden border border-gray-200 dark:border-neutral-700 aspect-square';
                    div.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" alt="Gallery ' + (idx+1) + '">';
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            label.innerText = 'Click to add more images';
        }
    }
</script>
@endpush
