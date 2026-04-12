<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Maximum quantity allowed per cart line item.
     */
    private const MAX_QTY = 100;

    /**
     * Regex that a valid $rowId must match: digits, optionally followed by -slug.
     */
    private const ROW_ID_PATTERN = '/^\d+(-[\w]+)?$/';

    /**
     * Display the cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $coupon = session()->get('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;

        $shippingSettings = ShippingSetting::firstOrCreate([], []);
        $shippingEnabled = (bool) ($shippingSettings->is_enabled ?? true);
        $flatRateEnabled = (bool) ($shippingSettings->is_flat_rate_enabled ?? false);
        $freeShippingEnabled = (bool) ($shippingSettings->is_free_shipping_enabled ?? false);
        $flatRatePrice   = (float) ($shippingSettings->flat_rate_price ?? 0);

        // Pre-calculate cart total precisely aligning with Checkout if shipping rates are statically predictable
        $appliedShipping = 0;
        if ($shippingEnabled && !$freeShippingEnabled && $flatRateEnabled) {
            $appliedShipping = $flatRatePrice;
        }

        $total = max(0, $subtotal - $discount + $appliedShipping);

        return view('shop.cart.index', compact('cart', 'subtotal', 'coupon', 'discount', 'total', 'shippingEnabled', 'flatRateEnabled', 'freeShippingEnabled', 'flatRatePrice', 'appliedShipping'));
    }

    /**
     * Add a product to the cart.
     *
     * – Validates that the product is active and in-stock.
     * – Caps the resulting quantity at min(stock, MAX_QTY).
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:100',
            'size'     => 'nullable|string|max:50',
            'color'    => 'nullable|string|max:50',
        ]);

        // ── Stock / active check ──
        if (!$product->is_active || $product->stock <= 0) {
            $error = 'This product is currently unavailable.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $error,
                ], 422);
            }

            return redirect()->back()->with('error', $error);
        }

        $quantity = $request->get('quantity', 1);
        $size = $request->get('size');
        $color = $request->get('color');
        $cart = session()->get('cart', []);

        $rowId = $product->id;
        if ($size) $rowId .= '-' . $size;
        if ($color) $rowId .= '-' . $color;

        $existingQty = isset($cart[$rowId]) ? $cart[$rowId]['quantity'] : 0;
        $maxAllowed   = min(self::MAX_QTY, $product->stock);
        $newQty       = min($existingQty + $quantity, $maxAllowed);

        // If the item is already at the cap, return an error
        if ($newQty <= $existingQty && $existingQty > 0) {
            $error = "You already have the maximum available quantity ({$maxAllowed}) in your cart.";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $error,
                ], 422);
            }

            return redirect()->back()->with('error', $error);
        }

        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] = $newQty;
        } else {
            $cart[$rowId] = [
                'id'       => $product->id,
                'row_id'   => $rowId,
                'name'     => $product->name,
                'slug'     => $product->slug,
                'price'    => $product->effective_price,
                'image'    => $product->image,
                'quantity' => $newQty,
                'size'     => $size,
                'color'    => $color,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $product->name . ' added to cart!',
                'cart'    => $this->getCartData(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity.
     *
     * – Validates $rowId format.
     * – Re-fetches the product to update the stored price.
     */
    public function update(Request $request, $rowId)
    {
        // ── Validate rowId format ──
        if (!preg_match(self::ROW_ID_PATTERN, $rowId)) {
            abort(400, 'Invalid cart row identifier.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$rowId])) {
            // Re-fetch product to get current price
            $product = Product::find($cart[$rowId]['id']);

            if ($product) {
                $cart[$rowId]['price'] = $product->effective_price;
            }

            $cart[$rowId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        // Recalculate coupon discount if applied
        $this->recalculateCoupon();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated.',
                'cart'    => $this->getCartData(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     *
     * – Validates $rowId format.
     */
    public function remove(Request $request, $rowId)
    {
        // ── Validate rowId format ──
        if (!preg_match(self::ROW_ID_PATTERN, $rowId)) {
            abort(400, 'Invalid cart row identifier.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
            session()->put('cart', $cart);
        }

        // Recalculate coupon discount if applied
        $this->recalculateCoupon();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'cart'    => $this->getCartData(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the entire cart.
     *
     * – Returns JSON for AJAX requests.
     */
    public function clear(Request $request)
    {
        session()->forget(['cart', 'coupon']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared.',
                'cart'    => $this->getCartData(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    /**
     * Apply a coupon code.
     *
     * – Returns JSON for AJAX requests.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            $error = 'Invalid or expired coupon code.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $error,
                ], 422);
            }

            return redirect()->route('cart.index')->with('error', $error);
        }

        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
            $error = 'This coupon does not meet the minimum order amount.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $error,
                ], 422);
            }

            return redirect()->route('cart.index')->with('error', $error);
        }

        session()->put('coupon', [
            'code'     => $coupon->code,
            'type'     => $coupon->type,
            'value'    => $coupon->value,
            'discount' => $discount,
        ]);

        $success = 'Coupon applied!';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $success,
                'cart'    => $this->getCartData(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', $success);
    }

    /**
     * Return cart data as JSON (for AJAX drawer refresh).
     */
    public function getData()
    {
        return response()->json($this->getCartData());
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function calculateSubtotal(array $cart): float
    {
        return collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    private function getCartData(): array
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $coupon = session()->get('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;
        $total = max(0, $subtotal - $discount);
        $count = collect($cart)->sum('quantity');

        $items = collect($cart)->map(function ($item, $key) {
            return [
                'id'       => $item['id'],
                'row_id'   => $key,
                'name'     => $item['name'],
                'slug'     => $item['slug'],
                'price'    => $item['price'],
                'image'    => !empty($item['image']) ? asset('storage/' . $item['image']) : null,
                'quantity' => $item['quantity'],
                'size'     => $item['size'] ?? null,
                'color'    => $item['color'] ?? null,
                'subtotal' => $item['price'] * $item['quantity'],
            ];
        })->values()->all();

        return [
            'items'    => $items,
            'count'    => $count,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total'    => $total,
            'coupon'   => $coupon,
        ];
    }

    /**
     * Recalculate the coupon discount after cart changes.
     *
     * If the recalculated discount is zero or negative, the coupon
     * is removed from the session entirely.
     */
    private function recalculateCoupon(): void
    {
        $couponData = session()->get('coupon');
        if (!$couponData) return;

        $coupon = Coupon::where('code', $couponData['code'])->first();
        if (!$coupon) {
            session()->forget('coupon');
            return;
        }

        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
            session()->forget('coupon');
            return;
        }

        session()->put('coupon.discount', $discount);
    }
}
