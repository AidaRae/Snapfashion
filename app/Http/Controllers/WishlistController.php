<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Get the identifier for the current user (auth or session-based).
     * Session IDs are hashed for security.
     */
    private function getIdentifier(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id(), 'session_id' => null];
        }

        // Ensure session is started and persisted so the ID doesn't rotate
        if (!Session::has('wishlist_session_active')) {
            Session::put('wishlist_session_active', true);
        }

        return [
            'user_id'    => null,
            'session_id' => hash('sha256', Session::getId()),
        ];
    }

    /**
     * Display the wishlist page.
     * Only shows active products; filters out inactive/deleted ones.
     */
    public function index()
    {
        $identifier = $this->getIdentifier();

        $query = Wishlist::with(['product' => function ($q) {
            $q->where('is_active', true);
        }]);

        if ($identifier['user_id']) {
            $query->where('user_id', $identifier['user_id']);
        } else {
            $query->where('session_id', $identifier['session_id']);
        }

        $wishlists = $query->latest()->get();

        return view('Shop.wishlist.wishlist', compact('wishlists'));
    }

    /**
     * Toggle a product in/out of the wishlist.
     *
     * – Validates product is active.
     * – Uses firstOrCreate to prevent duplicates under race conditions.
     */
    public function toggle(Product $product)
    {
        // Only allow wishlisting active products
        if (!$product->is_active) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This product is no longer available.',
            ], 404);
        }

        $identifier = $this->getIdentifier();

        $query = Wishlist::where('product_id', $product->id);

        if ($identifier['user_id']) {
            $query->where('user_id', $identifier['user_id']);
        } else {
            $query->where('session_id', $identifier['session_id']);
        }

        $wishlist = $query->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'status'  => 'removed',
                'message' => 'Removed from wishlist',
                'count'   => $this->getWishlistCount(),
            ]);
        }

        // Use firstOrCreate to guard against race conditions (double-clicks)
        Wishlist::firstOrCreate(
            array_merge($identifier, ['product_id' => $product->id])
        );

        return response()->json([
            'status'  => 'added',
            'message' => 'Added to wishlist ♥',
            'count'   => $this->getWishlistCount(),
        ]);
    }

    /**
     * Get current wishlist count for the user/session.
     */
    private function getWishlistCount(): int
    {
        $identifier = $this->getIdentifier();

        $query = Wishlist::query();

        if ($identifier['user_id']) {
            $query->where('user_id', $identifier['user_id']);
        } else {
            $query->where('session_id', $identifier['session_id']);
        }

        return $query->count();
    }
}