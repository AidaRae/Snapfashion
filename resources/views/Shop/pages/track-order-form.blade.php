@extends('layouts.shop')

@section('title', 'Track Your Order - ')

@section('content')
    <div class="max-w-xl mx-auto px-6 md:px-12 pt-28 pb-12 md:pt-40 md:pb-24 min-h-[60vh] flex flex-col justify-center">

        <div class="mb-10 text-center">
            <h1 class="font-display text-4xl mb-4 font-bold uppercase tracking-wider text-bark dark:text-cream">Track Your Order</h1>
            <p class="text-[15px] text-gray-500 font-medium leading-relaxed max-w-sm mx-auto">
                Enter your tracking code below to check the real-time status of your order.
            </p>
        </div>

        <div class="bg-white dark:bg-neutral-900 p-8 md:p-10 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 relative z-10 transition-colors">
            
            @if(session('error'))
                <div class="bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 p-4 rounded-xl mb-6 text-sm font-medium border border-red-100 dark:border-red-900/30 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('shop.track.form') }}" method="GET" class="space-y-6">
                <div>
                    <label for="code" class="block text-xs font-bold uppercase tracking-[0.15em] text-gray-500 mb-2">Tracking Code</label>
                    <div class="relative">
                        <input type="text" name="code" id="code" required
                            class="w-full bg-gray-50 dark:bg-neutral-800 border-2 border-transparent focus:border-bark dark:focus:border-cream focus:bg-white dark:focus:bg-black rounded-xl px-4 py-3.5 text-gray-900 dark:text-white transition-all font-mono tracking-wider placeholder-gray-400"
                            placeholder="e.g. SF-12B34C56"
                            value="{{ request('code') }}" />
                        <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-bark dark:bg-cream text-cream dark:text-bark rounded-xl py-4 font-display text-sm font-bold tracking-[0.2em] uppercase hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    Find Order
                </button>
            </form>
            
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-neutral-800 text-center">
                <p class="text-xs text-gray-400 font-medium">Having trouble? <a href="{{ route('shop.home') }}" class="text-bark dark:text-cream underline underline-offset-4 hover:opacity-80 transition-opacity">Contact Support</a></p>
            </div>
        </div>

        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden opacity-30 dark:opacity-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-clay/20 blur-[100px] rounded-full"></div>
            <div class="absolute top-40 -left-20 w-80 h-80 bg-rust/10 blur-[80px] rounded-full"></div>
        </div>
    </div>
@endsection
