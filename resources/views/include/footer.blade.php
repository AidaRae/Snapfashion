<!-- FEATURES STRIP -->
<section class="py-12 px-6 md:px-12 border-t border-bark/10 dark:border-cream/10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8 md:gap-12">
        <!-- Global Shipping -->
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center opacity-60">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path d="M1 3h15v13H1z"/>
                    <path d="M16 8h4l3 4v5h-7V8z"/>
                    <circle cx="5.5" cy="18.5" r="2.5"/>
                    <circle cx="18.5" cy="18.5" r="2.5"/>
                </svg>
            </div>
            <div>
                <div class="font-display text-sm font-bold tracking-[0.15em] uppercase">Global Shipping</div>
                <p class="text-xs opacity-50 mt-0.5">Shipping available for all order</p>
            </div>
        </div>

        <!-- Secure Shopping -->
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center opacity-60">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                </svg>
            </div>
            <div>
                <div class="font-display text-sm font-bold tracking-[0.15em] uppercase">Secure Shopping</div>
                <p class="text-xs opacity-50 mt-0.5">You're in safe hands</p>
            </div>
        </div>

        <!-- Multiple Styles -->
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center opacity-60">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="7"/>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                </svg>
            </div>
            <div>
                <div class="font-display text-sm font-bold tracking-[0.15em] uppercase">Multiple Styles</div>
                <p class="text-xs opacity-50 mt-0.5">We have everything you need</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER BAR -->
<footer class="bg-bark text-cream py-4 px-6 md:px-12">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <p class="text-xs opacity-60">
            &copy; {{ date('Y') }} {{ $settings['site_name'] ?? config('app.name') }}. All rights reserved.
        </p>
        <!-- Back to Top -->
        <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
            class="flex items-center gap-1.5 text-xs opacity-40 hover:opacity-80 transition-opacity group">
            <svg class="w-4 h-4 transform group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>
</footer>
