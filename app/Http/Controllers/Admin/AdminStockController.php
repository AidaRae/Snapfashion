<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminStockController extends Controller
{
    /**
     * Display the stock management dashboard.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status'); // 'out_of_stock', 'low_stock', 'in_stock'
        
        $query = Product::with('category');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($status) {
            if ($status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            } elseif ($status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            } elseif ($status === 'in_stock') {
                $query->where('stock', '>', 5);
            }
        }

        // Order by lowest stock first
        $products = $query->orderBy('stock', 'asc')->paginate(20)->withQueryString();

        // Stats
        $totalProducts = Product::count();
        $outOfStock = Product::where('stock', '<=', 0)->count();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();

        return view('admin.stock.stock', compact('products', 'totalProducts', 'outOfStock', 'lowStock'));
    }

    /**
     * Update stock level inline.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product->update([
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', "Stock for {$product->name} updated successfully.");
    }
}
