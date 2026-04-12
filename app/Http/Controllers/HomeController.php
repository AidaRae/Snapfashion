<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the shop homepage.
     */
    public function index()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->withCount(['products' => fn($q) => $q->active()])
            ->get();

        $latestProducts = Product::active()
            ->with('category')
            ->latest()
            ->take(12)
            ->get();

        return view('Shop.Home.index', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
