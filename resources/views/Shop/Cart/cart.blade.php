<!-- CART DRAWER -->
<div id="cartDrawer"
    class="fixed top-0 right-0 h-full w-80 z-50 shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col"
    style="background:var(--cart-bg);">
    <div class="flex items-center justify-between p-6 border-b border-current border-opacity-10">
        <h3 class="font-display text-xl">Your Cart</h3>
        <button onclick="toggleCart()" class="opacity-60 hover:opacity-100">✕</button>
    </div>
    <div id="cartItems" class="flex-1 overflow-y-auto p-6 space-y-4"></div>
    <div class="p-6 border-t border-current border-opacity-10">
        <div class="flex justify-between mb-4 text-sm"><span>Subtotal</span><span id="cartTotal"
                class="font-display font-semibold text-lg">₦0</span></div>
        <a href="{{ route('cart.index') }}"
            class="btn-primary w-full py-3.5 rounded-full text-sm font-medium font-body text-center block mb-2">View Cart</a>
        <a href="{{ route('checkout.index') }}"
            class="w-full py-3 rounded-full text-sm font-medium font-body text-center block border border-bark/20 dark:border-cream/20 hover:bg-bark/5 dark:hover:bg-cream/5 transition-colors">Checkout →</a>
    </div>
</div>
<div id="overlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="toggleCart()"></div>

<!-- TOAST -->
<div id="toast"
    class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-full text-sm font-medium font-body shadow-xl flex items-center gap-2"
    style="background:#2C2218;color:#F7F3EE;">
    <span id="toastMsg">Added to cart</span>
</div>
