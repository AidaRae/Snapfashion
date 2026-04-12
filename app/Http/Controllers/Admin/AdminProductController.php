<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.product.products', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::active()->get();

        return view('admin.product.product_add', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'max_purchase_qty' => 'nullable|integer|min:1',
            'low_stock_qty' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'is_purchasable' => 'boolean',
            'show_stock_out' => 'boolean',
            'is_refundable' => 'boolean',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'gallery_images' => 'nullable|array|max:10',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['featured'] = $request->boolean('featured', false);
        $validated['is_purchasable'] = $request->boolean('is_purchasable', true);
        $validated['show_stock_out'] = $request->boolean('show_stock_out', true);
        $validated['is_refundable'] = $request->boolean('is_refundable', false);
        
        $validated['sizes'] = $request->filled('sizes') ? array_filter(array_map('trim', explode(',', $request->sizes))) : null;
        $validated['colors'] = $request->filled('colors') ? array_filter(array_map('trim', explode(',', $request->colors))) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle hover image upload
        if ($request->hasFile('hover_image')) {
            $validated['hover_image'] = $request->file('hover_image')->store('products', 'public');
        }

        $product = Product::create($validated);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $i => $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path, 'sort_order' => $i]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category', 'orderItems');

        return view('admin.product.product_detail', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('images');

        return view('admin.product.product_edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'max_purchase_qty' => 'nullable|integer|min:1',
            'low_stock_qty' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'is_purchasable' => 'boolean',
            'show_stock_out' => 'boolean',
            'is_refundable' => 'boolean',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'gallery_images' => 'nullable|array|max:10',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['featured'] = $request->boolean('featured', false);
        $validated['is_purchasable'] = $request->boolean('is_purchasable', true);
        $validated['show_stock_out'] = $request->boolean('show_stock_out', true);
        $validated['is_refundable'] = $request->boolean('is_refundable', false);
        
        $validated['sizes'] = $request->filled('sizes') ? array_filter(array_map('trim', explode(',', $request->sizes))) : null;
        $validated['colors'] = $request->filled('colors') ? array_filter(array_map('trim', explode(',', $request->colors))) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle hover image upload
        if ($request->hasFile('hover_image')) {
            if ($product->hover_image) {
                Storage::disk('public')->delete($product->hover_image);
            }
            $validated['hover_image'] = $request->file('hover_image')->store('products', 'public');
        }

        // Handle hover image removal
        if ($request->boolean('remove_hover_image') && $product->hover_image) {
            Storage::disk('public')->delete($product->hover_image);
            $validated['hover_image'] = null;
        }

        $product->update($validated);

        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            $maxSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('gallery_images') as $i => $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path, 'sort_order' => $maxSort + $i + 1]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->hover_image) {
            Storage::disk('public')->delete($product->hover_image);
        }

        // Delete gallery images
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated.');
    }

    /**
     * Toggle product featured status.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['featured' => !$product->featured]);

        return response()->json(['featured' => $product->featured]);
    }

    /**
     * Bulk action on selected products.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->product_ids);

        switch ($request->action) {
            case 'activate':
                $products->update(['is_active' => true]);
                break;
            case 'deactivate':
                $products->update(['is_active' => false]);
                break;
            case 'delete':
                $products->each(function ($product) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    $product->delete();
                });
                break;
        }

        return back()->with('success', 'Bulk action completed.');
    }

    /**
     * Delete a single gallery image.
     */
    public function deleteGalleryImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }
}
