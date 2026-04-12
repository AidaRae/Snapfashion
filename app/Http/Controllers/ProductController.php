<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with optional filters.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Filter by category
        if ($request->filled('category')) {
            $categories = (array) $request->category;
            $query->whereHas('category', fn($q) => $q->whereIn('slug', $categories));
        }

        // Filter by size (fallback to description search)
        if ($request->filled('size')) {
            $query->where('description', 'LIKE', '%' . $request->size . '%');
        }

        // Filter by color (fallback to name/description search)
        if ($request->filled('color')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->color . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->color . '%');
            });
        }

        // Filter by price
        if ($request->filled('price')) {
            $priceRange = $request->price;
            if ($priceRange == '0-50000') {
                $query->where(function($q) {
                    $q->whereBetween('price', [0, 50000])
                      ->orWhere(function($sq) {
                          $sq->whereNotNull('sale_price')->whereBetween('sale_price', [0, 50000]);
                      });
                });
            } elseif ($priceRange == '50000-100000') {
                $query->where(function($q) {
                    $q->whereBetween('price', [50000, 100000])
                      ->orWhere(function($sq) {
                          $sq->whereNotNull('sale_price')->whereBetween('sale_price', [50000, 100000]);
                      });
                });
            } elseif ($priceRange == '100000+') {
                $query->where(function($q) {
                    $q->where('price', '>', 100000)
                      ->orWhere(function($sq) {
                          $sq->whereNotNull('sale_price')->where('sale_price', '>', 100000);
                      });
                });
            }
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        // Always push sold-out products to the end, then apply chosen sort
        $query = $query->orderByRaw('CASE WHEN stock <= 0 THEN 1 ELSE 0 END');

        $query = match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('Shop.shop.shop', compact('products', 'categories', 'sort'));
    }

    /**
     * Display a single product.
     */
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('Shop.shop.product_show', compact('product', 'relatedProducts'));
    }

    /**
     * Display products by category.
     */
    public function byCategory(Category $category)
    {
        abort_unless($category->is_active, 404);

        $products = Product::active()
            ->where('category_id', $category->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        $categories = Category::active()->get();

        return view('Shop.shop.shop', compact('products', 'categories'))->with('sort', 'latest')->with('currentCategory', $category);
    }

    /**
     * Search products by name or description.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $products = Product::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::active()->get();

        return view('Shop.shop.shop', compact('products', 'categories', 'query'))->with('sort', 'latest');
    }
}
